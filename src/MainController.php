<?php
namespace Itb;

class MainController
{
    public function indexAction(\Twig_Environment $twig)
    {
        $template = 'index';
        $argsArray = [];
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $shoppingCart = $this->getShoppingCartAction();
        $products = Product::getAllProducts();
        $argsArray = [
            'shoppingcart' => $shoppingCart,
            'isloggedin'=>$isLoggedIn,
            'username'=>$username,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);
    }



    public function aboutAction($twig)
    {
        $template = 'about';
        $cssStyleRule = $this->buildStyleRule();
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $argsArray = [ 'isloggedin'=>$isLoggedIn,
            'username'=>$username,
            'cssStyleRule' => $cssStyleRule];


        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function loginSuccessAction($twig)
    {
        $template = 'loginsuccess';
        $argsArray = [];
        $isLoggedIn = $this->isLoggedInFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $username = $this->usernameFromSession();
        $argsArray = [
            'isloggedin'=>$isLoggedIn,
            'username'=>$username,
            'cssStyleRule' => $cssStyleRule
        ];

        return $this->indexAction($twig);
       }
    function listAction($twig)
    {
        $pageTitle = 'List';
        $products=Product::getAllProducts();// adapted version of getAll CRUD4FREE Method [used to pull in some joined table data]
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $productsRepository = new ProductsRepository();
        $categories = $productsRepository->getCategories();
        $template = 'list';
        $argsArray = [
            'products' => $products,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);    }

    function clothingAction($twig)
    {
        $pageTitle = 'Clothing';
        $productcategoryid= 2;
        $products=Product::getFilteredProducts($productcategoryid);// adapted version of getAll CRUD4FREE Method [used to pull in some joined table data]
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $productsRepository = new ProductsRepository();
        $categories = $productsRepository->getCategories();
        $template = 'clothing';
        $argsArray = [
            'products' => $products,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);    }

    function musicAction($twig)
    {
        $pageTitle = 'music';
        $productcategoryid= 1;
        $products=Product::getFilteredProducts($productcategoryid);// adapted version of getAll CRUD4FREE Method [used to pull in some joined table data]
        $isLoggedIn = $this->isLoggedInFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $username = $this->usernameFromSession();
        $productsRepository = new ProductsRepository();
        $categories = $productsRepository->getCategories();
        $template = 'music';
        $argsArray = [
            'products' => $products,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);    }


    function detailAction($twig) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
           $productsRepository = new ProductsRepository();
        $product = Product::getOneProductById($id);
        $cssStyleRule = $this->buildStyleRule();
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

           if(null == $product){
            $message = 'sorry, no product with id = ' . $id . ' could be retrieved from the database';
            $template = 'message';
            $argsArray = [  'message' => $message,'username'=>$username,'isLoggedin'=>$isLoggedIn,
               'cssStyleRule' => $cssStyleRule];
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
            $cssStyleRule = $this->buildStyleRule();
            $categories = $productsRepository->getCategories();
            $isLoggedIn = $this->isLoggedInFromSession();
            $username = $this->usernameFromSession();

            $template = 'list';
            $argsArray = [
                'categories' => $categories,'username'=>$username,'isloggedin'=>$isLoggedIn,
                'cssStyleRule' => $cssStyleRule];
        return $twig->render('new_product_form..html.twig', $argsArray);
    }

    function createProductAction($twig)
    {
        $new_product = new Product();
        $new_product->setDescription(filter_input(INPUT_POST, 'description'));
        $new_product->setPrice(filter_input(INPUT_POST, 'price'));
        $new_product->setStocklevel(filter_input(INPUT_POST, 'stock'));
        $new_product->setProductCategoryId(filter_input(INPUT_POST, 'ProductCategoryId'));
        $cssStyleRule = $this->buildStyleRule();
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
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    function createCustomerAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
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
                $message = 'Sorry, there was a problem creating this new account, please check your connection';
                $template = 'message';
                $argsArray = ['message' => $message,'username'=>$username,
                    'cssStyleRule' => $cssStyleRule];
                return $twig->render($template . '.html.twig', $argsArray);
            }
        }
        else
            {
                $message = 'Sorry, there was a problem creating this new account, please check that you have not already registered with this email';
            }
        $template = 'message';
        $argsArray = [  'message' => $message];
        return $twig->render($template.'.html.twig', $argsArray);

    }
    function showEditUserAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $userId = User::getIdforUsername($username);
        $user = User::getOneById($userId->id);
        $cssStyleRule = $this->buildStyleRule();
        $productsRepository = new ProductsRepository();
        $connection = $productsRepository->getConnection();

        $template = 'edit_user';
        $argsArray = [
            'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule,'user'=>$user];
         return $twig->render($template.'.html.twig', $argsArray);

    }

    function processEditUserAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $productsRepository = new ProductsRepository();
        $connection = $productsRepository->getConnection();
        $user=new User();
        $user->setId(filter_input(INPUT_POST, 'Id')) ;
        $user->setUsername(filter_input(INPUT_POST, 'email')) ;
        $username=$user->getUsername();
        $user->setRole(1) ;
        $user->setFirstName(filter_input(INPUT_POST, 'firstName')) ;
        $user->setLastName(filter_input(INPUT_POST, 'lastName')) ;
        $user->setCustomerAddress1(filter_input(INPUT_POST, 'addressLine1')) ;
        $user->setCustomerAddress2(filter_input(INPUT_POST, 'addressLine2')) ;
        $user->setCustomerAddress3(filter_input(INPUT_POST, 'addressLine3')) ;
        $user->setCounty(filter_input(INPUT_POST, 'county')) ;
        $user->setEmail(filter_input(INPUT_POST, 'email')) ;
        $user->setMobileNumber(filter_input(INPUT_POST, 'mobileNumber')) ;



         $success = User::update($user);
            if ($success) {
                $id = $connection->lastInsertId(); // get ID of new record
                $message = "SUCCESS - your account information has been updated";
            } else {
                $message = 'Sorry, there was a problem updating your information';
                $template = 'message';
                $argsArray = ['message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
                    'cssStyleRule' => $cssStyleRule];
                return $twig->render($template . '.html.twig', $argsArray);
            }

        $template = 'message';
        $argsArray = [  'message' => $message,'isloggedin'=>$isLoggedIn,'username'=>$username,'cssStyleRule' => $cssStyleRule];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    function showPasswordFormAction($twig)
    {

        $pageTitle = 'Password Change Facility';
        $cssStyleRule = $this->buildStyleRule();
        $isLoggedIn = $this->isLoggedInFromSession();
        $shoppingCart = $this->getShoppingCartAction();
        $username = $this->usernameFromSession();
        if ($isLoggedIn) {

            $template = 'change_password';
            $argsArray = [
            'username'=>$username,'isloggedin'=>$isLoggedIn,'shoppingcart' => $shoppingCart,
            'cssStyleRule' => $cssStyleRule];
            }
        else {
            $template = 'index';
            $argsArray = [
                'shoppingcart' => $shoppingCart,
                'isloggedin' => $isLoggedIn,
                'username' => $username,
                'cssStyleRule' => $cssStyleRule
            ];
        }
            return $twig->render($template.'.html.twig', $argsArray);

        }

    function changePasswordAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $userId = User::getIdforUsername($username);
        $user = User::getOneById($userId->id);
        $productsRepository= new ProductsRepository();
        $connection = $productsRepository->getConnection();
        $cssStyleRule = $this->buildStyleRule();
        $password1=filter_input(INPUT_POST, 'password1');
        $password2=filter_input(INPUT_POST, 'password2');
        if ($this->passwordMatchCheck($password1,$password2)) {
            $user->setPassword($password1);


            $success = User::update($user);

            if ($success) {
                $message = "SUCCESS - your password has been updated. Please login";
            } else {
                $message = 'Sorry, there was a problem changing your password, Please ensure you enter the same password twice';
                $template = 'message';
                $argsArray = ['message' => $message,'username'=>$username,
                    'cssStyleRule' => $cssStyleRule];
                return $twig->render($template . '.html.twig', $argsArray);
            }
        }
        else
        {
            $message = 'Sorry, there was a problem changing your password. Please ensure you enter the same password twice';
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

    function passwordMatchCheck($password1,$password2)
    {
        if ($password1 ==$password2)
        {
            return true;
        }
        else {return false;}
    }
    function deleteAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $success = Product::delete($id);


        if($success){
            $message = 'SUCCESS - product with id = ' . $id . ' was deleted';
        } else {
            $message = 'sorry, product id = ' . $id . ' could not be deleted';
        }
        $template = 'message';
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    function showUpdateProductFormAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        // ID from GET parameters
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        // get array, ready for view to use to populate form
        $product = Product::getOneById($id);
        $productsRepository = new ProductsRepository();
        $categories = $productsRepository->getCategories();

        if (null == $product) {
            $message = 'sorry, no product with id = ' . $id . ' could be retrieved from the database';
            $template = 'message';
            $argsArray = ['message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
                'cssStyleRule' => $cssStyleRule];

            return $twig->render($template . '.html.twig', $argsArray);
        } else {
            // output the detail of product in HTML table
            $template = 'update';
            $argsArray = [
                'product' => $product,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn,
                'cssStyleRule' => $cssStyleRule
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
        $cssStyleRule = $this->buildStyleRule();
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
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function loginAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $template = 'login';
        $argsArray = ['cssStyleRule' => $cssStyleRule];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    public function purchaseBasketAction($twig)
    {
        $template = 'purchase';
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $shoppingCart = $this->getShoppingCartAction();
        $argsArray = [
            'shoppingcart' => $shoppingCart,
            'isloggedin'=>$isLoggedIn,
            'username'=>$username,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);
    }


    public function confirmPurchaseAction($twig)
    {
        $template = 'confirm_purchase';
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $_SESSION['shoppingCart'] = [];
        $argsArray = [
            'isloggedin'=>$isLoggedIn,
            'username'=>$username,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);
    }
    public function registerAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();

        $template = 'register';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function logoutAction($twig)
    {
        $isLoggedIn = false;
        $username = null;
        $cssStyleRule = $this->buildStyleRule();
        $this->killSessionAction();
        $template = 'message';
        $message = 'You are now logged out';
        $template = 'message';
        $argsArray = [  'message' => $message,
            'cssStyleRule' => $cssStyleRule];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function processLoginAction($twig)
    {
        // default is bad login
        $isLoggedIn = false;

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $cssStyleRule = $this->buildStyleRule();

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
            // $shoppingCart=$this->retrieveShoppingCartAction();
//            var_dump($shoppingCart);
            //   $_SESSION['shoppingCart'] = $shoppingCart;

            $argsArray = [
                'isloggedin'=>$isLoggedIn,
                'username'=>$username];
            return $twig->render($template . '.html.twig', $argsArray);

        } else {
            $message = 'bad username or password, please try again';
            $this->killSessionAction();
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
    public function sitemapAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $template = 'sitemap';
        $argsArray = ['username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule];
        return $twig->render($template . '.html.twig', $argsArray);
    }




    public function addToCartAction($twig)
    {
        // get the ID of product to add to cart
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $cssStyleRule = $this->buildStyleRule();

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
            'username'=>$username,
            'cssStyleRule' => $cssStyleRule
        ];
        return $this->indexAction($twig, $argsArray);

    }


    public function buyOneLessAction($twig)
    {
        // get the ID of product to add to cart
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $cssStyleRule = $this->buildStyleRule();

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
            'username'=>$username,
            'cssStyleRule' => $cssStyleRule
        ];
        return $this->indexAction($twig, $argsArray);

    }

    public function removeFromCartAction($twig)
    {
        // get the ID of product to add to cart
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();

        // get the cart array
        $shoppingCart = $this->getShoppingCartAction();

        // remove entry for this ID
        unset($shoppingCart[$id]);

        // store new  array into SESSION
        $_SESSION['shoppingCart'] = $shoppingCart;
        $argsArray = [
            'shoppingcart' => $shoppingCart,
            'isloggedin'=>$isLoggedIn,
            'username'=>$username,
            'cssStyleRule' => $cssStyleRule
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


    public function saveShoppingCartAction($twig)

    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();

        $shoppingCart = $this->getShoppingCartAction();
        $user = User::getIdforUsername($username);
        $userid=$user->id;

        foreach ($shoppingCart as $item) {
            $productid = $item->getProduct()->Id;
            $quantity = $item->getQuantity();
            $sql = 'INSERT into savedcarts (productid, userid, quantity) values ( ' . $productid . ',' . $userid . ',' . $quantity.')';
            Product::databaseUpdate($sql);
        }


         $message='Your cart has been stored';
        $template = 'message';
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function retrieveShoppingCartAction()
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $user = User::getIdforUsername($username);
        $userid=$user->id;
        $cssStyleRule = $this->buildStyleRule();

        $retrievedCartItem=Product::getSavedCart($userid);
        var_dump($retrievedCartItem);
           foreach ($retrievedCartItem as $item){
               $cartItem = new CartItem($item->id);
               $cartItem->setQuantity($item->quantity);

           }


        $_SESSION['shoppingCart'] = $cartItem;
    }
    function forgetSessionAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $this->killSessionAction();
        $message='Your shopping cart has been cleared';
        $template = 'message';
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule];
        // redirect to display text
        return $twig->render($template . '.html.twig', $argsArray);
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




    public function changeColor(\Twig_Environment $twig, string $color)
    {
        // (1) set default style array
        $styleArray = $this->getStyleArray();

        // (2) change color element to parameter
        $styleArray['color'] = $color;


        $styleArray['backgroundcolor'] = $color;

        // store new style array into SESSION
        $_SESSION['styleArray'] = $styleArray;
        // redirect display page (with CSS style rule)
        return $this->indexAction($twig);
    }

    public function buildStyleRule()
    {
        // (1) get style array
        $styleArray = $this->getStyleArray();

        // (3) retrieve color and size from array
        $color = $styleArray['color'];
        $size = $styleArray['size'];

        // (4) build string to define CSS rule for all body text color
        $bodyRule = 'body, section h2, #sidenav ul li a, #sidenav, p, div{'
            . PHP_EOL . "    color: $color;"
            . PHP_EOL . "    font-size: {$size}rem;"
            . PHP_EOL . "    background-color:light$color;"
            . PHP_EOL . '}';




        return $bodyRule;

    }

    public function changeSize(\Twig_Environment  $twig, float $size)
    {
        // (1) set default style array
        $styleArray = $this->getStyleArray();

        // (2) change color element to parameter
        $styleArray['size'] = $size;

        // store new style array into SESSION
        $_SESSION['styleArray'] = $styleArray;

        // redirect display page (with CSS style rule)
        return $this->indexAction($twig);
    }

    public function getStyleArray()
    {
        // (1) set default style array
        $styleArray = array();
        $styleArray['color'] = 'black';
        $styleArray['size'] = 1;

        // (2) try to retrieve style array from $_SESSION
        if (isset($_SESSION['styleArray'])){
            $styleArray = $_SESSION['styleArray'];
        }

        return $styleArray;
    }



}
