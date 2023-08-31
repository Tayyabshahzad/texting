@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @hasrole(['User'])
                    <profile :user="{{ Auth::user() }} "></profile>
                    @endhasrole
                    @hasrole(['Customer'])
                    <profile :user="{{ Auth::user() }} " :customer="{{ Auth::user()->customerDetails }}"></profile>
                    @endhasrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
