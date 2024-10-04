<?php

namespace Larowka\SupportBot\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int  $message_thread_id
 * @property bool $is_active
 */
class Topic extends Model
{
    /**
     * @var string
     */
    protected $table = 'support_bot_topics';

    /**
     * @var array
     */
    protected $fillable = [
        'message_thread_id',
        'is_active'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('support-bot.user.model'));
    }
}
