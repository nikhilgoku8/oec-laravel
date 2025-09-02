@extends('electrical.layout.master')

@section('content')

<div class="products_list_page">
    
<div class="heading">Shop</div>

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
            
            <div class="left_pane">
                <div class="filters_wrapper">
                    <div class="title">Filters</div>
                    @if(count($products))
                        @if(!empty($filterTypes) && count($filterTypes) > 0)
                            <form id="filterForm" method="GET" action="{{ route('shop') }}">
                            <input type="hidden" name="q" value="{{ request('q') }}">
                                <div id="accordion">
                                     @foreach ($filterTypes as $type)
                                         @if(count($type->filterValues) > 0)
                                            <h3>{{ $type->title }}</h3>
                                            <div>
                                                <ul>
                                                    @foreach ($type->filterValues as $value)
                                                    <li>
                                                        <label>
                                                            <input type="checkbox" name="filters[]" value="{{ $value->id }}" {{ in_array($value->id, request()->get('filters', [])) ? 'checked' : '' }}>
                                                            <span class="text">{{ $value->value }}</span>
                                                            <span class="count">{{ $filterCounts[$value->id] ?? 0 }}</span>
                                                        </label>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <br>
                                <!-- <button class="red_hollow_btn">Apply Filters</button> -->
                            </form>
                            <script>
                            $(document).on('change', '#filterForm input[type="checkbox"]', function() {
                                // alert($(this).val());
                                $('#filterForm').submit();
                            });
                            </script>
                        @endif
                    @endif
                </div>
            </div>
            <div class="right_pane">
                <div class="selected_filters_wrapper">
                    @if(request()->has('filters') && count(request('filters')) > 0)
                        <div class="selected_filters">

                            <button type="button" class="clear_filters"><span class="cross_icon"></span> <span class="txt">Clear Filters</span></button>

                            @foreach ($filterTypes as $type)
                                @foreach ($type->filterValues as $value)
                                    @if(in_array($value->id, request('filters', [])))
                                    <button class="remove_filter" data-id="{{ $value->id }}">
                                        <span class="cross_icon"></span>
                                        <span class="filter_value">{{ $value->value }}</span>
                                    </button>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                        <script>
                            $(document).on('click', '.remove_filter', function(e) {
                                e.preventDefault();
                                let filterId = $(this).data('id');

                                // Uncheck the checkbox for this filter
                                $("input[type=checkbox][value='" + filterId + "']").prop('checked', false);

                                // Submit the form automatically
                                $('#filterForm').submit();
                            });

                            // Clear all filters
                            $(document).on('click', '.clear_filters', function() {
                                $('#filterForm input[type=checkbox]').prop('checked', false);
                                $('#filterForm').submit();
                            });
                        </script>
                    @endif
                </div>
                <div class="list_heading">
                    <div class="breadcrumbs">
                        <ul>
                            <li><a class="txt" href="{{ route('electrical') }}">Home</a></li>
                            <li><span class="txt">Shop</span></li>
                        </ul>
                    </div>
                    <div class="total_count_text">
                        @if ($products->total() > 0)
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                        @endif
                    </div>
                    @if(!$desktop)
                    <div class="show_filter_btn_wrapper">
                        <button type="button" class="show_filter_btn">
                            <span class="three_lines">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </span>
                            <span class="text">Show Sidebar</span>
                        </button>
                    </div>
                    @endif
                </div>
                @if(count($products))
                <div class="products_list">
                    @foreach($products as $product)
                        <div class="product_box">
                            <a href="{{ route('product', [
                                    'category' => $product->subCategory->category->slug,
                                    'subCategory' => $product->subCategory->slug,
                                    'product' => $product->slug
                                ]) }}" class="img_box">
                                <img src="{{ $product->productImages?->first()->image_file ?? asset('electrical-assets/images/coming-soon.webp') }}">
                            </a>
                            <div class="text_box">
                                <a href="{{ route('product', [
                                    'category' => $product->subCategory->category->slug,
                                    'subCategory' => $product->subCategory->slug,
                                    'product' => $product->slug
                                ]) }}" class="product_title">{{ $product->title }}</a>
                                <div class="sub_category_title">{{ $product->subCategory->title }}</div>
                                <div class="description">{{ $product->description }}</div>
                                <!-- <button class="red_filled_btn">Add To Enquiry</button> -->
                                <div class="add_to_cart_inputs">
                                    <div class="number_input">
                                        <button onclick="this.parentNode.querySelector('input').stepDown()">-</button>
                                        <input type="number" value="1" min="1">
                                        <button onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                                    </div>
                                    <button class="red_filled_btn add_to_cart" data-product-id="{{ $product->id }}">Add to Enquiry</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="page_links">
                    <!-- @{{ $products->onEachSide(1)->links('pagination.numbers') }} -->
                    {{ $products->withQueryString()->links('pagination.numbers') }}
                </div>
                <!-- @{{ $products->links('pagination::bootstrap-5') }} -->
                <!-- @if ($products->total() > 0)
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                @else
                    No results found.
                @endif -->
                @else
                    <br>
                    <br>
                    <div class="title red">No results found.</div>
                @endif
            </div>

        </div>
    </div>
</div>
<!-- products_wrapper end -->

</div>
<!-- products_list_page end -->

<script>

// $( function() {
//   $( "#accordion" ).accordion({
//     collapsible: true
//   });
// } );

$("#accordion").accordion({
    collapsible: true,
    active: false,
    heightStyle: "content"
}).accordion("destroy"); // remove built-in behavior

// Custom multiple open toggle
$("#accordion div").hide();

// Open panels that have any checked checkbox
$("#accordion h3").each(function () {
    if ($(this).next().find("input[type='checkbox']:checked").length > 0) {
        $(this).next().show();        // Show the panel
        $(this).addClass("ui-state-active"); // Optional: jQuery UI style active
    }
});
    
$("#accordion h3").click(function () {
    $(this).toggleClass("ui-state-active");
    $(this).next().slideToggle();
});

</script>


@endsection