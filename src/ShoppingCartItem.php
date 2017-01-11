<?php
namespace Itb;
use Itb\Category;
use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;
class ShoppingCartItem
{
private $quantity = 0;
private $product;
public function __construct($quantity, Product $product)
{
$this->quantity = $quantity;
$this->product = $product;
}
}
?>