<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(Request $request) : View|RedirectResponse
    {
        $user = $request->user();
        if($user->hasRole('admin')){
            return redirect(RouteServiceProvider::ADMIN_HOME);
        }
        return view('dashboard');
    }
}
