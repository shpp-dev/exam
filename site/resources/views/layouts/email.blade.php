@switch(config('app.domain'))
    @case('programming.kr.ua')
    @case('2.shpp.me')
        @include('layouts.emails.kr-email')
        @break
    @default
        @include('layouts.emails.default')
@endswitch
