#!/bin/sh
# Dijalankan otomatis oleh entrypoint serversideup/php setiap container start.
# Migrasi TIDAK bisa dijalankan saat `docker build` karena database belum ada,
# jadi dijalankan di sini — tepat setelah container `db` healthy.
set -u

if [ "${RUN_MIGRATIONS:-true}" != "true" ]; then
    echo "[ruangai] migrate: di-skip (RUN_MIGRATIONS=${RUN_MIGRATIONS:-false})"
    exit 0
fi

cd /var/www/html || exit 0

echo "[ruangai] migrate: php spark migrate --all"
if php spark migrate --all; then
    echo "[ruangai] migrate: selesai"
else
    # Jangan hentikan container: error sudah tampil di log, app tetap bisa diakses.
    echo "[ruangai] migrate: GAGAL — cek log di atas (container tetap dijalankan)." >&2
fi

exit 0
