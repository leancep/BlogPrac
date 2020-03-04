<?php

namespace Blogs\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LoginController implements \Blogs\Interfaces\Controller {

    public function config($app) {

        $app->get('/login', function (Request $request, Response $response, array $args) {
            $template = $request->getAttribute("twig")->load('index.html');

            $response->getBody()->write(
                $template->render([])
            );
            return $response;
        });

        

        $app->post('/login', function (Request $request, Response $response, array $args) {
            
            $user = $request->getAttribute("loginService")->login($_POST["userId"],$_POST["password"]);

            if (!$user instanceof \Blogs\Models\UserNull) {
            
                $response= $response-> withStatus(302);
                $response= $response-> withHeader('Location', 'feed');
                $response->getBody()->write("Logged In");
                return $response;

            } else {
                $response= $response-> withStatus(302);
                $response= $response-> withHeader('Location', '/');
                $response->getBody()->write("Login Fail");
                return $response;
            }

        });
    }
}