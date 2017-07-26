<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Entities\InvoiceItem;
class ProductPurchased extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public $item;
     public $data;
    public function __construct(InvoiceItem $item)
    {
        $this->item=$item;
        $this->data=['message'=>$this->item->buyer->account.'已經買下'.$this->item->item_total_qty.'個'.$this->item->product->name,
        'avatar'=>$this->item->buyer->avatar
        ];
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
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', 'https://laravel.com')
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
   
    public function toBroadcast($notifiable)
{
    return new \App\Events\ProductPurchasedEvent(['data'=>$this->data]);
       
}
     public function toDatabase($notifiable)
    {
        return $this->data;
    }
}
