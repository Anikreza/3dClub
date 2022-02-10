<?php

namespace App\Repositories\Article;

use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\SubCategory;
use App\Models\Visitor;
use Cache;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Str;

class ArticleRepository implements ArticleInterface
{

    private $model;
    private $disk = 'public';

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function save(Request $request)
    {

        $image = $request->image;
        if ($image) {
            $image_ext = $image->getClientOriginalExtension();
            $image_full_name = time() . '.' . $image_ext;
            $upload_path = 'assets/images/';
            $image_url = $upload_path . $image_full_name;

            $success = $image->move($upload_path, $image_full_name);
        } else {
            $image_url = '';
        }

        $article = Article::create([
            'user_id' => auth()->user()->id,
            'title' => $request->input('title'),
            'slug' => $this->slugify($request->input('title')),
            'excerpt' => $request->input('excerpt'),
            'featured' => filter_var($request->input('featured'), FILTER_VALIDATE_BOOLEAN),
            'description' => $request->input('description'),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
            'image_disk' => $this->disk,
            'meta_title' => $request->input('meta_title'),
            'image' => $image_url,
        ]);
        // Category
        $article->categories()->sync([$request->input('categories')]);

        $subCategory = SubCategory::create([
            'whichCategory_id' => $request->input('categories'),
            'name' => $request->input('city'),
            'slug' => $this->slugify($request->input('city')),
        ]);

        // Keywords
        $newKeywords = explode(',', $request->input('keywords'));
        $keywordIds = [];

        foreach ($newKeywords as $keyword) {
            $keyword = Keyword::firstOrCreate(['title' => $keyword]);
            array_push($keywordIds, $keyword->id);
        }

        $article->keywords()->sync($keywordIds);

        return $article;
    }

    private function slugify($name): string
    {
        return \Str::slug($name);
    }

    public function update(Request $request, int $id): array
    {
        $article = Article::findOrFail($id);
        $isPublishedBefore = $article->published;

        $image = $request->image;
        if ($image) {
            $image_ext = $image->getClientOriginalExtension();
            $image_full_name = time() . '.' . $image_ext;
            $upload_path = 'assets/images/';
            $image_url = $upload_path . $image_full_name;

            $success = $image->move($upload_path, $image_full_name);
        } else {
            $image_url = '';
        }

        $data = [
            'title' => $request->input('title'),
            'slug' => $this->slugify($request->input('title')),
            'excerpt' => $request->input('excerpt'),
            'featured' => filter_var($request->input('featured'), FILTER_VALIDATE_BOOLEAN),
            'description' => $request->input('description'),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
            'meta_title' => $request->input('meta_title'),
            'image' => $image_url,
        ];

        // Category
        $article->categories()->detach();
        $article->categories()->sync([$request->input('categories')]);

        // Keywords
        $newKeywords = explode(',', $request->input('keywords'));
        $keywordIds = [];

        foreach ($newKeywords as $keyword) {
            $keyword = Keyword::firstOrCreate(['title' => $keyword]);
            array_push($keywordIds, $keyword->id);
        }

        $article->keywords()->detach();
        $article->keywords()->sync($keywordIds);
        $article->update($data);

        return ['article' => $article, 'previouslyPublished' => $isPublishedBefore];
    }

    public function delete(string $id)
    {
        $article = Article::where('slug','=',$id);

//        $article->categories()->detach();
//        $article->keywords()->detach();

        SubCategory::where('slug','=',$id)->delete();

        return $article->delete();
    }

    public function all(array $columns = [])
    {
        return count($columns) ? Article::select($columns)->orderBy('id')->get() : Article::orderBy('viewed')->get();
    }

    public function paginate($perPage = 10)
    {
        return Article::latest()
            ->with(['categories'])
            ->when(request()->has('category'), function ($q) {
                $q->whereHas('categories', function ($sq) {
                    $sq->where('category_id', \request('category'));
                });
            })
            ->when(request()->has('is_published'), function ($q) {
                $q->where('published', (bool)request('is_published'));
            })
            ->when(\request()->has('search'), function ($q) {
                $q->where('title', 'LIKE', '%' . \request('search') . '%');
            })
            ->orderBy('viewed', 'desc')
            ->paginate($perPage);
    }

    public function paginateWithFilter(int $limit)
    {
        // TODO: Implement paginateWithFilter() method.
    }

    public function paginateByCategoryWithFilter(int $perPage, int $categoryId)
    {
        return $this->baseQuery($categoryId)
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed', 'description')
            ->latest()
            ->paginate($perPage);
    }

    public function paginateAllProducts(int $perPage)
    {
        return $this->model
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed', 'description', 'price', 'excerpt')
            ->latest()
            ->paginate($perPage);
    }

    public function getArticleCount()
    {
        return Article::where('created_at', '>', Carbon::now()->subDays(1))
            ->groupBy(\DB::raw('HOUR(created_at)'))
            ->count();
    }

    public function getAllArticleCount(): int
    {
        return Article::all()->count();
    }

    public function SetVisitor()
    {
        $ip = request()->ip();
        $visited_date = Carbon::now();
        $visitor = Visitor::firstOrCreate(['ip' => $ip], ['visit_date' => $visited_date]);
        $visitor->increment('hits');
        $visitor->increment('lastDayRecord');

        Visitor::where('visit_date', '<', Carbon::now()->subDays(1))
            ->update(['lastDayRecord' => 0]);

        Visitor::where('created_at', '<', Carbon::now()->subDays(1))
            ->update(['visit_date' => Carbon::now(), 'created_at' => Carbon::now()]);


    }

    public function getTotalVisitCount(): int
    {
        return Visitor::sum('hits');
    }

    public function getLastDaysTotalVisitCount(): int
    {
        return Visitor::where('updated_at', '>', Carbon::now()->subDays(1))
            ->sum('lastDayRecord');
    }

    public function getUniqueVisitorCount(): int
    {
        return Visitor::all()->count();
    }

    public function getLastWeeksUniqueVisitorCount()
    {
        return Visitor::where('updated_at', '>', Carbon::now()->subDays(7))
            ->count('id');
    }

    public function getLastWeeksVisitCountByDay()
    {
        //
//        $visitorsPerDay = [];
//        foreach ($data as $key=>$item) {
//            $visitorsPerDay[] = $item->visits;
//        }
        return Visitor::select(DB::raw('sum(hits) as visits'))
            ->where('visit_date', ">", DB::raw('NOW() - INTERVAL 1 WEEK'))
            ->groupBy('visit_date')
            ->get();
    }

    public function getCategoriesCount(): int
    {
        return Category::all()->count();
    }

    private function baseQuery(int $categoryId = 1)
    {
        return $this->model->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('is_published', '=', 0);
            $q->when($categoryId !== 1, function ($sq) use ($categoryId) {
                $sq->where('category_id', $categoryId);
            });
        });
    }

    public function publishedArticles(int $categoryId, int $limit)
    {
        return $this->model
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed', 'description', 'excerpt', 'price')
            ->with('categories')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function publishedFeaturedArticles(int $categoryId, int $limit)
    {
        return $this->baseQuery($categoryId)
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed', 'description')
            ->where('featured', 1)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function mostReadArticles(int $categoryId, int $limit)
    {
        return $this->baseQuery($categoryId)
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed', 'description')
            ->limit($limit)
            ->orderBy('viewed', 'desc')
            ->get();
    }

    public function getArticle($condition, $isSlug = true)
    {
        return $this->model->with(['categories' => function ($q) use ($condition, $isSlug) {
            $q->with(['articles' => function ($sq) use ($condition, $isSlug) {
                $sq->select('article_id', 'title', 'slug', 'published', 'viewed', 'image', 'featured', 'description', 'price')
                    ->where('published', '=', true)
                    ->when($isSlug, function ($s) use ($condition, $isSlug) {
                        $s->where('slug', '!=', $condition);
                    })
                    ->when(!$isSlug, function ($s) use ($condition, $isSlug) {
                        $s->where('article_id', '!=', $condition);
                    })
                    ->inRandomOrder()
                    ->limit(4);
            }]);
        }])
            ->with('keywords')
            ->where('published', true)
            ->when($isSlug, function ($q) use ($condition) {
                $q->where('slug', $condition);
            })
            ->when(!$isSlug, function ($q) use ($condition) {
                $q->where('id', $condition);
            })
            ->first();
    }

    public function getSimilarArticles($categoryId, $limit)
    {
        return $this->baseQuery($categoryId)
            ->select('id', 'title', 'slug', 'published', 'viewed', 'image', 'featured', 'description')
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function searchArticles($query, $perPage)
    {
        return $this->baseQuery(1)
            ->select('id', 'title', 'slug', 'published', 'viewed', 'image', 'featured', 'description')
            ->where('title', 'LIKE', '%' . $query . '%')
            ->latest()
            ->limit(5)
            ->paginate($perPage);
    }

    public function getAllTags()
    {
        return Keyword::all();
    }

    public function getTagInfoWithArticles($tag, $perPage, $includeFavorites = false): array
    {
        $string = Str::title(str_replace('-', ' ', trim($tag)));
        $tag = Keyword::where('title', 'LIKE', '%' . $string . '%')->get();
        $tags = Keyword::all();

        return [
            'tagInfo' => count($tag) ? $tag[0] : null,
            'tags' => count($tags) ? $tags : null,
            'articles' => count($tag) ? $this->getArticlesByTag($perPage, $tag->pluck('id')->toArray(), $includeFavorites) : []
        ];
    }

    public function getArticlesByTag($perPage, array $keywordIds, $includeFavorites = false)
    {
        $q = $this->model->whereHas('keywords', function ($q) use ($keywordIds) {
            $q->whereIn('keyword_id', $keywordIds);
        })
            ->with('categories:id,name,slug')
            ->with('keywords:id,title')
            ->where('published', true)
            ->when($includeFavorites, function ($q) {
                $q->with(['favorites']);
            })
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed', 'description')
            ->latest();

        return $perPage === 4 ? $q->limit($perPage)->get() : $q->paginate($perPage);
    }

}
