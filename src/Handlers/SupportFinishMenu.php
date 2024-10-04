<?php

namespace Larowka\SupportBot\Handlers;

use Larowka\SupportBot\Contracts\KeyboardHandler;

class SupportFinishMenu extends KeyboardHandler
{
    protected string $startsWith = '✅';

    public function handle(): void
    {
//        FinishSupportSession::dispatch($this->update->client());

        $this->bot->sendMessage(
            $this->update->message()->chat->id,
            __('support-bot.session_finished'),
//            replyMarkup: Keyboard::main()
        );
    }
}