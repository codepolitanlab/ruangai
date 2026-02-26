<?php

namespace Deployer;

require 'recipe/codeigniter4.php';

// Config

set('repository', 'git@github.com:codepolitanlab/ruangai.git');

add('shared_files', ['Caddyfile','php.ini']);
add('shared_dirs', ['public/certificates']);
add('writable_dirs', []);

// Hosts
// Production
host('production')
    ->setHostname('ruangai-staging.appdata.id')
    ->setRemoteUser('root')
    ->setDeployPath('/var/www/ruangai.codepolitan.com')
    ->set('branch', 'main');

// Staging
host('staging')
    ->setHostname('ruangai-staging.appdata.id')
    ->setRemoteUser('root')
    ->setDeployPath('/var/www/ruangai-staging.appdata.id')
    ->set('branch', 'dev');

// Custom Tasks
desc('Update heroic settings');
task('spark:heroic:update', function () {
    run('{{bin/php}} {{release_path}}/spark heroic:update');
});

/**
 * Hooks: Mengatur urutan task tanpa merusak flow asli CI4 recipe
 */

// Jalankan migrasi setelah vendor terinstall
after('deploy:vendors', 'spark:migrate');

// Jalankan update heroic setelah migrasi selesai
after('spark:migrate', 'spark:heroic:update');

// Pastikan symlink diperbarui dan cache dioptimasi di akhir
after('deploy:publish', 'spark:optimize');

// Unlock jika gagal agar tidak nyangkut saat deploy berikutnya
after('deploy:failed', 'deploy:unlock');