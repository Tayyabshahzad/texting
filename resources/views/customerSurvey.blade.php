@extends('layouts.app')

@section('content')
<customer-survey :survey="{{ $survey }}" :q1="{{ $q1 }}" :q2="{{ $q2 }}" :q3="{{ $q3 }}" :opts1="{{ $opts1 }}" :opts2="{{ $opts2 }}" :opts3="{{ $opts3 }}"></customer-survey>
@endsection