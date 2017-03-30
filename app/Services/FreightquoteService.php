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
        $user_id = env('FREIGHTQUOTE_USER_ID');
        $user_pwd = env('FREIGHTQUOTE_USER_PWD');

        /* Set up initial XML structure */
        $freightquote = array(
            'GetRatingEngineQuote' => array(
                'request' => array(
                    'CustomerId' => '0',
                    'QuoteType' => $request->item['quoteType'],
                    'ServiceType' => $request->item['freightquoteServiceType'],
                    'QuoteShipment' => array(
                        'IsBlind' => $request->item['isBlind'],
                        'ShipmentLocations' => array(
                            'Location' => array(
                                $this->addShipper($request),
                                $this->addRecipient($request)
                            )
                        ),
                        'ShipmentProducts' => array(
                            'Product' => $this->addProducts($request)
                        ),
                        'ShipmentContacts' => array(
                            'ContactAddress' => array(
                                $this->addShipperContact($request),
                                $this->addRecipientContact($request)
                            )
                        )
                    )
                ),
                'user' => array(
                    // 'Name' => $user_id,
                    // 'Password' => $user_pwd,
                    'Name' => 'xmltest@freightquote.com',
                    'Password' => 'xml',
                    'CredentialType' => 'Default'
                )
            )
        );
        if($request->item['freightquoteServiceType'] == 'Truckload') {
            $freightquote['GetRatingEngineQuote']['request']['TLDeliveryDate'] = $request->item['tlDeliveryDate'];
            $freightquote['GetRatingEngineQuote']['request']['TLEquipmentType'] = $request->item['tlEquipmentType'];
            $freightquote['GetRatingEngineQuote']['request']['TLEquipmentSize'] = $request->item['tlEquipmentSize'];
            $freightquote['GetRatingEngineQuote']['request']['TLTarpSizeType'] = $request->item['tlTarpSizeType'];
        }
        if($this->hazardous) {
            $freightquote['GetRatingEngineQuote']['request']['QuoteShipment']['HazardousMaterialContactName'] = $request->item['origin']['name'];
            $freightquote['GetRatingEngineQuote']['request']['QuoteShipment']['HazardousMaterialContactPhone'] = $request->item['origin']['phoneNumber'];

        }
        return $freightquote;
    }

    public function call($freightquote)
    {

    }

    function addShipper($request)
    {
        $shipper = array(
            'LocationName' => $request->item['origin']['companyName'],
            'LocationType' => 'Origin',
            'HasLoadingDock' => $request->item['origin']['hasLoadingDock'],
            'IsConstructionSite' => $request->item['origin']['isConstructionSite'],
            'RequiresInsideDelivery' => $request->item['origin']['requiresInsideDelivery'],
            'IsTradeShow' => $request->item['origin']['isTradeShow'],
            'IsResidential' => $request->item['origin']['isResidential'],
            'RequiresLiftgate' => $request->item['origin']['requiresLiftgate'],
            'HasAppointment' => $request->item['origin']['hasAppointment'],
            'IsLimitedAccess' => $request->item['origin']['isLimitedAccess'],
            'LocationAddress' => array(
                'ContactName' => $request->item['origin']['name'],
                'ContactPhone' => $request->item['origin']['phoneNumber'],
                'StreetAddress' => $request->item['origin']['streetAddress'],
                'AdditionalAddress' => $request->item['origin']['streetAddress'],
                'City' => $request->item['origin']['majorMunicipality'],
                'StateCode' => $request->item['origin']['stateProvince'],
                'PostalCode' => $request->item['origin']['postalCode'],
                'CountryCode' => $request->item['origin']['country']
            )
        );
        return $shipper;
    }
    function addShipperContact($request)
    {
        $shipper = array(
            'ContactName' => $request->item['origin']['name'],
            'ContactPhone' => $request->item['origin']['phoneNumber']
        );
        return $shipper;
    }

    function addRecipient($request)
    {
        $recipient = array(
            'LocationName' => $request->item['destination']['companyName'],
            'LocationType' => 'Destination',
            'HasLoadingDock' => $request->item['destination']['hasLoadingDock'],
            'IsConstructionSite' => $request->item['destination']['isConstructionSite'],
            'RequiresInsideDelivery' => $request->item['destination']['requiresInsideDelivery'],
            'IsTradeShow' => $request->item['destination']['isTradeShow'],
            'IsResidential' => $request->item['destination']['isResidential'],
            'RequiresLiftgate' => $request->item['destination']['requiresLiftgate'],
            'HasAppointment' => $request->item['destination']['hasAppointment'],
            'IsLimitedAccess' => $request->item['destination']['isLimitedAccess'],
            'LocationAddress' => array(
                'ContactName' => $request->item['destination']['companyName'],
                'ContactPhone' => $request->item['destination']['phoneNumber'],
                'StreetAddress' => $request->item['destination']['streetAddress'],
                'AdditionalAddress' => $request->item['destination']['streetAddress'],
                'City' => $request->item['destination']['majorMunicipality'],
                'StateCode' => $request->item['destination']['stateProvince'],
                'PostalCode' => $request->item['destination']['postalCode'],
                'CountryCode' => $request->item['destination']['country']
            )
        );
        return $recipient;
    }

    function addRecipientContact($request)
    {
        $recipient = array(
            'ContactName' => $request->item['destination']['name'],
            'ContactPhone' => $request->item['destination']['phoneNumber']
        );
        return $recipient;
    }

    function addProducts($request)
    {
        $products = [];
        for($i = 0; $i < $request->get('count'); $i++) {
            if($request->items[$i]['hazardous'] == 'true') {
                $this->hazardous = true;
            }
            $products[$i] = array(
                'Class' => $request->items[$i]['class'],
                'ProductDescription' => $request->items[$i]['productDescription'],
                'Weight' => ceil($request->items[$i]['unitCount'] * (int)$request->items[$i]['lbs']),
                'Length' => ceil($request->items[$i]['lengthInMeters']),
                'Width' => ceil($request->items[$i]['widthInMeters']),
                'Height' => ceil($request->items[$i]['heightInMeters']),
                'PackageType' => $request->items[$i]['packageType'],
                // 'DeclaredValue' => round($request->items[$i]['declaredValue']),
                'CommodityType' => $request->items[$i]['commodityType'],
                'ContentType' => $request->items[$i]['contentType'],
                'IsStackable' => $request->items[$i]['stackable'],
                'IsHazardousMaterial' => $request->items[$i]['hazardous'],
                'PieceCount' => $request->items[$i]['unitCount'],
                'ItemNumber' => $i
            );
        }
        return $products;
    }


}

?>
