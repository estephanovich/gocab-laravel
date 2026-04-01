<?php

namespace Modules\CabBooking\Repositories\Admin;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ExceptionHandler;
use App\Http\Traits\FireStoreTrait;
use Modules\CabBooking\Models\CabBookingSetting;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Prettus\Repository\Eloquent\BaseRepository;

class SettingRepository extends BaseRepository
{
    use FireStoreTrait;

    public function model()
    {
        return CabBookingSetting::class;
    }

    public function index()
    {
        $settings = getCabBookingSettings();

        $settings['setting']['splash_screen'] = getMedia($settings['setting']['splash_screen_id'] ?? null);
        $settings['setting']['driver_splash_screen'] = getMedia($settings['setting']['splash_driver_screen_id'] ?? null);

        return view('cabbooking::admin.cabbooking-setting.index', [
            'cabbookingsettings' => $settings,
            'id' => $this->model->pluck('id')->first(),
        ]);
    }

    public function resetRideRequest()
    {
        $rideRequests = $this->fireStoreQueryCollection('ride_requests');
        $driverRideRequest = $this->fireStoreQueryCollection('driver_ride_requests');
        foreach($rideRequests as $rideRequestDoc) {
            if(isset($rideRequestDoc['id'])) {
                $this->fireStoreDeleteDocument('ride_requests', $rideRequestDoc['id']);
            }
        }

        foreach($driverRideRequest as $driverRideRequestDoc) {
            if(isset($driverRideRequestDoc['id'])) {
                $this->fireStoreDeleteDocument('driver_ride_requests', $driverRideRequestDoc['id']);
            }
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            $cabbookingSettings = $this->model->findOrFail($id);

            $fields = [
                'general' => ['ambulance_image', 'ambulance_map_icon'],
            ];

            foreach ($fields as $section => $imageFields) {
                $this->processFields($request, $cabbookingSettings, $section, $imageFields);
            }

            $request = array_diff_key($request, array_flip(['_token', '_method']));

            // Validate referral settings if present
            if (isset($request['referral'])) {
                $this->validateReferralSettings($request['referral']);
            }

            $cabbookingSettingsValue = $cabbookingSettings->cabbooking_values;
            $request['location']['google_map_api_key'] = decryptKey($request['location']['google_map_api_key']);
            $cabbookingSettings->update([
                'cabbooking_values' => $request,
            ]);

            if($cabbookingSettingsValue['activation']['bidding'] != $request['activation']['bidding']) {
                $this->resetRideRequest();
            }

            DB::commit();
            $this->env($request);
            return to_route('admin.cabbooking-setting.index')->with('success', __('static.settings.update_successfully'));

        } catch (Exception $e) {
            DB::rollback();
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    private function validateReferralSettings(array $referralSettings): void
    {
        if (isset($referralSettings['minimum_ride_amount'])) {
            $minRideAmount = (float) $referralSettings['minimum_ride_amount'];
            if ($minRideAmount < 0) {
                throw new Exception(__('cabbooking::static.validation.minimum_ride_amount_positive'));
            }
        }

        if (isset($referralSettings['referrer_bonus_percentage'])) {
            $referrerPercentage = (float) $referralSettings['referrer_bonus_percentage'];
            if ($referrerPercentage < 0 || $referrerPercentage > 100) {
                throw new Exception(__('cabbooking::static.validation.referrer_bonus_percentage_range'));
            }
        }

        if (isset($referralSettings['referred_bonus_percentage'])) {
            $referredPercentage = (float) $referralSettings['referred_bonus_percentage'];
            if ($referredPercentage < 0 || $referredPercentage > 100) {
                throw new Exception(__('cabbooking::static.validation.referred_bonus_percentage_range'));
            }
        }
    }

    public function env($cabbooking_values)
    {
        try {
            if (isset($cabbooking_values['location']['google_map_api_key'])){
                $google_map_api_key = $cabbooking_values['location']['google_map_api_key'];
                DotenvEditor::setKeys([
                    'GOOGLE_MAP_API_KEY' => $google_map_api_key,
                ]);

                DotenvEditor::save();
            }
        } catch (Exception $e) {

            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    private function processFields(&$request, $cabbookingSettings, $section, array $fields)
    {
        foreach ($fields as $field) {
            $requestValue = $request[$section][$field] ?? null;

            if ($requestValue) {
                $media = $this->storeImage($requestValue);
                $request[$section][$field] = $media->asset_url;
            } else {
                $request[$section][$field] = $cabbookingSettings->cabbooking_values[$section][$field] ?? null;
            }
        }
    }

    public function storeImage($request)
    {
        $attachments = createAttachment();
        $media = addMedia($attachments, $request);

        $attachments->delete($attachments?->id);
        return $media;
    }

}
