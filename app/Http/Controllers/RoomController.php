<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('roomType')
            ->orderBy('room_number')
            ->get();

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $roomTypes = RoomType::orderBy('name')->get();

        return view('rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => [
                'required',
                'string',
                'max:50',
                'unique:rooms,room_number',
            ],
            'room_type_id' => [
                'required',
                'exists:room_types,id',
            ],
        ]);

        Room::create($validated);

        return redirect()
            ->route('rooms.index')
            ->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::orderBy('name')->get();

        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms', 'room_number')->ignore($room->id),
            ],
            'room_type_id' => [
                'required',
                'exists:room_types,id',
            ],
        ]);

        $room->update($validated);

        return redirect()
            ->route('rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        if ($room->reservations()->exists()) {
            return redirect()
                ->route('rooms.index')
                ->with('error', 'This room cannot be deleted because it has reservations.');
        }

        $room->delete();

        return redirect()
            ->route('rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}