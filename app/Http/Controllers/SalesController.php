<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        // 商品を取得
        $product = Product::find($request->product_id);
    
        // 在庫があるか確認
        if ($product->stock < $request->quantity) {
            return response()->json(['message' => '在庫が不足しています。'], 400);
        }
    
        // 注文を作成
        $sale = Sale::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
        ]);
    
        // 在庫を減少
        $product->stock -= $request->quantity; // 在庫数を減らす
        $product->save(); // 更新をデータベースに保存
    
        return response()->json(['message' => '購入が完了しました。', 'sales' => $sale]);
    }
}
