<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function login()
    {
        return view('auth');
    }

    public function dash()
    {
        return view('dash');
    }

    public function new()
    {
        return view('new');
    }

    public function edit()
    {
        return view('edit');
    }

    public function delete()
    {
        return view('delete');
    }
}
