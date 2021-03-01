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
    
    public function kpi()
    {
        return view('main.view_menu.kpi');
    }

    public function department()
    {
        return view('main.view_menu.department');
    }
    
    public function staff()
    {
        return view('main.view_menu.staff');
    }

    public function contract()
    {
        return view('main.view_menu.contract');
    }
    
    public function salary()
    {
        return view('main.view_menu.salary');
    }
}
