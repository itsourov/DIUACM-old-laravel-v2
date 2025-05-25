<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserSolveStatOnEvent;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserSolveStatOnEventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_user::solve::stat::on::event');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserSolveStatOnEvent $userSolveStatOnEvent): bool
    {
        return $user->can('view_user::solve::stat::on::event');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_user::solve::stat::on::event');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserSolveStatOnEvent $userSolveStatOnEvent): bool
    {
        return $user->can('update_user::solve::stat::on::event');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserSolveStatOnEvent $userSolveStatOnEvent): bool
    {
        return $user->can('delete_user::solve::stat::on::event');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_user::solve::stat::on::event');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, UserSolveStatOnEvent $userSolveStatOnEvent): bool
    {
        return $user->can('force_delete_user::solve::stat::on::event');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_user::solve::stat::on::event');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, UserSolveStatOnEvent $userSolveStatOnEvent): bool
    {
        return $user->can('restore_user::solve::stat::on::event');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_user::solve::stat::on::event');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, UserSolveStatOnEvent $userSolveStatOnEvent): bool
    {
        return $user->can('replicate_user::solve::stat::on::event');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_user::solve::stat::on::event');
    }
}
