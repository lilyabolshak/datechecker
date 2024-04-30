@if (session('message'))
    <div class="alert-content ml-4 mb-4">
        <div class="alert-title font-semibold text-lg text-green-700">
            {{ __('Success') }}
        </div>
        <div class="alert-description text-sm text-green-600">
            {{ session('message' )}}
        </div>
    </div>
@endif
