<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\DependencyInjection\LoggerCompilerPass;
use App\Logger;
use App\Mailer\GmailMailer;
use App\Mailer\SmtpMailer;
use App\Texter\FaxTexter;
use App\Texter\SmsTexter;
use App\Texter\TexterInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__ . '/vendor/autoload.php';
/**
 * To create some container services with building
 */
$container = new ContainerBuilder();

/**
 * For facilities to create of  our  definitions
 * we use parameters directly on our container
 * exemple with the definition mailer.gmail
 * to see line 61
 */
$container->setParameter('mailer.gmail_user', 'issa@gmail.com');
$container->setParameter('mailer.gmail_password', '123456');

///////////////////////////////////////////

/**
 * To explain at the container how do you create a object
 * we can add arguments and autowiring
 * Autowiring runs if container is compile
 * we can update constructor of our classes whithout to touch our definition or register
 */
$container->register('database', Database::class)
    ->setAutowired(true);
/**
 * we can write another way more fast
 * exactly same thing
 */
$container->autowire('database', Database::class);

///////////////////////////////////////////

$container->autowire('logger', Logger::class);

$container->autowire('texter.sms', SmsTexter::class)
    ->setArguments(['service.sms.com', 'apikey1234'])
    ->addTag('with_logger');



$container->autowire('texter.fax', FaxTexter::class);


/////////////////////////////////////////

$container->autowire('mailer.gmail', GmailMailer::class)
    ->setArguments(["%mailer.gmail_user%", "%mailer.gmail_password%"])
    ->addTag('with_logger');




$container->autowire('mailer.smtp', SmtpMailer::class)
    ->setArguments(['smtp://localhost', 'root', '123']);

//////////////////////////////////////////


$container->autowire('order_controller', OrderController::class)
    ->addMethodCall('sayHello', ['Bonjour à tous']);


/////////////////////////////////////////////////

/**
 * To give aliases
 * we can use class name when aliases to create Amazing !
 */

$container->setAlias('App\Controller\OrderController', 'order_controller')->setPublic(true);

$container->setAlias('App\Database\Database', 'database');

$container->setAlias('App\Logger', 'logger');

$container->setAlias('App\Mailer\GmailMailer', 'mailer.gmail');
$container->setAlias('App\Mailer\SmtpMailer', 'mailer.gmail');
$container->setAlias('App\Mailer\MailerInterface', 'mailer.gmail');

$container->setAlias('App\Texter\SmsTexter', 'texter.sms');
$container->setAlias('App\Texter\FaxTexter', 'texter.sms');
$container->setAlias('App\Texter\TexterInterface', 'texter.sms');

///////////////////////////////////////////////

/**
 * Before to call compile we add compilerpass
 * to use
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


/////////////////////////////////////////////////



$httpMethod = $_SERVER['REQUEST_METHOD'];


if ($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__ . '/views/form.html.php';
