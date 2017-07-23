<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendChatMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:message {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Messagew';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user=\App\Entities\User::first();
        $message=\App\Entities\PrivateMessage::create(
             [ 'sender_id'=>1,
           'receiver_id'=>$user->id,
           'read'=>0,
         'message'=>$this->argument('message')]);
         event(new \App\Events\MessagePosted($user,$message));
    }
}
