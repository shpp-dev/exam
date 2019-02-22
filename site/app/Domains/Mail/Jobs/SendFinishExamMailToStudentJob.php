<?php
namespace App\Domains\Mail\Jobs;

use App\Data\Contracts\Repositories\UserRepositoryInterface;
use App\Data\Entities\User;
use Illuminate\Support\Facades\Mail;
use Lucid\Foundation\Job;

/**
 * Class SendFinishExamMailToStudentJob
 * @package App\Domains\Mail\Jobs
 */
class SendFinishExamMailToStudentJob extends Job
{
    /**
     * @var string
     */
    private $receiverEmail;

    /**
     * SendFinishExamMailToStudentJob constructor.
     * @param string $receiverEmail
     */
    public function __construct(string $receiverEmail)
    {
        $this->receiverEmail = $receiverEmail;
    }

    public function handle()
    {
        Mail::send('emails.exam_finished', [], function ($message) {
            $message->to($this->receiverEmail)->subject('Экзамен завершен');
        });
    }
}
