<?php
/**
 * Class Category | core/Category.php
 *
 * @version     v.1.0 (06/01/2016)
 * @Author John O'Grady
 *
 */
namespace Itb;
use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;
/**
 * Category is a foreign key attribute of Product to indicate which category the product is
 */
class Category
{

    /**
     * int value for category which is referenced by productcategoryid in product
     */
    private $productcategoryId;

    /**
     * retrieve producy catetory id
     * @return mixed
     */
    public function getProductcategoryId()
    {
        return $this->productcategoryId;
    }

    /**
     * set product category id
     * @param mixed $productcategoryId
     */
    public function setProductcategoryId($productcategoryId)
    {
        $this->productcategoryId = $productcategoryId;
    }

    /**
     * get description for product category
     * @return mixed
     */
    public function getCategorydescription()
    {
        return $this->categorydescription;
    }

    /**
     * set description
     * @param mixed $categorydescription
     */
    public function setCategorydescription($categorydescription)
    {
        $this->categorydescription = $categorydescription;
    }
    /**
     * String value for category description
     * String
     */
    private $categorydescription;
}