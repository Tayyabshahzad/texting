@extends('layouts.app')

@section('content')
<purchase-plan :plans="{{ $plans }}"></purchase-plan>
@endsection