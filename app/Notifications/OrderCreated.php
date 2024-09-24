<?php

namespace App\Notifications;

use App\Notifications\Channels\ZiperWhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class OrderCreated extends Notification
{
    use Queueable;
    protected $order;
    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', ZiperWhatsAppChannel::class];
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'title' => __('translation.new_order_created', ['order'=> $this->order->id]),
            'message' => __('translation.new_order_created_message',['category' => $this->order->category->name, 'room' => $this->order->room->room_no]),
            'url' => route('backend.order.index', ['categoryId'=>$this->order->category_id,'oid'=>$this->order->id]),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'title' => __('translation.new_order_created', ['order'=> $this->order->id]),
            'message' => __('translation.new_order_created_message',['category' => $this->order->category->name, 'room' => $this->order->room->room_no]),
            'url' => route('backend.order.index', ['categoryId'=>$this->order->category_id,'oid'=>$this->order->id]),
        ];
    }

    public function toZiperWhatsApp($notifiable)
    {
        $url = route('backend.order.index', ['categoryId'=>$this->order->category_id,'oid'=>$this->order->id]);
        $message = __('translation.whatsapp_created_message',['category' => $this->order->category->name, 'room' => $this->order->room->room_no,'first_name' => $notifiable->first_name, 'last_name' => $notifiable->last_name, 'url' => $url]);
        return $message;
    }
}
