# Development Setup

This project uses `docker-compose` to run the PHP backend, React frontend and Keycloak for authentication.

## Prerequisites

* [Docker](https://docs.docker.com/get-docker/) and [docker-compose](https://docs.docker.com/compose/install/) installed
* This repository cloned locally

## Running the stack

1. Build the containers and install dependencies:
   ```bash
   docker-compose build
   ```
2. Start all services in the background:
   ```bash
   docker-compose up -d
   ```
3. The React application will be served on <http://localhost:3000> and the PHP backend on <http://localhost:8080>.
4. Keycloak will be available on <http://localhost:8081/auth>.

## Building the React application

If you want to run the build manually (for example in CI):
```bash
docker-compose run --rm frontend npm run build
```
This will create production assets inside the `frontend/build` directory.

## Running the PHP backend

To start just the PHP service without the other containers:
```bash
docker-compose run --rm php
```
You can then reach the application at <http://localhost:8080> after the container starts.

## Accessing Keycloak

Keycloak is bundled as a service in `docker-compose.yml`. To open the admin console, visit:
```
http://localhost:8081/auth
```
Default credentials are set via environment variables in the compose file (e.g. `KEYCLOAK_USER`/`KEYCLOAK_PASSWORD`).

