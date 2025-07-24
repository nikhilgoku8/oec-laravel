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
                <form id="career_form" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-12">
                        <div class="input_box">
                            <label for="name">Name <span class="red">*</span></label>
                            <div class="error form_error form-error-name"></div>
                            <input type="text" name="name" placeholder="Enter name here">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="input_box">
                            <label for="email">Email Address <span class="red">*</span></label>
                            <div class="error form_error form-error-email"></div>
                            <input type="text" name="email" placeholder="Enter email here">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="input_box">
                            <label for="position">Position <span class="red">*</span></label>
                            <div class="error form_error form-error-position"></div>
                            <input type="text" name="position" placeholder="Enter position here">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="input_box">
                            <label for="message">Message</label>
                            <div class="error form_error form-error-message"></div>
                            <textarea name="message" placeholder="Enter message here"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="input_box">
                            <label for="name">Upload Resume <span class="red">*</span></label>
                            <div class="error form_error form-error-resume"></div>
                            <input type="file" name="resume" placeholder="Enter name here">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="submit_box">
                            <div class="error form_error all_errors"></div>
                            <button type="submit" class="red_filled_btn">Submit</button>
                        </div>
                    </div>
                    <div class="clr"></div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- apply_at_oec end -->

</div>
<!-- careers_page end -->

<script type="text/javascript">
$(document).ready(function() {

    $("#career_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        var button = $(this).find('[type=submit]');
        button.attr('disabled', 'disabled');
        button.addClass('spinners');

        $.ajax({
            type: "POST",
            url: "{{ route('careerEnquiry') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('career.thankyou') }}";
                // $this.html('<p>Subscribed Successfully</p>');
            },
            error: function(data){
                if (data.status === 422) {
                    let errors = data.responseJSON.errors;
                    let allErrors = '';
                    $.each(errors, function (key, val) {
                        var fieldName = key.replace(/\./g, '-');
                        // $('#form-error-' + key).html(message).addClass('alert alert-danger');
                        allErrors += val + '<br>';
                        $this.find(".form-error-"+fieldName).html(val).addClass('alert alert-danger');
                        $this.find(".form-error-"+fieldName).addClass('alert alert-danger');
                    });
                    $this.find(".all_errors").html(allErrors).addClass('alert alert-danger');
                } else if (data.status === 401) {
                    alert("Please log in.");
                    // window.location.href = "/login";
                } else if (data.status === 403) {
                    alert("You don’t have permission.");
                } else if (data.status === 404) {
                    alert("The resource was not found.");
                } else if (data.status === 419) {
                    alert("Error - "+419);
                    console.log(data.responseJSON.message);
                } else if (data.status === 500) {
                    alert("Something went wrong on the server.");
                    console.log(data.console_message);
                } else {
                    alert("Unexpected error: " + data.status);
                    console.log(data);
                }

                button.prop('disabled', false).removeClass('spinners');
            }
        });

    }));

});
</script>

@endsection