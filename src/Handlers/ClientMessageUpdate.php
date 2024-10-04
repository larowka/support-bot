<?php

namespace Larowka\SupportBot\Handlers;

use Larowka\SupportBot\Contracts\Handler;
use Larowka\SupportBot\Jobs\HandleClientMessage;

class ClientMessageUpdate extends Handler
{
    public function trigger(): bool
    {
        return $this->update->type() === 'message' &&
            $this->update->user() &&
            $this->update->message()->chat->id == $this->update->user()->telegramChatId();
    }

    public function handle(): void
    {
        if ($this->update->user()->topics()->active()->doesntExist()) {
            $this->bot->sendMessage(
                $this->update->message()->chat->id,
                __('support-bot.session_started'),
//                replyMarkup: Keyboard::finish()
            );
        }

        $this->dispatch(HandleClientMessage::class, $this->update);
    }
}