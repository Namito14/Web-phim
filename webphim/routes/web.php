<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
use Laravel\Socialite\Facades\Socialite;

// admin controller
use App\Http\Controllers\categoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LinkMovieController;
use App\Http\Controllers\LeechMovieController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\Auth\LoginController;


Route::get('/', [IndexController::class, 'home'])->name('homepage');

Route::get('/dang-nhap', [IndexController::class, 'dang_nhap'])->name('dang-nhap');
Route::get('/dang-ki', [IndexController::class, 'dang_ki'])->name('dang-ki');
Route::get('/dang-xuat', [IndexController::class, 'dang_xuat'])->name('dang-xuat');
Route::get('/yeu-thich', [IndexController::class, 'favorite'])->name('yeu-thich');
Route::post('/register-publisher', [IndexController::class, 'register_publisher'])->name('register-publisher');
Route::post('/login-publisher', [IndexController::class, 'login_publisher'])->name('login-publisher');
Route::post('/themyeuthich', [IndexController::class, 'themyeuthich'])->name('themyeuthich');


Route::get('/danh-muc/{slug}', [IndexController::class, 'category'])->name('category');
Route::get('/the-loai/{slug}', [IndexController::class, 'genre'])->name('genre');
Route::get('/quoc-gia/{slug}', [IndexController::class, 'country'])->name('country');
Route::get('/phim/{slug}', [IndexController::class, 'movie'])->name('movie');
Route::get('/xem-phim/{slug}/{tap}/{server_active}', [IndexController::class, 'watch']);
Route::get('/so-tap', [IndexController::class, 'episode'])->name('so-tap');
Route::get('/nam/{year}', [IndexController::class, 'year']);
Route::get('/tim-kiem', [IndexController::class, 'timkiem'])->name('tim-kiem');
Route::get('/locphim', [IndexController::class, 'locphim'])->name('locphim');
Route::post('/add-rating', [IndexController::class, 'add_rating'])->name('add-rating');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // route admin
    Route::resource('category', categoryController::class);
    Route::resource('genre', GenreController::class);
    Route::resource('country', CountryController::class);
    Route::resource('linkmovie', LinkMovieController::class);
    // Thông tin web
    Route::resource('info', InfoController::class);

    // xem tập phim
    Route::resource('episode', EpisodeController::class);
    Route::get('select-movie', [EpisodeController::class,'select_movie'])->name('select-movie');
    Route::get('add-episode/{id}', [EpisodeController::class,'add_episode'])->name('add-episode');

    Route::resource('movie', MovieController::class);
    Route::post('resorting', [categoryController::class,'resorting'])->name('resorting');

    Route::get('/update-year-phim', [MovieController::class, 'update_year']);
    Route::get('/update-topview-phim', [MovieController::class, 'update_topview']);
    Route::get('/update-season-phim', [MovieController::class, 'update_season']);

    // Thay đổi dữ liệu movie theo ajax
    Route::get('/category-choose', [MovieController::class, 'category_choose'])->name('category-choose');
    Route::get('/country-choose', [MovieController::class, 'country_choose'])->name('country-choose');
    Route::get('/trangthai-choose', [MovieController::class, 'trangthai_choose'])->name('trangthai-choose');
    Route::get('/phimhot-choose', [MovieController::class, 'phimhot_choose'])->name('phimhot-choose');
    Route::get('/resolution-choose', [MovieController::class, 'resolution_choose'])->name('resolution-choose');
    Route::post('/watch-video', [MovieController::class, 'watch_video'])->name('watch-video');

    // route leech movie
    Route::get('/leech-movie', [LeechMovieController::class, 'leech_movie'])->name('leech-movie');
    Route::get('/leech-detail/{slug}', [LeechMovieController::class, 'leech_detail'])->name('leech-detail');
    Route::get('/leech-episode/{slug}', [LeechMovieController::class, 'leech_episode'])->name('leech-episode');
    Route::post('/leech-store/{slug}', [LeechMovieController::class, 'leech_store'])->name('leech-store');
    Route::post('/leech-episode-store/{slug}', [LeechMovieController::class, 'leech_episode_store'])->name('leech-episode-store');
});

require __DIR__.'/auth.php';

Route::post('/filter-topview-phim', [MovieController::class, 'filter_topview']);

Route::get('/filter-topview-default', [MovieController::class, 'filter_default']);

// Login by google account
Route::get('auth/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('login-by-google');
Route::get('auth/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);

// Logout
Route::get('logout-home', [LoginGoogleController::class, 'logout_home'])->name('logout-home');
