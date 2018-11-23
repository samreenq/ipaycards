<?php
/**
 * this model is create to get data from flat table
 */

namespace App\Http\Models\Custom;

use App\Http\Models\Base;
use App\Libraries\GeneralSetting;
use Illuminate\Database\Eloquent\Model;

Class BrandFlat extends Base
{

    public function __construct()
    {
        // set tables and keys
        $this->__table = $this->table = 'brand_flat';
    }

    /**
     * @param $category_id
     * @return bool
     */
    public function getByCategoryID($category_id)
    {
        $query = "SELECT b.* FROM brand_flat b
                  WHERE b.brand_category_id = (SELECT parent_id FROM sys_category where category_id = $category_id)
                  ORDER BY b.entity_id DESC";

        $row = \DB::select($query);
        return isset($row[0]) ? $row : false;

    }




}