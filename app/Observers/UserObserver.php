<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $roleUser = \App\Models\Role::query()->where('name', '=', 'user')->firstOrFail();
        $roleSubscriber = \App\Models\Role::query()->where('name', '=', 'subscriber')->firstOrFail();

        $user->attachRole($roleUser);
        if($user->balance > 0){
            $user->attachRole($roleSubscriber);
        }
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $roleSubscriber = \App\Models\Role::query()->where('name', '=', 'subscriber')->firstOrFail();

        if($user->balance > 0 and !$user->isA('subscriber')){
            $user->attachRole($roleSubscriber);
        } else {
            $user->detachRole($roleSubscriber);
        }
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
