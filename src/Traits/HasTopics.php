<?php

namespace Larowka\SupportBot\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Larowka\SupportBot\Models\Topic;

trait HasTopics
{
    /**
     * Список топиков пользователя (Обращения в службу поддержки)
     *
     * @return HasMany
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}