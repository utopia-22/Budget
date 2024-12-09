@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- End of Sidebar -->
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Welcome ') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ Auth::user()->name }} is logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
