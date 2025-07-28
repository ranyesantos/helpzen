<?php

namespace App\Enums;

enum ServiceRequestStatusType : string
{
    case Pending = 'pending';
    case Done = 'done';
    case Canceled = 'canceled';
    case In_Progress = 'in_progress';
}
