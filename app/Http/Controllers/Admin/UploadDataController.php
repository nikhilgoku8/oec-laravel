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
            dd($validator->errors());
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
            $filterValuesBulk = [];

            $now = now();

            foreach ($data as $index => $row) {
                if ($index === 0) continue; // Skip header row

                [$productName, $description, $categoryName, $subCategoryName, $images, $attributeName1, $attributeValue1, $attributeVisibility1, $attributeName2, $attributeValue2, $attributeVisibility2, $attributeName3, $attributeValue3, $attributeVisibility3, $attributeName4, $attributeValue4, $attributeVisibility4, $attributeName5, $attributeValue5, $attributeVisibility5, $attributeName6, $attributeValue6, $attributeVisibility6, $attributeName7, $attributeValue7, $attributeVisibility7, $attributeName8, $attributeValue8, $attributeVisibility8, $attributeName9, $attributeValue9, $attributeVisibility9, $generalSpecification, $productSpecification, $certificationsAndCompliance, $dimensions, $electricalRating, $temperatureRating, $conductorRelated, $features, $catalogue] = array_map('trim', $row);

                if (!$productName || !$categoryName || !$subCategoryName) {
                    continue; // Skip invalid rows
                }

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
                        'sub_category_id' => $subCategories[$subCategoryName],
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
                $maxIndex = 9; // Adjust to expected max fields

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
                        ]);
                    }

                    // Step 2: Get or insert filter_value
                    $filterTypeId = $filterTypes[$attributeName];

                    $filterValues[$attributeName][$attributeValue] = $filterValues[$attributeName][$attributeValue] ?? DB::table('filter_values')
                        ->where('filter_type_id', $filterTypeId)
                        ->where('value', $attributeValue)
                        ->value('id');

                    if (!$filterValues[$attributeName][$attributeValue]) {
                        $filterValues[$attributeName][$attributeValue] = DB::table('filter_values')->insertGetId([
                            'filter_type_id' => $filterTypeId,
                            'value'          => $attributeValue,
                        ]);
                    }

                    // Step 3: Insert into pivot table
                    $filterValuesBulk[] = [
                        'product_id'       => $products[$productName],
                        'filter_value_id'  => $filterValues[$attributeName][$attributeValue],
                    ];

                    // **Insert in batches of 500**
                    if (count($filterValuesBulk) >= 500) {
                        DB::table('filter_value_product')->insert($filterValuesBulk);
                        $filterValuesBulk = []; // Reset array
                    }
                }

                // Add generalSpecification Tabs
                if ($generalSpecification) {
                    $productTabLabels['generalSpecification'] = $productTabLabels['generalSpecification']
                        ?? DB::table('product_tab_labels')->where('title', 'General Specification')->value('id');
                    if (!$productTabLabels['generalSpecification']) {
                        $productTabLabels['generalSpecification'] = DB::table('product_tab_labels')->insertGetId(['title' => 'General Specification']);
                    }

                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['generalSpecification'],
                        'product_id' => $products[$productName],
                        'content' => $generalSpecification
                    ];
                }

                // Add productSpecification Tabs
                if ($productSpecification) {
                    $productTabLabels['productSpecification'] = $productTabLabels['productSpecification']
                        ?? DB::table('product_tab_labels')->where('title', 'Product Specification')->value('id');
                    if (!$productTabLabels['productSpecification']) {
                        $productTabLabels['productSpecification'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Product Specification']);
                    }

                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['productSpecification'],
                        'product_id' => $products[$productName],
                        'content' => $productSpecification
                    ];
                }

                // Add certificationsAndCompliance Tabs
                if ($certificationsAndCompliance) {
                    $productTabLabels['certificationsAndCompliance'] = $productTabLabels['certificationsAndCompliance']
                        ?? DB::table('product_tab_labels')->where('title', 'Certifications And Compliance')->value('id');
                    if (!$productTabLabels['certificationsAndCompliance']) {
                        $productTabLabels['certificationsAndCompliance'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Certifications And Compliance']);
                    }

                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['certificationsAndCompliance'],
                        'product_id' => $products[$productName],
                        'content' => $certificationsAndCompliance
                    ];
                }

                // Add dimensions Tabs
                if ($dimensions) {
                    $productTabLabels['dimensions'] = $productTabLabels['dimensions']
                        ?? DB::table('product_tab_labels')->where('title', 'Dimensions')->value('id');
                    if (!$productTabLabels['dimensions']) {
                        $productTabLabels['dimensions'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Dimensions']);
                    }

                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['dimensions'],
                        'product_id' => $products[$productName],
                        'content' => $dimensions
                    ];
                }

                // Add electricalRating Tabs
                if ($electricalRating) {
                    $productTabLabels['electricalRating'] = $productTabLabels['electricalRating']
                        ?? DB::table('product_tab_labels')->where('title', 'Electrical Rating')->value('id');
                    if (!$productTabLabels['electricalRating']) {
                        $productTabLabels['electricalRating'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Electrical Rating']);
                    }

                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['electricalRating'],
                        'product_id' => $products[$productName],
                        'content' => $electricalRating
                    ];
                }

                // Add temperatureRating Tabs
                if ($temperatureRating) {
                    $productTabLabels['temperatureRating'] = $productTabLabels['temperatureRating']
                        ?? DB::table('product_tab_labels')->where('title', 'Temperature Rating')->value('id');
                    if (!$productTabLabels['temperatureRating']) {
                        $productTabLabels['temperatureRating'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Temperature Rating']);
                    }

                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['temperatureRating'],
                        'product_id' => $products[$productName],
                        'content' => $temperatureRating
                    ];
                }

                // Add conductorRelated Tabs
                if ($conductorRelated) {
                    $productTabLabels['conductorRelated'] = $productTabLabels['conductorRelated']
                        ?? DB::table('product_tab_labels')->where('title', 'Conductor Related')->value('id');
                    if (!$productTabLabels['conductorRelated']) {
                        $productTabLabels['conductorRelated'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Conductor Related']);
                    }

                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['conductorRelated'],
                        'product_id' => $products[$productName],
                        'content' => $conductorRelated
                    ];
                }

                // **Insert in batches of 500**
                if (count($productTabValues) >= 500) {
                    DB::table('product_tab_contents')->insert($productTabValues);
                    $productTabValues = []; // Reset array
                }

            }

            // **Insert remaining product images**
            if (!empty($productImagesBulk)) {
                DB::table('product_images')->insert($productImagesBulk);
            }

            // **Insert remaining Product Filter Values**
            if (!empty($filterValuesBulk)) {
                DB::table('filter_value_product')->insert($filterValuesBulk);
            }

            // **Insert remaining product_tab_contents**
            if (!empty($productTabValues)) {
                DB::table('product_tab_contents')->insert($productTabValues);
            }

            // **Delete the file after processing**
            $filePath = storage_path("app/imports/$filename");
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $duplicateMessage =  $duplicateProducts ? count($duplicateProducts) . ' Duplicate Products - ' . implode(",",$duplicateProducts) : '';

            $response = array(
                'success' => true,
                'message' => 'Records added ' . $duplicateMessage,
                'class' => 'alert alert-success'
            );
            // Session::flash('success','Data imported successfully!');
            session()->flash('success', 'Data imported successfully!' . $duplicateMessage);

            return response()->json($response);

        }
        
    }
}
