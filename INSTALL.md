# INSTALL

## REQUIREMENTS

The application is build on the following stack:

- PHP 7.4
- PostgreSQL 12.6

You will need following PHP modules:

- php-xml
- php-json
- php-pgsql

The recommended webserver is Apache2.

## INSTALLATION

Clone the repository into your webroot. Create a database for the application. Import init.sql into your newly created database. Set following environment variables to configure the database connection for the application: `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWD`.
If you are using Apache2 you can set the environment variables by adding this to your VHost configuration:

```
    # Set env vars
    SetEnv DB_HOST 'host'
    SetEnv DB_NAME 'databasename'
    SetEnv DB_USER 'username'
    SetEnv DB_PASSWD 'password'
```
