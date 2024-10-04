<?php

namespace Larowka\SupportBot\Contracts;

use Larowka\SupportBot\BotService;
use Larowka\SupportBot\Objects\Update;

abstract class Handler
{
    public bool $stopOnTrigger = true;

    public function __construct(
        protected BotService $bot,
        protected Update     $update
    )
    {
        //
    }

    abstract public function trigger(): bool;

    abstract public function handle(): void;

    /**
     * @param class-string $job
     * @param mixed        ...$args
     *
     * @return void
     */
    protected function dispatch(string $job, ...$args): void
    {
        if (config('support-bot.bot.queue.enabled')) {
            $job::dispatch(...$args);
        } else {
            $job::dispatchSync(...$args);
        }
    }
}