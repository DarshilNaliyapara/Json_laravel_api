<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request){

        $json = '[
    {
        "id": "1",
        "name": "Darshil",
        "email": "darshil@gmail.com"
    },
    {
        "id": "2",
        "name": "test",
        "email": "test@gmail.com"
    },
     {
        "id": "3",
        "name": "test123",
        "email": "host@gmail.com"
    },
     {
        "id": "4",
        "name": "user",
        "email": "user@gmail.com"
    }
]';

$data = json_decode($json,true);
$names = array_map(function($item){
    return $item;
},$data);

$id = 1;
$filteredForm = array_filter($data, function($item) use ($id) {
    return (int) $item['id'] !== (int) $id;
});

$temp = array_values($filteredForm);


return view('test',['names'=>$names,'for'=>$filteredForm]);
    }
    public function search(Request $request){
        $input = $request->inputdata;
        dd($input);
    }
}
