<?php

namespace App\Helpers\Locales;

abstract class AbstractLanguage implements LocaleInterface {

    public string
        $aboutUs           = 'About us',
        $active            = 'Active',
        $addLevel          = 'Add level',
        $addPlan           = 'Add plan',
        $addProject        = 'Project adding',
        $advertising       = 'Advertising',
        $after             = 'after',
        $availableValues   = 'Available values',
        $badPassword       = 'Wrong password',
        $chat              = 'Chat',
        $check             = 'check',
        $contact           = 'Contact',
        $dateStart         = 'Start date',
        $deleted           = 'Deleted',
        $deposit           = 'Deposit',
        $description       = 'Description',
        $enter             = 'Enter',
        $error             = 'Error',
        $exit              = 'Exit',
        $expectedNumber    = 'Expected a number',
        $fileNotFound      = 'File %s is not found',
        $fixedLength       = 'Fixed length:',
        $free              = 'free',
        $freeForAddProject = 'Adding a project to the database is completely',
        $from              = 'from',
        $new               = 'New',
        $forLastMonth      = 'For last month',
        $forAllTime        = 'For all time',
        $guest             = 'Guest',
        $headKeywords      = 'hyip monitoring 2021, profitable projects, capital, investments',
        $headDescription   = 'High Yield Investment Projects 2021',
        $headTitle         = 'Real Investment Market',
        $invalidDateFormat = 'Invalid date format',
        $languages         = 'Site languages',
        $level             = 'level',
        $login             = 'Login',
        $loginIsBusy       = 'This login is already registered. Please enter another',
        $maxLength         = 'Maximum number of characters:',
        $maxValue          = 'Maximum value:',
        $message           = 'Message',
        $messageIsSent     = 'Message is sent',
        $minDeposit        = 'Minimum deposit',
        $minLength         = 'Minimum number of characters:',
        $minValue          = 'Minimum value:',
        $menu              = 'Menu',
        $name              = 'Name',
        $needAuthorization = 'You need to log in',
        $no                = 'No',
        $noAccess          = 'No access',
        $noLanguage        = 'Language is not found',
        $noUser            = 'User is not found',
        $noPage            = 'Page is not found',
        $noProject         = 'Project is not found',
        $notPublished      = 'Not published',
        $options           = 'Options',
        $password          = 'Password',
        $paymentSystem     = 'Payment systems',
        $paywait           = 'Paywait',
        $period            = 'Period',
        $placeBanner       = 'Place a banner|for $%d per week',
        $plans             = 'Investment plans',
        $profit            = 'Profit',
        $projectIsAdded    = 'Project is added',
        $projectName       = 'Project name',
        $projects          = 'Projects',
        $projectUrl        = 'Project\'s url or referral link',
        $prohibitedChars   = 'Prohibited characters are entered',
        $rating            = 'Rating',
        $refProgram        = 'Referral program',
        $registration      = 'Registration',
        $remember          = 'Remember',
        $remove            = 'Remove',
        $repeatPassword    = 'Repeat password',
        $required          = 'Required',
        $scam              = 'Scam',
        $sendForm          = 'Send form',
        $showAllLangs      = 'Show all languages',
        $siteExists        = 'Site already exists',
        $siteIsFree        = 'Site is free',
        $startDate         = 'Start date of project',
        $success           = 'Success',
        $userRegistered    = 'User is registered',
        $userRegistration  = 'User\'s registration',
        $writeMessage      = 'Write a message',
        $wrongUrl          = 'Wrong site\'s address',
        $wrongValue        = 'Wrong value',
        $yes               = 'Yes',
        $youAreAuthorized  = 'You are authorized',
        $bannerPosition    = 'Banner position',
        $blockOnTop        = 'Block on top',
        $blockOnTheLeft    = 'Block on the left',
        $numberOfDays      = 'Number of days',
        $discount          = 'Discount',
        $total             = 'Total'
    ;

    public array
        $paymentType       = ['Withdrawal', 'Manual', 'Instant', 'Automatic'],
        $periodName        = ['', 'minutes', 'hours', 'days', 'weeks', 'months', 'years'],
        $currency          = ['dollar', 'euro', 'bitcoin', 'ruble', 'pound', 'yen', 'won', 'rupee'],
        $about             = [
            'Welcome to ', '',
            'On the site we collect the most up-to-date information about HYIPs. These are the rating, reviews and the start date of the campaign. For a more convenient calculation of profits, we bring tariff plans to the human form. In one place you will find everything you need to choose a project in which you are going to invest, or share your opinion in the chat.',
            'For administrators, we offer free project placement on our site. Order places for banners in the ', 'advertising', ' section'
        ];

    abstract public function getPeriodName(int $i, int $k): string;
}
