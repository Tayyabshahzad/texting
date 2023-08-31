@extends('layouts.app')

@section('content')
<div style="padding-top: 50px; background-image: url('https://static.wixstatic.com/media/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg/v1/fill/w_2024,h_1660,al_c,q_90,usm_0.66_1.00_0.01,enc_auto/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg'); background-size: cover; width: 100%; height: 190vh;">
    <signup-survey :details="{{ $details }}" :survey="{{ $survey }}" :q1="{{ $q1 }}" :q2="{{ $q2 }}" :q3="{{ $q3 }}" :opts1="{{ $opts1 }}" :opts2="{{ $opts2 }}" :opts3="{{ $opts3 }}"></signup-survey>
</div>
@endsection
