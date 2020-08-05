# Ulrack Web - Endpoint

Endpoints are defined as services and connected to routes. They perform the
actual logic for an endpoint. They must implement the
[EndpointInterface](../../src/Common/Endpoint/EndpointInterface.php).

An implementation of an endpoint looks like the following:
```php
<?php

namespace MyVendor\MyProject;

use Ulrack\Web\Common\Endpoint\InputInterface;
use Ulrack\Web\Common\Endpoint\OutputInterface;
use Ulrack\Web\Common\Endpoint\EndpointInterface;

class EndpointTest implements EndpointInterface
{
    /**
     * Invokes the endpoint.
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
        $output->setContentType('application/json');
        $output->setOutput($output->getAcceptedContentTypes());
    }
}
```

The `$input` the information sent with the incoming request.
The `$output` contains a set of methods to manipulate the output for the
response.

## Further reading

[Back to usage index](index.md)

[Request codecs](request-codecs.md)

[Route group](route-group.md)

[Route](route.md)

[Error](error.md)

[Authorization](authorization.md)
