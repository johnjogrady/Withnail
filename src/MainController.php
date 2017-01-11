<?php
namespace Itb;

class MainController
{
    public function indexAction($twig)
    {
        $template = 'index';
        $argsArray = [];
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        $shoppingCart = $this->getShoppingCartAction();
        $products = Product::getAllProducts();
        $argsArray = [
            'shoppingcart' => $shoppingCart,
            'isloggedin'=>$isLoggedIn,
            'username'=>$username
        ];

        return $twig->render($template . '.html.twig', $argsArray);
    }



    public function aboutAction($twig)
    {
        $template = 'about';
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $argsArray = [ 'isloggedin'=>$isLoggedIn,
            'username'=>$username];


        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function loginSuccessAction($twig)
    {
        $template = 'loginsuccess';
        $argsArray = [];
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $argsArray = [
            'isloggedin'=>$isLoggedIn,
            'username'=>$username
        ];

        return $this->indexAction($twig);
       }
    function listAction($twig)
    {
        $pageTitle = 'List';
        $products=Product::getAllProducts();// adapted version of getAll CRUD4FREE Method [used to pull in some joined table data]
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $productsRepository = new ProductsRepository();
        $categories = $productsRepository->getCategories();
        $template = 'list';
        $argsArray = [
            'products' => $products,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn
        ];

        return $twig->render($template . '.html.twig', $argsArray);    }

    function clothingAction($twig)
    {
        $pageTitle = 'Clothing';
        $productcategoryid= 2;
        $products=Product::getFilteredProducts($productcategoryid);// adapted version of getAll CRUD4FREE Method [used to pull in some joined table data]
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $productsRepository = new ProductsRepository();
        $categories = $productsRepository->getCategories();
        $template = 'clothing';
        $argsArray = [
            'products' => $products,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn
        ];

        return $twig->render($template . '.html.twig', $argsArray);    }

    function musicAction($twig)
    {
        $pageTitle = 'music';
        $productcategoryid= 1;
        $products=Product::getFilteredProducts($productcategoryid);// adapted version of getAll CRUD4FREE Method [used to pull in some joined table data]
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $productsRepository = new ProductsRepository();
        $categories = $productsRepository->getCategories();
        $template = 'music';
        $argsArray = [
            'products' => $products,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn
        ];

        return $twig->render($template . '.html.twig', $argsArray);    }


    function detailAction($twig) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
           $productsRepository = new ProductsRepository();
        $product = Product::getOneProductById($id);
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

           if(null == $product){
            $message = 'sorry, no product with id = ' . $id . ' could be retrieved from the database';
            $template = 'message';
            $argsArray = [  'message' => $message,'username'=>$username,'isLoggedin'=>$isLoggedIn];
            return $twig->render($template.'.html.twig', $argsArray);
        } else {
            // output the detail of product in HTML table
            $template = 'detail';
            $argsArray = [
                'products' => $product,'username'=>$username,'isloggedin'=>$isLoggedIn
            ];
                return $twig->render($template.'.html.twig', $argsArray);
        }
    }

    function showNewProductFormAction($twig)
    {

            $pageTitle = 'Add New Product';
            $productsRepository = new ProductsRepository();

            $categories = $productsRepository->getCategories();
            $isLoggedIn = $this->isLoggedInFromSession();
            $username = $this->usernameFromSession();

            $template = 'list';
            $argsArray = [
                'categories' => $categories,'username'=>$username,'isloggedin'=>$isLoggedIn
            ];
        return $twig->render('new_product_form..html.twig', $argsArray);
    }

    function createProductAction($twig)
    {
        $new_product = new Product();
        $new_product->setDescription(filter_input(INPUT_POST, 'description'));
        $new_product->setPrice(filter_input(INPUT_POST, 'price'));
        $new_product->setStocklevel(filter_input(INPUT_POST, 'stock'));
        $new_product->setProductCategoryId(filter_input(INPUT_POST, 'ProductCategoryId'));

        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        $new_product->getId();
        $success = Product::insert($new_product);
        if($success){
            $id = $new_product->getId(); // get ID of new record
            $message = "SUCCESS - new product with ID = $id created";
        } else {
            $message = 'sorry, there was a problem creating new product';
        }
        $template = 'message';
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    function createCustomerAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        $productsRepository = new ProductsRepository();
        $connection = $productsRepository->getConnection();
        $new_user = new User();
        $new_user->setFirstName(filter_input(INPUT_POST, 'firstName')) ;
        $new_user->setLastName(filter_input(INPUT_POST, 'lastName')) ;
        $new_user->setCustomerAddress1(filter_input(INPUT_POST, 'addressLine1')) ;
        $new_user->setCustomerAddress2(filter_input(INPUT_POST, 'addressLine2')) ;
        $new_user->setCustomerAddress3(filter_input(INPUT_POST, 'addressLine3')) ;
        $new_user->setCounty(filter_input(INPUT_POST, 'county')) ;
        $new_user->setEmail(filter_input(INPUT_POST, 'email')) ;
        $new_user->setUsername(filter_input(INPUT_POST, 'email')) ;
        $new_user->setMobileNumber(filter_input(INPUT_POST, 'mobileNumber')) ;
        $new_user->setPassword(filter_input(INPUT_POST, 'password')) ;
        $new_user->setRole(User::ROLE_USER);
        $emailFound=$this->checkEmailInDB($new_user->getUsername());
        if (!$emailFound) {
            $success = User::insert($new_user);
            if ($success) {
                $id = $connection->lastInsertId(); // get ID of new record
                $message = "SUCCESS - new customer created account for you. Please login";
            } else {
                $message = 'Sorry, there was a problem creating adding this new account, please check your connection';
                $template = 'message';
                $argsArray = ['message' => $message,'username'=>$username];
                return $twig->render($template . '.html.twig', $argsArray);
            }
        }
        else
            {
                $message = 'Sorry, there was a problem creating adding this new account, please check that you have not already registered with this email';
            }
        $template = 'message';
        $argsArray = [  'message' => $message];
        return $twig->render($template.'.html.twig', $argsArray);

    }


    function checkEmailInDB($email)
    {
        $productsRepository = new ProductsRepository();
        $connection = $productsRepository->getConnection();
        $sql = "select count(*) from users WHERE `email` = '$email'";
        $result = $connection->prepare($sql);
        $result->execute();
        $numrows = $result->fetchColumn();
        if ($numrows>0)
        {
            return true;
        }
        else {return false;}
    }

    function deleteAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();


        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $success = Product::delete($id);


        if($success){
            $message = 'SUCCESS - product with id = ' . $id . ' was deleted';
        } else {
            $message = 'sorry, product id = ' . $id . ' could not be deleted';
        }
        $template = 'message';
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    function showUpdateProductFormAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        // ID from GET parameters
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        // get array, ready for view to use to populate form
        $product = Product::getOneById($id);
        $productsRepository = new ProductsRepository();
        $categories = $productsRepository->getCategories();

        if (null == $product) {
            $message = 'sorry, no product with id = ' . $id . ' could be retrieved from the database';
            $template = 'message';
            $argsArray = ['message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn];

            return $twig->render($template . '.html.twig', $argsArray);
        } else {
            // output the detail of product in HTML table
            $template = 'update';
            $argsArray = [
                'product' => $product,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn
            ];


            return $twig->render($template . '.html.twig', $argsArray);
        }
    }


    public function updateProductAction($twig)
    {
        $productsRepository = new ProductsRepository();
        $connection = $productsRepository->getConnection();
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $product=new Product();

        $product->setId(filter_input(INPUT_POST, 'Id', FILTER_SANITIZE_NUMBER_INT));
        $product->setPrice(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT));
        $product->setDescription(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));
        $product->setImageUrl(filter_input(INPUT_POST, 'image_url', FILTER_SANITIZE_STRING));
        $product->setStocklevel(filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT));
        $product->setProductCategoryId(filter_input(INPUT_POST, 'ProductCategoryId', FILTER_SANITIZE_NUMBER_INT));
        $success = Product::update($product);
        if($success){
            $message = "SUCCESS - new product updated";
        } else {
            $message = 'sorry, there was a problem updated the product';
        }
        $template = 'message';
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function loginAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'login';
        $argsArray = [];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    public function registerAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'register';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function logoutAction($twig)
    {
        $isLoggedIn = false;
        $username = null;
        $this->killSession();
        $template = 'message';
        $message = 'You are now logged out';
        $template = 'message';
        $argsArray = [  'message' => $message];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function sitemapAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'sitemap';
        $argsArray = ['username'=>$username,'isloggedin'=>$isLoggedIn];
        return $twig->render($template . '.html.twig', $argsArray);
    }




    public function addToCartAction($twig)
    {
        // get the ID of product to add to cart
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        // get the cart array
        $shoppingCart = $this->getShoppingCartAction();

        // default is a new cart tiem
        $cartItem = new CartItem($id);

        // if quantity found in cart array, then use this
        if(isset($shoppingCart[$id])){
            $cartItem = $shoppingCart[$id];
            $oldQuantity = $cartItem->getQuantity();

            // store old quantity + 1 as new quantity into cart array
            $newQuantity = $oldQuantity + 1;
            $cartItem->setQuantity($newQuantity);
        }

        // store item in cart array
        $shoppingCart[$id] = $cartItem;

        // store new  array into SESSION
        $_SESSION['shoppingCart'] = $shoppingCart;
        $argsArray = [
            'shoppingcart' => $shoppingCart,
            'isloggedin'=>$isLoggedIn,
            'username'=>$username
        ];
        return $this->indexAction($twig, $argsArray);

    }


    public function buyOneLessAction($twig)
    {
        // get the ID of product to add to cart
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        // get the cart array
        $shoppingCart = $this->getShoppingCartAction();

        // default is a new cart tiem
        $cartItem = new CartItem($id);

        // if quantity found in cart array, then use this
        if(isset($shoppingCart[$id])){
            $cartItem = $shoppingCart[$id];
            $oldQuantity = $cartItem->getQuantity();

            // store old quantity + 1 as new quantity into cart array
            $newQuantity = $oldQuantity - 1;
            $cartItem->setQuantity($newQuantity);
        }

        // store item in cart array
        $shoppingCart[$id] = $cartItem;

        // store new  array into SESSION
        $_SESSION['shoppingCart'] = $shoppingCart;
        $argsArray = [
            'shoppingcart' => $shoppingCart,
            'isloggedin'=>$isLoggedIn,
            'username'=>$username
        ];
        return $this->indexAction($twig, $argsArray);

    }

    public function removeFromCartAction($twig)
    {
        // get the ID of product to add to cart
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        // get the cart array
        $shoppingCart = $this->getShoppingCartAction();

        // remove entry for this ID
        unset($shoppingCart[$id]);

        // store new  array into SESSION
        $_SESSION['shoppingCart'] = $shoppingCart;
        $argsArray = [
            'shoppingcart' => $shoppingCart,
            'isloggedin'=>$isLoggedIn,
            'username'=>$username
        ];
        return $this->indexAction($twig, $argsArray);
    }

    function getShoppingCartAction()
    {
        if (isset($_SESSION['shoppingCart'])){
            return $_SESSION['shoppingCart'];
        } else {
            return [];
        }
    }

    function forgetSessionAction()
    {
        killSessionAction();

        // redirect to display text
        indexAction();
    }

    /**
     * advice on how to kill session from PHP.net
     * URL: http://php.net/manual/en/function.session-destroy.php
     */
    function killSessionAction()
    {
        // (1) Unset all of the session variables.
        $_SESSION = [];

        // (2) If it is desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get('session.use_cookies')){
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // (3) destroy the session.
        session_destroy();
    }



    public function processLoginAction($twig)
    {
        // default is bad login
        $isLoggedIn = false;

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);


        // search for user with username in repository
        $isLoggedIn = UserRepository::canFindMatchingUsernameAndPassword($username, $password);

        $hashedCorrectPassword = password_hash('admin', PASSWORD_DEFAULT);
        if (('admin' == $username) && password_verify($password, $hashedCorrectPassword)) {
            $isLoggedIn = true;

        }

        $template = 'loginSuccess';

        if ($isLoggedIn) {
            // success - found a matching username and password, store in session
            $_SESSION['user'] = $username;
            $argsArray = [
                'isloggedin'=>$isLoggedIn,
                'username'=>$username];

            return $twig->render($template . '.html.twig', $argsArray);

        } else {
            $message = 'bad username or password, please try again';
            $template = 'message';
            $argsArray = ['message' => $message];
            return $twig->render($template . '.html.twig', $argsArray);

        }
    }

        public function isLoggedInFromSession() {
            $isLoggedIn = false;
            // user is logged in if there is a 'user' entry in the SESSION superglobal
            if(isset($_SESSION['user'])){
                $isLoggedIn = true;

            }
            return $isLoggedIn;
        }
        public function usernameFromSession() {
            $username = '';
	// extract username from SESSION superglobal
	if (isset($_SESSION['user'])) {
		$username = $_SESSION['user'];
	}
	return $username;
}




}
