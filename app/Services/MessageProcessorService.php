<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use App\Interfaces\TelegramServiceInterface;

class MessageProcessorService
{
    private TelegramServiceInterface $telegramService;

    public function __construct(TelegramServiceInterface $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function processMessage(array $message): void
    {
        $fromId = Arr::get($message, 'from_id');
        $chatId = Arr::get($message, 'peer_id');
        $messageText = $this->extractText($message);
        $fullMessage = json_encode($message);

        echo "Получено сообщение от ID: " . $fromId . " в чате: " . $chatId . "\n";

        try {
            $this->telegramService->sendMessage("Новое сообщение: " . $fullMessage);
        } catch (\Throwable $e) {
            Log::info("Ошибка при отправке сообщения: " . $e->getMessage() . "\n");
        }
    }

    private function extractText(array $message): ?string
    {
        return Arr::get($message, 'message');
    }
}