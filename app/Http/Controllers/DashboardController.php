<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();

        $today = Carbon::today();

        $reservations = Reservation::whereDate('check_in', $today)
            ->where('status', '!=', 'cancelled')
            ->count();

        $guests = Reservation::where('status', 'checked_in')
            ->count();

        $startDate = request()->filled('date')
            ? Carbon::parse(request('date'))->startOfDay()
            : Carbon::today();

        $endDate = $startDate->copy()->addDays(6);

        $occupiedRoomIds = Reservation::where('status', '!=', 'cancelled')
            ->where('check_in', '<', $endDate->copy()->addDay()->startOfDay())
            ->where('check_out', '>', $startDate->copy()->startOfDay())
            ->pluck('room_id')
            ->unique();

        $availableRooms = Room::whereNotIn('id', $occupiedRoomIds)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 7-Day Reservation Calendar
        |--------------------------------------------------------------------------
        */

        $startDate = request()->filled('date')
        ? Carbon::parse(request('date'))->startOfDay()
        : Carbon::today();

        $endDate = $startDate->copy()->addDays(6);

        $calendarDates = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $calendarDates[] = $date->copy();
        }

        $calendarReservations = Reservation::with([
            'guest',
            'room.roomType',
        ])
            ->where('status', '!=', 'cancelled')
            ->where('check_in', '<', $endDate->copy()->addDay()->startOfDay())
            ->where('check_out', '>', $startDate->copy()->startOfDay())
            ->orderBy('check_in')
            ->get();

        $rooms = Room::with('roomType')
            ->orderBy('room_number')
            ->get();

        return view('dashboard', compact(
            'totalRooms',
            'availableRooms',
            'reservations',
            'guests',
            'calendarDates',
            'calendarReservations',
            'rooms',
            'startDate',
            'endDate'
        ));
    }
}