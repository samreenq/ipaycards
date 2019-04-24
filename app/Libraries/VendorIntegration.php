<?php

namespace App\Libraries;
use App\Libraries\Services\Cards;
use App\Libraries\System\Entity;
use Validator;

Class VendorIntegration
{

    public function integrateProduct($request)
    {
        $return = [];
        try {

            $rules = array(
                'vendor_id' => 'required',
                'category_id' => 'required_if:vendor_id,mint_route',
                'brand_id' => 'required',
                'product_id' => 'required',
            );

            $validator = Validator::make((array)$request, $rules);

            if ($validator->fails()) {
                $return['error'] = 1;
                $return['message'] = $validator->errors()->first();

            } else {

                $request = is_array($request) ? (object) $request : $request;
                //Get Denomination
               $denomination = $this->getDenomination($request);
                //Update Product
                if(count($denomination) > 0)
                   return $this->updateProduct($request,$denomination);

                else
                    $return['error'] = 1;
                    $return['message'] = 'No Denomination Found';

            }

        } catch (\Exception $e) {
            //  echo $e->getTraceAsString(); exit;
            $return['error'] = 1;
            $return['message'] = $e->getMessage();
            $return['debug'] = 'File : ' . $e->getFile() . ' : Line ' . $e->getLine();
        }

        // fix for error flags
        $return['error'] = 0;
        return json_decode(json_encode($return));
    }

    /**
     * @param $request
     * @return array
     * @throws \Exception
     */
    public function getDenomination($request)
    {
        //Get product information
        $pLib = new Cards(request('vendor', $request->vendor_id));
        $data = $pLib->denominations(['brand_id'=> $request->brand_id]);

       // echo "<pre>"; print_r($data); exit;
        if(isset($data['denominations'])){
            foreach($data['denominations'] as $denomination){

                if($denomination['denomination_id'] == $request->product_id){
                    return $denomination;
                }
            }
        }
        return [];
    }

    /**
     * @param $request
     * @param $denomination
     * @return mixed
     */
    public function updateProduct($request,$denomination)
    {
        $vendor = str_replace('_','',$request->vendor_id);

        if(isset($request->category_id)){
            $denomination['category_id'] = $request->category_id;
        }

        $denomination['brand_id'] = $request->brand_id;
        $denomination = json_encode($denomination);
        $params = array(
            'entity_type_id' => 'product',
            'entity_id' => $request->entity_id,
            $vendor."_product_id" => $request->product_id,
            $vendor."_product_info" => $denomination,
        );

        $entity_lib = new Entity();
       // echo "<pre>"; print_r($params);
        $response = $entity_lib->apiUpdate($params);
      //  echo "<pre>"; print_r($response); exit;
       return json_decode(json_encode($response));
    }


}