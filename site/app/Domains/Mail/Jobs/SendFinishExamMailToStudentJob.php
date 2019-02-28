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
    private $emails;

    /**
     * SendFinishExamMailToStudentJob constructor.
     * @param array $emails
     */
    public function __construct(array $emails)
    {
        $this->emails = $emails;
    }

    public function handle()
    {
        Mail::send('mails.exam_completed', [], function ($message) {
            $message->to($this->emails)->subject('Экзамен завершен');
        });
    }
}
