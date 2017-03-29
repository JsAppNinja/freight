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

    public function getRule($count)
    {
        $rules = [
            'item' => 'array|min:1',
        ];

        return $rules;
    }

    public function returnData($request)
    {
        return $freightquote;
    }

    public function call($freightquote)
    {


    }


}

?>
