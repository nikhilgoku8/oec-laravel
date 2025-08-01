@if(count($products))
<ul>
    @foreach($products as $product)
    <li>
        <a href="{{ route('product', [
                'category' => $product->subCategory->category->slug,
                'subCategory' => $product->subCategory->slug,
                'product' => $product->slug
            ]) }}">
            <span class="img_box">
                <img src="{{ $product->productImages?->first()->image_file }}">
            </span>
            <span class="product_title">{{ $product->title }}</span>
        </a>
    </li>
    @endforeach
</ul>
<button type="submit" class="view_all">View all results</button>
@else
<div class="title red">No results found.</div>
@endif