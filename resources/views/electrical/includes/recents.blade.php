@if(session()->has('recent_searches') && !empty(session('recent_searches')))
                    <div class="recent_searches other_box">
                        <div class="sub_title">
                            <span class="icon">🔍</span>
                            <span class="text">Recent Searches:</span>
                        </div>
                        <ul>
                            @foreach(session('recent_searches') as $row)
                            <li>
                                <a href="{{ route('shop').'?q='.$row }}">{{$row}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(!empty($recentlyViewed) && count($recentlyViewed) > 0)
                    <div class="recently_viewed other_box">
                        <div class="sub_title">
                            <span class="icon">🕒</span>
                            <span class="text"> Recently Viewed Products:</span>
                        </div>
                        <ul>
                            @foreach($recentlyViewed as $product)
                            <li>
                                <a href="{{ route('product', [
                                    'category' => $product->subCategory->category->slug,
                                    'subCategory' => $product->subCategory->slug,
                                    'product' => $product->slug
                                ]) }}">
                                    <span class="img_box"><img src="{{ $product->productImages?->first()->image_file }}"></span>
                                    <span class="text">{{ $product->title }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif