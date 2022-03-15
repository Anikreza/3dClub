<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\NewsLetter;
use App\Models\Order;
use App\Models\Page;
use App\Models\PageLink;
use App\Models\SubCategory;
use App\Repositories\Article\ArticleRepository;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Share;


class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    private $articleRepository;
    private $baseSeoData;
    private $homePageSeoData;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->homePageSeoData = json_decode(setting()->get('general'), true);
        $this->baseSeoData = [
            'title' => $this->homePageSeoData['home_page_title'],
            'description' => $this->homePageSeoData['home_page_description'],
            'keywords' => $this->homePageSeoData['home_page_keywords'],
            'image' => $this->homePageSeoData['home_page_image_url'] ?
                Storage::disk('public')->url('settings/' . basename($this->homePageSeoData['home_page_image_url']))
                :
                asset('asset/logo.png'),
            'type' => 'website',
            'site' => env('APP_URL'),
            'app_name' => $this->homePageSeoData['app_name'],
            'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1'
        ];

        $this->articleRepository = $articleRepository;
        $categories = Category::with('subCategory', 'articles')->get();
        $featuredArticles = $this->articleRepository->publishedArticles(1, 3);
        $footerPages = \Cache::remember('footer_pages', config('cache.default_ttl'), function () {
            return PageLink::where('key', 'footer_pages')->with('page:id,title,slug')->get()->toArray();
        });

        view()->share('footerPages', $footerPages);
        view()->share('categories', $categories);
    }

    public function shop()
    {
        $segments = [
            [
                'name' => "Our Models",
            ],
        ];

        $allArticles = $this->articleRepository->paginateAllProducts(5);
        $title = request()->has('page') ? 'Shop' . " (Page " . request('page') . ')' : 'Shop';
        $app = $this->homePageSeoData['app_name'];
        $this->baseSeoData['title'] = "{$title} | {$app}";
        $this->baseSeoData['description'] = "Buy 3d models from 3dClub";
        $this->seo($this->baseSeoData);
        return view('pages.products.index',
            compact(
                'allArticles',
                'segments'
            )
        );
    }

    public function about()
    {
        $segments = [
            [
                'name' => "About Us",
            ],
        ];

        $title = request()->has('page') ? 'About' . " (Page " . request('page') . ')' : 'About';
        $app = $this->homePageSeoData['app_name'];
        $this->baseSeoData['title'] = "{$title} | {$app}";
        $this->seo($this->baseSeoData);
        return view('pages.about.index',
            compact(
                'segments'
            )
        );
    }

    public function contact()
    {
        $title = request()->has('page') ? 'Contact' . " (Page " . request('page') . ')' : 'Contact';
        $app = $this->homePageSeoData['app_name'];
        $this->baseSeoData['title'] = "{$title} | {$app}";
        $this->seo($this->baseSeoData);
        return view('pages.contact.index');

    }

    public function index()
    {

        $this->articleRepository->SetVisitor();
        $publishedArticles = $this->articleRepository->publishedArticles(1, 3);
        $featuredArticles = $this->articleRepository->publishedFeaturedArticles(3);
        $mostReadArticles = $this->articleRepository->mostReadArticles(1, 3);
//        dd($publishedArticles);
        $this->seo($this->baseSeoData);

        return view('pages.home.index',
            compact(
                'publishedArticles',
                'featuredArticles',
                'mostReadArticles'
            )
        );
    }

    public function addToCart(Request $request)
    {
        $product = Article::findOrFail($request->input('product_id'));
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cartItems')->with('success_message', "{$product->title} was already in your cart!");
        }

        Cart::add($product->id, $product->title, 1, $product->price, 0, ['image' => $product->image])
            ->associate('App\Models\Article');

        return redirect()->route('cartItems')->with('success_message', "{$product->title} is added to your cart");


//        return Redirect::route('cartItems')->with('message', 'successfully added');
//        return redirect()->back();

    }

    public function showCart()
    {
        $cartItems = Cart::content();;
        $count = $cartItems->count();
        $subtotal = Cart::subtotal();
        $title = request()->has('page') ? 'Shopping' . " (Page " . request('page') . ')' : 'Shopping';
        $app = $this->homePageSeoData['app_name'];
        $this->baseSeoData['title'] = "{$title} | {$app}";
        $this->seo($this->baseSeoData);
        return view('pages.cart.index', compact('cartItems', 'subtotal', 'count'));
    }

    public function checkout(Request $request)
    {
        $contents = Cart::content()->map(function ($item) {
            return $item->model->title;
        })->values()->toJson();
        $subtotal = Cart::subtotal();

        Order::create([
            'firstname' => $request->input('firstName'),
            'lastname' => $request->input('lastName'),
            'email' => $request->input('email'),
            'cardName' => $request->input('cardName'),
            'cardNumber' => $request->input('cardNumber'),
            'cardExpiration' => $request->input('cardExpiration'),
            'cvv' => $request->input('cvv'),
            'products' => $contents,
            'total' => $subtotal
        ]);
        return Redirect::route('contact');
    }

  public function sendBuyMail(Request $request)
    {
        $contents = Cart::content()->map(function ($item) {
            return $item->model->title;
        })->values()->toJson();
        $subtotal = Cart::subtotal();

        $data = [
            'recipent' => 'alexthegreatmaiden@gmail.com',
            'firstname' => $request->input('firstName'),
            'lastname' => $request->input('lastName'),
            'email' => $request->input('email'),
            'subject' => "Hey Shagor! I wanted to buy Something from you",
            'products' => $contents,
            'total' => $subtotal,

        ];
//        $data = $request->only('name', 'email', 'subject', 'message');
//        \Mail::to('anikreza22@gmail.com')->send(new SendContactMail($data));

      \Mail::send('email.buyProductsTemplate',$data, function ($message) use ($data) {
          $message->to($data['recipent'])
              ->from($data['email'], $data['lastname'])
              ->subject($data['subject']);
      });

        return Redirect::route('home');
    }

    public function confirmPayment(Request $request)
    {
        return view('pages.checkout.index');
    }

    public function deleteCart($id)
    {
        Cart::remove($id);
        return back();
    }

    public function articleDetails($slug)
    {
        $product = $this->articleRepository->getArticle($slug, true);
        if (!$product) {
            return $this->renderPage($slug);
        }
        $category = $product['categories'][0];
//        $similarArticles = $this->articleRepository->getSimilarArticles($category['id'], 2);
//        $tags = $product->keywords;
        $tagTitles = [];
//        foreach ($tags as $tag)
//            array_push($tagTitles, $tag->title);
        $segments = [
            [
                'name' => $product['categories'][0]['name'],
                'url' => route('category', [
                    'slug' => $category['slug']
                ])
            ],
            ['name' => $product['title'], 'url' => url($slug)]
        ];
        $cacheKey = request()->ip() . $slug;
        \Cache::remember($cacheKey, 60, function () use ($product) {
            $product->viewed = $product->viewed + 1;
            $product->save();
            return true;
        });

        $appName = env('APP_NAME');
        $this->baseSeoData['title'] = " $product->title - $appName";
        $this->baseSeoData['keywords'] = $tagTitles;
        $this->seo($this->baseSeoData);
        $shareLinks = $this->getSeoLinksForDetailsPage($product);

        return view('pages.productDetails.index', compact('product', 'shareLinks', 'category', 'segments'));
    }

    public function categoryDetails($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $segments = [
            [
                'name' => "{$category->name}",
                'url' => route('category', ['slug' => $category->slug])
            ],
        ];

        $categoryArticles = $this->articleRepository->paginateByCategoryWithFilter(5, $category->id);
        $name = empty($category->meta_title) ? $category->name : $category->meta_title;
        $title = request()->has('page') ? $name . " (Page " . request('page') . ')' : $name;
        $this->baseSeoData['title'] = "{$title} | {$category->name} | {$category->keywords}";
        $this->baseSeoData['description'] = "{$category->excerpt}";
        $this->baseSeoData['keywords'] = "{$category->keywords}";
        $this->seo($this->baseSeoData);

        return view('pages.category.index', compact('segments', 'category','categoryArticles'));
    }

    public function searchArticle(Request $request)
    {
            if($request->input('query')!==''){
                $searchTerm = $request->input('query');
            }
            else{
                $searchTerm='Models';
            }

        $allArticles = $this->articleRepository->searchArticles($searchTerm, 5);

        $segments = [
            ['name' => $searchTerm],
        ];

        // SEO META INFO
        $appName = env('APP_NAME');
        $this->baseSeoData['title'] = "$searchTerm - $appName";
        $this->seo($this->baseSeoData);

        return view('pages.products.index', compact('segments', 'searchTerm', 'allArticles'));
    }

    public function renderPage($slug)
    {
        $page = Page::where('slug', $slug)->with('keywords')->first();

        if (!$page) {
            abort(404);
        }

        //visitor count
        $cacheKey = request()->ip() . $slug;
        \Cache::remember($cacheKey, 60, function () use ($page) {
            $page->viewed = $page->viewed + 1;
            $page->save();
            return true;
        });

        $segments = [
            ['name' => $page['title'], 'url' => url($slug)]
        ];
        $shareLinks = $this->getSeoLinksForDetailsPage($page);

        return view('pages.page-details.index', compact('page', 'segments', 'shareLinks'));
    }

    private function getSeoLinksForDetailsPage($data)
    {
        $this->baseSeoData = [
            'title' => $data->title . " | {$this->baseSeoData['app_name']}",
            'description' => $data->excerpt,
            'keywords' => count($data->keywords) ? implode(", ", $data->keywords->pluck('title')->toArray()) : $this->baseSeoData['keywords'],
            'image' => $data->image_url,
            'type' => 'article',
            'site' => env('APP_URL'),
            'app_name' => $this->baseSeoData['app_name'],
            'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1'
        ];
        $this->seo($this->baseSeoData);

        return Share::page(url()->current(), $data->title)
            ->facebook()
            ->twitter()
            ->linkedin($data->excerpt)
            ->whatsapp()
            ->telegram()
            ->getRawLinks();
    }

    public function sendMail(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email|required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        $data = [
            'recipent' => 'alexthegreatmaiden@gmail.com',
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'body' => $request->message
        ];
//        $data = $request->only('name', 'email', 'subject', 'message');
//        \Mail::to('anikreza22@gmail.com')->send(new SendContactMail($data));

        \Mail::send('email.contact-template',$data, function ($message) use ($data) {
            $message->to($data['recipent'])
                ->from($data['email'], $data['name'])
                ->subject($data['subject']);
        });

        return Redirect::back()->with('success', 'Thank you, we have got your message');
    }


    public function newsLetters(Request $request): \Illuminate\Http\RedirectResponse
    {

        $request->validate([
            'email' => 'email|required',
        ]);

        NewsLetter::create([
            'email' => $request->input('email')
        ]);

        return back()->with("success", "Thanks! We Got You!!");
    }

    public function sendNewsLetters(Request $request): \Illuminate\Http\RedirectResponse
    {
//        $subscribers = NewsLetter::all();
//        $data = [];
//        $subject = "Hey Man";
//        $body = "This Is The Body";
//        $name = 'Name';
//        $email = env('MAIL_USERNAME');
//        for ($i = 0; $i < $subscribers->count(); $i++) {
//            \Mail::send('email.mail', $data, function ($message) use ($subscribers, $i) {
//                $message->to($subscribers[$i]->email)
//                    ->from('Anikreza22@gmail.com', 'Anik Reza')
//                    ->subject('Subject Line');
//            });
//        }

        return back()->with("success", "Thank You, We've Got You");
    }

    private function seo($data)
    {
        SEOMeta::setTitle($data['title'], false);
        SEOMeta::setDescription($data['description']);
//        SEOMeta::addMeta('name', $value = null, $name = 'name');
        SEOMeta::setKeywords($data['keywords']);
        SEOMeta::setRobots($data['robots']);
        SEOMeta::setCanonical(url()->full());

//        OpenGraph::addProperty('keywords', '$value'); // value can be string or array
        OpenGraph::setTitle($data['title']); // define title
        OpenGraph::setDescription($data['description']);  // define description

        if ($data['image']) {
            OpenGraph::addImage($data['image']); // add image url
        } else {
            OpenGraph::addImage($this->homePageSeoData['home_page_image_url']); // add image url
        }

        OpenGraph::setUrl(url()->current()); // define url
        OpenGraph::setSiteName($data['app_name']); //define site_name

        TwitterCard::setType('summary'); // type of twitter card tag
        TwitterCard::setTitle($data['title']); // title of twitter card tag
        TwitterCard::setDescription($data['description']); // description of twitter card tag

        if ($data['image']) {
            TwitterCard::setImage($data['image']); // add image url
        } else {
            TwitterCard::setImage($this->homePageSeoData['home_page_image_url']); // add image url
        }

        TwitterCard::setSite($data['site']); // site of twitter card tag
        TwitterCard::setUrl(url()->current()); // url of twitter card tag

        if (isset($data['read_time'])) {
            TwitterCard::addValue('label1', 'Est. reading time'); // value can be string or array
            TwitterCard::addValue('data1', $data['read_time']); // value can be string or array
        }

//        JsonLd::addValue($key, $value); // value can be string or array
        JsonLd::setType($data['type']); // type of twitter card tag
        JsonLd::setTitle($data['title']); // title of twitter card tag
        JsonLd::setDescription($data['description']); // description of twitter card tag

        if ($data['image']) {

            JsonLd::setImage($data['image']); // add image url
        } else {
            JsonLd::setImage($this->homePageSeoData['home_page_image_url']); // add image url
        }
        JsonLd::setSite('@3dClub'); // site of twitter card tag
        JsonLd::setUrl(url()->current()); // url of twitter card tag
    }
}
