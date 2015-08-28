<?php

    return array(

        // Menu items
        'email.change'                      => 'change email address',
        'password.change'                   => 'change password',
        'password.reset'                    => 'reset password',
        'login'                             => 'login',
        'logout'                            => 'logout',
        'register'                          => 'register',
        'profile'                           => 'profile',


        // Members
        'email.old'                         => 'current email address',
        'email.new'                         => 'new email address',
        'email.confirm'                     => 'confirm email address',

        'password.old'                      => 'current password',
        'password.new'                      => 'new password',
        'password.confirm'                  => 'confirm password',

        'remember'                          => 'remember me',
        'terms'                             => 'I accept the terms and conditions',


        // Flash messages
        'register.success'                  => 'Your registration has been completed successfully.',

        'confirmation.codeNotFound'         => 'This confirmation code cannot be found in the database.',
        'confirmation.success'              => 'Your confirmation has been completed successfully.',

        'login.required'                    => 'You need to be logged in to access this page',
        'login.emailNotFound'               => 'This email address cannot be found in the database.',
        'login.dataIncorrect'               => 'The credentials you have provided, are not correct.',
        'login.success'                     => 'You are now logged in.',
        'login.alreadyLoggedIn'             => 'You are already logged in.',

        'changeEmail.success'               => 'Your email address has been changed successfully.',

        'changePassword.success'            => 'Your password has been changed successfully.',

        'resetPassword.title'               => 'Reset password',
        'resetPassword.success'             => 'Your email address has been reset successfully. We have sent you an email with your new password.',

        'logout.success'                    => 'You are now logged out.',

        'errors'                            => array(

            'code'                              => array(
                'invalid'                           => 'The code you have provided is invalid',
                'redeemed'                          => 'The code you have provided has already been redeemed',
                'inactive'                          => 'The code you have provided is no longer active',
            ),

        ),

    );