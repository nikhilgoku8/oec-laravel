@extends('front.layout.master')

@section('content')

<div class="reach_us_page">
    
<div class="common_hero">
    <div class="text_box">
        <div class="title wow fadeInUp" data-wow-delay="0.1s">Reach Us</div>   
        <div class="sub_title wow fadeInUp" data-wow-delay="0.2s">Reach out to discuss your next project or explore exciting collaborations</div>   
    </div>
</div>

<div class="ctc_n_form_wrapper">
    <div class="container">
        <div class="inner_container">

            <div class="left_info">
                <div class="title wow fadeInUp" data-wow-delay="0.1s">Contact Info</div>
                <div class="ctc_wrapper">
                    <a href="tel:+1(929)5237411" class="ctc_box wow fadeInUp" data-wow-delay="0.1s">
                        <div class="icon"><i class="fas fa-phone-alt"></i></div>
                        <div class="text">Phone : +1 (929) 523 7411</div>
                    </a>
                    <div class="ctc_box wow fadeInUp" data-wow-delay="0.1s">
                        <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="text">1207 Delaware Ave, Wilmington, DE 19806</div>
                    </div>
                    <a href="mailto:info@oec-americas.com" class="ctc_box wow fadeInUp" data-wow-delay="0.1s">
                        <div class="icon"><i class="fas fa-envelope"></i></div>
                        <div class="text">info@oec-americas.com</div>
                    </a>
                </div>
            </div>
            <div class="right_info">
                <div class="form_wrapper wow fadeInRight" data-wow-delay="0.1s">
                    <form id="reach_us_form" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Name <span class="red">*</span></label>
                                <div class="error form_error form-error-name"></div>
                                <input type="text" name="name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Contact Phone <span class="red">*</span></label>
                                <div class="error form_error form-error-phone"></div>
                                <input type="text" name="phone">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Email Address <span class="red">*</span></label>
                                <div class="error form_error form-error-email"></div>
                                <input type="text" name="email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Company Name <span class="red">*</span></label>
                                <div class="error form_error form-error-company_name"></div>
                                <input type="text" name="company_name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Company Website </label>
                                <div class="error form_error form-error-company_website"></div>
                                <input type="text" name="company_website">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Street Address </label>
                                <div class="error form_error form-error-street_address"></div>
                                <input type="text" name="street_address">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">City</label>
                                <div class="error form_error form-error-city"></div>
                                <input type="text" name="city">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">State <span class="red">*</span></label>
                                <div class="error form_error form-error-state"></div>
                                <input type="text" name="state">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Country <span class="red">*</span></label>
                                <div class="error form_error form-error-country"></div>
                                <select name="country">
                                    @include('countries-dropdown')
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">ZIP / Postcode</label>
                                <div class="error form_error form-error-postcode"></div>
                                <input type="text" name="postcode">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label for="name">Contact Reason <span class="red">*</span></label>
                                <div class="error form_error form-error-contact_reason"></div>
                                <select name="contact_reason">
                                    <option value="">Please select an option</option>
                                    <option>New Product Idea</option>
                                    <option>Product Information</option>
                                    <option>Quality Issue</option>
                                    <option>Technical Support</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label for="message">Your Message</label>
                                <div class="error form_error form-error-message"></div>
                                <textarea name="message"></textarea>
                                <span class="note">Please provide additional details to help us address your need as quickly as possible.</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label for="name">Upload Document</label>
                                <div class="error form_error form-error-document"></div>
                                <input type="file" name="document">
                                <span class="note">Accepted file types: word, pdf, jpg, Max. file size: 5 MB</span>
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
</div>
<!-- apply_at_oec end -->

</div>
<!-- careers_page end -->

<script type="text/javascript">
$(document).ready(function() {

    $("#reach_us_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        var button = $(this).find('[type=submit]');
        button.attr('disabled', 'disabled');
        button.addClass('spinners');

        $.ajax({
            type: "POST",
            url: "{{ route('reach-us.post') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('reach-us.thankyou') }}";
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