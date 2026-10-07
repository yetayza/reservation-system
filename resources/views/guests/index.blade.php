@extends('layouts.app')

@section('title', 'Guests - BestBKK Reservation')

@section('content')

    <div class="page-title" style="display: flex; justify-content: space-between; align-items: center;">

        <div>
            <h1>Guests</h1>
            <p>Manage hotel guests.</p>
        </div>

        <a href="{{ route('guests.create') }}"
           style="background: #2563eb; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none;">
            + Add Guest
        </a>

    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">

        @if($guests->count())

            <div style="overflow-x: auto;">

                <table style="width: 100%; border-collapse: collapse;">

                    <thead>

                        <tr style="border-bottom: 2px solid #e5e7eb; text-align: left;">

                            <th style="padding: 12px;">
                                ID
                            </th>

                            <th style="padding: 12px;">
                                Guest Name
                            </th>

                            <th style="padding: 12px;">
                                Reservations
                            </th>

                            <th style="padding: 12px;">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($guests as $guest)

                            <tr style="border-bottom: 1px solid #e5e7eb;">

                                <td style="padding: 12px;">
                                    {{ $guest->id }}
                                </td>

                                <td style="padding: 12px; font-weight: bold;">
                                    {{ $guest->name }}
                                </td>

                                <td style="padding: 12px;">
                                    {{ $guest->reservations()->count() }}
                                </td>

                                <td style="padding: 12px;">
                                    <div class="flex items-center gap-2">                                                                                      
                                        <a href="{{ route('guests.edit', $guest) }}"
                                        style="background: #f59e0b; color: white; padding: 7px 12px; border-radius: 5px; text-decoration: none;">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('guests.destroy', $guest) }}"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this guest?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                style="background: #dc2626; color: white; border: none; padding: 7px 12px; border-radius: 5px; cursor: pointer;"
                                            >
                                                Delete
                                            </button>

                                        </form>
                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <p style="color: #666;">
                No guests have been added yet.
            </p>

        @endif

    </div>

@endsection