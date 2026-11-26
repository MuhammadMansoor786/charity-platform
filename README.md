# Charity Platform

## Current project structure

This repository is a server-rendered PHP/MySQL application at its root. It does
not currently contain separate `frontend` or `backend` directories, a React
application, or a FastAPI service. The database schema and seed data are in
[`charity_db.sql`](./charity_db.sql).

## Database configuration

The application reads these environment variables in `db_connect.php`:

| Variable | Default | Description |
| --- | --- | --- |
| `DB_HOST` | `localhost` | MySQL server hostname |
| `DB_PORT` | `3307` | MySQL server port (the existing XAMPP setup) |
| `DB_USER` | `root` | MySQL username |
| `DB_PASSWORD` | empty | MySQL password |
| `DB_NAME` | `charity_db` | Database name |
| `DB_SSL` | `false` | Set to `true` to require TLS |
| `DB_SSL_CA_FILE` | unset | Optional Aiven CA path; enables server-certificate verification when `DB_SSL=true` |

For Aiven, set the connection variables from the service's connection
information, set `DB_SSL=true`, and provide its CA certificate through
`DB_SSL_CA_FILE` to enable server-certificate verification. If the CA file is
omitted, the connection still requires TLS but cannot verify the server
certificate. Prefer configuring the CA file in production. Keep credentials
and the CA file out of source control; configure them in the hosting provider's
environment/secrets settings.

The checked-in `charity_db.sql` file contains both the schema and sample records.
Review its data before importing it into a production database.

## Hosting note

This application serves PHP pages directly; it does not make browser-to-API
requests and has no frontend build to publish on Netlify. It therefore cannot
use the requested Netlify + FastAPI/Render split without an architectural
migration. The root `Dockerfile` provides PHP 8.2 with Apache and the `mysqli`
and `pdo_mysql` extensions, enables Apache rewrite, and configures Apache to
listen on Render's `PORT` (defaulting to 80). Configure the database variables
above in Render.