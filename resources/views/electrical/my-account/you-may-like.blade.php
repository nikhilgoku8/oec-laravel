<ul>
                            @foreach($productsMayLike as $row)
                            <li>
                                <a>
                                    <span class="img_box">
                                        <img src="{{ $row->productImages[0]->image_file }}">
                                    </span>
                                    <span class="text">{{ $row->title }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>