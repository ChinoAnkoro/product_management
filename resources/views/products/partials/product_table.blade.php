<table class="table table-bordered">
    <thead>
        <tr>
            <th>
                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'id', 'order' => request('sort') === 'id' && request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                    ID
                    @if (request('sort') === 'id')
                        <i class="fas fa-sort-{{ request('order') === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
            </th>
            <th>商品画像</th>
            <th>
                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'product_name', 'order' => request('sort') === 'product_name' && request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                    商品名
                    @if (request('sort') === 'product_name')
                        <i class="fas fa-sort-{{ request('order') === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
            </th>
            <th>
                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price', 'order' => request('sort') === 'price' && request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                    価格
                    @if (request('sort') === 'price')
                        <i class="fas fa-sort-{{ request('order') === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
            </th>
            <th>
                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'stock', 'order' => request('sort') === 'stock' && request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                    在庫数
                    @if (request('sort') === 'stock')
                        <i class="fas fa-sort-{{ request('order') === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
            </th>
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
                <td>{{ $product->id }}</td>
                <td>
                    @if ($product->img_path)
                        <img src="{{ Storage::url($product->img_path) }}" alt="{{ $product->product_name }}" class="img-fluid" style="max-width: 50px; max-height: 50px;">
                    @else
                        <span class="text-muted">画像なし</span>
                    @endif
                </td>
                <td>{{ $product->product_name }}</td>
                <td>{{ number_format($product->price) }} ¥</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->company->company_name }}</td>
                <td class="text-center">
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">詳細</a>
                    <button class="btn btn-danger btn-sm delete-product" data-id="{{ $product->id }}" aria-label="削除">削除</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>