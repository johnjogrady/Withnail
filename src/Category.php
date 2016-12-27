<?php
/**
 * Created by PhpStorm.
 * User: john.ogrady
 * Date: 21/12/2016
 * Time: 21:45
 */

namespace Itb;
use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

class Category
{
private $productcategoryId;

    /**
     * @return mixed
     */
    public function getProductcategoryId()
    {
        return $this->productcategoryId;
    }

    /**
     * @param mixed $productcategoryId
     */
    public function setProductcategoryId($productcategoryId)
    {
        $this->productcategoryId = $productcategoryId;
    }

    /**
     * @return mixed
     */
    public function getCategorydescription()
    {
        return $this->categorydescription;
    }

    /**
     * @param mixed $categorydescription
     */
    public function setCategorydescription($categorydescription)
    {
        $this->categorydescription = $categorydescription;
    }
private $categorydescription;
}