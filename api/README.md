# Zellerfeld Assignment - Twitter Clone API

This is the backend API for the **Zellerfeld Assignment - Twitter Clone**, located in the `/api` directory of the
project. Built using **Laravel**, this API implements a clean, scalable, and testable architecture that merges Laravel
conventions with **Domain-Driven Design (DDD)** principles. It demonstrates the application of SOLID principles, RESTful
best practices, and modern Laravel development practices.

> For full installation and project bootstrapping instructions, refer to the root-level `README.md`.

## Getting started - API only

```
composer install

composer run dev
```

---

## Architecture Overview

This project blends **Laravel’s elegant developer experience** with a DDD-inspired structure for improved modularity and
maintainability:

- **Repositories (Interfaces):** Abstract the data layer, promoting easy testability and dependency inversion.
- **Services (eg. AuthService):** Handle business logic, separated cleanly from controllers and infrastructure.
- **Domain Models and Laravel Models.**
- **Controllers:** Slim, only delegate responsibilities to services or repositories. No business rules here.

This layered structure ensures **Separation of Concerns**, testability, and code reusability.

---

## Authentication and Authorization

- **Authentication:** Laravel Sanctum is used to secure API endpoints via token-based auth.
- **Authorization:** Only one authorization is needed, which is checking whether a user can add post to other user's
  profile. This is created intentionally this way to demonstrate resource authorization.
- **Validation:** Leveraging Laravel's Form Requests for input validation.

---

## RESTful API Best Practices

- **Resource-Oriented Controllers:** Example: `UserController`, `PostController`, and `UserPostController`.
- **Route Naming and Grouping:** All routes are versioned (`/api/v1`) and grouped by resource.

This consistency ensures clarity and interoperability across frontends or third-party clients.

---

## Testing

- **Unit Tests:** Target services and domain logic in isolation.
- **Feature Tests:** Validate endpoint behavior and expected system outcomes.

Run tests via:

```bash
php artisan test
````

---

## Swagger UI and OpenAPI

All routes are documented via **Swagger/OpenAPI**. To view interactive documentation:

Visit: [http://localhost:8000/api/docs](http://localhost:8000/api/docs)

---

## On Avoiding Over-Engineering

While this project favors simplicity for clarity, on larger-scale projects I would adopt **Hexagonal Architecture**,
cleanly dividing:

* **Application (CQRS)**: Command and Query handlers.
* **Domain**: Rich domain models and aggregates.
* **Infrastructure**: DB, cache, mail, external APIs.

This approach decouples concerns and enhances testing.

