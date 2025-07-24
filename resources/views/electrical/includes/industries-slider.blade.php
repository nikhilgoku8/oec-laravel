<div class="industries_slider">
                <div class="swiper-wrapper">

                    @foreach($categories as $category)
                    <div class="swiper-slide">
                        <div class="item_box">
                            <div class="img_box">
                                <img src="{{ $category->subCategories[0]->products[0]->productImages[0]->image_file }}">
                            </div>
                            <div class="category_title">{{ $category->title }}</div>
                            @if(!empty($category->subCategories))
                                <div class="sub_category_title">{{$category->subCategories[0]->title}}</div>
                            @endif
                            <a href="{{ route('products', ['category' => $category->slug, 'subCategory' => $category->subCategories[0]->slug]) }}" class="red_filled_btn">View Products</a>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
            <!-- industries_slider end -->