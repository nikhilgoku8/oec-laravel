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

    public function representatives_states_data()
    {
        return view('admin.imports.representative-states');
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    public function migrateDbData()
    {
        // $oldData = DB::connection('mysql_old')
        //     ->table('wp5y_users')
        //     ->select(
        //         'wp5y_users.user_email as email',
        //         'wp5y_users.user_registered as registered_at',
        //         'wp5y_users.user_status as status',
        //     )
        //     ->leftJoin('wp5y_usermeta','wp5y_usermeta.user_id','=','wp5y_users.id')
        //     ->where('wp5y_usermeta.meta_key', 'phone')
        //     ->get();

        $metaByUser = DB::connection('mysql_old')
            ->table('wp5y_usermeta')
            ->get()
            ->groupBy('user_id')
            ->map(fn($items) => $items->pluck('meta_value', 'meta_key'));

        $users = DB::connection('mysql_old')
            ->table('wp5y_users')
            ->get();

        $newUserData = [];

        foreach ($users as $user) {
            $user->meta = $metaByUser[$user->ID] ?? [];

            $newUserData[] = [
                'fname' => $user->meta['first_name'] ?: $user->display_name ?: '-',
                'lname' => $user->meta['last_name'] ?: '-',
                'email' => $user->user_email ?? '',
                'registered_at' => $user->user_registered ?? '',
                'billing_fname' => $user->meta['billing_first_name'] ?? '',
                'billing_lname' => $user->meta['billing_last_name'] ?? '',
                'billing_phone' => $user->meta['billing_phone'] ?? '',
                'billing_email' => $user->meta['billing_email'] ?? '',
                'billing_company' => $user->meta['billing_company'] ?? '',
                'billing_address' => $user->meta['billing_address_1'] ?? '',
                'billing_city' => $user->meta['billing_city'] ?? '',
                'billing_state' => $user->meta['billing_state'] ?? '',
                'billing_country' => $user->meta['billing_country'] ?? '',
                'billing_postcode' => $user->meta['billing_postcode'] ?? '',
                'same_address' => $user->meta['same_address'] ?? true,
                'shipping_fname' => $user->meta['shipping_first_name'] ?? '',
                'shipping_lname' => $user->meta['shipping_last_name'] ?? '',
                'shipping_phone' => $user->meta['shipping_phone'] ?? '',
                'shipping_email' => $user->meta['shipping_email'] ?? '',
                'shipping_company' => $user->meta['shipping_company'] ?? '',
                'shipping_address' => $user->meta['shipping_address'] ?? '',
                'shipping_city' => $user->meta['shipping_city'] ?? '',
                'shipping_state' => $user->meta['shipping_state'] ?? '',
                'shipping_country' => $user->meta['shipping_country'] ?? '',
                'shipping_postcode' => $user->meta['shipping_postcode'] ?? '',
                'paying_customer' => $user->meta['paying_customer'] ?? false,
                'status' => $user->meta['pw_user_status'] ?? 'pending',
            ];
        }

        $newUserDataUnique = collect($newUserData)
            ->unique('email')
            ->values()
            ->all();

        DB::table('users')->insert($newUserDataUnique);

        echo "Done";
    }

    public function importData(Request $request)
    {

        $rules = array(
            'data_file' => 'required|mimes:xlsx,csv'
        );

        $validator = Validator::make($request->all(), $rules);
        
        if(!$validator->passes()){
            // dd($validator->errors());
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
            $productImagesBulk = [];
            $productTabLabels = [];
            $productTabValues = [];
            $tabValuesDeletion = [];
            $filterTypes = [];
            $filterValues = [];
            $filterValuesBulk = [];

            $now = now();

            foreach ($data as $index => $row) {
                if ($index === 0) continue; // Skip header row

                [$productName, $description, $categoryName, $subCategoryName, $features, $images, $generalSpecification, $productSpecification, $certificationsAndCompliance, $dimensions, $temperatureRating, $conductorRelated, $electricalRating, $salesDrawing, $catalogue, $attributeName1, $attributeValue1, $attributeName2, $attributeValue2, $attributeName3, $attributeValue3, $attributeName4, $attributeValue4, $attributeName5, $attributeValue5, $attributeName6, $attributeValue6, $attributeName7, $attributeValue7, $attributeName8, $attributeValue8] = array_map('trim', $row);

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
                $productSlug = $this->string_filter($productName);
                $productData = [
                        'sub_category_id' => $subCategories[$subCategoryName],
                        'title' => $productName,
                        'slug' => $productSlug,
                        'description' => $description,
                        'features' => $features,
                        'sales_drawing' => $salesDrawing ?? null,
                        'catalogue' => $catalogue ?? null
                    ];
                if (!$products[$productName]) {
                    $products[$productName] = DB::table('products')->insertGetId($productData);
                }else{
                    // // Duplicate products and skip that row to not create confusion
                    // $duplicateProducts[] = $productName;
                    // continue;
                    DB::table('products')->where('id', $products[$productName])->update($productData);
                }

                // Remove existing images if replacing
                DB::table('product_images')->where('product_id', $products[$productName])->delete();

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

                // Remove old filters for this product (once per product)
                DB::table('filter_value_product')->where('product_id', $products[$productName])->delete();

                // $filterTypes = [];
                $maxIndex = 8; // Adjust to expected max fields

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
                        // DB::table('filter_value_product')->insert($filterValuesBulk);
                        $filterValuesBulk = collect($filterValuesBulk)
                            ->unique(fn ($item) => $item['product_id'].'-'.$item['filter_value_id'])
                            ->values()
                            ->toArray();

                        DB::table('filter_value_product')->upsert(
                            $filterValuesBulk,
                            ['product_id', 'filter_value_id'], // unique key
                            [] // no fields to update
                        );
                        $filterValuesBulk = []; // Reset array
                    }
                }

                // Add generalSpecification Tabs
                $productTabLabels['generalSpecification'] = $productTabLabels['generalSpecification']
                    ?? DB::table('product_tab_labels')->where('title', 'General Specification')->value('id');
                if (!$productTabLabels['generalSpecification']) {
                    $productTabLabels['generalSpecification'] = DB::table('product_tab_labels')->insertGetId(['title' => 'General Specification']);
                }

                if ($generalSpecification) {
                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['generalSpecification'],
                        'product_id' => $products[$productName],
                        'content' => $generalSpecification
                    ];
                }else{
                    $tabValuesDeletion[] = [$productTabLabels['generalSpecification'], $products[$productName]];
                }

                // Add productSpecification Tabs
                $productTabLabels['productSpecification'] = $productTabLabels['productSpecification']
                    ?? DB::table('product_tab_labels')->where('title', 'Product Specification')->value('id');
                if (!$productTabLabels['productSpecification']) {
                    $productTabLabels['productSpecification'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Product Specification']);
                }

                if ($productSpecification) {
                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['productSpecification'],
                        'product_id' => $products[$productName],
                        'content' => $productSpecification
                    ];
                }else{
                    $tabValuesDeletion[] = [$productTabLabels['productSpecification'], $products[$productName]];
                }

                // Add certificationsAndCompliance Tabs
                $productTabLabels['certificationsAndCompliance'] = $productTabLabels['certificationsAndCompliance']
                    ?? DB::table('product_tab_labels')->where('title', 'Certifications And Compliance')->value('id');
                if (!$productTabLabels['certificationsAndCompliance']) {
                    $productTabLabels['certificationsAndCompliance'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Certifications And Compliance']);
                }

                if ($certificationsAndCompliance) {
                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['certificationsAndCompliance'],
                        'product_id' => $products[$productName],
                        'content' => $certificationsAndCompliance
                    ];
                }else{
                    $tabValuesDeletion[] = [$productTabLabels['certificationsAndCompliance'], $products[$productName]];
                }

                // Add dimensions Tabs
                $productTabLabels['dimensions'] = $productTabLabels['dimensions']
                    ?? DB::table('product_tab_labels')->where('title', 'Dimensions')->value('id');
                if (!$productTabLabels['dimensions']) {
                    $productTabLabels['dimensions'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Dimensions']);
                }
                if ($dimensions) {
                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['dimensions'],
                        'product_id' => $products[$productName],
                        'content' => $dimensions
                    ];
                }else{
                    $tabValuesDeletion[] = [$productTabLabels['dimensions'], $products[$productName]];
                }

                // Add electricalRating Tabs
                $productTabLabels['electricalRating'] = $productTabLabels['electricalRating']
                    ?? DB::table('product_tab_labels')->where('title', 'Electrical Rating')->value('id');
                if (!$productTabLabels['electricalRating']) {
                    $productTabLabels['electricalRating'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Electrical Rating']);
                }
                if ($electricalRating) {
                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['electricalRating'],
                        'product_id' => $products[$productName],
                        'content' => $electricalRating
                    ];
                }else{
                    $tabValuesDeletion[] = [$productTabLabels['electricalRating'], $products[$productName]];
                }

                // Add temperatureRating Tabs
                $productTabLabels['temperatureRating'] = $productTabLabels['temperatureRating']
                    ?? DB::table('product_tab_labels')->where('title', 'Temperature Rating')->value('id');
                if (!$productTabLabels['temperatureRating']) {
                    $productTabLabels['temperatureRating'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Temperature Rating']);
                }
                if ($temperatureRating) {
                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['temperatureRating'],
                        'product_id' => $products[$productName],
                        'content' => $temperatureRating
                    ];
                }else{
                    $tabValuesDeletion[] = [$productTabLabels['temperatureRating'], $products[$productName]];
                }

                // Add conductorRelated Tabs
                $productTabLabels['conductorRelated'] = $productTabLabels['conductorRelated']
                    ?? DB::table('product_tab_labels')->where('title', 'Conductor Related')->value('id');
                if (!$productTabLabels['conductorRelated']) {
                    $productTabLabels['conductorRelated'] = DB::table('product_tab_labels')->insertGetId(['title' => 'Conductor Related']);
                }
                if ($conductorRelated) {
                    $productTabValues[] = [
                        'product_tab_label_id' => $productTabLabels['conductorRelated'],
                        'product_id' => $products[$productName],
                        'content' => $conductorRelated
                    ];
                }else{
                    $tabValuesDeletion[] = [$productTabLabels['conductorRelated'], $products[$productName]];
                }

                // **Insert in batches of 500**
                if (count($productTabValues) >= 500) {
                    // DB::table('product_tab_contents')->insert($productTabValues);

                    $productTabValues = collect($productTabValues)
                        ->unique(fn ($item) => $item['product_tab_label_id'].'-'.$item['product_id'])
                        ->values()
                        ->toArray();
                    
                    DB::table('product_tab_contents')->upsert(
                        $productTabValues,
                        ['product_tab_label_id', 'product_id'],
                        ['content'],
                    );
                    $productTabValues = []; // Reset array
                }

                // dd($tabValuesDeletion);

                // **delete in batches of 500**
                if (count($tabValuesDeletion) >= 500) {
                    $pairs = collect($tabValuesDeletion)
                        // ->map(fn($p) => '(' . implode(',', $p) . ')')
                        ->map(fn($p) => '(' . intval($p[0]) . ',' . intval($p[1]) . ')')
                        ->implode(',');
                // dd($pairs);

                    $rows = DB::select("SELECT * FROM product_tab_contents WHERE (product_tab_label_id, product_id) IN ($pairs)");
                    // dd(count($rows)); // should be 0 now

                    $deleted = DB::statement("DELETE FROM product_tab_contents WHERE (product_tab_label_id, product_id) IN ($pairs)");

                    // dd([
                    //     'pairs' => $pairs,
                    //     'deleted_rows' => $deleted
                    // ]);

                    // DB::table('product_tab_contents')
                    //     ->whereRaw("(product_tab_label_id, product_id) IN ($tabValuesDeletion)")
                    //     ->delete();
                    $tabValuesDeletion = []; // Reset array
                }

            }

            // **Insert remaining product images**
            if (!empty($productImagesBulk)) {
                DB::table('product_images')->insert($productImagesBulk);
            }

            // **Insert remaining Product Filter Values**
            if (!empty($filterValuesBulk)) {
                // DB::table('filter_value_product')->insert($filterValuesBulk);

                $filterValuesBulk = collect($filterValuesBulk)
                    ->unique(fn ($item) => $item['product_id'].'-'.$item['filter_value_id'])
                    ->values()
                    ->toArray();

                DB::table('filter_value_product')->upsert(
                    $filterValuesBulk,
                    ['product_id', 'filter_value_id'], // unique key
                    [] // no fields to update
                );
            }

            // **Insert remaining product_tab_contents**
            if (!empty($productTabValues)) {

                $productTabValues = collect($productTabValues)
                    ->unique(fn ($item) => $item['product_tab_label_id'].'-'.$item['product_id'])
                    ->values()
                    ->toArray();

                // DB::table('product_tab_contents')->insert($productTabValues);
                DB::table('product_tab_contents')->upsert(
                    $productTabValues,
                    ['product_tab_label_id', 'product_id'],
                    ['content'],
                );
            }

            // **Delete remaining product_tab_contents**
            if (!empty($tabValuesDeletion)) {
                $pairs = collect($tabValuesDeletion)
                    // ->map(fn($p) => '(' . implode(',', $p) . ')')
                    ->map(fn($p) => '(' . $p[0] . ',' . $p[1] . ')')
                    ->implode(',');

                DB::statement("DELETE FROM product_tab_contents WHERE (product_tab_label_id, product_id) IN ($pairs)");

                // DB::table('product_tab_contents')
                //     ->whereRaw("(product_tab_label_id, product_id) IN ($tabValuesDeletion)")
                //     ->delete();
            }

            // **Delete the file after processing**
            $filePath = storage_path("app/imports/$filename");
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $duplicateMessage =  $duplicateProducts ? count($duplicateProducts) . ' Duplicate Products - ' . implode(", ",$duplicateProducts) : '';

            $response = array(
                'success' => true,
                'message' => 'Records added ' . $duplicateMessage,
                'class' => 'alert alert-success'
            );
            // Session::flash('success','Data imported successfully!');
            session()->flash('success', 'Data imported successfully! ' . $duplicateMessage);

            return response()->json($response);

        }
        
    }

    public function importSalesRepresentativeData(Request $request)
    {

        $rules = array(
            'data_file' => 'required|mimes:xlsx,csv'
        );

        $validator = Validator::make($request->all(), $rules);
        
        if(!$validator->passes()){
            // dd($validator->errors());
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

            $reps = [];
            $states = [];
            $repsStatesBulk = [];

            $now = now();

            foreach ($data as $index => $row) {
                if ($index === 0) continue; // Skip header row

                [$repName, $stateAbbr, $address, $website, $email, $phone] = array_map('trim', $row);

                if (!$repName || !$stateAbbr) {
                    continue; // Skip invalid rows
                }

                // Cache Representative IDs
                $reps[$repName] = $reps[$repName] ?? DB::table('sales_representatives')->where('rep_name', $repName)->value('id');
                $repData = [
                        'rep_name' => $repName,
                        'address' => $address,
                        'website' => $website,
                        'email' => $email,
                        'phone' => $phone
                    ];

                if (!$reps[$repName]) {
                    $reps[$repName] = DB::table('sales_representatives')->insertGetId($repData);
                }else{
                    DB::table('sales_representatives')->where('id', $reps[$repName])->update($repData);
                }

                // Cache States IDs
                $states[$stateAbbr] = $states[$stateAbbr] ?? DB::table('us_states')->where('abbr', $stateAbbr)->value('id');
                if (!$states[$stateAbbr]) {
                    continue; // Skip invalid rows
                }

                // Insert into pivot table
                $repsStatesBulk[] = [
                    'sales_representative_id' => $reps[$repName],
                    'us_state_id' => $states[$stateAbbr],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // **Insert in batches of 500**
                if (count($repsStatesBulk) >= 500) {
                    // DB::table('sales_representative_us_state')->insert($repsStatesBulk);
                    $repsStatesBulk = collect($repsStatesBulk)
                        ->unique(fn ($item) => $item['sales_representative_id'].'-'.$item['us_state_id'])
                        ->values()
                        ->toArray();

                    DB::table('sales_representative_us_state')->upsert(
                        $repsStatesBulk,
                        ['sales_representative_id', 'us_state_id'], // unique key
                        ['updated_at'] // no fields to update
                    );
                    $repsStatesBulk = []; // Reset array
                }

            }

            // **Insert remaining Product Filter Values**
            if (!empty($repsStatesBulk)) {
                // DB::table('sales_representative_us_state')->insert($repsStatesBulk);

                $repsStatesBulk = collect($repsStatesBulk)
                    ->unique(fn ($item) => $item['sales_representative_id'].'-'.$item['us_state_id'])
                    ->values()
                    ->toArray();

                DB::table('sales_representative_us_state')->upsert(
                    $repsStatesBulk,
                    ['sales_representative_id', 'us_state_id'], // unique key
                    [] // no fields to update
                );
                $repsStatesBulk = []; // Reset array
            }

            // **Delete the file after processing**
            $filePath = storage_path("app/imports/$filename");
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $response = array(
                'success' => true,
                'message' => 'Records added ',
                'class' => 'alert alert-success'
            );
            // Session::flash('success','Data imported successfully!');
            session()->flash('success', 'Data imported successfully! ');

            return response()->json($response);

        }
        
    }
}
