<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::all();
        return response()->json($specialties);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $specialty = Specialty::create($validated);
        return response()->json($specialty);
    }

    public function show($id)
    {
        $specialty = Specialty::findOrFail($id);
        return response()->json($specialty);
    }

    public function update(Request $request, $id)
    {
        $specialty = Specialty::findOrFail($id);
        $validated = $request->validate([
            'name' => 'string|max:255',
        ]);

        $specialty->update($validated);
        return response()->json($specialty);
    }

    public function destroy($id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->delete();
        return response()->json(['message' => 'Specialty deleted successfully']);
    }
}
