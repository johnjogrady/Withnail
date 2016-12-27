<?php



namespace Itb;
use Itb\Category;
use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;
class Product extends DatabaseTable
{
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    private $description;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    private $price;

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getStocklevel()
    {
        return $this->stocklevel;
    }

    /**
     * @param mixed $stocklevel
     */
    public function setStocklevel($stocklevel)
    {
        $this->stocklevel = $stocklevel;
    }

    /**
     * @return mixed
     */
    public function getProductCategoryId()
    {
        return $this->productCategoryId;
    }

       /**
     * @param mixed $productCategoryId
     */
    public function setProductCategoryId($productCategoryId)
    {
        $this->productCategoryId = $productCategoryId;
    }
    private $image_url;

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * @param mixed $image_url
     */
    public function setImageUrl($image_url)
    {
        $this->image_url = $image_url;
    }
    private $stocklevel;
    private $productCategoryId;




}