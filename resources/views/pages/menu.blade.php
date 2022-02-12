@extends('layouts.app')

@section('content')

<main class="py-4" id="menus">
    <div class="header">
        <h4>Menu</h4>
        <p id="datetime"></p>
    </div>

    <!-- categories -->
    <div class="menu-categories mt-2">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link nav-category category-all active" 
                    href="#" 
                    id="0">All</a>
            </li>
            @foreach ($categories as $item)
            <li class="nav-item">
                <a class="nav-link nav-category" 
                    href="#" 
                    id="{{ $item->id }}">{{ $item->category_name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <!-- ends here -->

    <!-- Search here -->
    <!-- <div class="group-box">
        <span class="icon">
            <i data-feather="search"></i>
        </span>

        <input type="text" 
            name="search" 
            id="search" 
            autocomplete="off" 
            class="form-control search-control"
            placeholder="Search here...">
    </div> -->
    <!-- ends here -->

    <!-- menu -->
    <div class="menu-section">
        <div class="menu {{ $has_order ? '' : 'has-order' }}" id="menu-list">
            @foreach ($menu as $item)
            <button class="card btn-card" 
                data-category="{{ $item->menu_category_id }}"
                data-menu-id="{{ $item->id }}">
                <img class="img-fluid mb-2" 
                    src="{{ $item->menu_img }}" 
                    alt="{{ $item->menu_name }}">

                <div class="card-body">
                    <p class="card-text">
                        <span class="name">{{ $item->menu_name }}</span>
                        <span class="price">{{ __("₱ " .number_format($item->price, 2)) }}</span></p>
                </div>
            </button>
            @endforeach
        </div>

        <div id="loader" class="d-none">
            <div class="spinner-border text-primary" role="status">
                <!-- <span class="sr-only">Loading...</span> -->
            </div>
            <span class="ms-2">Loading...</span>
        </div>

        <div id="no-result" class="d-none">
            <span><i data-feather="search"></i></span>
            <span class="ms-2">No Result.</span>
        </div>
    </div>
    <!-- ends here -->
</main>

@include('includes.orders')
@include('includes.modal')

@endsection

@section('plugins')

<!-- plugins -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- ends here -->

@endsection
@section('scripts')
<!-- custom scripts -->
<script src="{{ asset('js/custom.js') }}"></script>
@endsection