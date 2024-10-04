<?php

namespace Larowka\SupportBot\Jobs;

use Larowka\SupportBot\Contracts\SupportUser;
use Larowka\SupportBot\Enums\Bot;
use Larowka\SupportBot\Facades\Telegram;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Larowka\SupportBot\Models\Topic;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class StartSupportSession implements ShouldQueue
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
    ) {
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

        $title = sprintf(
            '#%s - %s (%s)',
            Topic::query()->max('id') + 1,
            $this->user->telegram_name,
            '', // $this->user->getCountryFlag()
        );

        if ($this->user->topics()->active()->doesntExist()) {
            $topic = Telegram::createForumTopic($groupId, $title);

            $this->user->topics()
                ->create([
                    'message_thread_id' => $topic->message_thread_id,
                    'is_active'         => true
                ]);
        }
    }
}
