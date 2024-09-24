<?php

namespace App\Notifications;

use App\Notifications\Channels\ZiperWhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class OrderDeleted extends Notification
{
    use Queueable;
    protected $order;
    protected $orderItem;
    /**
     * Create a new notification instance.
     */
    public function __construct($order,$orderItem)
    {
        $this->order = $order;
        $this->orderItem = $orderItem;
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
            'title' => __('translation.order_item_cancelled',['order'=> $this->order->id]),
            'message' => __('translation.order_cancelled_message',['category' => $this->order->category->name, 'room' => $this->order->room->room_no, 'item'=>$this->orderItem->item->name]),
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
            'title' => __('translation.order_item_cancelled', ['order'=> $this->order->id]),
            'message' => __('translation.order_cancelled_message',['category' => $this->order->category->name, 'room' => $this->order->room->room_no, 'item'=>$this->orderItem->item->name]),
            'url' => route('backend.order.index', ['categoryId'=>$this->order->category_id,'oid'=>$this->order->id]),
        ];
    }

    public function toZiperWhatsApp($notifiable)
    {
        $url = route('backend.order.index', ['categoryId'=>$this->order->category_id,'oid'=>$this->order->id]);
        $message = html_entity_decode(__('translation.whatsapp_cancelled_message',['category' => $this->order->category->name, 'room' => $this->order->room->room_no,'first_name' => $notifiable->first_name, 'last_name' => $notifiable->last_name, 'url' => $url, 'item'=>$this->orderItem->item->name]));
        return $message;
    }
}
