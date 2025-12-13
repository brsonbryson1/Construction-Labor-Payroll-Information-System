<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laborer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LaborerController extends Controller
{
    public function index()
    {
        $laborers = Laborer::all();
        return view('laborers.index', compact('laborers'));
    }

    public function show($id)
    {
        $laborer = Laborer::findOrFail($id);
        return response()->json($laborer);
    }

    public function store(Request $request)
    {
        // Create the laborer
        $laborer = Laborer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'job_position' => $request->job_position,
            'daily_rate' => $request->daily_rate,
            'contact' => $request->contact,
        ]);

        // Also create a user account if email is provided
        $user = null;
        if ($request->email) {
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make('password'), // Default password
                'role' => 'Employee',
            ]);
        }

        return response()->json([
            'laborer' => $laborer,
            'user' => $user,
            'message' => $user ? 'Laborer and user account created successfully' : 'Laborer created successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $laborer = Laborer::findOrFail($id);
        $laborer->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'job_position' => $request->job_position,
            'daily_rate' => $request->daily_rate,
            'contact' => $request->contact,
        ]);
        return response()->json($laborer);
    }

    public function destroy($id)
    {
        $laborer = Laborer::findOrFail($id);
        $laborer->delete();
        return response()->json(['message' => 'Laborer deleted']);
    }
}
