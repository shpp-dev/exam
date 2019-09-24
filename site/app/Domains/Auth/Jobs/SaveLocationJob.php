<?php


namespace App\Domains\Auth\Jobs;


use App\Location;
use Lucid\Foundation\Job;

class SaveLocationJob extends Job
{
    private $name;
    private $address;

    public function __construct(string $name, string $address)
    {
        $this->name = $name;
        $this->address = $address;
    }

    public function handle()
    {
        return Location::updateOrCreate(['name' => $this->name], ['address' => $this->address]);
    }
}
