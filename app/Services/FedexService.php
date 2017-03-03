<?php
/**
* User: Starin
* Date: 06/27/17
*/

namespace App\Services;

use App\Contracts\ShippingServiceInterface;

class FedexService implements ShippingServiceInterface
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
    public function returnData($request)
    {
    }
    public function call($fedex){
        $url = 'https://sandbox-api.postmen.com/v3/rates';
       $method = 'POST';
       $headers = array(
           "content-type: application/json",
           "postmen-api-key: 8fc7966b-679b-4a57-911d-c5a663229c9e"
       );
       $body = '{"async":false,"shipper_accounts":[{"id":"starinit"}],"is_document":false,"shipment":{"ship_from":{"contact_name":"Elmira Zulauf","company_name":"Kemmer-Gerhold","street1":"662 Flatley Manors","country":"HKG","type":"business"},"ship_to":{"contact_name":"Dr. Moises Corwin","phone":"1-140-225-6410","email":"Giovanna42@yahoo.com","street1":"28292 Daugherty Orchard","city":"Beverly Hills","postal_code":"90209","state":"CA","country":"USA","type":"residential"},"parcels":[{"description":"Food XS","box_type":"custom","weight":{"value":2,"unit":"kg"},"dimension":{"width":20,"height":40,"depth":40,"unit":"cm"},"items":[{"description":"Food Bar","origin_country":"USA","quantity":2,"price":{"amount":3,"currency":"USD"},"weight":{"value":0.6,"unit":"kg"},"sku":"imac2014"}]}]}}';

       $curl = curl_init();

       curl_setopt_array($curl, array(
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_URL => $url,
           CURLOPT_CUSTOMREQUEST => $method,
           CURLOPT_HTTPHEADER => $headers,
           CURLOPT_POSTFIELDS => $body,
           CURLOPT_SSL_VERIFYPEER => false
       ));

       $response = curl_exec($curl);
       $err = curl_error($curl);

       curl_close($curl);

       if ($err) {
           echo "cURL Error #:" . $err;
       } else {
           print_r($response); exit;
       }

    }
}

?>
