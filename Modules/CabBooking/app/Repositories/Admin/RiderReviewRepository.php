<?php

namespace Modules\CabBooking\Repositories\Admin;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ExceptionHandler;
use Modules\CabBooking\Models\RiderReview;
use Prettus\Repository\Eloquent\BaseRepository;

class RiderReviewRepository extends BaseRepository
{
    function model()
    {
        return RiderReview::class;
    }

    public function index($riderReviewTable)
    {
        if (request()['action']) {
            return redirect()->back();
        }

        return view('cabbooking::admin.rider-review.index', ['tableConfig' => $riderReviewTable]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $riderReview = $this->model->findOrFail($id);
            $riderReview->destroy($id);

            DB::commit();
            return to_route('admin.rider-review.index')->with('success', __('cabbooking::static.reviews.delete_successfully'));
        } catch (Exception $e) {

            DB::rollback();
            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    public function restore($id)
    {
        try {

            $riderReview = $this->model->onlyTrashed()->findOrFail($id);
            $riderReview->restore();

            return redirect()->back()->with('success', __('cabbooking::static.reviews.restore_successfully'));
        } catch (Exception $e) {

            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

    public function forceDelete($id)
    {
        try {

            $riderReview = $this->model->onlyTrashed()->findOrFail($id);
            $riderReview->forceDelete();

            return redirect()->back()->with('success', __('cabbooking::static.reviews.permanent_delete_successfully'));
        } catch (Exception $e) {

            throw new ExceptionHandler($e->getMessage(), $e->getCode());
        }
    }

}   