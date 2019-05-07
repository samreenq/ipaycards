<?php
namespace App\Libraries;

use App\Http\Models\Conf;
use App\Http\Models\EmailTemplate;
use App\Http\Models\Setting;
use App\Http\Models\SYSEntity;
use App\Http\Models\SYSEntityAuth;
use App\Http\Models\FlatTable;

Class EmailLib {

    /**
     * @param $order
     * @param $email_content
     */
    public function sendOrderEmail($order,$email_content)
    {
        $conf_model = new Conf();
        $setting_model = new Setting();
        $email_template_model = new EmailTemplate();

        // configuration
        $conf = $conf_model->getBy('key', 'site');
        $conf = json_decode($conf->value);

        if(isset($order->customer_id->detail->auth)){
            $data = $order->customer_id->detail->auth;
        }
        else{
            $sys_entity = new SYSEntity();
            $customer = $sys_entity->getData($order->customer_id->id,array('mobile_json'=>1));
            $data = $customer->auth;
            // echo "<pre>"; print_r($customer); exit;
        }


        $data->created_at = date('Y-m-d H:i:s');

        // send email to new admin
        # admin email
        $setting = $setting_model->getBy('key', 'admin_email');
        $data->from = $setting->value;
        # admin email name
        $setting = $setting_model->getBy('key', 'admin_email_name');
        $data->from_name = $setting->value;

        # load email template
        $query = $email_template_model
            ->where("key", "=", 'new_order')
            ->whereNull("deleted_at");

        $query->whereNull("plugin_identifier");

        $email_template = $query->first();

        $wildcard['key'] = explode(',', $email_template->wildcards);
        $wildcard['replace'] = array(
            $conf->site_name, // APP_NAME
            url('/'), // APP_LINK
            $data->name, // ENTITY_NAME
            $order->order_number, // order number
            $email_content, // order items
        );

        // echo $email_content;
        # body
         $body = str_replace($wildcard['key'], $wildcard['replace'], $email_template->body);

        # subject
        $data->subject = str_replace($wildcard['key'], $wildcard['replace'], $email_template->subject);
        # send email
        $conf_model->sendMail(
            array($data->email, $data->name),
            $body,
            (array)$data
        );
    }

    /**
     * @param $order
     * @param $email_content
     */
    public function sendGiftEmail($order,$email_content)
    {
        $conf_model = new Conf();
        $setting_model = new Setting();
        $email_template_model = new EmailTemplate();

        // configuration
        $conf = $conf_model->getBy('key', 'site');
        $conf = json_decode($conf->value);


        $sys_entity_auth = new SYSEntityAuth();
        $data = $sys_entity_auth->getByEmail($order->recipient_email,11);

        if(!isset($data->entity_auth_id)){
            $data = new \StdClass();
            $data->name = 'User';
            $data->email = $order->recipient_email;
        }


        $data->created_at = date('Y-m-d H:i:s');

        // send email to new admin
        # admin email
        $setting = $setting_model->getBy('key', 'admin_email');
        $data->from = $setting->value;
        # admin email name
        $setting = $setting_model->getBy('key', 'admin_email_name');
        $data->from_name = $setting->value;

        # load email template
        $query = $email_template_model
            ->where("key", "=", 'new_order')
            ->whereNull("deleted_at");

        $query->whereNull("plugin_identifier");

        $email_template = $query->first();

        $wildcard['key'] = explode(',', $email_template->wildcards);
        $wildcard['replace'] = array(
            $conf->site_name, // APP_NAME
            url('/'), // APP_LINK
            $data->name, // ENTITY_NAME
            $order->order_number, // order number
            $email_content, // order items
        );

        // echo $email_content;
        # body
         $body = str_replace($wildcard['key'], $wildcard['replace'], $email_template->body);

        # subject
        $data->subject = str_replace($wildcard['key'], $wildcard['replace'], $email_template->subject);
        # send email

        $conf_model->sendMail(
            array($data->email, $data->name),
            $body,
            (array)$data
        );
    }
}