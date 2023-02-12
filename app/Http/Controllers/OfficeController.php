<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class OfficeController extends Controller
{
    public function index()
    {
        $office_id=Auth::user()->office_id;
        //ddd($office_id);
        $location=Office::find($office_id)->location;
        //ddd($location);
        return view('office.index');
    }
}
