<?php

namespace App\Enums;

enum CashierType: string
{
    case CASHIER = 'cashier';
    case ACCESS = 'access';
    case ONLINE = 'online';
    case CALLCENTER = 'call-center';
    case COORDINATOR = 'coordinator';
    case TOURS = 'tours';
    case BOOKSHOP = 'bookshop';

}