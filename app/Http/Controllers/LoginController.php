<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function authenticate()
    {
        $credentials = request()->validate([
            'username' => 'required',
            'password' => 'required'
        ]);


        $user = DB::select('select * from users where username = ?', [$credentials['username']]);

        if ($user) {
            $user = $user[0];

            if (Hash::check($credentials['password'], $user->password)) {
                session(['user_id' => $user->id]);
                request()->session()->regenerate();

                toast('Berhasil login!', 'success');
                return redirect()->intended('/dashboard/booking');
            }
        }

        toast('Login gagal!', 'error');
        return back();
    }

    public function logout()
    {
        session()->forget('user_id');
        session()->invalidate();
        session()->regenerateToken();

        toast('Berhasil Logout!', 'success');
        return redirect('/');
    }
}
