<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $incoming_field = $request->validate([
            "loginname" => 'required',
            "loginpassword" => 'required',

        ]);

        if (auth()->attempt(['name' => $incoming_field['loginname'], 'password' => $incoming_field['loginpassword']])) {
            $request->session()->regenerate();
        }
        return redirect('/');
    }

    public function logout()
    {

        auth()->logout();
        return redirect('/');
    }
    public function register(Request $request)
    {
        $incoming_field = $request->validate([
            'name' => ['required', 'min:3', 'max:20', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:3', 'max:200']
        ]);

        $incoming_field['password'] = bcrypt($incoming_field['password']);
        $user = User::create($incoming_field);
        auth()->login($user);
        return redirect('/');
    }
}
