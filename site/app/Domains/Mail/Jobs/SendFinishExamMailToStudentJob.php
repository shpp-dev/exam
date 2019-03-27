<?php
namespace App\Domains\Mail\Jobs;

use Illuminate\Support\Facades\Mail;
use Lucid\Foundation\Job;

/**
 * Class SendFinishExamMailToStudentJob
 * @package App\Domains\Mail\Jobs
 */
class SendFinishExamMailToStudentJob extends Job
{
    /**
     * @var array
     */
    private $email;

    /**
     * SendFinishExamMailToStudentJob constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function handle()
    {
        Mail::send('mails.exam_completed', [], function ($message) {
            $message->to($this->email)->subject('Экзамен завершен');
        });
    }
}
