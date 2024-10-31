<?php
namespace App\Http\Controllers;
use App\Models\FAQ;

class HomeController extends Controller
{
    public function homePageData() {
        $categories = [
            ['name' => 'IT/Software Jobs', 'image' => 'images/categories/it-software-jobs.png', 'link' => '/cat/it-software-jobs'],
            ['name' => 'Internships', 'image' => 'images/categories/internships.png', 'link' => '/cat/internships'],
            ['name' => 'Teaching Jobs', 'image' => 'images/categories/teaching-jobs.png', 'link' => '/cat/teaching-jobs'],
            ['name' => 'Cleaning Jobs', 'image' => 'images/categories/cleaning-jobs.png', 'link' => '/cat/cleaning-jobs'],
            ['name' => 'Babysitting Jobs', 'image' => 'images/categories/babysitting-jobs.png', 'link' => '/cat/babysitting-jobs'],
            ['name' => 'Other Jobs', 'image' => 'images/categories/other-jobs.png', 'link' => '/cat/other-jobs'],
        ];
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
            ['name' => 'Jonköping', 'image' => 'images/cities/jonkoping.png', 'link' => '/city/jonköping'],
            ['name' => 'Kiruna', 'image' => 'images/cities/kiruna.png', 'link' => '/city/kiruna'],
        ];
        $faqs = FAQ::latest()->take(8)->get();
        return view('home', compact('categories', 'cities', 'faqs'));
    }
}
