<?php
namespace Itb;

class MainController
{
    public function indexAction($twig)
    {
        $template = 'index';
        $argsArray = [];
        $template = 'loginForm';
        $shoppingCart = $this->getShoppingCart();
        $products = Product::getAllProducts();

        return $twig->render($template . '.html.twig', $argsArray);

        return $twig->render($template . '.html.twig', $argsArray);
    }



    public function aboutAction($twig)
    {
        $template = 'about';
        $argsArray = [];
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function loginSuccessAction($twig)
    {
        $template = 'loginsuccess';
        $argsArray = [];
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        return $twig->render($template . '.html.twig', $argsArray);
    }
    function listAction($twig)
    {
        $pageTitle = 'list of DVD votes';
        $productsRepository = new ProductsRepository();
        $products=Product::getAllProducts();// adapted version of getAll CRUD4FREE Method [used to pull in some joined table data]
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $productsRepository = new ProductsRepository();
        $categories = $productsRepository->getCategories();
        $template = 'list';
        $argsArray = [
            'products' => $products,'categories'=>$categories
        ];

        return $twig->render($template . '.html.twig', $argsArray);    }


    function detail_action($twig) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
           $productsRepository = new ProductsRepository();
        $product = Product::getOneProductById($id);
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

           if(null == $product){
            $message = 'sorry, no product with id = ' . $id . ' could be retrieved from the database';
            $template = 'message';
            $argsArray = [  'message' => $message];
            return $twig->render($template.'.html.twig', $argsArray);
        } else {
            // output the detail of product in HTML table
            $template = 'detail';
            $argsArray = [
                'products' => $product
            ];
            return $twig->render($template.'.html.twig', $argsArray);
        }
    }

    function show_new_product_form_action($twig)
    {

            $pageTitle = 'Add New Product';
            $productsRepository = new ProductsRepository();

            $categories = $productsRepository->getCategories();
            $isLoggedIn = $this->isLoggedInFromSession();
            $username = $this->usernameFromSession();

            $template = 'list';
            $argsArray = [
                'categories' => $categories
            ];
        return $twig->render('new_product_form..html.twig', $argsArray);
    }

    function create_product_action($twig)
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
        $argsArray = [  'message' => $message];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    function create_customer_action($twig)
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
                $argsArray = ['message' => $message];
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

    function delete_action($twig)
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
        $argsArray = [  'message' => $message];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    function show_update_product_form_action($twig)
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
            $argsArray = ['message' => $message];

            return $twig->render($template . '.html.twig', $argsArray);
        } else {
            // output the detail of product in HTML table
            $template = 'update';
            $argsArray = [
                'product' => $product,'categories'=>$categories
            ];


            return $twig->render($template . '.html.twig', $argsArray);
        }
    }


    public function update_product_action($twig)
    {
        $productsRepository = new ProductsRepository();
        $connection = $productsRepository->getConnection();
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $product=new Product();

        $product->setId(filter_input(INPUT_POST, 'Id', FILTER_SANITIZE_NUMBER_INT));
        $product->setPrice(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT)/100);
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
        $argsArray = [  'message' => $message];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function clothingAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();

        $template = 'clothing';
        $argsArray = [];
        return $twig->render($template.'.html.twig', $argsArray);

       }

    public function register($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'register';
        $argsArray = [];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    public function castAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'cast';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function merchandiseAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'merchandise';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function postersAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'posters';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function productsAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'products';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function registerAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'register';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }


    public function scriptAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'script';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function sitemapAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'sitemap';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    public function killSession()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')){
            $params = session_get_cookie_params();
            setcookie(	session_name(),
                '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
    }

    public function index_action($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $template = 'loginForm';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }


    function getShoppingCart()
    {
        if (isset($_SESSION['shoppingCart'])){
            return $_SESSION['shoppingCart'];

        } else {
            return [];
        }
    }

    function addToCart($twig)
    {
        // get the ID of product to add to cart
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $shoppingCart = $this->getShoppingCart();       // get the cart array

        $oldTotal = 0;    				     // default is old total is zero

        // if quantity found in cart array, then use it as oldTotal
        if(isset($shoppingCart[$id])){
            $oldTotal = $shoppingCart[$id];
        }

        $shoppingCart[$id] = $oldTotal + 1;             // store (old total + 1)
        $_SESSION['shoppingCart'] = $shoppingCart;      // store new  array into SESSION


        $template = 'index';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    function removeFromCart() {
        // get the ID of product to add to cart
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        // get the cart array
        $shoppingCart = getShoppingCart();

        // remove entry for this ID
        unset($shoppingCart[$id]);

        // store new  array into SESSION
        $_SESSION['shoppingCart'] = $shoppingCart;

        // redirect display page
        indexAction();
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
        $argsArray = [];
        if ($isLoggedIn) {
            // success - found a matching username and password, store in session
            $_SESSION['user'] = $username;
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
