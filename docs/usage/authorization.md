# Ulrack Web - Authorization

Authorizations are defined through services, should implement the
[AuthorizationInterface](../../src/Common/Request/AuthorizationInterface.php)
and can be registered on routes and route groups. They're used to determine
whether a request is authorized or not. These implementations would perform
checks on sessions, API keys and the like.

The authorization needs to implement one method `isAllowed`. This will recieve
the same `$input` and `$output` as an endpoint. It must return `true` when the
authorization passes na `false` on failure.

## Further reading

[Back to usage index](index.md)

[Request codecs](request-codecs.md)

[Route group](route-group.md)

[Route](route.md)

[Error](error.md)

[Endpoint](endpoint.md)
