<?php

namespace Modules\CabBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\CabBooking\Models\CabCommissionHistory;
use Modules\CabBooking\Tables\CabCommissionHistoryTable;
use Modules\CabBooking\Repositories\Admin\CabCommissionHistoryRepository;

class CabCommissionHistoryController extends Controller
{
    public $repository;

    public function __construct(CabCommissionHistoryRepository $repository)
    {
        $this->authorizeResource(CabCommissionHistory::class, 'cab_commission_history');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CabCommissionHistoryTable $cabCommissionHistoryTable)
    {
        return $this->repository->index($cabCommissionHistoryTable->generate());
    }
}
