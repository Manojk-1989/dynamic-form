@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">
        {{ isset($form) ? 'Edit Form' : 'Create New Dynamic Form' }}
    </h2>

    {{-- Create/Edit Form --}}
    <form id="createForm" method="POST" action="{{ isset($form) ? route('admin.forms.update', $form) : route('admin.forms.create') }}">
        @csrf
        @if(isset($form))
            @method('PUT')
        @endif

        {{-- Hidden input for Form ID (if editing) --}}
        @if(isset($form))
            <input type="hidden" name="form_id" value="{{ $form->id }}">
        @endif

        {{-- Form Title --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Form Title</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2"
                   value="{{ old('title', $form->title ?? '') }}" required>
        </div>

        {{-- Form Description --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Form Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="2">{{ old('description', $form->description ?? '') }}</textarea>
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
                @if(isset($form) && $form->fields->count())
                    @foreach($form->fields as $index => $field)
                        <tr>
                            <td class="border p-2">
                                <input type="text" name="label[]" class="w-full border rounded px-2 py-1"
                                       value="{{ old("label.$index", $field->label) }}" required>
                            </td>
                            <td class="border p-2">
                                <input type="text" name="name[]" class="w-full border rounded px-2 py-1"
                                       value="{{ old("name.$index", $field->name_attribute) }}" required>
                            </td>
                            <td class="border p-2">
                                <select name="field_type[]" class="w-full border rounded px-2 py-1 field-type">
                                    @foreach(['text', 'number', 'textarea', 'select', 'radio', 'checkbox'] as $type)
                                        <option value="{{ $type }}" {{ old("field_type.$index", $field->element_type) == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border p-2">
                                <button type="button" class="btn-options-modal bg-gray-200 border rounded px-2 py-1 w-full text-left">
                                    Set Options
                                </button>
                                <input type="hidden" name="options_or_values[]" class="options-hidden-input"
                                       value="{{ old("options_or_values.$index", json_encode($field->options)) }}">
                                <div class="options-summary text-sm text-gray-600 mt-1">
                                    {{ is_array($field->options) ? collect($field->options)->pluck('description')->join(', ') : '' }}
                                </div>
                            </td>
                            <td class="border p-2 text-center">
                                <input type="checkbox" name="required[]" value="1"
                                       {{ old("required.$index", $field->required) ? 'checked' : '' }}>
                            </td>
                            <td class="border p-2 text-center">
                                <button type="button" class="text-red-600 removeRowBtn">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <button type="button" id="addFieldBtn" class="bg-green-500 text-white px-3 py-1 rounded mb-4">+ Add Field</button>

        <div class="mb-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                {{ isset($form) ? 'Update Form' : 'Save Form' }}
            </button>
        </div>
    </form>
</div>

{{-- Template Row (Hidden) --}}
<table class="hidden">
    <tbody id="templateRow">
        <tr>
            <td class="border p-2">
                <input type="text" name="label[]" class="w-full border rounded px-2 py-1" required>
            </td>
            <td class="border p-2">
                <input type="text" name="name[]" class="w-full border rounded px-2 py-1" required>
            </td>
            <td class="border p-2">
                <select name="field_type[]" class="w-full border rounded px-2 py-1 field-type">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select (Dropdown)</option>
                    <option value="radio">Radio</option>
                    <option value="checkbox">Checkbox</option>
                </select>
            </td>
            <td class="border p-2">
                <button type="button" class="btn-options-modal bg-gray-200 border rounded px-2 py-1 w-full text-left">
                    Set Options
                </button>
                <input type="hidden" name="options_or_values[]" class="options-hidden-input" />
                <div class="options-summary text-sm text-gray-600 mt-1"></div>
            </td>
            <td class="border p-2 text-center">
                <input type="checkbox" name="required[]" value="1">
            </td>
            <td class="border p-2 text-center">
                <button type="button" class="text-red-600 removeRowBtn">Delete</button>
            </td>
        </tr>
    </tbody>
</table>

@include('modals.form-element-value-modal')
@endsection

@section('scripts')
<script src="{{ asset('page-js/admin/form.js') }}"></script>
@endsection
