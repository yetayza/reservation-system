@extends('layouts.app')

@section('title', 'Categories - BestBKK Reservation')

@section('content')

    <div class="page-title">

        <div style="display: flex; justify-content: space-between; align-items: center;">

            <div>
                <h1>Categories</h1>
                <p>Manage your room categories.</p>
            </div>

            <a href="{{ route('categories.create') }}"
               style="background: #1f2937; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none;">
                + Add Category
            </a>

        </div>

    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        @if($categories->count())

            <table style="width: 100%; border-collapse: collapse;">

                <thead>
                    <tr style="text-align: left; border-bottom: 1px solid #ddd;">
                        <th style="padding: 12px;">ID</th>
                        <th style="padding: 12px;">Name</th>
                        <th style="padding: 12px;">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($categories as $category)

                        <tr style="border-bottom: 1px solid #eee;">

                            <td style="padding: 12px;">
                                {{ $category->id }}
                            </td>

                            <td style="padding: 12px;">
                                {{ $category->name }}
                            </td>

                            <td style="padding: 12px;">

                                <a href="{{ route('categories.edit', $category) }}">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('categories.destroy', $category) }}"
                                    method="POST"
                                    style="display: inline; margin-left: 10px;"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Are you sure you want to delete this category?')"
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

            <p>No categories have been created yet.</p>

        @endif

    </div>

@endsection