# Docker Compose Setup

This project can be run locally or in production using Docker Compose. The
`docker-compose.yml` file provides a base configuration for running the web
application alongside a database. Environments may layer overrides using
`docker-compose.override.yml` files or by supplying a custom Compose file via the
`-f` flag.

## Environment-specific Overrides

1. **Local Development**
   - Copy `docker-compose.yml` to `docker-compose.override.yml` and adjust ports
     or volumes as needed.
   - Use an `.env` file to define variables such as `DB_HOST` or `APP_DEBUG`.
   - Mount local source directories for live code editing.

2. **Staging/Production**
   - Provide a separate override file (for example
     `docker-compose.prod.yml`) with production settings:
       - Bind public ports to the host or a load balancer.
       - Disable debugging and use production database credentials.
   - Store sensitive values such as database passwords in environment variables
     or a secrets manager rather than committing them to version control.

Compose will merge multiple files so you can execute:

```bash
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

## Persistent Storage

Containers are ephemeral. To retain uploaded charts and other persistent data,
mount host directories or volumes:

```yaml
services:
  web:
    volumes:
      - ./chartUploads:/var/www/app/chartUploads
      - ./storage:/var/www/app/storage
```

Be sure to back up these directories regularly.

## SSL Termination

Compose deployments typically sit behind a reverse proxy or ingress controller.
Handle TLS termination at that layer (e.g., nginx, Traefik, or an ELB) and proxy
traffic to the container over HTTP. This keeps the container configuration
simple and allows certificates to be managed separately.

## Scaling Considerations

If you expect higher load, you can increase the number of `web` service
containers and place them behind a load balancer. Database containers should use
an external volume so data persists across restarts. For advanced scaling you
may also consider moving the database to a managed service.

## Migrating From Legacy Deployment

The previous deployment installed the application directly into
`/srv/www/$FQDN/htdocs/mci`. To migrate:

1. Build the container image using the existing source tree.
2. Configure the new `docker-compose.yml` to mount any directories that held
   persistent data in the legacy setup (for example, `chartUploads`).
3. Update any web server or DNS configurations to point to the new container
   host or load balancer rather than the old path.
4. Decommission the legacy directory once the container stack is verified.

The container-based approach improves portability and simplifies future scaling
and maintenance.

