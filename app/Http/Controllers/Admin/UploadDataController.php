<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\Quality;
use App\Models\Admin\Product;

class UploadDataController extends Controller
{
    public function import_data()
    {
        return view('admin.imports.import-data');
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    public function importData(Request $request)
    {

        $rules = array(
            'data_file' => 'required|mimes:xlsx,csv'
        );

        $validator = Validator::make($request->all(), $rules);
        
        if(!$validator->passes()){
            return response()->json([
                'error' => true,
                'error_type' => 'form',
                'message' => 'Invalid request',
                'errors' => $validator->errors()->toArray(),
            ], 422);

        }else{

            $filename = time() . '-' . $request->file('data_file')->getClientOriginalName();
            $destination = storage_path("app/imports/" . $filename);
            $request->file('data_file')->move(storage_path("app/imports"), $filename);

            $data = Excel::toArray([], storage_path("app/imports/" . $filename))[0];

            $categories = [];
            $subCategories = [];
            $products = [];
            $productTabLabels = [];
            $productTabValues = [];
            $filterTypes = [];
            $filterValues = [];
            $now = now();

            foreach ($data as $index => $row) {
                if ($index === 0) continue; // Skip header row

                [$productName, $description, $categoryName, $subCategoryName, $images, $attributeName1, $attributeValue1, $attributeVisibility1, $attributeName2, $attributeValue2, $attributeVisibility2, $attributeName3, $attributeValue3, $attributeVisibility3, $attributeName4, $attributeValue4, $attributeVisibility4, $generalSpecification, $productSpecification, $certificationsAndCompliance, $dimensions, $electricalRating, $temperatureRating, $conductorRelated, $features, $catalogue] = array_map('trim', $row);

                if (!$productName || !$categoryName || !$subCategoryName) {
                    continue; // Skip invalid rows
                }

                // Cache Collection IDs
                $collections[$collectionName] = $collections[$collectionName] ?? DB::table('collections')->where('name', $collectionName)->value('id');
                if (!$collections[$collectionName]) {
                    $collectionSlug = $this->string_filter($collectionName);
                    $collections[$collectionName] = DB::table('collections')->insertGetId(['name' => $collectionName, 'slug' => $collectionSlug, 'img_file' => 'img_file_'.$index, 'description' => 'description', 'catalogue_file' => 'catalogue_file']);
                }

                // Cache End_Uses IDs
                $endUsesId = [];
                $endUsesName = array_filter(array_map('trim', explode(",", $endUseName)));
                foreach($endUsesName as $item){

                    // Try to get from cache or query
                    $end_uses[$item] = $end_uses[$item] ?? DB::table('end_uses')->where('name', $item)->value('id');

                    // If not found, insert it
                    if (!$end_uses[$item]) {
                        $end_uses[$item] = DB::table('end_uses')->insertGetId(['name' => $item]);
                    }
                    $endUsesId[] = $end_uses[$item];
                }

                // Cache Categories IDs
                $categoriesId = [];
                $categoriesName = array_filter(array_map('trim', explode(",", $categoryName)));
                foreach($categoriesName as $item){

                    // Try to get from cache or query
                    $categories[$item] = $categories[$item] ?? DB::table('categories')->where('name', $item)->value('id');

                    // If not found, insert it
                    if (!$categories[$item]) {
                        $categories[$item] = DB::table('categories')->insertGetId(['name' => $item]);
                    }
                    $categoriesId[] = $categories[$item]; // cleaner than array_push
                }

                // Cache Designs IDs
                $designsId = [];
                $designsName = array_filter(array_map('trim', explode(",", $designName)));
                foreach($designsName as $item){

                    // Try to get from cache or query
                    $designs[$item] = $designs[$item] ?? DB::table('designs')->where('name', $item)->value('id');

                    // If not found, insert it
                    if (!$designs[$item]) {
                        $designs[$item] = DB::table('designs')->insertGetId(['name' => $item]);
                    }
                    $designsId[] = $designs[$item]; // cleaner than array_push
                }

                // Cache Features IDs
                $featuresId = [];
                $featuresName = array_filter(array_map('trim', explode(",", $featureName)));
                foreach($featuresName as $item){

                    // Try to get from cache or query
                    $features[$item] = $features[$item] ?? DB::table('features')->where('name', $item)->value('id');

                    // If not found, insert it
                    if (!$features[$item]) {
                        $features[$item] = DB::table('features')->insertGetId(['name' => $item]);
                    }
                    $featuresId[] = $features[$item]; // cleaner than array_push
                }

                // Cache Cares IDs
                $caresId = [];
                $caresName = array_filter(array_map('trim', explode(",", $careName)));
                foreach($caresName as $item){

                    // Try to get from cache or query
                    $cares[$item] = $cares[$item] ?? DB::table('cares')->where('name', $item)->value('id');

                    // If not found, insert it
                    if (!$cares[$item]) {
                        $cares[$item] = DB::table('cares')->insertGetId(['name' => $item]);
                    }
                    $caresId[] = $cares[$item]; // cleaner than array_push
                }

                // Cache Compositions IDs
                $compositions[$compositionName] = $compositions[$compositionName] ?? DB::table('compositions')->where('name', $compositionName)->value('id');
                if (!$compositions[$compositionName]) {
                    $compositions[$compositionName] = DB::table('compositions')->insertGetId(['name' => $compositionName]);
                }

                // Cache Quality IDs
                $newQuality = false;
                $qualities[$qualityName] = $qualities[$qualityName] ?? DB::table('qualities')->where('name', $qualityName)->value('id');
                if (!$qualities[$qualityName]) {
                    $qualitySlug = $this->string_filter($qualityName);
                    $qualities[$qualityName] = DB::table('qualities')->insertGetId([
                        'name' => $qualityName,
                        'slug' => $qualitySlug,
                        'composition_id' => $compositions[$compositionName],
                        // 'glm' => $glm === "" ? NULL : $glm,
                        'glm' => is_numeric($glm) ? $glm : NULL,
                        'martindale' => is_numeric($martindale) ? $martindale : NULL
                    ]);
                    $newQuality = true;
                }

                // Fetch Eloquent Relation to update pivot tables
                $quality = Quality::find($qualities[$qualityName]);

                $quality->collections()->syncWithoutDetaching((array) $collections[$collectionName]);
                if (!empty($categoriesId)) {
                    $quality->categories()->syncWithoutDetaching((array) $categoriesId);
                }
                if (!empty($featuresId)) {                
                    $quality->features()->syncWithoutDetaching((array) $featuresId);
                }
                if (!empty($endUsesId)) {
                    $quality->endUses()->syncWithoutDetaching((array) $endUsesId);
                }
                if (!empty($caresId)) {
                    $quality->cares()->syncWithoutDetaching($caresId);
                }

                // Cache Design Number IDs
                $newDesignNumber = false;
                $design_numbers[$quality->id][$designNumber] = $design_numbers[$quality->id][$designNumber] ?? DB::table('design_numbers')->where('quality_id', $qualities[$qualityName])->where('design_number', $designNumber)->value('id');
                if (!$design_numbers[$quality->id][$designNumber]) {
                    $design_numbers[$quality->id][$designNumber] = DB::table('design_numbers')->insertGetId([
                        'quality_id' => $qualities[$qualityName],
                        'design_number' => $designNumber
                    ]);
                    $newDesignNumber = true;
                }

                // Update main_design_number_id for new Quality
                if($newQuality){
                    DB::table('qualities')->where('id', $qualities[$qualityName])->update(['main_design_number_id' => $design_numbers[$quality->id][$designNumber]]);
                }

                // Cache Product IDs
                $products[$quality->id][$srNo] = $products[$quality->id][$srNo] ?? DB::table('products')
                    ->join('design_numbers','products.design_number_id','design_numbers.id')
                    // ->join('qualities','design_numbers.quality_id','qualities.id')
                    ->where('design_numbers.quality_id', $qualities[$qualityName])
                    ->where('design_numbers.id', $design_numbers[$quality->id][$designNumber])
                    ->where('products.sr_no', $srNo)
                    ->value('products.id');
                if (!$products[$quality->id][$srNo]) {
                    $products[$quality->id][$srNo] = DB::table('products')->insertGetId([
                        'design_number_id' => $design_numbers[$quality->id][$designNumber],
                        'sr_no' => $srNo,
                        'horizontal_repeat_cms' => is_numeric($hrCms) ? $hrCms : NULL,
                        'vertical_repeat_cms' => is_numeric($vrCms) ? $vrCms : NULL,
                        'img_file' => $imgFile === "" ? $this->string_filter($qualityName).'-'.$srNo.'.jpg' : $imgFile,
                        'created_by' => 'Bulk Upload',
                        'updated_by' => 'Bulk Upload',
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }   

                $product = Product::find($products[$quality->id][$srNo]);

                if (!empty($designsId)) {
                    $product->designs()->syncWithoutDetaching((array) $designsId);
                }

                // Update main_product_id for new Design Number
                if($newDesignNumber){
                    DB::table('design_numbers')->where('id', $design_numbers[$quality->id][$designNumber])->update(['main_product_id' => $product->id]);
                }

                // Update main_product_id if main_product is yes
                if($mainProduct == 'yes'){
                    DB::table('qualities')->where('id', $qualities[$qualityName])->update(['main_design_number_id' => $design_numbers[$quality->id][$designNumber]]);
                    DB::table('design_numbers')->where('id', $design_numbers[$quality->id][$designNumber])->update(['main_product_id' => $product->id]);
                }

                // Collect sort order
                if ($sortOrder) {
                    $sortOrders[] = [
                        'collection_id' => $collections[$collectionName],
                        'product_id' => $products[$quality->id][$srNo],
                        'sort_order' => $sortOrder,
                        'created_at'    => $now,
                        'updated_at'    => $now,
                    ];

                    // **Insert in batches of 500**
                    if (count($sortOrders) >= 500) {
                        DB::table('collection_product')->upsert($sortOrders, ['collection_id', 'product_id'], ['sort_order']);
                        $sortOrders = []; // Reset array
                    }
                }
            }

            // **Insert remaining sort order**
            if (!empty($sortOrders)) {
                DB::table('collection_product')->upsert($sortOrders, ['collection_id', 'product_id'], ['sort_order']);
            }

            // **Delete the file after processing**
            $filePath = storage_path("app/imports/$filename");
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $response = array(
                'success' => true,
                'message' => 'Records added',
                'class' => 'alert alert-success'
            );
            // Session::flash('success','Data imported successfully!');
            session()->flash('success', 'Data imported successfully!');

            return response()->json($response);

        }
        
    }
}
