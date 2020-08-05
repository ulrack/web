<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Router;

use Ulrack\Web\Exception\NotFoundException;
use Ulrack\Web\Common\Router\RouterInterface;
use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Exception\UnauthorizedException;
use Ulrack\Web\Common\Router\RouteGroupInterface;
use Ulrack\Web\Common\Error\ErrorHandlerInterface;
use Ulrack\Web\Common\Router\PathMatcherInterface;
use Ulrack\Services\Common\ServiceFactoryInterface;
use Ulrack\Web\Common\Output\OutputHandlerInterface;
use Ulrack\Web\Common\Request\AuthorizationHandlerInterface;

class GroupRouter implements RouterInterface
{
    /**
     * Contains the route group registry.
     *
     * @var RouteGroupInterface[]
     */
    private $routeGroups;

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
     * Contains the default error registry.
     *
     * @var ErrorHandlerInterface
     */
    private $errorHandler;

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
     * Constructor.
     *
     * @param ErrorHandlerInterface $errorHandler
     * @param OutputHandler $outputHandler
     * @param ServiceFactoryInterface $serviceFactory
     * @param AuthorizationHandlerInterface $authorizationHandler
     * @param PathMatcherInterface $pathMatcher
     * @param RouteGroupInterface ...$routeGroups
     */
    public function __construct(
        ErrorHandlerInterface $errorHandler,
        OutputHandlerInterface $outputHandler,
        ServiceFactoryInterface $serviceFactory,
        AuthorizationHandlerInterface $authorizationHandler,
        PathMatcherInterface $pathMatcher,
        RouteGroupInterface ...$routeGroups
    ) {
        $this->errorHandler = $errorHandler;
        $this->outputHandler = $outputHandler;
        $this->serviceFactory = $serviceFactory;
        $this->authorizationHandler = $authorizationHandler;
        $this->pathMatcher = $pathMatcher;
        $this->routeGroups = $routeGroups;
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
        $this->errorHandler->setOutputHandler($this->outputHandler);
        $uri = $input->getRequest()->getUri();
        foreach ($this->routeGroups as $routeGroup) {
            if (!in_array($uri->getPort(), $routeGroup->getPorts())) {
                continue;
            }

            foreach ($routeGroup->getHosts() as $host) {
                if (fnmatch($host, $uri->getHost())) {
                    $this->errorHandler->setErrorRegistry(
                        $this->serviceFactory->create(
                            $routeGroup->getErrorRegistryService()
                        )
                    );

                    if (
                        !$this->authorizationHandler->pass(
                            $routeGroup->getAuthorizations(),
                            $input,
                            $output
                        )
                    ) {
                        throw new UnauthorizedException('Unauthorized');
                    }

                    (new Router(
                        $this->errorHandler,
                        $this->outputHandler,
                        $this->serviceFactory,
                        $this->authorizationHandler,
                        $routeGroup->getRoute(),
                        $this->pathMatcher
                    ))($input, $output);

                    return;
                }
            }

            continue;
        }

        throw new NotFoundException('Domain could not be resolved.');
    }
}
