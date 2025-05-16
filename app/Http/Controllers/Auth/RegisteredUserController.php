<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Employee;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate incoming data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the User record
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? User::ROLE_EMPLOYEE,
        ]);

        // Log the user ID for debugging
        Log::debug('User Created:', ['user_id' => $user->id]);

        // Create the Employee record and link it to the user
        Employee::create([
            'user_id' => $user->id, // Link employee to the user via user_id
            'first_name' => $request->name, 
            'last_name' => '',
            'email' => $request->email,
            'status' => 'inactive',
        ]);

        // Fire the Registered event
        event(new Registered($user));

        // Log the user in
        // Auth::login($user);

        // Redirect to the dashboard or another route
        return redirect(route('dashboard', absolute: false));
    }
}
