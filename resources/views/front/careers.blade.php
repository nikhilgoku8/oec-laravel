@extends('front.layout.master')

@section('content')

<div class="careers_page">
	
<div class="hero">
	<div class="fifty_years">
		<img src="{{ asset('front/assets/images/overview/50-years.webp') }}">
	</div>
	<div class="img_box">
		<!-- <img src="{{ asset('front/assets/images/overview/hero.svg') }}"> -->
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 283.5 19.6" preserveAspectRatio="none">
			<path class="elementor-shape-fill" style="opacity:0.33" d="M0 0L0 18.8 141.8 4.1 283.5 18.8 283.5 0z"></path>
			<path class="elementor-shape-fill" style="opacity:0.33" d="M0 0L0 12.6 141.8 4 283.5 12.6 283.5 0z"></path>
			<path class="elementor-shape-fill" style="opacity:0.33" d="M0 0L0 6.4 141.8 4 283.5 6.4 283.5 0z"></path>
			<path class="elementor-shape-fill" d="M0 0L0 1.2 141.8 4 283.5 1.2 283.5 0z"></path>
		</svg>
	</div>
</div>

<div class="about_oec">
    <div class="container">
        <div class="inner_container">

            <div class="inner_box">
                <div class="col-sm-6">
                    <div class="text_box">
                        <div class="title">About OEC</div>
                        <p>OEC was established in 1974 and is a family-owned, global leader in the manufacturing of electrical connectors, fittings, cable glands, automotive fittings, air brake products, and hoses. Over the last 50 years, OEC has consistently expanded its product portfolio to cater to the diverse needs of the electrical and automotive industries across the globe. OEC services various OEMs in the electrical, heavy-duty automotive, HVAC, and renewable industries. OEC also has a major presence in distribution and retail markets. We at OEC strive for excellence, innovation, and creativity, empowering OEC to be an industry leader and a generationally sustainable business. </p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="rings_wrapper">
                        <div class="ring_box">
                            <div class="ring">
                                <span class="lil_big"><span class="counter" data-target="700000">0</span> +</span>
                                <span class="lil_small">SQ.FT of Manufacturing</span>
                            </div>
                        </div>
                        <div class="ring_box">
                            <div class="ring">
                                <span class="lil_big"><span class="counter" data-target="15000">0</span> +</span>
                                <span class="lil_small">SKU’s</span>
                            </div>
                        </div>
                        <div class="ring_box">
                            <div class="ring">
                                <span class="lil_big"><span class="counter" data-target="100">0</span> +</span>
                                <span class="lil_small">Countries</span>
                            </div>
                        </div>
                        <div class="ring_box">
                            <div class="ring">
                                <span class="lil_big"><span class="counter" data-target="2100">0</span> +</span>
                                <span class="lil_small">Employees</span>
                            </div>
                        </div>
                        <div class="ring_box">
                            <div class="ring">
                                <span class="lil_big"><span class="counter" data-target="5">0</span></span>
                                <span class="lil_small">Facilities</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>

        </div>
    </div>
</div>
<!-- about_oec end -->

<div class="image_text_box">
	<div class="container">
		<div class="inner_container">
			
			<div class="inner_box">
				<div class="col-sm-6">
					<div class="img_box">
						<img src="{{ asset('front/assets/images/overview/oec-capabilities.webp') }}">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="text_box">
						<p>OEC's capabilities include forging, stamping, sand casting, shell moulding, injection moulding, die casting, and high-end precision machining. OEC's state of art facilities follow all global safety standards and boasts a dedicated R&D center, in-house tool development, in-house plating, and powder coating plants, and a UL-accredited Laboratory where we test and certify our products.</p>
					</div>
				</div>
				<div class="clr"></div>
			</div>

		</div>
	</div>
</div>
<!-- image_text_box end -->

</div>
<!-- careers_page end -->

@endsection