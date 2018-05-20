<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Models\Art;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
       return view('seller/dashboard'); 
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('login');
    }
}
