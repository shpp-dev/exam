<?php
/**
 * Created by IntelliJ IDEA.
 * User: eri
 * Date: 17.01.19
 * Time: 12:52
 */

namespace App\Foundation;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    // Allow for camelCased attribute access

    public function getAttribute($key)
    {
        return parent::getAttribute(snake_case($key));
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute(snake_case($key), $value);
    }
}
