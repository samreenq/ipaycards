<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Base
{

    public function __construct()
    {
        // set tables and keys
        $this->__table = $this->table = 'country';
        $this->primaryKey = $this->__table . '_id';
        $this->__keyParam = $this->primaryKey . '-';
        $this->hidden = [];

        // set fields
        $this->__fields = [$this->primaryKey, 'name', 'currency', 'currency_code'];
    }



}