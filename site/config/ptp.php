<?php

return [
    'accountFrontUrl' => env('ACCOUNT_FRONT_URL'),
    'accountBackUrl' => env('ACCOUNT_BACK_URL'),
    'examFrontUrl' => env('EXAM_FRONT_URL'),
    'examAdminFrontUrl' => 'https://http://admin.exam.scs.if.shpp.me/', //env('EXAM_ADMIN_FRONT_URL'),
    'programmingExam' => env('PROGRAMMING_EXAM_ON'),
    'englishExam' => env('ENGLISH_EXAM_ON'),
    'typeSpeedExam' => env('TYPE_SPEED_EXAM_ON'),
    'programmingTasksAmount' => env('PROGRAMMING_TASKS_AMOUNT'),
    'englishQuestionsAmount' => env('ENGLISH_QUESTIONS_AMOUNT'),
    'programmingExamDurationMins' => env('PROGRAMMING_EXAM_DURATION_MINS'),
    'englishExamDurationMins' => env('ENGLISH_EXAM_DURATION_MINS'),
    'retryTestingAfterDays' => env('RETRY_TESTING_AFTER_DAYS', 30),
    'coderunnerUrl' => env('CODERUNNER_URL'),
    'coderunnerKey' => env('CODERUNNER_KEY'),
    'calendlyUrl' => env('CALENDLY_URL'),
    'p2pZeroUrl' => env('P2P_ZERO_URL')
];
