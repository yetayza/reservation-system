@extends('layouts.app')

@section('title', 'Edit Guest - BestBKK Reservation')

@section('content')

    <div class="page-title">
        <h1>Edit Guest</h1>
        <p>Update guest information.</p>
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

        <form action="{{ route('guests.update', $guest) }}" method="POST">

            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">

                <label
                    for="name"
                    style="display: block; margin-bottom: 8px; font-weight: bold;"
                >
                    Guest Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $guest->name) }}"
                    required
                    autofocus
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"
                >

            </div>

            <div>

                <button
                    type="submit"
                    style="background: #2563eb; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer;"
                >
                    Update Guest
                </button>

                <a
                    href="{{ route('guests.index') }}"
                    style="margin-left: 10px; color: #555; text-decoration: none;"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

@endsection