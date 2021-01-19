<?php

namespace App\Domains\Exam\TypeSpeed\Jobs;

use App\Data\ExamSystem;
use Lucid\Foundation\Job;

class GetRandomTextJob extends Job
{
    public function handle()
    {
        $words = json_decode(file_get_contents(base_path(ExamSystem::ENGLISH_WORDS_PATH)));
        shuffle($words);

        $randomWords = [];
        $count = 0;

        foreach ($words as $word) {
            if ($count >= ExamSystem::WORDS_COUNT) {
                break;
            }
            $randomWords[] = $word;
            $count++;
        }

        return implode(' ', $randomWords);
    }
}
