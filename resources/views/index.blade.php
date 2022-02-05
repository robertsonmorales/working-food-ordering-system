@extends('layouts.app')

@section('content')
<main class="py-4" id="menus">
    <div class="header">
        <h4>Menu</h4>
        <p id="datetime"></p>
    </div>

    <div class="menu-categories">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">All</a>
            </li>
            @foreach ($categories as $item)
            <li class="nav-item">
                <a class="nav-link" href="#">{{ $item->category_name }}</a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="search-box">
        <span class="search-icon">
            <i data-feather="search"></i>
        </span>

        <input type="text" 
            name="search" 
            id="search" 
            autocomplete="search" 
            class="form-control search-control"
            placeholder="Search here...">
    </div>

    <div class="menu">
        @foreach ($menu as $item)
        <button class="card" data-category="{{ $item->menu_category_id }}">
            <img class="img-fluid mb-2" 
                src="{{ $item->menu_img }}" 
                alt="{{ $item->menu_name }}">

            <div class="card-body">
                <p class="card-text">
                    <span class="name">{{ $item->menu_name }}</span>
                    <span class="price">{{ __("₱" .number_format($item->price, 2)) }}</span></p>
                {{-- <p class="card-text"><small class="text-muted">{{ $item->menu_category->category_name }}</small></p> --}}
            </div>
        </button>
        @endforeach
    </div>
</main>
@endsection