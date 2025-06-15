@extends('admin.layout.master')

@section('content') 

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Products</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
                    </ul>    
                </div>
                
                <div class="right_section">
                    <div class="blue_filled_btn">
                        <a href="{{ url()->previous() }}">Back</a>
                    </div>
                </div>
            </div>                    
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">

            <div class="my_panel form_box">

                <form method="GET" action="{{ route('products.search') }}">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products...">
                    <button type="submit">Search</button>
                </form>

                @if($products->isEmpty())
                    <p>No results found.</p>
                @else
                    {{count($products)}}
                    <ul>
                        @foreach($products as $product)
                            <li>
                                <strong>{{ $product->title }}</strong><br>
                                {{ $product->description }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
                <div class="table_pagination">
                    {{ $products->links() }}
                    <div class="clr"></div>
                </div>

    </div>
    <!-- /.row -->

            
@endsection