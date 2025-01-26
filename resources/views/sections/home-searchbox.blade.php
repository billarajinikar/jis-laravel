<div class="text-center container py-4">
    <!-- Search Form -->
    <form action="{{ route('jobSearch', ['keyword' => 'default', 'city' => 'default']) }}" method="GET" onsubmit="event.preventDefault(); submitSearchForm();">
        <div class="row align-items-center">
            <!-- Search Box -->
            <div class="col-md-1 mb-3"> </div>
            <div class="col-md-5 mb-3">
                <div class="input-group">
                    <input type="text" id="keyword" name="query" class="form-control" placeholder="🔍 Search by keywords" value="{{ isset($keyword) ? str_replace('-', ' ', $keyword) : request()->get('query') }}">
                    @if(request()->has('query'))
                        <button type="button" class="btn btn-outline-secondary" onclick="clearSearch()">Clear</button>
                    @endif
                </div>
            </div>

            <!-- Location Filter -->
            <div class="col-md-3 mb-3">
                <select id="location" name="location" class="form-control custom-select">
                    <option value="" {{ ($city ?? '') == '' ? 'selected' : '' }}>📍 All over Sweden</option>
                    @foreach($cities as $cityOption)
                        <option value="{{ $cityOption['name'] }}" {{ ($city ?? '') == $cityOption['name'] ? 'selected' : '' }}>
                            {{ $cityOption['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Search Button -->
            <div class="col-md-2 mb-3">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
            <div class="col-md-1 mb-3"> </div>
        </div>  
    </form>
</div>

<script>
    function submitSearchForm() {
        const keyword = (document.getElementById('keyword').value.trim() || 'all').replace(/\s+/g, '-');
        const location = document.getElementById('location').value || 'all';
        const url = `{{ url('/search') }}/${encodeURIComponent(keyword)}/${encodeURIComponent(location)}`;
        window.location.href = url;
    }

    function clearSearch() {
        document.getElementById('keyword').value = '';
        window.location.href = '{{ route('jobSearch', ['keyword' => 'default', 'city' => 'default']) }}';
    }
</script>

<style>
    /* Styling for the reusable search box */
    .searchbox {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 40px;
    }
    
    .searchbox h2 {
        font-size: 1.5rem;
        color: #0056b3;
    }

    .form-control {
        border-radius: 0.5rem;
        -webkit-appearance: none; /* For Chrome & Safari */
        -moz-appearance: none;    /* For Firefox */
        appearance: none;         /* For most modern browsers */
        padding-right: 1.5rem; /* Space for custom arrow */
    }

    /* Add a custom arrow */
    .custom-select {
        position: relative;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23666' d='M2 0L0 2h4z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 0.65rem;
    }

    .btn-primary {
        background-color: #0056b3;
        border: none;
        border-radius: 0.5rem;
    }

    .input-group .form-control:focus {
        border-color: #0056b3;
        box-shadow: none;
    }

    .btn-outline-secondary {
        border: none;
        color: #888;
    }

    .btn-outline-secondary:hover {
        color: #000;
    }

    select.form-control option[disabled] {
        color: #aaa;
    }
</style>
