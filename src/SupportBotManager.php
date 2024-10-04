<?php

namespace Larowka\SupportBot;

use Illuminate\Container\Attributes\Config;
use Larowka\SupportBot\Contracts\Manager;
use Larowka\SupportBot\Handlers\AdminMessageUpdate;
use Larowka\SupportBot\Handlers\ClientMessageUpdate;
use Larowka\SupportBot\Handlers\StartCommand;
use Larowka\SupportBot\Handlers\SupportFinishMenu;
use Larowka\SupportBot\Handlers\SupportStartCommand;
use Larowka\SupportBot\Handlers\SupportStartMenu;

class SupportBotManager extends Manager
{
    protected array $handlers = [
        StartCommand::class,
        SupportStartCommand::class,
        SupportStartMenu::class,
        SupportFinishMenu::class,

        // Текстовые хендлеры должны быть последними
        AdminMessageUpdate::class,
        ClientMessageUpdate::class
    ];

    public function __construct(
        #[Config('support-bot.bot')] protected array $config
    )
    {
        parent::__construct(new BotService($config));
    }
}