<?php


namespace App\Repositories\App;


use App\Models\Article;
use App\Models\Category;
use App\Models\Device;
use App\Models\Favorite;
use App\Models\Page;
use App\Models\PageLink;

class AppRepository implements AppInterface
{

    public function getSystemData(string $deviceToken): array
    {
        $categories = Category::select('id', 'name', 'is_published')->where('is_published', true)->orderBy('id')->get();
        $deviceInfo = Device::firstOrCreate(['token' => $deviceToken, 'user_id' => null]);
        $settings = setting()->get('general');
        $pages = PageLink::where('key', 'app_navigation_pages')->with('page:id,title')->get();

        return ['categories' => $categories, 'settings' => $settings, 'deviceInfo' => $deviceInfo, 'pages' => $pages];
    }

    public function saveFavorites(array $data)
    {
        return Favorite::create($data);
    }

    public function removeFavorites($data)
    {
        return Favorite::where($data)->delete();
    }

    public function getFavorites(int $deviceId, $latestArticleOffset, $limit = 10)
    {
        return Article::whereHas('categories', function ($q) {
            $q->where('is_published', true);
        })
            ->whereHas('favorites', function ($q) use ($deviceId) {
                $q->where('device_id', $deviceId);
            })
            ->with('categories:id,name,slug')
            ->where('published', true)->select('id', 'title', 'slug', 'published', 'viewed', 'image', 'featured', 'read_time')
            ->latest()
            ->offset($latestArticleOffset * $limit)
            ->limit($limit)
            ->get();
    }

    public function updatePersonalSettings(array $data, int $deviceId)
    {
        setting([$deviceId => $data])->save();

        return setting()->get($deviceId);
    }

    public function getPersonalSettings(int $deviceId)
    {
        return setting()->get($deviceId);
    }

    public function getPageInfo($id)
    {
        return Page::with('keywords')
            ->where('published', true)
            ->where('id', $id)
            ->first();
    }
}
