<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralsController extends Controller
{
    /**
     * [__construct 构造器方法 权限控制]
     * @author dante 2021-04-19
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }

    public function show()
    {
        return view('home');
    }
}
