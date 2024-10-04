<?php

namespace Larowka\SupportBot\Enums;

enum File: int
{
    case PHOTO = 0;

    case AUDIO = 1;

    case DOCUMENT = 2;

    case VIDEO = 3;

    case ANIMATION = 4;

    case VOICE = 5;

    case STICKER = 6;

    case VIDEO_NOTE = 7;
}