# syntax=docker/dockerfile:1

###############################################################################
# RuangAI — CodeIgniter 4.6 + PHP 8.4 (FPM) + Nginx
#
# Base image: yllumi/fpm8.4-nginx
#   - turunan serversideup/php:8.4-fpm-nginx (S6 Overlay, non-root)
#   - document root default : /var/www/html/public  (cocok dengan public/index.php)
#   - nginx listen          : 8080 (HTTP) / 8443 (HTTPS)
#   - user runtime          : www-data (UID/GID 33)
#   - composer 2            : sudah tersedia
#   - ekstensi PHP          : intl, gd, mysqli, pdo_mysql, redis, zip, opcache, ...
#
# Catatan: image base hanya dipublikasikan untuk linux/amd64. Di host arm64
# (Apple Silicon) service `web` di docker-compose.yml memakai
# `platform: linux/amd64` sehingga berjalan lewat emulasi.
###############################################################################

FROM yllumi/fpm8.4-nginx:latest

# Build perlu root (composer + chown); proses runtime kembali ke www-data.
USER root

WORKDIR /var/www/html

# ---------------------------------------------------------------------------
# 1) Dependency — layer ini hanya di-invalidate kalau composer.json/lock berubah.
#    composer.lock* bersifat opsional karena file tersebut di-.gitignore.
# ---------------------------------------------------------------------------
COPY composer.json composer.lock* ./

RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --prefer-dist \
        --no-scripts \
        --no-autoloader

# ---------------------------------------------------------------------------
# 2) Source aplikasi (lihat .dockerignore untuk yang tidak ikut).
# ---------------------------------------------------------------------------
COPY . .

# Autoloader di-generate setelah source tersedia agar classmap App\ lengkap.
RUN composer dump-autoload --optimize --no-dev --no-scripts

# CodeIgniter membaca override config dari environment ($_ENV). Default PHP-FPM
# memakai variables_order=GPCS sehingga $_ENV kosong di worker; tambahkan "E".
# (Nama env ber-titik tetap dibuang PHP, jadi compose memakai bentuk underscore:
#  database_default_hostname, cache_handler, session_driver, dst.)
RUN printf 'variables_order = "EGPCS"\n' > /usr/local/etc/php/conf.d/zz-ruangai.ini

# Migrasi otomatis saat container start (bukan saat build: DB belum ada).
# Nonaktifkan dengan env RUN_MIGRATIONS=false.
# Catatan: sengaja tidak memakai `COPY --chmod` karena opsi itu butuh BuildKit.
COPY docker/entrypoint.d/50-ruangai-migrate.sh /etc/entrypoint.d/50-ruangai-migrate.sh
RUN chmod 0755 /etc/entrypoint.d/50-ruangai-migrate.sh

# ---------------------------------------------------------------------------
# 3) Direktori runtime harus writable oleh www-data.
#    writable/ juga di-bind-mount dari host melalui docker-compose.yml.
# ---------------------------------------------------------------------------
RUN mkdir -p \
        writable/cache \
        writable/logs \
        writable/session \
        writable/uploads \
        writable/debugbar \
        writable/certificates \
        public/vendor/heroic \
    && chown -R www-data:www-data writable public/vendor/heroic \
    && chmod -R ug+rwX writable public/vendor/heroic

USER www-data
