<?php

namespace Helpers\Locales;

class Tr extends AbstractLanguage {

    public string
        $active            = 'Активные',
        $addLevel          = 'Добавить уровень',
        $addPlan           = 'Добавить план',
        $addProject        = 'Добавление проекта',
        $after             = 'через',
        $availableValues   = 'Возможные значения',
        $badPassword       = 'Неверный пароль',
        $chat              = 'Чат',
        $check             = 'проверить',
        $contact           = 'Контакт',
        $dateStart         = 'Дата старта',
        $deleted           = 'Удаленные',
        $deposit           = 'Депозит',
        $description       = 'Описание',
        $enter             = 'Войти',
        $error             = 'Ошибка',
        $exit              = 'Выйти',
        $expectedNumber    = 'Ожидалось число',
        $fileNotFound      = 'Файл %s не найден',
        $fixedLength       = 'Фиксированная длина',
        $free              = 'бесплатно',
        $freeForAddProject = 'Добавление проекта в базу совершенно',
        $from              = 'от',
        $guest             = 'Гость',
        $headKeywords      = 'хайп мониторинг 2020, высокодоходные проекты, заработок в интернете, инвестиционные проекты, пирамиды',
        $headDescription   = 'Высокодоходные инвестиционные проекты 2020',
        $headTitle         = 'Инвестиционная Рыночная Площадка',
        $invalidDateFormat = 'Неверный формат даты',
        $languages         = 'Языки сайта',
        $level             = 'уровень',
        $login             = 'Логин',
        $loginIsBusy       = 'Данный логин уже зарегистрирован. Введите другой',
        $maxLength         = 'Максимальное количество знаков:',
        $maxValue          = 'Максимальное значение:',
        $message           = 'Сообщение',
        $messageIsSent     = 'Сообщение отправлено',
        $minDeposit        = 'Минимальный депозит',
        $minLength         = 'Минимальное количество знаков:',
        $minValue          = 'Минимальное значение:',
        $menu              = 'Меню',
        $name              = 'Имя',
        $needAuthorization = 'Вам необходимо авторизоваться',
        $no                = 'Нет',
        $noAccess          = 'Нет доступа',
        $noLanguage        = 'Язык не найден',
        $noUser            = 'Пользователь не найден',
        $noPage            = 'Страница не найдена',
        $noProject         = 'Проект не найден',
        $notPublished      = 'Неопубликованные',
        $options           = 'Опции',
        $password          = 'Пароль',
        $paymentSystem     = 'Платёжные системы',
        $paywait           = 'Ожидание оплаты',
        $period            = 'Период',
        $placeBanner       = 'Разместите баннер|за $%d в неделю',
        $plans             = 'Тарифные планы',
        $profit            = 'Прибыль',
        $projectName       = 'Название проекта',
        $projectIsAdded    = 'Проект добавлен',
        $projectUrl        = 'Ссылка на проект (либо реферальная ссылка)',
        $prohibitedChars   = 'Введены запрещённые символы',
        $rating            = 'Рейтинг',
        $refProgram        = 'Реферальная программа',
        $registration      = 'Регистрация',
        $remember          = 'Запомнить',
        $remove            = 'Удалить',
        $repeatPassword    = 'Повторите пароль',
        $scam              = 'Скам',
//        $selectFile        = 'Выбрать файл',
        $sendForm          = 'Отправить форму',
        $showAllLangs      = 'Показать все языки',
        $siteExists        = 'Сайт уже в базе',
        $siteIsFree        = 'Сайта нет в базе',
        $startDate         = 'Дата начала проекта',
        $success           = 'Успешно',
        $userRegistered    = 'Пользователь зарегистрирован',
        $userRegistration  = 'Регистрация пользователя',
        $writeMessage      = 'Напишите сообщение',
        $wrongUrl          = 'Неправильный адрес сайта',
        $wrongValue        = 'Неверное значение',
        $yes               = 'Да',
        $youAreAuthorized  = 'Вы авторизировались';

    public array
        $paymentType       = ['Тип выплат', 'Ручной', 'Инстант (мгновенный)', 'Автоматический'],
        $periodName        = ['', 'минут', 'часов', 'дней', 'недель', 'месяцев', 'лет'],
        $currency          = ['доллар', 'евро', 'биткоин', 'рубль', 'фунт', 'йена', 'вона', 'рупий'];

    public function getPeriodName(int $i, int $k): string {
        return ['минут', 'час', '', 'недел', 'месяц', ''][$i-1].(
            ($k+89)%100<4 || ($k+9)%10>3
                ?['', 'ов', 'дней', 'ь', 'ев', 'лет'][$i-1]
                :[['а', 'ы'], ['', 'а'], ['день', 'дня'], ['я', 'и'], ['', 'а'], ['год', 'года']][$i-1][(int)($k%10>1)]
            );
    }
}
