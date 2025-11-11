<?php

namespace App\Enums\GRH;

enum TypeLeaveEntitlements: string
{
    case CONGES = 'conges';
    case RTT = 'rtt';
    case MALADIE = 'maladie';
    case INJUSTIFIABLE = 'injustifiable';
}
