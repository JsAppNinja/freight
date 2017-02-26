<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function sendjson(Request $request)
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


        if ($thirdParty == "uship") {
            for( $i = 0; $i < count($streetAddress); $i++) {
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
            for( $i = 0; $i < count($streetAddress); $i++) {
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
            print_r($uship); exit;
        }

        if ($thirdParty == "UPS") {

        }
        if ($thirdParty == "FedEx") {

        }

    }
}
