<?php

namespace App\Interfaces;

use danog\MadelineProto\API;

interface TelegramServiceInterface
{
    public function initialize(): void;
    public function getApi(): API;
    public function getMyId(): int;
    public function getTargetId(): int;
    public function sendMessage(string $message): void;
}