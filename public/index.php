<?php

// autoloader
// ------------
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/setup.php';
// my settings
// ------------
$myTemplatesPath = __DIR__ . '/../templates';

// setup twig
// ------------
$loader = new Twig_Loader_Filesystem($myTemplatesPath);
$twig = new Twig_Environment($loader);

session_start();

use Itb\MainController;
$mainController = new MainController;


$action = filter_input(INPUT_GET, 'action');

switch($action){
    case 'about':
        $html = $mainController->aboutAction($twig);
        break;

        break;
    case 'list':
        $html = $mainController->listAction($twig);
        break;

    case 'clothing':
        $html = $mainController->clothingAction($twig);
        break;

    case 'music':
        $html = $mainController->musicAction($twig);
        break;

    case 'detail':
        $html = $mainController->detailAction($twig);

        break;

    case 'delete':
        $html = $mainController->deleteAction($twig);
        break;

    case 'showNewProductForm':
        $html = $mainController->showNewProductFormAction($twig);
        break;

    case 'createNewProduct':
        $html = $mainController->createProductAction($twig);
        break;

    case 'createNewCustomer':
        $html = $mainController->createCustomerAction($twig);
        break;

    case 'processEditUser':
        $html = $mainController->processEditUserAction($twig);
        break;

    case 'showEditUserForm':
        $html = $mainController->showEditUserAction($twig);
        break;

    case 'showPasswordForm':
        $html = $mainController->showPasswordFormAction($twig);
        break;

    case 'changePassword':
        $html = $mainController->changePasswordAction($twig);
        break;

    case 'login':
        $html = $mainController->loginAction($twig);
        break;

    case 'logout':
        $html = $mainController->logoutAction($twig);
        break;

    case 'sitemap':
        $html=$mainController->siteMapAction($twig);
        break;

    case 'register':
        $html=$mainController->registerAction($twig);
        break;
    case 'showUpdateProductForm':
        $html=$mainController->showUpdateProductFormAction($twig);
        break;

    case 'updateProduct':
        $html = $mainController->updateProductAction($twig);
        break;
    case 'processLogin':
        $html = $mainController->processLoginAction($twig);
        break;

    case 'addToCart':
        $html=$mainController->addToCartAction($twig);
        break;

    case 'buyOneLess':
        $html=$mainController->buyOneLessAction($twig);
        break;

    case 'removeFromCart':
        $html=$mainController->removeFromCartAction($twig);
        break;

    case 'emptyCart':
        $html=$mainController->forgetSessionAction($twig);
        break;

    case 'saveShoppingCart':
        $html=$mainController->saveShoppingCartAction($twig);
        break;

    case 'purchaseBasket':
        $html=$mainController->purchaseBasketAction($twig);
        break;
    case 'confirmPurchase':
        $html=$mainController->confirmPurchaseAction($twig);
        break;

    case 'colorGray':
        $html = $mainController->changeColor($twig, 'gray');
        break;

    case 'colorGreen':
        $html = $mainController->changeColor($twig, 'green');
        break;
    case 'colorBlue':
        $html = $mainController->changeColor($twig, 'blue');
        break;
    case 'colorNone':
        $html = $mainController->changeColor($twig, 'none');
        break;
    case 'sizeOne':
        $html =  $mainController->changeSize($twig, 1);
        break;

    case 'sizeOnePointTwo':
        $html =  $mainController->changeSize($twig, 1.2);
        break;

    case 'userAdmin':
        $html=$mainController->userAdminAction($twig);
        break;

    case 'showEditUserById':
        $html=$mainController->showEditUserByIdAction($twig);
        break;

    default:
        $html=$mainController->indexAction($twig);
}
print $html;