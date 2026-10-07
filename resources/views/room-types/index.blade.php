@extends('layouts.app')

@section('title', 'Room Types - BestBKK Reservation')

@section('content')

    <div class="page-title">

        <div style="display: flex; justify-content: space-between; align-items: center;">

            <div>
                <h1>Room Types</h1>
                <p>Manage your hotel room types.</p>
            </div>

            <a
                href="{{ route('room-types.create') }}"
                style="background: #1f2937; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none;"
            >
                + Add Room Type
            </a>

        </div>

    </div>

    @if(session('success'))

        <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>

    @endif

    <div class="card">

        @if($roomTypes->count())

            <table style="width: 100%; border-collapse: collapse;">

                <thead>

                    <tr style="text-align: left; border-bottom: 1px solid #ddd;">

                        <th style="padding: 12px;">
                            ID
                        </th>

                        <th style="padding: 12px;">
                            Category
                        </th>

                        <th style="padding: 12px;">
                            Room Type
                        </th>

                        <th style="padding: 12px;">
                            Description
                        </th>

                        <th style="padding: 12px;">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($roomTypes as $roomType)

                        <tr style="border-bottom: 1px solid #eee;">

                            <td style="padding: 12px;">
                                {{ $roomType->id }}
                            </td>

                            <td style="padding: 12px;">
                                {{ $roomType->category->name }}
                            </td>

                            <td style="padding: 12px;">
                                {{ $roomType->name }}
                            </td>

                            <td style="padding: 12px;">
                                {{ $roomType->description ?? '-' }}
                            </td>

                            <td style="padding: 12px;">

                                <a href="{{ route('room-types.edit', $roomType) }}">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('room-types.destroy', $roomType) }}"
                                    method="POST"
                                    style="display: inline; margin-left: 10px;"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Are you sure you want to delete this room type?')"
                                        style="background: none; border: none; color: #dc2626; cursor: pointer;"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p>No room types have been created yet.</p>

        @endif

    </div>

@endsection