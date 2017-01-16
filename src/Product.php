<?php
/**
 * Class Category | core/Product.php
 *
 * @version     v.1.0 (06/01/2016)
 * @Author John O'Grady
 *
 */


namespace Itb;
use Itb\Category;
use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;
/**
 * Product class represents a product that customers to the site can buy
 */
class Product extends DatabaseTable
{
    /**
     * unique integer identifier for productid
     */
    private $id;

    /**
     * get id for product
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set id for product
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * String description for product
     */
    private $description;

    /**
     * get description for a product
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * set description for a product
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $price
     * price to be charged to customers for a product
     */
    private $price;

    /**
     * get price for product
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * set price for product
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * get product stock level for product
     * @return mixed
     */
    public function getStocklevel()
    {
        return $this->stocklevel;
    }

    /**
     * set product stock level for product
     * @param mixed $stocklevel
     */
    public function setStocklevel($stocklevel)
    {
        $this->stocklevel = $stocklevel;
    }

    /**
     * get category id for product references foreign key category class
     * @return mixed
     */
    public function getProductCategoryId()
    {
        return $this->productCategoryId;
    }

       /**
       * set category id for product references foreign key category class
        * @param mixed $productCategoryId
        */
    public function setProductCategoryId($productCategoryId)
    {
        $this->productCategoryId = $productCategoryId;
    }

    /**
     * string storing image file location
     * @return mixed
     */
    private $image_url;

    /**
     * get image file location
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * set image url for product
     * @param int
     */
    public function setImageUrl($image_url)
    {
        $this->image_url = $image_url;
    }
    /**
     * stock level for product
     * TO DO IMPLEMENT GETTERS AND SETTERS and add to CRUD
     * @param int
     */
    private $stocklevel;

    /**
     * category id for product references category table*
     * @param int
     */
    private $productCategoryId;




}