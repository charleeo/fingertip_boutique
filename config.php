<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/phpecommerce/');
define('CART_COOKIE', 'SX443kPl56Nmv9IxZ8');
define('CART_COOKIE_EXPIRE', time()+ (86400 *30));
define('TAXRATE', 0.02);

define('CURRENCY', 'ngn');
define('CHECKOUTMODE', 'TEST'); //change test to live when you raer ready to to live
if(CHECKOUTMODE =='TEST'){
    // define('STRIPE_PRIVATE', 'sk_test_pwFYKec5uhcLC3bzIBdMoLRx003ua68Jhm');
    // define('STRIPE_PUBLIC', 'pk_test_shqvXd67RWnPocaDT33X4ZLS00bEgY1aWL');
}

// if(CHECKOUTMODE =='LIVE'){
//     define("SRTIPE_PRIVATE", '');
//     define("STRIPE_PUBLIC", '');
// }