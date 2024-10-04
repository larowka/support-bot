<?php

namespace Larowka\SupportBot\Handlers;

use Larowka\SupportBot\Contracts\Handler;
use Larowka\SupportBot\Jobs\StartSupportSession;

/**
 * Клиент попал в саппорт бота редиректом из основного бота
 */
class SupportStartCommand extends Handler
{
    public function trigger(): bool
    {
        return $this->update->type() === 'message' &&
            $this->update->message()->text === '/start support_redirect' &&
            $this->update->user();
    }

    public function handle(): void
    {
        $this->dispatch(StartSupportSession::class, $this->update->user());

        $this->bot->sendMessage(
            $this->update->message()->chat->id,
            __('support-bot.session_started'),
//            replyMarkup: Keyboard::finish()
        );
    }
}