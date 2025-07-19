@extends('electrical.layout.master')

@section('content')

<div class="products_list_page">
    
<div class="heading">Copper Lugs</div>

<div class="products_wrapper">
    <div class="container">
        <div class="inner_container">
            
            <div class="left_pane">
                <div class="filters_wrapper">
                    <div class="title">Filters</div>
                    @if(!empty($filterTypes) && count($filterTypes) > 0)
                        <form method="GET" action="{{ route('products', ['category' => $category->slug, 'subCategory' => $subCategory->slug]) }}">
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
                            <button class="btn btn-secondary mt-2">Apply Filters</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="right_pane">
                <div class="list_heading">
                    <div class="breadcrumbs">
                        <ul>
                            <li><a class="txt" href="{{ route('electrical') }}">Home</a></li>
                            <li><a class="txt" href="{{ route('sub-categories', $category->slug) }}">{{ $category->title }}</a></li>
                            <li><span class="txt">{{ $subCategory->title }}</span></li>
                        </ul>
                    </div>
                    <div class="total_count_text">
                        @if ($products->total() > 0)
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                        @endif
                    </div>
                </div>
                <div class="products_list">
                    @foreach($products as $product)
                        <div class="product_box">
                            <a href="{{ route('product', [
                                    'category' => $category->slug,
                                    'subCategory' => $subCategory->slug,
                                    'product' => $product->id
                                ]) }}" class="img_box">
                                <img src="{{ $product->productImages?->first()->image_file }}">
                            </a>
                            <div class="text_box">
                                <a href="{{ route('product', [
                                    'category' => $category->slug,
                                    'subCategory' => $subCategory->slug,
                                    'product' => $product->id
                                ]) }}" class="product_title">{{ $product->title }}</a>
                                <div class="sub_category_title">{{ $subCategory->title }}</div>
                                <div class="description">{{ $product->description }}</div>
                                <button class="red_filled_btn">Add To Enquiry</button>
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
            </div>

        </div>
    </div>
</div>
<!-- products_wrapper end -->

</div>
<!-- products_list_page end -->

<script>
  $( function() {
    $( "#accordion" ).accordion({
      collapsible: true
    });
  } );
  </script>
@endsection