<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TestReservationSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Remove previous test data
        |--------------------------------------------------------------------------
        */

        $testGuests = Guest::where('name', 'like', 'Test Guest %')->get();

        foreach ($testGuests as $guest) {
            Reservation::where('guest_id', $guest->id)->delete();
        }

        Guest::where('name', 'like', 'Test Guest %')->delete();

        /*
        |--------------------------------------------------------------------------
        | Get existing rooms
        |--------------------------------------------------------------------------
        */

        $rooms = Room::orderBy('room_number')->get();

        if ($rooms->isEmpty()) {
            $this->command->error(
                'No rooms found. Please create some rooms first.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Create 30 test guests
        |--------------------------------------------------------------------------
        */

        $guests = collect();

        for ($i = 1; $i <= 30; $i++) {

            $guests->push(
                Guest::create([
                    'name' => 'Test Guest ' . str_pad($i, 2, '0', STR_PAD_LEFT),
                ])
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create 50 test reservations
        |--------------------------------------------------------------------------
        */

        $today = Carbon::today();

        $statuses = [
            'reserved',
            'checked_in',
            'checked_out',
        ];

        for ($i = 1; $i <= 50; $i++) {

            // Rotate through the existing rooms.
            $room = $rooms[($i - 1) % $rooms->count()];

            // Determine which reservation slot this is for this room.
            $roomSlot = intdiv($i - 1, $rooms->count());

            /*
            Each reservation lasts 3 nights.
            There is a 2-day gap between reservations for the same room.
            This guarantees no overlapping test reservations.
            */
            $checkIn = $today->copy()
                ->addDays(($roomSlot * 5) - 12);

            $checkOut = $checkIn->copy()->addDays(3);

            /*
            Determine a realistic status based on the dates.
            */
            if ($checkOut->lt($today)) {

                $status = 'checked_out';

            } elseif (
                $checkIn->lte($today) &&
                $checkOut->gt($today)
            ) {

                $status = 'checked_in';

            } else {

                $status = 'reserved';
            }

            /*
            Give some reservations different statuses
            so the list and dashboard have variety.
            */
            if ($i % 10 === 0) {
                $status = 'cancelled';
            }

            Reservation::create([
                'guest_id' => $guests[($i - 1) % $guests->count()]->id,
                'room_id' => $room->id,
                'check_in' => $checkIn->copy()->setTime(14, 0),
                'check_out' => $checkOut->copy()->setTime(12, 0),
                'price' => rand(1500, 5000),
                'status' => $status,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Done
        |--------------------------------------------------------------------------
        */

        $this->command->info('Test data created successfully.');
        $this->command->info('30 test guests created.');
        $this->command->info('50 test reservations created.');
    }
}