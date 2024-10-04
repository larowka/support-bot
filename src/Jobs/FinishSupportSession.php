<?php

namespace Larowka\SupportBot\Jobs;

use Larowka\SupportBot\Contracts\SupportUser;
use Larowka\SupportBot\Enums\Bot;
use Larowka\SupportBot\Facades\Telegram;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class FinishSupportSession implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public SupportUser $user
    )
    {
        $this->onQueue(config('support-bot.bot.queue.name'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $groupId = config('support-bot.bot.group_id');

        if (is_null($groupId)) {
            Log::error('Не указан ID группы поддержки');

            return;
        }

        $topic = $this->user->topics()
            ->active()
            ->latest()
            ->first();

        if (!$topic) {
            // TODO: Нет активного обращения
            return;
        }

        Telegram::sendMessage(
            $groupId,
            __('support-bot.system_end'),
            $topic->message_thread_id
        );

        Telegram::closeForumTopic(
            $groupId,
            $topic->message_thread_id
        );

        $topic->update(['is_active' => false]);
    }
}
