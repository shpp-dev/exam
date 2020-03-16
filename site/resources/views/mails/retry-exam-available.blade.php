@extends('layouts.email')
@section('title')
    @lang('email_subjects.retryExamAvailable')
@endsection
@section('subtitle')
    @lang('email_messages.hello')!
@endsection
@section('content')
    <p>@lang('email_messages.retryExamAvailable', ['calendlyUrl' => config('ptp.calendlyUrl')])</p>
@endsection





