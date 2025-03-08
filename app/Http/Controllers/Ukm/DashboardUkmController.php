<?php

namespace App\Http\Controllers\Ukm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardUkmController extends Controller
{
    public function index()
    {
        return view('admin.ukm.dashboard');
    }
}
