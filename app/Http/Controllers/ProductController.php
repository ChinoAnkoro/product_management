<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 商品リストのクエリを構築
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

        // 商品リストを取得
        $products = $productsQuery->with('company') // `company` リレーションを使う
            ->orderBy('id', 'DESC')
            ->paginate(5);

        // 会社のリストを取得
        $companies = Company::all();

        // 認証ユーザーの名前とページIDを設定
        $user_name = Auth::check() ? Auth::user()->name : null;
        $page_id = $request->input('page', 1); // ページIDがない場合はデフォルトで1
        $i = ($page_id - 1) * 5;

        return view('products.index', [
            'products' => $products,
            'user_name' => $user_name,
            'page_id' => $page_id,
            'i' => $i,
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|max:2048',
            'product_name' => 'required|max:20',
            'price' => 'required|integer',
            'company_id' => 'required|integer',
            'stock' => 'required|integer',
            'comment' => 'nullable|max:140',
        ]);
    
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
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
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'image|max:2048',
            'product_name' => 'required|max:20',
            'price' => 'required|integer',
            'company_id' => 'required|integer', // `maker_id` から `company_id` に変更
            'stock' => 'required|integer',
            'comment' => 'nullable|max:140',
        ]);

        // フィールドの更新
        if ($request->hasFile('image'))
        {
            $product->img_path = $request->file('image')->store('images', 'public'); // `image` から `img_path` に変更
        }
        $product->product_name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->company_id = $request->input('company_id'); // `maker_id` から `company_id` に変更
        $product->stock = $request->input('stock');
        $product->detail = $request->input('detail');
        $product->user_id = Auth::user()->id;
        $product->save();

        return redirect()->route('products.edit', $product->id)
                     ->with('success', '商品が更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
        ->with('success', '商品' . $product->product_name . 'を削除しました');
    }
}