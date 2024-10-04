<?php

namespace Larowka\SupportBot;

use Illuminate\Container\Attributes\Config;
use Larowka\SupportBot\Enums\File;
use Larowka\SupportBot\Objects\ForumTopic;
use Larowka\SupportBot\Objects\Message;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class BotService
{
    public function __construct(
        #[Config('support-bot.bot')] protected array $config
    )
    {
        //
    }

    /**
     * @param string     $chatId
     * @param string     $text
     * @param int|null   $messageThreadId
     * @param string     $parseMode
     * @param array|null $replyMarkup
     *
     * @return Message|false
     */
    public function sendMessage(
        string $chatId,
        string $text,
        int    $messageThreadId = null,
        string $parseMode = 'html',
        array  $replyMarkup = null
    ): Message|false
    {
        $response = $this->request('sendMessage', array_filter([
            'chat_id'           => $chatId,
            'text'              => $text,
            'message_thread_id' => $messageThreadId,
            'reply_markup'      => $replyMarkup,
            'parse_mode'        => $parseMode
        ]));

        if (is_array($response)) {
            return Message::make($response);
        }

        return false;
    }

    /**
     * @param string      $chatId
     * @param string      $file
     * @param File        $type
     * @param int|null    $messageThreadId
     * @param string      $parseMode
     * @param array|null  $replyMarkup
     * @param string|null $caption
     * @param bool        $showCaptionAboveMedia
     *
     * @return Message|false
     */
    public function sendFile(
        string $chatId,
        string $file,
        File   $type,
        int    $messageThreadId = null,
        string $parseMode = 'html',
        array  $replyMarkup = null,
        string $caption = null,
        bool   $showCaptionAboveMedia = true
    ): Message|false
    {
        $args = [$chatId, $file, $messageThreadId, $parseMode, $replyMarkup, $caption, $showCaptionAboveMedia];

        return match ($type) {
            File::AUDIO => $this->sendAudio(...$args),
            File::DOCUMENT => $this->sendDocument(...$args),
            File::PHOTO => $this->sendPhoto(...$args),
            File::VIDEO => $this->sendVideo(...$args),
            File::VOICE => $this->sendVoice(...$args),
            File::STICKER => $this->sendSticker(...$args),
            File::VIDEO_NOTE => $this->sendVideoNote(...$args),
            File::ANIMATION => $this->sendAnimation(...$args),
            default => false
        };
    }

    /**
     * @param string      $chatId
     * @param string      $photo
     * @param int|null    $messageThreadId
     * @param string      $parseMode
     * @param array|null  $replyMarkup
     * @param string|null $caption
     * @param bool        $showCaptionAboveMedia
     *
     * @return Message|false
     */
    public function sendPhoto(
        string $chatId,
        string $photo,
        int    $messageThreadId = null,
        string $parseMode = 'html',
        array  $replyMarkup = null,
        string $caption = null,
        bool   $showCaptionAboveMedia = true
    ): Message|false
    {
        $response = $this->request('sendPhoto', array_filter([
            'chat_id'                  => $chatId,
            'photo'                    => $photo,
            'message_thread_id'        => $messageThreadId,
            'reply_markup'             => $replyMarkup,
            'parse_mode'               => $parseMode,
            'caption'                  => $caption,
            'show_caption_above_media' => $showCaptionAboveMedia
        ]));

        if (is_array($response)) {
            return Message::make($response);
        }

        return false;
    }

    /**
     * @param string      $chatId
     * @param string      $audio
     * @param int|null    $messageThreadId
     * @param string      $parseMode
     * @param array|null  $replyMarkup
     * @param string|null $caption
     * @param bool        $showCaptionAboveMedia
     *
     * @return Message|false
     */
    public function sendAudio(
        string $chatId,
        string $audio,
        int    $messageThreadId = null,
        string $parseMode = 'html',
        array  $replyMarkup = null,
        string $caption = null,
        bool   $showCaptionAboveMedia = true
    ): Message|false
    {
        $response = $this->request('sendAudio', array_filter([
            'chat_id'                  => $chatId,
            'audio'                    => $audio,
            'message_thread_id'        => $messageThreadId,
            'reply_markup'             => $replyMarkup,
            'parse_mode'               => $parseMode,
            'caption'                  => $caption,
            'show_caption_above_media' => $showCaptionAboveMedia
        ]));

        if (is_array($response)) {
            return Message::make($response);
        }

        return false;
    }

    /**
     * @param string      $chatId
     * @param string      $document
     * @param int|null    $messageThreadId
     * @param string      $parseMode
     * @param array|null  $replyMarkup
     * @param string|null $caption
     * @param bool        $showCaptionAboveMedia
     *
     * @return Message|false
     */
    public function sendDocument(
        string $chatId,
        string $document,
        int    $messageThreadId = null,
        string $parseMode = 'html',
        array  $replyMarkup = null,
        string $caption = null,
        bool   $showCaptionAboveMedia = true
    ): Message|false
    {
        $response = $this->request('sendDocument', array_filter([
            'chat_id'                  => $chatId,
            'document'                 => $document,
            'message_thread_id'        => $messageThreadId,
            'reply_markup'             => $replyMarkup,
            'parse_mode'               => $parseMode,
            'caption'                  => $caption,
            'show_caption_above_media' => $showCaptionAboveMedia
        ]));

        if (is_array($response)) {
            return Message::make($response);
        }

        return false;
    }

    /**
     * @param string      $chatId
     * @param string      $video
     * @param int|null    $messageThreadId
     * @param string      $parseMode
     * @param array|null  $replyMarkup
     * @param string|null $caption
     * @param bool        $showCaptionAboveMedia
     *
     * @return Message|false
     */
    public function sendVideo(
        string $chatId,
        string $video,
        int    $messageThreadId = null,
        string $parseMode = 'html',
        array  $replyMarkup = null,
        string $caption = null,
        bool   $showCaptionAboveMedia = true
    ): Message|false
    {
        $response = $this->request('sendVideo', array_filter([
            'chat_id'                  => $chatId,
            'video'                    => $video,
            'message_thread_id'        => $messageThreadId,
            'reply_markup'             => $replyMarkup,
            'parse_mode'               => $parseMode,
            'caption'                  => $caption,
            'show_caption_above_media' => $showCaptionAboveMedia
        ]));

        if (is_array($response)) {
            return Message::make($response);
        }

        return false;
    }

    /**
     * @param string      $chatId
     * @param string      $animation
     * @param int|null    $messageThreadId
     * @param string      $parseMode
     * @param array|null  $replyMarkup
     * @param string|null $caption
     * @param bool        $showCaptionAboveMedia
     *
     * @return Message|false
     */
    public function sendAnimation(
        string $chatId,
        string $animation,
        int    $messageThreadId = null,
        string $parseMode = 'html',
        array  $replyMarkup = null,
        string $caption = null,
        bool   $showCaptionAboveMedia = true
    ): Message|false
    {
        $response = $this->request('sendAnimation', array_filter([
            'chat_id'                  => $chatId,
            'animation'                => $animation,
            'message_thread_id'        => $messageThreadId,
            'reply_markup'             => $replyMarkup,
            'parse_mode'               => $parseMode,
            'caption'                  => $caption,
            'show_caption_above_media' => $showCaptionAboveMedia
        ]));

        if (is_array($response)) {
            return Message::make($response);
        }

        return false;
    }

    /**
     * @param string      $chatId
     * @param string      $voice
     * @param int|null    $messageThreadId
     * @param string      $parseMode
     * @param array|null  $replyMarkup
     * @param string|null $caption
     * @param bool        $showCaptionAboveMedia
     *
     * @return Message|false
     */
    public function sendVoice(
        string $chatId,
        string $voice,
        int    $messageThreadId = null,
        string $parseMode = 'html',
        array  $replyMarkup = null,
        string $caption = null,
        bool   $showCaptionAboveMedia = true
    ): Message|false
    {
        $response = $this->request('sendVoice', array_filter([
            'chat_id'                  => $chatId,
            'voice'                    => $voice,
            'message_thread_id'        => $messageThreadId,
            'reply_markup'             => $replyMarkup,
            'parse_mode'               => $parseMode,
            'caption'                  => $caption,
            'show_caption_above_media' => $showCaptionAboveMedia
        ]));

        if (is_array($response)) {
            return Message::make($response);
        }

        return false;
    }

    /**
     * @param string      $chatId
     * @param string      $sticker
     * @param int|null    $messageThreadId
     * @param string      $parseMode
     * @param array|null  $replyMarkup
     * @param string|null $caption
     * @param bool        $showCaptionAboveMedia
     *
     * @return Message|false
     */
    public function sendSticker(
        string $chatId,
        string $sticker,
        int    $messageThreadId = null,
        string $parseMode = 'html',
        array  $replyMarkup = null,
        string $caption = null,
        bool   $showCaptionAboveMedia = true
    ): Message|false
    {
        $response = $this->request('sendSticker', array_filter([
            'chat_id'                  => $chatId,
            'sticker'                  => $sticker,
            'message_thread_id'        => $messageThreadId,
            'reply_markup'             => $replyMarkup,
            'parse_mode'               => $parseMode,
            'caption'                  => $caption,
            'show_caption_above_media' => $showCaptionAboveMedia
        ]));

        if (is_array($response)) {
            return Message::make($response);
        }

        return false;
    }

    /**
     * @param string      $chatId
     * @param string      $videoNote
     * @param int|null    $messageThreadId
     * @param string      $parseMode
     * @param array|null  $replyMarkup
     * @param string|null $caption
     * @param bool        $showCaptionAboveMedia
     *
     * @return Message|false
     */
    public function sendVideoNote(
        string $chatId,
        string $videoNote,
        int    $messageThreadId = null,
        string $parseMode = 'html',
        array  $replyMarkup = null,
        string $caption = null,
        bool   $showCaptionAboveMedia = true
    ): Message|false
    {
        $response = $this->request('sendVideoNote', array_filter([
            'chat_id'                  => $chatId,
            'video_note'               => $videoNote,
            'message_thread_id'        => $messageThreadId,
            'reply_markup'             => $replyMarkup,
            'parse_mode'               => $parseMode,
            'caption'                  => $caption,
            'show_caption_above_media' => $showCaptionAboveMedia
        ]));

        if (is_array($response)) {
            return Message::make($response);
        }

        return false;
    }

    /**
     * @param string      $chatId
     * @param string      $title
     * @param int|null    $iconColor
     * @param string|null $iconCustomEmojiId
     *
     * @return ForumTopic|false
     */
    public function createForumTopic(string $chatId, string $title, int $iconColor = null, string $iconCustomEmojiId = null): ForumTopic|false
    {
        $response = $this->request('createForumTopic', array_filter([
            'chat_id'              => $chatId,
            'name'                 => $title,
            'icon_color'           => $iconColor,
            'icon_custom_emoji_id' => $iconCustomEmojiId
        ]));

        if (is_array($response)) {
            return ForumTopic::make($response);
        }

        return false;
    }

    /**
     * @param string $chatId
     * @param int    $messageThreadId
     *
     * @return bool
     */
    public function closeForumTopic(string $chatId, int $messageThreadId): bool
    {
        return $this->request('closeForumTopic', array_filter([
            'chat_id'           => $chatId,
            'message_thread_id' => $messageThreadId
        ]));
    }

    /**
     * @param string $method
     * @param array  $params
     *
     * @return array|false
     */
    private function request(string $method, array $params): array|bool
    {
        try {
            if (app()->hasDebugModeEnabled()) {
                Log::channel('telegram')
                    ->debug('Request', [
                        'method' => $method,
                        'params' => $params
                    ]);
            }

            $client = new Client([
                'base_uri' => sprintf('https://api.telegram.org/bot%s/', $this->config['token']),
                'headers'  => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $response = $client->request('POST', $method, [
                'json' => $params
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);

                if (app()->hasDebugModeEnabled()) {
                    Log::channel('telegram')
                        ->debug('Response', [
                            'response' => $data
                        ]);
                }

                if (isset($data['ok']) && $data['ok']) {
                    return $data['result'];
                }
            } elseif (app()->hasDebugModeEnabled()) {
                Log::channel('telegram')
                    ->debug('Response', [
                        'response' => json_decode($response->getBody()->getContents(), true)
                    ]);
            }

            return false;
        } catch (GuzzleException $e) {
            Log::error('Error while sending request: ' . $e->getMessage(), [
                'method' => $method,
                'params' => $params
            ]);
        }

        return false;
    }
}