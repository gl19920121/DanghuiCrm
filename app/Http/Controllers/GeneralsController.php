<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class GeneralsController extends Controller
{
    public function show()
    {
        // $this->authorize('view', [User::Class, Route::current()]);
        return view('home');
    }
}
