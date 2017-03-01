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
        $rules = [
            'item' => 'array|min:1',
        ];

        // origin Address rules

        $rules['item.origin.streetAddress'] = 'required|string|max:255' ;
        $rules['item.origin.majorMunicipality'] = 'required|string|max:255' ;
        $rules['item.origin.postalCode'] = 'required|string|max:255' ;
        $rules['item.origin.stateProvince'] = 'required|string|max:255' ;
        $rules['item.origin.country'] = 'required|string|max:255' ;
        $rules['item.origin.AddressType'] = 'required|string|max:255' ;
        $rules['item.origin.earliestArrival'] = 'required|date' ;
        $rules['item.origin.latestArrival'] = 'required|date' ;
        $rules['item.origin.name'] = 'required|string|max:255' ;
        $rules['item.origin.companyName'] = 'required|string|max:255' ;
        $rules['item.origin.phoneNumber'] = 'required|string|max:255' ;

        // destination Addres rules

        $rules['item.destination.postalCode'] = 'required|string|max:255' ;
        $rules['item.destination.country'] = 'required|string|max:255' ;
        $rules['item.destination.AddressType'] = 'required|string|max:255' ;

        // items rules

        for ($i = 0; $i < $count; $i++) {
            $rules['items.'.$i.'.Commodity'] = 'required|string|max:255';
            $rules['items.'.$i.'.unitCount'] = 'required|integer|max:50';
            $rules['items.'.$i.'.packaging'] = 'required|string|max:255';
            $rules['items.'.$i.'.lengthInMeters'] = 'required|numeric';
            $rules['items.'.$i.'.heightInMeters'] = 'required|numeric';
            $rules['items.'.$i.'.lbs'] = 'required|numeric';
            $rules['items.'.$i.'.freightClass'] = 'required|numeric';
            $rules['items.'.$i.'.handlingUnit'] = 'required|string|max:255';
        }

        return $rules;
    }
    public function returnJson($request)
    {

    }
}

?>
