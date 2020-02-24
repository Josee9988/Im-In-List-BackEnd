<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'ImInList-Back');

// Project repository
set('repository', 'git@github.com:Josee9988/Im-In-List-BackEnd.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);

add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);

// Hosts
// IP = 54.243.26.179
// IP2= 54.165.254.46
host('54.165.254.46')
    ->user('back')
    ->configFile('~/.ssh/config')
    ->port(443)
    ->identityFile('~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/html/ImInList-back');

// Podemos definir diferentes tareas que se ejecutarán durante, antes o después de cada despliegue
task('build', function () {
    run('cd {{release_path}} && build');
});

// Si el despliegue falla, automáticamente hacemos un unlock y dejamos la versión anterior.
after('deploy:failed', 'deploy:unlock');

// Ejecutamos la migramos la base de datos justo antes de llevar a cabo el enlace simbólico a la nueva versión.
before('deploy:symlink', 'artisan:migrate');

// Definimos las tareas que queremos que se ejecuten cuando llevemos a cabo un deploy de la aplicación.
desc('Deploy your project');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'deploy:symlink',
    'artisan:migrate:fresh',
    'artisan:db:seed',
    'deploy:unlock',
    'cleanup',
]);

// Sube .env
task('upload:env', function () {
    upload('.env', '{{deploy_path}}/shared/.env');
})->desc('Environment setup');

// Declaración de la tarea
task('reload:php-fpm', function () {
    run('sudo /etc/init.d/php7.2-fpm restart');
});

// Inclusión en el ciclo de despliegue
after('deploy', 'reload:php-fpm');
