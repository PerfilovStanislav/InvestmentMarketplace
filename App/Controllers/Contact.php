<?php

namespace App\Controllers;

use App\Core\{Controller};
use App\Helpers\Output;
use App\Models\Constant\Views;
use App\Requests\Contact\SendMessageRequest as ContactSendMessage;
use App\Requests\Telegram\SendMessageRequest;
use App\Views\Contact\FormSent;
use App\Views\Contact\Show;

class Contact extends Controller {

    public function show(array $data = []): Output {
        return Output()
            ->addView(Show::class, [])
            ->addFunctions([
                'imgClickInit',
                'initForms',
            ]);
    }

    public function send(ContactSendMessage $request): Output {
        App()->telegram()->sendMessage(new SendMessageRequest([
            'chat_id' => \Config::TELEGRAM_ADD_GROUP_PROJECT_ID,
            'text' => sprintf( implode(PHP_EOL, ['Login: `%s`', 'SessionId: %d', 'Name: %s', 'Message: %s']),
                CurrentUser()->user->login ?? 'Guest',
                CurrentUser()->session_id,
                $request->name,
                $request->message
            ),
        ]));

        return Output()
            ->addView(FormSent::class, [], Views::FORM_SENT)
            ->addAlertSuccess(Translate()->success, Translate()->messageIsSent);
    }
}
