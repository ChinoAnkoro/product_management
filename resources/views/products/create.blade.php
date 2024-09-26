@extends('layouts.app')
@section('content')
<div class="row mb-4">
    <div class="col-lg-12 margin-tb">
        <div class="d-flex justify-content-between align-items-center">
            <h2 style="font-size:1rem;">商品新規登録画面</h2>
        </div>
    </div>
</div>

<div>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf    
        <div class="row mb-3">
            <div class="col-md-3 d-flex align-items-center">
                <label for="product_name" class="form-label">商品名<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-9">
                <input id="product_name" type="text" name="product_name" class="form-control" placeholder="名前" value="{{ old('product_name') }}">
                @error('product_name')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 d-flex align-items-center">
                <label for="company_id" class="form-label">メーカー名<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-9">
                <select id="company_id" name="company_id" class="form-select">
                    <option value="">メーカーを選択してください</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 d-flex align-items-center">
                <label for="price" class="form-label">価格<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-9">
                <input id="price" type="number" name="price" class="form-control" placeholder="価格" value="{{ old('price') }}" step="1">
                @error('price')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 d-flex align-items-center">
                <label for="stock" class="form-label">在庫数<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-9">
                <input id="stock" type="number" name="stock" class="form-control" placeholder="在庫数" value="{{ old('stock') }}" min="0">
                @error('stock')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 d-flex align-items-center">
                <label for="detail" class="form-label">コメント</label>
            </div>
            <div class="col-md-9">
                <textarea id="detail" class="form-control" style="height:100px" name="detail" placeholder="コメント">{{ old('detail') }}</textarea>
                @error('detail')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 d-flex align-items-center">
                <label for="image" class="form-label">商品画像</label>
            </div>
            <div class="col-md-9">
                <input id="image" type="file" name="image" class="form-control">
                @error('image')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">登録</button>
                <a class="btn btn-primary" href="{{ url('/products') }}">戻る</a>
            </div>
        </div>
    </form>
</div>
@endsection
