<?php

namespace App\Http\Controllers;


use App\Jobs\SendForgetPasswordEmail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\SendWelcomeEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registration(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        // Check if the email is already taken
        $existinguser = User::where('email', $credentials['email'])->first();
        if ($existinguser) {
            return response()->json(['error' => 'Email already in use'], 400);
        }

        $user = new User;
        $user->name = $credentials['name'];
        $user->email = $credentials['email'];
        $user->password = bcrypt($credentials['password']);
        $user->save();

        $formData = [
            'name' => $credentials['name'],
            'email' => $credentials['email']
        ];

        SendWelcomeEmail::dispatch($formData);

        return response()->json(['message' => 'User created successfully']);
    }


    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required | email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            // $user = auth()->user;
            // $user = Auth::user()->id;
            if ($user && Hash::check($credentials['password'], $user->password)) {
                $token = $request->user()->createToken('api_token')->plainTextToken;
                return response()->json(['user' => $user, 'token' => $token]);
            }
        }
        return response()->json(['error' => 'Email or password is incorrect'], 401);
    }

    public function userinfo(Request $request)
    {
        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        $user = $request->user();
        return response()->json(['user' => $user]);
    }

    public function userinfoUpdate(Request $request)
    {
        // Ensure the user is authenticated
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $formData = $request->validate([
            'name'    => 'required',
            'email'   => 'required|unique:users,email,' . $user->id,
            'user_id' => 'required|exists:users,id',
            'image'    => 'nullable',
            'oldpassword' => 'nullable|required_with:password',
            'password'    => 'nullable|min:6',
        ]);

        if (request()->hasFile('image')) {
            $formData['image'] = request()->file('image')->store('profilepictures');
        }

        // Check if 'oldpassword' is provided
        if (isset($formData['oldpassword'])) {
            // Verify the old password
            if (!Hash::check($formData['oldpassword'], $user->password)) {
                return response()->json(['error' => 'Old password is incorrect'], 422);
            }

            // Update the password if old password is correct
            $formData['password'] = bcrypt($formData['password']);
        }

        $updateData = [
            'name' => $formData['name'],
            'email' => $formData['email'],
        ];


        if ($formData['password']) {
            $updateData['password'] = $formData['password'];
        }

        if ($formData['image']) {
            $updateData['image'] = $formData['image'];
        }

        $user->update($updateData);

        return response()->json(['message' => 'successfully updated']);
    }


    public function signout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged Out'], 200);
        } catch (\Exception $e) {
            Log::error('Error during logout: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred during logout'], 500);
        }
    }

    public function forgetpassword(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            return response()->json(['error' => 'An email with the password reset link has been sent. Please check your email.'], 422);
        }

        $user->remember_token = Str::random(40);
        $user->save();

        SendForgetPasswordEmail::dispatch($user);
        return response()->json([
            'token' => $user->remember_token,
            'message'   => 'An email with the password reset link has been sent. Please check your email.'
        ], 200);
    }

    public function resetpassword(Request $request)
    {
        $user = User::where('remember_token', $request->token)
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid Credentials'], 404);
        }

        if ($request->password == $request->cPassword) {
            $user->update([
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
            ]);

            // Regenerate remember_token
            $user->remember_token = Str::random(40);
            $user->save();

            return response()->json(['message' => 'Password reset successfully'], 200);
        } else {
            return response()->json(['error' => 'Password and confirmed password do not match.']);
        }
    }
}
