<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認可の設定（必要に応じて変更）
    }

    public function rules()
    {
        return [
            'product_name' => 'required|max:20',
            'company_id' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|max:140',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名は必須です。',
            'product_name.max' => '商品名は20文字以内で入力してください。',
            'company_id.required' => 'メーカーを選択してください。',
            'company_id.integer' => 'メーカーのIDが無効です。',
            'price.required' => '価格は必須です。',
            'price.numeric' => '価格は数値で入力してください。',
            'stock.required' => '在庫数は必須です。',
            'stock.integer' => '在庫数は整数で入力してください。',
            'stock.min' => '在庫数は0以上である必要があります。',
            'comment.max' => 'コメントは140文字以内で入力してください。',
            'img_path.image' => '画像ファイルをアップロードしてください。',
            'img_path.mimes' => 'jpeg、png、jpg、またはgif形式の画像をアップロードしてください。',
            'img_path.max' => '画像サイズは2MB以下である必要があります。',
        ];
    }
}
