@extends('admin.layout.master')

@section('content')   
<div class="container">
    <!-- 🔍 Search Bar -->
    <form method="GET" action="{{ route('products.search_new') }}">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..." class="form-control mb-3">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="row mt-4">
        <!-- 🧩 Filters -->
        <div class="col-md-3">
            <form method="GET" action="{{ route('products.search_new') }}">
                <input type="hidden" name="q" value="{{ request('q') }}">
                @foreach ($filterTypes as $type)
                    @if(count($type->filterValues) > 0)
                        <h5>{{ $type->title }}</h5>
                        @foreach ($type->filterValues as $value)
                            <label>
                                <input type="checkbox" name="filters[]" value="{{ $value->id }}"
                                       {{ in_array($value->id, request()->get('filters', [])) ? 'checked' : '' }}>
                                {{ $value->value }} ({{ $filterCounts[$value->id] ?? 0 }})
                            </label>
                        @endforeach
                    @endif
                @endforeach
                <button class="btn btn-secondary mt-2">Apply Filters</button>
            </form>
        </div>

        <!-- 🛍️ Product Results -->
        <div class="col-md-9">
            @if($products->count())
                <div class="row">
                    @foreach ($products as $product)
                        <!-- <div class="col-md-4 mb-4"> -->
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->title }}</h5>
                                    <!-- Add more product fields -->
                                </div>
                            </div>
                        <!-- </div> -->
                    @endforeach
                </div>

                <!-- 📄 Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $products->withQueryString()->links() }}
                </div>
            @else
                <p>No products found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
