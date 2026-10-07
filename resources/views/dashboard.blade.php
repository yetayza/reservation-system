@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="max-w-[1400px] mx-auto">

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Dashboard
        </h1>

        <p class="mt-1 text-gray-500">
            Best Bangkok House Reservation System
        </p>
    </div>


    {{-- Statistics --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    {{-- Total Rooms --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 text-center">

        <div class="flex justify-center mb-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center">
                <span class="text-3xl">
                    🏨
                </span>
            </div>
        </div>

        <p class="text-base font-medium text-gray-500">
            Total Rooms
        </p>

        <p class="mt-2 text-4xl font-bold text-gray-900">
            {{ $totalRooms }}
        </p>

    </div>


    {{-- Available Rooms --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 text-center">

        <div class="flex justify-center mb-4">
            <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center">
                <span class="text-3xl">
                    ✓
                </span>
            </div>
        </div>

        <p class="text-base font-medium text-gray-500">
            Available Rooms
        </p>

        <p class="mt-2 text-4xl font-bold text-gray-900">
            {{ $availableRooms }}
        </p>

    </div>


    {{-- Reservations --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 text-center">

        <div class="flex justify-center mb-4">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center">
                <span class="text-3xl">
                    📅
                </span>
            </div>
        </div>

        <p class="text-base font-medium text-gray-500">
            Reservations
        </p>

        <p class="mt-2 text-4xl font-bold text-gray-900">
            {{ $reservations }}
        </p>

    </div>


    {{-- Guests --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 text-center">

        <div class="flex justify-center mb-4">
            <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center">
                <span class="text-3xl">
                    👥
                </span>
            </div>
        </div>

        <p class="text-base font-medium text-gray-500">
            Occupied room
        </p>

        <p class="mt-2 text-4xl font-bold text-gray-900">
            {{ $guests }}
        </p>

    </div>

</div>


    {{-- Reservation Calendar Placeholder --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">

        <div class="p-6 border-b border-gray-200">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Reservation Calendar
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        7-day room availability
                    </p>
                </div>

                <div class="flex items-center gap-2">

                    <a
                        href="{{ route('dashboard', ['date' => $startDate->copy()->subDays(7)->format('Y-m-d')]) }}"
                        class="px-3 py-2 rounded-lg border border-gray-300 text-sm font-medium hover:bg-gray-50 transition"
                    >
                        ← Previous
                    </a>

                    <a
                        href="{{ route('dashboard') }}"
                        class="px-3 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition"
                    >
                        Today
                    </a>

                    <a
                        href="{{ route('dashboard', ['date' => $startDate->copy()->addDays(7)->format('Y-m-d')]) }}"
                        class="px-3 py-2 rounded-lg border border-gray-300 text-sm font-medium hover:bg-gray-50 transition"
                    >
                        Next →
                    </a>

                </div>

            </div>

        </div>


    
        {{-- Reservation Calendar --}}
<div class="overflow-hidden">

    {{-- Calendar Header --}}
    <div class="overflow-x-auto">

        <div class="min-w-[1500px]">

            {{-- Day Header --}}
            <div class="grid grid-cols-[140px_repeat(14,minmax(90px,1fr))] border-b border-gray-200">

                {{-- Room Header --}}
                <div class="bg-gray-50 border-r border-gray-200 p-3 sticky left-0 z-20 flex items-center">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Room
                    </p>
                </div>

                {{-- Seven Days --}}
                @foreach($calendarDates as $date)

                    @php
                        $isToday = $date->isToday();
                    @endphp

                    {{-- Day --}}
                    <div class="col-span-2 {{ $isToday ? 'bg-blue-50' : 'bg-gray-50' }} border-r border-gray-200">

                        {{-- Day Name --}}
                        <div class="h-[86px] py-3 text-center border-b border-gray-200">
                            

                                <div class="flex items-center justify-center gap-2">

                                    <p class="text-sm font-semibold {{ $isToday ? 'text-blue-600' : 'text-gray-500' }}">
                                        {{ $date->format('D') }}
                                    </p>

                                    <p class="text-lg font-bold {{ $isToday ? 'text-blue-700' : 'text-gray-900' }}">
                                        {{ $date->format('d') }}
                                    </p>

                                    <p class="text-sm {{ $isToday ? 'text-blue-500' : 'text-gray-500' }}">
                                        {{ $date->format('M') }}
                                    </p>

                                </div>

                                @if($isToday)

                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full bg-blue-600 text-white text-[10px] font-semibold">
                                        TODAY
                                    </span>

                                @endif
                            
                            
                        </div>

                        {{-- Time Periods --}}
                        <div class="grid grid-cols-2 text-center">

                            <div class="py-2 border-r border-gray-200">
                                <p class="text-[10px] font-medium {{ $isToday ? 'text-blue-500' : 'text-gray-400' }}">
                                    00:00 - 12:00
                                </p>
                            </div>

                            <div class="py-2">
                                <p class="text-[10px] font-medium {{ $isToday ? 'text-blue-500' : 'text-gray-400' }}">
                                    12:00 - 24:00
                                </p>
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Room Rows Grouped By Room Type --}}

@foreach($rooms->groupBy(fn($room) => $room->roomType->id) as $roomTypeId => $roomTypeRooms)

    @php
        $roomType = $roomTypeRooms->first()->roomType;
    @endphp

    {{-- Room Type Header --}}
    <div class="grid grid-cols-[140px_repeat(14,minmax(90px,1fr))]">

        <div
            class="col-span-15
                bg-gradient-to-r from-gray-800 to-gray-700
                border-b border-gray-600
                px-5 py-2.5
                sticky left-0 z-10"
        >

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <div class="w-1 h-6 rounded-full bg-blue-400"></div>

                    <div>
                        <p class="text-sm font-bold text-white tracking-wide">
                            {{ $roomType->name }}
                        </p>

                        <p class="text-[10px] text-gray-300 mt-0.5">
                            {{ $roomTypeRooms->count() }}
                            {{ $roomTypeRooms->count() === 1 ? 'room' : 'rooms' }}
                        </p>
                    </div>

                </div>

                <span class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">
                    {{ $roomTypeRooms->count() }}
                    {{ $roomTypeRooms->count() === 1 ? 'Room' : 'Rooms' }}
                </span>

            </div>

        </div>

    </div>


                {{-- Rooms Under This Room Type --}}
                @foreach($roomTypeRooms as $room)

                    @php
                        $roomReservations = $calendarReservations
                            ->where('room_id', $room->id);
                    @endphp


                    <div class="grid grid-cols-[140px_repeat(14,minmax(90px,1fr))] border-b border-gray-200 hover:bg-gray-50/30 transition-colors">

                        {{-- Room Information --}}
                        <div class="bg-white border-r border-gray-200 p-4 sticky left-0 z-10
                                    hover:bg-gray-50 transition-colors">

                            <p class="text-sm font-bold text-gray-900">
                                Room {{ $room->room_number }}
                            </p>

                        </div>


                        {{-- Timeline --}}
                        <div class="col-span-14 relative h-14 bg-white overflow-hidden">

                            {{-- Half-day Grid Lines --}}
                            <div class="absolute inset-0 grid grid-cols-14 pointer-events-none">

                                @for($i = 0; $i < 14; $i++)

                                    <div
                                        class="border-r border-gray-100
                                        {{ $i % 2 === 1 ? 'bg-gray-50/40' : '' }}"
                                    ></div>

                                @endfor

                            </div>


                            {{-- Reservations --}}
                            @foreach($roomReservations as $reservation)

                                @php

                                    $timelineStart = $startDate->copy()->startOfDay();

                                    $timelineEnd = $endDate->copy()->addDay()->startOfDay();

                                    $reservationStart = $reservation->check_in->copy();
                                    $reservationEnd = $reservation->check_out->copy();

                                    $visibleStart = $reservationStart->greaterThan($timelineStart)
                                        ? $reservationStart
                                        : $timelineStart;

                                    $visibleEnd = $reservationEnd->lessThan($timelineEnd)
                                        ? $reservationEnd
                                        : $timelineEnd;

                                    $totalHours = $timelineStart->diffInMinutes($timelineEnd) / 60;

                                    $leftHours = $timelineStart->diffInMinutes($visibleStart) / 60;

                                    $durationHours = $visibleStart->diffInMinutes($visibleEnd) / 60;

                                    $leftPercent = ($leftHours / $totalHours) * 100;

                                    $widthPercent = ($durationHours / $totalHours) * 100;

                                    $reservationClass = match($reservation->status) {
                                        'reserved' => 'bg-orange-400 border-orange-500',
                                        'checked_in' => 'bg-green-500 border-green-600',
                                        'checked_out' => 'bg-gray-400 border-gray-500',
                                        default => 'bg-blue-400 border-blue-500',
                                    };

                                @endphp


                                <a
                                    href="{{ route('reservations.edit', $reservation) }}"
                                    title="{{ $reservation->guest->name }} | {{ $reservation->check_in->format('d M H:i') }} → {{ $reservation->check_out->format('d M H:i') }}"
                                    class="absolute top-2 h-12 rounded-md border shadow-sm
                                        px-4 py-2 text-white overflow-hidden
                                        hover:brightness-95 hover:shadow-md hover:-translate-y-0.5
                                        transition-all
                                        {{ $reservationClass }}"
                                    style="
                                        left: {{ $leftPercent }}%;
                                        width: {{ $widthPercent }}%;
                                        min-width: 70px;
                                    "
                                >

                                    <div class="font-semibold text-xs truncate leading-4">
                                        {{ $reservation->guest->name }}
                                    </div>

                                    <div class="text-[10px] opacity-90 truncate leading-3">
                                        {{ $reservation->check_in->format('d M H:i') }}
                                        →
                                        {{ $reservation->check_out->format('d M H:i') }}
                                    </div>

                                </a>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            @endforeach

        </div>

    </div>

</div>


        {{-- Calendar Legend --}}
        <div class="px-6 py-4 border-t border-gray-200">

            <div class="flex flex-wrap items-center gap-6 text-sm">

                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded bg-orange-400"></span>
                    <span class="text-gray-600">
                        Reserved
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded bg-green-500"></span>
                    <span class="text-gray-600">
                        Checked In
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded bg-gray-400"></span>
                    <span class="text-gray-600">
                        Checked Out
                    </span>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection