<?php

namespace App\Policies;

use App\Models\Designer;
use Illuminate\Auth\Access\HandlesAuthorization;

class DesignerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any designers.
     *
     * @param  \App\Models\Designer $user
     * @return mixed
     */
    public function viewAny(Designer $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the designer.
     *
     * @param  \App\Models\Designer $user
     * @param  \App\Models\Designer $designer
     * @return mixed
     */
    public function view(Designer $user, Designer $designer)
    {
        return $user->id == $designer->id;
    }

    /**
     * Determine whether the user can create designers.
     *
     * @param  \App\Models\Designer $user
     * @return mixed
     */
    public function create(Designer $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the designer.
     *
     * @param  \App\Models\Designer $user
     * @param  \App\Models\Designer $designer
     * @return mixed
     */
    public function update(Designer $user, Designer $designer)
    {
        return $user->id == $designer->id;
    }

    /**
     * Determine whether the user can delete the designer.
     *
     * @param  \App\Models\Designer $user
     * @param  \App\Models\Designer $designer
     * @return mixed
     */
    public function delete(Designer $user, Designer $designer)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the designer.
     *
     * @param  \App\Models\Designer $user
     * @param  \App\Models\Designer $designer
     * @return mixed
     */
    public function restore(Designer $user, Designer $designer)
    {
        return $user->id == $designer->id;
    }

    /**
     * Determine whether the user can permanently delete the designer.
     *
     * @param  \App\Models\Designer $user
     * @param  \App\Models\Designer $designer
     * @return mixed
     */
    public function forceDelete(Designer $user, Designer $designer)
    {
        return false;
    }
}
