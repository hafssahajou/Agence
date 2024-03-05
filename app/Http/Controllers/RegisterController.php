<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function Register(RegisterRequest $request){
        $incomingFields = $request->validated();
        $incomingFields['password'] = bcrypt($incomingFields['password']);
        $user = User::create($incomingFields);
        auth()->login($user);
        if ($incomingFields['role'] === 'client') {
        return redirect('/client/dashboard');
    } elseif ($incomingFields['role'] === 'owner') {
        return redirect('/owner/dashboard');
    } else {
        // Gestion du cas où le rôle n'est ni 'client' ni 'owner'
        return redirect('/login')->with('error', 'Invalid role');
    }
    }
}
