<?php

namespace Larowka\SupportBot\Handlers;

use Larowka\SupportBot\Contracts\Handler;
use Larowka\SupportBot\Jobs\HandleAdminMessage;

class AdminMessageUpdate extends Handler
{
    public function trigger(): bool
    {
        return $this->update->type() === 'message' &&
            $this->update->message()?->chat->id == config('support-bot.bot.group_id') &&
            $this->update->message()->message_thread_id &&
            $this->update->admin();
    }

    public function handle(): void
    {
        $this->dispatch(HandleAdminMessage::class, $this->update);
    }
}