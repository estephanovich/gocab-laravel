<?php

namespace Modules\CabBooking\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Modules\CabBooking\Repositories\Front\ChatRepository;

class ChatController extends Controller
{
  public $repository;
    /**
     * Display a listing of the resource.
     */
    public function __construct(ChatRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      return $this->repository->index();
    }
    
}
