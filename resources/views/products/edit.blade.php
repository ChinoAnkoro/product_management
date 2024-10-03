@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 style="font-size:1rem;">商品編集画面</h2>
        </div>
    </div>
</div>

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                商品名<span style="color:red;">*</span>
                <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="form-control" placeholder="名前">
                @error('product_name')
                    <span style="color:red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                メーカー名<span style="color:red;">*</span>
                <select name="company_id" class="form-select">
                    <option value="">メーカーを選択してください</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                    <span style="color:red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                価格<span style="color:red;">*</span>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control" placeholder="価格" step="1">
                @error('price')
                    <span style="color:red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                在庫数<span style="color:red;">*</span>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control" placeholder="在庫数" min="0">
                @error('stock')
                    <span style="color:red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                コメント
                <textarea class="form-control" style="height:100px" name="comment" placeholder="コメント">{{ old('comment', $product->comment) }}</textarea>
                @error('comment')
                    <span style="color:red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <strong>商品画像:</strong><br>
            @if ($product->img_path)
                <img src="{{ Storage::url($product->img_path) }}" alt="{{ $product->product_name }}" width="50" style="margin-bottom: 10px;">
            @else
                <p>画像がありません</p>
            @endif

            <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('image-input').click()">画像を変更する</button>
            <input type="file" name="img_path" id="image-input" class="form-control" style="display: none;">
            @error('img_path')
                <span style="color:red;">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-12 mb-2 mt-2">
            <button type="submit" class="btn btn-success">更新</button>
            <a class="btn btn-secondary" href="{{ route('products.show', $product->id) }}">戻る</a>
        </div>
    </div>      
</form>
@endsection