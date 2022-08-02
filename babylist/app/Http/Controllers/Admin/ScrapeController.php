<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;
use Goutte\Client;
use Illuminate\Http\Request;
use stdClass;
use Symfony\Component\HttpClient\HttpClient;



class ScrapeController extends Controller
{
    public function show()
    {
        $shops = [
            'dreamBaby' => "dreamBaby",
            'mimibaby' => 'Mimi Baby',
            'Hema' => 'Hema',
            'littleMoustache' => 'Little Moustache',
        ];

        $dreamBabyCategories = Category::where('webshop', 'dreamBaby')->get();
        $mimibabyCategories = Category::where('webshop', 'mimibaby')->get();
        $hemaCategories = Category::where('webshop', 'Hema')->get();
        $littleMoustacheCategories = Category::where('webshop', 'littleMoustache')->get();

        return view('admin.scrape-form', compact('shops', 'dreamBabyCategories', 'mimibabyCategories', 'hemaCategories', 'littleMoustacheCategories'));
    }

    public function scrapeCategories(Request $r){

        switch($r->shop){

            case 'dreamBaby' :
                $this->scrapedreamBabyCategories($r->url);
                break;
            case 'mimibaby' :
                $this->scrapemimibabyCategories($r->url);
            case 'Hema' :
                $this->scrapeHemaCategories($r->url);
                break;
            case 'littleMoustache' :
                $this->scrapelittleMoustacheCategories($r->url);
                break;
        }
        return redirect()->back();
    }

    public function scrapeArticles(Request $r){

        switch($r->shop){

            case 'dreamBaby' :
                return $this->scrapedreamBabyArticles($r->url);
                break;
            case 'mimibaby' :
                return $this->scrapemimibabyArticles($r->url);
                break;
            case 'Hema' :
                return $this->scrapeHemaArticles($r->url);
                break;
            case 'littleMoustache' :
                return $this->scrapelittleMoustacheArticles($r->url);
                break;
        }

    }





    ///////////////////////////////////////////////////////////////dreambaby//////////////////////////////////////////
    private function scrapedreamBabyCategories ($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('.scrolling-wrapper-content .card .card-content a')
            ->each(function($node){
                $title = $node->text();
                $url = 'https://www.dreambaby.be' . $node->attr('href');

                $cat = new stdClass();
                $cat->title = $title;
                $cat->url = $url;

                return $cat;

            });

        foreach($categories as $scrapeCategory) {

            // Check if exists
            $exists = Category::where('url' , $scrapeCategory->url)->count();
            if ($exists > 0) continue;

            // Create/Add new category to database
            $categoryEntity = new Category();
            $categoryEntity->title = $scrapeCategory->title;
            $categoryEntity->webshop = 'dreamBaby';
            $categoryEntity->url = $scrapeCategory->url;
            $categoryEntity->save();
        };

    }


    private function scrapedreamBabyArticles($url ) {

        $client = new Client();
        $crawler = $client->request('GET', $url);

        $articles =$this->scrapedreamBabyPageData($crawler);
        return view('admin.scrape-result', compact('articles'));
    }


    // Scrape ALL articles from specific categorie on 1 page
    private function scrapedreamBabyPageData($crawler) {

        $nodes = $crawler->filter('div[base-product-name]');

        $articles = array();
        $articles = $nodes->each(function($node){
//                foreach ($nodes as $node) {
            $article = new stdClass();
            $article->title = $node->filter('.product_info a .product_name')->text();
            $article->image = $node->filter('.product_info a .product_image .image img')->first()->attr('src');
            $article->price = $node->filter('.product_info .product_price .product_price .price .value')->text();
            $article->desc = "";
            return $article;
        });


        foreach($articles as $scrapeArticle) {

            // Check if exists
            $exists = Category::where('url' , $scrapeArticle->title)->count();
            if ($exists > 0) continue;

            // Create/Add new category to database
            $ArticleEntity = new Article();
            /*$ArticleEntity->category_id = 50;*/
            $ArticleEntity->title = $scrapeArticle->title;
            $ArticleEntity->slug = self::slugify($scrapeArticle->title);
            $ArticleEntity->price = $scrapeArticle->price;
            $ArticleEntity->src = $scrapeArticle->image;
            $ArticleEntity->description = $scrapeArticle->desc;
            $ArticleEntity->save();

            return $articles;
        }
    }



    ///////////////////////////////////////////////////////////////mimibaby//////////////////////////////////////////
    private function scrapemimibabyCategories ($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('.nav-main .main-navigation .container .nav a')
            ->each(function($node){
                $title = $node->text();
                $url = $node->attr('href');

                $cat = new stdClass();
                $cat->title = $title;
                $cat->url = $url;

                return $cat;

            });

        foreach($categories as $scrapeCategory) {

            // Check if exists
            $exists = Category::where('url' , $scrapeCategory->url)->count();
            if ($exists > 0) continue;

            // Create/Add new category to database
            $categoryEntity = new Category();
            $categoryEntity->title = $scrapeCategory->title;
            $categoryEntity->webshop = 'mimibaby';
            $categoryEntity->url = $scrapeCategory->url;
            $categoryEntity->save();
        };

    }


    private function scrapemimibabyArticles($url) {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        //sleep(10);
        $articles =$this->scrapemimibabyPageData($crawler);
        return view('admin.scrape-result', compact('articles'));
    }


    // Scrape ALL articles from specific categorie on 1 page
    private function scrapemimibabyPageData($crawler) {

        $nodes = $crawler->filter('div.card-body');
        $articles = $nodes->each(function($node){
            $article = new stdClass();
            $article->title = $node->filter('.product-info a')->text();
            $article->image = $node->filter('img')->first()->attr('src');
            $article->price = $node->filter('.product-price')->text();
            $article->desc = "";
            return $article;

        });

                foreach($articles as $scrapeArticle) {

                    // Check if exists
                    $exists = Category::where('url' , $scrapeArticle->title)->count();
                    if ($exists > 0) continue;

                    // Create/Add new category to database
                    $ArticleEntity = new Article();
                   /* $ArticleEntity->category_id = 50;*/
                    $ArticleEntity->title = $scrapeArticle->title;
                    $ArticleEntity->slug = self::slugify($scrapeArticle->title);
                    $ArticleEntity->price = $scrapeArticle->price;
                    $ArticleEntity->src = $scrapeArticle->image;
                    $ArticleEntity->description = $scrapeArticle->desc;
                    $ArticleEntity->save();
                };
        return $articles;
    }

////////////////////////////////////////////////////////////hema
    private function scrapeHemaCategories($url) {
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('.featured-sidebar ul li a')
            ->each(function($node) {
                $title = $node->text();
                $url = $node->attr('href');

                $cat = new stdClass();
                $cat->title = $title;
                $cat->url = $url;

                return $cat;
            });
        foreach($categories as $scrapeCategory) {

            // Check if exists
            $exists = Category::where('url' , $scrapeCategory->url)->count();
            if ($exists > 0) continue;

            // Create/Add new category to database
            $categoryEntity = new Category();
            $categoryEntity->title = $scrapeCategory->title;
            $categoryEntity->webshop = 'Hema';
            $categoryEntity->url = $scrapeCategory->url;
            $categoryEntity->save();
        };
    }

    // Scrape ALL articles from specific categorie
    private function scrapeHemaArticles($url) {

        $client = new Client();
        $crawler = $client->request('GET', $url);

        $articles =$this->scrapeHemaPageData($crawler);
        return view('admin.scrape-result', compact('articles'));
    }

    // Scrape ALL articles from specific categorie on 1 page
    private function scrapeHemaPageData($crawler) {

        $nodes = $crawler->filter('.product-row-wrap');

        $articles = $nodes->each(function($node){
//
            $article = new stdClass();
            $article->title = $node->filter('.product-info h3 a span')->text();
            $article->image = $node->filter('.product-image a img')->first()->attr('src');
            $article->price = $node->filter('.product-price .js-price span')->text();
            $article->desc = "";
            return $article;

        });

        /*  foreach($articles as $scrapeArticle) {
              // Check if exists
              $exists = Category::where('url' , $scrapeArticle->title)->count();
              if ($exists > 0) continue;
              // Create/Add new category to database
              $ArticleEntity = new Article();
              $ArticleEntity->category_id = 36;
              $ArticleEntity->title = $scrapeArticle->title;
              $ArticleEntity->slug = self::slugify($scrapeArticle->title);
              $ArticleEntity->price = $scrapeArticle->price;
              $ArticleEntity->src = $scrapeArticle->image;
              $ArticleEntity->description = $scrapeArticle->desc;
              $ArticleEntity->save();
          };*/

        return $articles;
    }

///////////////////////////////////////////////////////////Little moustache
    private function scrapelittleMoustacheCategories ($url){
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('.UOLRo ul li a')
            ->each(function($node){
                $title = $node->text();
                $url =$node->attr('href');

                $cat = new stdClass();
                $cat->title = $title;
                $cat->url = $url;

                return $cat;

            });

        foreach($categories as $scrapeCategory) {

            // Check if exists
            $exists = Category::where('url' , $scrapeCategory->url)->count();
            if ($exists > 0) continue;

            // Create/Add new category to database
            $categoryEntity = new Category();
            $categoryEntity->title = $scrapeCategory->title;
            $categoryEntity->webshop = 'littleMoustache';
            $categoryEntity->url = $scrapeCategory->url;
            $categoryEntity->save();
        };

    }


    private function scrapelittleMoustacheArticles($url) {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        //sleep(10);

        $articles =$this->scrapelittleMoustachePageData($crawler);
        return view('admin.scrape-result', compact('articles'));
    }


    // Scrape ALL articles from specific categorie on 1 page
    private function scrapelittleMoustachePageData($crawler) {

        $nodes = $crawler->filter('div.ETPbIy');
        echo count($nodes);
        $articles = $nodes->each(function($node){
            $article = new stdClass();
            $article->title = $node->filter('.sMuaBcZ')->text();
            $article->image = $node->filter('.ha6XCD')->first()->attr('src');
            $article->price = $node->filter('.cfpn1d')->text();
            $article->desc = "";
            return $article;

        });

//                foreach($articles as $scrapeArticle) {
//
//                    // Check if exists
//                    $exists = Category::where('url' , $scrapeArticle->title)->count();
//                    if ($exists > 0) continue;
//
//                    // Create/Add new category to database
//                    $ArticleEntity = new Article();
//                    $ArticleEntity->category_id = 50;
//                    $ArticleEntity->title = $scrapeArticle->title;
//                    $ArticleEntity->slug = self::slugify($scrapeArticle->title);
//                    $ArticleEntity->price = $scrapeArticle->price;
//                    $ArticleEntity->src = $scrapeArticle->image;
//                    $ArticleEntity->description = $scrapeArticle->desc;
//                    $ArticleEntity->save();
//                };
        return $articles;
    }





    // ADDON (slug function)
    public static function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}
