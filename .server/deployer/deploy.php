<?php
declare(strict_types=1);

namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

require 'recipe/laravel.php';
require 'recipe/slack.php';

# -----------------------------------------------------------
# Configurate

set('application', 'ec2-52-198-195-60.ap-northeast-1.compute.amazonaws.com');
set('repository', 'git@github.com:/takenyan-tech/laravel-sns-tutorial-api.git');
set('git_tty', true);

add('shared_files', []);
add('shared_dirs', ['vendor']);
add('writable_dirs', ['bootstrap/cache', 'storage']);

set('slack_webhook', 'https://hooks.slack.com/services/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');

# -----------------------------------------------------------
# Hosts

host('52.198.195.60')
    ->set('deploy_path', '/var/www/html')
    ->user('fusic')
    ->identityFile('./miria.rsa')
    ->stage('production')
    ->set('branch', 'master');

# -----------------------------------------------------------
# Tasks

option('env-update', null, InputOption::VALUE_OPTIONAL, 'update env file.');
task('copy:env', function () {
    if (input()->hasOption('env-update')) {
        $update = input()->getOption('env-update');
        if ($update == 'true') {
            $stage = get('stage');
            $src = ".server/deployer/.env.${stage}";
            $path = get('deploy_path');
            $shared_path = "${path}/shared";
            run("if [ -e $(echo ${shared_path}/.env ) ]; then cp {{release_path}}/${src} ${shared_path}/.env; fi");
            run("cp {{release_path}}/${src} {{release_path}}/.env");
        }
    }
});

task('artisan:config:clear', function () {
    if (input()->hasOption('env-update')) {
        run('{{bin/php}} {{release_path}}/artisan config:clear');
    }
});

before('deploy:shared', 'copy:env');
before('artisan:config:cache', 'artisan:config:clear');
before('deploy:symlink', 'artisan:migrate');

after('deploy:failed', 'deploy:unlock');

before('deploy', 'slack:notify');
after('success', 'slack:notify:success');
