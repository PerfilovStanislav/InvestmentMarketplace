<?php
/**
 * Created by PhpStorm.
 * User: Beautynight
 * Date: 08.07.2016
 * Time: 22:49
 */

namespace Helpers\Locales {

    class En {
        public final static function getLocale() {
            return [
                'login_is_busy'     => 'This login is already registered. Please enter another',
                'email_is_busy'     => 'This email is already registered. Please enter another',
                'no_user'           => 'User is not found',
                'bad_password'      => 'Wrong password',
                'check'             => 'check',
                'add_project'       => 'Project adding',
                'project_name'      => 'Project name',
                'project_url'       => 'Project\'s url or referral link',
                'start_date'        => 'Start date of project',
                'description'       => 'Description',
                'payment_type'      => ['Withdrawal', 'Manual', 'Instant', 'Automatic'],
                'plans'             => 'Investment plans',
                'profit'            => 'Profit',
                'after'             => 'after',
                'period_name'       => ['','minutes','hours','days','weeks','months','years'],
                'period'            => 'Period',
                'deposit'           => 'Deposit',
                'currency'          => ['dollar', 'euro', 'bitcoin', 'ruble', 'pound', 'yen', 'won', 'rupee'],
                'from'              => 'from',
                'remove'            => 'Remove',
                'add_plan'          => 'Add plan',
                'ref_program'       => 'Referral program',
                'options'           => 'Options',
                'level'             => 'level',
                'add_level'         => 'Add level',
                'payment_system'    => 'Payment systems',
                'languages'         => 'Site languages',
                'show_all_langs'    => 'Show all languages',
                'screenshot'        => 'Site\'s screenshot',
                'preview'           => 'Preview',
                'select_file'       => 'Select a file',
                'view'              => 'View',
                'close'             => 'Close',
                'download'          => 'Download',
                'send_form'         => 'Send form',
                'remember'          => 'Remember',
                'yes'               => 'Yes',
                'no'                => 'No',
                'or'                => 'or',
                'enter'             => 'Enter',
                'registration'      => 'Registration',
                'user_registration' => 'User\'s registration',
                'user_registered'   => 'User is registered',
                'login'             => 'Login',
                'name'              => 'Name',
                'email'             => 'Email',
                'password'          => 'Password',
                'repeat_password'   => 'Repeat password',
                'auth_4_add_project'=> 'Only authorized users may add projects',
                'write_message'     => 'Write a message...',
                'chat'              => 'Chat'
            ];
        }

        public final static function getPeriodName($i, $k) {
            return ['minute','hour','day','week','month','year'][$i-1].($k>1?'s':'');
        }
    }
}