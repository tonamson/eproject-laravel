<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function getCreate()
    {
        return view('main.salary.create');
    }
}
