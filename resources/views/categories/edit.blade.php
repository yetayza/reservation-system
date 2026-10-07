@extends('layouts.app')

@section('title', 'Edit Category - BestBKK Reservation')

@section('content')

    <div class="page-title">
        <h1>Edit Category</h1>
        <p>Update the room category.</p>
    </div>

    <div class="card">

        <form method="POST" action="{{ route('categories.update', $category) }}">

            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">

                <label for="name" style="display: block; margin-bottom: 8px; font-weight: bold;">
                    Category Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $category->name) }}"
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
                Update Category
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