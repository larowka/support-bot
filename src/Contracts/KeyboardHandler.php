<?php

namespace Larowka\SupportBot\Contracts;

use Illuminate\Support\Str;

abstract class KeyboardHandler extends Handler
{
    protected string $startsWith;

    public function trigger(): bool
    {
        return $this->update->type() === 'message' &&
            $this->update->user() &&
            Str::startsWith($this->update->message()->text, $this->startsWith);
    }
}