<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\User;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    public function index() {
        return view('user.index');
    }

    public function json() {
        $user = User::all();
        return DataTables::of($user)
            ->addColumn('role', function ($user) {
                return $user->role->nama;
            })
            ->addColumn('action', function ($user) {
                return '
                    <a href="/user/'.$user->id.'/edit"><i class="pe-7s-pen text-success"></i></a>
                    <span data-id="'.$user->id.'" data-npk="'.$user->npk.'" class="btnDelete"><i class="pe-7s-trash  text-danger"></i></span>
                ';
            })->make(true);
    }

    public function create() {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request) {
        $rules = [
            'npk' => 'required',
            'role_id' => 'required'
        ];

        if($request->role_id == 6) {
            $rules = array_merge($rules, [
                'departemen_id' => 'required'
            ]);
        }

        $request->validate($rules);

        $user = User::create(array_merge($request->all(), ['password' => Hash::make($request->npk)]));

        return redirect(url()->previous());
    }

    public function edit($id) {
        $roles = Role::all();
        $user = User::find($id);
        return view('user.edit', compact('roles', 'user'));
    }

    public function update($id, Request $request) {
        $rules = [
            'npk' => 'required',
            'role_id' => 'required'
        ];

        if($request->role_id == 6) {
            $rules = array_merge($rules, [
                'departemen_id' => 'required'
            ]);
        }

        $user = User::find($id);
        $user->update(array_merge($request->all(), ['password' => Hash::make($request->npk)]));
        return redirect(url()->previous());
    }

    public function ajaxDestroy($id) {
        $currentUserId = Auth::user()->id;
        if($currentUserId == $id)
            return response(['message' => 'error'], 500);
        $user = User::find($id);
        $user->delete();
    }
}
