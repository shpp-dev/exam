<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Print test header
     *
     * @param $message
     * @param $number
     */
    public function printTestHeader($number, $message)
    {
        fwrite(STDOUT, "=================================================================\nTest $number: [$message]\n");
    }

    /**
     * Print test response
     *
     * @param $response
     */
    public function printTestResponse($response)
    {
        fwrite(STDOUT, "\e[34mresponse:\e[0m \n$response\n");
    }

    /**
     * Print success message test
     *
     * @param int $time
     */
    public function printTestSuccess($time = 0)
    {
        $time = round($time, 3);
        fwrite(STDOUT, "\e[1;32mtest passed\e[0m [time: $time]\n");
    }

    /**
     * Print database table to console
     *
     * @param $tableName
     * @param bool $printBeforeTest
     */
    public function printDatabaseTable(string $tableName)
    {
        $models = DB::select("select * from {$tableName}");

        if (!$models) {
            return;
        }

        foreach ($models as $model) {
            $keys = [];
            $values = [];

            foreach ($model as $key => $value) {

                $keys[] = $key;

                if ($value instanceof Carbon) {
                    $value = $value->toDateString();
                }

                $values[] = $value;
            }

            $data[] = $values;
        }

        array_unshift($data, $keys);
        $table = $this->tableToString($data);

        fwrite(STDOUT, "\e[34mtable name:\e[0m $tableName\n\e[47m$table\e[0m");
    }

    /**
     * Convert table to string
     *
     * @param $data
     * @return string
     */
    private function tableToString($data)
    {
        $columns = [];
        foreach ($data as $row_key => $row) {
            foreach ($row as $cell_key => $cell) {
                $length = mb_strlen($cell);
                if (empty($columns[$cell_key]) || $columns[$cell_key] < $length) {
                    $columns[$cell_key] = $length;
                }
            }
        }

        $table = '';
        foreach ($data as $row_key => $row) {
            foreach ($row as $cell_key => $cell) {
                $table .= $this->mb_str_pad($cell, $columns[$cell_key]) . '  ';
            }
            $table .= PHP_EOL;
        }

        return $table;
    }

    /**
     * UTF-8 str_pad
     *
     * source: https://coderwall.com/p/-xpdkq/utf-8-str_pad-in-php
     *
     * @param $input
     * @param $pad_length
     * @param string $pad_string
     * @param int $pad_style
     * @param string $encoding
     * @return string
     */
    private function mb_str_pad(
        $input,
        $pad_length,
        $pad_string=" ",
        $pad_style=STR_PAD_RIGHT,
        $encoding="UTF-8")
    {
        return str_pad(
            $input,
            strlen($input)-mb_strlen($input,$encoding)+$pad_length,
            $pad_string,
            $pad_style);
    }
}
