<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400..700&display=swap" rel="stylesheet">

    <title></title>

    <style> html{ font-family: "Cabin", sans-serif; font-size: 12px; line-height: 1.3em; color: #444; } @page { size: A4; } body { width: 210mm; height: 297mm; } *{ margin: 0; padding: 0; } .inner_box{ padding: 8mm; display: flex; flex-direction: column; } table{ width: 100%; } th,td{ padding: 0.2mm; } ul li{ list-style: disc; list-style-position: inside; } .tabs_wrapper td{ width: 50%; vertical-align: top; } .tab_box{ padding: 0 0 15px; page-break-inside: avoid; } .footer{ position: absolute; bottom: 8mm; width: calc(100% - 16mm); } </style>
</head>

<body>
<div class="specification_page">
<div class="inner_box">

    <!-- HEADER -->
    <table cellpadding="0" cellspacing="0" style="padding-bottom:10px;">
        <tr>
          <td>
    <img src="{{ asset('electrical-assets/images/oec-logo.png') }}" width="120mm">
</td>
			<td style="text-align:right;font-size:22px;font-weight:700;color:#000;">
    @php
        $productType = $product->filterValues()
            ->whereHas('filterType', function ($q) {
                $q->where('title', 'Product Type');
            })
            ->first();
    @endphp

    {{ $productType?->value ?? $product->subCategory->title }}
</td>
            <!-- <td style="text-align:right;font-size:22px;font-weight:700;color:#000;">
                {{ $product->subCategory->title }}
            </td>-->
        </tr>
    </table>

    <!-- PRODUCT INFO -->
   <table cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
        <tr>
            <td width="50%">
                <div style="font-size:20px;font-weight:700;color:#000;padding-bottom:1mm;">
                    {{ $product->title }}
                </div>
                <div style="font-size:13px;font-weight:600;color:#666;padding-bottom:5px;">
                    {!! $product->description !!}
                </div>
                <div style="font-size:14px;font-weight:600;color:#000;padding-bottom:3px;">
                    Features
                </div>
                {!! $product->features !!}
            </td>

            <td width="50%">
    @php
        $image = $product->productImages->first();
        $src = null;

        if ($image) {
            $url = $image->image_file;
            $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));

            if ($ext === 'webp' && function_exists('imagecreatefromwebp')) {
                $img = imagecreatefromwebp($url);

                if ($img) {
                    ob_start();
                    imagepng($img);
                    $data = ob_get_clean();
                    imagedestroy($img);

                    $src = 'data:image/png;base64,' . base64_encode($data);
                }
            }

            if (!$src) {
                $src = $url;
            }
        }
    @endphp

    @if($src)
        <img
    src="{{ $src }}"
    style="max-width:60%;margin-left:10%;" alt="Product">
    @endif
</td>
        </tr>
    </table>

    <!-- FIXED TAB LAYOUT -->
    @if(!empty($product->productTabContents) && count($product->productTabContents) > 0)

    @php
        $leftTabs = [
            'General Specification',
            'Product Specification',
            'Electrical Rating',
        ];

        $rightTabs = [
            'Dimensions',
	        'Temperature Rating',
            'Conductor Related',
            'Certifications and Compliance',
        ];
    @endphp

    <table cellpadding="0" cellspacing="0" class="tabs_wrapper" style="table-layout:fixed;">
        <tr>
            <!-- LEFT COLUMN -->
            <td>
                @foreach($leftTabs as $title)
    @php
        $tab = $product->productTabContents
            ->first(fn($t) => $t->productTabLabel?->title === $title);
    @endphp

    @if($tab)
        <div class="tab_box">
            <strong style="font-size:14px;font-weight:700;color:#000;">
                {{ $tab->productTabLabel?->title }}
            </strong>
            {!! $tab->content !!}
        </div>
    @endif
@endforeach
            </td>

            <!-- RIGHT COLUMN -->
            <td>
               @foreach($rightTabs as $title)
    @php
        $tab = $product->productTabContents
            ->first(fn($t) => $t->productTabLabel?->title === $title);
    @endphp

    @if($tab)
        <div class="tab_box">
            <strong style="font-size:14px;font-weight:700;color:#000;">
                {{ $tab->productTabLabel?->title }}
            </strong>
            {!! $tab->content !!}
        </div>
    @endif
@endforeach
            </td>
        </tr>
    </table>
    @endif

    <!-- FOOTER -->
<div class="footer">
    <div style="font-size:12px;padding-bottom:10px;text-align:right;">
        © 2026 OEC USA Inc. All proprietary rights reserved
        <span>{{ $product->title }}</span>-SPEC-EN
    </div>

        <table cellpadding="0" cellspacing="0" style="background:#ff0016;padding:10px;">
            <tr>
                <td style="color:#fff;width:33%;">OEC USA Inc.</td>
                <td style="text-align:center;width:33%;">
                    <a href="http://www.oec-americas.com/" style="color:#fff;text-decoration:none;">
                        www.oec-americas.com
                    </a>
                </td>
                <td style="color:#fff;text-align:right;width:33%;">
                    <a href="tel:+18008819236" style="color:#fff;text-decoration:none;">
                        +1 (800) 881 9236
                    </a>
                </td>
            </tr>
        </table>
    </div>

</div>
</div>
</body>
</html>
