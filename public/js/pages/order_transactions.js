function renderGrid(data){
    if(!$('#app').hasClass('no-order')){
        $('#app').addClass('no-order');
    }
    // specify the columns
    const columnDefs = [
        { field: "id", headerName: "ID", sortable: true, filter: true },
        { field: "order_id", headerName: "ORDER NO.", sortable: true, filter: true },
        { field: "status", headerName: "STATUS", sortable: true, filter: true },
        { field: "subtotal", headerName: "SUBTOTAL", sortable: true, filter: true },
        { field: "tax", headerName: "TAX", sortable: true, filter: true },
        { field: "coupon", headerName: "COUPON", sortable: true, filter: true },
        { field: "total", headerName: "TOTAL", sortable: true, filter: true },
    ];

    // specify the data
    const rowData = [];
    data.forEach(element => {
        rowData.push({
            id: element.id, 
            order_id: element.order_id,
            status: element.status,
            subtotal: element.subtotal, 
            tax: element.tax, 
            coupon: element.coupon, 
            total: element.total
        });
    });

    // let the grid know which columns and what data to use
    const gridOptions = {
        columnDefs: columnDefs,
        rowData: rowData
    };

    // lookup the container we want the Grid to use
    const eGridDiv = document.querySelector('#myGrid');

    // create the grid passing in the div to use together with the columns & data we want to use
    new agGrid.Grid(eGridDiv, gridOptions);
}