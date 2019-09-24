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
        $location = Location::where('name', $this->name)->first();

        if ($location) {
            $location->address = $this->address;
        } else {
            $location = new Location();
            $location->name = $this->name;
            $location->address = $this->address;
        }

        $location->save();

        return $location;
    }
}
