<?php

namespace Controllers;

use Core\{Controller};
use Helpers\Output;
use Requests\Contact\SendMessageRequest as ContactSendMessage;
use Requests\Telegram\SendMessageRequest;
use Views\Contact\Show;

class Contact extends Controller {

    public function show(): Output {
        return Output()
            ->addView(Show::class, [])
            ->addFunctions([
                'imgClickInit',
                'initForms',
            ]);
    }

    public function send(ContactSendMessage $request): Output {
        Error()->exitIfExists();

        App()->telegram()->sendMessage(new SendMessageRequest([
            'chat_id' => \Config::TELEGRAM_ADD_GROUP_PROJECT_ID,
            'text' => sprintf( implode(PHP_EOL, ['Username: `%s`', 'SessionId: %d', 'Name: %s', 'Message: %s']),
                CurrentUser()->user->name ?? 'Guest',
                CurrentUser()->session_id,
                $request->name,
                $request->message
            ),
        ]));
    }
}
