<?php


namespace App\Data;


class ExamSystem
{
    // exam statuses
    const DISABLED_STATUS = -1;
    const PREPARED_STATUS = 0;
    const IN_PROGRESS_STATUS = 1;
    const FINISHED_STATUS = 2;
    const STARTED = 'started';
    const READY_TO_START = 'readyToStart';

    // coefficient to correct timestamp value for javascript Date class
    const JAVASCRIPT_TIMESTAMP_COEFFICIENT = 1000;

    // number of words for random text
    const WORDS_COUNT = 50;

    // exam names
    const PROGRAMMING_EXAM_NAME = 'programming';
    const ENGLISH_EXAM_NAME = 'english';
    const TYPE_SPEED_EXAM_NAME = 'typeSpeed';

    // error messages
    const ENGLISH_QUESTIONS_STORAGE_ERROR = 'English questions storage error';
    const CONCURRENT_EXAM_ERROR = 'Another exam is already running';
    const EXAM_WAS_FINISHED = 'Exam was finished';
    const NOT_ACTIVE_EXAM_ERROR = 'Exam is not active';
    const NOT_ACTIVE_SESSION_ERROR = 'Session is not active';
    const STATUS_NOT_FOUND = 'Status not found';
    const SESSION_STARTED = 'Session has already started';

    // file paths
    const ENGLISH_QUESTIONS_PATH = 'resources' . DIRECTORY_SEPARATOR . 'exam' . DIRECTORY_SEPARATOR . 'englishQuestions.json';
    const ENGLISH_WORDS_PATH = 'resources' . DIRECTORY_SEPARATOR . 'exam' . DIRECTORY_SEPARATOR . 'englishWords.json';
}
