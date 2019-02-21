<?php
namespace App\Domains\Helpers\Traits;


trait MappedTrait
{

    /**
     * @param array $rows
     * @param string $key
     * @return array
     */
    public function getMapped(array $rows, string $key)
    {
        $mapped = [];
        foreach ($rows as $row) {
            $mapped[$row->{$key}()] = $row;
        }
        return $mapped;
    }
}
