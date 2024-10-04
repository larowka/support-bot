<?php

namespace Larowka\SupportBot\Facades;

use Illuminate\Support\Facades\Facade;
use Larowka\SupportBot\SupportBotManager;
use RuntimeException;

/**
 * @method static void handle(array $update)
 */
class SupportManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return SupportBotManager::class;
    }
}