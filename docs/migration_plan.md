# Database Migration Plan

This document outlines how to migrate the existing CakePHP database schema to a new MariaDB container.

## 1. Current CakePHP Schema

The application uses the configuration file `app/config/database.php` (not tracked in version control).  The default template shows a MySQL based setup:

```php
'driver' => 'mysql',
'persistent' => false,
'host' => 'localhost',
'login' => 'user',
'password' => 'password',
'database' => 'database_name',
'prefix' => '',
```

Additional tables for ACL, i18n and sessions are provided in `app/config/sql/`.

The repository includes example SQL schemas under `app/config/sql/` and a dump used for tests (`app/tests/cnics-mci_test.test_event_derived_datas.schema.sql`).  These files can serve as references when building migration scripts.

## 2. Choosing a Migration Tool

[Phinx](https://phinx.org/) is a lightweight PHP migration tool that integrates well with legacy CakePHP applications. It allows incremental migrations to be written in PHP and executed via the command line.

To install Phinx with Composer:

```bash
composer require robmorgan/phinx
```

Initialize Phinx in the project root:

```bash
vendor/bin/phinx init
```

Update `phinx.php` with your database credentials.

## 3. Exporting the Old Database

From the server hosting the existing MySQL/MariaDB instance, create a dump:

```bash
mysqldump -u <user> -p<password> --databases <dbname> > old_db.sql
```

Copy `old_db.sql` into the new environment.

## 4. Importing into the New MariaDB Container

Assuming the container is named `mariadb` and the dump file is `old_db.sql` in the current directory:

```bash
docker cp old_db.sql mariadb:/tmp/old_db.sql
docker exec -it mariadb bash -c 'mysql -u <user> -p<password> <dbname> < /tmp/old_db.sql'
```

## 5. Incremental Schema Updates

Phinx migrations can be created for each schema change:

```bash
vendor/bin/phinx create AddNewTable
```

Edit the generated migration file under `db/migrations/` to define `up()` and `down()` methods.

Run migrations:

```bash
vendor/bin/phinx migrate
```

This approach allows future schema changes to be version controlled and applied consistently across environments.
