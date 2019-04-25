<?php

/**
 * Description: this library is to get truck information
 * Author: Samreen <samreen.quyyum@cubixlabs.com>
 * Date: 25-June-2018
 * Time: 04:00 PM
 * Copyright: CubixLabs
 */
namespace App\Libraries;
use App\Libraries\System\Entity;

Class InventoryLib
{
    /**
     * @param $inventory_id
     */
    public function updateStatusSold($inventory_id)
    {
        $entity_lib = new Entity();
        //Update Inventory Status
        $params = [
            'entity_type_id' => 'inventory',
            'entity_id' => $inventory_id,
            'availability' => 'sold',
        ];

        $entity_lib->apiUpdate($params);
    }

}