<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Info;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;   

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('update_at','desc')->take('5')->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('update_at','desc')->take('5')->get();
        $category = Category::orderBy('id','DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->get();
        $country = Country::orderBy('id','DESC')->get();
        $info = Info::find(1);

        // Total Admin
        $category_total = Category::all()->count();
        $genre_total = Genre::all()->count();
        $country_total = Country::all()->count();   
        $movie_total = Movie::all()->count();   
        
        View::share([
            'category_total' => $category_total,
            'genre_total' => $genre_total,
            'country_total' => $country_total,
            'movie_total' => $movie_total,
            'info' => $info,
            'phimhot_trailer' => $phimhot_trailer,
            'phimhot_sidebar' => $phimhot_sidebar,
            'category_home' => $category,
            'genre_home' => $genre,
            'country_home' => $country
        ]);
    }
}
