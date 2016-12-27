<nav>
    <div id="sidenav">
		<ul>
            <li><a href="index.html.twig" <?=setSelectedClass("index")?>>Home</a></li>
            <li><a href="index.html.twig?action=about" <?=setSelectedClass("index.html.twig?action=about")?>>About</a></li>
            <li><a href="index.html.twig?action=cast " <?=setSelectedClass("index.html.twig?action=cast")?>>Cast</a></li>
            <li><a href="index.html.twig?action=clothing" <?=setSelectedClass("index.html.twig?action=clothing")?>>Clothing</a></li>
            <li><a href="index.html.twig?action=merchandise" <?=setSelectedClass("index.html.twig?action=merchandise")?>>Merchandise</a></li>
            <li><a href="index.html.twig?action=posters" <?=setSelectedClass("index.html.twig?action=posters")?>>Posters</a></li>
            <li><a href="index.html.twig?action=products" <?=setSelectedClass("index.html.twig?action=products")?>>Product</a></li>
            <li><a href="index.html.twig?action=script" <?=setSelectedClass("index.html.twig?action=script")?>>Script</a></li>
            <li><a href="index.html.twig?action=sitemap" <?=setSelectedClass("index.html.twig?action=sitemap")?>>SiteMap</a></li>

            <!--next class to be updated once database is in place-->
		  <li><a class="featured" href="index.html.twig?action=products">	Featured product
                  <img class="featured" alt="DVD product" src="../images/Withnail_soundtrack_cover_vinyl.jpg" width="140" height="140"></a>
		  </li>
		</ul>
    </div>
</nav>


<?php
function setSelectedClass($requestUri)
{
	$current_page = basename($_SERVER['REQUEST_URI'], ".php");

	if ($current_page== $requestUri)
		echo 'class="selected"';
}
?>