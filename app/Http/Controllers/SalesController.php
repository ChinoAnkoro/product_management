<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // トランザクションを開始
        DB::beginTransaction();

        try {
            // 商品を取得
            $product = Product::findOrFail($request->product_id);

            // 在庫確認
            if (!$product->hasSufficientStock($request->quantity)) {
                return response()->json(['message' => '在庫が不足しています。'], 400);
            }

            // 売上作成
            $sale = Sale::createSale($product->id, $request->quantity);

            // 在庫を減少
            $product->reduceStock($request->quantity);

            // トランザクションをコミット
            DB::commit();

            return response()->json(['message' => '購入が完了しました。', 'sale' => $sale]);

        } catch (\Exception $e) {
            // ロールバック
            DB::rollBack();

            return response()->json(['message' => '購入処理中にエラーが発生しました。'], 500);
        }
    }
}