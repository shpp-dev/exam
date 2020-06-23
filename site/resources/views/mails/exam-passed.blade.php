@extends('layouts.email')
@section('title')
    @lang('email_subjects.examChecked')
@endsection
@section('subtitle')
    @lang('email_messages.congratulation')!
@endsection
@section('content')
    <p>@lang('email_messages.examPassed.p1')</p>
    <p>@lang('email_messages.examPassed.p2')</p>
    <p>@lang('email_messages.examPassed.p3')</p>
    <p>@lang('email_messages.examPassed.p4')</p>
    <p>@lang('email_messages.examPassed.p5', ['accountUrl' => config('ptp.accountFrontUrl')])</p>
    <p>@lang('email_messages.examPassed.p6')</p>
@endsection
