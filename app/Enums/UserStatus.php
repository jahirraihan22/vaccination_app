<?php

namespace App\Enums;

enum UserStatus: string
{
    case NOT_REGISTERED = 'Not registered';
    case NOT_SCHEDULED = 'Not Scheduled';
    case SCHEDULED = 'Scheduled';
    case VACCINATED = 'Vaccinated';
}
