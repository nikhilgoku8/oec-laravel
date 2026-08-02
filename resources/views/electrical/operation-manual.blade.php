@extends('electrical.layout.master')

@section('content')

<div class="operation_manual_page">
    
    <div class="container">
        <div class="inner_container">
            
            <div class="heading">User Guide</div>

            <div class="text_box">
                <p>We provide detailed guidance on proper installation techniques, tool requirements, and best practices to ensure compliance with industry standards and optimal performance. Our reference guide includes key parameters such as wire size, connector type, crimping tool, die code, and crimping force to guarantee secure and reliable connections. By following standardized procedures, technicians and electricians can minimize the risk of faulty connections, preventing electrical failures, overheating, and poor conductivity.</p>
            </div>

            <div class="pdf_boxes">

                 <div class="pdf_box">
                    <a href="{{ asset('https://oec-americas.com/products/product-images/ACI0426.jpg') }}" 
					   class="img_box image_veno">
                        <img src="{{ asset('https://oec-americas.com/products/product-images/ACI0426.jpg') }}">
                    </a>
                    <div class="pdf_title">Aluminum Lug & Splice - Crimping Instruction</div>
                    <a href="{{ asset('https://oec-americas.com/products/product-images/ACI0426.pdf') }}"
					   class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
                <div class="pdf_box">
                    <a href="{{ asset('https://oec-americas.com/products/product-images/CCI0426.jpg') }}" 
					   class="img_box image_veno">
                        <img src="{{ asset('https://oec-americas.com/products/product-images/CCI0426.jpg') }}">
                    </a>
                    <div class="pdf_title">Copper Lug & Splice - Crimping Instruction</div>
                    <a href="{{ asset('https://oec-americas.com/products/product-images/CCI0426.pdf') }}" 
					   class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
                <div class="pdf_box">
                    <a href="{{ asset('https://oec-americas.com/products/product-images/insulated-connector-installation.jpg') }}" 
					   class="img_box image_veno">
                        <img src="{{ asset('https://oec-americas.com/products/product-images/insulated-connector-installation.jpg') }}">
                    </a>
                    <div class="pdf_title">Insulated Connector Installation Instruction</div>
                    <a href="{{ asset('https://oec-americas.com/products/product-images/insulated-connector-installation.pdf') }}" 
					   class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
				<div class="pdf_box">
                    <a href="{{ asset('https://oec-americas.com/products/product-images/instructions_307.jpg') }}" 
					   class="img_box image_veno">
                        <img src="{{ asset('https://oec-americas.com/products/product-images/instructions_307.jpg') }}">
                    </a>
                    <div class="pdf_title">Pin Adapter Installation Instruction</div>
                    <a href="{{ asset('https://oec-americas.com/products/product-images/instructions_307.pdf') }}" 
					   class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
                <div class="pdf_box">
                    <a href="{{ asset('https://oec-americas.com/products/product-images/cord-grip-instruction.jpg') }}" 
					   class="img_box image_veno">
                        <img src="{{ asset('https://oec-americas.com/products/product-images/cord-grip-instruction.jpg') }}">
                    </a>
                    <div class="pdf_title">Cord Grip Installation Instruction</div>
                    <a href="{{ asset('https://oec-americas.com/products/product-images/cord-grip-instruction.pdf') }}" 
					   class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
                <div class="pdf_box">
                    <a href="{{ asset('https://oec-americas.com/products/product-images/junction-box-installation.jpg') }}" 
					   class="img_box image_veno">
                        <img src="{{ asset('https://oec-americas.com/products/product-images/junction-box-installation.jpg') }}">
                    </a>
                    <div class="pdf_title">Junction Box Installation Instruction</div>
                    <a href="{{ asset('https://oec-americas.com/products/product-images/junction-box-installation.pdf') }}" 
					   class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
				<div class="pdf_box">
                    <a href="{{ asset('https://oec-americas.com/products/product-images/OEC5802.jpg') }}" 
					   class="img_box image_veno">
                        <img src="{{ asset('https://oec-americas.com/products/product-images/OEC5802.jpg') }}">
                    </a>
                    <div class="pdf_title">OEC5802 Installation Instruction</div>
                    <a href="{{ asset('https://oec-americas.com/products/product-images/instruction-sheet-AC-disconnect_OEC5802.pdf') }}"
					   class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
				<div class="pdf_box">
                    <a href="{{ asset('https://oec-americas.com/products/product-images/copper-tooling.jpg') }}" 
					   class="img_box image_veno">
                        <img src="{{ asset('https://oec-americas.com/products/product-images/copper-tooling.jpg') }}">
                    </a>
                    <div class="pdf_title">Terrafix Compression Grounding Connector Thin Wall C-Tap Installation Instruction</div>
                    <a href="{{ asset('https://oec-americas.com/products/product-images/copper-tooling.pdf') }}" 
					   class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
				<div class="pdf_box">
                    <a href="{{ asset('https://oec-americas.com/products/product-images/copper-tooling.jpg') }}" 
					   class="img_box image_veno">
                        <img src="{{ asset('https://oec-americas.com/products/product-images/copper-tooling.jpg') }}">
                    </a>
                    <div class="pdf_title">Terrafix Compression Grounding Connector C-Tap Installation Instruction</div>
                    <a href="{{ asset('https://oec-americas.com/products/product-images/copper-tooling.pdf') }}" 
					   class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>

            </div>
            <!-- pdf_boxes end -->

        </div>
    </div>

</div>
<!-- operation_manual_page end -->

@endsection