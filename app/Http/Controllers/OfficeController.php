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
        return view('office.index');
    }
}
