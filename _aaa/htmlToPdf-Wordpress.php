<?php
require 'dompdf/autoload.inc.php'; 
require(dirname(__FILE__) . '/wp-load.php'); 

use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize Dompdf options
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Arial');
$options->set('isPhpEnabled', true);
$options->set('marginTop', 0);
$options->set('marginBottom', 0);
$options->set('marginLeft', 0);
$options->set('marginRight', 0);

// Create Dompdf instance
$dompdf = new Dompdf($options);

// Function to check if an image exists
function imageExists($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ($http_code == 200);
}

// Function to fetch image as Base64
function fetchImageAsBase64($imageURL) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $imageURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $imageData = curl_exec($ch);
    curl_close($ch);
    return $imageData ? 'data:image/png;base64,' . base64_encode($imageData) : false;
}


global $wpdb;


// Specify the product ID you want to retrieve data for
$product_id = $_POST['postId']; // Replace with your actual product ID
//$product_id = 48007; 
// Get product data
$product = $wpdb->get_row($wpdb->prepare("
    SELECT * FROM {$wpdb->posts} 
    WHERE ID = %d AND post_type = 'product'
", $product_id));


// Check if the product exists
if ($product) {
    // Get product metadata
    $product_meta = $wpdb->get_results($wpdb->prepare("
        SELECT * FROM {$wpdb->postmeta} 
        WHERE post_id = %d
    ", $product_id));

    // Get the featured image (main image)
    $featured_image = wp_get_attachment_url(get_post_thumbnail_id($product_id));

    // Get the product object
    $productDetails = wc_get_product($product_id);

    // Get the gallery images
    $gallery_image_ids = $productDetails->get_gallery_image_ids();
    $gallery_images = array();

    foreach ($gallery_image_ids as $image_id) {
        $gallery_images[] = wp_get_attachment_url($image_id);
    }

    // Get product categories
    $terms = get_the_terms($product_id, 'product_cat');
    $categoryName = '';
    if ($terms && ! is_wp_error($terms)) {
        // echo '<h2>' . get_the_title() . '</h2>';
        // echo '<ul class="product-categories">';
        // foreach ( $terms as $term ) {
        //     echo '<li><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></li>';
        // }
        // echo '</ul>';
        $categoryName = $terms[0]->name;
        //echo '<pre>'.print_r( $terms[0]->name). '</pre>';

    }

    // Prepare an array to hold the metadata
    $meta_data = [];
    foreach ($product_meta as $meta) {
        $meta_data[$meta->meta_key] = $meta->meta_value;
    }

    // echo '<pre>' . print_r($product , true) . '</pre>';
    //   echo '<pre>' . print_r($meta_data, true) . '</pre>';

    // Output product data
    // echo '<h2>' . esc_html(  ) . '</h2>';
    // echo '<p>Product ID: ' . esc_html( $product->ID ) . '</p>';
    // echo '<p>Product Price: ' . esc_html( isset($meta_data['_price']) ? $meta_data['_price'] : 'N/A') . '</p>';
    // echo '<p>Stock Status: ' . esc_html( isset($meta_data['_stock_status']) ? $meta_data['_stock_status'] : 'N/A') . '</p>';
    // Your HTML content
    $subDescriptions = '';
    if ($product->post_excerpt) {
        $subDescriptions = $product->post_excerpt;
    }
    $descriptionFeature = '';
    if ($meta_data['feature']) {
        $descriptionFeature = 
        '<h4 class="feature-title"> Features </h4>' .$meta_data['feature'];
    }
    $generalSpecification = '';
    if ($meta_data['_wpt_field_wpt-8533']) {
        $generalSpecification = 
        '<div class="General-specification">
                  <div class="table-title">
                      <h4 class="gs-title">General Specifications <span></span> </h4>
                  </div>
                  <div class="table-div">
                      '.$meta_data['_wpt_field_wpt-8533'].'
                  </div>
              </div>';
    }
    $temperatureRating = '';
    if ($meta_data['_wpt_field_wpt-44463']) {
        $temperatureRating = 
        '<div class="General-specification">
                  <div class="table-title" style="padding-top:10px!important;">
                      <h4 class="gs-title">Temperature Rating <span></span> </h4>
                  </div>
                  <div class="table-div">
                      '.$meta_data['_wpt_field_wpt-44463'].'
                  </div>
              </div>';
    }

    $conductorRelated = '';
    if ($meta_data['_wpt_field_wpt-8718']) {
        $conductorRelated = 
        '<div class="General-specification">
                  <div class="table-title" style="padding-top:10px!important;">
                      <h4 class="gs-title">Conductor Related <span></span> </h4>
                  </div>
                  <div class="table-div">
                      '.$meta_data['_wpt_field_wpt-8718'].'
                  </div>
              </div>';
    }

    $productSpecification = '';
    if ($meta_data['_wpt_field_wpt-8534']) {
        $productSpecification =
            '<div class="General-specification">
                <div class="table-title" style="padding-top:10px!important;">
                    <h4>Product Specifications </h4>
                </div>
                <div class="table-div">
                 ' . $meta_data['_wpt_field_wpt-8534'] . '
                </div>
            </div>';
    }
    $certificationAndArea = '';
    if ($meta_data['_wpt_field_wpt-8535']) {
        $certificationAndArea =
            '<div class="General-specification">
              <div class="table-title" style="padding-top:10px!important;">
                    <h4">Certification and Compliances</h4>
                </div>
                <div class="table-div">
                 ' . $meta_data['_wpt_field_wpt-8535'] . '
                </div>
            </div>';
    }
    $dimensions = '';
    if ($meta_data['_wpt_field_wpt-8717']) {
    $dimensions =
        '<div class="General-specification">
            <div class="table-title" style="padding-top:10px!important;">
                <h4>Dimensions</h4>
            </div>
            <div class="table-div">
             ' . $meta_data['_wpt_field_wpt-8717'] . '
            </div>
        </div>';
}
    $feature = '';
    if (isset($meta_data['_wpt_field_wpt-8536']) && $meta_data['_wpt_field_wpt-8536'] !== '') {
        $feature =
            '<div class="General-specification">
                <div class="table-title" style="padding-top:10px!important;">
                    <h4>Feature</h4>
                </div>
                <div class="table-div">
                 ' . $meta_data['_wpt_field_wpt-8536'] . '
                </div>
            </div>';
    }
    $electricRating = '';
    if ($meta_data['_wpt_field_wpt-8719']) {
        $electricRating =
            '<div class="General-specification">
                <div class="table-title" style="padding-top:10px!important;">
                    <h4>Electrical Rating</h4>
                </div>
                <div class="table-div">
                 ' . $meta_data['_wpt_field_wpt-8719'] . '
                </div>
            </div>';
    }
    
    

 // Example Product Name
function sanitizeFileName($name) {
    return preg_replace('/[^A-Za-z0-9\-_]/', '_', trim($name));
}

$sanitizedTitle = sanitizeFileName($product->post_title);
$imagePath = __DIR__ . '/wp-content/uploads/product-images/' . $sanitizedTitle . '-1.webp';
   $logoImagePath = __DIR__ .'/wp-content/uploads/2024/10/logo-1.webp';

    if (file_exists($imagePath)) {
        $imageData = base64_encode(file_get_contents($imagePath));
        $src = 'data:image/png;base64,' . $imageData;
    } else {
        $src = '';
        //echo 'File does not exist: ' . $imagePath;
    }
    if (file_exists($logoImagePath)) {
        $logImageData = base64_encode(file_get_contents($logoImagePath));
        $logoSrc = 'data:image/png;base64,' . $logImageData;
    } else {
        $logoSrc = '';
        //echo 'File does not exist: ' . $imagePath;
    }


    $html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
</head>
<style>
@page {
                margin: 10px 20px 0px 29px;
            }
  body{
  font-size:;12px;
  }
  .footer-div {
                display: block;
                width: 100%;
                clear: both;
                padding-top: 5px;
                position: fixed;
                bottom: 8px;
                left: -7px;
                padding-bottom: 8px;
            }
            .footer-pdf {
                background-color: red;
                color: #fff;
                display: block;
                width: 100%;
            }
            .footer-pdf table {
                width: 100%;
            }
            .footer-pdf table td {
                width: 33.33%;
                text-align: center;
            }
            .footer-pdf table td:nth-child(1) {
                text-align: left;
            }
            .footer-pdf table td:nth-child(3) {
                text-align: right;
            }
            .footer-text {
                font-size: 6pt;
                color: #656761;
                text-align: right;
                margin-right: 24px;
            }

  .footer-div-list{
  width:33.33%; 
  
  }

.gs-title span{
display:inline-block;
float:right;
}  

.pdf-main-body{
      width:100%;
       display: block;
        font-family: Arial!important;
      }
      .main-table-div td{
		width: 50%; 
    }
        .table-list{
            marign-bottom:0px!important;
        }
      .table-list table{
      width: 100%; 
      margin-bottom:0px!important;
      }
    //  .table-list table tbody tr:nth-of-type(odd) {
    //     background-color: #dee5e3;
    //     opacity:1;
    // }
    h1{
     font-size:16px!important;
     }
     ul{
     margin:0px!important;
     padding:0px!important;
     list-style:none;
     }
  
.table-div{
font-size:12px!important;
margin-bottom:-15.8px;
}
.table-title h4{
margin-bottom:8px!important;}
.General-specification table{
      border-collapse: separate!important;
  border-spacing: 0 5px!important;
}
  .General-specification table tr td:first-child{
  width:155px; 
vertical-align: top;
  }
 .General-specification table tr td{
    font-size:10;
    padding:2px 5px;
    line-height:1.5em;
 }
    table {
    page-break-inside: avoid!important;
    }
    .pdf-list{
 padding: 0;
  list-style-type: none;
  margin: 0;
    }
    .pdf-list li{
     display: inline-block;
  width: 49%; /* Close to 50%, with a bit of margin for spacing */
  vertical-align: top; /* Aligns items to the top */
  box-sizing: border-box; /* Ensures padding doesn’t affect width */
  padding: 5px; /* Optional: adds spacing around items */
    }
.container {
  width: 100%;
}

.column {
  display: inline-block;

  vertical-align: top;
  box-sizing: border-box;
}
  .column.left{
    width: 48%;
  }
  .column.right{
  padding-top:5.2px;
    width: 44%;
  padding-left:20px!important;
  }
  .f-detaisl {
  display:block; 
  }
  .f-detaisl ul{
 padding: 0;
  
  list-style-type: none;
  margin: 0;
    height:100%;
    width:100%;
    display: inline-block;
    text-aling:center;
    padding-left:45px!important;
  }
.f-detaisl li{
 display: inline-block;
 height:20px;
  line-height:40px;
  width:33.33%;

}
  .feature-title{
 font-size:9pt;
  }
  .feature-list{
     margin-top:-2px!important;
     list-style:disc!important;
     margin-left:10px!important;
      font-size:8pt!important;
  }
 .feature-list li{
    font-size:8pt!important;
    color:#656761;
      margin-top:0px;
    margin-bottom:1.4px;
 }
   .gs-title, .table-title{
     font-size:9pt;
    }
     .table-div td{ 
      font-size:8pt!important;
      color:#646660;
      padding-left:0px!important;
      }
      .column.left{
      padding-top:5px;
        padding-left:0px!important;
      }
        .oec-footer-table td{padding:14.5px 5px 13px 5px!important;font-size:9pt;}
    

  </style>
<body style="font-family: Arial, sans-serif;">
 <div class="main-pdf-body" style="width: 100%;">
        <table style="width: 100%;border-spacing: 0px;margin-bottom:0px!important;" class="main-table-div">
            <thead >
                <tr>
                    <td style="padding-left:0px!important; vertical-align: top; padding-top:3px!important;">
            <div class="logo-main" style="padding-left:0px;padding-top:19.5px!important;margin-left:-7.5px;">
                ' . $logoTag . '
            </div>
        </td>
                    <td  style="vertical-align: top;padding-top:15px!important;padding-right:17px!important;">
                        <div class="title-div" style="padding-right:0.5px!important;padding-top:2px!important;">
                            <h4 class="categorey-name" style="text-align: right; font-size:19px;max-width:200px;margin:0px 0px 0px auto; font-family: Arial, sans-serif;">
                            '. $categoryName .'
                            </h4>
                        </div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                  
                    <td style="padding:0px!important; vertical-align:top;" >
                    <div> </div>
                        <div class="product-name" style="margin-top:0px;padding-top:20.0px!important; ">
                            <h5  style="font-size:14pt; margin-bottom:18px!important; margin-top:20px; text-align:left!important; display:block;" >'. $product->post_title .'</h5>
                            <p class="discription" style="color:#646660!important; margin-bottom:-2px!important;font-size:9pt;line-height:1.3em;font-weight:bold!important;">
                               ' . $subDescriptions . '
                            </p>
                            
                           '.$descriptionFeature.'
                        </div>
                    </td>
                     <td style="padding:0px!important;vertical-align:  top;">
                        <div class="product-image" style="width:100%">
                           <img src="' . $src . '"  alt="" style="width:auto; height:240px;object-fit:contain ;margin-top:50px;margin-left:35px;">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <section class="container">
  <article class="column left">
   <div class="table-list">
             '. $generalSpecification .'
        </div>
         <div class="table-list">
           '. $productSpecification .'
     </div>
      <div class="table-list">
        '. $electricRating .'
      </div>
  </article>
  <article class="column right">
   
           
             
  <div class="table-list">
   '. $dimensions .' 
      </div>
      <div class="table-list">
            '. $temperatureRating .' 
           </div>
     <div class="table-list">
            '. $conductorRelated .' 
           </div>      
     <div class="table-list">
            '. $certificationAndArea .' 
        </div>
          <div class="table-list">
        '. $feature .'
      </div>
  </article> 
</section> 
 

<div class="footer-div" style="display: block; width:100%; clear:both; padding-top:5px;" >
        <p style="display: block;clear:both; font-size:6pt;color:#656761; padding-right:20px!important;  text-align: right!important; width:100%!important;"> <span style="margin-right:24px;">© 2025 OEC USA Inc. All proprietary rights are hereby reserved OEC-'.$product->post_title.'-SPEC-EN </span> </p>
        <div class="footer-pdf" style="background-color: red; color: #fff; display:block;width:100%;">
       
       
            <table style=" width:100%" class="oec-footer-table"> 
                    <tr>
                        <td style="width:33.33%;text-align:left;padding:14.5px 5px 13px 5px!important;font-size:9pt;">  OEC USA Inc. </td>
                        <td style="width:33.33%;text-align:center;padding:14.5px 5px 13px 5px!important;font-size:9pt;">  www.oec-americas.com  </td>
                        <td style="width:33.33%; text-align:right;padding:14.5px 5px 13px 5px!important;font-size:9pt;">+1 (732) 479 0469</td>
                    </tr> 
                </table>
          
        </div>
    </div>
    
      
      </body>
</html>
';

    // Load HTML content
    $dompdf->loadHtml($html);
 // Set the paper size and orientation
 $dompdf->setPaper('A4', 'portrait');

 // Render the PDF (this will generate the document)
 $dompdf->render();

 // Get the canvas to add footer manually
 $canvas = $dompdf->getCanvas();
 $canvasWidth = $canvas->get_width();
 $canvasHeight = $canvas->get_height();

 // Set the footer content
 $footerText = '<div class="footer-div" style="display: block; width:100%; clear:both; padding-top:5px;" >
        <p style="display: block;clear:both; font-size:6pt;color:#656761; padding-right:20px!important;  text-align: right!important; width:100%!important;"> <span style="margin-right:24px;">© 2025 OEC Incorporated. All proprietary rights are hereby reserved OEC-98073-SPEC-EN </span> </p>
        <div class="footer-pdf" style="background-color: red; color: #fff; display:block;width:100%;">
       
       
            <table style=" width:100%" class="oec-footer-table"> 
                    <tr>
                        <td style="width:33.33%;text-align:left;padding:14.5px 5px 13px 5px!important;font-size:9pt;">  OEC USA Inc. </td>
                        <td style="width:33.33%;text-align:center;padding:14.5px 5px 13px 5px!important;font-size:9pt;">  www.oec-americas.com  </td>
                        <td style="width:33.33%; text-align:right;padding:14.5px 5px 13px 5px!important;font-size:9pt;">+1 (732) 479 0469</td>
                    </tr> 
                </table>
          
        </div>
    </div>';

// Get PDF output
    $pdfOutput = $dompdf->output();

    // Set headers to force download with the desired filename
    header("Content-Type: application/pdf");
    
    // **Important**: Force the filename to be exactly `98001.pdf`
    header("Content-Disposition: attachment; filename=\"98001.pdf\"");

    // Clear caching headers to ensure fresh download
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Output the PDF to the browser
    echo $pdfOutput;
    exit;
} else {
    echo 'Product not found.';
}
?>