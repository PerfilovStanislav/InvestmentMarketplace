<?php

namespace App\Helpers\Locales;

class Fr extends AbstractLanguage {

    public string
        $active            = 'Actif',
        $addLevel          = 'Ajouter un niveau',
        $addPlan           = 'Ajouter un plan',
        $addProject        = 'Ajout de projet',
        $after             = 'après',
        $availableValues   = 'Valeurs disponibles',
        $badPassword       = 'Mauvais mot de passe',
        $chat              = 'Bavarder',
        $check             = 'vérifier',
        $contact           = 'Contact',
        $dateStart         = 'Date de début',
        $deleted           = 'Supprimé',
        $deposit           = 'Dépôt',
        $description       = 'La description',
        $enter             = 'Entrer',
        $error             = 'Erreur',
        $exit              = 'Sortie',
        $expectedNumber    = 'Attendu un nombre',
        $fileNotFound      = 'Le fichier %s est introuvable',
        $fixedLength       = 'Longueur fixe:',
        $free              = 'libre',
        $freeForAddProject = 'L\'ajout d\'un projet à la base de données est complet',
        $from              = 'de',
        $guest             = 'Client',
        $headKeywords      = 'hyip monitoring 2020, projets rentables, capital, investissements',
        $headDescription   = 'Projets d\'investissement à haut rendement 2020',
        $headTitle         = 'Marché d\'investissement réel',
        $invalidDateFormat = 'Format de date non valide',
        $languages         = 'Langues du site',
        $level             = 'niveau',
        $login             = 'S\'identifier',
        $loginIsBusy       = 'Cette connexion est déjà enregistrée. Veuillez en saisir un autre',
        $maxLength         = 'Nombre maximum de caractères:',
        $maxValue          = 'Valeur maximum:',
        $message           = 'Message',
        $messageIsSent     = 'Le message est envoyé',
        $minDeposit        = 'Dépôt minimum',
        $minLength         = 'Nombre minimum de caractères:',
        $minValue          = 'Valeur minimum:',
        $menu              = 'Menu',
        $name              = 'Nom',
        $needAuthorization = 'Vous devez vous connecter',
        $no                = 'Non',
        $noAccess          = 'Pas d\'accès',
        $noLanguage        = 'La langue est introuvable',
        $noUser            = 'L\'utilisateur est introuvable',
        $noPage            = 'La page est introuvable',
        $noProject         = 'Le projet est introuvable',
        $notPublished      = 'Non publié',
        $options           = 'Options',
        $password          = 'Mot de passe',
        $paymentSystem     = 'Systèmes de paiement',
        $paywait           = 'Paywait',
        $period            = 'Période',
        $placeBanner       = 'Placez une bannière|pour $%d par semaine',
        $plans             = 'Plans d\'investissement',
        $profit            = 'Profit',
        $projectName       = 'Nom du projet',
        $projectIsAdded    = 'Le projet est ajouté',
        $projectUrl        = 'URL du projet ou lien de référence',
        $prohibitedChars   = 'Les caractères interdits sont saisis',
        $rating            = 'Évaluation',
        $refProgram        = 'Programme de référence',
        $registration      = 'Enregistrement',
        $remember          = 'Rappelles toi',
        $remove            = 'Retirer',
        $repeatPassword    = 'Répéter le mot de passe',
        $required          = 'Obligatoire',
        $scam              = 'Arnaque',
        $sendForm          = 'Envoyez le formulaire',
        $showAllLangs      = 'Afficher toutes les langues',
        $siteExists        = 'Le site existe déjà',
        $siteIsFree        = 'Le site est gratuit',
        $startDate         = 'Date de début du projet',
        $success           = 'Succès',
        $userRegistered    = 'L\'utilisateur est enregistré',
        $userRegistration  = 'Enregistrement de l\'utilisateur',
        $writeMessage      = 'Écrire un message',
        $wrongUrl          = 'Mauvaise adresse du site',
        $wrongValue        = 'Mauvaise valeur',
        $yes               = 'Oui',
        $youAreAuthorized  = 'Vous êtes autorisé';

    public array
        $paymentType       = ['Retrait', 'Manuel', 'Instantané', 'Automatique'],
        $periodName        = ['', 'minutes', 'heures', 'jours', 'semaines', 'mois', 'années'],
        $currency          = ['dollar', 'euro', 'bitcoin', 'rouble', 'livre', 'yen', 'gagné', 'roupie'];

    public function getPeriodName(int $i, int $k): string {
        return ['minute', 'heure', 'jour', 'semaine', 'mois', ''][$i-1].(
            $i <= 4 ? ($k === 1 ? '' : 's') : (
            $i === 6 ? ($k === 1 ? 'année' : (\in_array($k, [3,4,5,10]) ? 'années' : 'ans')) : ''
            )
        );
    }
}
