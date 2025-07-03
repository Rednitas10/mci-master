# Logserver

Sets up a central location to store and view logs. Container logs are persisted
to a named Docker volume so data is retained between runs.


## Setup

Copy the .env file default:

    cp default.env .env

Modify each newly copied env file as necessary. Lines that are not commented-out are required, commented lines are optional.

### Sending logs

Other services should send their log messages to the `LOG_SERVER_URL` environment variable. In the provided `docker-compose.yaml` the main `web` service forwards log events to `http://postgrest-internal:3000/events`.
