<?php

namespace App\Http\Controllers;
use App\Product;
use App\Category;
use App\Components\Recusive;
use App\product_jpg;
use App\Traits\StorageimageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    use StorageimageTrait;
    private $category;
    private $product;
    public function __construct(Category $category , Product $product)
    {
        $this->category = $category;
        $this->product = $product;
    }


    public function index(){
        return view('admin.product.index');
    }

    public function create() {
        $htmlOftion = $this->getCategory($parentId = '');

        return view('admin.product.add', compact('htmlOftion'));

    }

    public function getCategory($parentId){
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $htmlOftion =  $recusive->categoryRecus($parentId);
        return $htmlOftion;
    }

    public function store(Request $request){
        dd($request->image_path );
        $dataProductCreate = [
            'name' => $request->name,
            'price' => $request->price,
            'content' => $request->contents,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,

        ];
        $dataUpLoadFuture = $this->storageTraitUpload($request, 'feature_image_path' , 'product');
        if(!empty($dataUpLoadFuture)){
            $dataProductCreate['feature_image_name'] = $dataUpLoadFuture['file_name'];
            $dataProductCreate['feature_image_path'] = $dataUpLoadFuture['file_path'];
        }
           $products = $this->product->create($dataProductCreate);


        //insert data to productimage
//        if($request->hasFile(image_path)){
//            foreach ($request->image_path as $fileItem){
//                $dataProductDetail = $this->storageTraitUploadMutiple($fileItem,'product');
//            }
//        }
//       product_jpg::create([
//           'product_id' => $product->id,
//           'image_path' => $dataProductDetail['file_name'],
//           'image_name' => $dataProductDetail['file_path'],
//       ]);


//
    }

}
