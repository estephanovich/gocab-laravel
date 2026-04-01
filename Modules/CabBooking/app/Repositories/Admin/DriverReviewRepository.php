<?php

namespace Modules\CabBooking\Repositories\Admin;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ExceptionHandler;
use Modules\CabBooking\Models\DriverReview;
use Prettus\Repository\Eloquent\BaseRepository;

class DriverReviewRepository extends BaseRepository
{
    function model()
    {
        return DriverReview::class;
    }

    public function index($driverReviewTable)
    {
        if (request()['action']) {
            return redirect()->back();
        }

        return view('cabbooking::admin.driver-review.index', ['tableConfig' => $driverReviewTable]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $driverReview = $this->model->findOrFail($id);
            $driverReview->destroy($id);

            DB::commit();
            return to_route('admin.driver-review.index')->with('success', __('cabbooking::static.reviews.delete_successfully'));
        } catch (Exception $e) {

            DB::rollback();
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    public function restore($id)
    {
        try {

            $driverReview = $this->model->onlyTrashed()->findOrFail($id);
            $driverReview->restore();

            return redirect()->back()->with('success', __('cabbooking::static.reviews.restore_successfully'));
        } catch (Exception $e) {

            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    public function forceDelete($id)
    {
        try {

            $driverReview = $this->model->onlyTrashed()->findOrFail($id);
            $driverReview->forceDelete();

            return redirect()->back()->with('success', __('cabbooking::static.reviews.permanent_delete_successfully'));
        } catch (Exception $e) {

            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

}
