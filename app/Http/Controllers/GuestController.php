<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::latest()->get();

        return view('guests.index', compact('guests'));
    }

    public function create()
    {
        return view('guests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Guest::create($validated);

        return redirect()
            ->route('guests.index')
            ->with('success', 'Guest created successfully.');
    }

    public function edit(Guest $guest)
    {
        return view('guests.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $guest->update($validated);

        return redirect()
            ->route('guests.index')
            ->with('success', 'Guest updated successfully.');
    }

    public function destroy(Guest $guest)
    {
        if ($guest->reservations()->exists()) {
            return redirect()
                ->route('guests.index')
                ->with('error', 'This guest cannot be deleted because they have reservations.');
        }

        $guest->delete();

        return redirect()
            ->route('guests.index')
            ->with('success', 'Guest deleted successfully.');
    }
}