<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ViewMenuController extends Controller
{
    public function index()
    {
        return view('main.view_menu.index');
    }

    public function timeLeave()
    {
        return view('main.view_menu.time_leave');
    }
}
