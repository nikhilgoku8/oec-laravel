@if(!empty($cartProducts) && count($cartProducts) > 0)
                    <div class="products_wrapper">
                        @foreach($cartProducts as $row)
                            <div class="product_box">
                                <a href="{{ route('product', [
                                    'category' => $row->product->subCategory->category->slug,
                                    'subCategory' => $row->product->subCategory->slug,
                                    'product' => $row->product->slug
                                ]) }}">
                                    <div class="img_box">
                                        <img src="{{ $row->product->productImages[0]->image_file }}">
                                    </div>
                                    <div class="text_box">
                                        <div class="product_title">{{ $row->product->title }}</div>
                                        <div class="product_description">{{ Str::limit($row->product->description, 75) }}</div>
                                        <div class="product_count">
                                            <span class="number">{{ $row->quantity }}</span>
                                            <span class="times">x</span>
                                        </div>
                                    </div>
                                </a>
                                <button class="remove_product" data-cart-item-id="{{$row->id}}"></button>
                            </div>
                        @endforeach
                    </div>
                    <div class="c2a_btns">
                        <a href="{{ route('cart.index') }}" class="red_hollow_btn full_width">View Enquiry List</a>
                        <a href="{{ route('checkout') }}" class="red_filled_btn full_width">Request Quote</a>
                    </div>
                @else
                <div class="heading">Empty Cart</div>
                @endif