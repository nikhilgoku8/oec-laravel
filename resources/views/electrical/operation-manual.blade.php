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
                    <a href="{{ asset('electrical-assets/operation-manual/aluminum-compression-connectors.png') }}" class="img_box image_veno">
                        <img src="{{ asset('electrical-assets/operation-manual/aluminum-compression-connectors.png') }}">
                    </a>
                    <div class="pdf_title">Aluminum Compression Connectors</div>
                    <a href="{{ asset('electrical-assets/operation-manual/aluminum-compression-connectors.pdf') }}" class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
                <div class="pdf_box">
                    <a href="{{ asset('electrical-assets/operation-manual/copper-compression-connectors.png') }}" class="img_box image_veno">
                        <img src="{{ asset('electrical-assets/operation-manual/copper-compression-connectors.png') }}">
                    </a>
                    <div class="pdf_title">Copper Compression Connectors</div>
                    <a href="{{ asset('electrical-assets/operation-manual/copper-compression-connectors.pdf') }}" class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
                <div class="pdf_box">
                    <a href="{{ asset('electrical-assets/operation-manual/insulated-connector-installation.png') }}" class="img_box image_veno">
                        <img src="{{ asset('electrical-assets/operation-manual/insulated-connector-installation.png') }}">
                    </a>
                    <div class="pdf_title">Insulated Connector Installation</div>
                    <a href="{{ asset('electrical-assets/operation-manual/insulated-connector-installation.pdf') }}" class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
                <div class="pdf_box">
                    <a href="{{ asset('electrical-assets/operation-manual/cord-grip-connector-installation.png') }}" class="img_box image_veno">
                        <img src="{{ asset('electrical-assets/operation-manual/cord-grip-connector-installation.png') }}">
                    </a>
                    <div class="pdf_title">Cord Grip Connector Installation</div>
                    <a href="{{ asset('electrical-assets/operation-manual/cord-grip-connector-installation.pdf') }}" class="red_filled_btn" target="_blank">
                        <span class="icon"><i class="fas fa-download"></i></span>
                        Download
                    </a>
                </div>
                <div class="pdf_box">
                    <a href="{{ asset('electrical-assets/operation-manual/junction-box-installation.png') }}" class="img_box image_veno">
                        <img src="{{ asset('electrical-assets/operation-manual/junction-box-installation.png') }}">
                    </a>
                    <div class="pdf_title">Junction Box Installation</div>
                    <a href="{{ asset('electrical-assets/operation-manual/junction-box-installation.pdf') }}" class="red_filled_btn" target="_blank">
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