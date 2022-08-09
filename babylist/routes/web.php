<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AllArticlesController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ScrapeController;
use App\Http\Controllers\Guest\GuestController;
use App\Http\Controllers\Guest\GuestWishlistController;
use App\Http\Controllers\ShoppingCart\CheckoutController;
use App\Http\Controllers\ShoppingCart\WebhookController;

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

    //delete an article
    Route::delete('/overview/delete/{wishlist_id}/{article_id}', [ArticlesWishlistController::class, 'deleteListArticle'])->name('deleteListArticle');


// Guest buying from wishlist

    //get access to wishlist
    Route::get('/buyList' , [GuestController::class, 'show'])->name('buyList');;
    Route::post('/buyList' , [GuestController::class, 'accessList'])->name('accessList');


    //see articles in wishlist and add them too the shoppingcart
    Route::get('/buyList/detaillist/{id}', [GuestWishlistController::class, 'guestListDetail'])->name('detailList');
    Route::post('/buyList/detaillist/{id}', [GuestWishlistController::class, 'addShopingCart'])->name('addShopingCart');

    //buy articles and payment
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success' , [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/webhooks/mollie',[WebhookController::class, 'handle'])->name('webhooks.mollie');


// Admin
    //scrape page
    Route::get('/scrape', [ScrapeController::class, 'show'])->middleware('auth')->name('scraper');
    Route::post('/scrape/categories', [ScrapeController::class, 'scrapeCategories'])->middleware('auth')->name('scrape.categories');
    Route::post('/scrape/articles', [ScrapeController::class, 'scrapeArticles'])->middleware('auth')->name('scrape.articles');
    
    //see all articles
    Route::get('/articles', [AllArticlesController::class, 'allArticles'])->middleware('auth')->name('articles.overview');
    
    //delete articles
    Route::delete('/scrape/delete/{article_id}',[AllArticlesController::class, 'deleteArticle'])->middleware('auth')->name('deleteArticle');

require __DIR__.'/auth.php';
