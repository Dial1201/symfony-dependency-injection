<?php


use App\Logger;
use App\Texter\FaxTexter;
use App\Texter\SmsTexter;
use App\Database\Database;
use App\Mailer\SmtpMailer;
use App\Mailer\GmailMailer;
use App\Controller\OrderController;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

/*
return function (ContainerConfigurator $configurator) {
    $parameters = $configurator->parameters();

    $parameters
        ->set('mailer.gmail_user', 'issa@gmail.com')
        ->set('mailer.gmail_password', '123456');

    $services = $configurator->services();

    $services->defaults()
        ->autowire(true);

    $services
        ->set('order_controller', OrderController::class)
        ->call('sayHello', ['Bonjour à tous'])

        ->set('database', Database::class)

        ->set('logger', Logger::class)

        ->set('texter.sms', SmsTexter::class)
        ->args(['service.sms.com', 'apikey1234'])
        ->tag('with_logger')

        ->set('texter.fax', FaxTexter::class)

        ->set('mailer.gmail', GmailMailer::class)
        ->args(["%mailer.gmail_user%", "%mailer.gmail_password%"])
        ->tag('with_logger')

        ->set('mailer.smtp', SmtpMailer::class)

        ->args(['smtp://localhost', 'root', '123'])

        ->alias('App\Controller\OrderController', 'order_controller')->public()
        ->alias('App\Database\Database', 'database')
        ->Alias('App\Logger', 'logger')
        ->Alias('App\Mailer\GmailMailer', 'mailer.gmail')
        ->Alias('App\Mailer\SmtpMailer', 'mailer.gmail')
        ->Alias('App\Mailer\MailerInterface', 'mailer.gmail')
        ->Alias('App\Texter\SmsTexter', 'texter.sms')
        ->Alias('App\Texter\FaxTexter', 'texter.sms')
        ->Alias('App\Texter\TexterInterface', 'texter.sms');
};
*/
