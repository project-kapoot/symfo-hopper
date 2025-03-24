<?php

namespace App\Enum;

enum Status: string
{
    case PENDING = 'pending';
    case STARTED = 'started';
    case FINISHED = 'finished';
}
