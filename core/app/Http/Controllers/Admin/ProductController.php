<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\Winner;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;
    protected $search;

    protected function filterProducts($type)
    {

        $products = Product::query();
        $this->pageTitle    = ucfirst($type) . ' Products';
        $this->emptyMessage = 'No ' . $type . ' products found';

        if ($type != 'all') {
            $products = $products->$type();
        }

        if (request()->search) {
            $search  = request()->search;

            $products    = $products->where(function ($qq) use ($search) {
                $qq->where('name', 'like', '%' . $search . '%')->orWhere(function ($product) use ($search) {
                    $product->whereHas('merchant', function ($merchant) use ($search) {
                        $merchant->where('username', 'like', "%$search%");
                    })->orWhereHas('admin', function ($admin) use ($search) {
                        $admin->where('username', 'like', "%$search%");
                    });
                });
            });

            $this->pageTitle    = "Search Result for '$search'";
            $this->search = $search;
        }

        return $products->with('merchant', 'admin')->orderBy('admin_id', 'DESC')->latest()->paginate(getPaginate());
    }

    public function index()
    {
        $segments       = request()->segments();
        $products       = $this->filterProducts(end($segments));
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;
        $search         = $this->search;

        return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products', 'search'));
    }

    public function approve(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $product = Product::findOrFail($request->id);
        $product->status = 1;
        $product->save();

        $notify[] = ['success', 'Product Approved Successfully'];
        return back()->withNotify($notify);
    }

    public function create()
    {
        $pageTitle = 'Create Product';
        $categories = Category::where('status', 1)->get();

        return view('admin.product.create', compact('pageTitle', 'categories'));
    }

    public function edit($id)
    {
        $pageTitle = 'Update Product';
        $categories = Category::where('status', 1)->get();
        $product = Product::findOrFail($id);

        $images      = [];

        if ($product->images) {
            foreach ($product->images as $key => $image) {
                $img['id']  = $key;
                $img['src'] = getImage(imagePath()['product']['path'] . '/' . $image);
                $images[]   = $img;
            }
        }

        return view('admin.product.edit', compact('pageTitle', 'categories', 'product', 'images'));
    }

    public function store(Request $request)
    {
        $this->validation($request, 'required');
        $product            = new Product();
        $product->admin_id  = auth()->guard('admin')->id();
        $product->status    = 1;

        $this->saveProduct($request, $product);
        $notify[] = ['success', 'Product added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $this->validation($request, 'nullable');
        $product = Product::findOrFail($id);
        $this->saveProduct($request, $product);
        $notify[] = ['success', 'Product updated successfully'];
        return back()->withNotify($notify);
    }

    public function saveProduct($request, $product)
    {
        $imageArray = [];
        $imageArray = $this->removeImages($request, $product, imagePath()['product']['path']);
        if ($request->hasFile('images')) {
            foreach ($request->images as $key => $image) {
                try {
                    array_push($imageArray, uploadImage($image, imagePath()['product']['path'], imagePath()['product']['size'], $product->image, imagePath()['product']['thumb']));
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Image could not be uploaded.'];
                    return back()->withNotify($notify);
                }
            }
        }
        $product->images = (array)$imageArray;
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->started_at = $request->started_at ?? now();
        $product->expired_at = $request->expired_at;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->specification = $request->specification ?? null;

        $product->save();
    }

    protected function removeImages($request, $product, $path)
    {
        $imageArray = $product->images ?? [];
        $previousImages = $product->images ? array_keys($product->images) : [];
        $imageToRemove  = array_values(array_diff($previousImages, $request->old ?? []));
        foreach ($imageToRemove as $item) {
            @unlink($path . '/' . $product->images[$item]);
            @unlink($path . '/thumb_' . $product->images[$item]);
            unset($imageArray[$item]);
        }
        return $imageArray;
    }


    protected function validation($request, $imgValidation)
    {
        $request->validate([
            'name'                  => 'required',
            'category'              => 'required|exists:categories,id',
            'price'                 => 'required|numeric|gte:0',
            'expired_at'            => 'required',
            'short_description'     => 'required',
            'long_description'      => 'required',
            'specification'         => 'nullable|array',
            'started_at'            => 'required_if:schedule,1|date|after:yesterday|before:expired_at',
            'images.*'              => $imgValidation . '|array|min:1|max:10',
            'images.*'              => ['image', new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ]);
    }


    public function productBids($id)
    {
        $product = Product::with('winner')->findOrFail($id);
        $pageTitle = $product->name . ' Bids';
        $emptyMessage = $product->name . ' has no bid yet';
        $bids = Bid::where('product_id', $id)->with('user', 'product', 'winner')->withCount('winner')->orderBy('winner_count', 'DESC')->latest()->paginate(getPaginate());
        return view('admin.product.product_bids', compact('pageTitle', 'emptyMessage', 'bids'));
    }

    public function productWinner()
    {
        $pageTitle = 'All Winners';
        $emptyMessage = 'No winner found';
        $winners = Winner::with('product', 'user')->latest()->paginate(getPaginate());

        return view('admin.product.winners', compact('pageTitle', 'emptyMessage', 'winners'));
    }

    public function deliveredProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $winner = Winner::with('product')->whereHas('product')->findOrFail($request->id);
        $winner->product_delivered = 1;
        $winner->save();

        $notify[] = ['success', 'Product mark as delivered'];
        return back()->withNotify($notify);
    }
}
