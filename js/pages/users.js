'use strict';
$(document).ready(function() {
    var table = $('#editable_table').removeAttr('width').DataTable( {
    // var table = $('#editable_table');
    // table.DataTable({
        dom: "<'text-right'B><f>lr<'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
        buttons: [
            
        ],

        "columnDefs": [
            { "searchable": false, "targets": 1 }
        ],
        
        order: [[ 0, "desc" ]],
        "scrollX": true,
        "fixedColumns":   {
            "leftColumns": 1,
            "rightColumns": 1,
            "width": 200 
        }
    });
    var tableWrapper = $("#editable_table_wrapper");
    tableWrapper.find(".dataTables_length select").select2({
        showSearchInput: false //hide search box with special css class
    }); // initialize select2 dropdown
    $("#editable_table_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
    $(".dataTables_wrapper").removeClass("form-inline");
    $(".dataTables_paginate .pagination").addClass("float-right");
});


