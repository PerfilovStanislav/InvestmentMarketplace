<?php

namespace App\Helpers\Locales;

class De extends AbstractLanguage {

    public string
        $active            = 'Aktiv',
        $addLevel          = 'Level hinzufügen',
        $addPlan           = 'Plan hinzufügen',
        $addProject        = 'Projekt hinzufügen',
        $advertising       = 'Reclame',
        $after             = 'nach',
        $availableValues   = 'Verfügbare Werte',
        $badPassword       = 'Falsches Passwort',
        $chat              = 'Plaudern',
        $check             = 'prüfen',
        $contact           = 'Kontakt',
        $dateStart         = 'Anfangsdatum',
        $deleted           = 'Gelöscht',
        $deposit           = 'Anzahlung',
        $description       = 'Beschreibung',
        $enter             = 'Eingeben',
        $error             = 'Error',
        $exit              = 'Ausgang',
        $expectedNumber    = 'Erwartet eine Nummer',
        $fileNotFound      = 'Die Datei %s wurde nicht gefunden',
        $fixedLength       = 'Feste Länge:',
        $free              = 'kostenlos',
        $freeForAddProject = 'Das Hinzufügen eines Projekts zur Datenbank ist völlig',
        $from              = 'von',
        $guest             = 'Gast',
        $headKeywords      = 'Hyip Monitoring 2020, profitable Projekte, Kapital, Investitionen',
        $headDescription   = 'High Yield Investment Projekte 2020',
        $headTitle         = 'Realer Investmentmarkt',
        $invalidDateFormat = 'Ungültiges Datumsformat',
        $languages         = 'Websitesprachen',
        $level             = 'Niveau',
        $login             = 'Anmeldung',
        $loginIsBusy       = 'Dieser Login ist bereits registriert. Bitte geben Sie einen anderen ein',
        $maxLength         = 'Maximale Anzahl von Zeichen:',
        $maxValue          = 'Höchster Wert:',
        $message           = 'Botschaft',
        $messageIsSent     = 'Nachricht wird gesendet',
        $minDeposit        = 'Mindesteinzahlung',
        $minLength         = 'Mindestanzahl von Zeichen:',
        $minValue          = 'Mindestwert:',
        $menu              = 'Speisekarte',
        $name              = 'Name',
        $needAuthorization = 'Sie müssen sich anmelden',
        $no                = 'Nein',
        $noAccess          = 'Kein Zugang',
        $noLanguage        = 'Sprache wird nicht gefunden',
        $noUser            = 'Benutzer wurde nicht gefunden',
        $noPage            = 'Seite wurde nicht gefunden',
        $noProject         = 'Projekt wurde nicht gefunden',
        $notPublished      = 'Nicht veröffentlicht',
        $options           = 'Optionen',
        $password          = 'Passwort',
        $paymentSystem     = 'Zahlungssysteme',
        $paywait           = 'Paywait',
        $period            = 'Zeitraum',
        $placeBanner       = 'Platzieren Sie ein Banner|für $%d pro Woche',
        $plans             = 'Investitionspläne',
        $profit            = 'Profitieren',
        $projectName       = 'Projektname',
        $projectIsAdded    = 'Projekt wird hinzugefügt',
        $projectUrl        = 'URL des Projekts oder Empfehlungslink',
        $prohibitedChars   = 'Verbotene Zeichen werden eingegeben',
        $rating            = 'Bewertung',
        $refProgram        = 'Empfehlungsprogramm',
        $registration      = 'Anmeldung',
        $remember          = 'Merken',
        $remove            = 'Entfernen',
        $repeatPassword    = 'Wiederhole das Passwort',
        $required          = 'Erforderlich',
        $scam              = 'Betrug',
        $sendForm          = 'Sende Formular',
        $showAllLangs      = 'Alle Sprachen anzeigen',
        $siteExists        = 'Site existiert bereits',
        $siteIsFree        = 'Die Seite ist kostenlos',
        $startDate         = 'Startdatum des Projekts',
        $success           = 'Erfolg',
        $userRegistered    = 'Benutzer ist registriert',
        $userRegistration  = 'Benutzerregistrierung',
        $writeMessage      = 'Eine Nachricht schreiben',
        $wrongUrl          = 'Falsche Adresse der Site',
        $wrongValue        = 'Falscher Wert',
        $yes               = 'Ja',
        $youAreAuthorized  = 'Sie sind berechtigt',
        $bannerPosition    = 'Bannerpositie',
        $blockOnTop        = 'Blok bovenop',
        $blockOnTheLeft    = 'Blok aan de linkerkant',
        $numberOfDays      = 'Aantal dagen',
        $discount          = 'Korting',
        $total             = 'Totaal'
    ;

    public array
        $paymentType       = ['Auszahlung', 'Manuell', 'Sofort', 'Automatisch'],
        $periodName        = ['', 'minuten', 'stunden', 'tage', 'wochen', 'monate', 'jahre'],
        $currency          = ['dollar', 'euro', 'bitcoin', 'rubel', 'pfund', 'yen', 'won', 'rupie'];

    public function getPeriodName(int $i, int $k): string {
        return ['minute', 'stunde', 'tag', 'woche', 'monat', 'jahr'][$i-1].(
            $k > 1 ? ['n', 'n', 'e', 'n', 'e', 'e'][$i-1] : ''
        );
    }
}
