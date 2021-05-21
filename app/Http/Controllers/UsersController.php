<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
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

    /**
     * [index description]
     * @author dante 2021-04-16
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index(Request $request)
    {
        return User::all();
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $part = $request->part;
        return view('users.edit', compact('user', 'part'));
    }

    /**
     * [store 创建账户 POST]
     * @author dante 2021-04-16
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'account' => 'required|unique:users|max:50',
            'password' => 'required|confirmed|min:10|max:16',
            'name' => 'required|string|max:255',
            'sex' => 'nullable|string|max:2',
            'job' => 'nullable|string|max:255',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email|max:255'
        ]);

        $user = User::create([
            'account' => $request->account,
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'sex' => $request->sex,
            'job' => $request->job,
            'phone' => $request->phone,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'se_jobtasks_id' => $request->se_tasks_id,
            're_jobtasks_id' => $request->re_tasks_id,
            'remember_token' => $request->remember_token,
            'status' => $request->status
        ]);

        session()->flash('success', '注册成功');
        return redirect()->route('users.show', [$user]);
    }

    /**
     * [update description]
     * @author dante 2021-04-16
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        // $this->validate($request, [
        //     'account' => 'required|max:50',
        //     'password' => 'required|min:10|max:16',
        //     'name' => 'required|string|max:255'
        // ]);

        $data = $request->toArray();
        // foreach ($data as $key => $value) {
        //     if (isset($user->$key)) {
        //         $user->$key = $value;
        //     }
        // }
        // $user->save();
        $user->update($data);

        session()->flash('success', '修改成功');
        return redirect()->route('users.show', [$user]);
    }

    /**
     * [destroy 删除账户 POST]
     * @author dante 2021-04-16
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '删除成功');
        return back();
    }
}
