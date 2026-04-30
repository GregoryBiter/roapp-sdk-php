<?php

namespace Gbit\Roapp\Models\Old;

use Gbit\Roapp\Models\Order;

trait ConnectModel 
{
    public function order() 
    {
        if($this->order == null) {
            $this->order = new Order($this->api);
        }
        return $this->order;
    }
}