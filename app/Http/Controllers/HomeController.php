<?php
namespace App\Http\Controllers;
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
            ['name' => 'IT/Software Jobs', 'image' => 'images/categories/it-software-jobs.png', 'link' => '/cat/it-software-jobs'],
            ['name' => 'Internships', 'image' => 'images/categories/internships.png', 'link' => '/cat/internships/'],
            ['name' => 'Teaching Jobs', 'image' => 'images/categories/teaching-jobs.png', 'link' => '/cat/teaching-jobs/'],
            ['name' => 'Cleaning Jobs', 'image' => 'images/categories/cleaning-jobs.png', 'link' => '/cat/cleaning-jobs/'],
            ['name' => 'Babysitting Jobs', 'image' => 'images/categories/babysitting-jobs.png', 'link' => '/cat/babysitting-jobs/'],
            ['name' => 'Other Jobs', 'image' => 'images/categories/other-jobs.png', 'link' => '/cat/other-jobs/'],
        ];
        return $categories;
    }
    public function getCities() {
        $cities = [
            ['name' => 'Stockholm', 'image' => 'images/cities/stockholm.png', 'link' => '/city/stockholm'],
            ['name' => 'Göteborg', 'image' => 'images/cities/gothenburg.png', 'link' => '/city/Göteborg'],
            ['name' => 'Malmö', 'image' => 'images/cities/malmo.png', 'link' => '/city/malmö'],
            ['name' => 'Uppsala', 'image' => 'images/cities/uppsala.png', 'link' => '/city/uppsala'],
            ['name' => 'Västerås', 'image' => 'images/cities/vasteras.png', 'link' => '/city/västerås'],
            ['name' => 'Örebro', 'image' => 'images/cities/orebro.png', 'link' => '/city/örebro'],
            ['name' => 'Linköping', 'image' => 'images/cities/linkoping.png', 'link' => '/city/linköping'],
            ['name' => 'Norrköping', 'image' => 'images/cities/norrkoping.png', 'link' => '/city/norrköping'],
            ['name' => 'Lund', 'image' => 'images/cities/lund.png', 'link' => '/city/lund'],
            ['name' => 'Helsingborg', 'image' => 'images/cities/helsingborg.png', 'link' => '/city/helsingborg'],
            ['name' => 'Jönköping', 'image' => 'images/cities/jonkoping.png', 'link' => '/city/jönköping'],
            ['name' => 'Kiruna', 'image' => 'images/cities/kiruna.png', 'link' => '/city/kiruna'],
        ];
        return $cities;
    }
}
