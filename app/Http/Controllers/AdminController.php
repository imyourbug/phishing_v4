<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Toastr;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function checkLogin(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|email:rfc,dns',
                'password' => 'required|min:6',
            ]);
            if (auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                Toastr::success('Login successfully', 'Success');

                return redirect()->intended('/languages');
            } else {
                Toastr::error('Login failed', 'Failed');
            }
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), 'Failed');
        }

        return redirect()->back();
    }
}
