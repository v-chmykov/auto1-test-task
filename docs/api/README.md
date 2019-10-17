# API calls

## Endpoints

* [Show list of positions](positions.md) : `GET /v1/positions/`
* [Show a single position](meta.md) : `GET /v1/positions/:id/`
* [Show most interesting positions by skills](list.md) : `GET /v1/positions/most_interesting`

## Errors

When errors occur the server responds with appropriate HTTP-code and payload. All payload has the same format.

For example:

```json
{
    "desciption":"Skills not provided"
}
```

[Back](../../README.md)
