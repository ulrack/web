# Ulrack Web - Routers

Routers are used to determine which endpoint should be invoked for a request.
They are described by the [RouterInterface](../../src/Common/Router/RouterInterface.php).

Routers have two required methods. `accepts` is to check whether the route
would be able to resolve the request. The `__invoke` method is called when the
router is chosen to determine the request. A router which would accept every
request and resolve to the same endpoint would be:

```php
<?php

namespace MyProject\MyPackage\Component\Router;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Router\RouterInterface

class MyRouter implements RouterInterface
{
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
        return true;
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
        $input->setParameter('endpoint', 'services.my-endpoint');
    }
}

```

Endpoints must be set on the input by calling
```php
$input->setParameter('endpoint', 'services.my-endpoint');
```

Where `'services.my-endpoint'` should be replaced with a service reference that
resolves to a service implementing the `EndpointInterface`. Additional
parameters can also be set in the `$input` and can be used as `{@template.*}`
references for the service creation.

This package supplies a few basic routers:
- [BaseRouter](../../src/Component/Router/BaseRouter.php) This router should be
used as a root router, because it handles all output related tasks.
- [MiddlewareRouter](../../src/Component/Router/MiddlewareRouter.php) This
router can be used to implement middleware for another router. It will perform
the checks on the middleware during the `__invoke` or `accepts` method
invocation. When those checks fail in `__invoke` a `HttpException` will be
thrown, resulting in a standard error.
- [RouterAggregate](../../src/Component/Router/RouterAggregate.php) This router
can be used to pass multiple routers in, which will be iterated over and
checked. It is recommended to pass an instance of this router to the
`BaseRouter` to allow multiple other routers to handle requests.

## Further reading

[Back to usage index](index.md)

[Request codecs](request-codecs.md)

[Error](error.md)

[Endpoint](endpoint.md)

[Middleware](middleware.md)
