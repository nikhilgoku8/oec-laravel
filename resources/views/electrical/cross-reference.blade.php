@extends('electrical.layout.master')

@section('content')

<div class="cross_reference_page">

<div class="section_one">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading">Cross Reference</div>

            <div class="competitor_search_wrapper">
                <div class="input_box">
                    <input type="text" name="search" placeholder="Search Competitors">
                </div>
                <button class="icon_box"><i class="fas fa-search"></i></button>
            </div>

            <div class="note">Enter a manufacturer’s part number and the corresponding OEC product(s) will be listed below:</div>

        </div>
    </div>
</div>
<!-- section_one end -->

</div>
<!-- operation_manual_page end -->

@endsection