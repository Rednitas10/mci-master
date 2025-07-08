# Backend Table Service Tasks

This document outlines tasks for building the backend API that will deliver table data to the React frontend.

- [x] Set up basic Express server in `backend/src/index.js`.
- [x] Configure database connection using existing credentials.
- [x] Implement `/api/tables/:name` route in `backend/routes/tables.js` to return data for a given table query.
- [x] Wire up `tableService` with SQL queries pulled from the legacy PHP code.
- [x] Integrate authentication middleware to reuse the Keycloak setup.
- [x] Add unit tests for service functions and routes.
- [x] Document API endpoints and expected payloads.

Each task can be completed independently. Focus first on reading from the legacy schema and returning JSON to the new React components.
