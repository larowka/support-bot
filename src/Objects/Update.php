<?php

namespace Larowka\SupportBot\Objects;

use Larowka\SupportBot\Contracts\SupportUser;

/**
 * This [object](https://core.telegram.org/bots/api#available-types) represents an incoming update.
 * At most one of the optional parameters can be present in any given update.
 *
 * @property int      $update_id       The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially. This ID becomes especially handy if you're using Webhooks, since it allows you to ignore repeated updates or to restore the correct update sequence, should they get out of order. If there are no new updates for at least a week, then identifier of the next update will be chosen randomly instead of sequentially.
 * @property Message  $message         Optional. New incoming message of any kind — text, photo, sticker, etc.
 * @property Message  $edited_message  Optional. New version of a message that is known to the bot and was edited
 */
class Update extends TelegramObject
{
    protected ?SupportUser $user = null;
    protected ?SupportUser $admin = null;

    public function type(): string|null
    {
        foreach ($this->properties as $key => $value) {
            if ($key !== 'update_id') {
                return $key;
            }
        }

        return null;
    }

    /**
     * Get the `Message` object instance from update.
     *
     * @return Message|null
     */
    public function message(): ?Message
    {
        $message = $this->message ??
            $this->edited_message ??
            $this->channel_post ??
            $this->edited_channel_post ??
            $this->callback_query->message ??
            $this->business_message ??
            $this->edited_business_message;

        if ($message) {
            return Message::make((array)$message);
        }

        return null;
    }

    /**
     * @return SupportUser
     */
    public function user(): SupportUser
    {
        if ($this->user) {
            return $this->user;
        }

        $this->user = config('support-bot.user.model')::query()
            ->where(config('support-bot.user.chat_key'), $this->message()->from->id)
            ->first();

        return $this->user;
    }

    /**
     * @return SupportUser
     */
    public function admin(): SupportUser
    {
        if ($this->admin) {
            return $this->admin;
        }

        $this->admin = config('support-bot.admin.model')::query()
            ->where(config('support-bot.admin.chat_key'), $this->message()->from->id)
            ->first();

        return $this->admin;
    }
}