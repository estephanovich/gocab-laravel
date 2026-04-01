<?php

namespace Modules\CabBooking\Events;

use Modules\CabBooking\Models\Driver;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class DriverVerificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $driver;

    public $status;

    public function __construct(Driver $driver, $status)
    {
        $this->driver = $driver;
        $this->status = $status;
    }
}
