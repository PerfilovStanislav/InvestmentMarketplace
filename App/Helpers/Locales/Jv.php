<?php

namespace App\Helpers\Locales;

class Jv extends AbstractLanguage {

    // Javanese
    public string
        $aboutUs           = 'Babagan kita',
        $active            = 'Aktif',
        $addLevel          = 'Tambah level',
        $addPlan           = 'Tambah rencana',
        $addProject        = 'Nambahake proyek',
        $advertising       = 'Pariwara',
        $after             = 'sawise',
        $availableValues   = 'Nilai sing kasedhiya',
        $badPassword       = 'Tembung sandhi sing salah',
        $chat              = 'Ngobrol',
        $check             = 'mriksa',
        $contact           = 'Kontak',
        $dateStart         = 'Tanggal wiwitan',
        $deleted           = 'Mbusak',
        $deposit           = 'Simpenan',
        $description       = 'Katrangan',
        $enter             = 'Ketik',
        $error             = 'Kesalahan',
        $exit              = 'Metu',
        $expectedNumber    = 'Diarepake nomer',
        $fileNotFound      = 'File %s ora ditemokake',
        $fixedLength       = 'Dawane tetep:',
        $free              = 'gratis',
        $freeForAddProject = 'Nambahake proyek menyang basis data rampung',
        $from              = 'saka',
        $new               = 'Anyar',
        $forLastMonth      = 'Kanggo wulan pungkasan',
        $forAllTime        = 'Sajrone wektu iki',
        $guest             = 'Tamu',
        $headKeywords      = 'ngawasi hyip 2021, proyek sing nguntungake, modal, investasi',
        $headDescription   = 'Proyek Investasi Hasil Tinggi 2021',
        $headTitle         = 'Pasar Investasi Nyata',
        $invalidDateFormat = 'Format tanggal ora valid',
        $languages         = 'Basa situs',
        $level             = 'tingkat',
        $login             = 'Login',
        $loginIsBusy       = 'Login iki wis didaftar. Tulung ketik liyane',
        $maxLength         = 'Nomer karakter maksimum:',
        $maxValue          = 'Nilai maksimal:',
        $message           = 'Pesen',
        $messageIsSent     = 'Pesen dikirim',
        $minDeposit        = 'Simpenan minimal',
        $minLength         = 'Nomer minimal karakter:',
        $minValue          = 'Nilai minimal:',
        $menu              = 'Menu',
        $name              = 'Jeneng',
        $needAuthorization = 'Sampeyan kudu mlebu',
        $no                = 'Ora',
        $noAccess          = 'Ora ono akses',
        $noLanguage        = 'Basa ora ditemokake',
        $noUser            = 'Pangguna ora ditemokake',
        $noPage            = 'Kaca ora ditemokake',
        $noProject         = 'Proyek ora ditemokake',
        $notPublished      = 'Ora diterbitake',
        $options           = 'Pilihan',
        $password          = 'Sandhi',
        $paymentSystem     = 'Sistem pambayaran',
        $paywait           = 'Paywait',
        $period            = 'Periode',
        $placeBanner       = 'Selehake spanduk kanthi|rega $%d saben minggu',
        $plans             = 'Rencana investasi',
        $profit            = 'Bathi',
        $projectIsAdded    = 'Proyek ditambahake',
        $projectName       = 'Jeneng proyek',
        $projects          = 'Proyek',
        $projectUrl        = 'Link url utawa referensi proyek',
        $prohibitedChars   = 'Karakter terlarang dilebokake',
        $rating            = 'Rating',
        $refProgram        = 'Program referensi',
        $registration      = 'Registrasi',
        $remember          = 'Kelingan',
        $remove            = 'Nyopot',
        $repeatPassword    = 'Baleni sandhi',
        $required          = 'Dibutuhake',
        $scam              = 'Apus-apus',
        $sendForm          = 'Kirim formulir',
        $showAllLangs      = 'Tampilake kabeh basa',
        $siteExists        = 'Situs wis ana',
        $siteIsFree        = 'Situs iki gratis',
        $startDate         = 'Tanggal wiwitan proyek',
        $success           = 'Sukses',
        $userRegistered    = 'Pangguna pangguna',
        $userRegistration  = 'Registrasi pangguna',
        $writeMessage      = 'Tulis pesen',
        $wrongUrl          = 'Alamat situs sing salah',
        $wrongValue        = 'Nilai salah',
        $yes               = 'Nggih',
        $youAreAuthorized  = 'Sampeyan wis sah',
        $bannerPosition    = 'Posisi spanduk',
        $blockOnTop        = 'Blokir ing ndhuwur',
        $blockOnTheLeft    = 'Blokir ing sisih kiwa',
        $numberOfDays      = 'Nomer dina',
        $discount          = 'Diskon',
        $total             = 'Total'
    ;

    public array
        $paymentType       = ['Penarikan', 'Manual', 'Instan', 'Otomatis'],
        $periodName        = ['', 'menit', 'jam', 'dina', 'minggu', 'wulan', 'taun'],
        $currency          = ['dolar', 'euro', 'bitcoin', 'rubel', 'pound', 'yen', 'won', 'rupee'],
        $about             = [
            'Sugeng rawuh ing', '',
            'Ing situs kasebut, kita nglumpukake informasi paling anyar babagan HYIP. Iki minangka rating, review lan tanggal wiwitan kampanye. Kanggo pitungan bathi sing luwih trep, kita nggawa rencana tarif menyang bentuk manungsa. Ing sak panggonan sampeyan bakal nemokake kabeh sing dibutuhake kanggo milih proyek sing bakal diinvestasikan, utawa nuduhake pendapat ing obrolan.',
            'Kanggo administrator, kita nawakake penempatan proyek gratis ing situs iki. Pesenan papan kanggo spanduk ing bagean', 'pariwara', ''
        ];

    public function getPeriodName(int $i, int $k): string {
        return ['menit', 'jam', 'dina', 'minggu', 'wulan', 'taun'][$i-1];
    }
}
