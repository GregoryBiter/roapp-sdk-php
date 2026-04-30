<?php

namespace Gbit\Roapp\Request;

class OrderGet{

public function toRequest() {
    return [
        'query' => $data,
        'body' => $data->body,
        ]
        ;
}
}

