@extends('layouts.app')

@section('title', 'Create User - BestBKK Reservation')

@section('content')

<div class="w-full mx-auto">

    {{-- Page Header --}}
    <div class="mb-8">

        <a
            href="{{ route('users.index') }}"
            class="text-sm text-gray-500 hover:text-gray-700"
        >
            ← Back to Users
        </a>

        <h1 class="mt-3 text-3xl font-bold text-gray-900">
            Create User
        </h1>

        <p class="mt-1 text-gray-500">
            Create a new system user and assign their role.
        </p>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="mb-6 px-4 py-3 rounded-lg bg-red-50
                    border border-red-200 text-red-700">

            <p class="font-semibold mb-2">
                Please fix the following:
            </p>

            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- Form --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">

        <form
            action="{{ route('users.store') }}"
            method="POST"
        >

            @csrf


            {{-- Name --}}
            <div class="mb-6">

                <label
                    for="name"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    class="w-full px-4 py-3 rounded-lg border border-gray-300
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500"
                    placeholder="Enter user's name"
                >

            </div>


            {{-- Email --}}
            <div class="mb-6">

                <label
                    for="email"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500"
                    placeholder="Enter email address"
                >

            </div>


            {{-- Role --}}
            <div class="mb-6">

                <label
                    for="role"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Role
                </label>

                <select
                    id="role"
                    name="role"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300
                           bg-white focus:outline-none focus:ring-2
                           focus:ring-blue-500 focus:border-blue-500"
                >

                    <option value="">
                        -- Select Role --
                    </option>

                    @foreach($allowedRoles as $role)

                        <option
                            value="{{ $role }}"
                            {{ old('role') === $role ? 'selected' : '' }}
                        >
                            {{ ucfirst($role) }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Password --}}
            <div class="mb-6">

                <label
                    for="password"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500"
                    placeholder="Minimum 8 characters"
                >

            </div>


            {{-- Confirm Password --}}
            <div class="mb-8">

                <label
                    for="password_confirmation"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Confirm Password
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500"
                    placeholder="Enter the password again"
                >

            </div>


            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3">

                <a
                    href="{{ route('users.index') }}"
                    class="px-5 py-2.5 rounded-lg border border-gray-300
                           text-gray-700 font-medium hover:bg-gray-50 transition"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-lg bg-blue-600 text-white
                           font-medium hover:bg-blue-700 transition"
                >
                    Create User
                </button>

            </div>

        </form>

    </div>

</div>

@endsection