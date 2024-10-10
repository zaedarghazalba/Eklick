<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Contencontroll extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function home()
    {
        return view('home');
    }
}
