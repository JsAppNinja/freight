<?php
/**
* User: Starin
* Date: 06/27/17
*/

namespace App\Services;

use App\Contracts\ShippingServiceInterface;

require_once('../../libs/fedex/library/fedex-common.php5');


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
        $rules['item.origin.name'] = 'required|string|max:255' ;
        $rules['item.origin.companyName'] = 'required|string|max:255' ;
        $rules['item.origin.phoneNumber'] = 'required|string|max:255' ;

        // destination Addres rules

        $rules['item.origin.streetAddress'] = 'required|string|max:255' ;
        $rules['item.origin.majorMunicipality'] = 'required|string|max:255' ;
        $rules['item.destination.postalCode'] = 'required|string|max:255' ;
        $rules['item.origin.stateProvince'] = 'required|string|max:255' ;
        $rules['item.destination.country'] = 'required|string|max:255' ;
        $rules['item.destination.AddressType'] = 'required|string|max:255' ;
        $rules['item.destination.name'] = 'required|string|max:255' ;
        $rules['item.destination.companyName'] = 'required|string|max:255' ;
        $rules['item.destination.phoneNumber'] = 'required|string|max:255' ;

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
        $newline = "<br />";
        //The WSDL is not included with the sample code.
        //Please include and reference in $path_to_wsdl variable.
        $path_to_wsdl = "../../wsdl/RateService_v20.wsdl";

        ini_set("soap.wsdl_cache_enabled", "0");
         
        $client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

        $request['WebAuthenticationDetail'] = array(
            'ParentCredential' => array(
                'Key' => getProperty('parentkey'),
                'Password' => getProperty('parentpassword')
            ),
            'UserCredential' => array(
                'Key' => getProperty('key'), 
                'Password' => getProperty('password')
            )
        ); 
        $request['ClientDetail'] = array(
            'AccountNumber' => getProperty('shipaccount'), 
            'MeterNumber' => getProperty('meter')
        );
        $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'crs', 
            'Major' => '20', 
            'Intermediate' => '0', 
            'Minor' => '0'
        );
        $request['ReturnTransitAndCommit'] = true;
        $request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
        $request['RequestedShipment']['ShipTimestamp'] = date('c');
        $request['RequestedShipment']['ServiceType'] = 'INTERNATIONAL_PRIORITY'; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
        $request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
        $request['RequestedShipment']['TotalInsuredValue']=array(
            'Ammount'=>100,
            'Currency'=>'USD'
        );
        $request['RequestedShipment']['Shipper'] = addShipper();
        $request['RequestedShipment']['Recipient'] = addRecipient();
        $request['RequestedShipment']['ShippingChargesPayment'] = addShippingChargesPayment();
        $request['RequestedShipment']['PackageCount'] = '1';
        $request['RequestedShipment']['RequestedPackageLineItems'] = addPackageLineItem1();

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

    function addShipper(){
        $shipper = array(
            'Contact' => array(
                'PersonName' => 'Sender Name',
                'CompanyName' => 'Sender Company Name',
                'PhoneNumber' => '9012638716'
            ),
            'Address' => array(
                'StreetLines' => array('Address Line 1'),
                'City' => 'Collierville',
                'StateOrProvinceCode' => 'TN',
                'PostalCode' => '38017',
                'CountryCode' => 'US'
            )
        );
        return $shipper;
    }
    function addRecipient(){
        $recipient = array(
            'Contact' => array(
                'PersonName' => 'Recipient Name',
                'CompanyName' => 'Company Name',
                'PhoneNumber' => '9012637906'
            ),
            'Address' => array(
                'StreetLines' => array('Address Line 1'),
                'City' => 'Richmond',
                'StateOrProvinceCode' => 'BC',
                'PostalCode' => 'V7C4V4',
                'CountryCode' => 'CA',
                'Residential' => false
            )
        );
        return $recipient;                                      
    }
    function addShippingChargesPayment(){
        $shippingChargesPayment = array(
            'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
            'Payor' => array(
                'ResponsibleParty' => array(
                    'AccountNumber' => getProperty('billaccount'),
                    'CountryCode' => 'US'
                )
            )
        );
        return $shippingChargesPayment;
    }
    function addLabelSpecification(){
        $labelSpecification = array(
            'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
            'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
            'LabelStockType' => 'PAPER_7X4.75'
        );
        return $labelSpecification;
    }
    function addSpecialServices(){
        $specialServices = array(
            'SpecialServiceTypes' => array('COD'),
            'CodDetail' => array(
                'CodCollectionAmount' => array(
                    'Currency' => 'USD', 
                    'Amount' => 150
                ),
                'CollectionType' => 'ANY' // ANY, GUARANTEED_FUNDS
            )
        );
        return $specialServices; 
    }
    function addPackageLineItem1(){
        $packageLineItem = array(
            'SequenceNumber'=>1,
            'GroupPackageCount'=>1,
            'Weight' => array(
                'Value' => 50.0,
                'Units' => 'LB'
            ),
            'Dimensions' => array(
                'Length' => 108,
                'Width' => 5,
                'Height' => 5,
                'Units' => 'IN'
            )
        );
        return $packageLineItem;
    }
}

?>
