<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\ProductStore;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::whereNull('parent_id')->withCount('products')->get();
//        dd($categories);
        return view('category.index')->with(compact(
            'categories'
        ));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubCategories()
    {
        $categories = Category::whereNotNull('parent_id')->get();

        return view('category.sub_categories')->with(compact(
            'categories'
        ));
    }

    public function getAllSubCategories()
    {
        $categories = Category::whereNotNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $categories_dp = $this->commonUtil->createDropdownHtml($categories, 'Please Select');
        return $categories_dp;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quick_add = request()->quick_add ?? null;
        $type = request()->type ?? null;

        $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $product_classes = ProductClass::orderBy('name', 'asc')->pluck('name', 'id');

        return view('category.create')->with(compact(
            'type',
            'quick_add',
            'categories',
            'product_classes'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(
            $request,
            ['name' => ['required', 'max:255']]
        );
        if (!empty($request->parent_id)) {
            $category_exist = Category::where('parent_id', $request->parent_id)->where('name', $request->name)->first();
        } else {
            $category_exist = Category::where('product_class_id', $request->product_class_id)->where('name', $request->name)->first();
        }

        if (!empty($category_exist)) {
            if ($request->ajax()) {
                return response()->json(array(
                    'success' => false,
                    'message' => 'There are incorect values in the form!',
                    'msg' => 'Category name already taken'
                ));
            }
        }
        try {
            $data = $request->except('_token', 'quick_add');
            $data['translations'] = !empty($data['translations']) ? $data['translations'] : [];

            DB::beginTransaction();
            $category = Category::create($data);

            if ($request->has("cropImages") && count($request->cropImages) > 0) {
                foreach ($request->cropImages as $imageData) {
                    $extention = explode(";",explode("/",$imageData)[1])[0];
                    $image = rand(1,1500)."_image.".$extention;
                    $filePath = public_path('uploads/' . $image);
                    $fp = file_put_contents($filePath,base64_decode(explode(",",$imageData)[1]));
                    $category->addMedia($filePath)->toMediaCollection('category');

                }
            }

            $category_id = $category->id;
            $sub_category_id = null;
            if ($request->parent_id) {
                $category_id = $request->parent_id;
                $sub_category_id = $category->id;
            }


            DB::commit();
            $output = [
                'success' => true,
                'category_id' => $category_id,
                'sub_category_id' => $sub_category_id,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }


        if ($request->quick_add) {
            return $output;
        }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $type = request()->type ?? null;
        $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $product_classes = ProductClass::orderBy('name', 'asc')->pluck('name', 'id');

        return view('category.edit')->with(compact(
            'type',
            'category',
            'categories',
            'product_classes'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            ['name' => ['required', 'max:255']]
        );

        try {
            $data = $request->except('_token', '_method');
            $data['translations'] = !empty($data['translations']) ? $data['translations'] : [];
            DB::beginTransaction();
            $category = Category::find($id);

            $category->update($data);
            if ($request->has("cropImages") && count($request->cropImages) > 0) {
                foreach ($this->getCroppedImages($request->cropImages) as $imageData) {
                    $category->clearMediaCollection('category');
                    $extention = explode(";",explode("/",$imageData)[1])[0];
                    $image = rand(1,1500)."_image.".$extention;
                    $filePath = public_path('uploads/' . $image);
                    $fp = file_put_contents($filePath,base64_decode(explode(",",$imageData)[1]));
                    $category->addMedia($filePath)->toMediaCollection('category');
                }
            }

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (request()->source == 'pct') {
                Category::find($id)->delete();
                Category::where('parent_id', $id)->delete();
                $products = Product::where('category_id', $id)->orWhere('sub_category_id', $id)->get();
                foreach ($products as $product) {
                    ProductStore::where('product_id', $product->id)->delete();
                    $product->delete();
                }
            } else {
                $sub_category_exsist = Category::where('parent_id', $id)->exists();
                if ($sub_category_exsist) {
                    $output = [
                        'success' => false,
                        'msg' => __('lang.sub_category_exsist')
                    ];

                    return $output;
                } else {
                    Category::find($id)->delete();
                }
            }
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return $output;
    }

    public function getDropdown()
    {
        $categories=[];
        if (!empty(request()->product_class_id)&& request()->type=="category") {
            $categories = Category::where('product_class_id', request()->product_class_id)->orderBy('name', 'asc')->pluck('name', 'id');
        } 
        if(request()->type=="sub_category") {
            $categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        }
        $categories_dp = $this->commonUtil->createDropdownHtml($categories, 'Please Select');

        return $categories_dp;
    }

    public function getSubCategoryDropdown()
    {
        if (!empty(request()->category_id)) {
            $categories = Category::where('parent_id', request()->category_id)->orderBy('name', 'asc')->pluck('name', 'id');
        } else {
            $categories = Category::whereNotNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        }
        $categories_dp = $this->commonUtil->createDropdownHtml($categories, 'Please Select');

        return $categories_dp;
    }
    public function getBase64Image($Image)
    {

        $image_path = str_replace(env("APP_URL") . "/", "", $Image);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $image_path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $image_content = curl_exec($ch);
        curl_close($ch);
//    $image_content = file_get_contents($image_path);
        $base64_image = base64_encode($image_content);
        $b64image = "data:image/jpeg;base64," . $base64_image;
        return  $b64image;
    }
    public function getCroppedImages($cropImages){
        $dataNewImages = [];
        foreach ($cropImages as $img) {
            if (strlen($img) < 200){
                $dataNewImages[] = $this->getBase64Image($img);
            }else{
                $dataNewImages[] = $img;
            }
        }
        return $dataNewImages;
    }
}
