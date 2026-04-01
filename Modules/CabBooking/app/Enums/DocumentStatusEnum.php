<?php

namespace Modules\CabBooking\Enums;

enum DocumentStatusEnum: string
{
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';
}

