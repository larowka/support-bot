<?php

namespace Larowka\SupportBot\Facades;

use Larowka\SupportBot\BotService;
use Larowka\SupportBot\Enums\File;
use Larowka\SupportBot\Objects\ForumTopic;
use Larowka\SupportBot\Objects\Message;
use Illuminate\Support\Facades\Facade;
use RuntimeException;

/**
 * @method static Message sendMessage(string $chat_id, string $text, int $message_thread_id = null, string $parse_mode = 'html', array $reply_markup = null)
 * @method static ForumTopic createForumTopic(string $chat_id, string $name, ?int $icon_color = null, ?string $icon_custom_emoji_id = null)
 * @method static ForumTopic closeForumTopic(string $chat_id, int $message_thread_id)
 * @method static Message sendFile(string $chat_id, string $file, File $type, int $message_thread_id = null, string $parse_mode = 'html', array $reply_markup = null, string $caption = null, bool $show_caption_above_media = true)
 */
class Telegram extends Facade
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
        return BotService::class;
    }
}