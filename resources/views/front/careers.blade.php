@extends('front.layout.master')

@section('content')

<div class="careers_page">
	
<div class="common_hero">
	<div class="text_box">
        <div class="title wow fadeInUp" data-wow-delay="0.1s">A Career With OEC</div>   
        <div class="sub_title wow fadeInUp" data-wow-delay="0.2s">Explore exciting opportunities with OEC and join us on a journey of growth and success.</div>   
    </div>
</div>

<div class="apply_at_oec">
    <div class="container">
        <div class="inner_container">
            
            <div class="title center wow fadeInUp" data-wow-delay="0.0s">Apply at <br> <b class="">OEC</b></div>

            <div class="form_wrapper wow fadeInUp" data-wow-delay="0.2s">
                <form>
                    <div class="input_box">
                        <label for="name">Name <span class="red">*</span></label>
                        <div class="error form_error">asdasd</div>
                        <input type="text" name="name" id="name" placeholder="Enter name here">
                    </div>
                    <div class="input_box">
                        <label for="email">Email Address <span class="red">*</span></label>
                        <div class="error form_error"></div>
                        <input type="text" name="email" id="email" placeholder="Enter email here">
                    </div>
                    <div class="input_box">
                        <label for="position">Position <span class="red">*</span></label>
                        <div class="error form_error"></div>
                        <input type="text" name="position" id="position" placeholder="Enter position here">
                    </div>
                    <div class="input_box">
                        <label for="message">Message</label>
                        <div class="error form_error"></div>
                        <textarea name="message" id="message" placeholder="Enter message here"></textarea>
                    </div>
                    <div class="input_box">
                        <label for="name">Upload Resume <span class="red">*</span></label>
                        <div class="error form_error"></div>
                        <input type="file" name="name" id="name" placeholder="Enter name here">
                    </div>
                    <div class="submit_box">
                        <div class="error form_error all_errors"></div>
                        <button type="submit" class="red_filled_btn">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- apply_at_oec end -->

</div>
<!-- careers_page end -->

@endsection