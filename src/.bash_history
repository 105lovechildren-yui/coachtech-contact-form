composer install
cp .env.example .env
exit
php artisan key:generate
sudo chown yui_105:yui_105 ~/coachtech/laravel/coachtech-contact-form/src/.env
sudo chown -R yui_105:yui_105 ~/coachtech/laravel/coachtech-contact-form
exit
