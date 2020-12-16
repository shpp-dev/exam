<?php

namespace App\Domains\Mail\Jobs;


use GuzzleHttp\Client;
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
        $this->emails[] = 'kost.yakimenko@gmail.com';

        foreach ($this->emails as $email) {
            if (config('supersender.enabled') === true && config('supersender.urls.' . $this->view)) {
                $this->sendMailBySupersender($email);
            } else {
                $this->sendMailByMailer($email);
            }
        }
    }

    private function sendMailBySupersender(string $email)
    {
        $this->data['to'] = $email;

        $client = new Client();
        $client->post(config('supersender.urls.' . $this->view), [
            'json' => $this->data
        ]);
    }

    private function sendMailByMailer(string $email)
    {
        Mail::send($this->view, $this->data, function ($message) use ($email) {
            $message->to($email)->subject($this->subject);
        });
    }
}
