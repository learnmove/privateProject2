<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use App\Entities\ChatList;
use App\Entities\User;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
  Broadcast::routes(['middleware' => ['jwt.auth']]);


+   require base_path('routes/channels.php');

        /*
         * Authenticate the user's personal channel...
         */

        // Broadcast::channel('App.User.*', function ($user, $userId) {
        //     return (int) $user->id === (int) $userId;
        // });

                Broadcast::channel('chat_lists.*', function ($user, $chatlist) {
        
             $result=$user->id===ChatList::find($chatlist)->user_id||$user->id===ChatList::find($chatlist)->chat_id? true:'';
             return $result;
            
            
        });
    }
}
