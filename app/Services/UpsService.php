<?php
/**
* User: Starin
* Date: 06/27/17
*/

namespace App\Services;

use App\Contracts\ShippingServiceInterface;

class UpsService implements ShippingServiceInterface
{
    public function getRule($count)
    {
        return [
            'item["streetAddress"]' => 'required|string|max:255',
            'item["alternateStreetAddress"]' => 'required|string|max:255',
            'item["majorMunicipality"]' => 'required|string|max:255',
            'item["postalCode"]' => 'required|string|max:255',
            'item["stateProvince"]' => 'required|string|max:255',
            'item["country"]' => 'required|string|max:255',
            'item["AddressType"]' => 'required|string|max:255',
            'item["earliestArrival"]' => 'required|date|after:tomorrow',
            'item["earliestArrival"]' => 'required|date|after:item["earliestArrival"]',
            'item["name"]' => 'required|string|max:255',
            'item["companyName"]' => 'required|string|max:255',
            'item["phoneNumber"]' => 'required|integer|max:50',
            'Commodity' => 'required|string|max:255',
            'unitCount' => 'required|integer|max:50',
            'packaging' => 'required|string|max:255',
            'lengthInMeters' => 'required|numeric|min:2|max:5',
            'heightInMeters' => 'required|numeric|min:2|max:5',
            'lbs' => 'required|numeric|min:2|max:5',
            'freightClass' => 'required|numeric|min:2|max:5',
            'handlingUnit' => 'required|string|max:255',
        ];
    }
    public function call($data)
    {

    }
}

?>
