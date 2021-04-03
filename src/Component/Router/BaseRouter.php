<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Router;

use Throwable;
use Ulrack\Web\Common\Router\RouterInterface;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Endpoint\EndpointInterface;
use Ulrack\Web\Common\Error\ErrorHandlerInterface;
use Ulrack\Web\Common\Output\OutputHandlerInterface;
use GrizzIt\Services\Common\Factory\ServiceFactoryInterface;

class BaseRouter implements RouterInterface
{
    /**
     * Contains the router.
     *
     * @var RouterInterface
     */
    private RouterInterface $router;

    /**
     * Determines whether a router has been found.
     *
     * @var bool
     */
    private bool $found = false;

    /**
     * Contains the output handler.
     *
     * @var OutputHandlerInterface
     */
    private OutputHandlerInterface $outputHandler;

    /**
     * Contains the error handler.
     *
     * @var ErrorHandlerInterface
     */
    private ErrorHandlerInterface $errorHandler;

    /**
     * Contains the service factory.
     *
     * @var ServiceFactoryInterface
     */
    private ServiceFactoryInterface $serviceFactory;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     * @param OutputHandlerInterface $outputHandler
     * @param ErrorHandlerInterface $errorHandler
     * @param ServiceFactoryInterface $serviceFactory
     */
    public function __construct(
        RouterInterface $router,
        OutputHandlerInterface $outputHandler,
        ErrorHandlerInterface $errorHandler,
        ServiceFactoryInterface $serviceFactory
    ) {
        $this->router = $router;
        $this->outputHandler = $outputHandler;
        $this->errorHandler = $errorHandler;
        $this->serviceFactory = $serviceFactory;
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
        $this->found = $this->router->accepts($input, $output);

        return $this->found;
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
        if (!$this->found) {
            $this->errorHandler->outputByCode(404);

            return;
        }

        try {
            $this->router->__invoke($input, $output);
            $endpoint = $this->getEndpoint($input);
            $endpoint($input, $output);
            $this->outputHandler->__invoke($input, $output);
        } catch (Throwable $exception) {
            $this->errorHandler->outputByException($exception);
        }
    }

    /**
     * Constructs and retrieves the endpoint.
     *
     * @param InputInterface $input
     *
     * @return EndpointInterface
     */
    private function getEndpoint(InputInterface $input): EndpointInterface
    {
        return $this->serviceFactory->create(
            $input->getParameter('endpoint'),
            $input->getParameters()
        );
    }
}
