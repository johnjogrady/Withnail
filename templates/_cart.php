
<hr>
<h3>shopping cart</h3>
<table>
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>sub-total</th>
        <th>(remove)</th>
    </tr>
    <?php
    //-----------------------------
    $total = 0;

    foreach($shoppingCart as $id=>$quantity):

        $product = get_one_product($id);
        $price = $product['price'];
        $subTotal = $price * $quantity;
        $total += $subTotal;
//-----------------------------
        ?>
        <tr>
            <td><?= $product['description'] ?></td>
            <td>&euro; <?= $price ?></td>
            <td><?= $quantity ?></td>
            <td><?= $subTotal ?></td>
            <td><a href="/index.php?action=removeFromCart&id=<?= $product['id'] ?>">(remove from cart)</a></td>

        </tr>

        <?php
//-----------------------------
    endforeach;
    //-----------------------------
    ?>

    <tr>
        <td colspan="3">Total</td>
        <td>&euro; <?= $total ?></td>
    </tr>

</table>

<a href="/index.php?action=emptyCart">EMPTY CART</a>

<pre>
    <?= var_dump($_SESSION) ?>
</pre>
