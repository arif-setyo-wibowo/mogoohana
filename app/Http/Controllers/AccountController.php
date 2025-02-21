<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = auth()->user()->pembelian()->with('details')->latest()->get();

        return view('my-account', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Update account details.
     */
    public function updateAccountDetails(Request $request)
    {
        $user = Auth::user();

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'display_name' => 'required|string|max:255',
            ]);

            $user->name = $validatedData['name'];
            $user->display_name = $validatedData['display_name'];
            $user->email = $validatedData['email'];

            $user->update();

            return redirect()->route('my-account.index')
                ->with('success_message', 'Account details updated successfully!')
                ->with('alert_type', 'success');
        } catch (\Exception $e) {
            return redirect()->route('my-account.index')
                ->with('error_message', 'Failed to update account details. Please try again.')
                ->with('alert_type', 'error');
        }
    }

    /**
     * Change password.
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        try {
            $validatedData = $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ], [
                'current_password.required' => 'Please enter your current password.',
                'new_password.required' => 'Please enter a new password.',
                'new_password.min' => 'New password must be at least 8 characters long.',
                'new_password.confirmed' => 'New password confirmation does not match.',
            ]);

            if (!Hash::check($validatedData['current_password'], $user->password)) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Current password is incorrect.'
                    ], 400);
                }

                return redirect()->route('my-account.index')
                    ->with('error_message', 'Current password is incorrect.')
                    ->with('alert_type', 'error');
            }

            $user->update([
                'password' => Hash::make($validatedData['new_password']),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password changed successfully!'
                ]);
            }

            return redirect()->route('my-account.index')
                ->with('success_message', 'Password changed successfully!')
                ->with('alert_type', 'success');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to change password. Please try again.'
                ], 500);
            }

            return redirect()->route('my-account.index')
                ->with('error_message', 'Failed to change password. Please try again.')
                ->with('alert_type', 'error');
        }
    }

    /**
     * Fetch and display order details.
     */
    public function orderDetails($nomer_order)
    {
        $order = auth()->user()->pembelian()
            ->with(['details.produk'])
            ->where('nomer_order', $nomer_order)
            ->firstOrFail();

        return view('order-details', compact('order'));
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendPasswordResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show password reset form
     */
    public function showPasswordResetForm($token)
    {
        return view('reset-password', ['token' => $token]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login.index')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
