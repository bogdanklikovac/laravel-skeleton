<?php

namespace Deployer;

require 'recipe/laravel.php';

set('bin/php', '/usr/bin/php8.1');

set('bin/composer', function () {
    $composer = locateBinaryPath('composer');

    return '{{bin/php}} '.$composer;
});

set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader');

inventory('./servers.yml');

// Project name
set('application', 'Q Laravel Skeleton');

// Project repository
set('repository', 'git@gitlab.q-software.com:qalliance/laravel-skeleton.git');

// Set default branch
set('branch', 'development');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys
add('shared_files', ['.env']);
add('shared_dirs', ['storage']);

// Writable dirs by web server
add('writable_dirs', ['storage', 'storage/app', 'storage/framework', 'storage/logs']);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Tasks

desc('Deploy project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:cache:clear',
    'artisan:config:cache',
    'artisan:route:cache',
    'deploy:writable',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);
