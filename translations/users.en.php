<?php
return [
    
    'field.lastName' => 'Last name',
    'field.firstName' => 'First name',
    'field.email' => 'E-mail address',
    'field.username' => 'Username',
    'field.usernameOrEmail' => 'E-mail address or username',
    'field.password' => 'Password',
    'field.oldPassword' => 'Old password',
    'field.confirmPassword' => 'Confirm password',
    'field.role' => 'Role',
    'field.status' => 'Status',
    
    'status.makeChoice' => '- Choose a status -',
    'status.active' => 'Active',
    'status.inactive' => 'Inactive',
    'status.blocked' => 'Blocked',
    'status.deleted' => 'Deleted',
    'status.unconfirmed' => 'Unconfirmed',
    
    'role.makeChoice' => '- Choose a role -',
    'role.ROLE_USER' => 'User',
    'role.ROLE_ADMIN' => 'Administrator',
    'role.ROLE_SUPERADMIN' => 'Superadministrator',    
    
    'action.view' => 'View a user',
    'action.add' => 'Add a user',
    'action.update' => 'Update a user',
    'action.delete' => 'Delete a user',
    'action.updateMyProfile' => 'Change my profile information',
    'action.updatePassword' => 'Change my password',
    'action.forgotYourPassword' => 'Forgot your password?',
    'action.confirmRegistration' => 'Confirm your registration',    
    
    'list.noFound' => 'No users were found.',
    'list.showEntries' => 'Showing %start% to %end% of %total% users',
    
    'msg.addedSuccessfully' => 'The user "%username%" has been successfully added.',
    'msg.changedSuccessfully' => 'The user "%username%" has been successfully changed.',
    'msg.deletedSuccessfully' => 'The user "%fullName% (%username%)" has been successfully deleted.',
    'msg.ownProfileUpdatedSuccessfully' => 'Your profile data has been successfully changed.',
    'msg.updatePasswordSucessfully' => 'Your password has been successfully changed.',
    
    'error.noUserWithSlug' => 'No user with the slug \'%slug%\' was found.',
    
    'setPassword.accountCreated' => 'An account has been created for you on www.lisztomania.be.',
    'setPassword.clickToSetPassword' => 'Click on the link below to set your password.',    
    
    'forgotPassword.fillInUsernameOrEmail' => 'Enter your e-mail address or username and we will send you a link to reset your password.',
    'forgotPassword.youForgotPassword' => 'We were told that you forgot your password on Lisztomania.',
    'forgotPassword.clickToSetPassword' => 'To reset your password, please click this link.',
    'forgotPassword.ignoreEmail' => 'P.S. If you didn\'t request this email, you may safely ignore it.',
    'forgotPassword.sendResetPasswordLink' => 'An e-mail has been sent to your email address with instructions to reset your password.',
    'forgotPassword.resetPassword' => 'Enter your new password below.',
    'forgotPassword.passwordIsReset' => 'Your password has been successfully changed.',
    'forgotPassword.clickToLogin' => 'Click on the button below to login.',
    
    'accountUnconfirmed.accountUnconfirmed' => 'Your account has not been confirmed.',
    'accountUnconfirmed.clickLinkInEmail' => 'Please click the link in the confirmation email we sent.',
    'accountUnconfirmed.resendConfirmationMail' => 'Click here to resent it',
    
    'accountAlreadyConfirmed.accountConfirmed' => 'Your account has already been confirmed.',
    'accountAlreadyConfirmed.clickToLogin' => 'Click on the button below to login.',    
    
    'accountConfirmed.accountConfirmed' => 'Your account has already been confirmed.',
    'accountConfirmed.clickToLogin' => 'Click on the button below to login.',       
    
    'confirmRegistration.enterPassword' => 'Enter a password to confirm your registration.',
    
    'deleteUser.confirmWithPassword' => 'Enter your password to delete this account from "%fullName% (%username%)".',
    'deleteUser.account' => 'If the account has been deleted, you cannot restore it!',
    'deleteUser.onlySuperadminError' => '"%fullName% (%username%)" is currently the only active administrator and therefore cannot be deleted. Add an active administrator and try again.',
    
];