
                    <div class="total_count_text">
                        @if($competitors->total() > 0)
                            Showing {{ $competitors->firstItem() }} to {{ $competitors->lastItem() }} of {{ $competitors->total() }} results
                        @endif
                    </div>
                    @if(count($competitors))
                <div class="products_list">
                    @foreach($competitors as $competitor)
                        <div class="product_box">
                            <a href="{{ route('product', [
                                    'category' => $competitor->product->subCategory->category->slug,
                                    'subCategory' => $competitor->product->subCategory->slug,
                                    'product' => $competitor->product->slug
                                ]) }}" class="img_box">
                                <img src="{{ $competitor->product->productImages?->first()->image_file }}">
                            </a>
                            <div class="text_box">
                                <div class="competitor_title">{{ $competitor->title }}</div>
                                <a href="{{ route('product', [
                                    'category' => $competitor->product->subCategory->category->slug,
                                    'subCategory' => $competitor->product->subCategory->slug,
                                    'product' => $competitor->product->slug
                                ]) }}" class="product_title">{{ $competitor->product->title }}</a>
                                <a href="{{ route('products', [
                                        'category' => $competitor->product->subCategory->category->slug,
                                        'subCategory' => $competitor->product->subCategory->slug
                                    ]) }}" class="sub_category_title">{{ $competitor->product->subCategory->title }}</a>
                                <a href="{{ route('product', [
                                    'category' => $competitor->product->subCategory->category->slug,
                                    'subCategory' => $competitor->product->subCategory->slug,
                                    'product' => $competitor->product->slug
                                ]) }}" class="description">{{ $competitor->product->description }}</a>
                                <!-- <button class="red_filled_btn">Add To Enquiry</button> -->
                                <div class="add_to_cart_inputs">
                                    <div class="number_input">
                                        <button onclick="this.parentNode.querySelector('input').stepDown()">-</button>
                                        <input type="number" value="1" min="1">
                                        <button onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                                    </div>
                                    <button class="red_filled_btn add_to_cart" data-product-id="{{ $competitor->product->id }}">Add to Enquiry</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="page_links">
                    {{ $competitors->withQueryString()->links('pagination.numbers') }}
                </div>
                @else
                    <br>
                    <br>
                    <div class="title center red">No results found.</div>
                @endif