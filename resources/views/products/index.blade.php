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
            <form action="{{ route('products.index') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="text" name="search" class="form-control" placeholder="商品名で検索" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="company_id" class="form-select"> 
                            <option value="">メーカー</option>
                            @foreach ($companies as $company) 
                                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="submit" class="btn btn-primary rounded-pill w-100">検索</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 商品リストテーブル -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>
                    @auth
                    <a class="btn btn-success rounded-pill" href="{{ route('products.create') }}">新規登録</a>
                    @endauth
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td class="text-end">{{ $product->id }}</td>
                <td>
                    @if ($product->img_path) 
                        <img class="img-thumbnail" src="{{ Storage::url($product->img_path) }}" alt="{{ $product->product_name }}" width="50" height="50"/>
                    @else
                        画像なし
                    @endif
                </td>
                <td>
                    {{ $product->product_name }}
                </td>
                <td class="text-end">{{ number_format($product->price) }}￥</td>
                <td class="text-end">{{ $product->stock }}</td>
                <td>{{ $product->company->company_name }}</td>
                <td class="text-center">
                    @auth
                        <a class="btn btn-primary btn-sm rounded-pill" href="{{ route('products.show', $product->id) }}">詳細</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick='return confirm("削除しますか？");'>削除</button>
                        </form>
                    @endauth
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ページネーション -->
    {!! $products->links('pagination::bootstrap-5') !!}
</div>
@endsection