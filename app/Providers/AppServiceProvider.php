<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //\Carbon\Carbon::setLocale('ru');
        //dd(App::getLocale());
        //dd(config('app.locale'));
        
        // FIX THE LOCALE BUG WITH CARBON - https://vegibit.com/what-is-a-view-composer-in-laravel/
        View::composer('*', function ($view) {

            $locale = App::getLocale();
            
            \Carbon\Carbon::setUtf8(true);
            \Carbon\Carbon::setLocale($locale);
            
            //$date = \Carbon\Carbon::parse('2018-06-15 17:34:15.984512', 'UTC')->getTranslatedMonthName('M');
            //dd($date);
            //dd($date->getTranslatedMonthName('Do MMMM')); // марта)
        });
        
        
        Blade::directive('date', function ($expression) {
            return "<?php echo date('d/m/Y', strtotime($expression))?>";
        });
        Blade::directive('date_monthname', function ($expression) {
            return "<?php echo date('d M Y', strtotime($expression))?>";
            /*return "<?php Carbon\Carbon::parse($expression)->getTranslatedShortMonthName('MMM Do YY')?>";*/
        });
        Blade::directive('day', function ($expression) {
            return "<?php echo date('d', strtotime($expression))?>";
        });
        Blade::directive('month', function ($expression) {
            /*return "<?php echo date('M', strtotime($expression))?>";*/
            
            return "<?php echo Carbon\Carbon::parse($expression)->getTranslatedShortMonthName('MMM')?>";
            /*return "<?php echo 'aa';?>";*/
        });
        Blade::directive('time_am_pm', function ($expression) {
            return "<?php echo date('g.i a', strtotime($expression))?>";
        });
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
