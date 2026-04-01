<?php

namespace Modules\CabBooking\Enums;

enum RequestEnum: string
{
    const PENDING = 'pending';

    const APPROVED = 'approved';

    const REJECTED = 'rejected';
}

