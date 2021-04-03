<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Router;

use Ulrack\Web\Exception\HttpException;
use Ulrack\Web\Common\Router\RouterInterface;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Middleware\MiddlewareInterface;

class MiddlewareRouter implements RouterInterface
{
    /**
     * Contains the router.
     *
     * @var RouterInterface
     */
    private RouterInterface $router;

    /**
     * Contains the middleware that takes care of the accepts method.
     *
     * @var MiddlewareInterface|null
     */
    private ?MiddlewareInterface $middlewareAccept;

    /**
     * Contains the middleware that takes care of the invoke method.
     *
     * @var MiddlewareInterface|null
     */
    private ?MiddlewareInterface $middlewareInvoke;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     * @param MiddlewareInterface $middlewareAccept
     * @param MiddlewareInterface $middlewareInvoke
     */
    public function __construct(
        RouterInterface $router,
        MiddlewareInterface $middlewareAccept = null,
        MiddlewareInterface $middlewareInvoke = null
    ) {
        $this->router = $router;
        $this->middlewareAccept = $middlewareAccept;
        $this->middlewareInvoke = $middlewareInvoke;
    }

    /**
     * Determines whether the router accepts the request.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    public function accepts(
        InputInterface $input,
        OutputInterface $output
    ): bool {
        if (
            is_null($this->middlewareAccept) ||
            $this->middlewareAccept->pass($input, $output)
        ) {
            return $this->router->accepts($input, $output);
        }

        return false;
    }

    /**
     * Resolves the request to an endpoint, executes it and renders the response.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function __invoke(
        InputInterface $input,
        OutputInterface $output
    ): void {
        if (
            is_null($this->middlewareInvoke) ||
            $this->middlewareInvoke->pass($input, $output)
        ) {
            $this->router->__invoke($input, $output);

            return;
        }

        throw new HttpException($this->middlewareInvoke->getErrorCode());
    }
}
