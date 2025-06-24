@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Forms List</h2>

    <table class="w-full table-auto border-collapse border border-gray-300 mb-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2 text-left">ID</th>
                <th class="border px-3 py-2 text-left">Title</th>
                <th class="border px-3 py-2 text-left">Description</th>
                <th class="border px-3 py-2 text-left">Fields Count</th>
                <th class="border px-3 py-2 text-left">Created At</th>
                <th class="border px-3 py-2 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($forms as $form)
            <tr>
                <td class="border px-3 py-2">{{ $form->id }}</td>
                <td class="border px-3 py-2">{{ $form->title }}</td>
                <td class="border px-3 py-2">{{ $form->description }}</td>
                <td class="border px-3 py-2">{{ $form->fields_count }}</td>
                <td class="border px-3 py-2">{{ $form->created_at->format('Y-m-d') }}</td>
                <td class="border px-3 py-2">
                    <a href="{{ route('admin.forms.edit', $form) }}" class="text-blue-600 hover:underline">Edit</a>
                    <button type="button"
                        class="text-red-600 hover:underline delete-form-btn"
                        data-id="{{ $form->id }}"
                        data-url="{{ route('admin.forms.destroy', $form) }}">
                        Delete
                    </button>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="border px-3 py-2 text-center text-gray-500">No forms available.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination links --}}
    <div class="mt-4">
        {{ $forms->links() }}
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('page-js/admin/dashboard.js') }}"></script>
@endsection