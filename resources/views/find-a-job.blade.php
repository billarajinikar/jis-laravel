@extends('layouts.app')
@section('title', 'Find English Speaking Jobs in Sweden')

@section('content')
<div class="container mt-4 mb-5">
    <div class="text-center mb-4">
        @include('sections.searchbox')
    </div>
</div>

<div class="container mt-2 mb-5">
    <!-- Popular Categories Section -->
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-danger d-flex justify-content-between align-items-center">
                <span>Popular Categories</span>
                <!-- <a href="" class="text-decoration-none text-primary" style="font-size: 0.875rem;">
                  View All Categories
                </a> -->
            </h4>
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-4 mb-2">
                        <a href="{{ $category['link'] }}" class="d-block text-decoration-none text-dark fw-bold position-relative link-hover-effect">
                            {{ $category['name'] }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Jobs By City Section -->
    <div class="row mt-4 mb-5">
        <div class="col-md-12">
            <h4 class="text-danger d-flex justify-content-between align-items-center">
                <span>Jobs By City</span>
                <!-- <a href="" class="text-decoration-none text-primary" style="font-size: 0.875rem;">
                    View All Cities
                </a> -->
            </h4>
            <div class="row">
                @foreach($cities as $city)
                    <div class="col-md-2 mb-3">
                        <a href="{{ $city['link'] }}" class="list-group-item list-group-item-action text-dark text-decoration-none">
                            <i class="bi bi-geo-alt-fill me-2 text-secondary"></i>{{ $city['name'] }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
