<?php
/**
* User: Starin
* Date: 06/27/17
*/

namespace App\Services;

use App\Contracts\ShippingServiceInterface;
use Ups\Entity\Shipment;
use Ups\Rate;
use Ups\Entity\Address;
use Ups\Entity\ShipFrom;
use Ups\Entity\Package;
use Ups\Entity\PackagingType;
use Ups\Entity\UnitOfMeasurement;
use Ups\Entity\Dimensions;

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
    public function returnData($request)
    {
        $user_id = env('UPS_USER_ID');
        $user_password = env('UPS_USER_PASSWORD');
        $access_key = env('UPS_ACCESS_KEY');

        $rate = new Rate($access_key, $user_id, $user_password);

        try {
            $shipment = new Shipment;
            $shipperAddress = $shipment->getShipper()->getAddress();
            $shipperAddress->setPostalCode($request->item['origin']['postalCode']);

            // OriginAddress
            $originaddress = new Address;
            $originaddress->setAddressLine1($request->item['origin']['streetAddress']);
            $originaddress->setAddressLine2($request->item['origin']['alternateStreetAddress']);
            $originaddress->setPostalCode($request->item['origin']['postalCode']);
            $originaddress->setCity($request->item['origin']['majorMunicipality']);
            $originaddress->setstateProvinceCode($request->item['origin']['stateProvince']);
            $originaddress->setCountryCode($request->item['origin']['country']);
            $originaddress->setStreetType($request->item['origin']['AddressType']);
            $shipFrom = new ShipFrom;
            $shipFrom->setAddress($originaddress);
            $shipment->setShipFrom($shipFrom);

            //Destination Address
            $shipTo = $shipment->getShipTo();
            $shipTo->setCompanyName($request->item['destination']['companyName']);
            $shipToAddress = $shipTo->getAddress();
            $shipToAddress->setPostalCode($request->item['destination']['postalCode']);
            $shipToAddress->setCountryCode($request->item['destination']['country']);
            $shipToAddress->setStreetType($request->item['destination']['AddressType']);

            // multi package
            for($i = 0; $i < $request->get('count'); $i++){
                $package[$i] = new Package;
                $package[$i]->getPackagingType()->setCode(PackagingType::PT_PACKAGE);
                $package[$i]->getPackageWeight()->setWeight($request->items[$i]['lbs']);
                $weightUnit = new UnitOfMeasurement;
                $weightUnit->setCode(UnitOfMeasurement::UOM_LBS);
                $package[$i]->getPackageWeight()->setUnitOfMeasurement($weightUnit);

                $dimensions = new Dimensions;
                $dimensions->setHeight($request->items[$i]['heightInMeters']);
                $dimensions->setWidth($request->items[$i]['lbs']);
                $dimensions->setLength($request->items[$i]['lengthInMeters']);
                $unit = new UnitOfMeasurement;
                $unit->setCode(UnitOfMeasurement::UOM_CM);
                $dimensions->setUnitOfMeasurement($unit);
                $package[$i]->setDimensions($dimensions);

            }
            $shipment->addPackage($package);
            print_r($rate->getRate($shipment)); exit;

        } catch (Exception $e){
            print_r($e);
        }
    }
    public function call($ups)
    {

    }
}

?>
