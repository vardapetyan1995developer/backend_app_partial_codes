<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'SUPER_ADMIN';
    case ADMIN = 'ADMIN';
    case CLIENT = 'CLIENT';
    case WORKER = 'WORKER';
    case CONTACT = 'CONTACT';
}
