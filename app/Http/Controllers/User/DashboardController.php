<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $services = Service::all();

        return view('user.dashboard', compact('services'));
    }
}
