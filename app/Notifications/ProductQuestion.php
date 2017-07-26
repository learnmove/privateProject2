<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Entities\Product;
use App\Entities\User;
class ProductQuestion extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
     protected $data;
    public function __construct($product_id,$account,$content)
    {
        $product=Product::find($product_id);
        $user=User::where('account',$account)->first();
        $this->data=['message'=>$account.'詢問你的產品【'.$product->name.'】'.$content,
        'avatar'=>$user->avatar];;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
 

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toBroadcast($notifiable)
{
    return new \App\Events\ProductQuestionEvent(['data'=>$this->data]);
       
}
     public function toDatabase($notifiable)
    {
        return $this->data;
    }
}
