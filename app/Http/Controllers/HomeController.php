<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\FAQ;
use App\Models\BlogPost;

class HomeController extends Controller
{
    public function homePageData() {
        $categories = $this->getCategories();
        $cities = $this->getCities();
        $faqs = FAQ::latest()->take(5)->get();
        $posts = BlogPost::orderBy('published_at', 'desc')->select('title', 'slug')->get();
        return view('home', data: compact('categories', 'cities', 'faqs', 'posts'));
    }
    public function searchBox() {
        $cities = $this->getCities();
        return view('search', data: compact('cities'));
    }
    public function findAJob() {
        $categories = collect($this->getCategories());
        $cities = collect($this->getCities());
        return view('find-a-job', data: compact('cities', 'categories'));
    }
    public function getCategories() {
        $categories = [
            ['name' => 'IT/Software Jobs', 'image' => 'images/categories/it-software-jobs.png', 'link' => '/cat/it-software-jobs', 'slug' => 'it-software-jobs'],
            ['name' => 'Internships', 'image' => 'images/categories/internships.png', 'link' => '/cat/internships/', 'slug' => 'internships'],
            ['name' => 'Teaching Jobs', 'image' => 'images/categories/teaching-jobs.png', 'link' => '/cat/teaching-jobs/', 'slug' => 'teaching-jobs'],
            ['name' => 'Cleaning Jobs', 'image' => 'images/categories/cleaning-jobs.png', 'link' => '/cat/cleaning-jobs/', 'slug' => 'cleaning-jobs'],
            ['name' => 'Babysitting Jobs', 'image' => 'images/categories/babysitting-jobs.png', 'link' => '/cat/babysitting-jobs/', 'slug' => 'babysitting-jobs'],
            ['name' => 'Other Jobs', 'image' => 'images/categories/other-jobs.png', 'link' => '/cat/other-jobs/', 'slug' => 'other-jobs'],
        ];
        foreach ($categories as &$category) {
            $category['total_jobs'] = $this->getTotalJobs($category['slug'], 'cat');
        }    
        return $categories;
    }
    public function getCities() {
        $cities = [
            ['name' => 'Stockholm', 'image' => 'images/cities/stockholm.png', 'link' => '/city/stockholm', 'slug' => 'stockholm'],
            ['name' => 'Göteborg', 'image' => 'images/cities/gothenburg.png', 'link' => '/city/göteborg', 'slug' => 'Göteborg'],
            ['name' => 'Malmö', 'image' => 'images/cities/malmo.png', 'link' => '/city/malmö', 'slug' => 'Malmö'],
            ['name' => 'Uppsala', 'image' => 'images/cities/uppsala.png', 'link' => '/city/uppsala', 'slug' => 'uppsala'],
            ['name' => 'Västerås', 'image' => 'images/cities/vasteras.png', 'link' => '/city/vasterås', 'slug' => 'Västerås'],
            ['name' => 'Örebro', 'image' => 'images/cities/orebro.png', 'link' => '/city/örebro', 'slug' => 'Örebro'],
            ['name' => 'Linköping', 'image' => 'images/cities/linkoping.png', 'link' => '/city/linköping', 'slug' => 'Linköping'],
            ['name' => 'Norrköping', 'image' => 'images/cities/norrkoping.png', 'link' => '/city/norrköping', 'slug' => 'Norrköping'],
        ];
        foreach ($cities as &$city) {
            $city['total_jobs'] = $this->getTotalJobs($city['slug'], 'city');
        }
    
        return $cities;
    }
    public function getTotalJobs($slug, $pageType) {
        $cacheKey = "total_jobs_{$pageType}_{$slug}";
    
        return Cache::remember($cacheKey, now()->addHours(24), function () use ($slug, $pageType) {
            return DB::table('total_jobs')
                ->where('slug', $slug)
                ->where('page_type', $pageType)
                ->value('total_jobs') ?? 0;
        });
    }
}
