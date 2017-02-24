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

    public function save(Request $request)
    {
        $streetAddress = $request->item['streetAddress'];
        $alternateStreetAddress = $request->item['alternateStreetAddress'];
        $majorMunicipality = $request->item['majorMunicipality'];
        $postalCode = $request->item['postalCode'];
        $stateProvince = $request->item['stateProvince'];
        $country = $request->item['country'];
        $AddressType = $request->item['AddressType'];
        $earliestArrival = $request->item['earliestArrival'];
        $latestArrival = $request->item['latestArrival'];
        $timeFrame = $request->item['timeFrameType'];
        $inside = $request->item['inside'];
        $liftgateRequired = $request->item['liftgateRequired'];
        $callBeforeArrival = $request->item['callBeforeArrival'];
        $appointmentRequired = $request->item['appointmentRequired'];
        $name = $request->item['name'];
        $companyName = $request->item['companyName'];
        $phoneNumber = $request->item['phoneNumber'];
        $commodity = $request->Commodity;
        $unitCount = $request->unitCount;
        $lengthInMeters = $request->lengthInMeters;
        $heightInMeters = $request->heightInMeters;
        $lbs = $request->lbs;
        $freightClass = $request->freightClass;
        $stackable = $request->stackable;
        $hazardous = $request->hazardous;
        $handlingUnit = $request->handlingUnit;
        $protectfromFreezing = $request->protectfromFreezing;
        $sortandSegregate = $request->sortandSegregate;
        $blindShipmentCoordination =$request->blindShipmentCoordination;
        $thirdParty = $request->thirdParty;
    }
}
