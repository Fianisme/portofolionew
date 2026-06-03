<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected ContentService $content;

    public function __construct(ContentService $content)
    {
        $this->content = $content;
    }

    public function showLogin()
    {
        // Redirect if already logged in
        if (Session::get('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login', [
            'title' => 'Admin Login',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $users = $this->content->get('users');
        $username = $request->input('username');
        $password = $request->input('password');

        foreach ($users as $user) {
            if ($user['username'] === $username && Hash::check($password, $user['password'])) {
                // Login success
                Session::put('admin_logged_in', true);
                Session::put('admin_user', [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'name' => $user['name'],
                    'role' => $user['role'],
                ]);
                Session::regenerate();

                return redirect()->route('admin.dashboard')
                    ->with('success', 'Welcome back, ' . $user['name'] . '!');
            }
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['username' => 'Invalid username or password.']);
    }

    public function logout(Request $request)
    {
        Session::forget('admin_logged_in');
        Session::forget('admin_user');
        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Logged out successfully.');
    }
}
