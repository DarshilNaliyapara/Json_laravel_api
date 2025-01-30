<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request, Form $form)
    {

        $customers = Form::where('meta_name', 'customers')->first();
        $data = [];
        if (!empty($customers)) {
            $data = isset($customers->meta_value) ? json_decode($customers->meta_value, true) : [];
            if ($data) {
                $forms = array_map(function ($item) {
                    return $item;
                }, $data);
            } else {
                return response()->json(["status" => false, "message" => "No Data Found"], 404);
            }
            return response()->json(["status" => true, "response_data" => $forms], 200);
        } else {
            return response()->json(["status" => false, "message" => "No Data Found"], 404);
        }
    }

    public function store(Request $request, Form $form)
    {
        $data = [
            'meta_name' => 'customers',
            'meta_value' => json_encode($request->customers),
        ];
        if ($data) {

            $form = Form::updateOrCreate(
                ['meta_name' => 'customers'],
                $data
            );


            $customers = Form::where('meta_name', 'customers')->first();

            $data = isset($customers->meta_value) ? json_decode($customers->meta_value, true) : [];

            if ($data) {
                $AllData = array_map(function ($item) {
                    return $item;
                }, $data);
                return response()->json(["status" => true, "message" => "Data Inserted Successfully.", "response_data" => $AllData], 200);
            } else {
                return response()->json(["status" => false, "message" => "Failed to Insert Data."], 404);
            }
        } else {
            return response()->json(["status" => false, "message" => "Failed to Insert Data."], 404);
        }
    }
    public function show(Request $request, Form $form, string $id)
    {

        $customers = Form::where('meta_name', 'customers')->first();

        $data = isset($customers->meta_value) ? json_decode($customers->meta_value, true) : [];
        if ($data) {
            $filteredData = current(array_filter($data, function ($items) use ($id) {
                return $items['id'] == $id;
            }));
            if ($filteredData) {
                return response()->json(["status" => true, "response_data" => $filteredData], 200);
            }
            else {
                return response()->json(["status" => false, "message" => "No Data Found on given id: $id"], 404);
            }

        } else {
            return response()->json(["status" => false, "message" => "No Data Found"], 404);
        }
    }

    public function edit(string $id)
    {
        $customers = Form::where('meta_name', 'customers')->first();


        $data = isset($customers->meta_value) ? json_decode($customers->meta_value, true) : [];

        $forms = array_map(function ($item) {
            return $item;
        }, $data);

        $filteredForm = current(array_filter($data, function ($items) use ($id) {
            return $items['id'] == $id;
        }));


        return view('index', ['forms' => $forms, 'id' => $id, 'for' => $filteredForm]);
    }

    public function update(Request $request, string $id)
    {
        $vals = $request->customers;

        foreach ($vals as $key => $val) {

            $name = $val['name'];
            $email = $val['email'];
            $id = $val['id'];
        }

        $customers = Form::where('meta_name', 'customers')->first();

        $forms = json_decode($customers->meta_value, true);

        $filteredForm = current(array_filter($forms, function ($items) use ($id) {
            return $items['id'] == $id;
        }));
        if ($filteredForm) {
            $filteredForm['name'] = $name;
            $filteredForm['email'] = $email;
            $filteredForm['id'] = $id;

            foreach ($forms as $key => $form) {
                if ($form['id'] == $filteredForm['id']) {
                    $forms[$key] = $filteredForm;
                }
            };
            $customers->meta_value = json_encode($forms);
            $customers->save();



            return response()->json(["status" => true, "message" => "Data Updated Successfully.", "response_data" => $forms], 200);
        } else {
            return response()->json(["status" => false, "message" => "Failed to Update data"], 404);
        }
    }
    public function destroy(string $id)
    {
        $customers = Form::where('meta_name', 'customers')->first();
        $data = isset($customers->meta_value) ? json_decode($customers->meta_value, true) : [];

if ($data) {


        $filteredForm = array_filter($data, function ($item) use ($id) {
            return  $item['id'] != $id;
        });

        $data = array_values($filteredForm);
        $customers->meta_value = json_encode($data);
        $customers->save();
        if ($data) {
            return response()->json(["status" => true, "message" => "Data Deleted Successfully.", "response_data" => $data], 200);
        } else {
            return response()->json(["status" => false, "message" => "Failed to Delete data"], 404);
        }
    }
else {
    return response()->json(["status" => false, "message" => "Failed to Delete data,No Data Found"], 404);
}
}

}
