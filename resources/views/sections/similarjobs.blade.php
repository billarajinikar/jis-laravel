<div>
    <h2 class="text-center mb-4">Similar Jobs</h2>
    <div class="mt-4">
        <div class="container">
            @if($similarJobs)
                <div class="list-group">
                    @foreach($similarJobs as $job)
                        <?php
                            $jobId = $job["id"];
                            $jobLogoUrl = $job["logo_url"];
                            $jobTitle = $job["headline"];
                            $urlTitle = preg_replace("~[^\pL\d]+~u", "-", $jobTitle);
                            $jobInfoUrl = "/job/" . $urlTitle . "/" . $jobId."/";
                            $jobLocation = $job['workplace_address']['municipality']
                        ?>
                        <a href="{{ $jobInfoUrl }}" class="list-group-item list-group-item-action" style="font-weight: bold; color: #007bff; text-decoration: none;">
                            <p>{{ $jobTitle }} - {{$jobLocation}}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <p>No posts available.</p>
            @endif
        </div>
    </div>
</div>