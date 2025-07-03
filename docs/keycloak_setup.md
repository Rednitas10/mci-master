# Keycloak Setup

This repository includes a `docker-compose.yml` file with a Keycloak service
for local development. The container exposes Keycloak on port `8080` and uses
the official Keycloak image.

## Environment variables

The service reads the following environment variables which you can define in
an optional `.env` file or export in your shell:

```bash
KEYCLOAK_ADMIN=admin
KEYCLOAK_ADMIN_PASSWORD=changeme
KEYCLOAK_IMPORT=./keycloak/realm/example-realm.json
```

`KEYCLOAK_ADMIN` and `KEYCLOAK_ADMIN_PASSWORD` configure the initial
administrator account. `KEYCLOAK_IMPORT` points to a realm JSON file that will
be imported on start.

## Running Keycloak

1. Ensure Docker Compose is installed.
2. Adjust the environment variables if needed and place your realm configuration
   under `keycloak/realm/`.
3. Start the service:

```bash
docker compose up keycloak
```

After startup Keycloak will be available at `http://localhost:8080`. Log in with
the admin credentials you configured and verify that your realm is imported.
