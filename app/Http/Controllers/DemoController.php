<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function exampleDataGet(Request $request)
    {
        return response([
            'param_name' => $request->name,
            'message' => 'Hello json data',
            'status' => 200,
            'isSuccess' => true,
            'data' => [
                [
                    'id' => 1,
                    'name' => 'John1',
                    'email' => 'john1@example.com',
                ],
                [
                    'id' => 2,
                    'name' => 'John2',
                    'email' => 'john2@example.com',
                ],
            ]
        ]);
    }

    public function exampleDataPost()
    {

    }

    public function testGet()
    {
        $params = [
            'name' => 'Taylor',
            'page' => 1,
        ];
        $response = Http::get('http://localhost:8888/staff/list');
        $body = json_decode($response->body(), true);
        return view('demo', [
            'items' => $body['data']
        ]);
    }

    public function post()
    {

    }
}
