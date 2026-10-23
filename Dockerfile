# syntax=docker/dockerfile:1

###############################################################################
# RuangAI — runtime image (PHP 8.4 FPM + Nginx)
#
# Image ini SENGAJA TIDAK memuat source code aplikasi. Yang di-bake hanya:
#   - dependency composer (vendor/) dari `composer install --no-dev`
#   - konfigurasi PHP (variables_order agar $_ENV terisi)
#   - script entrypoint (migrasi saat container start)
#   - direktori runtime kosong: writable/ dan mount point source
#
# Source aplikasi (app/, modules/, public/, spark) di-bind-mount dari host saat
# container berjalan — lihat docker-compose.yml. Konsekuensinya:
#   - perubahan kode tidak perlu rebuild image;
#   - rebuild hanya perlu ketika composer.json / composer.lock berubah.
#
# Base image: yllumi/fpm8.4-nginx
#   - turunan serversideup/php:8.4-fpm-nginx (S6 Overlay)
#   - document root default : /var/www/html/public  (cocok dengan public/index.php)
#   - nginx listen          : 8080 (HTTP) / 8443 (HTTPS)
#   - worker PHP-FPM        : diatur via PHP_FPM_CHILD_PROCESS_USER/GROUP (compose)
#   - composer 2            : sudah tersedia
#   - ekstensi PHP          : intl, gd, mysqli, pdo_mysql, redis, zip, opcache, ...
#
# Catatan: image base hanya dipublikasikan untuk linux/amd64. Di host arm64
# (Apple Silicon) service `web` di docker-compose.yml memakai
# `platform: linux/amd64` sehingga berjalan lewat emulasi.
###############################################################################

FROM yllumi/fpm8.4-nginx:latest

# Build perlu root (composer). Container juga tetap root saat runtime agar
# PHP-FPM bisa menurunkan worker ke UID/GID host (lihat bagian akhir file).
USER root

WORKDIR /var/www/html

# ---------------------------------------------------------------------------
# 1) Dependency — layer ini hanya di-invalidate kalau composer.json/lock berubah.
#    Source belum tersedia di sini, dan memang tidak diperlukan: autoloader tetap
#    dibuat, aturan PSR-4 (App\, Config\, Referral\) di-resolve saat runtime dari
#    source yang di-mount. `--no-autoloader` tidak dipakai agar autoloader tetap
#    ter-generate; `--no-scripts` dipakai karena script paket butuh source.
# ---------------------------------------------------------------------------
COPY composer.json composer.lock* ./

RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --prefer-dist \
        --no-scripts

# ---------------------------------------------------------------------------
# 2) Mount point source (kosong, hanya agar bind-mount punya target yang jelas)
#    dan direktori runtime yang dibutuhkan CodeIgniter.
# ---------------------------------------------------------------------------
RUN mkdir -p \
        app \
        modules \
        public \
        writable/cache \
        writable/logs \
        writable/session \
        writable/uploads \
        writable/debugbar \
        writable/certificates

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

# vendor/ hanya dibaca worker PHP; writable/ ditulis worker.
RUN chown -R www-data:www-data vendor writable \
    && chmod -R ug+rwX writable

# ---------------------------------------------------------------------------
# Container tetap berjalan sebagai root.
# Diperlukan agar PHP-FPM bisa menurunkan worker ke UID/GID host
# (PHP_FPM_CHILD_PROCESS_USER/GROUP di docker-compose.yml). Dengan begitu file
# yang ditulis aplikasi ke source yang di-mount — misalnya public/uploads/ —
# tetap dimiliki user host, bukan root/www-data.
# ---------------------------------------------------------------------------
USER root
