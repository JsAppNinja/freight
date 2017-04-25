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
                    'BillCollect' => 'SHIPPER',
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

        $xml = $this->_arrayToXml($freightquote);

        $xml = '<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope
        	xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
        	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        	xmlns:xsd="http://www.w3.org/2001/XMLSchema">
        	<soap:Body>
        		<GetRatingEngineQuote
        			xmlns="http://tempuri.org/">
        			<request>
        				<CustomerId>0</CustomerId>
        				<QuoteType>B2B</QuoteType>
        				<ServiceType>LTL</ServiceType>
        				<QuoteShipment>
        					<IsBlind>false</IsBlind>
        					<PickupDate>2017-04-23T00:00:00</PickupDate>
        					<SortAndSegregate>false</SortGetRatingEngineQuoteAndSegregate>
        					<UseStackableFlag>false</UseStackableFlag>
        					<DeclaredValue>20000</DeclaredValue>
        					<MaxPickupDate />
        					<TLDeliveryDate />
        					<TLEquipmentType>Any</TLEquipmentType>
        					<TLEquipmentSize>Any</TLEquipmentSize>
        					<TLTarpSizeType>NoTarpRequired</TLTarpSizeType>
        					<ShipmentLocations>
        						<Location>
        							<LocationType>Origin</LocationType>
        							<HasLoadingDock>false</HasLoadingDock>
        							<IsConstructionSite>false</IsConstructionSite>
        							<RequiresInsideDelivery>false</RequiresInsideDelivery>
        							<IsTradeShow>false</IsTradeShow>
        							<TradeShow>TradeShowDesc</TradeShow>
        							<IsResidential>false</IsResidential>
        							<RequiresLiftgate>false</RequiresLiftgate>
        							<HasAppointment>false</HasAppointment>
        							<IsLimitedAccess>false</IsLimitedAccess>
        							<LocationAddress>
        								<PostalCode>30303</PostalCode>
        								<CountryCode>US</CountryCode>
        							</LocationAddress>
        							<AdditionalServices />
        						</Location>
        						<Location>
        							<LocationType> Destination</LocationType>
        							<HasLoadingDock>false</HasLoadingDock>
        							<IsConstructionSite>false</IsConstructionSite>
        							<RequiresInsideDelivery>false</RequiresInsideDelivery>
        							<IsTradeShow>false</IsTradeShow>
        							<TradeShow>TradeShowDesc</TradeShow>
        							<IsResidential>false</IsResidential>
        							<RequiresLiftgate>false</RequiresLiftgate>
        							<HasAppointment>false</HasAppointment>
        							<IsLimitedAccess>false</IsLimitedAccess>
        							<LocationAddress>
        								<PostalCode>60606</PostalCode>
        								<CountryCode>US</CountryCode>
        							</LocationAddress>
        							<AdditionalServices />
        						</Location>
        					</ShipmentLocations>
        					<ShipmentProducts>
        						<Product>
        							<Class>55</Class>
        							<Weight>1200</Weight>
        							<Length>0</Length>
        							<Width>0</Width>
        							<Height>0</Height>
        							<ProductDescription>Books</ProductDescription>
        							<PackageType>Pallets_48x48</PackageType>
        							<IsStackable>false</IsStackable>
        							<DeclaredValue>0</DeclaredValue>
        							<CommodityType>GeneralMerchandise</CommodityType>
        							<ContentType>NewCommercialGoods</ContentType>
        							<IsHazardousMaterial>false</IsHazardousMaterial>
        							<NMFC />
        							<DimWeight>0</DimWeight>
        							<EstimatedWeight>0</EstimatedWeight>
        							<PieceCount>5</PieceCount>
        							<ItemNumber>0</ItemNumber>
        							<ProductDrops />
        						</Product>
        					</ShipmentProducts>
        					<ShipmentContacts />
        				</QuoteShipment>
        			</request>
        			<user>
        				<Name>xmltest@freightquote.com</Name>
        				<Password>xml</Password>
        				<CredentialType>Default</CredentialType>
        			</user>
        		</GetRatingEngineQuote>
        	</soap:Body>
        </soap:Envelope>';
        $endpoint_url = "https://b2b.freightquote.com/WebService/QuoteService.asmx";

        $headers = array(
            'Content-Type: text/xml; charset=utf-8',
            'Content-Length: ' . strlen($xml),
            'SOAPAction: "http://tempuri.org/GetRatingEngineQuote"'
        );

        $ch = curl_init( $endpoint_url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        if (curl_errno($ch) == 0) {

            curl_close($ch);

            //Simple check to make sure that this is a valid XML response
            // echo($response); $exit;
            if (strpos(strtolower($response), 'soap:envelope') === false) {
                return response()->json(['error' => 'Freightquote.com: Invalid response from server.'], 402);
                // return 'Freightquote.com: Invalid response from server.';
            }
            if ($response) {
                //Convert the XML into an easy-to-use associative array
                $response = $this->_parseXml($response);
                $response = $response['GetRatingEngineQuoteResponse'][0]['GetRatingEngineQuoteResult'][0];
                if($response['QuoteId'] > 0) {
                    $price = $response['QuoteCarrierOptions'][0]['CarrierOption'][0]['QuoteAmount'];
                    return response()->json(['price' => $price], 200);
                } else {
                    $errorMessage = $response['ValidationErrors'][0]['B2BError'][0]['ErrorMessage'];
                    return response()->json(['error' => $errorMessage], 402);
                }
            } else {
                return response()->json(['error' => 'Freightquote.com: No Response'], 402);
            }
        } else {
            //Collect the error returned
            $curlErrors = curl_error($ch) . ' (Error No. ' . curl_errno($ch) . ')';

            curl_close($ch);

            return response()->json(['error' => 'Freightquote.com: ' . $curlErrors], 402);
        }

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

    protected function _arrayToXml($array, $wrapper = true)
    {
        $xml = '';

        if ($wrapper) {
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n" .
            '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\n" .
            'xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' . "\n" .
            '<soap:Body>' . "\n";
        }

        $first_key = true;

        foreach ($array as $key => $value) {
            $position = 0;

            if (is_array($value)) {
                $is_value_assoc = $this->_isAssoc($value);
                $xml .= "<$key" . ($first_key && $wrapper ? ' xmlns="http://tempuri.org/"' : '') . ">\n";
                $first_key = false;

                foreach ($value as $key2 => $value2) {
                    if (is_array($value2)) {
                        if ($is_value_assoc) {
                            $xml .= "<$key2>\n" . $this->_arrayToXml($value2, false) . "</$key2>\n";
                        } elseif (is_array($value2)) {
                            $xml .= $this->_arrayToXml($value2, false);
                            $position++;
                            if ($position < count($value) && count($value) > 1) $xml .= "</$key>\n<$key>\n";
                        }
                    } else {
                        $xml .= "<$key2>" . $this->_xmlSafe($value2) . "</$key2>\n";
                    }
                }
                $xml .= "</$key>\n";
            } else {
                $xml .= "<$key>" . $this->_xmlSafe($value) . "</$key>\n";
            }
        }

        if ($wrapper) {
            $xml .= '</soap:Body>' . "\n" .
            '</soap:Envelope>';
        }
        return $xml;
    }

    protected function _isAssoc($array)
    {
        return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
    }

    protected function _xmlSafe($str) {
        //The 5 evil characters in XML
        $str = str_replace('<', '&lt;', $str);
        $str = str_replace('>', '&gt;', $str);
        $str = str_replace('&', '&amp;', $str);
        $str = str_replace("'", '&apos;', $str);
        $str = str_replace('"', '&quot;', $str);

        return $str;
    }

    protected function _parseXml($text)
    {
        $reg_exp = '/<(\w+)[^>]*>(.*?)<\/\\1>/s';
        preg_match_all($reg_exp, $text, $match);
        foreach ($match[1] as $key=>$val) {
            if ( preg_match($reg_exp, $match[2][$key]) ) {
                $array[$val][] = $this->_parseXml($match[2][$key]);
            } else {
                $array[$val] = $match[2][$key];
            }
        }
        return $array;
    }

}

?>
