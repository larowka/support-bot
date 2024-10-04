<?php

namespace Larowka\SupportBot\Contracts;

use Larowka\SupportBot\BotService;
use Larowka\SupportBot\Objects\Update;
use Illuminate\Support\Facades\Log;

abstract class Manager
{
    protected array $handlers = [];

    protected function __construct(
        protected BotService $service
    ) {
       //
    }

    public function handle(array $update): void
    {
        $manager = function () use ($update) {
            $update = Update::make($update);

            if (app()->hasDebugModeEnabled()) {
                Log::channel('telegram')
                    ->debug('Handle update', [
                        'update' => $update->toArray()
                    ]);
            }

            foreach ($this->handlers as $handler) {
                if (is_subclass_of($handler, Handler::class)) {
                    $_handler = new $handler($this->service, $update);

                    if ($_handler->trigger()) {
                        $_handler->handle();

                        if (app()->hasDebugModeEnabled()) {
                            Log::info($_handler::class . ' triggered');
                        }

                        if ($_handler->stopOnTrigger) {
                            break;
                        }
                    }
                }
            }
        };

        if (config('support-bot.bot.queue.enabled')) {
            dispatch($manager)->onQueue(config('support-bot.bot.queue.name'));
        } else {
            $manager();
        }
    }
}