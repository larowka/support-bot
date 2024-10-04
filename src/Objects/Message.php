<?php

namespace Larowka\SupportBot\Objects;

use Larowka\SupportBot\Enums\File;

/**
 * This object represents a message.
 *
 * @property string       $message_id
 * @property string       $message_thread_id
 * @property string       $text
 * @property SimpleFile   $animation       Optional. Message is an animation, information about the animation. For backward compatibility, when this field is set, the document field will also be set
 * @property SimpleFile   $audio           Optional. Message is an audio file, information about the file
 * @property SimpleFile   $document        Optional. Message is a general file, information about the file
 * @property SimpleFile[] $photo           Optional. Message is a photo, available for all
 * @property SimpleFile   $video           Optional. Message is a video, information about the video
 * @property SimpleFile   $voice           Optional. Message is a voice message, information about the file
 * @property SimpleFile   $sticker         Optional. Message is a sticker, information about the sticker
 * @property SimpleFile   $video_note      Optional. Message is a video note, information about the video message
 * @property string       $caption         Optional. Caption for the document, photo or video
 */
class Message extends TelegramObject
{
    public function file(): SimpleFile|false
    {
        $data = (array) $this->properties;

        $file = $this->animation
            ?? $this->audio
            ?? $this->document
            ?? $this->photo
            ?? $this->video
            ?? $this->voice
            ?? $this->sticker
            ?? $this->video_note;

        return match (true) {
            isset($data['animation']) => SimpleFile::make(array_merge((array) $file, ['type' => File::ANIMATION])),
            isset($data['audio']) => SimpleFile::make(array_merge((array) $file, ['type' => File::AUDIO])),
            isset($data['document']) => SimpleFile::make(array_merge((array) $file, ['type' => File::DOCUMENT])),
            isset($data['video']) => SimpleFile::make(array_merge((array) $file, ['type' => File::VIDEO])),
            isset($data['voice']) => SimpleFile::make(array_merge((array) $file, ['type' => File::VOICE])),
            isset($data['sticker']) => SimpleFile::make(array_merge((array) $file, ['type' => File::STICKER])),
            isset($data['video_note']) => SimpleFile::make(array_merge((array) $file, ['type' => File::VIDEO_NOTE])),
            isset($data['photo']) => SimpleFile::make(array_merge((array) ((array) $data['photo'])[0], ['type' => File::PHOTO])),
            default => false
        };
    }
}