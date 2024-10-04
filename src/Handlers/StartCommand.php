<?php

namespace Larowka\SupportBot\Handlers;

use Larowka\SupportBot\Contracts\Handler;
use Larowka\SupportBot\Jobs\StartSupportSession;

/**
 * Теоретически не авторизованный пользователь запустил саппорт бота
 */
class StartCommand extends Handler
{
    public function trigger(): bool
    {
        return $this->update->type() === 'message' &&
            $this->update->message()?->text === '/start';
    }

    public function handle(): void
    {
        if ($this->update->user() === null) {
            // Не авторизованный пользователь

            return;
        }

        $this->dispatch(StartSupportSession::class, $this->update->user());

        $this->bot->sendMessage(
            $this->update->message()->chat->id,
            __('support-bot.session_started'),
//            replyMarkup: Keyboard::finish()
        );
    }
}