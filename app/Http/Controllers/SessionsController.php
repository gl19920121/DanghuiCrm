<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest', [
        //     'only' => ['create', 'store']
        // ]);
        $this->middleware('auth', [
            'except' => ['index', 'create', 'store']
        ]);
    }

    public function index()
    {
        if(Auth::check()) { //已登录
            return redirect()->route('home');
        } else { //未登录
            return redirect()->route('login');
        }
    }

    /**
     * [create 账户登录 GET]
     * @author dante 2021-04-16
     * @return [type] [description]
     */
    public function create()
    {
        $bgNum = date("w");
        $bgNum = ($bgNum === 6 || $bgNum === 0) ? 5 : $bgNum;
        return view('sessions.create')->with('bgNum', $bgNum);
    }

    /**
     * [store 账户登录 POST]
     * @author dante 2021-04-16
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'account' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials, $request->has('remember'))) {
            session()->flash('success', '欢迎');
            $fallback = route('home'); //Auth::user()
            return redirect()->intended($fallback);
        } else {
            session()->flash('danger', '账户名密码不匹配');
            return redirect()->back()->withInput();
        }

        return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '成功退出');
        return redirect('login');
    }
}
