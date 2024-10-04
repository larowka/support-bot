<?php

namespace Larowka\SupportBot\Objects;

/**
 * This object represents a forum topic.
 *
 * @property int    $message_thread_id      Unique identifier of the forum topic
 * @property string $name                   Name of the topic
 * @property int    $icon_color             Color of the topic icon in RGB format
 * @property string $icon_custom_emoji_id   Optional. Unique identifier of the custom emoji shown as the topic icon
 */
class ForumTopic extends TelegramObject
{
    //
}