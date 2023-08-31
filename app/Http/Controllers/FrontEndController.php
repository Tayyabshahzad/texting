<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index(){
        return view('frontEnd.index');
    }

    public function howItWorks(){
        return view('frontEnd.howItWorks');
    }

    public function pricingPlans(){
        return view('frontEnd.pricingPlans');
    }

    public function bookOnline(){
        return view('frontEnd.bookOnline');
    }

    public function contact(){
        return view('frontEnd.contact');
    }
}
