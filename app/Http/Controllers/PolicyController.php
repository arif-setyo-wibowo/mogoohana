<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('privacy');
    }

    public function terms()
    {
        return view('terms');
    }

    public function refund()
    {
        return view('refund');
    }
}
