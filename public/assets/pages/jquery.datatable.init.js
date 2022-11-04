/**
 * Theme: Metrica - Responsive Bootstrap 4 Admin Dashboard
 * Author: Mannatthemes
 * Datatables Js
 */


$(document).ready(function() {
    $('#datatable').DataTable();

    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['excel','colvis']
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

    /**DATATABLE ROLE START**/
    var table_poste = $('#datatable-role').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('.page-title').html(); },
                exportOptions: {
                    columns: ':visible:not(.action)'
                }
            }
        ]
    });
    table_poste.buttons().container()
        .appendTo('#datatable-role_wrapper .col-md-6:eq(0)');
    /**DATATABLE ROLE END**/

    /**DATATABLE PERMISSION START**/

    // var table_permission = $('#datatable-permission').DataTable({
    //     scrollX: true,
    //     scrollCollapse: true,
    //     orderCellsTop: true,
    //     fixedHeader: true,
    //     buttons: [
    //         {
    //             extend: 'excel',
    //             title: function () { return $('.page-title').html(); },
    //         }
    //     ],
    // });
    $('#datatable-permission tfoot th').each( function () {
        var title = $(this).text();
        if( !this.classList.contains('action')) {
        $(this).html( '<input type="text" class="form-control" placeholder="Recherche'+title+'" />' );
        }
    } );

    // DataTable
    var table_permission = $('#datatable-permission').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('.page-title').html(); },
            }
        ],
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },

    });

    table_permission.buttons().container()
        .appendTo('#datatable-permission_wrapper .col-md-6:eq(0)');
    /**DATATABLE PERMISSION END**/

    /**DATATABLE STRUCTURE START**/
    var table_structure = $('#datatable-structure').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('.page-title').html(); },
                exportOptions: {
                    columns: ':visible:not(.action)'
                }
            }
        ]
    });
    table_structure.buttons().container()
        .appendTo('#datatable-structure_wrapper .col-md-6:eq(0)');
    /**DATATABLE STRUCTURE END**/

    /**DATATABLE TYPE STRUCTURE START**/
    var table_type = $('#datatable-type').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('.page-title').html(); },
                exportOptions: {
                    columns: ':visible:not(.action)'
                }
            }
        ]
    });
    table_type.buttons().container()
        .appendTo('#datatable-type_wrapper .col-md-6:eq(0)');
    /**DATATABLE TYPE STRUCTURE END**/

    /**DATATABLE USER START**/
    var table_user = $('#datatable-user').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('.page-title').html(); },
                exportOptions: {
                    columns: ':visible:not(.action)',
                }
            }
        ]
    });
    table_user.buttons().container()
        .appendTo('#datatable-user_wrapper .col-md-6:eq(0)');
    /**DATATABLE USER END**/

    /**DATATABLE TRACKING START**/
    var table_tracking = $('#datatable-tracking').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('.page-title').html(); }
            }
        ]
    });
    table_tracking.buttons().container()
        .appendTo('#datatable-tracking_wrapper .col-md-6:eq(0)');
    /**DATATABLE TRACKING END**/

    /**DATATABLE KITS START**/
    var table_kits = $('#datatable-kits').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('.page-title').html();},
                exportOptions: {
                    columns: ':visible:not(.action)'
                }
            }
        ]
    });

    table_kits.buttons().container()
        .appendTo('#datatable-kits_wrapper .col-md-6:eq(0)');

    /**DATATABLE KITS END**/

    /**DATATABLE FICHES START**/
    var table_fiches = $('#datatable-fiches').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('.page-title').html(); },
                exportOptions: {
                    columns: ':visible:not(.action)'
                }
            },
            {
                extend: 'colvis',
            }
        ],
        "columnDefs": [
            // Hide second, third and fourth columns
            { "visible": false, "targets": [2,3,4,8,9], className: 'hidden' }
        ]
    });
    table_fiches.buttons().container()
        .appendTo('#datatable-fiches_wrapper .col-md-6:eq(0)');
    /**DATATABLE FICHES END**/

/**DATATABLE CATALOGUES START**/
    var table_catalogues = $('#datatable-catalogues').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('.page-title').html(); },
                exportOptions: {
                    columns: ':visible:not(.action)'
                }
            },
            {
                extend: 'colvis',
            }
        ],
        "columnDefs": [
            // Hide second, third and fourth columns
            { "visible": false, "targets": [2,3,6,9], className: 'hidden' }
        ]
    });
    table_catalogues.buttons().container()
        .appendTo('#datatable-catalogues_wrapper .col-md-6:eq(0)');
    /**DATATABLE ACTIONS END**/

    /**DATATABLE FICHES VALIDATION START**/
    var table_fiches = $('#datatable-fiches-valider').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('.page-title').html(); }
            },
            {
                extend: 'colvis',
            }
        ],
        "columnDefs": [
            // Hide second, third and fourth columns
            { "visible": false, "targets": [2,3,4,8,9,10], className: 'hidden' }
        ]
    });
    table_fiches.buttons().container()
        .appendTo('#datatable-fiches-valider_wrapper .col-md-6:eq(0)');
    /**DATATABLE FICHES VALIDATION END**/

    /**DATATABLE FICHES MOTIF START**/
    var table_motif = $('#datatable-motif').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('#demande').html(); },
                exportOptions: {
                    columns: ':visible:not(.action)'
                }
            }
        ]
    });
    table_motif.buttons().container()
        .appendTo('#datatable-motif_wrapper .col-md-6:eq(0)');
    /**DATATABLE FICHES MOTIF END**/

    /**DATATABLE RAPPORTS DE REVU START**/
    var table_rapport_revu = $('#datatable-rapport-revu').DataTable({
        scrollX: true,
        scrollCollapse: true,
        buttons: [
            {
                extend: 'excel',
                title: function () { return $('.page-title').html(); },
                exportOptions: {
                    columns: ':visible:not(.action)'
                }
            }
        ]
    });
    table_rapport_revu.buttons().container()
        .appendTo('#datatable-rapport-revu_wrapper .col-md-6:eq(0)');
    /**DATATABLE RAPPORTS DE REVU END**/
} );








/* Formatting function for row details - modify as you need */
// function format ( d ) {
//     // `d` is the original data object for the row
//     return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
//         '<tr>'+
//             '<td>Full name:</td>'+
//             '<td>'+d.name+'</td>'+
//         '</tr>'+
//         '<tr>'+
//             '<td>Extension number:</td>'+
//             '<td>'+d.extn+'</td>'+
//         '</tr>'+
//         '<tr>'+
//             '<td>Extra info:</td>'+
//             '<td>And any further details here (images etc)...</td>'+
//         '</tr>'+
//     '</table>';
// }

// $(document).ready(function() {
//     var table = $('#child_rows').DataTable( {
//         // "ajax": "../../plugins/datatables/objects.txt",
//         "data": testdata.data,
//         select:"single",
//         "columns": [
//             {
//                 "className":      'details-control',
//                 "orderable":      false,
//                 "data":           null,
//                 "defaultContent": ''
//             },
//             { "data": "name" },
//             { "data": "position" },
//             { "data": "office" },
//             { "data": "salary" }
//         ],
//         "order": [[1, 'asc']]
//     } );

//     // Add event listener for opening and closing details
//     $('#child_rows tbody').on('click', 'td.details-control', function () {
//         var tr = $(this).closest('tr');
//         var row = table.row( tr );

//         if ( row.child.isShown() ) {
//             // This row is already open - close it
//             row.child.hide();
//             tr.removeClass('shown');
//         }
//         else {
//             // Open this row
//             row.child( format(row.data()) ).show();
//             tr.addClass('shown');
//         }
//     } );
// } );

// var testdata = {
//     "data": [
//     {
//     "name": "Tiger Nixon",
//     "position": "System Architect",
//     "salary": "$320,800",
//     "start_date": "2011/04/25",
//     "office": "Edinburgh",
//     "extn": "5421"
//     },
//     {
//     "name": "Garrett Winters",
//     "position": "Accountant",
//     "salary": "$170,750",
//     "start_date": "2011/07/25",
//     "office": "Tokyo",
//     "extn": "8422"
//     },
//     {
//     "name": "Ashton Cox",
//     "position": "Junior Technical Author",
//     "salary": "$86,000",
//     "start_date": "2009/01/12",
//     "office": "San Francisco",
//     "extn": "1562"
//     },]}
