@extends('layout')

@section('title', $product->id . ' ' . $product->name)

@section('content')
    <h1>Товар #{{ $product->id }}</h1>

    <p><strong>Название:</strong> {{ $product->name }}</p>
    <p><strong>Частотность:</strong> {{ $product->frequency }}</p>

    <a href="{{ route('products.index') }}">Вернуться в каталог</a>

    <p>[Тут должна быть перелинковка]</p>
@endsection

