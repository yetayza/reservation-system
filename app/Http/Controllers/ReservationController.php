<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    public function availableRooms(Request $request)
    {
        $validated = $request->validate([
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'reservation_id' => ['nullable', 'exists:reservations,id'],
        ]);

        $query = Reservation::where('status', '!=', 'cancelled')
            ->where('check_in', '<', $validated['check_out'])
            ->where('check_out', '>', $validated['check_in']);

        // When editing a reservation, ignore that reservation itself.
        if (!empty($validated['reservation_id'])) {
            $query->where('id', '!=', $validated['reservation_id']);
        }

        $reservedRoomIds = $query->pluck('room_id');

        $rooms = Room::with('roomType.category')
            ->whereNotIn('id', $reservedRoomIds)
            ->orderBy('room_number')
            ->get();

        return response()->json([
            'count' => $rooms->count(),
            'rooms' => $rooms,
        ]);
    }
    public function index(Request $request)
    {
        $query = Reservation::with([
            'guest',
            'room.roomType.category',
            'createdBy',
        ]);

        // Search by guest name or room number.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {

                $query->whereHas('guest', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });

                $query->orWhereHas('room', function ($query) use ($search) {
                    $query->where('room_number', 'like', '%' . $search . '%');
                });

            });
        }

        // Filter by status.
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by check-in date.
        if ($request->filled('check_in')) {
            $query->whereDate('check_in', $request->check_in);
        }

        // Filter by check-out date.
        if ($request->filled('check_out')) {
            $query->whereDate('check_out', $request->check_out);
        }

        $reservations = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $guests = Guest::orderBy('name')->get();

        $rooms = Room::with('roomType.category')
            ->orderBy('room_number')
            ->get();

        return view('reservations.create', compact('guests', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_name' => [
                'required',
                'string',
                'max:255',
            ],

            'room_id' => [
                'required',
                'exists:rooms,id',
            ],

            'check_in' => [
                'required',
                'date',
            ],

            'check_out' => [
                'required',
                'date',
                'after:check_in',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'reserved',
                    'checked_in',
                    'checked_out',
                    'cancelled',
                ]),
            ],
            'source' => [
                'required',
                Rule::in([
                    'direct',
                    'ota',
                ]),
            ],

            'channel' => [
                'nullable',
                'string',
                'max:255',
                'required_if:source,ota',
            ],

            'ota_booking_id' => [
                'nullable',
                'string',
                'max:255',
                'required_if:source,ota',
            ],
        ]);
        $guest = Guest::firstOrCreate([
            'name' => trim($validated['guest_name']),
        ]);
        $hasConflict = Reservation::where('room_id', $validated['room_id'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($validated) {
                $query
                    ->where('check_in', '<', $validated['check_out'])
                    ->where('check_out', '>', $validated['check_in']);
            })
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'room_id' => 'This room is already reserved during the selected dates.',
                ]);
        }

        Reservation::create([
            'guest_id' => $guest->id,
            'room_id' => $validated['room_id'],
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'price' => $validated['price'],
            'status' => $validated['status'],
            'source' => $validated['source'],
            'channel' => $validated['source'] === 'ota'
                ? $validated['channel']
                : null,
            'ota_booking_id' => $validated['source'] === 'ota'
                ? $validated['ota_booking_id']
                : null,
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation created successfully.');
    }

    public function edit(Reservation $reservation)
    {
        $guests = Guest::orderBy('name')->get();

        $rooms = Room::with('roomType.category')
            ->orderBy('room_number')
            ->get();

        return view('reservations.edit', compact(
            'reservation',
            'guests',
            'rooms'
        ));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'guest_name' => [
                'required',
                'string',
                'max:255',
            ],

            'room_id' => [
                'required',
                'exists:rooms,id',
            ],

            'check_in' => [
                'required',
                'date',
            ],

            'check_out' => [
                'required',
                'date',
                'after:check_in',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'reserved',
                    'checked_in',
                    'checked_out',
                    'cancelled',
                ]),
            ],
            'source' => [
                'required',
                Rule::in([
                    'direct',
                    'ota',
                ]),
            ],

            'channel' => [
                'nullable',
                'string',
                'max:255',
                'required_if:source,ota',
            ],

            'ota_booking_id' => [
                'nullable',
                'string',
                'max:255',
                'required_if:source,ota',
            ],
        ]);

        $guest = Guest::firstOrCreate([
            'name' => trim($validated['guest_name']),
        ]);

        $hasConflict = Reservation::where('room_id', $validated['room_id'])
            ->where('id', '!=', $reservation->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($validated) {
                $query
                    ->where('check_in', '<', $validated['check_out'])
                    ->where('check_out', '>', $validated['check_in']);
            })
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'room_id' => 'This room is already reserved during the selected dates.',
                ]);
        }

        $reservation->update([
            'guest_id' => $guest->id,
            'room_id' => $validated['room_id'],
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'price' => $validated['price'],
            'status' => $validated['status'],
            'source' => $validated['source'],
            'channel' => $validated['source'] === 'ota'
                ? $validated['channel']
                : null,
            'ota_booking_id' => $validated['source'] === 'ota'
                ? $validated['ota_booking_id']
                : null,
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        if ($reservation->status === 'cancelled') {
            return back()->withErrors([
                'reservation' => 'This reservation is already cancelled.',
            ]);
        }

        $reservation->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation cancelled successfully.');
    }
}