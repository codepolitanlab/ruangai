<?php

namespace Deployer;

require 'recipe/codeigniter4.php';

// Config

set('repository', 'git@github.com:codepolitanlab/ruangai.git');

add('shared_files', ['Caddyfile','php.ini']);
add('shared_dirs', []);
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

// Tasks
desc('Run heroic commands.');
task('spark:heroic:update', spark('heroic:update'));

/**
 * Main deploy task.
 */
desc('Deploys your project');
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'spark:optimize',
    'spark:migrate',
    'spark:heroic:update',
    'deploy:publish',
]);

// Hooks

after('deploy:failed', 'deploy:unlock');
