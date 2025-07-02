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
                    <div class="ctc_box wow fadeInUp" data-wow-delay="0.1s">
                        <a href="tel:+1(929)5237411" class="icon"><i class="fas fa-phone-alt"></i></a>
                        <div class="text">Phone : +1 (929) 523 7411</div>
                    </div>
                    <div class="ctc_box wow fadeInUp" data-wow-delay="0.1s">
                        <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="text">1207 Delaware Ave, Wilmington, DE 19806</div>
                    </div>
                    <div class="ctc_box wow fadeInUp" data-wow-delay="0.1s">
                        <a href="mailto:info@oec-americas.com" class="icon"><i class="fas fa-envelope"></i></a>
                        <div class="text">info@oec-americas.com</div>
                    </div>
                </div>
            </div>
            <div class="right_info">
                <div class="form_wrapper wow fadeInRight" data-wow-delay="0.1s">
                    <form>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">First Name <span class="red">*</span></label>
                                <div class="error form_error"></div>
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Contact Phone <span class="red">*</span></label>
                                <div class="error form_error"></div>
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Email Address <span class="red">*</span></label>
                                <div class="error form_error"></div>
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Company Name <span class="red">*</span></label>
                                <div class="error form_error"></div>
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Company Website </label>
                                <div class="error form_error"></div>
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Street Address </label>
                                <div class="error form_error"></div>
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">City</label>
                                <div class="error form_error"></div>
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">State <span class="red">*</span></label>
                                <div class="error form_error"></div>
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Country <span class="red">*</span></label>
                                <div class="error form_error"></div>
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">ZIP</label>
                                <div class="error form_error"></div>
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label for="name">Contact Reason <span class="red">*</span></label>
                                <div class="error form_error"></div>
                                <select>
                                    <option>New Product Idea</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label for="message">Your Message</label>
                                <div class="error form_error"></div>
                                <textarea name="message" id="message"></textarea>
                                <span class="note">Please provide additional details to help us address your need as quickly as possible.</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label for="name">Upload Document</label>
                                <div class="error form_error"></div>
                                <input type="file" name="name" id="name">
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

@endsection