@extends('layouts.app')

@section('title', 'Edit Reservation - BestBKK Reservation')

@section('content')

    <div class="page-title">
        <h1>Edit Reservation #{{ $reservation->id }}</h1>
        <p>Update reservation information.</p>
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

        <form action="{{ route('reservations.update', $reservation) }}" method="POST">

            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">

                <label
                    for="guest_name"
                    style="display: block; margin-bottom: 8px; font-weight: bold;"
                >
                    Guest Name
                </label>

                <input
                    type="text"
                    id="guest_name"
                    name="guest_name"
                    value="{{ old('guest_name', $reservation->guest->name) }}"
                    list="guest_list"
                    autocomplete="off"
                    required
                    placeholder="Type guest name..."
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                >

                <datalist id="guest_list">

                    @foreach($guests as $guest)

                        <option value="{{ $guest->name }}"></option>

                    @endforeach

                </datalist>

                <p style="margin-top: 8px; color: #6b7280; font-size: 13px;">
                    Select an existing guest or enter a new guest name.
                </p>

            </div>

            <div style="margin-bottom: 20px;">

                <label
                    for="room_id"
                    style="display: block; margin-bottom: 8px; font-weight: bold;"
                >
                    Room
                    <span
                        id="room_availability"
                        style="margin-left: 8px; color: #6b7280; font-size: 13px; font-weight: normal;"
                    ></span>
                </label>

                <select
                    id="room_id"
                    name="room_id"
                    required
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                >

                    @foreach($rooms as $room)

                        <option
                            value="{{ $room->id }}"
                            {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' : '' }}
                        >
                            Room {{ $room->room_number }}
                            - {{ $room->roomType->name }}
                            ({{ $room->roomType->category->name }})
                        </option>

                    @endforeach

                </select>

            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">

                <div>

                    <label
                        for="check_in"
                        style="display: block; margin-bottom: 8px; font-weight: bold;"
                    >
                        Check In
                    </label>

                    <input
                        type="datetime-local"
                        id="check_in"
                        name="check_in"
                        value="{{ old('check_in', $reservation->check_in->format('Y-m-d\TH:i')) }}"
                        required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                    >

                </div>

                <div>

                    <label
                        for="check_out"
                        style="display: block; margin-bottom: 8px; font-weight: bold;"
                    >
                        Check Out
                    </label>

                    <input
                        type="datetime-local"
                        id="check_out"
                        name="check_out"
                        value="{{ old('check_out', $reservation->check_out->format('Y-m-d\TH:i')) }}"
                        required
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                    >

                </div>

            </div>

            <div style="margin-bottom: 20px;">

                <label
                    for="price"
                    style="display: block; margin-bottom: 8px; font-weight: bold;"
                >
                    Total Price (THB)
                </label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    value="{{ old('price', $reservation->price) }}"
                    min="0"
                    step="0.01"
                    required
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                >

            </div>

            <div style="margin-bottom: 20px;">

                <label
                    for="source"
                    style="display: block; margin-bottom: 8px; font-weight: bold;"
                >
                    Channel
                </label>

                <select
                    id="source"
                    name="source"
                    required
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                >
                    <option
                        value="direct"
                        {{ old('source', $reservation->source) === 'direct' ? 'selected' : '' }}
                    >
                        Direct
                    </option>

                    <option
                        value="ota"
                        {{ old('source', $reservation->source) === 'ota' ? 'selected' : '' }}
                    >
                        OTA
                    </option>
                </select>

            </div>

            <div
                id="ota_fields"
                style="
                    display: none;
                    margin-bottom: 20px;
                    padding: 15px;
                    background: #f9fafb;
                    border: 1px solid #e5e7eb;
                    border-radius: 6px;
                "
            >

                <div style="margin-bottom: 20px;">

                    <label
                        for="channel"
                        style="display: block; margin-bottom: 8px; font-weight: bold;"
                    >
                        OTA Channel
                    </label>

                    <select
                        id="channel"
                        name="channel"
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                    >
                        <option value="">-- Select Channel --</option>

                        <option
                            value="agoda"
                            {{ old('channel', $reservation->channel) === 'agoda' ? 'selected' : '' }}
                        >
                            Agoda
                        </option>

                        <option
                            value="booking.com"
                            {{ old('channel', $reservation->channel) === 'booking.com' ? 'selected' : '' }}
                        >
                            Booking.com
                        </option>

                        <option
                            value="expedia"
                            {{ old('channel', $reservation->channel) === 'expedia' ? 'selected' : '' }}
                        >
                            Expedia
                        </option>

                        <option
                            value="other"
                            {{ old('channel', $reservation->channel) === 'other' ? 'selected' : '' }}
                        >
                            Other
                        </option>
                    </select>

                </div>

                <div>

                    <label
                        for="ota_booking_id"
                        style="display: block; margin-bottom: 8px; font-weight: bold;"
                    >
                        OTA Booking ID
                    </label>

                    <input
                        type="text"
                        id="ota_booking_id"
                        name="ota_booking_id"
                        value="{{ old('ota_booking_id', $reservation->ota_booking_id) }}"
                        placeholder="Example: 123456789"
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                    >

                </div>

            </div>

            <div style="margin-bottom: 20px;">

                <label
                    for="status"
                    style="display: block; margin-bottom: 8px; font-weight: bold;"
                >
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    required
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                >

                    <option
                        value="reserved"
                        {{ old('status', $reservation->status) === 'reserved' ? 'selected' : '' }}
                    >
                        Reserved
                    </option>

                    <option
                        value="checked_in"
                        {{ old('status', $reservation->status) === 'checked_in' ? 'selected' : '' }}
                    >
                        Checked In
                    </option>

                    <option
                        value="checked_out"
                        {{ old('status', $reservation->status) === 'checked_out' ? 'selected' : '' }}
                    >
                        Checked Out
                    </option>

                    <option
                        value="cancelled"
                        {{ old('status', $reservation->status) === 'cancelled' ? 'selected' : '' }}
                    >
                        Cancelled
                    </option>

                </select>

            </div>

            <div>

                <button
                    type="submit"
                    style="background: #2563eb; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer;"
                >
                    Update Reservation
                </button>

                <a
                    href="{{ route('reservations.index') }}"
                    style="margin-left: 10px; color: #555; text-decoration: none;"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>
    <script>
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const roomSelect = document.getElementById('room_id');
        const roomAvailability = document.getElementById('room_availability');
        const sourceSelect = document.getElementById('source');
        const otaFields = document.getElementById('ota_fields');
        const channelSelect = document.getElementById('channel');
        const otaBookingIdInput = document.getElementById('ota_booking_id');

        function toggleOtaFields() {
            if (sourceSelect.value === 'ota') {
                otaFields.style.display = 'block';

                channelSelect.required = true;
                otaBookingIdInput.required = true;
            } else {
                otaFields.style.display = 'none';

                channelSelect.required = false;
                otaBookingIdInput.required = false;
            }
        }

        sourceSelect.addEventListener('change', toggleOtaFields);

        toggleOtaFields();

        async function loadAvailableRooms() {

            const checkIn = checkInInput.value;
            const checkOut = checkOutInput.value;

            // Don't check until both dates are selected.
            if (!checkIn || !checkOut) {
                roomAvailability.textContent = '';
                return;
            }

            // Check-out must be after check-in.
            if (checkOut <= checkIn) {
                roomAvailability.textContent = '';
                return;
            }

            try {

                roomAvailability.textContent = 'Checking...';

                const url = new URL(
                    '{{ route('reservations.available-rooms') }}',
                    window.location.origin
                );

                url.searchParams.set('check_in', checkIn);
                url.searchParams.set('check_out', checkOut);

                // Important: exclude the reservation currently being edited.
                url.searchParams.set(
                    'reservation_id',
                    '{{ $reservation->id }}'
                );

                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error('Failed to load available rooms.');
                }

                const data = await response.json();
                const rooms = data.rooms;

                const currentRoom = roomSelect.value;

                // Clear the current room options.
                roomSelect.innerHTML = '';

                // Add default option.
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = '-- Select Room --';
                roomSelect.appendChild(defaultOption);

                // Add available rooms.
                rooms.forEach(room => {

                    const option = document.createElement('option');

                    option.value = room.id;

                    option.textContent =
                        `Room ${room.room_number} - ${room.room_type.name} (${room.room_type.category.name})`;

                    roomSelect.appendChild(option);

                });

                // Keep the current room selected if it is still available.
                if (
                    currentRoom &&
                    rooms.some(room => String(room.id) === String(currentRoom))
                ) {
                    roomSelect.value = currentRoom;
                }

                // Show availability count.
                if (rooms.length === 0) {

                    roomAvailability.textContent =
                        'No rooms available for these dates.';

                    roomAvailability.style.color = '#dc2626';

                } else {

                    roomAvailability.textContent =
                        `${rooms.length} room${rooms.length === 1 ? '' : 's'} available`;

                    roomAvailability.style.color = '#16a34a';
                }

            } catch (error) {

                console.error(error);

                roomAvailability.textContent =
                    'Unable to check room availability.';

                roomAvailability.style.color = '#dc2626';
            }
        }

        checkInInput.addEventListener('change', loadAvailableRooms);
        checkOutInput.addEventListener('change', loadAvailableRooms);

        // Check availability immediately when the Edit page opens.
        loadAvailableRooms();
    </script>
@endsection