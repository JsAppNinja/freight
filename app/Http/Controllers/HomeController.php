<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Contracts\ShippingServiceInterface;

class HomeController extends Controller
{

    protected $shippingService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ShippingServiceInterface $shippingService)
    {
        $this->middleware('auth');
        $this->shippingService = $shippingService;
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
        $count = $request->get('count');
        $rules = $this->shippingService->getRule($count);
        $this->validate($request,$rules);
        $shippingData = $this->shippingService->returnData($request);
        $price = $this->shippingService->call($shippingData);
        if(is_numeric($price)) {
            return response()->json(['price' => $price], 200);
        }
        else {
            return response()->json(['error' => $price], 401);
        }
    }
}
