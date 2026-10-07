@extends('layouts.app')

@section('title', 'Add Category - BestBKK Reservation')

@section('content')

    <div class="page-title">
        <h1>Add Category</h1>
        <p>Create a new room category.</p>
    </div>

    <div class="card">

        <form method="POST" action="{{ route('categories.store') }}">

            @csrf

            <div style="margin-bottom: 20px;">

                <label for="name" style="display: block; margin-bottom: 8px; font-weight: bold;">
                    Category Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;"
                >

                @error('name')
                    <div style="color: #dc2626; margin-top: 6px;">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <button
                type="submit"
                style="background: #1f2937; color: white; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer;"
            >
                Create Category
            </button>

            <a
                href="{{ route('categories.index') }}"
                style="margin-left: 10px;"
            >
                Cancel
            </a>

        </form>

    </div>

@endsection