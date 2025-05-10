<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\BlogPost;
use DB;


class JobController extends Controller
{
    public function connectJobtechAPI($endPoint) {
        $apiUrl = 'https://jobsearch.api.jobtechdev.se/';
        $response = Http::withHeaders([
            'Accept' => 'application/json',

        ])->get($apiUrl . $endPoint);
        return $response->json();
    }
    public function jobListByCategory($slug, $page=1) {
        if ($slug === "it-software-jobs") {
            $searchKey = "search?q=IT+softwaredeveloper+programmer+english";
            $pageTitle = "Top IT and Software Jobs in Sweden - English Speaking positions";
            $pageHeadding = "Find IT and Software Jobs in Sweden";
            $pageDescription = "Discover high-paying IT and software jobs (Jobba) in Sweden for English speaking professionals";
        } else if ($slug === "internships") {
            $searchKey = "search?q=Internship";
            $pageTitle = "Internship Opportunities in Sweden 2025- Kickstart Your Career in 2025";
            $pageHeadding = "Explore Internships in Sweden - 2025";
            $pageDescription = "Find English speaking internships in Sweden. Gain hands-on experience, develop new skills, and grow your career with top organizations.";
        } else if ($slug === "teaching-jobs") {
            $searchKey = "search?q=teaching";
            $pageTitle = "English Teaching Jobs in Sweden";
            $pageHeadding = "Find Teaching Jobs in Sweden";
            $pageDescription = "Browse Englishspeaking teaching jobs in Sweden. From early childhood education to university teaching positions, discover your next teaching role.";
        } else if ($slug === "cleaning-jobs") {
            $searchKey = "search?q=cleaning";
            $pageTitle = "Cleaning Jobs in Sweden";
            $pageHeadding = "Discover Cleaning Jobs in Sweden";
            $pageDescription = "Find cleaning jobs in Sweden. Whether you're looking for part-time or full-time opportunities, explore English speaking jobs that match your availability.";
        } else if ($slug === "babysitting-jobs") {
            $searchKey = "search?q=babysitting";
            $pageTitle = "Babysitting Jobs in Sweden - English-Speaking Childcare Roles";
            $pageHeadding = "Find Babysitting Jobs in Sweden";
            $pageDescription = "Find English speaking babysitting jobs in Sweden. Provide childcare services to families while building a rewarding career in childcare.";
        } else {
            $searchKey = "search?q=chef+hotel+restaurant";
            $pageTitle = "English Speaking Job Opportunities in Sweden";
            $pageHeadding = "Explore English Speaking Jobs in Sweden";
            $pageDescription = "Search a variety of English speaking job roles in Sweden, from hospitality and culinary jobs to hotel management. Find the right job for your skills.";
        }
        
        $pageNumber = intval($page ?? 1);
        $pageNumber = $pageNumber == 0 || $pageNumber == "" ? 1 : $pageNumber;
        $pageNumber = max($pageNumber, 1);
        $pageTitle = $pageTitle." -".$pageNumber;

        $numberOfJobsPerPage = 10;
        $start = $pageNumber * $numberOfJobsPerPage - $numberOfJobsPerPage;
        $end = $numberOfJobsPerPage;
        $searchKey = $searchKey . "&offset=$start&limit=$end&sort=pubdate-desc";
        $jobListRespo = $this->connectJobtechAPI($searchKey);
        $totalPositions = $jobListRespo["total"]["value"];
        $totalPages = ceil($totalPositions/$numberOfJobsPerPage);
        $jobs = $jobListRespo['hits'];
        $homeController = new HomeController();
        $cities = $homeController->getCities();
        $pageType="cat";
        $metaDescription = $pageDescription;
        //$this->updateTotalJobsCount(slug: $slug, $totalPositions, $pageType);
        return view('jobs', compact("jobs", 'page', 'totalPages', 'slug', 'pageTitle', 'pageHeadding', 'pageDescription', 'pageType', 'cities', 'totalPositions', 'metaDescription'));

    }
    public function jobListByCity($slug, $page=1) {
        $searchKey = "search?q=english+".$slug;
        $pageHeadding = "Jobs in ".ucfirst($slug);
        $pageDescription = "Explore various English speaking job opportunities in beautiful cities in Sweden.";
        $pageNumber = intval($page ?? 1);
        $pageNumber = $pageNumber == 0 || $pageNumber == "" ? 1 : $pageNumber;
        $pageNumber = max($pageNumber, 1);
        $pageTitle = ucfirst($slug)." -".$pageNumber." jobs for English speaking people";
        $metaDescription = "Find English-speaking jobs in ".ucfirst($slug).". Browse the latest job openings in ".$slug." for expats and international professionals. Apply now!";

        $numberOfJobsPerPage = 10;
        $start = $pageNumber * $numberOfJobsPerPage - $numberOfJobsPerPage;
        $end = $numberOfJobsPerPage;
        $searchKey = $searchKey . "&offset=$start&limit=$end&sort=pubdate-desc";
        $jobListRespo = $this->connectJobtechAPI($searchKey);
        $totalPositions = $jobListRespo["total"]["value"];
        $totalPages = ceil($totalPositions/$numberOfJobsPerPage);
        $jobs = $jobListRespo['hits'];
        $homeController = new HomeController();
        $cities = $homeController->getCities();
        $pageType="city";
        //$this->updateTotalJobsCount($slug, $totalPositions, $pageType);
        return view('jobs', compact("jobs", 'page', 'totalPages', 'slug', 'pageTitle', 'pageHeadding', 'pageDescription', 'pageType', 'cities', 'totalPositions', 'metaDescription'));
    }
    public function jobsBySearch($keyword, $city, $page=1) {
        if (ctype_digit($keyword) || ctype_digit($city)) {
            return abort(404); // or redirect('/404');
        }
        $keyword = $this->sanitizeKeyword($keyword);
        $searchKey = "search?q=$keyword"."+English+".$city;
        $cityKeyword = ($city==='all')?'All over Sweden':$city;
        $keywordforTitle = ($keyword==='all')?'Jobs ':$keyword;
        if($city === 'all') {
            $pageTitle = ucfirst($keyword)." jobs";
        } else {
            $pageTitle = ucfirst($keyword)." jobs in ".$city; 
        }
        
        $pageDescription = "Explore various English-speaking job opportunities in beautiful cities in Sweden.";
        $pageNumber = intval($page ?? 1);
        $pageNumber = $pageNumber == 0 || $pageNumber == "" ? 1 : $pageNumber;
        $pageNumber = max($pageNumber, 1);
        $numberOfJobsPerPage = 10;
        $start = $pageNumber * $numberOfJobsPerPage - $numberOfJobsPerPage;
        $end = $numberOfJobsPerPage;
        $searchKey = $searchKey . "&offset=$start&limit=$end&sort=pubdate-desc";
        $jobListRespo = $this->connectJobtechAPI($searchKey);

        if (isset($jobListRespo['errors']['offset'])) {
            return abort(404);
        }
        $totalPositions = $jobListRespo["total"]["value"];
        $totalPages = ceil($totalPositions/$numberOfJobsPerPage);
        $jobs = $jobListRespo['hits'];
        $homeController = new HomeController();
        $cities = $homeController->getCities();
        return view('search_results', compact("jobs", 'page', 'totalPages', 'keyword', 'city', 'pageTitle', 'pageDescription', 'cities', 'totalPositions'));

    }
    public function showJob($title, $id) {
        $endPoint = "/ad/" . $id;
        $job = $this->connectJobtechAPI($endPoint);
        if(!isset($job['id'])) {
            if($job['message'] === "Ad not found") {
                abort(404);
            }
        }
        $jobLocation = $job['workplace_address']['municipality'];
        $pageTitle =
        preg_replace("~[^\pL\d]+~u", "-", $title) . " - " . $jobLocation;
        $similarJobsKeyword = str_replace("-", "+", $pageTitle);
        $similarJobs = $this->similarTypeOfJobsByKeyword($similarJobsKeyword);
        $posts = BlogPost::orderBy('published_at', 'desc')->select('title', 'slug')->take(5)->get();

        return view('jobshow', compact('job', 'similarJobs', 'posts'));
    }
    public function similarTypeOfJobsByKeyword($similarJobsKeyword) {

        $searchKey = "/search?q=$similarJobsKeyword";
        $searchKey = $searchKey . "&offset=0&limit=4";
        $jobListRespo = $this->connectJobtechAPI($searchKey);
        return $similarJobs = $jobListRespo['hits'];
    }
    public function updateTotalJobsCount($slug, $totalPositions, $pageType) {
        $cacheKey = "total_jobs_{$pageType}_{$slug}";
        DB::table('total_jobs')->updateOrInsert(
            ['slug' => $slug, 'page_type' => $pageType],
            [
                'total_jobs' => $totalPositions,
                'status' => 1,
                'created_at' => DB::raw('IFNULL(created_at, NOW())'),
                'updated_at' => now()
            ]
        );
        
        Cache::put($cacheKey, $totalPositions, now()->addHours(24));

       // Cache::put($cacheKey, $totalPositions, now()->addHours(24));
    }
    public function myFavoriteJobs(Request $request)
    {
        $favoriteJobs = $request->input('favoriteJobs', []);
        return view('favorite-jobs', [
            'favoriteJobs' => $favoriteJobs,
        ]);
    }
    private function sanitizeKeyword($keyword)
    {
        $keyword = str_replace('-', ' ', $keyword);
        $unwanted = ['job', 'jobs', 'openings', 'positions', 'vacancies', 'jobba', 'jobb'];
        $words = explode(' ', strtolower($keyword));
        $filtered = array_filter($words, fn($word) => !in_array($word, $unwanted));
        return trim(implode(' ', $filtered));
    }

    
}
