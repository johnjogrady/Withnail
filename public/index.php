<?php
session_start();


require_once __DIR__ . '/../app/setup.php';

use Itb\MainController;
$mainController = new MainController;


$action = filter_input(INPUT_GET, 'action');

switch($action){
    case 'about':
        $html = $mainController->aboutAction($twig);
        break;


    case 'clothing':
        $html = $mainController->clothingAction($twig);

        break;
    case 'list':
        $html = $mainController->listAction($twig);
        break;

    case 'detail':
        $html = $mainController->detail_action($twig);

        break;

    case 'show':
        show_one_product_action(1);
        break;

    case 'delete':
        $html = $mainController->delete_action($twig);
        break;

    case 'showNewProductForm':
        $html = $mainController->show_new_product_form_action($twig);
        break;

    case 'createNewProduct':
        $html = $mainController->create_product_action($twig);
        break;

    case 'createNewCustomer':
        $html = $mainController->create_customer_action($twig);
        break;

    case 'cast':
        $html = $mainController->castAction($twig);
        break;

    case 'merchandise':
        $html= $mainController->merchandiseAction($twig);
        break;

    case 'posters':
        $html=$mainController->postersAction($twig);
        break;

    case 'products':
        $html=$mainController->productsAction($twig);
        break;

    case 'sitemap':
        $html=$mainController->sitemapAction($twig);
        break;

    case 'script':
        $html=$mainController->scriptAction($twig);
        break;

    case 'register':
        $html=$mainController->registerAction($twig);
        break;
    case 'showUpdateProductForm':
        $html=$mainController->show_update_product_form_action($twig);
        break;

    case 'updateproduct':
        $html = $mainController->update_product_action($twig);
        break;
    case 'processLogin':
        $html = $mainController->processLoginAction($twig);
        break;

    case 'addToCart':
        $html=$mainController->addToCart($twig);
        break;

    case 'removeFromCart':
        removeFromCart();
        break;

    case 'emptyCart':
        forgetSession();
        break;


    default:
        $html=$mainController->indexAction($twig);
}
print $html;