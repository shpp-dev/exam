@extends('layouts.email')
@section('title')
    @lang('email_subjects.examFinished')
@endsection
@section('subtitle')
    @lang('email_messages.hello')!
@endsection
@section('content')
    <p>@lang('email_messages.examCompleted')</p>
@endsection