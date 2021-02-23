<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function getList()
    {
        return view('main.contract.index');
    }

    public function getCreate()
    {
        return view('main.contract.create');
    }
}
