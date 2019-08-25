<?php

namespace App\Domains\Mail\Jobs;


use Illuminate\Support\Facades\Mail;
use Lucid\Foundation\Job;

class SendMailToUserJob extends Job
{
    /**
     * @var string
     */
    private $email;

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
     * @param string $email
     * @param string $view
     * @param string $subject
     * @param array $data
     */
    public function __construct(string $email, string $view, string $subject, array $data = [])
    {
        $this->email = $email;
        $this->data = $data;
        $this->view = $view;
        $this->subject = $subject;
    }

    public function handle()
    {
        Mail::send($this->view, $this->data, function ($message) {
            $message->to($this->email)->subject($this->subject);
        });
    }
}
