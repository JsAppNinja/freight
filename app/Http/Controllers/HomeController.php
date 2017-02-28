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
        $rules = $this->shippingService->getRule($count);
        $this->validate($request,$rules);
        $this->shippingService->call($request);
    }
}
