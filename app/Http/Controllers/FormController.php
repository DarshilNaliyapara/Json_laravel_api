<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index(Form $form)
    {

        $customers = Form::where('meta_name', 'customers')->first();
        $data = [];
        $forms = [];
        if (!empty($customers)) {
            $data = isset($customers->meta_value) ? json_decode($customers->meta_value, true) : [];

            $forms = array_map(function ($item) {
                return $item;
            }, $data);
            
        }

        return view('index', ['forms' => $forms, 'form' => $form]);
    }

    public function store(Request $request, Form $form)
    {

        $customers = Form::where('meta_name', 'customers')->first();
        $forms = json_decode($customers->meta_value, true);
        if (count($forms)>0) {

            $vals = $request->inputdata;

          
            $mxnum = -1;
            foreach ($forms as $form) {
                if ($form['id'] > $mxnum) {
                    $mxnum = $form['id'];
                }
            }

            foreach ($vals as $key => $val) {

                $mxnum ++;
                $forms[] = [
                    'id' => $mxnum,
                    'name' => $val['name'],
                    'email' => $val['email'],
                ];
            }

            $customers->meta_value = json_encode($forms);
            $customers->save();

        } else {
            $vals = $request->inputdata;

            foreach ($vals as $key => $val) {

                $name = $val['name'];
                $email = $val['email'];
                $id = $key + 1;

                $forms[] = [
                    'id' => $id,
                    'name' => $name,
                    'email' => $email,
                ];
            }

            $data = [
                'meta_name' => 'customers',
                'meta_value' => json_encode($forms),
            ];
            $form = Form::updateOrCreate(
                ['meta_name' => 'customers'],
                $data
            );
        }
    }

    public function edit(int $id)
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

    public function update(Request $request, int $id)
    {
        $vals = $request->inputdata;

        foreach ($vals as $key => $val) {

            $name = $val['name'];
            $email = $val['email'];
            $id = $id;
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
        }
    }
    public function destroy(int $id)
    {
        $customers = Form::where('meta_name', 'customers')->first();
        $data = isset($customers->meta_value) ? json_decode($customers->meta_value, true) : [];

        $filteredForm = array_filter($data, function ($item) use ($id) {
            return $item['id'] !== $id;
        });

        $data = array_values($filteredForm);

        $customers->meta_value = json_encode($data);
        $customers->save();

        return redirect(route('forms.index'));
    }
}
