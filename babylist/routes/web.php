<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GetArticlesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ScrapeController;
use App\Http\Controllers\Guest\GuestController;
use App\Http\Controllers\Guest\GuestWishlistController;
use App\Http\Controllers\wishlist\articles\AddArticles;
use App\Http\Controllers\wishlist\ArticlesWishlistController;
use App\Http\Controllers\WishList\create\CreateWishlistController;
use App\Http\Controllers\wishlist\WishlistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [AdminController::class, 'adminCheck'])->name('/');

//Visitor(logged in) make wishlists + add articles
    // Make a wishlist
    Route::get('/make-list', [WishlistController::class, 'showListForm'])->middleware('auth')->name('make-list');
    Route::post('/make-list', [CreateWishlistController::class, 'newList'])->middleware('auth')->name('newListPOST');

    //return wishlists
    Route::get('/overview', [WishlistController::class, 'showWishlist'])->middleware('auth')->name('overview');
    Route::get('/overview/{id}', [ArticlesWishlistController::class, "showListId"])->middleware('auth')->name(('listdetail'));

    //delete a wishlist
    Route::delete('/overview/delete/{wishlist_id}' , [WishlistController::class, 'deleteList'])->middleware('auth')->name('deleteList');

    //add articles to your wishlist
    Route::get('/overview/{id}/newarticle', [ArticlesWishlistController::class, "showArticleForm"])->middleware('auth')->name('newArticle');
    Route::post('/overview/{wishlist_id}/newarticle/{article_id}', [ArticlesWishlistController::class, "addArticle"])->middleware('auth')->name('addArticle');


// Guest buying from wishlist


    Route::get('/buy-from-list' , [GuestController::class, 'show'])->name('buy-from-list');;
    Route::post('/buy-from-list' , [GuestController::class, 'access'])->name('access');

    Route::get('/guest/detaillist/{id}', [GuestWishlistController::class, 'UserListDetail'])->name('detaillistwcode');
    Route::post('/guest/detaillist/{id}', [GuestWishlistController::class, 'AddWinkelmandje'])->name('AddWinkelmandje');



// Admin
    Route::get('/scrape', [ScrapeController::class, 'show'])->name('scraper');
    Route::post('/scrape/categories', [ScrapeController::class, 'scrapeCategories'])->name('scrape.categories');
    Route::post('/scrape/articles', [ScrapeController::class, 'scrapeArticles'])->name('scrape.articles');
    // Route::get('/admin/articles', [ArticlesWishlistController::class, 'allArticles'])->name('articles');


require __DIR__.'/auth.php';
