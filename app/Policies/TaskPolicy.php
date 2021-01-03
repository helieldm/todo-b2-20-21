<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return Auth::user() == $user;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function view(User $user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Board $board
     * @return mixed
     */
    public function create(User $user, Board $board)
    {
        return (Auth::user() == $user && $board->users->find($user->id));
    }

    /**
     * Le but de cette fonction est de voir quels utilisateurs ont les droit sur la modification  de
     * la tache (sauf le statut)
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
       return( $task->board->users->find($user->id) != null || $task->participants->find($user->id) != null);
    }

    /**
     * Le but de cette fonction est de voir quels utilisateurs ont les droit sur la modification du statut de
     * la tache.
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function updateStatus(User $user, Task $task){
        return($task->assignedUsers->find($user->id) != null);
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        return( $task->board->owner == $user || $task->participants->find($user->id) != null);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function restore(User $user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function forceDelete(User $user, Task $task)
    {
        //
    }
}
