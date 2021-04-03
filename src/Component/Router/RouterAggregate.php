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

class RouterAggregate implements RouterInterface
{
    /**
     * Contains the routers.
     *
     * @var RouterInterface[]
     */
    private array $routers;

    /**
     * Contains the last accepted router.
     *
     * @var RouterInterface|null
     */
    private ?RouterInterface $lastAccepted = null;

    /**
     * Constructor.
     *
     * @param RouterInterface ...$routers
     */
    public function __construct(RouterInterface ...$routers)
    {
        $this->routers = $routers;
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
        foreach ($this->routers as $router) {
            if ($router->accepts($input, $output)) {
                $this->lastAccepted = $router;
                return true;
            }
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
     *
     * @throws NotFoundException When none of the routers accept the request.
     */
    public function __invoke(
        InputInterface $input,
        OutputInterface $output
    ): void {
        if ($this->lastAccepted !== null) {
            $this->lastAccepted->__invoke($input, $output);

            return;
        }

        throw new NotFoundException();
    }
}
