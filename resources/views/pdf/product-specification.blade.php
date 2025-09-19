<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<title></title>
<style>
html{
    font-family: "Cabin", sans-serif;
    font-size: 12px;
    line-height: 1.3em;
    color: #444;
}
@page {
    size: A4;
    /*margin: 15mm;*/
}
body {
    width: 210mm;
    height: 297mm;
}
*{
    margin: 0;
    padding: 0;
}
.inner_box{
    padding: 8mm;
    display: flex;
    flex-direction: column;
}
table{
    width: 100%;
}
th,td{
    padding: 0.2mm;
}
ul li{
    list-style: disc;
    list-style-position: inside;
    line-height: 1em;
}
.product_info_wrapper{
    /*display: flex;
    align-items: center;*/
}
.product_info_wrapper .left_info{
    width: 50%;
}
.product_info_wrapper .right_img{
    width: 50%;
}
.tabs_wrapper .tab_box{
    padding: 0 0 15px;
    break-inside: avoid;      /* Standard */
    page-break-inside: avoid; /* Older wkhtmltopdf/WebKit */
    -webkit-column-break-inside: avoid; /* Vendor prefix */
}
.tabs_wrapper .tab_box .tab_title{
    padding: 0 0 0 5px;
    font-size: 16px;
    font-weight: 600;
    color: #000;
}
.tabs_wrapper table td{
    width: 50%;
    vertical-align: top;
}
.footer {
    position: absolute; bottom: 8mm; text-align: center; width: calc(100% - 16mm); font-size: 10pt;
}
</style>
</head>
<body>

<div class="specification_page">
    <div class="inner_box">

        <table cellpadding="0" cellspacing="0" style="margin:0;padding:0 0 10px 0;">
            <tr>
                <td><img src="{{ asset('electrical-assets/images/oec-logo.png') }}" width="120mm"></td>
                <td style="text-align:right;font-size: 22px;font-weight: 700;color: #000;">{{ $product->subCategory->title }}</td>
            </tr>
        </table>
        <!-- <div class="sub_category_title" style="text-align:right;font-size: 22px;font-weight: 700;color: #000;">{{ $product->subCategory->title }}</div> -->
        <table class="product_info_wrapper" cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse;padding: 0 0 5mm;">
            <tbody>
                <tr>
                    <td class="left_info" style="width: 50%;">
                        <div class="product_title" style=";font-size: 20px;font-weight: 700;color: #000;padding:0 0 1mm;">{{ $product->title }}</div>
                        <div class="product_description" style="font-size: 13px;line-height:1.1em;font-weight: 600;color: #666;padding:0 0 15px;">{!! $product->description !!}</div>
                        <div class="features_title" style="font-size: 14px;font-weight: 600;color: #000;padding:0 0 10px;">Features</div>
                        {!! $product->features !!}
                    </td>
                    <td class="right_img" style="width: 50%;">
                        <!-- <img src="{{ $product->productImages[0]->image_file }}" alt="" style="max-width: 80%;" /> -->
                        @php
                            $url = $product->productImages[0]->image_file;
                            $ext = pathinfo($url, PATHINFO_EXTENSION);

                            if ($ext === 'webp') {
                                $img = imagecreatefromwebp($url);
                                ob_start();
                                imagepng($img);
                                $data = ob_get_clean();
                                imagedestroy($img);

                                $src = 'data:image/png;base64,' . base64_encode($data);
                            } else {
                                $src = $url; // or fetch + base64 as before
                            }
                        @endphp

                        <img src="{{ $src }}" style="max-width:60%;margin: 0 0 0 10%;" alt="Product">
                    </td>
                </tr>
            </tbody>
        </table>

        @if(!empty($product->productTabContents) && count($product->productTabContents) > 0)
        <table cellpadding="0" cellspacing="0" width="100%" class="tabs_wrapper">
            <tr>
                <td width="50%" valign="top">
                    @foreach($product->productTabContents as $tabContent)
                        @if($tabContent->productTabLabel->title == 'General Specification')
                            <div style="page-break-inside: avoid;padding: 0 0 15px;">
                                <strong style="font-size: 14px;font-weight: 700;color: #000;padding:0 0 0 1mm;">{{ $tabContent->productTabLabel->title }}</strong>
                                {!! $tabContent->content !!}
                            </div>
                        @endif
                        @if($tabContent->productTabLabel->title == 'Product Specification')
                            <div style="page-break-inside: avoid;padding: 0 0 15px;">
                                <strong style="font-size: 14px;font-weight: 700;color: #000;padding:0 0 0 1mm;">{{ $tabContent->productTabLabel->title }}</strong>
                                {!! $tabContent->content !!}
                            </div>
                        @endif
                        @if($tabContent->productTabLabel->title == 'Electrical Rating')
                            <div style="page-break-inside: avoid;padding: 0 0 15px;">
                                <strong style="font-size: 14px;font-weight: 700;color: #000;padding:0 0 0 1mm;">{{ $tabContent->productTabLabel->title }}</strong>
                                {!! $tabContent->content !!}
                            </div>
                        @endif
                    @endforeach
                </td>
                <td width="50%" valign="top">
                    @php
                        $order = [
                            'Dimensions',
                            'Temperature Rating',
                            'Conductor Related',
                            'Certifications And Compliance'
                        ];

                        $sortedTabs = $product->productTabContents->sortBy(function($tabContent) use ($order) {
                            return array_search($tabContent->productTabLabel->title, $order);
                        });
                    @endphp
                    @foreach($sortedTabs as $tabContent)
                        @if(in_array($tabContent->productTabLabel->title, $order))
                            <div style="page-break-inside: avoid;padding: 0 0 15px;">
                                <strong style="font-size: 14px;font-weight: 700;color: #000;padding:0 0 0 1mm;">
                                    {{ $tabContent->productTabLabel->title }}
                                </strong>
                                {!! $tabContent->content !!}
                            </div>
                        @endif
                    @endforeach
                </td>
            </tr>
        </table>
        @endif

        <div class="footer">
            <div class="copyright_text" style="font-size:12px;padding: 20px 0 10px 0;margin: auto 0 0 0;text-align: right;">© 2025 OEC USA Inc. All proprietary rights are hereby reserved OEC-21000-SPEC-EN </div>

            <table cellpadding="0" cellspacing="0" class="red_box" style="background: #ff0016;align-items: center;padding: 10px;width: 100%;">
                <tbody>
                    <tr>
                        <td style="color:#fff;width: 33.33%;">OEC USA Inc.</td>
                        <td style="text-align: center;width: 33.33%;">
                            <a href="http://www.oec-americas.com/" style="color:#fff;text-decoration: none;">www.oec-americas.com</a>
                        </td>
                        <td style="color:#fff;text-align: right;width: 33.33%;">
                            <a href="tel:+1(732)4790469" style="color:#fff;text-decoration: none;">+1 (732) 479 0469</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>