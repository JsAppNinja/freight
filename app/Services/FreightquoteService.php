<?php
/**
* User: Starin
* Date: 03/27/17
*/

namespace App\Services;

use App\Contracts\ShippingServiceInterface;
use SoapClient;

class FreightquoteService implements ShippingServiceInterface
{

    protected $hazardous = false;

    public function getRule($count)
    {
        $rules = [
            'item' => 'array|min:1',
        ];

        // origin Address rules

        // $rules['item.origin.streetAddress'] = 'required|string|max:255' ;
        // $rules['item.origin.majorMunicipality'] = 'required|string|max:255' ;
        $rules['item.origin.postalCode'] = 'required|string|max:255' ;
        // $rules['item.origin.stateProvince'] = 'required|string|max:255' ;
        $rules['item.origin.country'] = 'required|string|max:255' ;
        $rules['item.origin.name'] = 'required|string|max:255' ;
        // $rules['item.origin.companyName'] = 'required|string|max:255' ;
        $rules['item.origin.phoneNumber'] = 'required|string|max:255' ;

        // destination Addres rules

        // $rules['item.destination.streetAddress'] = 'required|string|max:255' ;
        // $rules['item.destination.majorMunicipality'] = 'required|string|max:255' ;
        $rules['item.destination.postalCode'] = 'required|string|max:255' ;
        // $rules['item.destination.stateProvince'] = 'required|string|max:255' ;
        $rules['item.destination.country'] = 'required|string|max:255' ;
        $rules['item.destination.name'] = 'required|string|max:255' ;
        // $rules['item.destination.companyName'] = 'required|string|max:255' ;
        $rules['item.destination.phoneNumber'] = 'required|string|max:255' ;

        //Attributes
        $rules['item.isBlind'] = 'required|string|max:255' ;
        $rules['item.quoteType'] = 'required|string|max:255' ;
        $rules['item.freightquoteServiceType'] = 'required|string|max:255' ;

        // items rules

        for ($i = 0; $i < $count; $i++) {
            // $rules['items.'.$i.'.class'] = 'required|string|max:255';
            $rules['items.'.$i.'.productDescription'] = 'required|string|max:255';
            $rules['items.'.$i.'.commodityType'] = 'required|string|max:255';
            $rules['items.'.$i.'.packageType'] = 'required|string|max:255';
            $rules['items.'.$i.'.contentType'] = 'required|string|max:255';
            $rules['items.'.$i.'.unitCount'] = 'required|integer|max:50';
            $rules['items.'.$i.'.lengthInMeters'] = 'required|numeric';
            $rules['items.'.$i.'.widthInMeters'] = 'required|numeric';
            $rules['items.'.$i.'.heightInMeters'] = 'required|numeric';
            $rules['items.'.$i.'.lbs'] = 'required|numeric';
        }

        return $rules;
    }

    public function returnData($request)
    {
    }


}

?>
