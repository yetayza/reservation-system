@extends('layouts.app')

@section('title', 'Add Room Type - BestBKK Reservation')

@section('content')

    <div class="page-title">
        <h1>Add Room Type</h1>
        <p>Create a new room type.</p>
    </div>

    <div class="card">

        <form method="POST" action="{{ route('room-types.store') }}">

            @csrf

            <div style="margin-bottom: 20px;">

                <label
                    for="category_id"
                    style="display: block; margin-bottom: 8px; font-weight: bold;"
                >
                    Category
                </label>

                <select
                    id="category_id"
                    name="category_id"
                    required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;"
                >

                    <option value="">
                        -- Select Category --
                    </option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

                @error('category_id')

                    <div style="color: #dc2626; margin-top: 6px;">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div style="margin-bottom: 20px;">

                <label
                    for="name"
                    style="display: block; margin-bottom: 8px; font-weight: bold;"
                >
                    Room Type Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Example: Standard Double"
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;"
                >

                @error('name')

                    <div style="color: #dc2626; margin-top: 6px;">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div style="margin-bottom: 20px;">

                <label
                    for="description"
                    style="display: block; margin-bottom: 8px; font-weight: bold;"
                >
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Describe this room type..."
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;"
                >{{ old('description') }}</textarea>

                @error('description')

                    <div style="color: #dc2626; margin-top: 6px;">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <button
                type="submit"
                style="background: #1f2937; color: white; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer;"
            >
                Create Room Type
            </button>

            <a
                href="{{ route('room-types.index') }}"
                style="margin-left: 10px;"
            >
                Cancel
            </a>

        </form>

    </div>

@endsection