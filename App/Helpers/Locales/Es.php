<?php

namespace App\Helpers\Locales;

class Es extends AbstractLanguage {

    // Spanish
    public string
        $aboutUs           = 'Sobre nosotros',
        $active            = 'Activo',
        $addLevel          = 'Agregar nivel',
        $addPlan           = 'Agregar plan',
        $addProject        = 'Agregar proyecto',
        $advertising       = 'Publicidad',
        $after             = 'through',
        $availableValues   = 'Valores posibles',
        $badPassword       = 'Contraseña no válida',
        $chat              = 'Chat',
        $check             = 'comprobar',
        $contact           = 'Contacto',
        $dateStart         = 'Fecha de inicio',
        $deleted           = 'Eliminado',
        $deposit           = 'Depósito',
        $description       = 'Descripción',
        $enter             = 'Iniciar sesión',
        $error             = 'Error',
        $exit              = 'Salir',
        $expectedNumber    = 'Número esperado',
        $fileNotFound      = 'Archivo %s no encontrado',
        $fixedLength       = 'Longitud fija',
        $free              = 'gratis',
        $freeForAddProject = 'Añadiendo un proyecto a la base de datos por completo',
        $from              = 'desde',
        $new               = 'Nuevo',
        $forLastMonth      = 'Durante el último mes',
        $forAllTime        = 'Durante todo este tiempo',
        $guest             = 'Invitado',
        $headKeywords      = 'monitoreo del hype 2021, proyectos altamente rentables, ganancias en Internet, proyectos de inversión, pirámides',
        $headDescription   = 'Proyectos de inversión de alto rendimiento 2021',
        $headTitle         = 'Mercado de inversiones',
        $invalidDateFormat = 'Formato de fecha no válido',
        $languages         = 'Idiomas del sitio',
        $level             = 'nivel',
        $login             = 'Iniciar sesión',
        $loginIsBusy       = 'Este inicio de sesión ya está registrado. Por favor ingrese otro ',
        $maxLength         = 'Número máximo de caracteres:',
        $maxValue          = 'Valor máximo:',
        $message           = 'Mensaje',
        $messageIsSent     = 'Mensaje enviado',
        $minDeposit        = 'Depósito mínimo',
        $minLength         = 'Número mínimo de caracteres:',
        $minValue          = 'Valor mínimo:',
        $menu              = 'Menú',
        $name              = 'Nombre',
        $needAuthorization = 'Necesitas autorizar',
        $no                = 'No',
        $noAccess          = 'Sin acceso',
        $noLanguage        = 'Idioma no encontrado',
        $noUser            = 'Usuario no encontrado',
        $noPage            = 'Página no encontrada',
        $noProject         = 'Proyecto no encontrado',
        $notPublished      = 'No publicado',
        $options           = 'Opciones',
        $password          = 'Contraseña',
        $paymentSystem     = 'Sistemas de pago',
        $paywait           = 'Esperando pago',
        $period            = 'Periodo',
        $placeBanner       = 'Colocar un banner|por $%d por semana',
        $plans             = 'Planes de tarifas',
        $profit            = 'Beneficio',
        $projectIsAdded    = 'Proyecto agregado',
        $projectName       = 'Nombre del proyecto',
        $projects          = 'Proyectos',
        $projectUrl        = 'Enlace al proyecto (o enlace de referencia)',
        $prohibitedChars   = 'Caracteres ilegales ingresados',
        $rating            = 'Valoración',
        $refProgram        = 'Programa de recomendación',
        $registration      = 'Registro',
        $remember          = 'Recordar',
        $remove            = 'Eliminar',
        $repeatPassword    = 'Repetir contraseña',
        $required          = 'Necesario',
        $scam              = 'Estafa',
        $sendForm          = 'Enviar formulario',
        $showAllLangs      = 'Mostrar todos los idiomas',
        $siteExists        = 'El sitio ya está en la base de datos',
        $siteIsFree        = 'El sitio no está en la base de datos',
        $startDate         = 'Fecha de inicio del proyecto',
        $success           = 'Exitoso',
        $userRegistered    = 'El usuario está registrado',
        $userRegistration  = 'Registro de usuario',
        $writeMessage      = 'Escribir un mensaje',
        $wrongUrl          = 'URL del sitio incorrecta',
        $wrongValue        = 'Valor no válido',
        $yes               = 'Sí',
        $youAreAuthorized  = 'Está autorizado',
        $bannerPosition    = 'Posición de la pancarta',
        $blockOnTop        = 'Bloque en la parte superior',
        $blockOnTheLeft    = 'Bloque a la izquierda',
        $numberOfDays      = 'Número de días',
        $discount          = 'Descuento',
        $total             = 'Total'
    ;

    public array
        $paymentType       = ['Tipo de pago', 'Manual', 'Instantáneo', 'Automático'],
        $periodName        = ['', 'minutos', 'horas', 'días', 'semanas', 'meses', 'año'],
        $currency          = ['dólar', 'euro', 'bitcoin', 'rublo', 'libra', 'yen', 'won', 'rupia'],
        $about             = [
            'Bienvenido a', '',
            'En el sitio recopilamos la información más actualizada sobre los HYIP. Estos son la calificación, las reseñas y la fecha de inicio de la campaña. Para un cálculo de beneficios más conveniente, traemos planes tarifarios a la forma humana. En un solo lugar encontrarás todo lo necesario para elegir un proyecto en el que vas a invertir, o compartir tu opinión en el chat.',
            'Para los administradores, ofrecemos la colocación de proyectos gratis en nuestro sitio. Solicitar lugares para banners en la sección', 'publicidad', ''
        ];

    public function getPeriodName(int $i, int $k): string {
        return ['minuto', 'hora', 'día', 'semana', 'mes', 'año'][$i-1].(
            $k>1
                ? ($i === 5 ? 'es' : 's')
                : ''
            );
    }
}
