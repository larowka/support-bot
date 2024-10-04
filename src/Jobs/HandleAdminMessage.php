<?php

namespace Larowka\SupportBot\Jobs;

use Larowka\SupportBot\Contracts\SupportUser;
use Larowka\SupportBot\Facades\Telegram;
use Larowka\SupportBot\Objects\Update;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class HandleAdminMessage implements ShouldQueue
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

        /** @var SupportUser $user */
        $user = config('support-bot.user.model')::query()
            ->whereHas(
                'topics',
                fn($q) => $q->active()
                    ->where('message_thread_id', $this->update->message()->message_thread_id)
            )
            ->first();

        if (!$user) {
            // TODO: Нет клиента связанного с топиком
            return;
        }

        if ($file = $this->update->message()->file()) {
            $response = Telegram::sendFile(
                $user->telegramChatId(),
                $file->file_id,
                $file->type(),
                caption: __('support-bot.admin', ['text' => $this->update->message()->caption])
            );
        } else {
            $response = Telegram::sendMessage(
                $user->telegramChatId(),
                __('support-bot.admin', ['text' => $this->update->message()->text])
            );
        }

        if (!$response) {
            FinishSupportSession::dispatch($user);
        }
    }
}
