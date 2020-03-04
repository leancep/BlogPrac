<?php
include "../vendor/autoload.php";

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

session_start();

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) return false;
}
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../template');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

$mongoconn= new MongoDB\Client("mongodb://localhost");
$userService= new \Blogs\Service\UserService($mongoconn->practiceblog->users);
$postService= new \Blogs\Service\PostService($mongoconn->practiceblog->blog);

$app = AppFactory::create();
$app->add(function($serverRequest, $requestHandler)
            use($twig, $userService, $postService){
            
    $serverRequest =$serverRequest->withAttribute("twig", $twig);
    $serverRequest =$serverRequest->withAttribute("userService", $userService);
    $serverRequest =$serverRequest->withAttribute("postService", $postService);

    return $requestHandler->handle($serverRequest);
});

$controllerService = new \Blogs\Service\ControllerService;
$controllerService->setup($app, __DIR__ .'/../src/Controllers/' );

$app->run();
