@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="main-header-area">
    <h1>
        @if(request('keyword'))
            <span class="search-keyword-display">
                ”{{ request('keyword') }}”の商品一覧
            </span>
        @else
            商品一覧
        @endif
    </h1>
    <div class="header-actions">
        <a href="{{ route('products.create') }}" class="add-product-btn" style="text-decoration: none;">+ 商品を追加</a>
    </div>
</div>

<div class="page-container">
    <aside class="sidebar">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="filter-group">
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品検索" class="search-input">
                <button type="submit" class="search-btn">検索</button>
            </div>

            <div class="filter-group">
                <label>価格順で表示</label>
                <select name="sort" class="sort-select" onchange="this.form.submit()">
                    <option value="" {{ request('sort') == '' ? 'selected' : '' }}>価格で並び替え</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>低い順に表示</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>高い順に表示</option>
                </select>
            </div>

            <div class="selected-filters">
                @if(request('sort') == 'price_asc')
                    <span class="filter-badge">
                        価格が低い順
                        <a href="{{ route('products.index', Arr::except(request()->query(), ['sort'])) }}" class="remove-filter">×</a>
                    </span>
                @elseif(request('sort') == 'price_desc')
                    <span class="filter-badge">
                        価格が高い順
                        <a href="{{ route('products.index', Arr::except(request()->query(), ['sort'])) }}" class="remove-filter">×</a>
                    </span>
                @endif
            </div>
        </form>
    </aside>

    <main class="main-content">
        <div class="product-grid">
            @foreach ($products as $product)
            <a href="{{ route('products.detail', ['productId' => $product->id]) }}" class="product-card-link" style="text-decoration: none; color: inherit;">
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="product-info">
                        <span class="product-name">{{ $product->name }}</span>
                        <span class="product-price">¥{{ $product->price }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="pagination">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </main>
</div>
@endsection