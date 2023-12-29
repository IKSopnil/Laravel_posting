<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
{
    $incoming_field=$request->validate([
        'name'=>['required','min:3','max:10'],
        'email'=>['required','email'],
        'password'=>['required','min:8','max:200']
    ]);

    $incoming_field['password']= bcrypt($incoming_field['password']);
    $user=User::create($incoming_field);
    auth()->login($user);
    return redirect('/');
}}
