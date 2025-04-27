<?php

namespace App\Console\Commands;

use App\Handlers\MessageHandler;
use App\Interfaces\TelegramServiceInterface;
use App\Services\MessageProcessorService;
use Illuminate\Console\Command;

class StartTelegramBot extends Command
{
    protected $signature = 'telegram:run';
    protected $description = 'Запустить Telegram-бота';

    private TelegramServiceInterface $telegramService;
    private MessageProcessorService $messageProcessor;

    public function __construct(
        TelegramServiceInterface $telegramService,
        MessageProcessorService $messageProcessor
    ) {
        parent::__construct();
        $this->telegramService = $telegramService;
        $this->messageProcessor = $messageProcessor;
    }

    public function handle(): void
    {
        try {
            $this->telegramService->initialize();

            $this->info("Авторизация успешна!");

            $this->telegramService->sendMessage("Бот запущен и готов к работе!");
            $this->info("Приветственное сообщение отправлено");

            $handler = new MessageHandler($this->telegramService, $this->messageProcessor);
            $handler->start();

        } catch (\Throwable $e) {
            $this->error("Произошла ошибка: " . $e->getMessage());
        }
    }
}