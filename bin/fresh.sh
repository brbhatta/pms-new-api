#!/bin/bash

# Register .env file
export $(grep -v '^#' .env | xargs)

# Removing the "tenant_capcito_db" database
mysql -h $DB_HOST -u $DB_USERNAME -e "DROP DATABASE IF EXISTS pmsapi"

# Perform a fresh migration
php artisan migrate:fresh

# Seeding the central database
php artisan module:seed

printf "apikey:\n"

# Base64 encodes api key
printf $apiKey | base64 | tr -d '\n'

printf "\n\nDone, migrated, seeded and tenant created with api-key above \U2191\n"