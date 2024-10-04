<?php

namespace Larowka\SupportBot\Objects;

use Illuminate\Contracts\Support\Arrayable;

abstract class TelegramObject implements Arrayable
{
    protected object $properties;

    private function __construct(array $data)
    {
        $this->properties = json_decode(json_encode($data, JSON_FORCE_OBJECT), false);
    }

    public static function make(array $data): static
    {
        return new static($data);
    }

    public function __get(string $name)
    {
        return data_get($this->properties, $name);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return (array) $this->properties;
    }
}