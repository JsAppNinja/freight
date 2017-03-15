<?php
/**
* User: Starin
* Date: 06/27/17
*/

namespace App\Services;

use App\Contracts\ShippingServiceInterface;

require_once('../libs/fedex/library/fedex-common.php5');


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
        // $rules['item.origin.AddressType'] = 'required|string|max:255' ;
        $rules['item.origin.name'] = 'required|string|max:255' ;
        $rules['item.origin.companyName'] = 'required|string|max:255' ;
        $rules['item.origin.phoneNumber'] = 'required|string|max:255' ;

        // destination Addres rules

        $rules['item.origin.streetAddress'] = 'required|string|max:255' ;
        $rules['item.origin.majorMunicipality'] = 'required|string|max:255' ;
        $rules['item.destination.postalCode'] = 'required|string|max:255' ;
        $rules['item.origin.stateProvince'] = 'required|string|max:255' ;
        $rules['item.destination.country'] = 'required|string|max:255' ;
        $rules['item.destination.name'] = 'required|string|max:255' ;
        $rules['item.destination.companyName'] = 'required|string|max:255' ;
        $rules['item.destination.phoneNumber'] = 'required|string|max:255' ;

        // items rules

        for ($i = 0; $i < $count; $i++) {
            $rules['items.'.$i.'.Commodity'] = 'required|string|max:255';
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
        // $request['RequestedShipment']['RequestedPackageLineItems'] = addPackageLineItem1();
        $request['RequestedShipment']['RequestedPackageLineItems'] = addPackageLineItems();


        try {
            if(setEndpoint('changeEndpoint')){
                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }
            
            $response = $client -> getRates($request);
                
            if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){      
                $rateReply = $response -> RateReplyDetails;
                echo '<table border="1">';
                echo '<tr><td>Service Type</td><td>Amount</td><td>Delivery Date</td></tr><tr>';
                $serviceType = '<td>'.$rateReply -> ServiceType . '</td>';
                if($rateReply->RatedShipmentDetails && is_array($rateReply->RatedShipmentDetails)){
                    $amount = '<td>$' . number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") . '</td>';
                }elseif($rateReply->RatedShipmentDetails && ! is_array($rateReply->RatedShipmentDetails)){
                    $amount = '<td>$' . number_format($rateReply->RatedShipmentDetails->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") . '</td>';
                }
                if(array_key_exists('DeliveryTimestamp',$rateReply)){
                    $deliveryDate= '<td>' . $rateReply->DeliveryTimestamp . '</td>';
                }else if(array_key_exists('TransitTime',$rateReply)){
                    $deliveryDate= '<td>' . $rateReply->TransitTime . '</td>';
                }else {
                    $deliveryDate='<td>&nbsp;</td>';
                }
                echo $serviceType . $amount. $deliveryDate;
                echo '</tr>';
                echo '</table>';
                
                printSuccess($client, $response);
            }else{
                printError($client, $response);
            } 
            writeToLog($client);    // Write to log file   
        } catch (SoapFault $exception) {
           printFault($exception, $client);        
        }


        
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
                'PersonName' => $request->item['origin']['name'],
                'CompanyName' => $request->item['origin']['companyName'],
                'PhoneNumber' => $request->item['origin']['phoneNumber']
            ),
            'Address' => array(
                'StreetLines' => array($request->item['origin']['streetAddress']),
                'City' => $request->item['origin']['majorMunicipality'],
                'StateOrProvinceCode' => $request->item['origin']['stateProvince'],
                'PostalCode' => $request->item['origin']['postalCode'],
                'CountryCode' => $request->item['origin']['country']
            )
        );      
        return $shipper;
    }
    function addRecipient(){
        $recipient = array(
            'Contact' => array(
                'PersonName' => $request->item['destination']['name'],
                'CompanyName' => $request->item['destination']['companyName'],
                'PhoneNumber' => $request->item['destination']['phoneNumber']
            ),
            'Address' => array(
                'StreetLines' => array($request->item['destination']['streetAddress']),
                'City' => $request->item['destination']['majorMunicipality'],
                'StateOrProvinceCode' => $request->item['destination']['stateProvince'],
                'PostalCode' => $request->item['destination']['postalCode'],
                'CountryCode' => $request->item['destination']['country']
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
    function addPackageLineItem(){
        $packageLineItem = array(
            'SequenceNumber'=>1,
            'GroupPackageCount'=>1,
            'Weight' => array(
                'Value' => $request->items[0]['lbs'],
                'Units' => 'LB'
            ),
            'Dimensions' => array(
                'Length' => $request->items[0]['lengthInMeters'],
                'Width' => $request->items[0]['widthInMeters'],
                'Height' => $request->items[0]['heightInMeters'],
                'Units' => 'IN'
            )
        );
        return $packageLineItem;
    }
    function addPackageLineItems(){
    $packageLineItems = [];
    for($i = 0; $i < $request->get('count'); $i++) {
        $packageLineItems[i] = array(
            'SequenceNumber'=>$i,
            'GroupPackageCount'=>1,
            'Weight' => array(
                'Value' => $request->items[$i]['lbs'],
                'Units' => 'LB'
            ),
            'Dimensions' => array(
                'Length' => $request->items[$i]['lengthInMeters'],
                'Width' => $request->items[$i]['widthInMeters'],
                'Height' => $request->items[$i]['heightInMeters'],
                'Units' => 'IN'
            )
        );
        return $packageLineItems;
    }    
}

?>
