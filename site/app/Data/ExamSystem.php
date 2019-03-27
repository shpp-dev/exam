<?php


namespace App\Data;


class ExamSystem
{
    // session statuses
    const DISABLED_STATUS = -1;
    const IN_PROGRESS_STATUS = 0;
    const FINISHED_STATUS = 1;

    // exam names
    const PROGRAMMING_EXAM_NAME = 'programming';
    const ENGLISH_EXAM_NAME = 'english';
    const TYPE_SPEED_EXAM_NAME = 'typeSpeed';

    // error messages
    const ENGLISH_QUESTIONS_STORAGE_ERROR = 'english questions storage error';

    // file paths
    const ENGLISH_QUESTIONS_PATH = 'site' . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'exam' . DIRECTORY_SEPARATOR . 'englishQuestions.json';
}