<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $hotels = Hotel::paginate(8); 
        return response()->json($hotels);
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        return response()->json($hotel);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'cost_per_night' => 'nullable|numeric|min:0',
            'available_rooms' => 'nullable|integer|min:1',
            'rating' => 'nullable|numeric|min:0|max:5',
            'image_url' => 'nullable|string',
        ]);

        $hotel = Hotel::create($validated);

        return response()->json(['message' => 'Hotel added successfully', 'hotel' => $hotel], 201);
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'cost_per_night' => 'required|numeric|min:0',
            'available_rooms' => 'required|integer|min:1',
            'rating' => 'required|numeric|min:0|max:5',
            'image_url' => 'nullable|string',
        ]);

        $hotel->update($validated);

        return response()->json(['message' => 'Hotel updated successfully', 'hotel' => $hotel]);
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return response()->json(['message' => 'Hotel deleted successfully']);
    }



}
