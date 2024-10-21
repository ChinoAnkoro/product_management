@extends('layouts.app')
@section('content')
<div class="container">
    <!-- 商品一覧タイトル -->
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 style="font-size:1rem;">商品一覧画面</h2>
            </div>
        </div>
    </div>

    <!-- 検索フォーム -->
    <div class="row mb-3">
        <div class="col-lg-12">
            <form id="search-form" method="GET">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        <label for="search-input" class="form-label">商品名で検索</label>
                        <input type="text" name="search" id="search-input" class="form-control" placeholder="商品名で検索" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="company-select" class="form-label">メーカー</label>
                        <select name="company_id" id="company-select" class="form-select">
                            <option value="">メーカー</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill">検索</button>
                    </div>
                </div>
    
                <div class="row mb-2">
                    <div class="col-md-2 mb-2">
                        <label for="min_price" class="form-label">最低価格</label>
                        <input type="number" name="min_price" id="min_price" class="form-control" placeholder="最低価格" value="{{ request('min_price') }}">
                    </div>
                    <div class="col-md-1 mb-2 text-center align-self-center">～</div>
                    <div class="col-md-2 mb-2">
                        <label for="max_price" class="form-label">最高価格</label>
                        <input type="number" name="max_price" id="max_price" class="form-control" placeholder="最高価格" value="{{ request('max_price') }}">
                    </div>
                </div>
    
                <div class="row mb-2">
                    <div class="col-md-2 mb-2">
                        <label for="min_stock" class="form-label">最低在庫数</label>
                        <input type="number" name="min_stock" id="min_stock" class="form-control" placeholder="最低在庫数" value="{{ request('min_stock') }}">
                    </div>
                    <div class="col-md-1 mb-2 text-center align-self-center">～</div>
                    <div class="col-md-2 mb-2">
                        <label for="max_stock" class="form-label">最高在庫数</label>
                        <input type="number" name="max_stock" id="max_stock" class="form-control" placeholder="最高在庫数" value="{{ request('max_stock') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 商品リストテーブル -->
    <div id="product-list">
        @include('products.partials.product_table', ['products' => $products])
    </div>

    <!-- ページネーション -->
    <div id="pagination-links">
        {!! $products->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection