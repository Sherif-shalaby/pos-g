<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Grade;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\Size;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Variation;
use App\Utils\ProductUtil;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ProductImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $productUtil;
    protected $request;

    /**
     * Constructor
     *
     * @param ProductUtil $productUtil
     * @return void
     */
    public function __construct(ProductUtil $productUtil, $request)
    {
        $this->productUtil = $productUtil;
        $this->request = $request;
    }


    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if($row['product_name'] != null ){
                $unit = null;
                $color = null;
                $size = null;
                $grade = null;
                $class = null;
                $category = null;
                $sub_category = null;
                $brand = null;
                $tax = null;
                if (!empty($row['units'])) {
                    $unit = Unit::where('name', $row['units'])->first();
                    if(!$unit){
                        $unit =   Unit::create([
                            'name'=>  $row['units']
                        ]);
                    }
                }
                if (!empty($row['colors'])) {
                    $color = Color::where('name', $row['colors'])->first();
                    if(!$color){
                        $color =   Color::create([
                            'name'=>  $row['colors']
                        ]);
                    }
                }
                if (!empty($row['sizes'])) {
                    $size = Size::where('name', $row['sizes'])->first();
                    if(!$size){
                        $size =   Size::create([
                            'name'=>  $row['sizes']
                        ]);
                    }
                }
                if (!empty($row['grades'])) {
                    $grade = Grade::where('name', $row['grades'])->first();
                    if(!$grade){
                        $grade =   Grade::create([
                            'name'=>  $row['grades']
                        ]);
                    }
                }

                if (!empty($row['class'])) {

                    $class = ProductClass::where('name', $row['class'])->first();
                    if(!$class){
                        $class =   ProductClass::create([
                            'name'=>  $row['class']
                        ]);
                    }
                }
                if (!empty($row['category'])) {
                    $category = Category::where('name', $row['category'])->whereNull('parent_id')->first();
                    if(!$category){
                        $category =   Category::create([
                            'name'=>  $row['category'],
                            'product_class_id'=>!empty($row['class'])?$class->id:null,
                        ]);
                    }
                }
                if (!empty($row['sub_category']) && !empty($row['category'])) {
                    $sub_category = Category::where('name', $row['sub_category'])->whereNotNull('parent_id')->first();
                    if(!$sub_category){
                        $sub_category =   Category::create([
                            'name'=>  $row['sub_category'],
                            'parent_id'=>  $category->id,

                        ]);
                    }
                }
                if (!empty($row['brand'])) {
                    $brand = Brand::where('name', $row['brand'])->first();
                    if(!$brand){
                        $brand =   Brand::create([
                            'name'=>  $row['brand'],
                        ]);
                    }
                }
                if (!empty($row['tax'])) {
                    $tax = Tax::where('name', $row['tax'])->first();
                    if(!$tax){
                        $tax =   Brand::create([
                            'name'=>  $row['tax'],
                        ]);
                    }
                }
                $product_data = [
                    'name' => $row['product_name'],
                    'product_class_id' => !empty($class) ? $class->id : null,
                    'category_id' => !empty($category) ? $category->id : null,
                    'sub_category_id' => !empty($sub_category) ? $sub_category->id : null,
                    'brand_id' => !empty($brand) ? $brand->id : null,
                    'sku' => $row['sku'] ?? $this->productUtil->generateSku($row['product_name']),
                    'multiple_units' => !empty($unit) ? [(string)$unit->id] : [],
                    'multiple_colors' => !empty($color) ? [(string)$color->id] : [],
                    'multiple_sizes' => !empty($size) ? [(string)$size->id] : [],
                    'multiple_grades' => !empty($grade) ? [(string)$grade->id] : [],
                    'is_service' => !empty($row['is_service']) ? 1 : 0,
                    'product_details' => $row['product_details'],
                    'batch_number' => $row['batch_number'],
                    'barcode_type' => 'C128',
                    'manufacturing_date' => !empty($row['manufacturing_date']) ? $row['manufacturing_date'] : null,
                    'expiry_date' => !empty($row['expiry_date']) ? $row['expiry_date'] : null,
                    'expiry_warning' => $row['expiry_warning'],
                    'convert_status_expire' => $row['convert_status_expire'],
                    'alert_quantity' => $row['alert_quantity'],
                    'purchase_price' => 0,
                    'sell_price' => 0,
                    'tax_id' => !empty($tax) ? $tax->id : null,
                    'tax_method' => $row['tax_method'],
                    'discount_type' => $row['discount_type'],
                    'discount_customers' => [],
                    'discount' => $row['discount'],
                    'discount_start_date' => !empty($row['discount_start_date']) ? $row['discount_start_date'] : null,
                    'discount_end_date' => !empty($row['discount_end_date']) ? $row['discount_end_date'] : null,
                    'show_to_customer' => 1,
                    'show_to_customer_types' => [],
                    'different_prices_for_stores' => 0,
                    'this_product_have_variant' => 0,
                    'type' => 'single',
                    'active' => 1,
                    'created_by' => Auth::user()->id
                ];
                $product = Product::create($product_data);

                $variation_data['name'] = 'Default';
                $variation_data['product_id'] = $product->id;
                $variation_data['sub_sku'] = $row['sku'];
                $variation_data['color_id'] = $color?$color->id : null ;
                $variation_data['size_id'] = $size?$size->id : null ;
                $variation_data['grade_id'] =$grade? $grade->id : null ;
                $variation_data['unit_id'] = $unit? $unit->id : null ;
                $variation_data['is_dummy'] = 1;
                $variation=Variation::create($variation_data);
                $this->productUtil->createOrUpdateProductStore($product, $variation, $this->request, []);
                // $this->productUtil->createOrUpdateVariations($product, $this->request);
            }

        }
    }

    public function rules(): array
    {
        return [
            'product_name' => 'required',
            'class' => 'required',
            'sku' => 'sometimes|unique:products,sku',
        ];
    }
}
