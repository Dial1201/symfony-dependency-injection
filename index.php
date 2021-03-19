<?php

use App\Controller\OrderController;
use App\DependencyInjection\LoggerCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require __DIR__ . '/vendor/autoload.php';
/**
 * To create some container services with building
 */
$container = new ContainerBuilder();


// Loading of the setting services 

// $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/config'));
// $loader->load('services.php');

$loader = new YamlFileLoader($container, new FileLocator([__DIR__ . '/config']));
$loader->load('services.yaml');

/**
 * Before to call compile we add compilerpass
 * 
 */

$container->addCompilerPass(new LoggerCompilerPass);

/////////////////////////////////////////////
/**
 * The compilation phase allows
 * 1. Optimize the service definitions
 * 2. Detect possible configuration errors (such as circular references)
 * 3. To modify the Definitions at the last minute by having all the configurations at hand
 * 
 * But warning, the compilation has a side effect: the services are all set to "private" by default, which then * prevents us from making a direct request to the container with the method $container->get('my_service') 
 * unless the requested service has been clearly defined as public!
 * 
 * All the services who will should to be to call after compile, should to be public (line 103)
 */
$container->compile();

$controller = $container->get(OrderController::class);



$httpMethod = $_SERVER['REQUEST_METHOD'];


if ($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__ . '/views/form.html.php';
