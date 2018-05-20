<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Models\Art;

class AppController extends Controller
{


    public function index()
    {
        return view('home');
    }
    

    public function seller()
    {
        return view('seller/home');
    }
}
