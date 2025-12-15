<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Check if email already exists
            if (User::where('email', $request->email)->exists()) {
                return response()->json(['error' => 'Email address already exists'], 422);
            }
            
            $plainPassword = $request->password;
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($plainPassword),
                'role' => $request->role ?? 'Employee',
            ]);
            
            // Send welcome email if notify is checked
            if ($request->notify_user) {
                try {
                    Mail::to($user->email)->send(new \App\Mail\WelcomeNewUser(
                        $user->name,
                        $user->email,
                        $plainPassword,
                        $user->role
                    ));
                    return response()->json(['user' => $user, 'email_sent' => true]);
                } catch (\Exception $mailError) {
                    return response()->json(['user' => $user, 'email_sent' => false, 'email_error' => $mailError->getMessage()]);
                }
            }
            
            return response()->json(['user' => $user, 'email_sent' => false]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];
        
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
