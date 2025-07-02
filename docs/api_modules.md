# API Isolation Candidates

The legacy `app/` directory contains multiple CakePHP controllers and models. The following areas can be separated behind RESTful APIs or services:

- **Event management** – `EventsController`, `Event` model, and related components handle creation, upload, and review of events.
- **Criteria management** – `CriteriasController` and `Criteria` model maintain definitions for coded criteria.
- **Solicitations** – `SolicitationsController` and `Solicitation` model send requests and track responses.
- **User management** – `UsersController` and `User` model handle authentication and roles.
- **Patient records** – `Patient` model contains patient information referenced by events.
- **Review and derived data** – `Review` and `EventDerivedData` models store reviewer input and calculated fields.

Isolating these domains behind APIs would allow them to be consumed by a modern PHP or JavaScript front end and enable gradual migration off the CakePHP stack.
