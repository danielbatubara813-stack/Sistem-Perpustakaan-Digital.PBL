<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LogoutController extends Controller
{
    // Logout Anggota
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        // Forget the remember me cookie if present
        try {
            Cookie::queue(Cookie::forget(Auth::getRecallerName()));
        } catch (\Throwable $e) {
            // ignore if not available
        }

        $request->session()->invalidate();
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->route('home-page');
    }

    // Logout Admin
    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();

        try {
            Cookie::queue(Cookie::forget(Auth::getRecallerName()));
        } catch (\Throwable $e) {
        }

        $request->session()->invalidate();
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->route('home-page');
    }
}

