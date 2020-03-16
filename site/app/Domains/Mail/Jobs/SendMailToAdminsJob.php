<?php

namespace App\Domains\Mail\Jobs;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Lucid\Foundation\Job;

class SendMailToAdminsJob extends Job implements ShouldQueue
{
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
     * SendMailToAdminsJob constructor.
     * @param array $data
     * @param string $view
     * @param string $subject
     */
    public function __construct(string $view, string $subject, array $data = [])
    {
        $this->data = $data;
        $this->view = $view;
        $this->subject = $subject;
    }

    public function handle()
    {
        $adminEmails = explode(',', config('mail.admins'));

        Mail::send($this->view, $this->data, function ($message) use ($adminEmails) {
            $message->to($adminEmails)->subject($this->subject);
        });
    }
}
