@extends('user.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">Available Forms</h2>

    @if($forms->isEmpty())
        <p class="text-gray-600">No forms are available at the moment.</p>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($forms as $form)
                <div class="border rounded shadow p-4 hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold mb-2">{{ $form->title }}</h3>
                    <p class="text-gray-700 mb-4">
                        {{ Str::limit($form->description, 100) }}
                    </p>
                    <a href="{{ route('user.form.show', $form) }}"
                       class="text-blue-600 font-medium hover:underline">
                        Fill Out Form →
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
