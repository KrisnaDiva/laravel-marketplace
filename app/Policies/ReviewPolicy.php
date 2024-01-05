<?php

namespace App\Policies;

use App\Models\OrderDetail;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Create a new policy instance.
     */
    public function create(User $user, OrderDetail $orderDetail)
    {
        return $orderDetail->order &&
        $user->id == $orderDetail->order->user_id &&
        $orderDetail->order->has_paid == 1 &&
        !$orderDetail->review;
    }
    public function update(User $user, OrderDetail $orderDetail)
    {
        return $orderDetail->order &&
        $user->id == $orderDetail->order->user_id &&
        $orderDetail->order->has_paid == 1 &&
        $orderDetail->review;
    }
}
