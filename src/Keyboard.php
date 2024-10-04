<?php

namespace Larowka\SupportBot;

abstract class Keyboard
{
    public static function main(): array
    {
        return [
            'keyboard' => [
                [
                    ['text' => '👨‍💼 ' . __('telegram.menu.manager')]
                ],
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];
    }

    public static function finish(): array
    {
        return [
            'keyboard' => [
                [
                    ['text' => '✅ ' . __('telegram.menu.finish')]
                ],
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];
    }
}