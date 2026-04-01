<?php

namespace Modules\CabBooking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CabBookingSetting extends Model
{
    use HasFactory;

    /**
     * The values that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'cabbooking_values',
    ];

    protected $casts = [
        'cabbooking_values' => 'json',
    ];

    protected $visible = [
        'cabbooking_values'
    ];

    public function getCabBookingValuesAttribute($value)
    {
        $values = json_decode($value, true);
        return $values;
    }
}
