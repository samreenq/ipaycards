<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes AS SoftDeletes;

// init models
//use App\Http\Models\Conf;

class SYSCategory extends Base
{

    use SoftDeletes;
    public $table = 'sys_category';
    public $timestamps = true;
    public $primaryKey;
    public $data;
    protected $dates = ['deleted_at'];



    public function __construct()
    {
        // set tables and keys
        $this->__table = $this->table;
        $this->primaryKey = 'category_id';
        $this->__keyParam = $this->primaryKey . '-';
        $this->hidden = array();

        // set fields
        $this->__fields = array($this->primaryKey,'is_parent', 'parent_id', "title","slug", "description",'parent_ids','product_count','level','is_featured','featured_type','category_type','status','created_at', 'updated_at', 'deleted_at','is_gift_card','top_category');
    }

    public function getData($id=0,$status = false)
    {
        $data = $this->get($id);

        if ($data !== FALSE) {
            $data->child = $this->getChild($id,$status);

            //Calculate parent product count only by sum of active sub categories
            if($data->parent_id == 0 && $data->child){
                $parent_product_count = 0;
                if(count($data->child)>0){

                    foreach($data->child as $key => $child){


                      //  print_r($child);
                        if($child->status == 1){

                            $sys_table_flat = new SYSTableFlat('product');
                            $get_total = $sys_table_flat->getDataByWhere(" FIND_IN_SET('".$child->category_id."',category_id) AND status = 1",array('count(entity_id) as total'));
                            $total_products = isset($get_total[0]->total) ? $get_total[0]->total : 0;
                          //  echo "<pre>"; print_r($get_total); exit;
                            //$product_count  = ($child->product_count > 0) ? $child->product_count : 0;
                            $data->child[$key]->product_count = $total_products;
                            $parent_product_count += $total_products;
                            
                        }

                    }
                }
                $data->product_count =  $parent_product_count;
            }
            elseif((isset($data->is_gift_card) && $data->is_gift_card == 1) || (isset($data->slug) && $data->slug == 'deal')){

                    $sys_table_flat = new SYSTableFlat('product');
                    $get_total = $sys_table_flat->getDataByWhere(" category_id IN ($data->category_id) AND status = 1",array('count(entity_id) as total'));
                  //  echo "<pre>"; print_r($get_total); exit;
                    $data->product_count = isset($get_total[0]->total) ? $get_total[0]->total : 0;
            }
        }

        return $data;
    }

    public function getChild($id=0,$status = false)
    {
        $child = array();
        $query = $this->select('category_id')
                    ->whereNull("deleted_at")
                    ->where("parent_id", "=", $id);

        if($status){
            $query = $query->where('status','=',1);
        }

        $query = $query->get();

        foreach ($query as $record) {
            $child[] = $this->getData($record->category_id);
        }
        return $child;
    }

    public function addParentList($id=0)
    {
        \DB::statement("CALL category_parents($id)");

    }

    public function UpdateProductCountInCategory($id=0,$operation='+')
    {
        \DB::statement("CALL update_category_product_count($id,'$operation')");

    }

    /**
     * @param int $parent_id
     * @return bool
     */
    public function getCategoryType($parent_id)
    {
        $row = $this->select('category_type')
            ->whereNull("deleted_at")
            ->where("category_id", "=", $parent_id)->get();


        return isset($row[0]) ? $row[0]->category_type : false;
    }

    /**
     * Get Category title by role id
     * @param $id
     * @return bool
     */
    public function geCategoryTitleById($id){
        $row = $this->select('title')->where($this->primaryKey, '=', $id)
            ->whereNull("deleted_at")
            ->get();
        return isset($row[0])?$row[0]->title:false;
    }

    /**Get Category data by title
     * @param $title
     * @return bool
     */
    public function getCategoryByTitle($title){
        $row = $this->where('title', '=', $title)
            ->whereNull("deleted_at")
            ->get();
        return isset($row[0])?$row[0]:false;
    }

    /**
     * Get parents by category ids
     * @param $ids
     * @return bool
     */
    public function getParentsByCategoryIds($ids)
    {
        $row = $this->whereIn('category_id', $ids)
            ->whereNull("deleted_at")
            ->get();

        return isset($row[0])?$row:false;
    }

    /**
     * @param $cat_id
     * @return mixed
     */
    public function getChildCategories($cat_id)
    {
       $result = \DB::select("SELECT GROUP_CONCAT(category_id) as cat_ids FROM $this->__table WHERE parent_id = $cat_id");
       return isset($result[0]->cat_ids) ? $result[0]->cat_ids : false;
    }


}