<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HomeController;

class UpdateJobCounts extends Command
{
    protected $signature = 'jobs:update-counts';
    protected $description = 'Update the total job count for each category and city';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $jobController = new JobController();
        $homeController = new HomeController();

        // Get categories and update job counts
        $categories = $homeController->getCategories();
        foreach ($categories as $category) {
            $slug = $category['slug'];
            if($slug === "it-software-jobs") {
                $searchKey = "search?q=IT+softwaredeveloper+programmer+english";
            }
            else if ($slug === "internships") {
                $searchKey = "search?q=Internship";
            } else if ($slug === "teaching-jobs") {
                $searchKey = "search?q=teaching";
            } else if ($slug === "cleaning-jobs") {
                $searchKey = "search?q=cleaning";
            } else if ($slug === "babysitting-jobs") {
                $searchKey = "search?q=babysitting";
            } else {
                $searchKey = "search?q=chef+hotel+restaurant";
            }   
            $this->updateJobCount($jobController, $slug, 'cat', $searchKey);
        }

        // Get cities and update job counts
        $cities = $homeController->getCities();
        foreach ($cities as $city) {
            //$slug = strtolower(str_replace(' ', '-', $city['name']));
            $slug = $city['slug'];
            $searchKey = "search?q=english+".$slug;
            $this->updateJobCount($jobController, $slug, 'city', $searchKey);
        }

        $this->info("Job counts updated successfully!");
    }

    private function updateJobCount($jobController, $slug, $type, $searchKey)
    {
        $totalPositions = null;
        if ($type == 'cat') {
             
            $jobListRespo = $jobController->connectJobtechAPI($searchKey);
            $totalPositions = $jobListRespo["total"]["value"];

        } else {
            //$response = $jobController->jobListByCity($slug, 1);
            $jobListRespo = $jobController->connectJobtechAPI($searchKey);
            $totalPositions = $jobListRespo["total"]["value"];
        }

       

        // Update total job count in database and Redis cache
        $jobController->updateTotalJobsCount($slug, $totalPositions, $type);
    }
}
