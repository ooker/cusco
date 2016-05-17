<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Symfony\Component\Yaml\Yaml;

Route::get('/', function () {
    return view('pages.index');
});

Route::get('/styleguide', function () {


    $components = collect(Storage::disk('resources')->allDirectories('views/components'))
        ->map(function($directory) {
            return Storage::disk('resources')->files($directory);
        })
        ->flatten()
        ->filter(function($filepath) {
            return pathinfo($filepath, PATHINFO_EXTENSION) == 'yaml';
        })
        ->map(function($filepath) {
            return (object) [
                'name' => pathinfo($filepath, PATHINFO_FILENAME),
                'yaml' => Storage::disk('resources')->get($filepath)
            ];
        })
        ->map(function($component) {
            $component->yaml = Yaml::parse(trim($component->yaml));
            return $component;
        });
 
    return view('pages.styleguide', [
        'components' => $components
    ]);

});
