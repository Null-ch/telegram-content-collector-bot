<?php

namespace App\Services;

use App\Interfaces\TelegramServiceInterface;
use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use Illuminate\Support\Arr;

class TelegramService implements TelegramServiceInterface
{
    private API $api;
    private int $myId;
    private int $targetId;

    public function __construct()
    {
        $settings = new Settings;
        $settings->getAppInfo()
            ->setApiId((int)env('TG_API_ID'))
            ->setApiHash(env('TG_API_HASH'));

        $this->api = new API(storage_path('app/madeline/session.madeline'), $settings);
    }

    public function initialize(): void
    {
        $this->api->start();
        $me = $this->api->getSelf();
        $this->myId = Arr::get($me, 'id');
        echo "Авторизован как: " . Arr::get($me, 'username') . " (ID: " . $this->myId . ")\n";
        $targetUsername = env('TG_TARGET_USERNAME');
        $target = $this->api->getInfo($targetUsername);
        $this->targetId = Arr::get($target, 'User.id');
    }

    public function getApi(): API
    {
        return $this->api;
    }

    public function getMyId(): int
    {
        return $this->myId;
    }

    public function getTargetId(): int
    {
        return $this->targetId;
    }

    public function sendMessage(string $message): void
    {
        $this->api->messages->sendMessage([
            'peer' => $this->targetId,
            'message' => $message
        ]);
    }
}
