# Backend Table Service Tasks

This document outlines tasks for building the backend API that will deliver table data to the React frontend.

- [ ] Set up basic Express server in `backend/src/index.js`.
- [ ] Configure database connection using existing credentials.
- [ ] Implement `/api/tables/:name` route in `backend/routes/tables.js` to return data for a given table query.
- [ ] Wire up `tableService` with SQL queries pulled from the legacy PHP code.
- [ ] Integrate authentication middleware to reuse the Keycloak setup.
- [ ] Add unit tests for service functions and routes.
- [ ] Document API endpoints and expected payloads.

Each task can be completed independently. Focus first on reading from the legacy schema and returning JSON to the new React components.
