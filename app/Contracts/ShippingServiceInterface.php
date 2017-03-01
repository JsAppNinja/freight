<?php

namespace App\Contracts;

interface ShippingServiceInterface {
    public function getRule($count);
    public function returnJson($data);
    public function call($data);
}
