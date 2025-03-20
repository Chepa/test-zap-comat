@extends('layout')

@section('title', 'Каталог - список товаров')

@section('content')
    <h1>Список товаров</h1>

    <div class="products-list">
        @foreach ($products as $product)
            <div class="product-item" style="margin-bottom: 10px;">
                <a href="{{ route('products.show', $product->id) }}">
                <strong>{{ $product->id }}.</strong>
                {{ $product->name }}
                (частотность: <strong>{{ $product->frequency }}</strong>)
                </a>
            </div>
        @endforeach
    </div>

    <!-- Пагинация -->
    <div class="pagination">
        {{ $products->links() }}
    </div>
@endsection
