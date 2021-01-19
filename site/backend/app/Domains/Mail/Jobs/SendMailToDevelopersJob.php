<?php


namespace App\Domains\Mail\Jobs;


use Illuminate\Support\Facades\Mail;
use Lucid\Foundation\Job;

class SendMailToDevelopersJob extends Job
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $developerEmails;

    /**
     * SendMailToDevelopersJob constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
        $this->developerEmails = explode(',', config('mail.developers'));
    }

    public function handle()
    {
        Mail::raw($this->message, function ($message) {
            $message
                ->to($this->developerEmails)
                ->subject(__('email_subjects.error'));
        });
    }
}
