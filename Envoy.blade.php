@servers(['prod' => 'mmrfid@midsouthmakers.org'])

@task('deploy:prod', ['on' => 'prod'])
cd /home/mmrfid/midsouthmakers-rfid
php artisan down
git pull origin master
composer install --no-dev
php artisan migrate --force
npm run production
php artisan up
@endtask
