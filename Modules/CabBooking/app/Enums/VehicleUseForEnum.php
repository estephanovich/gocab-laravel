<?php

namespace Modules\CabBooking\Enums;

  enum VehicleUseForEnum:string {
    case RIDE = 'ride';
    case PARCEL = 'parcel';
    case FREIGHT = 'freight';
    case INTERCITY = 'intercity';
    case RENTAL = 'rental';
  }
