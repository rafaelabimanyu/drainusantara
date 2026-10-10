#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."

# Each run owns a fresh database and a user with privileges only on that database.
suffix=$(php -r 'echo bin2hex(random_bytes(6));')
export DB_DATABASE="drainusantara_test_${suffix}"
export DB_USERNAME="drain_test_${suffix}"
export DB_PASSWORD
DB_PASSWORD=$(php -r 'echo bin2hex(random_bytes(24));')
export DB_CONNECTION=mysql DB_HOST=localhost DB_PORT=3306 DB_SOCKET=/var/run/mysqld/mysqld.sock
export DB_URL='' DB_CHARSET=utf8mb4 DB_COLLATION=utf8mb4_unicode_ci APP_ENV=testing
export APP_CONFIG_CACHE="${TMPDIR:-$HOME/.cache}/drainusantara-no-config-${suffix}.php"
cleanup() {
    sudo -n mysql <<SQL
DROP DATABASE IF EXISTS \`${DB_DATABASE}\`;
DROP USER IF EXISTS '${DB_USERNAME}'@'localhost';
SQL
}
trap cleanup EXIT
sudo -n mysql <<SQL
CREATE DATABASE \`${DB_DATABASE}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER '${DB_USERNAME}'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';
GRANT ALL PRIVILEGES ON \`${DB_DATABASE}\`.* TO '${DB_USERNAME}'@'localhost';
SQL
printf 'Disposable MySQL database: %s\n' "$DB_DATABASE"
if (($# == 0)); then
    set -- tests/Feature/DatabaseValidationTest.php tests/MySql
fi
php vendor/bin/phpunit "$@"
