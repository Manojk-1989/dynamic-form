@extends('admin.layouts.admin')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold text-lg">Forms</h2>
            <p class="text-gray-600 text-sm">Manage dynamic forms.</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold text-lg">Submissions</h2>
            <p class="text-gray-600 text-sm">View submitted data.</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold text-lg">Users</h2>
            <p class="text-gray-600 text-sm">Manage admin users.</p>
        </div>
    </div>
    
@endsection
@section('scripts')
<script src="{{ asset('page-js/admin/dashboard.js') }}"></script>

@endsection
