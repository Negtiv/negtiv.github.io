<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'negtiv.github.io');

// Project repository
set('repository', 'git@github.com:quintenbuis/quintenbuis.github.io.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
set('shared_files', []);
set('shared_dirs', []);

// Writable dirs by web server 
set('writable_dirs', []);

set('default_stage', 'staging');


// Hosts

host('quintenbuis.nl')
    ->stage('production')
    ->user('root')
    ->port(22)
    ->forwardAgent()
    ->set('deploy_path', '/home/negtiv/{{application}}');
    
host('quintenbuis.nl')
    ->set('branch', 'develop')
    ->stage('staging')
    ->user('root')
    ->port(22)
    ->forwardAgent()
    ->set('deploy_path', '/home/negtiv/staging_{{application}}');  
    

// Tasks

desc('Deploy to server');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
