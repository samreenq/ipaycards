<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;


class LaptopModel extends Base
{

    public function __construct()
    {
        // set tables and keys
        $this->__table = 'laptop_model';
        $this->primaryKey =  'id';
        $this->__keyParam = $this->primaryKey . '-';
        $this->hidden = [];

        // set fields
        $this->__fields = array($this->primaryKey, 'title', 'created_at', 'updated_at');
    }




}
