<?php

namespace App\Routing\Middleware;

use Cake\Http\Exception\RedirectException;
use Cake\Http\MiddlewareQueue;
use Cake\Http\Runner;
use Cake\Routing\Exception\RedirectException as DeprecatedRedirectException;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\Router;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AppRoutingMiddleware extends RoutingMiddleware
{
    /**
     * Apply routing and update the request.
     *
     * Any route/path specific middleware will be wrapped around $next and then the new middleware stack will be
     * invoked.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->loadRoutes();
        try {
            //Don't set static vars Router::$_request and Router::$_requestContext
//            Router::setRequest($request);
            $params = (array)$request->getAttribute('params', []);
            $middleware = [];
            if (empty($params['controller'])) {
                $params = Router::parseRequest($request) + $params;
                if (isset($params['_middleware'])) {
                    $middleware = $params['_middleware'];
                    unset($params['_middleware']);
                }
                /** @var \Cake\Http\ServerRequest $request */
                $request = $request->withAttribute('params', $params);
                //Don't set static vars Router::$_request and Router::$_requestContext
//                Router::setRequest($request);
            }
        } catch (RedirectException $e) {
            return new RedirectResponse(
                $e->getMessage(),
                $e->getCode()
            );
        } catch (DeprecatedRedirectException $e) {
            return new RedirectResponse(
                $e->getMessage(),
                $e->getCode()
            );
        }
        $matching = Router::getRouteCollection()->getMiddleware($middleware);
        if (!$matching) {
            return $handler->handle($request);
        }

        $middleware = new MiddlewareQueue($matching);
        $runner = new Runner();

        return $runner->run($middleware, $request, $handler);
    }
}
