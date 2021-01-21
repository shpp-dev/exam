<?php

return [
    'enabled' => env('SUPERSENDER_ENABLED'),

    'urls' => [
        'mails' => [
            'exam-completed' => env('SUPERSENDER_BASE_URL') . '/email-exam-completed',
            'exam-completed-forced' => env('SUPERSENDER_BASE_URL') . '/email-exam-completed-forced',
            'exam-failed' => env('SUPERSENDER_BASE_URL') . '/email-exam-failed',
            'exam-passed' => env('SUPERSENDER_BASE_URL') . '/email-exam-passed',
            'retry-exam-available' => env('SUPERSENDER_BASE_URL') . '/email-exam-retry'
        ]
    ]
];
