<?php

namespace Larowka\SupportBot\Objects;

use Larowka\SupportBot\Enums\File;

/**
 * This object represents a general file.
 *
 * @property int    $type
 * @property string $file_id        Identifier for this file, which can be used to download or reuse the file
 * @property string $file_unique_id Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 */
class SimpleFile extends TelegramObject
{
    public function type(): File
    {
        return File::from($this->type);
    }
}