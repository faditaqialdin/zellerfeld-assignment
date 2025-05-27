# Zellerfeld Assignment - Twitter Clone

> For full API documentation, refer to the api-level `api/README.md`.
>

## Getting started

This project make use of Docker Compose.

1. Install the project:

```
make install
```

2. Start up containers:

```
make start
```

3. After successful launch the frontend should be accessible at [http://localhost:3000](http://localhost:3000) and the
   backend docs should be accessible at [http://localhost:8000/api/docs](http://localhost:8000/api/docs).

Run phpunit tests by executing the following:

```
make test
```

See the logs:

```
make logs
```

Seed db for testing purposes:

```
make seed
```

Shut down containers:

```
make stop
```

## Thank you!
