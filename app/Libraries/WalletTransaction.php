<?php
namespace App\Libraries;
use App\Http\Models\SYSTableFlat;

/**
 * Class WalletTransaction
 * @package App\Libraries
 */
Class WalletTransaction
{
    private $_modelPath = '';
    private $_table = '';
    private $_SYSTableFlatModel = '';

    /**
     * WalletTransaction constructor.
     */
    public function __construct()
    {
        $this->_modelPath = config("system.MODEL_PATH");
        $this->_table = 'wallet_transaction';
        $this->_SYSTableFlatModel = $this->_modelPath . "SYSTableFlat";
        $this->_SYSTableFlatModel = new $this->_SYSTableFlatModel($this->_table);

    }

    /**
     * @param $customer_id
     * @return int
     */
    public function getCurrentBalance($customer_id)
    {
        $current_balance =  $this->_SYSTableFlatModel->columnValueByWhere('customer_id', $customer_id, 'balance','DESC');
        return ($current_balance) ? $current_balance : 0;

    }

    /**
     * @param $customer_id
     * @param int $credit
     * @param int $debit
     * @return int
     */
    public function calculateBalance($customer_id,$credit = 0, $debit = 0)
    {
        //get customer current balance
        $current_balance = $this->getCurrentBalance($customer_id);
        $balance = $this->balanceWalletAmount($current_balance,$credit,$debit);
        return $balance;

    }

    /**
     * balance Wallet Amount
     * @param $current_balance
     * @param int $credit
     * @param int $debit
     * @return mixed
     */
    public function balanceWalletAmount($current_balance,$credit = 0, $debit = 0)
    {
        $balance = $current_balance;

        if($credit > 0)
            $balance  = $current_balance + $credit;

        if($debit > 0)
            $balance  = $current_balance - $debit;

        return $balance;

    }
    
    public function checkWalletAmount($customer_id = false,$amount)
    {
        $wallet = "0.00";
        $paid_amount = "0.00";

        if(isset($customer_id)){
            // User Verification

            $customer_balance =  $this->getCurrentBalance($customer_id);

            $flat_table = new SYSTableFlat('customer');
            $customer_raw = $flat_table->getDataByWhere(' entity_id = '.$customer_id,array('default_wallet_payment','wallet'));

            $default_wallet_payment = isset($customer_raw[0]->default_wallet_payment) ? $customer_raw[0]->default_wallet_payment : 2;

            if($default_wallet_payment == 1){

                $customer_balance = ($customer_balance) ? $customer_balance : 0.00;

                if($customer_balance > $amount){
                    $wallet = $amount;
                }
                else{
                    $wallet =  $customer_balance;
                }
            }

            $paid_amount = roundOfAmount($amount - $wallet,2);

        }
        else{
            $paid_amount = $amount;
        }

        return array(
            'wallet' =>  $wallet,
            'paid_amount' => $paid_amount
        );
    }



}