<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        print_r($request->item[0]['streetAddress'][0]); exit;
        $rules = $this->shippingService->getRule($count);
        // print_r($rules); exit;
        $this->validate($request,$rules);
//        $shippingApi = $this->shippingService->call($request);
    }
}
