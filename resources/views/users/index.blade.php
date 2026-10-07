@extends('layouts.app')

@section('title', 'User Management - BestBKK Reservation')

@section('content')

<div class="max-w-[1400px] mx-auto">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                User Management
            </h1>

            <p class="mt-1 text-gray-500">
                Manage system users and their roles.
            </p>
        </div>

        <a
            href="{{ route('users.create') }}"
            class="px-4 py-2.5 bg-blue-600 text-white rounded-lg
                   font-medium hover:bg-blue-700 transition"
        >
            + New User
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="mb-6 px-4 py-3 rounded-lg bg-green-50
                    border border-green-200 text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- Error Message --}}
    @if($errors->has('user'))

        <div class="mb-6 px-4 py-3 rounded-lg bg-red-50
                    border border-red-200 text-red-700">
            {{ $errors->first('user') }}
        </div>

    @endif


    {{-- User Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hiddenx">

        <div class="w-full overflow-x-auto">

            <table class="w-full table-fixed">
                <colgroup>
                    <col class="w-[28%]">
                    <col class="w-[28%]">
                    <col class="w-[15%]">
                    <col class="w-[15%]">
                    <col class="w-[14%]">
                </colgroup>

                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wide text-gray-500">
                            Name
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wide text-gray-500">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wide text-gray-500">
                            Role
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wide text-gray-500">
                            Created
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold
                                   uppercase tracking-wide text-gray-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($users as $user)

                        <tr class="hover:bg-gray-50 transition">

                            {{-- Name --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-full
                                                bg-blue-50 text-blue-600
                                                flex items-center justify-center
                                                font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>

                                    <div>

                                        <p class="font-semibold text-gray-900">
                                            {{ $user->name }}
                                        </p>

                                        @if($user->id === auth()->id())
                                            <p class="text-xs text-blue-600 mt-0.5">
                                                You
                                            </p>
                                        @endif

                                    </div>

                                </div>

                            </td>


                            {{-- Email --}}
                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->email }}
                            </td>


                            {{-- Role --}}
                            <td class="px-6 py-4">

                                @if($user->role === 'admin')

                                    <span class="inline-flex px-2.5 py-1 rounded-full
                                                 text-xs font-semibold
                                                 bg-purple-100 text-purple-700">
                                        Admin
                                    </span>

                                @elseif($user->role === 'manager')

                                    <span class="inline-flex px-2.5 py-1 rounded-full
                                                 text-xs font-semibold
                                                 bg-blue-100 text-blue-700">
                                        Manager
                                    </span>

                                @else

                                    <span class="inline-flex px-2.5 py-1 rounded-full
                                                 text-xs font-semibold
                                                 bg-gray-100 text-gray-700">
                                        Staff
                                    </span>

                                @endif

                            </td>


                            {{-- Created --}}
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->created_at->format('d M Y') }}
                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">

                                <a
                                    href="{{ route('users.edit', $user) }}"
                                    class="inline-flex px-3 py-1.5 rounded-md
                                           bg-orange-500 text-black text-sm
                                           font-medium hover:bg-orange-600 transition"
                                >
                                    Edit
                                </a>


                                @if($user->id !== auth()->id())

                                    <form
                                        action="{{ route('users.destroy', $user) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="ml-2 inline-flex px-3 py-1.5
                                                   rounded-md bg-red-600 text-black
                                                   text-sm font-medium
                                                   hover:bg-red-700 transition"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No users found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($users->hasPages())

            <div class="px-6 py-4 border-t border-gray-200">

                <div class="flex items-center justify-between">

                    <span class="text-sm text-gray-500">
                        Page {{ $users->currentPage() }}
                        of {{ $users->lastPage() }}
                    </span>

                    <div class="flex gap-2">

                        @if($users->onFirstPage())

                            <span class="px-3 py-2 rounded-lg border
                                         border-gray-200 text-gray-400
                                         text-sm">
                                ← Previous
                            </span>

                        @else

                            <a
                                href="{{ $users->previousPageUrl() }}"
                                class="px-3 py-2 rounded-lg border
                                       border-gray-300 text-gray-700
                                       text-sm hover:bg-gray-50"
                            >
                                ← Previous
                            </a>

                        @endif


                        @if($users->hasMorePages())

                            <a
                                href="{{ $users->nextPageUrl() }}"
                                class="px-3 py-2 rounded-lg border
                                       border-gray-300 text-gray-700
                                       text-sm hover:bg-gray-50"
                            >
                                Next →
                            </a>

                        @else

                            <span class="px-3 py-2 rounded-lg border
                                         border-gray-200 text-gray-400
                                         text-sm">
                                Next →
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection