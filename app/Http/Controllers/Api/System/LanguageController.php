<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Controller;
use App\Http\Models\PLAttachment;
use App\Http\Models\SYSEntityHistory;
use App\Libraries\System\LanguageLib;
use Illuminate\Http\Request;

use View;
use Validator;
// load models
use App\Http\Models\ApiMethod;
use App\Http\Models\ApiMethodField;
use App\Http\Models\ApiUser;
use App\Http\Models\EFEntityPlugin;
use App\Http\Models\Conf;

//use Twilio;

class LanguageController extends Controller
{

    private $_apiData = array();
    private $_layout = "";
    private $_models = array();
    private $_jsonData = array();
    private $_model_path = "\App\Http\Models\\";
    private $_object_identifier = "language";
    private $_entity_pk = "language_id";
    private $_entity_model = "Language";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        // load entity model
        $this->_entity_model = $this->_model_path . $this->_entity_model;
        $this->_entity_model = new $this->_entity_model;

        // error response by default
        $this->_apiData['kick_user'] = 0;
        $this->_apiData['response'] = "error";
    }

    /**
     *  Show the application dashboard to the user.
     */
    public function index()
    {

    }


    /**
     * Create
     *
     * @return Response
     */
    public function post(Request $request)
    {
        // trim/escape all
       /* $request->merge(array_map('strip_tags', $request->all()));
        $request->merge(array_map('trim', $request->all()));*/

        // extra models
        $exModel = $this->_model_path . "SYSEntityType";
        $exModel = new $exModel;

        // validations
        $rules = array(
           'title' => "required|string|alpha_custom|unique:". $this->_entity_model->table .",title,NULL,". $this->_entity_model->primaryKey .",deleted_at,NULL",
            "identifier" => "required|string|unique:". $this->_entity_model->table .",identifier,NULL,". $this->_entity_model->primaryKey .",deleted_at,NULL",
            "file" => "required|int",
            "validation_file" => "required|int",
            "text_direction" => "required",
            "status" => "required",
         );

       // $rules['title'] = "required|string|alpha_custom|unique:sys_role,title,NULL,deleted_at";

        $validator = Validator::make($request->all(), $rules);

        // validate
        if ($validator->fails()) {
            $this->_apiData['message'] = $validator->errors()->first();
        } else {

            //Check Language File Validation
            $language_lib = new LanguageLib();
            $validate_file =  $language_lib->validateFile($request->all(),'file');

            if($validate_file['error'] == 1){
                $this->_apiData['message'] = $validate_file['message'];
                return $this->__ApiResponse($request, $this->_apiData);
            }

            $validation_file =  $language_lib->validateFile($request->all(),'validation_file');
            if($validation_file['error'] == 1){
                $this->_apiData['message'] = $validation_file['message'];
                return $this->__ApiResponse($request, $this->_apiData);
            }




            // success response
                $this->_apiData['response'] = "success";


                // init output data array
                $this->_apiData['data'] = $data = array();

                // init entity
                $entity = array();
                // map data
                foreach ($rules as $key => $val) {
                    $entity[$key] = $request->input($key, "");
                }
                // other data

               $entity["created_at"] = date("Y-m-d H:i:s");
                $entity_id = $this->_entity_model->put($entity);

                //Create Language File
                $language_lib->createFile($validate_file['data'],$request->identifier);
                 $language_lib->createValidationFile($validation_file['data'],$request->identifier);

                // response data
                $data[$this->_object_identifier] = $this->_entity_model->getData($entity_id);

                $this->_apiData['message'] = trans('system.success');

                // assign to output
                $this->_apiData['data'] = $data;


                //Log History and save system notification
                $sys_history = new SYSEntityHistory();
                $other_data['extension_ref_table'] = 'language';
                $other_data['extension_ref_id'] = $entity_id;
                $timestamp = date("Y-m-d H:i:s");
                $target_entity_id = false;
                $request_params = json_decode(json_encode($request->all()));
                $sys_history->logHistory('entity_add', $entity_id, $target_entity_id, $other_data, $timestamp, $request_params);


        }

        return $this->__ApiResponse($request, $this->_apiData);
    }


    /**
     * Get
     *
     * @return Response
     */
    public function get(Request $request)
    {
        // trim/escape all
        /*$request->merge(array_map('strip_tags', $request->all()));
        $request->merge(array_map('trim', $request->all()));*/

        // validations
        $rules = array(
            $this->_entity_pk => 'required|integer|exists:' . $this->_entity_model->table . "," . $this->_entity_model->primaryKey . ",deleted_at,NULL"
        );
        $validator = Validator::make($request->all(), $rules);

        // get data
        $entity = $this->_entity_model
            ->where($this->_entity_pk, "=", $request->{$this->_entity_pk})
            ->whereNull("deleted_at")
            ->first();

        // validate
        if ($validator->fails()) {
            $this->_apiData['message'] = $validator->errors()->first();
        } else if (!$entity) {
            $this->_apiData['message'] = trans('system.invalid_record_request');
        } else {
            // success response
            $this->_apiData['response'] = "success";

            // init output data array
            $this->_apiData['data'] = $data = array();

            // get user data
            $data[$this->_object_identifier] = $this->_entity_model->getData($entity->{$this->_entity_pk});

            // message
            $this->_apiData['message'] = trans('system.success');

            // assign to output
            $this->_apiData['data'] = $data;
        }


        return $this->__ApiResponse($request, $this->_apiData);
    }


    /**
     * Update
     *
     * @return Response
     */
    public function update(Request $request)
    {
        /*$request->merge(array_map('strip_tags', $request->all()));
        $request->merge(array_map('trim', $request->all()));*/

        // extra models
        $exModel = $this->_model_path . "SYSEntity";
        $exModel = new $exModel;

        // validations
        $rules = array(
            $this->_entity_pk => 'required|integer|exists:' . $this->_entity_model->table . "," . $this->_entity_model->primaryKey . ",deleted_at,NULL",
            'title' => "required|string|alpha_custom",
            "identifier" => "required|string",
            "file" => "required|int",
            "validation_file" => "required|int",
            "text_direction" => "required",
            "status" => "required",
        );

        $validator = Validator::make($request->all(), $rules);

        // get data
        $entity = $this->_entity_model
            ->where($this->_entity_pk, "=", $request->{$this->_entity_pk})
            ->whereNull("deleted_at")
            ->first();

        // validate
        if ($validator->fails()) {
            $this->_apiData['message'] = $validator->errors()->first();
        } else if (!$entity) {
            $this->_apiData['message'] = trans('system.invalid_record_request');
        } else {

            $update_language_file = false;
            $update_validation_file = false;

            $language_lib = new LanguageLib();
            $pl_attachment = new PLAttachment();

            if($entity->file != $request->file){
                //Check Language File Validation
                $old_language_file = $entity->file;
                $update_language_file = true;
                $validate_file =  $language_lib->validateFile($request->all(),'file');

                if($validate_file['error'] == 1){
                    $this->_apiData['message'] = $validate_file['message'];
                    return $this->__ApiResponse($request, $this->_apiData);
                }
            }

            if($entity->validation_file != $request->validation_file){
                //Check Language File Validation
                $update_validation_file = true;
                $old_validation_file = $entity->validation_file;
                $validation_file =  $language_lib->validateFile($request->all(),'validation_file');

                if($validation_file['error'] == 1){
                    $this->_apiData['message'] = $validation_file['message'];
                    return $this->__ApiResponse($request, $this->_apiData);
                }
            }

            // get
            $entity = json_decode(json_encode($entity), TRUE);

            //check if department is already exist b/c laraval unique validation was not working on it thats
            $this->_apiData['response'] = "success";

            // init output data array
            $this->_apiData['data'] = $data = [];


            // map data
            foreach ($rules as $key => $val) {
                $entity[ $key ] = $request->input($key, "");
            }

            $entity["updated_at"] = date("Y-m-d H:i:s");

            $entity_id = $this->_entity_model->set($entity[ $this->_entity_pk ], $entity);

            //Create Language File
            if($update_language_file){
                $language_lib->createFile($validate_file['data'],$request->identifier);
            }

            if($update_validation_file){
                $language_lib->createValidationFile($validation_file['data'],$request->identifier);
            }

            // response data
            $data[$this->_object_identifier] = $this->_entity_model->getData($entity_id);

            $this->_apiData['message'] = trans('system.success');

            // assign to output
            $this->_apiData['data'] = $data;

                //Log History and save system notification
                $sys_history = new SYSEntityHistory();
                $other_data['extension_ref_table'] = 'sys_role';
                $other_data['extension_ref_id'] = $entity[ $this->_entity_pk ];
                $timestamp = date("Y-m-d H:i:s");
                $target_entity_id = false;
                $request_params = json_decode(json_encode($request->all()));
                $sys_history->logHistory('entity_update', $entity[$this->_entity_pk], $target_entity_id, $other_data, $timestamp, $request_params);


         }

        return $this->__ApiResponse($request, $this->_apiData);
    }


    /**
     * Listin / Search
     *
     * @return Response
     */
    public function listing(Request $request)
    {
	
        // trim/escape all
        /*$request->merge(array_map('strip_tags', $request->all()));
        $request->merge(array_map('trim', $request->all()));*/

        // override object identifier
        $this->_object_identifier = $this->_object_identifier . "_" . strtolower(__FUNCTION__);
        // extra models
        $exModel = $this->_model_path . "SYSEntity";
        $exModel = new $exModel;
        // allowed order
        $allowed_ordering = $allowed_searching = $this->_entity_model->primaryKey . ",title,created_at";
        $allowed_sorting = "asc,desc";


        // validations
        $rules = array(
            $this->_entity_pk => 'integer|exists:' . $this->_entity_model->table . "," . $this->_entity_model->primaryKey . ",deleted_at,NULL",
           'title' => 'string',
            //'slug' => "string|unique:".$this->_entity_model->table.",".$this->_entity_model->primaryKey.",NULL,deleted_at,parent_id,".$request->parent_id,
           // 'description' => 'string',
           // 'created_by' => 'integer:exists:' . $exModel->table . "," . $exModel->primaryKey . ",deleted_at,NULL",
            "order_by" => "in:" . $allowed_ordering,
            "sorting" => "in:" . $allowed_sorting,
            "offset" => "integer",
            "limit" => "integer"
        );
        $validator = Validator::make($request->all(), $rules);

        // validate
        if ($validator->fails()) {
            $this->_apiData['message'] = $validator->errors()->first();
        } else {
            // success response
            $this->_apiData['response'] = "success";

            // init output data array
            $this->_apiData['data'] = $data = array();

            $listing = array();
            // init listing object
            $data[$this->_object_identifier] = array();

            // sorting defaults
            $request->order_by = $request->input("order_by", "") == "" ? explode(",", $allowed_ordering)[0] : $request->order_by;
            $request->sorting = $request->input("sorting", "") == "" ? explode(",", $allowed_sorting)[0] : $request->sorting;


            $query = $this->_entity_model->select($this->_entity_model->primaryKey);

            $query->whereNull("deleted_at"); // exclude deleted
            // apply search
            $query = $this->_search($request, $query, $allowed_searching);

            //echo $query->toSql(); exit;
            // get total
            $total_records = $query->count();


            // default offset / limits
            $request->offset = 0;
            $request->limit = $total_records;
            // if need paging
            // params
            $request->limit = $request->input("limit", "") == "" ? PAGE_LIMIT_API : intval($request->input("limit", ""));
            $request->offset = intval($request->input("offset", 0));
            // offfset / limits / valid pages
            $request->offset = $request->offset < $total_records ? $request->offset : ($total_records - 1);
            $request->offset = $request->offset < 0 ? 0 : $request->offset;

            // apply order
            $query->orderBy($request->order_by, strtoupper($request->sorting));
            $query->take($request->limit);
            $query->skip($request->offset);
            //$raw_records = $query->select(explode(",", $allowed_ordering))->get();
            $raw_records = $query->get();

            // set records
            if (isset($raw_records[0])) {
                //var_dump($raw_records); exit;
                foreach ($raw_records as $raw_record) {
                    //$record = $raw_record;
                    $record = $this->_entity_model->getData($raw_record->{$this->_entity_model->primaryKey});

                    $data[$this->_object_identifier][] = $record;
                }
            }

            // set pagination response
            $data["page"] = array(
                "offset" => $request->offset,
                "limit" => $request->limit,
                "total_records" => $total_records,
                "next_offset" => ($request->offset + $request->limit),
                "prev_offset" => $request->offset > 0 ? ($request->offset - $request->limit) : $request->offset,
            );


            // message
            $this->_apiData['message'] = trans('system.success');

            // assign to output
            $this->_apiData['data'] = $data;
        }


        return $this->__ApiResponse($request, $this->_apiData);
    }


    /**
     * Search
     * @param $query query
     * @return query
     */
    private function _search($request, $query, $allowed_searching = "")
    {
        // fix indexes
        $fix_indexes = array($this->_entity_pk, "target_entity_id", "created_by","entity_type_id","parent_id");
        // search
        foreach (explode(",", $allowed_searching) as $field) {
            // if in fix indexes
            if (in_array($field, $fix_indexes)) {
                // all fix searches
                if ($request->{$field} != "") {
                    $q = trim(strtolower($request->{$field}));
                    $query->where($field, '=', "$q");
                }
            } else {
                // all LIKE searches
                if ($request->{$field} != "") {
                    $q = trim(strtolower($request->{$field}));
                    $query->where($field, 'like', "%$q%");
                }
            }
        }
        return $query;
    }


    /**
     * Delete
     *
     * @return Response
     */
    public function delete(Request $request)
    {
        // trim/escape all
       /* $request->merge(array_map('strip_tags', $request->all()));
        $request->merge(array_map('trim', $request->all()));*/

        $rules = array(
            $this->_entity_pk => 'required|integer|exists:' . $this->_entity_model->table . "," . $this->_entity_model->primaryKey . ",deleted_at,NULL"
        );

        $validator = Validator::make($request->all(), $rules);

        // get data
        $entity = $this->_entity_model
            ->where($this->_entity_pk, "=", $request->{$this->_entity_pk})
            ->whereNull("deleted_at")
            ->first();



        // validate
        if ($validator->fails()) {
            $this->_apiData['message'] = $validator->errors()->first();
        } else if (!$entity) {
            $this->_apiData['message'] = trans('system.invalid_record_request');
        } else {


            // success response
            $this->_apiData['response'] = "success";

            // init output data array
            $this->_apiData['data'] = $data = array();

            if(isset($entity->file)){
                $pl_attachment = new PLAttachment();
                $attachment = $pl_attachment->getData($entity->file);
                unlink(base_path($attachment->file));
               // unlink(base_path() .'/'.config('constants.LANGUAGE_PATH').config('constants.TRANSLATION_FILE_NAME'));
                $pl_attachment->remove($entity->file);

                $attachment = $pl_attachment->getData($entity->validation_file);
                unlink(base_path($attachment->file));
                // unlink(base_path() .'/'.config('constants.LANGUAGE_PATH').config('constants.TRANSLATION_FILE_NAME'));
                $pl_attachment->remove($entity->validation_file);
            }

            // get
            $entity = json_decode(json_encode($entity), true);


            // to-do
            // delete dependencies first
            $this->_entity_model->remove($entity[$this->_entity_pk]);

            // response data
            $data[$this->_object_identifier] = $this->_entity_model->getData($entity[$this->_entity_pk]);

            $this->_apiData['message'] = trans('system.success');

            // assign to output
            $this->_apiData['data'] = $data;
        }

        return $this->__ApiResponse($request, $this->_apiData);
    }


}