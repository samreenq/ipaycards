<?php
namespace App\Http\Controllers\Api\Extension\Validator;

use App\Http\Controllers\Controller;
use App\Libraries\CustomHelper;
use Illuminate\Http\Request;
use View;
use Validator;
// load models
use App\Http\Models\ApiMethod;
use App\Http\Models\ApiMethodField;
use App\Http\Models\ApiUser;
use App\Http\Models\Conf;

//use Twilio;

class EntityTypeFormController extends Controller
{
    protected $_assignData = array(
        'p_dir' => '',
        'dir' => DIR_API
    );
    protected $_apiData = array();
    protected $_layout = "";
    protected $_models = array();
    protected $_jsonData = array();
    private $_mobileJSON = false;
    private $_pModelPath = "Extension\\Validator\\";
    protected $_entityModel = "SYSEntity";
    protected $_eHistoryModel = "SYSEntityHistory";
    // system
    private $_entityTypeModel = "SYSEntityType";
    private $_extStatModel = "SYSExtensionStat";
    private $_eTypeExtMapModel = "SYSEntityTypeExtensionMap";
    // extension
    private $_extMapData; // extension mapping data
    private $_extIdentifier = "ext_validator";
    private $_historyIdentifier = "form";
    //private $_activityTypeModel = "ExtActivityType"; // extension required model
    private $_pModel = "EntityTypeFormMap"; // extension model
    private $_pHook = "EntityTypeFormMap"; // extension hook
    private $_langIdentifier = 'system';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        // set extension path
        $this->_pModelPath = $this->_modelPath . $this->_pModelPath;
        // load extension model
        $this->_pModel = $this->_pModelPath . $this->_pModel;
        $this->_pModel = new $this->_pModel;
        // load extension map model
        $this->_eTypeExtMapModel = $this->_modelPath . $this->_eTypeExtMapModel;
        $this->_eTypeExtMapModel = new $this->_eTypeExtMapModel;

        // load activity model
        /*$this->_activityTypeModel = $this->_pModelPath . $this->_activityTypeModel;
        $this->_activityTypeModel = new $this->_activityTypeModel;*/

        // error response by default
        $this->_apiData['kick_user'] = 0;
        $this->_apiData['response'] = "error";

        // check access before proceeding, (get extension ID on access)
        /*$this->_extMapData = $this->_eTypeExtMapModel->checkAPIAccess(
            $this->_extIdentifier,
            $request
        );

        // save activity type data
        $this->_activityTypeData = $this->_activityTypeModel->getBy('identifier', $this->_activityIdentifier);
        */

        // init models
        $this->__models['conf_model'] = new Conf;

        $this->_entityTypeModel = $this->_modelPath . $this->_entityTypeModel;
        $this->_entityTypeModel = new $this->_entityTypeModel;

        $this->_extStatModel = $this->_modelPath . $this->_extStatModel;
        $this->_extStatModel = new $this->_extStatModel;

        // handle entity type id vs identifier
        // - actor entity type ID
        if (!is_numeric(trim($request->{"actor_" . $this->_entityTypeModel->primaryKey}))) {
            $et_data = $this->_entityTypeModel->getBy("identifier", trim($request->{"actor_" . $this->_entityTypeModel->primaryKey}));
            // assign to request
            $et_id = isset($et_data->{$this->_entityTypeModel->primaryKey}) ?
                $et_data->{$this->_entityTypeModel->primaryKey} : 0;
            $request->merge(array("actor_" . $this->_entityTypeModel->primaryKey => $et_id));
            unset($et_id, $et_data);
        }
        // - target entity type ID
        if (!is_numeric(trim($request->{"target_" . $this->_entityTypeModel->primaryKey}))) {
            $et_data = $this->_entityTypeModel->getBy("identifier", trim($request->{"target_" . $this->_entityTypeModel->primaryKey}));
            // assign to request
            $et_id = isset($et_data->{$this->_entityTypeModel->primaryKey}) ?
                $et_data->{$this->_entityTypeModel->primaryKey} : 0;
            $request->merge(array("target_" . $this->_entityTypeModel->primaryKey => $et_id));
            unset($et_id, $et_data);
        }

        $this->_entityModel = $this->_modelPath . $this->_entityModel;
        $this->_entityModel = new $this->_entityModel;

        $this->_mobileJSON = (isset($request->mobile_json)) ? true : false;
        CustomHelper::$mobileJson = $this->_mobileJSON; // set to helper var

    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {

    }


    /**
     * post
     *
     * @return Response
     */
    public function post(Request $request)
    {
        // trim/escape all
        $request->merge(array_map('strip_tags', $request->all()));
        $request->merge(array_map('trim', $request->all()));

        // optional fields
        $optionalFields = array();

        // validations
        $validator = Validator::make($request->all(), array(
            // entity type id
            'target_' . $this->_entityTypeModel->primaryKey => 'required|int|exists:' . $this->_entityTypeModel->table . ',' . $this->_entityTypeModel->primaryKey . ',deleted_at,NULL',
            // entity vs entity type
            //'target_' . $this->_entityModel->primaryKey => 'required|int|exists:' . $this->_entityModel->table . "," . $this->_entityModel->primaryKey . "," . $this->_entityTypeModel->primaryKey . "," . $request->input("target_" . $this->_entityTypeModel->primaryKey) . ',deleted_at,NULL',
            // entity type id
            'actor_' . $this->_entityTypeModel->primaryKey => 'required|int|exists:' . $this->_entityTypeModel->table . ',' . $this->_entityTypeModel->primaryKey . ',allow_auth,1,deleted_at,NULL',
            // actory entity vs actor entity type
            'actor_' . $this->_entityModel->primaryKey => 'required|int|exists:' . $this->_entityModel->table . "," . $this->_entityModel->primaryKey . "," . $this->_entityTypeModel->primaryKey . "," . $request->input("actor_" . $this->_entityTypeModel->primaryKey) . ',deleted_at,NULL',
            'title' => 'required',
            // json data
            //"json_data" => "required_without:review|json",

        ));

        // validate
        if ($validator->fails()) {
            $this->_apiData['message'] = $validator->errors()->first();
        } else {
            // success response
            $this->_apiData['response'] = "success";

            // init output data array
            $this->_apiData['data'] = $data = array();

            // init data
            $entity = array();
            $timestamp = date("Y-m-d H:i:s");

            // generate field if not exists
            //$this->_extraFields($request);

            // prepare data
            $save = array(
                'target_' . $this->_entityTypeModel->primaryKey => $request->{'target_' . $this->_entityTypeModel->primaryKey},
                'actor_' . $this->_entityTypeModel->primaryKey => $request->{'actor_' . $this->_entityTypeModel->primaryKey},
                'actor_' . $this->_entityModel->primaryKey => $request->{'actor_' . $this->_entityModel->primaryKey},
                'title' => $request->input('title', ''),
                'description' => $request->input('description', null)
            );
            // insert
            $id = $this->_pModel->saveData($save, $timestamp);

            // api msg
            $this->_apiData['message'] = trans($this->_langIdentifier . '.entity_insert_success', array("entity" => $this->_pModel->objectIdentifier));

            // set current actor
            $this->_pModel->currentActorID = $request->{'actor_' . $this->_entityModel->primaryKey};

            // get data
            $entity = $this->_pModel->getData($id);

            // log history STARTS
            // - init model
            $this->_eHistoryModel = $this->_modelPath . $this->_eHistoryModel;
            $this->_eHistoryModel = new $this->_eHistoryModel;
            // - identifier
            $h_identifier = $this->_historyIdentifier . "_add";
            // - log
            $other_data = array(
                "extension_ref_table" => $this->_pModel->table,
                "extension_ref_id" => $id,
                "against_entity_type_id" => $request->{'target_' . $this->_entityTypeModel->primaryKey},
                "against_entity_id" => $request->{'target_' . $this->_entityModel->primaryKey},
            );
            $this->_eHistoryModel->logHistory($h_identifier,
                $request->{'target_' . $this->_entityModel->primaryKey},
                $request->{'actor_' . $this->_entityModel->primaryKey},
                $other_data,
                $timestamp,
                $request->all()
            );
            // log history ENDS


            // response data
            $data[$this->_pModel->objectIdentifier] = $entity;

            // assign to output
            $this->_apiData['data'] = $data;

        }

        // call hook
        $this->_apiData = CustomHelper::hookData($this->_pHook, __FUNCTION__, $request, $this->_apiData);

        return $this->__ApiResponse($request, $this->_apiData);

    }


    /**
     * update
     *
     * @return Response
     */
    public function xupdate(Request $request)
    {
        // trim/escape all
        $request->merge(array_map('strip_tags', $request->all()));
        $request->merge(array_map('trim', $request->all()));

        // optional fields
        $optionalFields = array();

        // validations
        $validator = Validator::make($request->all(), array(
            // entity vs entity type
            /*'target_' . $this->_entityModel->primaryKey => 'required|int|exists:' . $this->_entityModel->table . "," . $this->_entityModel->primaryKey . "," . $this->_entityTypeModel->primaryKey . "," . $request->input("target_" . $this->_entityTypeModel->primaryKey),*/
            // actory entity vs actor entity type
            'actor_' . $this->_entityModel->primaryKey => 'required|int|exists:' . $this->_entityModel->table . "," . $this->_entityModel->primaryKey . "," . $this->_entityTypeModel->primaryKey . "," . $request->input("actor_" . $this->_entityTypeModel->primaryKey),
            $this->_pModel->primaryKey => 'required|int|exists:' . $this->_pModel->table . ',' . $this->_pModel->primaryKey . ',actor_' . $this->_entityModel->primaryKey . ',' . $request->input('actor_' . $this->_entityModel->primaryKey, 0) . ',' . $this->_eTypeExtMapModel->primaryKey . ',' . $this->_extMapData->{$this->_eTypeExtMapModel->primaryKey} . ',deleted_at,NULL',
            // review
            //'review' => 'required_without:json_data',
            // rating
            'rating' => 'required|int|min:1',
            // json data
            //"json_data" => "required_without:review|json",

        ));

        // get record
        $entity_type = $this->_entityTypeModel->get($this->_extMapData->{'data_' . $this->_entityTypeModel->primaryKey});

        // validate
        if ($validator->fails()) {
            $this->_apiData['message'] = $validator->errors()->first();
        } else {
            // success response
            $this->_apiData['response'] = "success";

            // init output data array
            $this->_apiData['data'] = $data = array();

            // init data
            $id = $request->{$this->_pModel->primaryKey};
            $entity = (array)$this->_pModel->get($id);
            $timestamp = date("Y-m-d H:i:s");

            // prepare data
            $save = array(
                'review' => $request->input('review', ''),
                'rating' => $request->input('rating', 0),
                'json_data' => $request->input('json_data', null),
                "updated_at" => $timestamp
            );
            // update
            $this->_pModel->updateData($this->_extMapData, $id, $save, $timestamp);

            // api msg
            $this->_apiData['message'] = trans($this->_langIdentifier . '.entity_update_success', array("entity" => $entity_type->identifier));

            // set current actor
            $this->_pModel->currentActorID = $request->{'actor_' . $this->_entityModel->primaryKey};

            // get data
            $entity = $this->_pModel->getData($id);

            // log history STARTS
            // - init model
            $this->_eHistoryModel = $this->_modelPath . $this->_eHistoryModel;
            $this->_eHistoryModel = new $this->_eHistoryModel;
            // - identifier
            $h_identifier = $this->_pModel->objectIdentifier . "_" . __FUNCTION__;
            // - log
            $other_data = array(
                "extension_ref_table" => $this->_pModel->table,
                "extension_ref_id" => $id,
                "against_entity_type_id" => $this->_extMapData->data_entity_type_id,
                "against_entity_id" => $entity->{'data_' . $this->_entityModel->primaryKey},
            );
            $this->_eHistoryModel->logHistory($h_identifier,
                $entity->{'target_' . $this->_entityModel->primaryKey},
                $request->{'actor_' . $this->_entityModel->primaryKey},
                $other_data,
                $timestamp,
                $request->all()
            );
            // log history ENDS


            // response data
            $data[$this->_pModel->objectIdentifier] = $entity;

            // assign to output
            $this->_apiData['data'] = $data;

        }

        // call hook
        $this->_apiData = CustomHelper::hookData($this->_pHook, __FUNCTION__, $request, $this->_apiData);

        return $this->__ApiResponse($request, $this->_apiData);

    }


    /**
     * delete
     *
     * @return Response
     */
    public function xdelete(Request $request)
    {
        // trim/escape all
        $request->merge(array_map('strip_tags', $request->all()));
        $request->merge(array_map('trim', $request->all()));

        // optional fields
        $optionalFields = array();

        // validations
        $validator = Validator::make($request->all(), array(
            // actory entity vs actor entity type
            'actor_' . $this->_entityModel->primaryKey => 'required|int|exists:' . $this->_entityModel->table . "," . $this->_entityModel->primaryKey . "," . $this->_entityTypeModel->primaryKey . "," . $request->input("actor_" . $this->_entityTypeModel->primaryKey),
            $this->_pModel->primaryKey => 'required|int|exists:' . $this->_pModel->table . ',' . $this->_pModel->primaryKey . ',actor_' . $this->_entityModel->primaryKey . ',' . $request->input('actor_' . $this->_entityModel->primaryKey, 0) . ',' . $this->_eTypeExtMapModel->primaryKey . ',' . $this->_extMapData->{$this->_eTypeExtMapModel->primaryKey} . ',deleted_at,NULL',

        ));

        // get record
        $entity_type = $this->_entityTypeModel->get($this->_extMapData->{'data_' . $this->_entityTypeModel->primaryKey});

        // validate
        if ($validator->fails()) {
            $this->_apiData['message'] = $validator->errors()->first();
        } else {
            // success response
            $this->_apiData['response'] = "success";

            // init output data array
            $this->_apiData['data'] = $data = array();

            // init data
            $id = $request->{$this->_pModel->primaryKey};
            $entity = (array)$this->_pModel->get($id);
            $timestamp = date("Y-m-d H:i:s");

            // update
            $this->_pModel->removeData($this->_extMapData, $id, $timestamp);

            // api msg
            $this->_apiData['message'] = trans($this->_langIdentifier . '.entity_delete_success', array("entity" => $entity_type->identifier));

            // set current actor
            $this->_pModel->currentActorID = $request->{'actor_' . $this->_entityModel->primaryKey};

            // get data
            $entity = $this->_pModel->getData($id);

            // log history STARTS
            // - init model
            $this->_eHistoryModel = $this->_modelPath . $this->_eHistoryModel;
            $this->_eHistoryModel = new $this->_eHistoryModel;
            // - identifier
            $h_identifier = $this->_pModel->objectIdentifier . "_" . __FUNCTION__;
            // - log
            $other_data = array(
                "extension_ref_table" => $this->_pModel->table,
                "extension_ref_id" => $id,
                "against_entity_type_id" => $this->_extMapData->data_entity_type_id,
                "against_entity_id" => $entity->{'data_' . $this->_entityModel->primaryKey},
            );
            $this->_eHistoryModel->logHistory($h_identifier,
                $entity->{'target_' . $this->_entityModel->primaryKey},
                $request->{'actor_' . $this->_entityModel->primaryKey},
                $other_data,
                $timestamp,
                $request->all()
            );
            // log history ENDS


            // response data
            $data[$this->_pModel->objectIdentifier] = $entity;

            // assign to output
            $this->_apiData['data'] = $data;

        }

        // call hook
        $this->_apiData = CustomHelper::hookData($this->_pHook, __FUNCTION__, $request, $this->_apiData);

        return $this->__ApiResponse($request, $this->_apiData);

    }


    /**
     * listing
     *
     * @return Response
     */
    public function listing(Request $request)
    {
        // trim/escape all
        $request->merge(array_map('strip_tags', $request->all()));
        $request->merge(array_map('trim', $request->all()));

        // validations
        $validator = Validator::make($request->all(), array(
            // entity type id
            'target_' . $this->_entityTypeModel->primaryKey => 'required|int|exists:' . $this->_entityTypeModel->table . ',' . $this->_entityTypeModel->primaryKey . ',deleted_at,NULL',
            // entity type id
            'actor_' . $this->_entityTypeModel->primaryKey => 'required|int|exists:' . $this->_entityTypeModel->table . ',' . $this->_entityTypeModel->primaryKey . ',allow_auth,1,deleted_at,NULL',
            // actory entity vs actor entity type
            'actor_' . $this->_entityModel->primaryKey => 'required|int|exists:' . $this->_entityModel->table . "," . $this->_entityModel->primaryKey . "," . $this->_entityTypeModel->primaryKey . "," . $request->input("actor_" . $this->_entityTypeModel->primaryKey) . ',deleted_at,NULL',

        ));


        // validate
        if ($validator->fails()) {
            $this->_apiData['message'] = $validator->errors()->first();
        } else {
            // success response
            $this->_apiData['response'] = "success";

            // init output data array
            $this->_apiData['data'] = $data = array();

            // defaults
            $data[$this->_pModel->objectIdentifier . "_listing"] = array();

            // allowed ordering/sorting
            $allowed_sorting = "desc,asc";
            $allowed_ordering = $this->_pModel->primaryKey . ",created_at";
            $primary_alias = 'a.';

            // sorting defaults
            $request->order_by = $request->input("order_by", "") == "" ? explode(",", $allowed_ordering)[0] : $request->order_by;
            $request->sorting = $request->input("sorting", "") == "" ? explode(",", $allowed_sorting)[0] : $request->sorting;
            $request->sorting = strtolower($request->sorting);


            // make query
            $query = $this->_pModel->select($primary_alias . $this->_pModel->primaryKey)
                ->from($this->_pModel->table . ' AS a')
                ->where($primary_alias . 'target_' . $this->_entityTypeModel->primaryKey, '=', $request->{'target_' . $this->_entityTypeModel->primaryKey})
                ->whereNull($primary_alias . 'deleted_at');
            // title
            if (trim($request->input('title')) != '') {
                $query->where($primary_alias . 'title', 'like', '%' . trim($request->input('title')) . '%');
            }
            // get total
            $total_records = $query->count();


            // get paging query
            $query = $this->_pagingQuery($request, $query, $total_records, $primary_alias);

            // apply ordering
            $query->orderBy($primary_alias . $request->order_by, strtoupper($request->sorting));

            // get records
            $raw_records = $query->select($primary_alias . $this->_pModel->primaryKey)->get();

            // remove object mapping
            $raw_records = json_decode(json_encode($raw_records));

            // fetch records
            if (isset($raw_records[0])) {
                $records = array();
                // set actor ID to class
                $this->_pModel->currentActorID = $request->{'actor_' . $this->_entityModel->primaryKey};

                foreach ($raw_records as $raw_record) {
                    $records[] = $this->_pModel->getData($raw_record->{$this->_pModel->primaryKey});
                }
                // replace raw records
                $raw_records = $records;
            }

            // response data
            $data[$this->_pModel->objectIdentifier . "_listing"] = $raw_records;

            // get paging data
            $data["paging"] = $this->_paging($request, $raw_records);
            // assign to output
            $this->_apiData['data'] = $data;

        }

        // call hook
        $this->_apiData = CustomHelper::hookData($this->_pHook, __FUNCTION__, $request, $this->_apiData);

        return $this->__ApiResponse($request, $this->_apiData);

    }


    /**
     * paging query (init paging data)
     *
     * @return Response
     */
    private function _pagingQuery($request, $query, $total_records, $primary_alias = '')
    {
        // set vars
        $primary_alias = trim($primary_alias) == "" ? $primary_alias : $primary_alias . '.';
        $primary_alias = str_replace('..', '.', $primary_alias); // take care of provided param error
        // get paging/params
        $limit = trim(strip_tags($request->input('limit', "")));
        $limit = $limit == "" ? PAGE_LIMIT_API : intval($limit);
        $offset = intval($request->input("offset", 0));
        $offset = $offset < 0 ? 0 : $offset;
        $next_offset = $prev_offset = $offset; // - init


        // datatables request
        if (intval($request->input("dt_request", 0)) == 1) {
            // offfset / limits
            $offset = $offset < $total_records ? $offset : ($total_records - 1);
            $offset = $offset < 0 ? 0 : $offset;
            // next offset
            $next_offset = ($offset + $limit) > $total_records ? ($total_records - $offset) : ($offset + $limit);
            // prev offset
            $prev_offset = $offset > 0 ? ($offset - $limit) : $offset;
            $prev_offset = $prev_offset > 0 ? $prev_offset : 0;
            // apply offset
            $query->skip($offset);
        } else {
            // apply new paging offset
            if ($request->sorting == "asc") {
                $query->where($primary_alias . $this->_pModel->primaryKey, ">", $offset);
            } else {
                if ($offset > 0) {
                    $query->where($primary_alias . $this->_pModel->primaryKey, "<", $offset);
                }
            }
        }

        // apply limit
        $query->take($limit);

        // set pagination response
        $paging = array(
            "limit" => $limit,
            "offset" => $offset,
            "total_records" => $total_records,
            "next_offset" => $next_offset,
            "prev_offset" => $prev_offset
        );

        // assign to output (for internal sharing)
        $this->_apiData['data']["paging"] = $paging;

        return $query;
    }


    /**
     * paging
     *
     * @return Response
     */
    private function _paging($request, $raw_records)
    {
        // init data
        $paging = $this->_apiData['data']["paging"];


        // if not datatables request
        if (intval($request->input("dt_request", 0)) == 0) {
            $r_index = count($raw_records);
            $r_index = $r_index > 0 ? ($r_index - 1) : $r_index;
            if (count($raw_records) > 0) {
                $paging["next_offset"] = $raw_records[$r_index]->{$this->_pModel->primaryKey};
                //$prev_offset = $raw_records[0]->{$this->_pModel->primaryKey};
            }
        }

        // set pagination response
        $paging = array(
            "limit" => $paging["limit"],
            "offset" => $paging["offset"],
            "total_records" => $paging["total_records"],
            "next_offset" => $paging["next_offset"],
            "prev_offset" => intval($request->offset),
            "page_records" => count($raw_records)
        );

        // assign to output (for internal sharing)
        return $paging;
    }


    /**
     * _extraFields
     *
     * @return Response
     */
    private function _extraFields(Request $request)
    {
        // if we are saving first record, then we need to create required fields
        // in target entity type
        $total_records = $this->_pModel
            ->where($this->_eTypeExtMapModel->primaryKey, '=', $this->_extMapData->{$this->_eTypeExtMapModel->primaryKey})
            ->whereNull('deleted_at')->count();

        if ($total_records == 0) {

            // rating
            $this->_eTypeExtMapModel->generateField($request,
                'rating',
                $this->_extMapData->{'target_' . $this->_entityTypeModel->primaryKey});

            // total rating
            $this->_eTypeExtMapModel->generateField($request,
                'total_rating',
                $this->_extMapData->{'target_' . $this->_entityTypeModel->primaryKey},
                0,
                'float');

            // total raters
            $this->_eTypeExtMapModel->generateField($request,
                'total_raters',
                $this->_extMapData->{'target_' . $this->_entityTypeModel->primaryKey},
                0,
                'float');

            // average rating
            $this->_eTypeExtMapModel->generateField($request,
                'average_rating',
                $this->_extMapData->{'target_' . $this->_entityTypeModel->primaryKey},
                0,
                'float');
        }

    }


}