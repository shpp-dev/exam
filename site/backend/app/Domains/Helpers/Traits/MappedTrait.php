<?php
namespace App\Domains\Helpers\Traits;


use Illuminate\Database\Eloquent\Collection;

trait MappedTrait
{

    /**
     * @param Collection $rows
     * @param string $key
     * @return array
     */
    public function getMapped(Collection $rows, string $key)
    {
        $mapped = [];
        foreach ($rows as $row) {
            $mapped[$row->{$key}] = $row;
        }
        return $mapped;
    }
}
