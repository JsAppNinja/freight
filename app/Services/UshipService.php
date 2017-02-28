<?php
/**
* User: Starin
* Date: 06/27/17
*/

namespace App\Services;

use App\Contracts\ShippingServiceInterface;

class UshipService implements ShippingServiceInterface
{
   /**
    *  @param integer
    *  @return Array
    *
    *  Request data Validation rules
    *
    */

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

    /**
     *  @param Array
     *  make uship request body, call uship Api
     *
     */

    public function call($request)
    {
        $uship = array();
        $address = array();
        $count = $request->get('count');

        // Origin Address

        $origin['streetAddress'] = $request->item['origin']['streetAddress'];
        $origin['alternateStreetAddress'] = $request->item['origin']['alternateStreetAddress'];
        $origin['majorMunicipality'] = $request->item['origin']['majorMunicipality'];
        $origin['postalCode'] = $request->item['origin']['postalCode'];
        $origin['stateProvince'] = $request->item['origin']['stateProvince'];
        $origin['country'] = $request->item['origin']['country'];
        $origin['AddressType'] = $request->item['origin']['AddressType'];

        // Origin TimeFrame

        $origin['earliestArrival'] = $request->item['origin']['earliestArrival'];
        $origin['latestArrival'] = $request->item['origin']['latestArrival'];
        $origin['timeFrameType'] = $request->item['origin']['timeFrameType'];

        // Origin attributes

        $origin['inside'] = $request->item['origin']['inside'];
        $origin['liftgateRequired'] = $request->item['origin']['liftgateRequired'];
        $origin['callBeforeArrival'] = $request->item['origin']['callBeforeArrival'];
        $origin['appointmentRequired'] = $request->item['origin']['appointmentRequired'];

        // Origin Contacts

        $origin['name'] = $request->item['origin']['name'];
        $origin['companyName'] = $request->item['origin']['companyName'];
        $origin['phoneNumber'] = $request->item['origin']['phoneNumber'];

        // Desitination Address

        $destination['postalCode'] = $request->item['destination']['postalCode'];
        $destination['country'] = $request->item['destination']['country'];
        $destination['AddressType'] = $request->item['destination']['AddressType'];

        // Desitination attributes

        $destination['inside'] = $request->item['destination']['inside'];
        $destination['liftgateRequired'] = $request->item['destination']['liftgateRequired'];
        $destination['callBeforeArrival'] = $request->item['destination']['callBeforeArrival'];
        $destination['appointmentRequired'] = $request->item['destination']['appointmentRequired'];

        // Destination Contacts

        $destination['name'] = $request->item['destination']['name'];
        $destination['companyName'] = $request->item['destination']['companyName'];
        $destination['phoneNumber'] = $request->item['destination']['phoneNumber'];

        for ( $i = 0; $i < $count; $i++) {
            $commodity[$i] = $request->items[$i]['Commodity'];
            $unitCount[$i] = $request->items[$i]['unitCount'];
            $packaging[$i] = $request->items[$i]['packaging'];
            $lbs[$i] = $request->items[$i]['lbs'];
            $freightClass[$i] = $request->items[$i]['freightClass'];
            $stackable[$i] = $request->items[$i]['stackable'];
            $hazardous[$i] = $request->items[$i]['hazardous'];
        }

        //Attributes
        $protectfromFreezing = $request->protectfromFreezing;
        $sortandSegregate = $request->sortandSegregate;
        $blindShipmentCoordination =$request->blindShipmentCoordination;

        // Route/item Array

        array_push($address,$origin);
        array_push($address,$destination);
        $route['Items'] = $address;
        // Items Array

        for ( $i = 0; $i < $count; $i++) {
            $items[$i]['Commodity'] = $commodity[$i];
            $items[$i]['unitCount'] = $unitCount[$i];
            $items[$i]['packaging'] = $packaging[$i];
            $items[$i]['lbs'] = $lbs[$i];
            $items[$i]['freightClass'] = $freightClass[$i];
            $items[$i]['stackable'] = $stackable[$i];
            $items[$i]['hazardous'] = $hazardous[$i];
        }

        // Attributs Array
        $attributes['protectfromFreezing'] = $protectfromFreezing;
        $attributes['sortandSegregate'] = $sortandSegregate;
        $attributes['blindShipmentCoordination'] = $blindShipmentCoordination;

        $uship['route'] = $route;
        $uship['items'] = $items;
        $uship['attributes'] = $attributes;
        print_r(response()->json($uship)); exit;
    }
}
?>
