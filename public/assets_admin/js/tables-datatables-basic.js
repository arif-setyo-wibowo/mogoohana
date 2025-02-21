$(document).ready(function() {
    $("#example1").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-label-primary dropdown-toggle mx-3',
                text: '<i class="mdi mdi-export-variant me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5],
                            format: {
                                body: function(data, row, column) {
                                    // Strip $ from price columns
                                    if (column === 3 || column === 4) {
                                        return data.replace(/^\$\s*/g, '').trim();
                                    }
                                    return data;
                                }
                            }
                        },
                        title: 'Data Produk ' + new Date().toLocaleDateString()
                    },
                    {
                        extend: 'print',
                        text: '<i class="mdi mdi-printer-outline me-1"></i>Print',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1],
                            format: {
                                body: function(inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function(index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        },
                        customize: function(win) {
                            $(win.document.body)
                                .css('color', '#000')
                                .css('border-color', '#ccc')
                                .css('background-color', '#fff');
                            $(win.document.body)
                                .find('table')
                                .addClass('compact')
                                .css('color', 'inherit')
                                .css('border-color', 'inherit')
                                .css('background-color', 'inherit');
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="mdi mdi-file-pdf-box me-1"></i>Pdf',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1],
                            format: {
                                body: function(inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function(index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        },
                        customize: function(doc) {
                            // Customization
                            doc.content.splice(0, 1); // Remove default header
                            doc.styles.tableHeader = {
                                bold: true,
                                fontSize: 11,
                                color: 'black',
                                fillColor: '#f2f2f2',
                                alignment: 'center'
                            };
                            doc.styles.title = {
                                color: 'black',
                                fontSize: '12',
                                alignment: 'center'
                            };
                            doc.content[0].text = 'Data Export';
                        }
                    },
                    {
                        extend: 'copy',
                        text: '<i class="mdi mdi-content-copy me-1"></i>Copy',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1],
                            format: {
                                body: function(inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function(index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        }
                    }
                ]
            }
        ],
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
});