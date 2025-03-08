<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $user = Auth::user();
        // $profil = Profil::where('user_id', $user->id)->firstOrFail();

        return view('admin.bem.dashboard');
    }
}
