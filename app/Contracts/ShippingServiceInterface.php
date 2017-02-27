<?php

namespace App\Contracts;

interface ShippingServiceInterface {
    public function getRule($count);
    public function call($data);
}
