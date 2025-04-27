<?php

namespace App\Handlers;

use App\Interfaces\MessageHandlerInterface;
use App\Interfaces\TelegramServiceInterface;
use App\Services\MessageProcessorService;
use Illuminate\Support\Arr;

class MessageHandler implements MessageHandlerInterface
{
    private TelegramServiceInterface $telegramService;
    private MessageProcessorService $messageProcessor;
    private bool $running = true;
    private int $offset = 0;

    public function __construct(
        TelegramServiceInterface $telegramService,
        MessageProcessorService $messageProcessor
    ) {
        $this->telegramService = $telegramService;
        $this->messageProcessor = $messageProcessor;

        pcntl_signal(SIGINT, function() {
            $this->stop();
        });
    }

    public function start(): void
    {
        echo "Начинаю слушать обновления...\n";
        echo "Для завершения работы нажмите Ctrl+C\n";

        while ($this->running) {
            try {
                $updates = $this->telegramService->getApi()->getUpdates([
                    'offset' => $this->offset,
                    'limit' => 50,
                    'timeout' => 1
                ]);

                if (count($updates) > 0) {
                    foreach ($updates as $update) {
                        $this->offset = Arr::get($update, 'update_id') + 1;
                        
                        if ($updateData = Arr::get($update, 'update')) {
                            $this->handleUpdate($updateData);
                        }
                    }
                }

                pcntl_signal_dispatch();
            } catch (\Throwable $e) {
                echo "Ошибка при обработке обновлений: " . $e->getMessage() . "\n";
            }
            sleep(1);
        }

        echo "Работа завершена\n";
    }

    public function stop(): void
    {
        echo "\nПолучен сигнал завершения. Завершаю работу...\n";
        $this->running = false;
    }

    private function handleUpdate(array $updateData): void
    {
        if (in_array(Arr::get($updateData, '_'), ['updateNewMessage', 'updateNewChannelMessage'])) {
            $message = Arr::get($updateData, 'message');
            
            if (Arr::get($message, 'from_id') == $this->telegramService->getMyId()) {
                return;
            }

            $this->messageProcessor->processMessage($message);
        }
    }
} 