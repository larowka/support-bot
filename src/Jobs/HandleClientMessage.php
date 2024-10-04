<?php

namespace Larowka\SupportBot\Jobs;

use Larowka\SupportBot\Enums\Bot;
use Larowka\SupportBot\Facades\Telegram;
use Larowka\SupportBot\Objects\Update;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class HandleClientMessage implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Update $update
    )
    {
        $this->onQueue(config('support-bot.bot.queue.name'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (is_null(config('support-bot.bot.group_id'))) {
            Log::error('Не указан ID группы поддержки');

            return;
        }

        $client = $this->update->user();

        $topic = $client->topics()->active()->latest()->first();

        if (!$topic) {
            StartSupportSession::dispatchSync($client);

            $topic = $client->topics()->active()->latest()->first();
        }

        if ($file = $this->update->message()->file()) {
            Telegram::sendFile(
                config('support-bot.bot.group_id'),
                $file->file_id,
                $file->type(),
                $topic->message_thread_id,
                caption: __('support-bot.client', ['text' => $this->update->message()->caption])
            );
        } else {
            Telegram::sendMessage(
                config('support-bot.bot.group_id'),
                __('support-bot.client', ['text' => $this->update->message()->text]),
                $topic->message_thread_id
            );
        }
    }
}
