<?php
declare(strict_types = 1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    
    /**
     * Constructor function
     * 
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    /**
     * Generate test data for the users
     * 
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setLastName('Clijsters');
        $user1->setFirstName('Cindy');
        $user1->setEmail('cindy.clijsters@gmail.com');
        $user1->setRole(User::ROLE_SUPERADMIN);
        $user1->setPassword($this->passwordEncoder->encodePassword($user1, 'testTEST123@'));
        $user1->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user1);
        
        $user2 = new User();
        $user2->setLastName('Smeets');
        $user2->setFirstName('Anna');
        $user2->setEmail('anna.smeets@testmail.com');
        $user2->setRole(User::ROLE_ADMIN);
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, 'testTEST123@'));
        $user2->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user2);    
        
        $user3 = new User();
        $user3->setLastName('Hendriks');
        $user3->setFirstName('Jan');
        $user3->setEmail('jan.hendriks@testmail.com');
        $user3->setRole(User::ROLE_ADMIN);
        $user3->setPassword($this->passwordEncoder->encodePassword($user3, 'testTEST123@'));
        $user3->setStatus(User::STATUS_UNCONFIRMED);
        $manager->persist($user3);  

        $user4 = new User();
        $user4->setLastName('Beckers');
        $user4->setFirstName('Fons');
        $user4->setEmail('fons.beckers@testmail.com');
        $user4->setRole(User::ROLE_SUPERADMIN);
        $user4->setPassword($this->passwordEncoder->encodePassword($user4, 'testTEST123@'));
        $user4->setStatus(User::STATUS_INACTIVE);
        $manager->persist($user4);  
        
        $user5 = new User();
        $user5->setLastName('Hermans');
        $user5->setFirstName('Ria');
        $user5->setEmail('ria.hermans@testmail.com');
        $user5->setRole(User::ROLE_ADMIN);
        $user5->setPassword($this->passwordEncoder->encodePassword($user5, 'testTEST123@'));
        $user5->setStatus(User::STATUS_DELETED);
        $manager->persist($user5); 

        $user6 = new User();
        $user6->setLastName('Peeters');
        $user6->setFirstName('Emma');
        $user6->setEmail('emma.peeters@testmail.com');
        $user6->setRole(User::ROLE_USER);
        $user6->setPassword($this->passwordEncoder->encodePassword($user6, 'testTEST123@'));
        $user6->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user6);  
        
        $user7 = new User();
        $user7->setLastName('Janssens');
        $user7->setFirstName('Liam');
        $user7->setEmail('liam.janssen@testmail.com');
        $user7->setRole(User::ROLE_USER);
        $user7->setPassword($this->passwordEncoder->encodePassword($user7, 'testTEST123@'));
        $user7->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user7);  

        $user8 = new User();
        $user8->setLastName('Maes');
        $user8->setFirstName('Olivia');
        $user8->setEmail('olivia.maes@testmail.com');
        $user8->setRole(User::ROLE_USER);
        $user8->setPassword($this->passwordEncoder->encodePassword($user8, 'testTEST123@'));
        $user8->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user8);

        $user9 = new User();
        $user9->setLastName('Jacobs');
        $user9->setFirstName('Adam');
        $user9->setEmail('adam.jacobs@testmail.com');
        $user9->setRole(User::ROLE_USER);
        $user9->setPassword($this->passwordEncoder->encodePassword($user9, 'testTEST123@'));
        $user9->setStatus(User::STATUS_INACTIVE);
        $manager->persist($user9);

        $user10 = new User();
        $user10->setLastName('Mertens');
        $user10->setFirstName('Louise');
        $user10->setEmail('louise.mertens@testmail.com');
        $user10->setRole(User::ROLE_USER);
        $user10->setPassword($this->passwordEncoder->encodePassword($user10, 'testTEST123@'));
        $user10->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user10);

        $user11 = new User();
        $user11->setLastName('Willems');
        $user11->setFirstName('Arthur');
        $user11->setEmail('arthur.willems@testmail.com');
        $user11->setRole(User::ROLE_USER);
        $user11->setPassword($this->passwordEncoder->encodePassword($user11, 'testTEST123@'));
        $user11->setStatus(User::STATUS_UNCONFIRMED);
        $manager->persist($user11);

        $user12 = new User();
        $user12->setLastName('Dubois');
        $user12->setFirstName('Mila');
        $user12->setEmail('mila.dubois@testmail.com');
        $user12->setRole(User::ROLE_USER);
        $user12->setPassword($this->passwordEncoder->encodePassword($user12, 'testTEST123@'));
        $user12->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user12);

        $user13 = new User();
        $user13->setLastName('Lambert');
        $user13->setFirstName('Noah');
        $user13->setEmail('noah.lambert@testmail.com');
        $user13->setRole(User::ROLE_USER);
        $user13->setPassword($this->passwordEncoder->encodePassword($user13, 'testTEST123@'));
        $user13->setStatus(User::STATUS_BLOCKED);
        $manager->persist($user13);

        $user14 = new User();
        $user14->setLastName('Diallo');
        $user14->setFirstName('Alice');
        $user14->setEmail('alice.diallo@testmail.com');
        $user14->setRole(User::ROLE_USER);
        $user14->setPassword($this->passwordEncoder->encodePassword($user14, 'testTEST123@'));
        $user14->setStatus(User::STATUS_DELETED);
        $manager->persist($user14);

        $user15 = new User();
        $user15->setLastName('Dupont');
        $user15->setFirstName('Lucas');
        $user15->setEmail('lucas.dupont@testmail.com');
        $user15->setRole(User::ROLE_USER);
        $user15->setPassword($this->passwordEncoder->encodePassword($user15, 'testTEST123@'));
        $user15->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user15);

        $user16 = new User();
        $user16->setLastName('Claes');
        $user16->setFirstName('Lina');
        $user16->setEmail('lina.claes@testmail.com');
        $user16->setRole(User::ROLE_USER);
        $user16->setPassword($this->passwordEncoder->encodePassword($user16, 'testTEST123@'));
        $user16->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user16);

        $user17 = new User();
        $user17->setLastName('Wouters');
        $user17->setFirstName('Youssef');
        $user17->setEmail('youssef.wouters@testmail.com');
        $user17->setRole(User::ROLE_USER);
        $user17->setPassword($this->passwordEncoder->encodePassword($user17, 'testTEST123@'));
        $user17->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user17);

        $user18 = new User();
        $user18->setLastName('Goossens');
        $user18->setFirstName('Gabriel');
        $user18->setEmail('gabriel.goossens@testmail.com');
        $user18->setRole(User::ROLE_USER);
        $user18->setPassword($this->passwordEncoder->encodePassword($user18, 'testTEST123@'));
        $user18->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user18);

        $user19 = new User();
        $user19->setLastName('De Smet');
        $user19->setFirstName('David');
        $user19->setEmail('david.de.smet@testmail.com');
        $user19->setRole(User::ROLE_USER);
        $user19->setPassword($this->passwordEncoder->encodePassword($user19, 'testTEST123@'));
        $user19->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user19);

        $user20 = new User();
        $user20->setLastName('Bah');
        $user20->setFirstName('Sarah');
        $user20->setEmail('sarah-bah@testmail.com');
        $user20->setRole(User::ROLE_USER);
        $user20->setPassword($this->passwordEncoder->encodePassword($user20, 'testTEST123@'));
        $user20->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user20);

        $user21 = new User();
        $user21->setLastName('Nguyen');
        $user21->setFirstName('Finn');
        $user21->setEmail('finn.nguyen@testmail.com');
        $user21->setRole(User::ROLE_USER);
        $user21->setPassword($this->passwordEncoder->encodePassword($user21, 'testTEST123@'));
        $user21->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user21);

        $user22 = new User();
        $user22->setLastName('Lejeune');
        $user22->setFirstName('Yasmine');
        $user22->setEmail('yasmine.lejeune@testmail.com');
        $user22->setRole(User::ROLE_USER);
        $user22->setPassword($this->passwordEncoder->encodePassword($user22, 'testTEST123@'));
        $user22->setStatus(User::STATUS_INACTIVE);
        $manager->persist($user22);

        $user23 = new User();
        $user23->setLastName('Renard');
        $user23->setFirstName('Mathis');
        $user23->setEmail('mathis.renard@testmail.com');
        $user23->setRole(User::ROLE_USER);
        $user23->setPassword($this->passwordEncoder->encodePassword($user23, 'testTEST123@'));
        $user23->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user23);

        $user24 = new User();
        $user24->setLastName('Dumont');
        $user24->setFirstName('Mia');
        $user24->setEmail('mia.dumont@testmail.com');
        $user24->setRole(User::ROLE_USER);
        $user24->setPassword($this->passwordEncoder->encodePassword($user24, 'testTEST123@'));
        $user24->setStatus(User::STATUS_ACTIVE);
        $manager->persist($user24);

        $user25 = new User();
        $user25->setLastName('LeClerq');
        $user25->setFirstName('Jules');
        $user25->setEmail('jules.leclerq@testmail.com');
        $user25->setRole(User::ROLE_USER);
        $user25->setPassword($this->passwordEncoder->encodePassword($user25, 'testTEST123@'));
        $user25->setStatus(User::STATUS_BLOCKED);
        $manager->persist($user25);       
        
        $manager->flush();
    }
}
