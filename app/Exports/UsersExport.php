<?php

namespace App\Exports;

use App\Models\Form;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Form::where('meta_value->id',1)->get();
    }
}
