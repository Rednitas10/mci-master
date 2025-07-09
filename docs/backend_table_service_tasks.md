# Backend Table Service Tasks

This document outlines tasks for building the backend API that will deliver table data to the React frontend using Flask.

- [x] Set up a basic Flask server in `flask_backend/app.py`.
- [x] Configure database connection using existing credentials.
- [x] Implement `/api/tables/<name>` route to return data for a given table query.
- [x] Wire up `table_service` with SQL queries pulled from the legacy PHP code.
- [x] Integrate authentication middleware to reuse the Keycloak setup (optional).
- [x] Add unit tests for service functions and routes.
- [x] Document API endpoints and expected payloads.

Each task can be completed independently. Focus first on reading from the legacy schema and returning JSON to the new React components.
