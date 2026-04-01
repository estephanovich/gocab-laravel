<?php

namespace Modules\CabBooking\Console;

use DB;
use Carbon\Carbon;
use App\Models\Blog;
use Illuminate\Console\Command;
use Modules\CabBooking\Models\Ride;
use Modules\CabBooking\Models\PeakZone;
use Modules\CabBooking\Models\RideRequest;
use Modules\CabBooking\Models\WithdrawRequest;
use Symfony\Component\Console\Input\InputOption;
use Modules\CabBooking\Enums\ServiceCategoryEnum;
use Symfony\Component\Console\Input\InputArgument;
use Modules\CabBooking\Models\CabCommissionHistory;

class UpdateDateCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'cabbooking:date-update';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rides = Ride::whereNull('deleted_at')?->get();
        $rideRequests = RideRequest::whereNull('deleted_at')?->get();
        foreach($rides as $ride) {
            if($ride?->service_category?->slug != ServiceCategoryEnum::SCHEDULE) {
                $ride->created_at = Carbon::now()?->subDays(rand(1, 2));
                $ride->save();
                CabCommissionHistory::where('ride_id', $ride?->id)->update([
                   'created_at' => $ride?->created_at
                ]);

            } else {
                $ride->created_at = Carbon::now()?->addDays(rand(1, 2));
                $ride->save();
            }
        }

        foreach($rideRequests as $rideRequest) {
            if($rideRequest?->service_category?->slug != ServiceCategoryEnum::SCHEDULE) {
                $rideRequest->created_at = Carbon::now()?->subDays(rand(1, 2));
                $rideRequest->save();
            } else {
                $ride->created_at = Carbon::now()?->addDays(rand(1, 2));
                $ride->save();
            }
        }

        $peakZones = PeakZone::whereNull('deleted_at')?->get();
        foreach($peakZones as $peakZone) {
            $peakZone->created_at = Carbon::now()?->addDays(rand(1, 2));
            $peakZone->save();
        }

        $users = DB::table('users')?->whereNull('deleted_at')?->get();
        foreach($users as $user) {
            DB::table('users')?->where('id', $user?->id)
                ->update([
                    'created_at' => Carbon::now()?->addDays(rand(1, 2)),
                ]);
        }

        $withdrawRequests = WithdrawRequest::whereNull('deleted_at')?->get();
        foreach($withdrawRequests as $withdrawRequest) {
            $withdrawRequest->created_at = Carbon::now()?->addDays(rand(1, 2));
            $withdrawRequest->save();
        }

        $blogs = Blog::whereNull('deleted_at')?->get();
        foreach($blogs as $blog) {
            $blog->created_at = Carbon::now()?->addDays(rand(1, 2));
            $blog->created_by_id = 1;
            $blog->save();
        }

        $this->info('cabbooking date updated successfully.');
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
