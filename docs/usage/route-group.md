# Ulrack Web - Route group

A route group defines the initial connection to the application. This is handled
through the services layer.

An example definition looks like the following:
```json
{
    "main": {
        "ports": [
            80,
            443
        ],
        "hosts": [
            "*.example.com*"
        ],
        "route": "main-home",
        "errorRegistryService": "services.web.errors.default.api.registry"
    }
}
```

The `ports` node defines which ports are open to the route group. The `hosts`
node defines which URL's should be routed to the route group. The `route` node
defines the default route of the route group. The `errorRegistryService` node
defines which service is used to retrieve the error registry. The optional
`authorizations` node defines a list of authorization services used  to verify
the authority of the request. The optional `weight` node defines the order in
which route groups are routed.

## Further reading

[Back to usage index](index.md)

[Request codecs](request-codecs.md)

[Route](route.md)

[Error](error.md)

[Authorization](authorization.md)

[Endpoint](endpoint.md)
