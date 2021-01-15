@extends('layouts.email')
@section('title')
    @lang('email_subjects.examChecked')
@endsection
@section('subtitle')
    @lang('email_messages.hello')!
@endsection
@section('content')
    <p>@lang('email_messages.examFailed.p1')</p>
    <p>@lang('email_messages.examFailed.p2', ['p2pZeroUrl' => config('ptp.p2pZeroUrl')])</p>
@endsection
