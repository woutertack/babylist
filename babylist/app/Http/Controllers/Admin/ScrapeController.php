<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;
use Goutte\Client;
use Illuminate\Http\Request;
use stdClass;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;



class ScrapeController extends Controller
{
    public function show()
    {
        $shops = [
            'dreamBaby' => "dreamBaby",
            'mimibaby' => 'Mimi Baby',
            'littleMoustache' => 'Little Moustache',
            
        ];

        $dreamBabyCategories = Category::where('webshop', 'dreamBaby')->get();
        $mimibabyCategories = Category::where('webshop', 'mimibaby')->get();
        $littleMoustacheCategories = Category::where('webshop', 'littleMoustache')->get();

        return view('admin.scrape-form', compact('shops', 'dreamBabyCategories', 'mimibabyCategories', 'littleMoustacheCategories'));
    }

    public function scrapeCategories(Request $r){

        switch($r->shop){

            case 'dreamBaby' :
                $this->scrapedreamBabyCategories($r->url);
                break;
            case 'mimibaby' :
                $this->scrapemimibabyCategories($r->url);
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
        
        $sitemap_articles = $this->scrapeSitemapDreamBaby();
        $articles =$this->scrapedreamBabyPageData($crawler, $sitemap_articles);
        return view('admin.scrape-result', compact('articles'));
    }

    private function scrapeSitemapDreamBaby(){
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.dreambaby.be/ecomwcs/no_deploy/sitemap/dreambaby/sitemap-dreambaby-nl-product-1.xml');
        $nodes = $crawler->filterXPath('//default:url')->each(function($node){
            $article = new stdClass();
            $article->loc = $node->filterXPath('//default:loc')->first()->text();
            if($node->filterXPath('//image:image')->count()){
                $article->image = $node->filterXPath('//image:loc')->first()->text();
            }
            return $article;
        });
        return $nodes;
    }

    // Scrape ALL articles from specific categorie on 1 page
    private function scrapedreamBabyPageData($crawler,$sitemap_articles) {
        $articles = [];

        foreach($crawler->filter('div[base-product-name]') as $domElement) {
            $node = new Crawler($domElement);
            $article = new stdClass();
            $article->title = $node->filter('.product_info a .product_name')->text();
            $article->url = $node->filter('a')->first()->attr("href");
            $article->img = "";
            foreach ( $sitemap_articles as $element ) {
                if ( $article->url == $element->loc ) {
                    $article->image =  $element->image;
                    break;
                }
            }
            $article->price = $node->filter('.product_info .product_price .product_price .price .value')->text();
            array_push($articles, $article);

            $ArticleEntity = new Article();
            $ArticleEntity->title = $article->title;
            $ArticleEntity->slug = self::slugify($article->title);
            $ArticleEntity->price = $article->price;
            $ArticleEntity->src = $article->image;
            $ArticleEntity->save();
            
        }

        return $articles;



       
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
           
            return $article;

        });

                foreach($articles as $scrapeArticle) {

                    // Check if exists
                    $exists = Category::where('url' , $scrapeArticle->title)->count();
                    if ($exists > 0) continue;

                    // Create/Add new category to database
                    $ArticleEntity = new Article();
                   
                    $ArticleEntity->title = $scrapeArticle->title;
                    $ArticleEntity->slug = self::slugify($scrapeArticle->title);
                    $ArticleEntity->price = $scrapeArticle->price;
                    $ArticleEntity->src = $scrapeArticle->image;
                    
                    $ArticleEntity->save();
                };
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
        
        $sitemap_articles = $this->scrapeSitemapLitteMoustache();
        $articles =$this->scrapelittleMoustachePageData($crawler,$sitemap_articles);
        return view('admin.scrape-result', compact('articles'));
    }

    private function scrapeSitemapLitteMoustache(){
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.little-moustache.be/store-products-sitemap.xml');
        $nodes = $crawler->filterXPath('//default:url')->each(function($node){
            $article = new stdClass();
            $article->loc = $node->filterXPath('//default:loc')->first()->text();
            if($node->filterXPath('//image:image')->count()){
                $article->image = $node->filterXPath('//image:loc')->first()->text();
            }
            return $article;
        });
        return $nodes;
    }


    // Scrape ALL articles from specific categorie on 1 page
    private function scrapelittleMoustachePageData($crawler,$sitemap_articles) {
        $articles = [];
        foreach($crawler->filter('.S4WbK_ li') as $domElement) {
            $node = new Crawler($domElement);
            $article = new stdClass();
            $article->title = $node->filter('.sMuaBcZ')->text();
            $article->url = $node->filter('a')->first()->attr("href");
            $article->img = "";
            foreach ( $sitemap_articles as $element ) {
                if ( $article->url == $element->loc ) {
                    $article->image =  $element->image;
                    break;
                }
            }
            $article->price = $node->filter('.cfpn1d')->text();
            array_push($articles, $article);

            $ArticleEntity = new Article();
            $ArticleEntity->title = $article->title;
            $ArticleEntity->slug = self::slugify($article->title);
            $ArticleEntity->price = $article->price;
            $ArticleEntity->src = $article->image;
            $ArticleEntity->save();
            
        }

     
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
