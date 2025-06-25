@extends('user.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">{{ $form->title }}</h2>
    <p class="mb-6 text-gray-700">{{ $form->description }}</p>

    <form id="userForm" method="POST" action="{{ route('public.form.submit', $form->id) }}">
        @csrf

        @foreach($form->fields as $field)
            <div class="mb-4">
                <label class="block font-medium mb-1">{{ $field->label }}
                    @if($field->required) <span class="text-red-500">*</span> @endif
                </label>

                @php
                    $name = $field->name_attribute;
                    $required = $field->required ? 'required' : '';
                    $value = old($name);
                @endphp

                @if($field->element_type === 'text' || $field->element_type === 'email' || $field->element_type === 'number')
                    <input type="{{ $field->element_type }}" name="{{ $name }}" class="w-full border rounded px-3 py-2"
                        value="{{ $value }}" {{ $required }}>
                @elseif($field->element_type === 'textarea')
                    <textarea name="{{ $name }}" class="w-full border rounded px-3 py-2" {{ $required }}>{{ $value }}</textarea>
                @elseif($field->element_type === 'select')
                    @php $options = json_decode($field->options, true); @endphp
                    <select name="{{ $name }}" class="w-full border rounded px-3 py-2" {{ $required }}>
                        <option value="">Select</option>
                        @foreach($options as $option)
                            <option value="{{ $option['value'] }}">{{ $option['description'] }}</option>
                        @endforeach
                    </select>
                @elseif($field->element_type === 'radio')
                    @php $options = json_decode($field->options, true); @endphp
                    @foreach($options as $option)
                        <label class="mr-4">
                            <input type="radio" name="{{ $name }}" value="{{ $option['value'] }}" {{ $required }}>
                            {{ $option['description'] }}
                        </label>
                    @endforeach
                @elseif($field->element_type === 'checkbox')
                    @php $options = json_decode($field->options, true); @endphp
                    @foreach($options as $option)
                        <label class="mr-4">
                            <input type="checkbox" name="{{ $name }}[]" value="{{ $option['value'] }}">
                            {{ $option['description'] }}
                        </label>
                    @endforeach
                @endif

                @error($name)
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit</button>
    </form>
</div>
@endsection
@section('scripts')
<script src="{{ asset('page-js/user/form.js') }}"></script>
@endsection
