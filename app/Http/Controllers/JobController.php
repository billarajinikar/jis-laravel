<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use App\Models\BlogPost;


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
        if($slug === "it-software-jobs") {
            $searchKey = "search?q=IT+softwaredeveloper+programmer+english";
            $pageTitle = "IT/Software jobs in Sweden";
            $pageHeadding = "IT/Software jobs in Sweden";
            $pageDescription = "Find the best English-speaking IT and Software jobs in Sweden. From developers to system administrators, explore opportunities that suit your skillset.";
        } else if($slug === "internships") {
            $searchKey = "search?q=Internship";
            $pageTitle = "Inernships";
            $pageHeadding = "Inernships";
            $pageDescription = "Discover exciting English-speaking internships in Sweden. Gain valuable experience and kickstart your career with the right opportunities.";
        }
        else if($slug === "teaching-jobs") {
            $searchKey = "search?q=teaching";
            $pageTitle = "Teaching jobs in Sweden";
            $pageHeadding = "Teaching jobs in Sweden";
            $pageDescription = "Explore English-speaking teaching jobs across Sweden. Whether you specialize in early education or higher education, find your next teaching role here.";
        }
        else if($slug === "cleaning-jobs") {
            $searchKey = "search?q=cleaning";
            $pageTitle = "Cleaning jobs in Sweden";
            $pageHeadding = "Cleaning jobs in Sweden";
            $pageDescription = "Looking for English-speaking cleaning jobs in Sweden? Discover a variety of cleaning job opportunities that match your experience and availability.";
        }
        else if($slug === "babysitting-jobs") {
            $searchKey = "search?q=babysitting";
            $pageTitle = "Babysitting jobs in Sweden";
            $pageHeadding = "Babysitting jobs in Sweden";
            $pageDescription = "Find English-speaking babysitting jobs in Sweden. Explore opportunities to work with families and provide quality childcare services.";
        } else {
            $searchKey = "search?q=chef+hotel+restuarant";
            $pageTitle = "All other jobs";
            $pageHeadding = "All English speaking jobs";
            $pageDescription = "Explore various English-speaking job opportunities in Sweden, including roles in hospitality, restaurants, and more.";
        }
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
        $pageType="cat";
        return view('jobs', compact("jobs", 'page', 'totalPages', 'slug', 'pageTitle', 'pageHeadding', 'pageDescription', 'pageType', 'cities'));

    }
    public function jobListByCity($slug, $page=1) {
        $searchKey = "search?q=english+".$slug;
        $pageTitle = ucfirst($slug)." jobs for English speaking people";
        $pageHeadding = "Jobs in ".ucfirst($slug);
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
        $pageType="city";
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

    public function findaJob() {

    }
    
}
