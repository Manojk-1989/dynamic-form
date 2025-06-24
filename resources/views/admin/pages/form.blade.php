@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Create New Dynamic Form</h2>

    {{-- Create Form --}}
    <form id="createForm" method="POST" action="{{ route('admin.forms.create') }}">
        @csrf

        {{-- Form Title --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Form Title</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
        </div>

        {{-- Form Description --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Form Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="2"></textarea>
        </div>

        {{-- Dynamic Fields Section --}}
        <h3 class="text-lg font-semibold mb-2">Form Fields</h3>

        <table class="w-full table-auto border mb-4" id="fieldsTable">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2 border">Label</th>
                    <th class="p-2 border">Field Name</th>
                    <th class="p-2 border">HTML Type</th>
                    <th class="p-2 border">Placeholder / Options</th>
                    <th class="p-2 border">Required</th>
                    <th class="p-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- Rows will be appended here dynamically --}}
            </tbody>
        </table>

        <button type="button" id="addFieldBtn" class="bg-green-500 text-white px-3 py-1 rounded mb-4">+ Add Field</button>

        <div class="mb-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Form</button>
        </div>
    </form>
</div>

{{-- Template Row (Hidden) --}}
<table class="hidden">
    <tbody id="templateRow">
        <tr>
            <td class="border p-2">
                <input type="text" name="fields[][label]" class="w-full border rounded px-2 py-1" required>
            </td>
            <td class="border p-2">
                <input type="text" name="fields[][name]" class="w-full border rounded px-2 py-1" required>
            </td>
            <td class="border p-2">
                <select name="fields[][type]" class="w-full border rounded px-2 py-1 field-type">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select (Dropdown)</option>
                    <option value="radio">Radio</option>
                    <option value="checkbox">Checkbox</option>
                </select>
            </td>
            <td class="border p-2">
                <input type="text" name="fields[][options]" class="w-full border rounded px-2 py-1 options-field" placeholder="Comma separated for Select/Radio/Checkbox">
            </td>
            <td class="border p-2 text-center">
                <input type="checkbox" name="fields[][required]" value="1">
            </td>
            <td class="border p-2 text-center">
                <button type="button" class="text-red-600 removeRowBtn">Delete</button>
            </td>
        </tr>
    </tbody>
</table>

@endsection

@section('scripts')
<script src="{{ asset('page-js/admin/form.js') }}"></script>
@endsection
