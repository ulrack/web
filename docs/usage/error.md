# Ulrack Web - Error

Errors are defined as services and are used to display the correct output per
error type. The must implement the
[ErrorInterface](../../src/Common/Error/ErrorInterface.php). The errors are
registered to an error registry.

Two classes are provided by default which can be fully configured through
services. These are
[ConfigurableApiError](../../src/Component/Error/ConfigurableApiError.php) and
[ConfigurablePlainError](../../src/Component/Error/ConfigurablePlainError.php).

A definition for an error looks like the following:
```json
{
    "services": {
        "web.errors.default.api.400": {
            "class": "\\Ulrack\\Web\\Component\\Error\\ConfigurableApiError",
            "parameters": {
                "errorStatusCode": 400,
                "errorMessage": "Bad Request"
            }
        }
    }
}
```

## Further reading

[Back to usage index](index.md)

[Request codecs](request-codecs.md)

[Endpoint](endpoint.md)

[Middleware](middleware.md)

[Routers](routers.md)
