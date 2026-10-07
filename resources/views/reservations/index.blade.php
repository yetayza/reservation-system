@extends('layouts.app')

@section('title', 'Reservations - BestBKK Reservation')

@section('content')

    <div class="page-title" style="display: flex; justify-content: space-between; align-items: center;">

        <div>
            <h1>Reservations</h1>
            <p>Manage hotel reservations.</p>
        </div>

        <a
            href="{{ route('reservations.create') }}"
            style="background: #2563eb; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none;"
        >
            + New Reservation
        </a>

    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        {{-- Reservation Filters --}}
        <form
            action="{{ route('reservations.index') }}"
            method="GET"
            style="margin-bottom: 25px;"
        >

            <div
                style="
                    display: grid;
                    grid-template-columns: 2fr 1fr 1fr 1fr auto auto;
                    gap: 12px;
                    align-items: end;
                "
            >

                {{-- Search --}}
                <div>

                    <label
                        for="search"
                        style="display: block; margin-bottom: 6px; font-weight: bold;"
                    >
                        Search
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Guest name or room number"
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                    >

                </div>

                {{-- Check In --}}
                <div>

                    <label
                        for="filter_check_in"
                        style="display: block; margin-bottom: 6px; font-weight: bold;"
                    >
                        Check In
                    </label>

                    <input
                        type="date"
                        id="filter_check_in"
                        name="check_in"
                        value="{{ request('check_in') }}"
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                    >

                </div>

                {{-- Check Out --}}
                <div>

                    <label
                        for="filter_check_out"
                        style="display: block; margin-bottom: 6px; font-weight: bold;"
                    >
                        Check Out
                    </label>

                    <input
                        type="date"
                        id="filter_check_out"
                        name="check_out"
                        value="{{ request('check_out') }}"
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                    >

                </div>

                {{-- Status --}}
                <div>

                    <label
                        for="filter_status"
                        style="display: block; margin-bottom: 6px; font-weight: bold;"
                    >
                        Status
                    </label>

                    <select
                        id="filter_status"
                        name="status"
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                    >

                        <option value="">
                            All Statuses
                        </option>

                        <option
                            value="reserved"
                            {{ request('status') === 'reserved' ? 'selected' : '' }}
                        >
                            Reserved
                        </option>

                        <option
                            value="checked_in"
                            {{ request('status') === 'checked_in' ? 'selected' : '' }}
                        >
                            Checked In
                        </option>

                        <option
                            value="checked_out"
                            {{ request('status') === 'checked_out' ? 'selected' : '' }}
                        >
                            Checked Out
                        </option>

                        <option
                            value="cancelled"
                            {{ request('status') === 'cancelled' ? 'selected' : '' }}
                        >
                            Cancelled
                        </option>

                    </select>

                </div>

                {{-- Filter Button --}}
                <button
                    type="submit"
                    style="
                        background: #2563eb;
                        color: white;
                        border: none;
                        padding: 10px 16px;
                        border-radius: 6px;
                        cursor: pointer;
                        height: 40px;
                    "
                >
                    Filter
                </button>

                {{-- Clear Button --}}
                <a
                    href="{{ route('reservations.index') }}"
                    style="
                        background: #e5e7eb;
                        color: #374151;
                        padding: 10px 16px;
                        border-radius: 6px;
                        text-decoration: none;
                        height: 40px;
                        box-sizing: border-box;
                    "
                >
                    Clear
                </a>

            </div>

        </form>

        {{-- Result Count --}}
        <div style="margin-bottom: 15px; color: #6b7280; font-size: 14px;">

            Showing
            <strong>{{ $reservations->count() }}</strong>
            reservation{{ $reservations->count() === 1 ? '' : 's' }}

            @if(request()->hasAny(['search', 'check_in', 'check_out', 'status']))
                matching your filters.
            @endif

        </div>

        @if($reservations->count())

            <div style="overflow-x: auto;">

                <table style="width: 100%; border-collapse: collapse;">

                    <thead>

                        <tr style="border-bottom: 2px solid #e5e7eb; text-align: left;">

                            <th style="padding: 12px;">
                                Booking Code
                            </th>

                            <th style="padding: 12px;">
                                Guest
                            </th>

                            <th style="padding: 12px;">
                                Room
                            </th>

                            <th style="padding: 12px;">
                                Room Type
                            </th>

                            <th style="padding: 12px;">
                                Check In
                            </th>

                            <th style="padding: 12px;">
                                Check Out
                            </th>

                            <th style="padding: 12px;">
                                Price
                            </th>

                            <th style="padding: 12px;">
                                Channel
                            </th>

                             <th style="padding: 12px;">
                                OTA Booking ID
                            </th>

                            <th style="padding: 12px;">
                                Created By
                            </th>

                            <th style="padding: 12px;">
                                Status
                            </th>

                            <th style="padding: 12px;">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($reservations as $reservation)

                            <tr style="border-bottom: 1px solid #e5e7eb;">

                                <td style="padding: 12px; font-weight: bold;">
                                    {{ $reservation->booking_code }}
                                </td>

                                <td style="padding: 12px;">
                                    {{ $reservation->guest->name }}
                                </td>

                                <td style="padding: 12px;">
                                    {{ $reservation->room->room_number }}
                                </td>

                                <td style="padding: 12px;">
                                    {{ $reservation->room->roomType->name }}
                                </td>

                                <td style="padding: 12px;">
                                    {{ $reservation->check_in->format('d M Y H:i') }}
                                </td>

                                <td style="padding: 12px;">
                                    {{ $reservation->check_out->format('d M Y H:i') }}
                                </td>

                                <td style="padding: 12px;">
                                    ฿{{ number_format($reservation->price, 2) }}
                                </td>

                                <td style="padding: 12px;">
                                    @if($reservation->source === 'direct')
                                        Direct
                                    @else
                                        {{ ucfirst($reservation->channel) }}
                                    @endif
                                </td>

                                <td style="padding: 12px;">
                                    {{ $reservation->ota_booking_id ?? '—' }}
                                </td>

                                <td style="padding: 12px;">
                                    {{ $reservation->createdBy?->name ?? '—' }}
                                </td>
                                
                                <td style="padding: 12px;">

                                    @if($reservation->status === 'reserved')

                                        <span style="background: #dbeafe; color: #1d4ed8; padding: 5px 9px; border-radius: 5px;">
                                            Reserved
                                        </span>

                                    @elseif($reservation->status === 'checked_in')

                                        <span style="background: #dcfce7; color: #166534; padding: 5px 9px; border-radius: 5px;">
                                            Checked In
                                        </span>

                                    @elseif($reservation->status === 'checked_out')

                                        <span style="background: #e5e7eb; color: #374151; padding: 5px 9px; border-radius: 5px;">
                                            Checked Out
                                        </span>

                                    @else

                                        <span style="background: #fee2e2; color: #991b1b; padding: 5px 9px; border-radius: 5px;">
                                            Cancelled
                                        </span>

                                    @endif

                                </td>

                                <td style="padding: 12px; white-space: nowrap;">
                                    <div class="flex items-center gap-2">
                                        <a   
                                            href="{{ route('reservations.edit', $reservation) }}"
                                            style="background: #f59e0b; color: white; padding: 4px 13px; border-radius: 5px; text-decoration: none;"
                                        >
                                            Edit
                                        </a>

                                        @if($reservation->status !== 'cancelled')
                                            <form
                                                method="POST"
                                                action="{{ route('reservations.destroy', $reservation) }}"
                                                onsubmit="return confirm('Are you sure you want to cancel this reservation?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="px-3 py-1.5 rounded-md bg-red-600 text-white text-sm font-medium
                                                        hover:bg-red-700 transition-colors"
                                                >
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>
            @if($reservations->hasPages())

    <div
        style="
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        "
    >

        {{-- Previous --}}
        @if($reservations->onFirstPage())

            <span
                style="
                    padding: 8px 14px;
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    color: #9ca3af;
                    background: #f9fafb;
                "
            >
                ← Previous
            </span>

        @else

            <a
                href="{{ $reservations->previousPageUrl() }}"
                style="
                    padding: 8px 14px;
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    color: #374151;
                    background: white;
                    text-decoration: none;
                "
            >
                ← Previous
            </a>

        @endif

        {{-- Page information --}}
        <span style="color: #6b7280; font-size: 14px;">
            Page {{ $reservations->currentPage() }}
            of {{ $reservations->lastPage() }}
        </span>

        {{-- Next --}}
        @if($reservations->hasMorePages())

            <a
                href="{{ $reservations->nextPageUrl() }}"
                style="
                    padding: 8px 14px;
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    color: #374151;
                    background: white;
                    text-decoration: none;
                "
            >
                Next →
            </a>

        @else

            <span
                style="
                    padding: 8px 14px;
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    color: #9ca3af;
                    background: #f9fafb;
                "
            >
                Next →
            </span>

        @endif

    </div>

@endif
            @else

            <p style="color: #666;">
                No reservations have been created yet.
            </p>

        @endif

    </div>

@endsection