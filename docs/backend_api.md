# Backend API

The backend service exposes a small set of endpoints for retrieving table data used by the React frontend.

## `GET /api/tables/:name`

Returns up to 100 rows from the specified database table.

**Response**

```json
{
  "data": [
    {"id": 1, "...": "..."}
  ]
}
```

All endpoints require authentication if Keycloak configuration variables are provided.