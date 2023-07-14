<?php
/**
 * Application name
 */
$appname = ''; // domain

/**
 * Remote server connection string
 */
$server_map = [
    'dev' => '', // dev.domain.com
    'production' => '', // domain.com
];
/**
 * Repository source
 */
$source_repo = ''; // git@github.com:username/repo.git
/**
 * Deployment base path
 */
$deploy_basepath = ''; // /var/www/html/
/**
 * Remote server service user(group) that the application runs as
 */
$serviceowner = 'apache';
/**
 * shared sub-directories name , eg: storage
 */
$shared_subdirs = [
    'storage',
];
/**
 * addon exclude pattens , eg: /node_modules/
 */
$exclude_addon_pattens = [
    'node_modules',
];
?>

@setup
if ( ! isset($appname) ) { throw new Exception('App Name is not set'); }
if ( ! isset($server_map['dev']) && $server_map['dev'] != '' ) { throw new Exception('SSH development login username/host is not set'); }
if ( ! isset($server_map['production']) && $server_map['production'] != '' ) { throw new Exception('SSH production login username/host is not set'); }
if ( ! isset($source_repo) ) { throw new Exception('Git repository is not set'); }
if ( ! isset($serviceowner) ) { throw new Exception('Service Owner is not set'); }
if ( ! isset($deploy_basepath) ) { throw new Exception('Path is not set'); }
if ( substr($deploy_basepath, 0, 1) !== '/' ) { throw new Exception('Careful - your path does not begin with /'); }

$envoy_servers = array_merge(['local'=>'localhost',],$server_map);

$now = new DateTime();
$dateDisplay = $now->format('Y-m-d H:i:s');
$date = $now->format('YmdHis');

$remote_server = (isset($on) && $on == 'production') ? 'production' : 'dev';
if(!isset($branch)){
$branch = (isset($remote_server) && $remote_server == 'production' ? "master" : "develop");
}else{
$remote_server = 'dev';
}

$source_name = 'source';

$app_base = $deploy_basepath.$appname;
$source_dir = $app_base.'/'.$source_name;
$release_dir = $app_base.'/releases';
$app_dir = $app_base.'/current';
$prev_dir = $app_base.'/prevrelease';
$last_dir = $app_base.'/lastrelease';
$shared_dir = $app_base.'/shared';
$release = 'release_' . $date;
$tmp_dir = $app_base.'/tmp';

$local_dir = getcwd();
$localdeploy_dirname = '.envoydeploy';
$localdeploy_base = $local_dir.'/'.$localdeploy_dirname;
$localdeploy_source_dir = $localdeploy_base.'/'.$source_name;
$localdeploy_tmp_dir = $localdeploy_base.'/tmp';
@endsetup

@servers($envoy_servers)

@macro('deploy')
show_env_local
show_env_remote
init_basedir_local
init_basedir_remote
updaterepo_localsrc
depsinstall_localsrc
packrelease_localsrc
rcpreleasepack_to_remote
extractreleasepack_on_remote
syncshareddata_remotesrc
baseenvlink_remoterelease
prepare_remoterelease
link_newrelease_on_remote
cache_remote_release
cleanup_oldreleases_on_remote
clean_localsrc
@endmacro

@macro('rollback')
link_rollback_on_remote
@endmacro

@task('show_env_local', ['on' => 'local'])
echo '----';
echo 'Current Release Name: {{$release}}';
echo 'Current branch is {{$branch}}';
echo 'Deployment Start at {{$dateDisplay}}';
echo 'App base {{ $localdeploy_base }}';
echo '----';
@endtask

@task('show_env_remote', ['on' => $remote_server])
echo '----';
echo 'Current Release Name: {{$release}}';
echo 'Current branch is {{$branch}}';
echo 'Deployment Start at {{$dateDisplay}}';
echo 'Releases dir {{ $release_dir }}';
echo 'Shared dir {{ $shared_dir }}';
echo 'App base {{ $app_base }}';
echo '----';
@endtask

@task('init_basedir_local', ['on' => 'local'])
[ -d {{ $localdeploy_base }} ] || mkdir -p {{ $localdeploy_base }};
[ -d {{ $localdeploy_source_dir }} ] || mkdir -p {{ $localdeploy_source_dir }};
[ -d {{ $localdeploy_tmp_dir }} ] || mkdir -p {{ $localdeploy_tmp_dir }};
@endtask

@task('init_basedir_remote', ['on' => $remote_server])

if [ ! -d {{ $release_dir }} ]; then
    mkdir -p -m 02770 {{ $release_dir }};
    chgrp marketing {{ $release_dir }};
    chmod g+s {{ $release_dir }};
fi

if [ ! -d {{ $shared_dir }}/storage ]; then
    mkdir -p -m 02770 {{ $shared_dir }}/storage;
    chgrp marketing {{ $shared_dir }}/storage;
    chmod g+s {{ $shared_dir }}/storage;
fi

[ -d {{ $shared_dir }}/storage/debugbar ] || mkdir -p -m 02770 {{ $shared_dir }}/storage/debugbar;
[ -d {{ $shared_dir }}/storage/logs ] || mkdir -p -m 02770 {{ $shared_dir }}/storage/logs;
[ -d {{ $shared_dir }}/storage/app ] || mkdir -p -m 02770 {{ $shared_dir }}/storage/app;
[ -d {{ $shared_dir }}/storage/app/public ] || mkdir -p -m 02770 {{ $shared_dir }}/storage/app/public;
[ -d {{ $shared_dir }}/storage/framework ] || mkdir -p -m 02770 {{ $shared_dir }}/storage/framework;
[ -d {{ $shared_dir }}/storage/framework/cache ] || mkdir -p -m 02770 {{ $shared_dir }}/storage/framework/cache;
[ -d {{ $shared_dir }}/storage/framework/views ] || mkdir -p -m 02770 {{ $shared_dir }}/storage/framework/views;

[ -d {{ $app_base }}/tmp ] || mkdir -p 02770 {{ $app_base }}/tmp;
@endtask

@task('updaterepo_localsrc', ['on' => 'local'])
echo "LocalSource Repository update...";
if [ -d {{ $localdeploy_source_dir }}/.git ]; then
echo "Repository exists only update...";
echo "Cleaning up old _resources"
[ -d {{ $localdeploy_source_dir }}/public/_resources ] && rm -rf {{ $localdeploy_source_dir }}/public/_resources
cd {{ $localdeploy_source_dir }};
git fetch origin;
git checkout -B {{ $branch }} origin/{{ $branch }};
git pull origin {{ $branch }};
else
echo "No Previous Repository exits and cloning...";
git clone {{ $source_repo }} --branch={{ $branch }} --depth=1 {{ $localdeploy_source_dir }};
fi
echo "LocalSource Repository updated.";
@endtask

@task('depsinstall_localsrc', ['on' => 'local'])
echo "LocalSource Dependencies install...";
cd {{ $localdeploy_source_dir }};

echo "Composer install...";
if [ "{{ $remote_server }}" = "production" ]; then
make composerinstallproduction
else
make composerinstalldev
fi
echo "Composer installed.";

echo "Generate the artisan key...";
make generatekey

echo "Yarn install...";
make yarn;
echo "Yarn installed.";

echo "Compile assets...";
make buildproduction;
echo "Assets compiled.";

echo "LocalSource Dependencies installed.";
@endtask

@task('packrelease_localsrc', ['on' => 'local'])
echo "LocalSource Pack release...";
[ -f {{ $localdeploy_tmp_dir }}/release.tgz ] && rm -rf {{ $localdeploy_tmp_dir }}/release.tgz;
cd {{ $localdeploy_base }}/;
tar --exclude=storage --exclude=node_modules --exclude-vcs -czf {{ $localdeploy_tmp_dir }}/release.tgz {{ $source_name }};
echo "LocalSource Pack release Done.";
@endtask

@task('rcpreleasepack_to_remote', ['on' => 'local'])
echo "rcp localpack release to remote...";
echo {{ $localdeploy_tmp_dir }};
if [ -f {{ $localdeploy_tmp_dir }}/release.tgz ]; then
rsync -avz --progress --port 22 {{ $localdeploy_tmp_dir }}/release.tgz {{ $server_map[$remote_server] }}:{{ $tmp_dir }}/;
else
echo "localpack release NOT EXISTS.";
exit 1;
fi
echo "rcp localpack release to remote Done.";
@endtask

@task('clean_localsrc', ['on' => 'local'])
echo "clean .envoydeploy directory...";
[ -d {{ $localdeploy_base }} ] && rm -rf {{ $localdeploy_base }};
echo ".envoydeploy folder cleaned"
@endtask

@task('extractreleasepack_on_remote', ['on' => $remote_server])
echo "extract pack release on remote...";
if [ -f {{ $tmp_dir }}/release.tgz ]; then
[ -d {{ $tmp_dir }}/{{ $source_name }} ] && rm -rf {{ $tmp_dir }}/{{ $source_name }};
tar zxf {{ $tmp_dir }}/release.tgz -C {{ $tmp_dir }} --warning=no-timestamp;
if [ -d {{ $tmp_dir }}/{{ $source_name }} ]; then
if [ -d {{ $source_dir }} ]; then
echo "Previous Remote Source Dir Exists,Moving.";
[ -d {{ $app_base }}/source_prev ] && rm -rf {{ $app_base }}/source_prev;
mv {{ $source_dir }} {{ $app_base }}/source_prev;
mv {{ $tmp_dir }}/{{ $source_name }} {{ $source_dir }};
else
mv {{ $tmp_dir }}/{{ $source_name }} {{ $source_dir }};
fi
else
echo "extract pack release on remote ERROR.";
exit 1;
fi
else
echo "pack release NOT EXISTS.";
exit 1;
fi
echo "extract pack release on remote Done.";
@endtask

@task('syncshareddata_remotesrc', ['on' => $remote_server])
echo "RemoteSource Sync SharedData...";
ln -fs {{ $shared_dir }}/storage {{ $source_dir }}/storage
ln -fs {{ $shared_dir }}/storage/app/public {{ $source_dir }}/public/_static
echo "RemoteSource Sync SharedData Done.";
@endtask

@task('baseenvlink_remoterelease', ['on' => $remote_server])
echo "RemoteRelease Environment file setup...";
if [ -f {{ $app_base }}/.env ]; then
[ -f {{ $source_dir }}/.env ] && rm -rf {{ $source_dir }}/.env;
ln -nfs {{ $app_base }}/.env {{ $source_dir }}/.env && chgrp -h {{$serviceowner}} {{ $source_dir }}/.env;
fi
echo "RemoteRelease Environment file setup Done.";
@endtask

@task('prepare_remoterelease', ['on' => $remote_server])
echo "RemoteRelease Prepare...";
rsync --progress -e ssh -avzh --delay-updates --delete {{ $source_dir }}/ {{ $release_dir }}/{{ $release }}/;
chmod -R g+s {{ $release_dir }}/{{ $release }}
echo "RemoteRelease Prepare Done.";
@endtask

@task('cache_remote_release', ['on' => $remote_server])
shopt -s expand_aliases
source ~/.bashrc
echo "Clearing view cache"
php73 {{ $release_dir }}/{{ $release }}/artisan view:clear
echo "Caching configs...";
php73 {{ $release_dir }}/{{ $release }}/artisan config:cache
echo "Caching routes...";
php73 {{ $release_dir }}/{{ $release }}/artisan route:cache
echo "Done caching ";
@endtask

@task('link_newrelease_on_remote', ['on' => $remote_server])
echo "Deploy new Release link";
cd {{ $app_base }};
[ -d {{ $prev_dir }} ] && unlink {{ $prev_dir }};
[ -d {{ $app_dir }} ] && mv {{ $app_dir }} {{ $prev_dir }};
ln -nfs {{ $release_dir }}/{{ $release }} {{ $app_dir }} && chgrp -h {{$serviceowner}} {{ $app_dir }};
echo "Deployment ({{ $release }}) symbolic link created";
@endtask

@task('link_rollback_on_remote', ['on' => $remote_server])
if [ -d {{ $last_dir }} ]; then
[ ! -d {{ $app_dir }} ] || mv {{ $app_dir }} {{ $prev_dir }};
[ ! -d {{ $last_dir }} ] || mv {{ $last_dir }} {{ $app_dir }};
echo "Reset to last symbolic link";
elif [ -d {{ $prev_dir }} ] && [ ! -d {{ $last_dir }} ]; then
[ ! -d {{ $app_dir }} ] || mv {{ $app_dir }} {{ $last_dir }};
[ ! -d {{ $prev_dir }} ] || mv {{ $prev_dir }} {{ $app_dir }};
echo "Rollback to previous symbolic link";
else
echo "No previous link to rollback";
fi
@endtask

@task('cleanup_oldreleases_on_remote', ['on' => $remote_server])
echo 'Cleanup up old releases';
cd {{ $release_dir }} && (ls -rd {{ $release_dir }}/*|head -n 4;ls -d {{ $release_dir }}/*)|sort|uniq -u|xargs rm -rf
echo "Cleanup up done.";
@endtask

@task('notice_done')
echo "Deployment ({{ $release }}) done.";
@endtask
