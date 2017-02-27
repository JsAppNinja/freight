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
   * Request data Validation.
   *
   * @return response
   */

    public function getRule($count)
    {
        $rules = array();
        for ($i = 0; $i < $count; $i++ ) {
            $rules = [
                'item'.'['.$i.']'.'["streetAddress"]'.'['.$i.']' =>'required|string|max:255',
            ];
        }
        return $rules;
        // return [
        //     'item["streetAddress"][]' => 'required|string|max:255',
            // 'item["alternateStreetAddress"]' => 'required|string|max:255',
            // 'item["majorMunicipality"]' => 'required|string|max:255',
            // 'item["postalCode"]' => 'required|string|max:255',
            // 'item["stateProvince"]' => 'required|string|max:255',
            // 'item["country"]' => 'required|string|max:255',
            // 'item["AddressType"]' => 'required|string|max:255',
            // 'item["earliestArrival"]' => 'required|date|after:tomorrow',
            // 'item["latestArrival"]' => 'required|date|after:item["latestArrival"]',
            // 'item["name"]' => 'required|string|max:255',
            // 'item["companyName"]' => 'required|string|max:255',
            // 'item["phoneNumber"]' => 'required|integer|max:50',
            // 'Commodity' => 'required|string|max:255',
            // 'unitCount' => 'required|integer|max:50',
            // 'packaging' => 'required|string|max:255',
            // 'lengthInMeters' => 'required|numeric|min:2|max:5',
            // 'heightInMeters' => 'required|numeric|min:2|max:5',
            // 'lbs' => 'required|numeric|min:2|max:5',
            // 'freightClass' => 'required|numeric|min:2|max:5',
            // 'handlingUnit' => 'required|string|max:255',
        // ];
    }
    public function call($request)
    {
        $uship = array();
        //Address
        $streetAddress = $request->item['streetAddress'];
        $alternateStreetAddress = $request->item['alternateStreetAddress'];
        $majorMunicipality = $request->item['majorMunicipality'];
        $postalCode = $request->item['postalCode'];
        $stateProvince = $request->item['stateProvince'];
        $country = $request->item['country'];
        $AddressType = $request->item['AddressType'];

        //TimeFrame
        $earliestArrival = $request->item['earliestArrival'];
        $latestArrival = $request->item['latestArrival'];
        $timeFrameType = $request->item['timeFrameType'];

        //Item/Attributes
        $inside = $request->item['inside'];
        $liftgateRequired = $request->item['liftgateRequired'];
        $callBeforeArrival = $request->item['callBeforeArrival'];
        $appointmentRequired = $request->item['appointmentRequired'];

        //Contacts
        $name = $request->item['name'];
        $companyName = $request->item['companyName'];
        $phoneNumber = $request->item['phoneNumber'];

        //items
        $commodity = $request->Commodity;
        $unitCount = $request->unitCount;
        $packaging = $request->packaging;
        $lengthInMeters = $request->lengthInMeters;
        $heightInMeters = $request->heightInMeters;
        $lbs = $request->lbs;
        $freightClass = $request->freightClass;
        $stackable = $request->stackable;
        $hazardous = $request->hazardous;
        $handlingUnit = $request->handlingUnit;
        //Attributes
        $protectfromFreezing = $request->protectfromFreezing;
        $sortandSegregate = $request->sortandSegregate;
        $blindShipmentCoordination =$request->blindShipmentCoordination;

        //ThirdParty
        $thirdParty = $request->thirdParty;


        for ( $i = 0; $i < count($streetAddress); $i++) {
            //address
            $address[$i]['streetAddress'] = $streetAddress[$i];
            $address[$i]['alternateStreetAddress'] = $alternateStreetAddress[$i];
            $address[$i]['majorMunicipality'] = $majorMunicipality[$i];
            $address[$i]['postalCode'] = $postalCode[$i];
            $address[$i]['stateProvince'] = $stateProvince[$i];
            $address[$i]['country'] = $country[$i];
            $address[$i]['type'] = $AddressType[$i];

            //timeFrame
            $timeFrame[$i]['earliestArrival'] = $earliestArrival[$i];
            $timeFrame[$i]['latestArrival'] = $latestArrival[$i];
            $timeFrame[$i]['timeFrameType'] = $timeFrameType[$i];

            //item/attributes
            $attribute[$i]['inside'] = $inside[$i];
            $attribute[$i]['liftgateRequired'] = $liftgateRequired[$i];
            $attribute[$i]['callBeforeArrival'] = $callBeforeArrival[$i];
            $attribute[$i]['appointmentRequired'] = $appointmentRequired[$i];

            //contact
            $contact[$i]['name'] = $name[$i];
            $contact[$i]['companyName'] = $companyName[$i];
            $contact[$i]['phoneNumber'] = $phoneNumber[$i];
        }
        for ( $i = 0; $i < count($streetAddress); $i++) {
            $item[$i]['address'] = $address[$i];
            $item[$i]['timeFrame'] = $timeFrame[$i];
            $item[$i]['attributes'] = $attribute[$i];
            $item[$i]['contact'] = $contact[$i];
        }
        $route['Items'] = $item;

        //Items Array
        $items['Commodity'] = $commodity;
        $items['unitCount'] = $unitCount;
        $items['packaging'] = $packaging;
        $items['LengthInMeters'] = $lengthInMeters;
        $items['$HeightInMeters'] = $heightInMeters;
        $items['LBS'] = $lbs;
        $items['freightClass'] = $freightClass;
        $items['stackable'] = $stackable;
        $items['hazardous'] = $hazardous;
        $items['handlingUnit'] = $handlingUnit;

        //Attributs Array
        $attributes['protectfromFreezing'] = $protectfromFreezing;
        $attributes['sortandSegregate'] = $sortandSegregate;
        $attributes['blindShipmentCoordination'] = $blindShipmentCoordination;

        //UShip Json
        $uship['route'] = $route;
        $uship['items'] = $items;
        $uship['attributes'] = $attributes;

        return $uship;
    }
}
?>
