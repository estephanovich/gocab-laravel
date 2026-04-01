<?php

namespace Modules\CabBooking\Database\Seeders;

use Illuminate\Database\Seeder;

class DefaultImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultImagePaths = [
            'cab.png',
            'ambulance.png',
            'cab-icon.svg',
            'parcel-icon.svg',
            'freight-icon.svg',
            'outstation-banner.png',
            'package.png',
            'parcel.png',
            'freight.png',
            'outstation-image.png',
            'parcel.svg',
            'rental.svg',
            'splash.png',
            'splash_driver.png',
            'intercity-cab.png',
            'intercity-freight.png',
            'intercity-parcel.png',
            'package-cab.png',
            'rental-cab.png',
            'ride-cab.png',
            'ride-freight.png',
            'ride-parcel.png',
            'schedule-cab.png',
            'schedule-freight.png',
            'schedule-parcel.png',
            'ambulance-1.png',
            'cab1.png',
            'bike.png',
            'top-bike.png',
            'auto.png',
            'top-auto.png',
            'car.png',
            'top-car.png',
            'prime.png',
            'top-primecar.png',
            'cargo-van.png',
            'top-cargovan.png',
            'bolero.png',
            'top-bolero.png',
            'Chota-hathi.png',
            'top-chhota-hathi.png',
            'tempo.png',
            'top-tempo.png',
            'truck.png',
            'top-truck.png',
            'big-truck.png',
            'top-big-truck.png',

          
        
        ];

        $imageDirectory = module_path('CabBooking', 'resources/assets/images/defaults');
        $attachments = createAttachment();
        foreach ($defaultImagePaths as $defaultImagePath) {
            $fullImagePath = $imageDirectory . '/' . $defaultImagePath;
            if (file_exists($fullImagePath)) {
                $attachments->copyMedia($fullImagePath)->toMediaCollection('attachment');
            }
        }

        $attachments->delete($attachments?->id);
    }
}
