<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case NEW = 'NEW';
    case SENT = 'SENT';
    case PAID = 'PAID';
}
