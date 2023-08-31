@extends('layouts.master')
@section('content')

<div class="row td-subscriptions">
    <div class="col-md-12 px-5 py-3">
        <h2 class="td-dashboard-title">Signup Survey</h2>
    </div>

    <div class="col-md-12 px-5 py-3 td-subscribers-table">
        <div class="mb-10" style="margin-bottom: 25px">
            <h4>  {{ $q1->question }} </h4>
            <ul>
                @foreach ($opts1 as  $options_1)
                    <li> {{ $options_1->survey_question_option }} </li>
                 @endforeach
            </ul>
        </div>

        <div style="margin-bottom: 25px">
            <h4>   {{ $q2->question }} </h4>
            <ul>
                @foreach ($opts2 as  $options_1)
                    <li> {{ $options_1->survey_question_option }} </li>
                 @endforeach
            </ul>
        </div>

        <div style="margin-bottom: 25px">
            <h4>   {{ $q3->question }} </h4>
            <ul>
                @foreach ($opts3 as  $options_1)
                    <li> {{ $options_1->survey_question_option }} </li>
                 @endforeach
            </ul>
        </div>

    </div>
</div>


@endsection

@section('page_js')
@endsection
