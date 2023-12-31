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

                    @hasrole('Super-Admin')
                    <div>
                        <admin-tools :user="{{ Auth::user() }}" :sms='@json($sms)' :counts='@json($counts)'></admin-tools>
                    </div>
                    @endhasrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
