<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest; // ProductRequest をインポート

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productsQuery = Product::query();

        // 商品名での検索
        if ($request->has('search') && $request->input('search') != '')
        {
            $productsQuery->where('product_name', 'like', '%' . $request->input('search') . '%');
        }

        // 会社での検索
        if ($request->has('company_id') && $request->input('company_id') != '')
        {
            $productsQuery->where('company_id', $request->input('company_id'));
        }

        // 価格での検索
        if ($request->has('min_price') && $request->input('min_price') != '')
        {
            $productsQuery->where('price', '>=', $request->input('min_price'));
        }
        if ($request->has('max_price') && $request->input('max_price') != '')
        {
            $productsQuery->where('price', '<=', $request->input('max_price'));
        }

        // 在庫数での検索
        if ($request->has('min_stock') && $request->input('min_stock') != '')
        {
            $productsQuery->where('stock', '>=', $request->input('min_stock'));
        }
        if ($request->has('max_stock') && $request->input('max_stock') != '')
        {
            $productsQuery->where('stock', '<=', $request->input('max_stock'));
        }

        // ソート処理
        if ($request->has('sort') && in_array($request->sort, ['id', 'product_name', 'price', 'stock']))
        {
            $order = $request->input('order', 'asc');
            $productsQuery->orderBy($request->sort, $order);
        }
        else
        {
            $productsQuery->orderBy('id', 'DESC'); // デフォルトのソート
        }

        // 商品リストを取得
        $products = $productsQuery->with('company')
            ->orderBy('id', 'DESC')
            ->paginate(5);

        $companies = Company::all();

        return view('products.index', [
            'products' => $products,
            'companies' => $companies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('products.create')->with('companies', $companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request) // ProductRequest を使用
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated(); // バリデーション済みデータを取得

            if ($request->hasFile('img_path')) {
                $imagePath = $request->file('img_path')->store('images', 'public');
                $validated['img_path'] = $imagePath; // `image` から `img_path` に変更
            }

            $validated['user_id'] = Auth::user()->id;
            Product::create($validated);

            DB::commit();
            return redirect()->route('products.index')
                ->with('success', '商品を登録しました');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('商品登録エラー: ' . $e->getMessage());

            return back()->withErrors('商品登録中にエラーが発生しました。');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'))
        ->with('page_id', request()->page_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $companies = Company::all(); // ここを修正
        return view('products.edit', compact('product', 'companies')); // ここも修正
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product) // ProductRequest を使用
    {
        $validated = $request->validated(); // バリデーション済みデータを取得

        // 更新するフィールドを設定
        $product->product_name = $validated['product_name'];
        $product->company_id = $validated['company_id'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->comment = $validated['comment'];

        // 画像の処理
        if ($request->hasFile('img_path'))
        {
            // 既存の画像がある場合は削除
            if ($product->img_path && Storage::exists('public/images/'.$product->img_path)) 
            {
                Storage::delete('public/images/'.$product->img_path);
            }

            // 新しい画像を保存
            $imageName = time().'.'.$request->img_path->extension();
            $request->img_path->storeAs('public/images', $imageName);
            $product->img_path = 'images/' . $imageName;  // 画像のパスを更新
        }

        $product->save();

        return redirect()->route('products.edit', $product->id)->with('success', '商品情報が更新されました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => '商品 ' . $product->product_name . ' を削除しました']);
    }
}