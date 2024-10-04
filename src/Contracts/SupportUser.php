<?php

namespace Larowka\SupportBot\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Larowka\SupportBot\Models\Topic;

/**
 * @mixin Model
 */
interface SupportUser
{
    /**
     * @return HasMany<Topic>
     */
    public function topics(): HasMany;

    public function telegramChatId(): string;
}