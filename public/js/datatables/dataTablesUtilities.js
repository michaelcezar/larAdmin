function dataTablesLengthSelect(order){
    if (order === 'desc'){
        var retorno = [
            [-1,100,50,30,10],
            ['Todos',100,50,30,10]
        ];
    } else {
        var retorno = [
            [10,30,50,100,-1],
            [10,30,50,100,'Todos']
        ];
    }
    return retorno;
}

function dataTablesLanguage(language){
    switch(language) {
    case 'pt-br':
        var retorno = {'url': '/js/datatables/language/Portuguese-Brasil.json'};
        break;
    }
    return retorno;
}

function ajaxDataTable(setDataTable){
    return {
        'language'   : dataTablesLanguage('pt-br'),
        'aLengthMenu': dataTablesLengthSelect(setDataTable.orderMenuLength),
        'ajax': {
            'url':     setDataTable.url,
            'type':    setDataTable.method,
            'data':    function(){ return setDataTable.searchParams[0]},
            'dataSrc': setDataTable.dataSrc,
        },
        'aoColumns': setDataTable.columnsAray,
        'order':     setDataTable.orderColumnsnArray,
        'drawCallback': function() {
            if(setDataTable.buttons) {
                $(setDataTable.tableId+'_filter').html('');
                var buttons = new $.fn.dataTable.Buttons($(setDataTable.tableId), {
                    buttons: [
                        {
                            text:      '<i class="fas fa-search fa-fw "></i>',
                            className: 'btn btn-secondary mr-1 rounded tooltips lista '+ setDataTable.reportId+'SEARCH',
                            attr:  {
                                'onClick':             setDataTable.reportId+'SEARCH();',
                                'data-container':      'body',
                                'data-toggle':         'tooltip',
                                'data-placement':      'bottom',
                                'data-original-title': 'Pesquisar '
                            }
                        },
                        {
                            extend:    'excelHtml5',
                            text:      '<i class="far fa-file-excel fa-fw "></i>',
                            className: 'btn btn-secondary mr-1 rounded tooltips lista '+ setDataTable.reportId+'EXCEL',
                            attr:  {
                                'data-container':      'body',
                                'data-toggle':         'tooltip',
                                'data-placement':      'bottom',
                                'data-original-title': 'Gerar Excel '
                            },
                            footer :    true,
                            title:      setDataTable.reportTitle,
                            exportOptions: {
                                columns:  setDataTable.showColumnsReportArray,
                                format: {
                                    body: function(data, row, column, node) {
                                        data = $('<p>' + data + '</p>').text();
                                        return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                                    },
                                    footer: function(data, row, column, node) {
                                        data = $('<p>' + data + '</p>').text();
                                        return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                                    }
                                }
                            }
                        },
                        {
                            extend:      'pdfHtml5',
                            text:        '<i class="far fa-file-pdf fa-fw "></i>',
                            className:   ' btn btn-secondary mr-1 rounded tooltips lista '+ setDataTable.reportId+'PDF',
                            attr:  {
                                'data-container':      'body',
                                'data-toggle':         'tooltip',
                                'data-placement':      'bottom',
                                'data-original-title': 'Gerar PDF '
                            },
                            orientation: setDataTable.reportOrientation,
                            pageSize:    'A4',
                            footer :     true,
                            title:       setDataTable.reportTitle,
                            exportOptions: {
                                columns:  setDataTable.showColumnsReportArray
                            },
                            customize: function (doc) {
                                doc.styles.tableHeader.alignment = 'left';
                                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                            }
                        },
                        {
                            extend: 'print',
                            text:      '<i class="fas fa-print fa-fw "></i>',
                            className: ' btn btn-secondary mr-1 rounded tooltips lista '+ setDataTable.reportId+'PRINT',
                            attr:  {
                                'data-container':      'body',
                                'data-toggle':         'tooltip',
                                'data-placement':      'bottom',
                                'data-original-title': 'Imprimir '
                            },
                            orientation: setDataTable.reportOrientation,
                            pageSize: 'A4',
                            footer : true,
                            title: setDataTable.reportTitle,
                            exportOptions: {
                                columns:  setDataTable.showColumnsReportArray
                            },
                            customize: function(win)
                            {
                                var last = null;
                                var current = null;
                                var bod = [];
                                var css = '@page { size: '+setDataTable.reportOrientation+'; }',
                                    head = win.document.head || win.document.getElementsByTagName('head')[0],
                                    style = win.document.createElement('style');
                                style.type = 'text/css';
                                style.media = 'print';
                                if (style.styleSheet)
                                {
                                  style.styleSheet.cssText = css;
                                }
                                else
                                {
                                  style.appendChild(win.document.createTextNode(css));
                                }
                                head.appendChild(style);
                            }
                        }
                    ]
                }).container().appendTo($(setDataTable.tableId+'_filter'));
                $('[data-toggle="tooltip"]').tooltip();
            }
        },
    }
}