@extends('layout')

@section('title', $product->id . ' ' . $product->name)

@section('content')
    <h1>Товар #{{ $product->id }}</h1>

    <p><strong>Название:</strong> {{ $product->name }}</p>
    <p><strong>Частотность:</strong> {{ $product->frequency }}</p>

    <a href="{{ route('products.index') }}">Вернуться в каталог</a>

    <p>Колличество ссылаемых товаров: {{ $linkedCount }}</p>

    <p>Рекомендуемые товары:</p>
    <ul>
        @foreach($recommended as $recommendedProduct)
            <li>
                <p>
                    <a href="{{ route('products.show', ['product' => $recommendedProduct->product->id]) }}"><strong>Название:</strong> {{ $recommendedProduct->product->name }}
                    </a></p>
                <p><strong>Частотность:</strong> {{ $recommendedProduct->product->frequency }}</p>
            </li>
        @endforeach
    </ul>
@endsection

