<?php

namespace Deployer;

require 'recipe/codeigniter4.php';

// Config

set('repository', 'git@github.com:codepolitanlab/ruangai.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
// Production
host('production')
    ->setHostname('app.ruangai.id')
    ->setRemoteUser('root')
    ->setDeployPath('/var/www/app.jagoansiber.com')
    ->set('branch', 'main');

// Staging
host('staging')
    ->setHostname('ruangai.cloudapp.web.id')
    ->setRemoteUser('root')
    ->setDeployPath('/var/www/jagoansiber.cloudapp.web.id')
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
