<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Router;

use InvalidArgumentException;
use Ulrack\Web\Exception\NotFoundException;
use Ulrack\Web\Common\Router\RouteInterface;
use Ulrack\Web\Common\Router\RouterInterface;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Exception\UnauthorizedException;
use Ulrack\Web\Common\Endpoint\EndpointInterface;
use Ulrack\Web\Common\Error\ErrorHandlerInterface;
use Ulrack\Web\Common\Router\PathMatcherInterface;
use Ulrack\Services\Common\ServiceFactoryInterface;
use Ulrack\Web\Exception\MethodNotAllowedException;
use Ulrack\Web\Common\Output\OutputHandlerInterface;
use Ulrack\Web\Common\Request\AuthorizationHandlerInterface;

class Router implements RouterInterface
{
    /**
     * Contains the route groups.
     *
     * @var RouteInterface
     */
    private $route;

    /**
     * Contains the service factory.
     *
     * @var ServiceFactoryInterface
     */
    private $serviceFactory;

    /**
     * Contains the output handler.
     *
     * @var OutputHandlerInterface
     */
    private $outputHandler;

    /**
     * Contains the authorization handler.
     *
     * @var AuthorizationHandlerInterface
     */
    private $authorizationHandler;

    /**
     * Contains the path matcher.
     *
     * @var PathMatcherInterface
     */
    private $pathMatcher;

    /**
     * Contains the error handler.
     *
     * @var ErrorHandlerInterface
     */
    private $errorHandler;

    /**
     * Constructor.
     *
     * @param ErrorHandlerInterface $errorHandler
     * @param OutputHandlerInterface $outputHandler
     * @param ServiceFactoryInterface $serviceFactory
     * @param AuthorizationHandlerInterface $authorizationHandler
     * @param RouteInterface $routeGroup
     * @param PathMatcherInterface $pathMatcher
     */
    public function __construct(
        ErrorHandlerInterface $errorHandler,
        OutputHandlerInterface $outputHandler,
        ServiceFactoryInterface $serviceFactory,
        AuthorizationHandlerInterface $authorizationHandler,
        RouteInterface $route,
        PathMatcherInterface $pathMatcher
    ) {
        $this->errorHandler = $errorHandler;
        $this->outputHandler = $outputHandler;
        $this->serviceFactory = $serviceFactory;
        $this->authorizationHandler = $authorizationHandler;
        $this->route = $route;
        $this->pathMatcher = $pathMatcher;
    }

    /**
     * Resolves the request to an endpoint, executes it and renders the response.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     *
     * @throws NotFoundException When none of the endpoints matches the request.
     */
    public function __invoke(
        InputInterface $input,
        OutputInterface $output
    ): void {
        if (
            $this->executeRoute(
                $this->route,
                $input,
                $output,
                sprintf(
                    '%s/',
                    trim($input->getRequest()->getUri()->getPath(), '/')
                )
            ) === false
        ) {
            throw new NotFoundException('Endpoint could not be resolved.');
        }
    }

    /**
     * Determines whether the route can be executed and then executes it.
     *
     * @param RouteInterface $route
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param string $normalizedPath
     * @param string $outputHandler
     * @param string $errorRegistry
     * @param array $parameters
     *
     * @return bool
     */
    private function executeRoute(
        RouteInterface $route,
        InputInterface $input,
        OutputInterface $output,
        string $normalizedPath,
        string $outputHandler = '',
        string $errorRegistry = '',
        array $parameters = []
    ): bool {
        $matchInfo = $this->pathMatcher->__invoke($route, $normalizedPath);
        if ($matchInfo === null) {
            return false;
        }

        $normalizedPath = $matchInfo['path'];
        $parameters = array_merge($parameters, $matchInfo['parameters']);

        $outputHandler = $route->getOutputHandlerService()
            ?? $outputHandler;

        $errorRegistry = $route->getErrorRegistryService()
            ?? $errorRegistry;

        if ($normalizedPath === '') {
            $this->setParameters($parameters, $input);

            $outputHandlerService = $this->outputHandler;
            if ($outputHandler !== '') {
                /** @var OutputHandlerInterface $outputHandlerService */
                $outputHandlerService = $this->serviceFactory->create(
                    $outputHandler
                );

                $this->errorHandler->setOutputHandler($outputHandlerService);
            }

            if ($errorRegistry !== '') {
                $this->errorHandler->setErrorRegistry(
                    $this->serviceFactory->create(
                        $errorRegistry
                    )
                );
            }

            $this->preExecutionChecks($input, $output, $route);

            /** @var EndpointInterface $endpoint */
            $endpoint = $this->serviceFactory->create($route->getService());

            if (!is_a($endpoint, EndpointInterface::class)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Service %s must be of type %s',
                        $route->getService(),
                        EndpointInterface::class
                    )
                );
            }

            $endpoint($input, $output);
            $outputHandlerService($input, $output);

            return true;
        }

        foreach ($route->getRoutes() as $subRoute) {
            $result = $this->executeRoute(
                $subRoute,
                $input,
                $output,
                $normalizedPath,
                $outputHandler,
                $errorRegistry,
                $parameters
            );
        }

        return $result ?? false;
    }

    /**
     * Sets the parameters on the input.
     *
     * @param array $parameters
     * @param InputInterface $input
     *
     * @return void
     */
    private function setParameters(
        array $parameters,
        InputInterface $input
    ): void {
        foreach ($parameters as $key => $value) {
            $input->setParameter($key, $value);
        }
    }

    /**
     * Executes the pre-execution checks and throws an error if something is incorrect.
     *
     * @param InputInterface $input
     * @param RouteInterface $route
     *
     * @return void
     *
     * @throws MethodNotAllowedException When the method is not allowed.
     * @throws UnauthorizedException When the authorization fails.
     */
    private function preExecutionChecks(
        InputInterface $input,
        OutputInterface $output,
        RouteInterface $route
    ): void {
        if (
            !in_array(
                $input->getRequest()->getMethod(),
                $route->getMethods()
            )
        ) {
            throw new MethodNotAllowedException('Method Not Allowed');
        }

        if (
            !$this->authorizationHandler->pass(
                $route->getAuthorizations(),
                $input,
                $output
            )
        ) {
            throw new UnauthorizedException('Unauthorized');
        }
    }
}
