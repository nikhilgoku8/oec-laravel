@extends('electrical.layout.master')

@section('content')

<div class="competitors_page">
    
<div class="heading">Competitors</div>

<div class="products_wrapper">
    <div class="container">
        <div class="inner_container">

            @if (session('success'))
                <div class="col-sm-12">
                    <div class="alert alert-success center title">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <div class="competitors_wrapper">
                <div class="competitors_search_wrapper">
                    <form method="GET" action="{{ route('competitors.search') }}" class="competitors_search">
                        <div class="input_box">
                            <!-- <input type="text" class="search_input" id="competitor-search" placeholder="Search Competitors" name="q" value="{{ request('q') }}"> -->
                            <input type="text" class="search_input" id="competitor-search" placeholder="Search Competitors">
                        </div>
                        <button class="icon_box"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="center sub_title">Enter a manufacturer’s part number and the corresponding OEC product(s) will be listed below:</div>
                <div class="list_heading">
                </div>
                <div id="competitor-results">
                    
                </div>
                
            </div>

        </div>
    </div>
</div>
<!-- products_wrapper end -->

</div>
<!-- products_list_page end -->

<script>
let searchTimer;

// Function to load search results
function loadCompetitors(url) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            $('#competitor-results').html(response);
        },
        error: function() {
            $('#competitor-results').html('<div class="title red">Error loading results.</div>');
        }
    });
}

// Trigger search after 3 letters
$('#competitor-search').on('keyup', function() {
    let query = $(this).val().trim();
    $('#competitor-results').html('...');

    if (query.length >= 3) {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            let url = '{{ route("competitors.search") }}?q=' + encodeURIComponent(query);
            loadCompetitors(url);
        }, 300); // debounce
    } else {
        $('#competitor-results').html('');
    }
});

// Handle pagination clicks via delegation
$(document).on('click', '.page_links a', function(e) {
    e.preventDefault();
    let url = $(this).attr('href');
    loadCompetitors(url);
});
</script>
@endsection