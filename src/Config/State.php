<?php

namespace App\Config;

enum State: string
{
    case Created = 'Created';
    case Pending = 'Pending';
    case Rejected = 'Rejected';
    case Done = 'Done';
}