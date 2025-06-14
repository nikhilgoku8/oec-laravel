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
            $duplicateProducts = [];

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
                // $collections[$collectionName] = $collections[$collectionName] ?? DB::table('collections')->where('title', $collectionName)->value('id');
                // if (!$collections[$collectionName]) {
                //     $collectionSlug = $this->string_filter($collectionName);
                //     $collections[$collectionName] = DB::table('collections')->insertGetId(['title' => $collectionName, 'slug' => $collectionSlug, 'img_file' => 'img_file_'.$index, 'description' => 'description', 'catalogue_file' => 'catalogue_file']);
                // }

                // Cache Categories IDs
                // $categoriesId = [];
                // $categoriesName = array_filter(array_map('trim', explode(",", $categoryName)));
                // foreach($categoriesName as $item){

                //     // Try to get from cache or query
                //     $categories[$item] = $categories[$item] ?? DB::table('categories')->where('title', $item)->value('id');

                //     // If not found, insert it
                //     if (!$categories[$item]) {
                //         $categories[$item] = DB::table('categories')->insertGetId(['title' => $item]);
                //     }
                //     $categoriesId[] = $categories[$item]; // cleaner than array_push
                // }

                // Fetch Eloquent Relation to update pivot tables
                // $quality = Quality::find($qualities[$qualityName]);

                // $quality->collections()->syncWithoutDetaching((array) $collections[$collectionName]);
                // if (!empty($categoriesId)) {
                //     $quality->categories()->syncWithoutDetaching((array) $categoriesId);
                // }

                // Cache Design Number IDs
                // $newDesignNumber = false;
                // $design_numbers[$quality->id][$designNumber] = $design_numbers[$quality->id][$designNumber] ?? DB::table('design_numbers')->where('quality_id', $qualities[$qualityName])->where('design_number', $designNumber)->value('id');
                // if (!$design_numbers[$quality->id][$designNumber]) {
                //     $design_numbers[$quality->id][$designNumber] = DB::table('design_numbers')->insertGetId([
                //         'quality_id' => $qualities[$qualityName],
                //         'design_number' => $designNumber
                //     ]);
                //     $newDesignNumber = true;
                // }

                // Cache Categories IDs
                $categories[$categoryName] = $categories[$categoryName] ?? DB::table('categories')->where('title', $categoryName)->value('id');
                if (!$categories[$categoryName]) {
                    $categorySlug = $this->string_filter($categoryName);
                    $categories[$categoryName] = DB::table('categories')->insertGetId(['title' => $categoryName, 'slug' => $categorySlug]);
                }

                // Cache Sub Categories IDs
                $subCategories[$subCategoryName] = $subCategories[$subCategoryName] ?? DB::table('sub_categories')->where('title', $subCategoryName)->value('id');
                if (!$subCategories[$subCategoryName]) {
                    $subCategorySlug = $this->string_filter($subCategoryName);
                    $subCategories[$subCategoryName] = DB::table('sub_categories')->insertGetId([
                        'category_id' => $categories[$categoryName],
                        'title' => $subCategoryName,
                        'slug' => $subCategorySlug
                    ]);
                }

                // Cache Products IDs
                $products[$productName] = $products[$productName] ?? DB::table('products')->where('title', $productName)->value('id');
                if (!$products[$productName]) {
                    $products[$productName] = DB::table('products')->insertGetId([
                        'sub_category_id ' => $subCategories[$subCategoryName],
                        'title' => $productName,
                        'description' => $description,
                        'features' => $features
                    ]);
                }else{
                    // Duplicate products and skip that row to not create confusion
                    $duplicateProducts[] = $productName;
                    continue;
                }

                // Add Images
                $imagesArray = array_filter(array_map('trim', explode(",", $images)));
                foreach($imagesArray as $item){
                    // DB::table('product_images')->insert(['product_id' => $products[$productName],'image_file' => $item]);
                    $productImagesBulk[] = [
                        'product_id' => $products[$productName],
                        'image_file' => $item,
                        'created_at'    => $now,
                        'updated_at'    => $now,
                    ];
                }

                // **Insert in batches of 500**
                if (count($productImagesBulk) >= 500) {
                    DB::table('product_images')->insert($productImagesBulk);
                    $productImagesBulk = []; // Reset array
                }

                // $filterTypes = [];
                $maxIndex = 4; // Adjust to expected max fields

                for ($i = 1; $i <= $maxIndex; $i++) {
                    $nameVar = 'attributeName' . $i;
                    $valueVar = 'attributeValue' . $i;

                    if (empty($$nameVar) || empty($$valueVar)) {
                        continue;
                    }

                    $attributeName = $$nameVar;
                    $attributeValue = $$valueVar ?? null;

                    // Step 1: Get or insert filter_type
                    $filterTypes[$attributeName] = $filterTypes[$attributeName]
                        ?? DB::table('filter_types')->where('title', $attributeName)->value('id');

                    if (!$filterTypes[$attributeName]) {
                        $filterTypes[$attributeName] = DB::table('filter_types')->insertGetId([
                            'title' => $attributeName,
                            'slug'  => $categorySlug,
                        ]);
                    }

                    // Step 2: Get or insert filter_value
                    $filterTypeId = $filterTypes[$attributeName];

                    $filterValueId = DB::table('filter_values')
                        ->where('filter_type_id', $filterTypeId)
                        ->where('value', $attributeValue)
                        ->value('id');

                    if (!$filterValueId) {
                        $filterValueId = DB::table('filter_values')->insertGetId([
                            'filter_type_id' => $filterTypeId,
                            'value'          => $attributeValue,
                        ]);
                    }

                    // Step 3: Insert into pivot table
                    DB::table('filter_value_product')->insert([
                        'product_id'       => $productId,
                        'filter_value_id'  => $filterValueId,
                    ]);
                }


                // Cache Filter Type IDs
                // if($attributeName1){
                //     $filterTypes[$attributeName1] = $filterTypes[$attributeName1] ?? DB::table('filter_types')->where('title', $attributeName1)->value('id');
                //     if (!$filterTypes[$attributeName1]) {
                //         $filterTypes[$attributeName1] = DB::table('filter_types')->insertGetId(['title' => $attributeName1, 'slug' => $categorySlug]);
                //     }
                // }
                // if($attributeName2){
                //     $filterTypes[$attributeName2] = $filterTypes[$attributeName2] ?? DB::table('filter_types')->where('title', $attributeName2)->value('id');
                //     if (!$filterTypes[$attributeName2]) {
                //         $filterTypes[$attributeName2] = DB::table('filter_types')->insertGetId(['title' => $attributeName2, 'slug' => $categorySlug]);
                //     }
                // }




                // // Cache Quality IDs
                // $newQuality = false;
                // $qualities[$qualityName] = $qualities[$qualityName] ?? DB::table('qualities')->where('title', $qualityName)->value('id');
                // if (!$qualities[$qualityName]) {
                //     $qualitySlug = $this->string_filter($qualityName);
                //     $qualities[$qualityName] = DB::table('qualities')->insertGetId([
                //         'title' => $qualityName,
                //         'slug' => $qualitySlug,
                //         'composition_id' => $compositions[$compositionName],
                //         // 'glm' => $glm === "" ? NULL : $glm,
                //         'glm' => is_numeric($glm) ? $glm : NULL,
                //         'martindale' => is_numeric($martindale) ? $martindale : NULL
                //     ]);
                //     $newQuality = true;
                // }


                // // Update main_design_number_id for new Quality
                // if($newQuality){
                //     DB::table('qualities')->where('id', $qualities[$qualityName])->update(['main_design_number_id' => $design_numbers[$quality->id][$designNumber]]);
                // }

                // // Cache Product IDs
                // $products[$quality->id][$srNo] = $products[$quality->id][$srNo] ?? DB::table('products')
                //     ->join('design_numbers','products.design_number_id','design_numbers.id')
                //     // ->join('qualities','design_numbers.quality_id','qualities.id')
                //     ->where('design_numbers.quality_id', $qualities[$qualityName])
                //     ->where('design_numbers.id', $design_numbers[$quality->id][$designNumber])
                //     ->where('products.sr_no', $srNo)
                //     ->value('products.id');
                // if (!$products[$quality->id][$srNo]) {
                //     $products[$quality->id][$srNo] = DB::table('products')->insertGetId([
                //         'design_number_id' => $design_numbers[$quality->id][$designNumber],
                //         'sr_no' => $srNo,
                //         'horizontal_repeat_cms' => is_numeric($hrCms) ? $hrCms : NULL,
                //         'vertical_repeat_cms' => is_numeric($vrCms) ? $vrCms : NULL,
                //         'img_file' => $imgFile === "" ? $this->string_filter($qualityName).'-'.$srNo.'.jpg' : $imgFile,
                //         'created_by' => 'Bulk Upload',
                //         'updated_by' => 'Bulk Upload',
                //         'created_at' => $now,
                //         'updated_at' => $now
                //     ]);
                // }   

                // $product = Product::find($products[$quality->id][$srNo]);

                // if (!empty($designsId)) {
                //     $product->designs()->syncWithoutDetaching((array) $designsId);
                // }

                // // Update main_product_id for new Design Number
                // if($newDesignNumber){
                //     DB::table('design_numbers')->where('id', $design_numbers[$quality->id][$designNumber])->update(['main_product_id' => $product->id]);
                // }

                // // Update main_product_id if main_product is yes
                // if($mainProduct == 'yes'){
                //     DB::table('qualities')->where('id', $qualities[$qualityName])->update(['main_design_number_id' => $design_numbers[$quality->id][$designNumber]]);
                //     DB::table('design_numbers')->where('id', $design_numbers[$quality->id][$designNumber])->update(['main_product_id' => $product->id]);
                // }

                // // Collect sort order
                // if ($sortOrder) {
                //     $sortOrders[] = [
                //         'collection_id' => $collections[$collectionName],
                //         'product_id' => $products[$quality->id][$srNo],
                //         'sort_order' => $sortOrder,
                //         'created_at'    => $now,
                //         'updated_at'    => $now,
                //     ];

                //     // **Insert in batches of 500**
                //     if (count($sortOrders) >= 500) {
                //         DB::table('collection_product')->upsert($sortOrders, ['collection_id', 'product_id'], ['sort_order']);
                //         $sortOrders = []; // Reset array
                //     }
                // }
            }

            // **Insert remaining product images**
            if (!empty($productImagesBulk)) {
                DB::table('product_images')->insert($productImagesBulk);
            }

            // **Insert remaining sort order**
            // if (!empty($sortOrders)) {
            //     DB::table('collection_product')->upsert($sortOrders, ['collection_id', 'product_id'], ['sort_order']);
            // }

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
