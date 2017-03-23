<?php
/**
* User: Starin
* Date: 06/27/17
*/

namespace App\Services;

use App\Contracts\ShippingServiceInterface;
use SoapClient;

// use FedEx\ShipService,
//     FedEx\ShipService\ComplexType,
//     FedEx\ShipService\SimpleType;
    
use FedEx\RateService;
use FedEx\RateService\ComplexType;
use FedEx\RateService\SimpleType;

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
            // $rules['items.'.$i.'.Commodity'] = 'required|string|max:255';
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
        $fedex['WebAuthenticationDetail'] = array(
            // 'ParentCredential' => array(
            //     'Key' => getProperty('parentkey'),
            //     'Password' => getProperty('parentpassword')
            // ),
            'UserCredential' => array(
                'Key' => getProperty('key'),
                'Password' => getProperty('password')
            )
        ); 
        $fedex['ClientDetail'] = array(
            'AccountNumber' => getProperty('shipaccount'),
            'MeterNumber' => getProperty('meter')
        );
        $fedex['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request using PHP ***');
        $fedex['Version'] = array(
            'ServiceId' => 'crs', 
            'Major' => '20', 
            'Intermediate' => '0', 
            'Minor' => '0'
        );
        $fedex['ReturnTransitAndCommit'] = true;
        $fedex['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
        $fedex['RequestedShipment']['ShipTimestamp'] = date('c');
        $fedex['RequestedShipment']['ServiceType'] = 'INTERNATIONAL_PRIORITY'; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
        $fedex['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
        $fedex['RequestedShipment']['TotalInsuredValue']=array(
            'Ammount'=>100,
            'Currency'=>'USD'
        );
        $fedex['RequestedShipment']['Shipper'] = $this->addShipper($request);
        $fedex['RequestedShipment']['Recipient'] = $this->addRecipient($request);
        $fedex['RequestedShipment']['ShippingChargesPayment'] = $this->addShippingChargesPayment($request);
        $fedex['RequestedShipment']['PackageCount'] = '1';
        // $request['RequestedShipment']['RequestedPackageLineItems'] = addPackageLineItems($request);
        $fedex['RequestedShipment']['RequestedPackageLineItems'] = $this->addPackageLineItem($request);

        return $fedex;
    }

    public function call($fedex){

        $rateRequest = new ComplexType\RateRequest();
        //UserCredential
        $userCredential = new ComplexType\WebAuthenticationCredential();
        $userCredential
            ->setKey('1HV9OgrPBoxJC51Y')
            ->setPassword('Jas1ChHUN9ZTBMH3akbIJQgKQ');

        ini_set("soap.wsdl_cache_enabled", "0");
        ini_set('soap.wsdl_cache_ttl',0);

        //WebAuthenticationDetail
        $webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
        $webAuthenticationDetail->setUserCredential($userCredential);

        $rateRequest->setWebAuthenticationDetail($webAuthenticationDetail);

        //ClientDetail
        $clientDetail = new ComplexType\ClientDetail();
        $clientDetail
            ->setAccountNumber('510087500')
            ->setMeterNumber('118789971');

        $rateRequest->setClientDetail($clientDetail);

        //TransactionDetail
        $transactionDetail = new ComplexType\TransactionDetail();
        $transactionDetail->setCustomerTransactionId('Testing Rate Service request');

        $rateRequest->setTransactionDetail($transactionDetail);

        //VersionId
        $versionId = new ComplexType\VersionId();
        $versionId
            ->setServiceId('crs')
            ->setMajor(10)
            ->setIntermediate(0)
            ->setMinor(0);

        $rateRequest->setVersion($versionId);

        //OPTIONAL ReturnTransitAndCommit
        $rateRequest->setReturnTransitAndCommit(true);

        //RequestedShipment
        $requestedShipment = new ComplexType\RequestedShipment();
        $requestedShipment->setDropoffType(SimpleType\DropoffType::_REGULAR_PICKUP);
        $requestedShipment->setShipTimestamp(date('c'));

        $rateRequest->setRequestedShipment($requestedShipment);

        //RequestedShipment/Shipper
        $shipper = new ComplexType\Party();

        $shipperAddress = new ComplexType\Address();
        $shipperAddress
            ->setStreetLines(array('10 Fed Ex Pkwy'))
            ->setCity('Memphis')
            ->setStateOrProvinceCode('TN')
            ->setPostalCode(38115)
            ->setCountryCode('US');

        $shipper->setAddress($shipperAddress);

        $requestedShipment->setShipper($shipper);

        //RequestedShipment/Recipient
        $recipient = new ComplexType\Party();

        $recipientAddress = new ComplexType\Address();
        $recipientAddress
            ->setStreetLines(array('13450 Farmcrest Ct'))
            ->setCity('Herndon')
            ->setStateOrProvinceCode('VA')
            ->setPostalCode(20171)
            ->setCountryCode('US');

        $recipient->setAddress($recipientAddress);

        $requestedShipment->setRecipient($recipient);

        //RequestedShipment/ShippingChargesPayment
        $shippingChargesPayment = new ComplexType\Payment();
        $shippingChargesPayment->setPaymentType(SimpleType\PaymentType::_SENDER);

        $payor = new ComplexType\Payor();
        $payor
            ->setAccountNumber('510087500')
            ->setCountryCode('US');

        $shippingChargesPayment->setPayor($payor);

        $requestedShipment->setShippingChargesPayment($shippingChargesPayment);

        //RequestedShipment/RateRequestType(s)
        $requestedShipment->setRateRequestTypes([
            SimpleType\RateRequestType::_LIST,
            SimpleType\RateRequestType::_ACCOUNT
        ]);

        //RequestedShipment/PackageCount
        $requestedShipment->setPackageCount(2);

        //RequestedShipment/RequestedPackageLineItem(s)
        $item1Weight = new ComplexType\Weight();
        $item1Weight
            ->setUnits(SimpleType\WeightUnits::_LB)
            ->setValue(2.0);

        $item1Dimensions = new ComplexType\Dimensions();
        $item1Dimensions
            ->setLength(10)
            ->setWidth(10)
            ->setHeight(3)
            ->setUnits(SimpleType\LinearUnits::_IN);

        $item1 = new ComplexType\RequestedPackageLineItem();
        $item1
            ->setWeight($item1Weight)
            ->setDimensions($item1Dimensions)
            ->setGroupPackageCount(1);

        $item2Weight = new ComplexType\Weight();
        $item2Weight
            ->setUnits(SimpleType\WeightUnits::_LB)
            ->setValue(5.0);

        $item2Dimensions = new ComplexType\Dimensions();
        $item2Dimensions
            ->setLength(20)
            ->setWidth(20)
            ->setHeight(10)
            ->setUnits(SimpleType\LinearUnits::_IN);

        $item2 = new ComplexType\RequestedPackageLineItem();
        $item2
            ->setWeight($item2Weight)
            ->setDimensions($item2Dimensions)
            ->setGroupPackageCount(1);

        $requestedShipment->setRequestedPackageLineItems([$item1, $item2]);

        $rateRequest->setRequestedShipment($requestedShipment);

        $rateServiceRequest = new RateService\Request();
        $response = $rateServiceRequest->getGetRatesReply($rateRequest);

        var_dump($response);


    }

    function addShipper($request){
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
    function addRecipient($request){
        $recipient = array(
            'Contact' => array(
                'PersonName' => $request->item['destination']['name'],
                'CompanyName' => $request->item['destination']['companyName'],
                'PhoneNumber' => $request->item['destination']['phoneNumber']
            ),
            'Address' => array(
                'StreetLines' => array('Address Line 1'),
                'City' => 'Richmond',
                'StateOrProvinceCode' => 'BC',
                'PostalCode' => 'V7C4V4',
                'CountryCode' => 'CA',
                'Residential' => false
            )
            // 'Address' => array(
            //     'StreetLines' => array($request->item['destination']['streetAddress']),
            //     'City' => $request->item['destination']['majorMunicipality'],
            //     'StateOrProvinceCode' => $request->item['destination']['stateProvince'],
            //     'PostalCode' => $request->item['destination']['postalCode'],
            //     'CountryCode' => $request->item['destination']['country'],
            //     'Residential' => false
            // )
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
    function addPackageLineItem($request){
        $packageLineItem = array(
            'SequenceNumber'=>1,
            'GroupPackageCount'=> $request->items[0]['unitCount'],
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
    function addPackageLineItems($request){
        $packageLineItems = [];
        for($i = 0; $i < $request->get('count'); $i++) {
            $packageLineItems[i] = array(
                'SequenceNumber'=>$i,
                'GroupPackageCount'=> $request->items[0]['unitCount'],
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
        }
        return $packageLineItems;
    }    
}

?>
