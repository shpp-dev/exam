<?php


namespace App\Data;


class ExamSystem
{
    // exam statuses
    const DISABLED_STATUS = -1;
    const PREPARED_STATUS = 0;
    const IN_PROGRESS_STATUS = 1;
    const FINISHED_STATUS = 2;

    // exam names
    const PROGRAMMING_EXAM_NAME = 'programming';
    const ENGLISH_EXAM_NAME = 'english';
    const TYPE_SPEED_EXAM_NAME = 'typeSpeed';

    // error messages
    const ENGLISH_QUESTIONS_STORAGE_ERROR = 'english questions storage error';
    const CONCURRENT_EXAM_ERROR = 'another exam is already running';
    const EXAM_WAS_FINISHED = 'exam was finished';

    // file paths
    const ENGLISH_QUESTIONS_PATH = 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'exam' . DIRECTORY_SEPARATOR . 'englishQuestions.json';
}