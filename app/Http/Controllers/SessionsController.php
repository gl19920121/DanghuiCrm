<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;
use DateTime;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'create', 'store']
        ]);
        $this->middleware('guest', [
            'only' => ['create']
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
        $bgNum = (int)date("w");
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
        // if (Gate::allows('user-status', Auth::user()->id)) {
        //     return redirect()->back()->withInput()->withErrors(['password' => '账户名密码不匹配']);
        // }
        $messages = [
            'account.required' => '请填写用户名',
            'password.required' => '请填写密码'
        ];
        $credentials = $this->validate($request, [
            'account' => 'bail|required',
            'password' => 'required'
        ], $messages);

        $credentials['status'] = 1;
        if(Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();
            $user->login_on = new DateTime();
            $user->save();
            $fallback = route('home');
            return redirect()->intended($fallback);
        } else {
            // session()->flash('result', false);
            return redirect()->back()->withInput()->withErrors(['password' => '账户名密码不匹配']);
        }

        return;
    }

    public function destroy()
    {
        $user = Auth::user();
        $user->logout_on = new DateTime();
        $user->save();
        Auth::logout();
        return redirect('login');
    }
}
