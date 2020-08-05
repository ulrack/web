# Ulrack Web - Route group

A route defines the path of an endpoint and sub-routes.
It is described by the `route.schema.json` schema.

An example definition looks like the following:
```json
{
    "$schema": "route.schema.json",
    "key": "main-home",
    "path": "/",
    "service": "services.main-home-endpoint",
    "methods": [
        "GET"
    ],
    "outputService": "services.web.handler.output"
}
```

The `key` node defines the reference of the route. The `path` node defines the
path to the endpoint. The `service` node defines the service which is
constructed and is expected to return an implementation of the
[EndpointInterface](../../src/Common/Endpoint/EndpointInterface.php). The
`methods` node defines which methods are accepted for the endpoint. The
`outputService` defines which service is used to handle the output of the
endpoint. This output service is inherited by the children of the route if it
is not defined. The optional `authorizations` node defines a list of
authorization services used to verify the authority of the request. The optional
`errorRegistryService` node defines the error registry service for the route. If
it is not defined, the service from the route group is used. The optional
`parent` defines the parent route of the defined route. When a route is
classified as a sub-route it will extend its' parent `path`.

## Further reading

[Back to usage index](index.md)

[Request codecs](request-codecs.md)

[Route group](route-group.md)

[Error](error.md)

[Authorization](authorization.md)

[Endpoint](endpoint.md)
