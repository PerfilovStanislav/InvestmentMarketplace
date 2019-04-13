<?php

namespace Helpers\Locales {

	use Interfaces\LocaleInterface;

	class En implements LocaleInterface {
        final public static function getLocale():array {
            return [
                'active'			=> 'Active',
				'add'				=> 'Add',
				'add_level'         => 'Add level',
				'add_plan'          => 'Add plan',
				'add_project'       => 'Project adding',
				'after'             => 'after',
				'auth_4_add_project'=> 'Only authorized users may add projects',
				'bad_password'      => 'Wrong password',
				'chat'              => 'Chat',
				'check'             => 'check',
				'close'             => 'Close',
				'currency'          => ['dollar', 'euro', 'bitcoin', 'ruble', 'pound', 'yen', 'won', 'rupee'],
				'deposit'           => 'Deposit',
				'description'       => 'Description',
				'download'          => 'Download',
				'email'             => 'Email',
				'email_is_busy'     => 'This email is already registered. Please enter another',
				'enter'             => 'Enter',
                'exit'              => 'Exit',
                'free'				=> 'free',
				'free_4_add_project'=> 'Adding a project to the database is completely',
				'from'              => 'from',
				'general'           => 'General',
				'guest'             => 'Guest',
				'languages'         => 'Site languages',
				'level'             => 'level',
				'login'             => 'Login',
				'login_is_busy'     => 'This login is already registered. Please enter another',
				'menu'              => 'Menu',
				'name'              => 'Name',
				'no'                => 'No',
				'no_user'           => 'User is not found',
                'no_project'        => 'Project not found',
                'not_published'     => 'Not published',
				'options'           => 'Options',
				'or'                => 'or',
				'password'          => 'Password',
				'payment_system'    => 'Payment systems',
				'payment_type'      => ['Withdrawal', 'Manual', 'Instant', 'Automatic'],
				'period'            => 'Period',
				'period_name'       => ['','minutes','hours','days','weeks','months','years'],
				'plans'             => 'Investment plans',
				'preview'           => 'Preview',
				'profit'            => 'Profit',
				'project_name'      => 'Project name',
				'project_is_added'  => 'Project is added',
				'project_url'       => 'Project\'s url or referral link',
				'ref_program'       => 'Referral program',
				'registration'      => 'Registration',
				'remember'          => 'Remember',
				'remove'            => 'Remove',
				'repeat_password'   => 'Repeat password',
				'screenshot'        => 'Site\'s screenshot',
				'select_file'       => 'Select a file',
				'send_form'         => 'Send form',
				'show_all_langs'    => 'Show all languages',
				'site_exists'       => 'Site already exists',
				'site_is_free'      => 'Site is free',
				'site_title'        => 'Real Investment Market',
				'start_date'        => 'Start date of project',
				'user_registered'   => 'User is registered',
				'user_registration' => 'User\'s registration',
				'view'              => 'View',
                'write_message'     => 'Write a message...',
				'wrong_url'   		=> 'Wrong site address',
				'yes'               => 'Yes',
            ];
        }

        final public static function getPeriodName(int $i, int $k):string {
            return ['minute','hour','day','week','month','year'][$i-1].($k>1?'s':'');
        }
    }
}
