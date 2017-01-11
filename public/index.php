<?php



require_once __DIR__ . '/../app/setup.php';
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
        forgetSession();
        break;

    default:
        $html=$mainController->indexAction($twig);
}
print $html;