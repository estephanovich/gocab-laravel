<?php

namespace Modules\CabBooking\Policies;

use App\Models\User;
use Modules\CabBooking\Models\ServiceCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if ($user->can('service_category.index')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  Modules\CabBooking\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ServiceCategory $serviceCategory)
    {
        if ($user->can('service_category.index')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  Modules\CabBooking\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ServiceCategory $serviceCategory)
    {
        if ($user->can('service_category.edit')) {
            return true;
        }
    }
}
