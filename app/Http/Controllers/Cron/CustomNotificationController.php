<?php

/**
 * This is written to send notification
 * Class CustomNotificationController
 * Date: 13-07-2018
 * Author: Cubix
 * Copyright: cubix
 */

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Http\Models\FlatTable;
use App\Libraries\CouponLib;
use App\Libraries\EntityNotification;
use App\Libraries\System\Entity;
use Illuminate\Http\Request;
use App\Libraries\CustomHelper;
use Validator;
use Illuminate\Http\Exception;

Class CustomNotificationController extends Controller {

    public function __construct()
    {
        ini_set('max_execution_time', 0);
    }

    /**
     * this function is used for send custom notification via cron job
     */
    public function sendNotification()
    {
        $params = array(
            'entity_type_id' => '44',
            'order_by'       => 'created_at',
            'sorting'        => 'DESC'
        );
        $entity_lib = new Entity();
        $getData = $entity_lib->apiList($params);
        if(count($getData['data']['entity_listing']) && !empty($getData['data']['entity_listing'])){
            foreach($getData['data']['entity_listing'] as $results){
                $identifier          = $results->attributes->notify_to->value;
                $notificationSubject = $results->attributes->subject;
                $notificationMessage = $results->attributes->message;
                $notificationStatus  = $results->attributes->notification_status;
                if($notificationStatus != 1){
                    if($identifier == 'customer' || $identifier == 'driver'){
                        self::sendNotificationToTargetUsers($results,$notificationSubject,$notificationMessage,$identifier);
                    }else{
                        self::sendNotificationToAllTargetUsers($results,$notificationSubject,$notificationMessage,$identifier);
                    }
                    //update notification flag
                    $entity_lib = new Entity();
                    $post_arr['entity_type_id']      = 44;
                    $post_arr['entity_id']           = $results->entity_id;
                    $post_arr['notification_status'] = '1';
                    $data = $entity_lib->doUpdate($post_arr);
                }else{
                    echo 'No record found'; exit;
                }
            }
       }else{
            echo 'No record found'; exit;
        }
    }
    
    public function sendNotificationToTargetUsers($results,$notificationSubject,$notificationMessage,$identifier)
    {
        $targetUsers = $results->attributes->target_user_entity_id;
        if(count($targetUsers)){
            foreach($targetUsers as $entity){
                $entityNotification =  new EntityNotification();
                $entityNotification->sendNotification($entity->detail,$notificationSubject,$notificationMessage,$identifier);
            }
        }
    }

    public function sendNotificationToAllTargetUsers($results,$notificationSubject,$notificationMessage,$identifier)
    {
        $identifier = $results->attributes->notify_to->value;
        if($identifier == 'all_customer'){
            $entity_type = 'customer';
        }else{
            $entity_type = 'driver';
        }
        self::getEntityRecordInChunk($entity_type,$notificationSubject,$notificationMessage,$identifier);
    }

    public function getEntityRecordInChunk($identifier,$notificationSubject,$notificationMessage,$offset = 0)
    {
        $params = array(
            'entity_type_id' => $identifier,
            'order_by'       => 'created_at',
            'sorting'        => 'DESC',
            'offset'         => $offset
        );
        $entity_lib = new Entity();
        $getData = $entity_lib->apiList($params);
        self::sendNotificationInChunk($identifier,$getData,$notificationSubject,$notificationMessage);
    }

    public function sendNotificationInChunk($identifier,$getData,$notificationSubject,$notificationMessage)
    {
        if(count($getData['data']['entity_listing']) && !empty($getData['data']['entity_listing']))
        {
            foreach($getData['data']['entity_listing'] as $entity)
            {
                $entityNotification =  new EntityNotification();
                $entityNotification->sendNotification($entity,$notificationSubject,$notificationMessage,$identifier);
            }
            $offset  = $getData['data']['page']['next_offset'];
            self::getEntityRecordInChunk($identifier,$notificationSubject,$notificationMessage,$offset);
        }
    }

    /**
     * This function is used for send remainder notification
     */
    public function sendRemainderNotification()
    {
      //  self::sendRemainderNotificationToDriver(3332,6394,'15:00:00');
        echo 'current time<br>';
       echo $current_time = date('H:i');
       echo '<br>';
        $currentTime = strtotime($current_time);

        $getOrders = FlatTable::getRemainderNotificationData();

        if(count($getOrders)){
            foreach($getOrders as $orders){
                $driver_id = $orders->driver_id;
                $order_id  = $orders->order_id;

                echo 'Pickup time<br>';
              echo $pickup_time = date('H:i',strtotime($orders->pickup_time));
                echo '<br>';
                echo "<pre>"; print_r($orders);

                //notification send before 2 hours
                $remainderTime = strtotime('-2 hour',strtotime($pickup_time));
                if($currentTime == $remainderTime){
                    self::sendRemainderNotificationToDriver($driver_id,$order_id,$pickup_time);
                }
                //notification send before an hour
                $remainderTime2 = strtotime('-1 hour',strtotime($pickup_time));
                if($currentTime == $remainderTime2){
                    self::sendRemainderNotificationToDriver($driver_id,$order_id,$pickup_time);
                }
                //notification send before half an hour
                $remainderTime3 = strtotime('-30 minutes',strtotime($pickup_time));
                if($currentTime == $remainderTime3){
                    self::sendRemainderNotificationToDriver($driver_id,$order_id,$pickup_time);
                }

            }
        }
    }

    public function sendRemainderNotificationToDriver($driver_id,$order_id,$pickupTime)
    {
        $entity_lib = new Entity();
        //get order
        $params = array(
            'entity_type_id' => 'order',
            'order_by'       => 'created_at',
            'sorting'        => 'ASC',
            'entity_id'      => $order_id
        );
        $getData  = $entity_lib->apiList($params);
        $getOrder = $getData['data']['entity_listing'][0];
        //get Driver
        $params = array(
            'entity_type_id' => 'driver',
            'order_by'       => 'created_at',
            'sorting'        => 'ASC',
            'entity_id'      =>  $driver_id
        );
        $getData = $entity_lib->apiList($params);
        $entity = $getData['data']['entity_listing'][0];

        $entityNotification =  new EntityNotification();
        $entityNotification->sendReminderNotification($entity,$getOrder,$pickupTime);
    }
}