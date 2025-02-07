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
            $pageTitle = "Top IT and Software Jobs in Sweden - English-Speaking Roles";
            $pageHeadding = "Find IT and Software Jobs in Sweden";
            $pageDescription = "Discover high-paying IT and software jobs in Sweden for English-speaking professionals. From developers to IT support roles, start your tech career today.";
        } else if ($slug === "internships") {
            $searchKey = "search?q=Internship";
            $pageTitle = "Internship Opportunities in Sweden - Kickstart Your Career";
            $pageHeadding = "Explore Internships in Sweden";
            $pageDescription = "Search for exciting English-speaking internships in Sweden. Gain hands-on experience, develop new skills, and grow your career with top organizations.";
        } else if ($slug === "teaching-jobs") {
            $searchKey = "search?q=teaching";
            $pageTitle = "Teaching Jobs in Sweden - English-Speaking Educator Roles";
            $pageHeadding = "Find Teaching Jobs in Sweden";
            $pageDescription = "Browse English-speaking teaching jobs in Sweden. From early childhood education to university teaching positions, discover your next teaching role.";
        } else if ($slug === "cleaning-jobs") {
            $searchKey = "search?q=cleaning";
            $pageTitle = "Cleaning Jobs in Sweden - English-Speaking Roles Available";
            $pageHeadding = "Discover Cleaning Jobs in Sweden";
            $pageDescription = "Find English-speaking cleaning jobs in Sweden. Whether you're looking for part-time or full-time opportunities, explore jobs that match your availability.";
        } else if ($slug === "babysitting-jobs") {
            $searchKey = "search?q=babysitting";
            $pageTitle = "Babysitting Jobs in Sweden - English-Speaking Childcare Roles";
            $pageHeadding = "Find Babysitting Jobs in Sweden";
            $pageDescription = "Explore English-speaking babysitting jobs in Sweden. Provide childcare services to families while building a rewarding career in childcare.";
        } else {
            $searchKey = "search?q=chef+hotel+restaurant";
            $pageTitle = "English-Speaking Job Opportunities in Sweden";
            $pageHeadding = "Explore English-Speaking Jobs in Sweden";
            $pageDescription = "Search a variety of English-speaking job roles in Sweden, from hospitality and culinary jobs to hotel management. Find the right job for your skills.";
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
        //$this->updateTotalJobsCount(slug: $slug, $totalPositions, $pageType);
        return view('jobs', compact("jobs", 'page', 'totalPages', 'slug', 'pageTitle', 'pageHeadding', 'pageDescription', 'pageType', 'cities'));

    }
    public function jobListByCity($slug, $page=1) {
        $searchKey = "search?q=english+".$slug;
        $pageHeadding = "Jobs in ".ucfirst($slug);
        $pageDescription = "Explore various English-speaking job opportunities in beautiful cities in Sweden.";
        $pageNumber = intval($page ?? 1);
        $pageNumber = $pageNumber == 0 || $pageNumber == "" ? 1 : $pageNumber;
        $pageNumber = max($pageNumber, 1);
        $pageTitle = ucfirst($slug)." -".$pageNumber." jobs for English speaking people";
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
        return view('jobs', compact("jobs", 'page', 'totalPages', 'slug', 'pageTitle', 'pageHeadding', 'pageDescription', 'pageType', 'cities'));
    }
    public function jobsBySearch($keyword, $city, $page=1) {
        $searchKey = "search?q=$keyword"."+English+".$city;
        $cityKeyword = ($city==='all')?'All over Sweden':$city;
        $keywordforTitle = ($keyword==='all')?'Jobs ':$keyword;
        $pageTitle = ucfirst($keyword)." jobs in ".$city;
        $pageDescription = "Explore various English-speaking job opportunities in beautiful cities in Sweden.";
        $pageNumber = intval($page ?? 1);
        $pageNumber = $pageNumber == 0 || $pageNumber == "" ? 1 : $pageNumber;
        $pageNumber = max($pageNumber, 1);
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
        return view('search_results', compact("jobs", 'page', 'totalPages', 'keyword', 'city', 'pageTitle', 'pageDescription', 'cities'));

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
    
}
