<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class ViewController extends Controller
{
    public function login()
    {
        return view('auth');
    }

    public function dash()
    {
        $countries = Country::all();
        return view('dash', compact('countries'));
    }

    public function new()
    {
        return view('new');
    }

    public function edit($code)
    {
        $country = Country::where('code', $code)->firstOrFail();
        return view('edit', compact('country'));
    }
}
