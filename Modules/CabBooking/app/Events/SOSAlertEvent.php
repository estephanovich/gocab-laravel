<?php

namespace Modules\CabBooking\Events;

use Modules\CabBooking\Models\Ride;
use Modules\CabBooking\Models\SOSAlert;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SOSAlertEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sos;
    public $ride;

    public function __construct(Ride $ride, SOSAlert $sos)
    {
        $this->ride = $ride;
        $this->sos  = $sos;
    }

    public function broadcastOn(): array
    {
        return [];
    }
}
