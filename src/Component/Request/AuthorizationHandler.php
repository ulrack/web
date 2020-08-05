<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Component\Request;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Exception\UnauthorizedException;
use Ulrack\Services\Common\ServiceFactoryInterface;
use Ulrack\Web\Common\Request\AuthorizationInterface;
use Ulrack\Web\Common\Request\AuthorizationHandlerInterface;
use Ulrack\Web\Common\Registry\AuthorizationRegistryInterface;

class AuthorizationHandler implements AuthorizationHandlerInterface
{
    /**
     * Contains the service factory.
     *
     * @var ServiceFactoryInterface
     */
    private $serviceFactory;

    /**
     * Contains the previously created authorization services.
     *
     * @var AuthorizationInterface[]
     */
    private $authorizers;

    /**
     * Contains the registered authorization services.
     *
     * @var AuthorizationRegistryInterface
     */
    private $registry;

    /**
     * Constructor.
     *
     * @param ServiceFactoryInterface $serviceFactory
     * @param AuthorizationRegistryInterface $registry
     */
    public function __construct(
        ServiceFactoryInterface $serviceFactory,
        AuthorizationRegistryInterface $registry
    ) {
        $this->serviceFactory = $serviceFactory;
        $this->registry = $registry;
    }

    /**
     * Checks whether the authorization passes.
     *
     * @param string[] $authorizationKeys
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    public function pass(
        array $authorizationKeys,
        InputInterface $input,
        OutputInterface $output
    ): bool {
        foreach ($authorizationKeys as $authorizationKey) {
            if (
                !$this->getAuthorizationByKey($authorizationKey)
                    ->isAllowed($input, $output)
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Retrieves the authorization instance by the configured key.
     *
     * @return AuthorizationInterface
     *
     * @throws UnauthorizedException When the authorization could not be found.
     */
    private function getAuthorizationByKey(string $key): AuthorizationInterface
    {
        if (!isset($this->authorizers[$key])) {
            if (!$this->registry->has($key)) {
                throw new UnauthorizedException(
                    'Misconfigured authorization detected'
                );
            }

            $this->authorizers[$key] = $this->serviceFactory->create(
                $this->registry->get($key)
            );
        }

        return $this->authorizers[$key];
    }
}
