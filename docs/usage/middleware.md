# Ulrack Web - Middleware

Middleware is used to perform additional checks in routers.
Middleware implements the [MiddlewareInterface](../../src/Common/Middleware/MiddlewareInterface.php).
It uses two methods for this validation, one is to perform the check, and the
other one is used for formulating the correct response.
An example middleware which does a check for a header would be:

```php
<?php

namespace MyProject\MyPackage\Component\Middleware;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Middleware\MiddlewareInterface;

class HeaderCheckingMiddleware implements MiddlewareInterface
{
    /**
     * Retrieves the error code for the middleware if it does not pass.
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return 401;
    }

    /**
     * Performs additional checks on the route.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    public function pass(
        InputInterface $input,
        OutputInterface $output
    ): bool {
        $request = $input->getRequest();

        if (
            $request->hasHeader('Authorization') &&
            $request->getHeader('Authorization') === 'my-auth-code'
        ) {
            return true;
        }

        return false;
    }
}

```

This middleware could then be used in a
[MiddlewareRouter](../../src/Component/Router/MiddlewareRouter.php) to perform
the check when a request is made to another router.

The following implementations for middleware are provided in this package:
- [HostMatchingMiddleware](../../src/Component/Middleware/HostMatchingMiddleware.php)
for matching the host of a request to one or multiple patterns.
- [MethodMatchingMiddleware](../../src/Component/Middleware/MethodMatchingMiddleware.php)
for checking the method of a request.
- [PathMatchingMiddleware](../../src/Component/Middleware/PathMatchingMiddleware.php)
for checking a path to a pattern/route. It supports wildcards with names e.g.
`users/{userId}`. When the path matches, the `userId` is stored in the input.
- [PortMatchingMiddleware](../../src/Component/Middleware/PortMatchingMiddleware.php)
for checking the port of a request.
- [MiddlewareAggregate](../../src/Component/Middleware/MiddlewareAggregate.php)
for chaining multiple middlewares together to put in one MiddlewareRouter.

## Further reading

[Back to usage index](index.md)

[Request codecs](request-codecs.md)

[Error](error.md)

[Endpoint](endpoint.md)

[Routers](routers.md)
