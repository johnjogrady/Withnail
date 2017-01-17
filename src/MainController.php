<?php
/**
 * Class Category | core/MainController.php
 *
 * @version     v.1.0 (06/01/2016)
 * @Author John O'Grady
 *
 */
namespace Itb;
/**
 * Overall main controller based on MVC pattern which contains a variety of different methods
 */
class MainController
{
    /**
     * controller method to display Default/Home page of the site. checks if logged in and if so retrieves cart
     */
    public function indexAction(\Twig_Environment $twig)
    {
        $template = 'index';
        // clear argsArray
        $argsArray = [];
        //check if user is autgenticated and username of authenticated user
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        // retrieve shopping chart and style rules
        $cssStyleRule = $this->buildStyleRule();
        $shoppingCart = $this->getShoppingCartAction();
        /**
        *passes contents of cart, style rules and
         */

        $argsArray = [
            'shoppingcart' => $shoppingCart,
            'isloggedin'=>$isLoggedIn,
            'username'=>$username,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);
    }

    /**
     * controller method to display static about page of the site.
     */
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

    /**
     * controller method to display landing page if login has been successful
     */
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
        //route user back to the indexAction page passing loggedin (bool to indicate if logged in or not), and username)

        return $this->indexAction($twig);
       }

    /**
     * controller method to display retrieve a list of all products and displays in a table
     */
    function listAction($twig)
    {
        $pageTitle = 'List';
        $products=Product::getAllProducts();// adapted version of getAll CRUD4FREE Method [used to pull in some joined table data]
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $productsRepository = new ProductsRepository();
        //builds list of categories to display beside individual products
        $categories = $productsRepository->getCategories();
        // route user to products list page which displays all products in a HTML table
        $template = 'list';
        $argsArray = [
            'products' => $products,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);    }

    /**
     * controller method to display filtered pages which displays clothing category products, category id hard coded for now
     */
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
        // route user to clothing page which displays a list of clothing products in a HTML table

        $template = 'clothing';
        $argsArray = [
            'products' => $products,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);    }

    /**
     * controller method to display filtered pages which displays music category products, category id hard coded for now
     */
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
        // route user to music page which displays a list of music products in a HTML table

        $template = 'music';
        $argsArray = [
            'products' => $products,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);    }

    /**
     * controller method to display detail page for an individual product
     */
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

    /**
     * landing page shown for adding a new product to the site (restricted to admin users only)
     */
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

    /**
     * processes form data input in new product form above(restricted to admin users only)
     */
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
        // route user to message page with success or failure notice

        $template = 'message';
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule];
        return $twig->render($template.'.html.twig', $argsArray);

    }
    /**
     * controller method to process submitted new User registration
     */
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
        $new_user->setAvatar(filter_input(INPUT_POST, 'avatar')) ;
        $new_user->setUsername(filter_input(INPUT_POST, 'email')) ;
        $new_user->setMobileNumber(filter_input(INPUT_POST, 'mobileNumber')) ;
        $new_user->setPassword(filter_input(INPUT_POST, 'password')) ;
        $new_user->setRole(User::ROLE_USER);
        /**
         * calls checkEmailInDB method below to verify that the email of the new registering user is not already in the datavase
         */

        $emailFound=$this->checkEmailInDB($new_user->getUsername());
        if (!$emailFound) {
            $success = User::insert($new_user);
            if ($success) {
                $id = $connection->lastInsertId(); // get ID of newly created record
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
        // route user to message page with success or failure notice
        $template = 'message';
        $argsArray = [  'message' => $message];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    /**
     * this controller method renders a form where user can change their details
     * this first version loads the currently logged in and authenticated user on username variable in session
     * returns a single user record
     */
    function showEditUserAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        //get userid attached to this username
        $userId = User::getIdforUsername($username);
        //load $user object into memory passing userid to database query
        $user = User::getOneById($userId->id);
        $cssStyleRule = $this->buildStyleRule();
        $productsRepository = new ProductsRepository();
        $connection = $productsRepository->getConnection();
        //display edit user template page
        $template = 'edit_user';
        $argsArray = [
            'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule,'user'=>$user];
         return $twig->render($template.'.html.twig', $argsArray);

    }

    /**
     * this controller method renders a form where user can change their details
     * this version accepts a User id from the Show Users form.
     */
    function showEditUserByIdAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $userId=filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $user = User::getOneById($userId);
        $cssStyleRule = $this->buildStyleRule();
        $productsRepository = new ProductsRepository();
        $connection = $productsRepository->getConnection();
        //display edit user template page
        $template = 'edit_user';
        $argsArray = [
            'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule,'user'=>$user];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    /**
     * method to write updated user information into the database
     */
    function processEditUserAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $productsRepository = new ProductsRepository();
        $connection = $productsRepository->getConnection();
        $user=new User();
        //retrieve user field values entered into form

        $user->setId(filter_input(INPUT_POST, 'Id')) ;
        $user->setUsername(filter_input(INPUT_POST, 'email')) ;
        $username=$user->getUsername();
        $user->setRole(1) ;
        $user->setPassword('withnail');
        // I'm having an issue here where in passing between the two pages, the password is getting changed, so I've hard coded it here for now
        $user->setFirstName(filter_input(INPUT_POST, 'firstName')) ;
        $user->setLastName(filter_input(INPUT_POST, 'lastName')) ;
        $user->setCustomerAddress1(filter_input(INPUT_POST, 'addressLine1')) ;
        $user->setAvatar('cat') ;// Missed this choose avatar requirement in the spec
        // until very late in the project so I've hard coded for now, TO DO: wire it to form user input value later...
        $user->setCustomerAddress2(filter_input(INPUT_POST, 'addressLine2')) ;
        $user->setCustomerAddress3(filter_input(INPUT_POST, 'addressLine3')) ;
        $user->setCounty(filter_input(INPUT_POST, 'county')) ;
        $user->setEmail(filter_input(INPUT_POST, 'email')) ;
        $user->setMobileNumber(filter_input(INPUT_POST, 'mobileNumber')) ;
        $success = User::update($user);
        // to avoid $username being reset to current user being edited, it session variable needs to be reset here
        $username=$this->usernameFromSession();
            if ($success) {
                $id = $connection->lastInsertId(); // get ID of new record
                $message = "SUCCESS - The account information has been updated";
            } else {
                $message = 'Sorry, there was a problem updating the account information';
                $template = 'message';
                $argsArray = ['message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
                    'cssStyleRule' => $cssStyleRule];
                return $twig->render($template . '.html.twig', $argsArray);
            }
        // route user to message page with success or failure notice

        $template = 'message';
        $argsArray = [  'message' => $message,'isloggedin'=>$isLoggedIn,'username'=>$username,'cssStyleRule' => $cssStyleRule];
        return $twig->render($template.'.html.twig', $argsArray);

    }
    /**
     * method to display change password form to the user
     */
    function showPasswordFormAction($twig)
    {

        $pageTitle = 'Password Change Facility';
        $cssStyleRule = $this->buildStyleRule();
        $isLoggedIn = $this->isLoggedInFromSession();
        $shoppingCart = $this->getShoppingCartAction();
        $username = $this->usernameFromSession();
        // only display change password form to authenticated users, otherwise display index page

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

    /**
     * method to write updated password into the database
     */
    function changePasswordAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        // check which user is logged in
        $username = $this->usernameFromSession();
        // get userid for this username ( yeah, I know....)
        $userId = User::getIdforUsername($username);
        // use PDO helper class to retrieve User object which matches that id in the database
        $user = User::getOneById($userId->id);
        $cssStyleRule = $this->buildStyleRule();
        //retrieve password field values
        $password1=filter_input(INPUT_POST, 'password1');
        $password2=filter_input(INPUT_POST, 'password2');

        //  calls passwordMatchCheck method below to ensure form data in both password fields was the same
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
            //  could not save password

        {
            $message = 'Sorry, there was a problem changing your password. Please ensure you enter the same password twice';
        }
        // route user to message page with success or failure notice
        $template = 'message';
        $argsArray = [  'message' => $message];
        return $twig->render($template.'.html.twig', $argsArray);
    }

    /**
     * helper method to checks to see if new registration has the same email address as one already in the database
     */
    function checkEmailInDB($email)
    {
        $productsRepository = new ProductsRepository();
        // obtain database connection
        $connection = $productsRepository->getConnection();
        $sql = "select count(*) from users WHERE `email` = '$email'";
        //build database query and execute
        $result = $connection->prepare($sql);
        $result->execute();
        // if database query returns a non empty result the email already exists, return true
        $numrows = $result->fetchColumn();
        if ($numrows>0)
        {
            return true;
        }
        // otherwise it does not exists, return false

        else {return false;}
    }
    /**
     * helper method to verify that the two password fields contained the same data
     */
    function passwordMatchCheck($password1,$password2)
    {
        if ($password1 ==$password2)
        {
            return true;
        }
        else {return false;}
    }

    /**
     * this controller method renders a form where user can change their details
     * returns a single user record
     */
    function userAdminAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        //get all users in the database
        $users = User::getAll();
        $cssStyleRule = $this->buildStyleRule();
        $productsRepository = new ProductsRepository();
        $connection = $productsRepository->getConnection();
        //display edit user template page
        $template = 'show_users';
        $argsArray = [
            'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule,'users'=>$users];
        return $twig->render($template.'.html.twig', $argsArray);

    }
    /**
     * this method removes a single product, identified by id from the database
     */
    function deleteAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        //get id from form of product to be deleted
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        // use PDO helper class to delete Product object which matches that id in the database
        $success = Product::delete($id);
        if($success){
            $message = 'SUCCESS - product with id = ' . $id . ' was deleted';
        } else {
            $message = 'sorry, product id = ' . $id . ' could not be deleted';
        }
        // route user to message page with success or failure notice

        $template = 'message';
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule];
        return $twig->render($template.'.html.twig', $argsArray);

    }
    /**
     * this method displays a product update to allow a user to change product attributes
     */
    function showUpdateProductFormAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        // ID from from GET method to indicate product to be updated
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        // get array of product attributes for that product, ready for view to use to populate form
        $product = Product::getOneById($id);
        // database connection
        $productsRepository = new ProductsRepository();
        $categories = $productsRepository->getCategories();
        // if database didn't locate the product
        // route user to message page with failure notice
        if (null == $product) {
            $message = 'sorry, no product with id = ' . $id . ' could be retrieved from the database';
            $template = 'message';
            $argsArray = ['message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
                'cssStyleRule' => $cssStyleRule];

            return $twig->render($template . '.html.twig', $argsArray);
        } else {
            // route user to update page for product
            // output the detail of product in HTML table
            $template = 'update';
            $argsArray = [
                'product' => $product,'categories'=>$categories,'username'=>$username,'isloggedin'=>$isLoggedIn,
                'cssStyleRule' => $cssStyleRule
            ];

            return $twig->render($template . '.html.twig', $argsArray);
        }
    }

    /**
     * method to add updated product attributes to the database
     */
    public function updateProductAction($twig)
    {
        $productsRepository = new ProductsRepository();
        $connection = $productsRepository->getConnection();
        $isLoggedIn = $this->isLoggedInFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $username = $this->usernameFromSession();
        // create product variable in memory
        $product=new Product();
        // bind updated form data for product attributes to Product object
        $product->setId(filter_input(INPUT_POST, 'Id', FILTER_SANITIZE_NUMBER_INT));
        $product->setPrice(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT));
        $product->setDescription(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));
        $product->setImageUrl(filter_input(INPUT_POST, 'image_url', FILTER_SANITIZE_STRING));
        $product->setStocklevel(filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT));
        $product->setProductCategoryId(filter_input(INPUT_POST, 'ProductCategoryId', FILTER_SANITIZE_NUMBER_INT));
        // attempt to write updated product attributes to database using pdo db level methods
        $success = Product::update($product);
        if($success){
            $message = "SUCCESS - new product updated";
        } else {
            $message = 'sorry, there was a problem updated the product';
        }
        // route user to message page with success or failure notice

        $template = 'message';
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    /**
     * method to display login page to user
     */
    public function loginAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        $template = 'login';
        $argsArray = ['cssStyleRule' => $cssStyleRule];
        return $twig->render($template.'.html.twig', $argsArray);

    }

    /**
     * method to allow user to process items in Cart through to purchase stage
     */
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

    /**
     * method to allow display items in Cart and ask user to confirm/cancel order
     */
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

    /**
     * method to display registration page for User
     */
    public function registerAction($twig)
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();

        $template = 'register';
        $argsArray = [];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    /**
     * method to which user is routed when the click Logout on Nav menu.
     */
    public function logoutAction($twig)
    {
        //clears isloggedin flag and username objects in memory
        $isLoggedIn = false;
        $username = null;
        $cssStyleRule = $this->buildStyleRule();
        //calls kill Session method to remove session variables
        $this->killSessionAction();
        $template = 'message';
        //route user to message page and advise user of their logged out status
        $message = 'You are now logged out';
        $template = 'message';
        $argsArray = [  'message' => $message,
            'cssStyleRule' => $cssStyleRule];
        return $twig->render($template . '.html.twig', $argsArray);
    }

    /**
     * this method processes an attempt by user to login using login page
     */
    public function processLoginAction($twig)
    {
        // default is bad login
        $isLoggedIn = false;
        //retrieve username and password from form data, post method of login page

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $cssStyleRule = $this->buildStyleRule();

        // search for user with username and supplied password in repository
        $isLoggedIn = UserRepository::canFindMatchingUsernameAndPassword($username, $password);
        // check if user is and admin.. Had intended to link this to the role attribute in the User table but ran out of time!

        $hashedCorrectPassword = password_hash('admin', PASSWORD_DEFAULT);
        if (('admin' == $username) && password_verify($password, $hashedCorrectPassword)) {
            $isLoggedIn = true;

        }

        $template = 'loginSuccess';

        if ($isLoggedIn) {
            // success - found a matching username and password, store in session
            $_SESSION['user'] = $username;
            // $shoppingCart=$this->retrieveShoppingCartAction();
            // As per note on the forum, I haven't been able to get this feature working so I've commented it out for now


            //   $_SESSION['shoppingCart'] = $shoppingCart;
            //route user to succesful login page
            $argsArray = [
                'isloggedin'=>$isLoggedIn,
                'username'=>$username];
            return $twig->render($template . '.html.twig', $argsArray);

        } else
            //route user to unsuccessful login page

        {
            $message = 'bad username or password, please try again';
            $this->killSessionAction();
            $template = 'message';
            $argsArray = ['message' => $message];
            return $twig->render($template . '.html.twig', $argsArray);

        }
    }
    /**
     * this method checks if user is logged in from a session in _SESSION
     */
    public function isLoggedInFromSession() {
        $isLoggedIn = false;
        // user is logged in if there is a 'user' entry in the SESSION superglobal
        if(isset($_SESSION['user'])){
            $isLoggedIn = true;

        }
        return $isLoggedIn;
    }

    /**
     * this method retrieves username for currently logged in user for display in UI
     */
    public function usernameFromSession() {
        $username = '';
        // extract username from SESSION superglobal
        if (isset($_SESSION['user'])) {
            $username = $_SESSION['user'];
        }
        return $username;
    }

    /**
     * this method displays sitemap to user
     */
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

    /**
     * this method allows user to add an item to the Session cart
     */
    public function addToCartAction($twig)
    {
        // get the ID of product to add to cart
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        //retrieve selected product
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

    /**
     * this method allows user to reduce quantity in cart of a product by one unit
     */
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

            // store old quantity less 1 as new quantity into cart array
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
    /**
     * this method allows user to remove an individual product from the cart, leaving other items in cart unaffected
     */
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

    /**
     * this helper method retrieves cart values from Session [shopping cart] if this already exists
     */
    function getShoppingCartAction()
    {
        if (isset($_SESSION['shoppingCart'])){
            return $_SESSION['shoppingCart'];
        } else {
            return [];
        }
    }

    /**
     * this method saves the Shopping cart contents from the session into the CartItems table in the database
     */
    public function saveShoppingCartAction($twig)

    {
        $isLoggedIn = $this->isLoggedInFromSession();
        $username = $this->usernameFromSession();
        $cssStyleRule = $this->buildStyleRule();
        // retrieve shopping cart
        $shoppingCart = $this->getShoppingCartAction();
        //get User and then UserID for the currently logged in user
        $user = User::getIdforUsername($username);
        $userid=$user->id;
        // iterate through the cart items and insert new entries in the database representing quantity, productid and user
        foreach ($shoppingCart as $item) {
            //check id for product and store in memory
            $product = $item->getProduct();
            $productId=$product->getId();
            //check id for quantity and store in memory
            $quantity = $item->getQuantity();
            // prepare sql statement to write into database
            $sql = 'INSERT into savedcarts (productid, userid, quantity) values ( ' . $productId . ',' . $userid . ',' . $quantity.')';
            // attempt to update this line of detail from the cart into the cartitems database table
            Product::databaseUpdate($sql);
        }
        $message='Your cart has been stored';
        $template = 'message';
        $argsArray = [  'message' => $message,'username'=>$username,'isloggedin'=>$isLoggedIn,
            'cssStyleRule' => $cssStyleRule
        ];

        return $twig->render($template . '.html.twig', $argsArray);
    }

    /**
     * this method retrieves the previously saved Shopping cart contents from the CartItems table in the database into the session variable
     */
    public function retrieveShoppingCartAction()
    {
        $isLoggedIn = $this->isLoggedInFromSession();
        //get currently logged in user
        $username = $this->usernameFromSession();
        //get userid for this username

        $user = User::getIdforUsername($username);
        $userid=$user->id;
        $cssStyleRule = $this->buildStyleRule();
        // retrieve cart from database
        $retrievedCartItem=Product::getSavedCart($userid);
           foreach ($retrievedCartItem as $item){
               $cartItem = new CartItem($item->id);
               $cartItem->setQuantity($item->quantity);
     }
        $_SESSION['shoppingCart'] = $cartItem;
    }

    /**
     * return user to message confirming session has been cleared
     * this method retrieves the previously saved Shopping cart contents from the CartItems table in the database into the session variable
     */
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

    /**
     * method will clear session
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


    /**
     * change the colour of various CSS objects based on user select
     * as well as the Twig environment variable, accepts a string representing CSS colour
     */
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

    /**
     * dynamically builds a CSS rule based on colour and font size
     * used to populate styles which are applied to _base.html.twig
     * returns a String containing the CSS rule
     */
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

    /**
     * used to change the font size based on user selection, accepts twig context and size variable
     */
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

    /**
     * used to set default Style characterists
     */
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
