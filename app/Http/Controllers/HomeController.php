<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Check role and based on that redirect to specific home page
        if ($request->user()->hasRole('Admin')) {
            return redirect(url('/admin/index'));
        } elseif ($request->user()->hasRole('Seller')) {
            return redirect(url('/seller/index'));
        } elseif ($request->user()->hasRole('Buyer')) {
            return redirect(url('/buyer/index'));
        } 
        return redirect(url('/'));
    }
}
