<?php

namespace Controllers;

use Libraries\Screens;
use Models\Constant\ProjectStatus;
use Requests\Investment\ChangeStatusRequest;
use Requests\Investment\ReloadScreenshotRequest;
use Requests\Telegram\EditMessageReplyMarkup;
use Requests\Telegram\SendPhotoRequest;
use Requests\Telegram\SetWebhookRequest;
use Requests\Telegram\WebhookRequest;
use Services\InvestmentService;

class Telegram {
    public const
        ACTIVATE      = 'activate',
        RELOAD_SCREEN = 'reloadScreen';

    public function __construct()
    {
        Output()->disableLayout();
    }

    public function setWebhook() {
        $request = new SetWebhookRequest([
            'url'             => SITE . '/Telegram/getwebhook/token/' . \Config::TELEGRAM_GET_WEBHOOK_KEY . '/',
            'certificate'     => '/etc/nginx/ssl/ssl.ca-bundle',
            'max_connections' => 20,
        ]);
        $result = App()->telegram()->setWebhook($request);
    }

    public function getwebhook(string $token, WebhookRequest $request) {
        if ($token !== \Config::TELEGRAM_GET_WEBHOOK_KEY) {
            die('=(');
        }

        if (!$request->callback_query->message) {
            die();
        }

        // Remove keyboard
        App()->telegram()->editMessageReplyMarkup(new EditMessageReplyMarkup([
            'chat_id'     => $request->callback_query->message->chat->id,
            'message_id'  => $request->callback_query->message->message_id,
            'reply_markup' => [
                'inline_keyboard' => []
            ],
        ]));

        switch ($request->callback_query->data['action']) {
            case self::ACTIVATE:
                (new InvestmentService())->changeStatus(new ChangeStatusRequest([
                    'status'  => ProjectStatus::getConstNameLower(ProjectStatus::ACTIVE),
                    'project' => $request->callback_query->data['project_id'],
                ]));
                break;
//            case self::RELOAD_SCREEN:
//                $projectId = $request->callback_query->data['project_id'];
//                (new InvestmentService())->reloadScreen(new ReloadScreenshotRequest(['project' => $projectId]));
//
//                App()->telegram()->sendPhoto(new SendPhotoRequest([
//                    'chat_id'             => $request->callback_query->message->chat->id,
//                    'photo'               => Screens::getOriginalJpgScreen($projectId),
//                    'reply_to_message_id' => $request->callback_query->message->message_id,
//                    'reply_markup' => [
//                        'inline_keyboard' => [[[
//                            'text' => '👍 public',
//                            'callback_data' => json_encode([
//                                'action' => self::ACTIVATE,
//                                'project_id' => $projectId
//                            ], JSON_THROW_ON_ERROR)],
//                        ]]],
//                ]));
//                break;
        }
    }
}