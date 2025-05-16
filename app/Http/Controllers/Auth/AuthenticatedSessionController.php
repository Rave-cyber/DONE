<?php

namespace App\Http\Controllers\Auth;

use App\Models\Employee;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();
        
        // Check if user is an employee and verify their status
        if ($user->role === 'employee') {
            $employee = Employee::where('user_id', $user->id)->first();
            
            // If employee record exists and status is inactive, log them out
            if ($employee && $employee->status === 'inactive') {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')
                    ->withErrors(['email' => 'Your account is inactive. Please contact an administrator.']);
            }
        }

        $request->session()->regenerate();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
         
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
