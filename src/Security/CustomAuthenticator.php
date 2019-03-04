<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class CustomAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return 'rtAdminLogin' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $formData = $request->request->get('login');

        $credentials = [
            'email'      => (array_key_exists('email', $formData) ? $formData['email'] : null),
            'password'   => (array_key_exists('plainPassword', $formData) ? $formData['plainPassword'] : null),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $credentials['email']
        ]);

        if (!$user or $user->getStatus() === User::STATUS_DELETED) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('You\'re email address couldn\'t been found.');
        }
        
        if (
            !in_array(User::ROLE_ADMIN, $user->getRoles())
            && !in_array(User::ROLE_SUPERADMIN, $user->getRoles())
        ) {
            throw new CustomUserMessageAuthenticationException('You don\'t have access to the administrator module.');
        }
        
        if ($user->getStatus() === User::STATUS_UNCONFIRMED) {
            throw new CustomUserMessageAuthenticationException('You have to confirm your registration before you can log in.');
        }
        
        if ($user->getStatus() === User::STATUS_INACTIVE) {
            throw new CustomUserMessageAuthenticationException('Your account is inactive.  Contact the administrator');
        }
        
        if ($user->getStatus() === User::STATUS_BLOCKED) {
            throw new CustomUserMessageAuthenticationException('Your account is blocked.');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        // For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));
        return new RedirectResponse($this->urlGenerator->generate('rtAdminDashboard'));
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate('rtAdminLogin');
    }
}
