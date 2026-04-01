<?php

namespace Modules\CabBooking\Policies;

use App\Models\User;
use Modules\CabBooking\Models\Service;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{

    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        if ($user->can('service.index')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Service $service)
    {
        if ($user->can('service.index')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service)
    {
        if ($user->can('service.edit')) {
            return true;
        }
    }
}
