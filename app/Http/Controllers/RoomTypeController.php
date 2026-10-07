<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with('category')
            ->latest()
            ->get();

        return view('room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('room-types.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        RoomType::create($validated);

        return redirect()
            ->route('room-types.index')
            ->with('success', 'Room type created successfully.');
    }

    public function edit(RoomType $roomType)
    {
        $categories = Category::orderBy('name')->get();

        return view('room-types.edit', compact('roomType', 'categories'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $roomType->update($validated);

        return redirect()
            ->route('room-types.index')
            ->with('success', 'Room type updated successfully.');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();

        return redirect()
            ->route('room-types.index')
            ->with('success', 'Room type deleted successfully.');
    }
}