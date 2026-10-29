#!/bin/sh
# Dijalankan otomatis oleh entrypoint serversideup/php setiap container start.
# Migrasi TIDAK bisa dijalankan saat `docker build` karena database belum ada,
# jadi dijalankan di sini — tepat setelah container `db` healthy.
set -u

cd /var/www/html || exit 0

# Container berjalan sebagai root, sedangkan worker PHP-FPM memakai UID/GID host
# (PHP_FPM_CHILD_PROCESS_USER/GROUP). Samakan kepemilikan volume writable/ dengan
# user tersebut dan jalankan spark sebagai user yang sama, agar file cache/log
# yang dibuat saat migrasi tidak tertinggal sebagai root.
php_user="${PHP_FPM_CHILD_PROCESS_USER:-www-data}"
php_group="${PHP_FPM_CHILD_PROCESS_GROUP:-$php_user}"

if [ "$(id -u)" = "0" ]; then
    chown -R "$php_user:$php_group" writable 2>/dev/null || true

    run_as_php() {
        setpriv --reuid="$php_user" --regid="$php_group" --clear-groups -- "$@"
    }
else
    run_as_php() {
        "$@"
    }
fi

if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "[ruangai] migrate: php spark migrate --all (user: ${php_user})"
    if run_as_php php spark migrate --all; then
        echo "[ruangai] migrate: selesai"
    else
        # Jangan hentikan container: error sudah tampil di log, app tetap bisa diakses.
        echo "[ruangai] migrate: GAGAL — cek log di atas (container tetap dijalankan)." >&2
    fi
else
    echo "[ruangai] migrate: di-skip (RUN_MIGRATIONS=${RUN_MIGRATIONS:-false})"
fi

echo "[ruangai] heroic:update: php spark heroic:update (user: ${php_user})"
if ! run_as_php php spark heroic:update; then
    echo "[ruangai] heroic:update: GAGAL — aset Heroic tidak berhasil diperbarui." >&2
    exit 1
fi

exit 0
