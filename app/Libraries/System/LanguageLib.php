<?php
/**
 * This file is created to add functions related to Language module
 */
namespace App\Libraries\System;

use Maatwebsite\Excel\Facades\Excel;
use App\Http\Models\PLAttachment;

Class LanguageLib {

    /**
     * @param $request
     * @return mixed
     */
    public function validateFile($request,$file_name = 'file')
    {
        $request = is_array($request) ? (object)$request : $request;

        $return['error'] = 0;
        $return['message'] = 'success';
        $pl_attachment_model = new PLAttachment();
        $attachment = $pl_attachment_model->get($request->{$file_name});

        if ($attachment) {
            $data = Excel::load($attachment->file)->toArray();

            if (count($data) == 0) {
                $return['error'] = 1;
                $return['message'] = trans('No Data Found');
            } else {

                $lang_key = [];
                foreach($data[0] as $key => $value){
                    $lang_key[] = $key;
                }

                $valid_file = true;

                if(!in_array(trim('code'),$lang_key,true)){
                    $valid_file = false;
                }

                if(!in_array(trim($request->identifier),$lang_key,true)){
                    $valid_file = false;
                }

                if(!$valid_file){
                    $return['error'] = 1;
                    $return['message'] = trans('Missing column of translation');
                }

                $return['data'] = $data;
                $return['attachment'] = $attachment;

            }
        }else{
            $return['error'] = 1;
            $return['message'] = trans('Please upload '.$file_name.', attachment not found');

        }
        return $return;
    }

    /**
     * Create Language File
     * @param $data
     * @param $identifier
     */
    public function createFile($data,$identifier)
    {
        if(count($data) >0){

            foreach($data as $data_val){

                $data_val = (object)$data_val;
                $resource_arr[trim($data_val->code)] =  trim($data_val->{$identifier});
            }

            $dir_path = config('constants.LANGUAGE_PATH').$identifier;
            if (!is_dir($dir_path)) {
                mkdir(@$dir_path, 0777, TRUE);
            }

            // write resource file (configuration)
            $fo = fopen($dir_path.'/'.config('constants.TRANSLATION_FILE_NAME'), 'w+');
            // prepare PHP content
            $content = "<?php \n"
                . 'return ' . var_export($resource_arr, TRUE)
                . ";";
            @fwrite($fo, $content);
            @fclose($fo);

        }
    }

    public function createValidationFile($data,$identifier)
    {
        if(count($data) >0){

            foreach($data as $data_val){

                $data_val = (object)$data_val;

                $code = strpos($data_val->code, '.');

                if($code !== false){

                    $code_arr = explode('.',$data_val->code);

                    if(!isset($resource_arr[$code_arr[0]])){
                        $resource_arr[$code_arr[0]] = [];
                    }
                    $resource_arr[trim($code_arr[0])][trim($code_arr[1])] = trim($data_val->{$identifier});

                }else{
                    $resource_arr[trim($data_val->code)] =  trim($data_val->{$identifier});
                }

            }

            $resource_arr['custom'] = [
                'attribute-name' => [
                    'rule-name' => 'custom-message',
                ],
            ];

            $resource_arr['attributes'] = [];


           // echo "<pre>"; print_r($resource_arr); exit;
            $dir_path = config('constants.LANGUAGE_PATH').$identifier;
            if (!is_dir($dir_path)) {
                mkdir(@$dir_path, 0777, TRUE);
            }

            // write resource file (configuration)
            $fo = fopen($dir_path.'/'.config('constants.TRANSLATION_VALIDATION_FILE'), 'w+');
            // prepare PHP content
            $content = "<?php \n"
                . 'return ' . var_export($resource_arr, TRUE)
                . ";";
            @fwrite($fo, $content);
            @fclose($fo);

        }
    }

}