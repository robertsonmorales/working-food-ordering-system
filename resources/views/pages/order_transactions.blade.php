@extends('layouts.app')

@section('content')
<main class="py-4" id="menus">
    <div class="header">
        <h4>Order Transactions</h4>
        <p id="datetime"></p>
    </div>

    <div class="order-list">
        <div id="myGrid" class="ag-theme-alpine"></div>
    </div>
</main>
@endsection

@section('plugins')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script>
<link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-grid.css">
<link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-theme-alpine.css">
@endsection

@section('scripts')
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/pages/order_transactions.js') }}"></script>

<script type="text/javascript">
    let data = @json($data);
    renderGrid(data);
</script>
@endsection