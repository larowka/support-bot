<?php

namespace Larowka\SupportBot\Handlers;

use Larowka\SupportBot\Contracts\KeyboardHandler;
use Larowka\SupportBot\Jobs\StartSupportSession;

class SupportStartMenu extends KeyboardHandler
{
    protected string $startsWith = '👨‍💼';

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