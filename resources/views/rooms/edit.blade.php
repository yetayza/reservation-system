@extends('layouts.app')

@section('title', 'Edit Room - BestBKK Reservation')

@section('content')

    <div class="page-title">
        <h1>Edit Room</h1>
        <p>Update room information.</p>
    </div>

    <div class="card">

        @if($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px;">
                <ul style="margin-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rooms.update', $room) }}" method="POST">

            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">

                <label for="room_number"
                       style="display: block; margin-bottom: 8px; font-weight: bold;">
                    Room Number
                </label>

                <input
                    type="text"
                    id="room_number"
                    name="room_number"
                    value="{{ old('room_number', $room->room_number) }}"
                    required
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                >

            </div>

            <div style="margin-bottom: 20px;">

                <label for="room_type_id"
                       style="display: block; margin-bottom: 8px; font-weight: bold;">
                    Room Type
                </label>

                <select
                    id="room_type_id"
                    name="room_type_id"
                    required
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                >

                    <option value="">-- Select Room Type --</option>

                    @foreach($roomTypes as $roomType)

                        <option
                            value="{{ $roomType->id }}"
                            {{ old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : '' }}
                        >
                            {{ $roomType->name }}
                            - {{ $roomType->category->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div>

                <button
                    type="submit"
                    style="background: #2563eb; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer;"
                >
                    Update Room
                </button>

                <a
                    href="{{ route('rooms.index') }}"
                    style="margin-left: 10px; color: #555; text-decoration: none;"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

@endsection