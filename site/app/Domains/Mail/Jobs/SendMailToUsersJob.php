<?php

namespace App\Domains\Mail\Jobs;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Lucid\Foundation\Job;

class SendMailToUsersJob extends Job implements ShouldQueue
{
    /**
     * @var array
     */
    private $emails;

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $view;

    /**
     * @var string
     */
    private $subject;

    /**
     * SendMailToStudentJob constructor.
     * @param array $emails
     * @param string $view
     * @param string $subject
     * @param array $data
     */
    public function __construct(array $emails, string $view, string $subject, array $data = [])
    {
        $this->emails = $emails;
        $this->data = $data;
        $this->view = $view;
        $this->subject = $subject;
    }

    public function handle()
    {
        Mail::send($this->view, $this->data, function ($message) {
            $message->to($this->emails)->subject($this->subject);
        });
    }
}
