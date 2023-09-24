
function initializeQuoteSelect2(){
    $('#quoteNo').select2({
        ajax: {
            url: "/quote/details",
            dataType: 'json',
            delay: 250,
            method: 'post',
            data: function (params) {
                return {
                    term: params.term,
                    // user_type: 'vendor'
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.data,
                    pagination: {
                        page: (params.page * data.per_page) < data.total
                    }
                };
            },
            cache: false
        },
        minimumInputLength: 1,
        // dropdownParent: $('#invoiceForm'),
        templateResult: function (quote) {
            console.log('quote',quote);
            if (!quote.id) {
                return quote.quote_no;
            }
            var $state = $(
                '<span clas="user-list">' + quote.quote_no + '</span>'
            );
            return $state;
        },
        templateSelection: function (quote) {
            console.log('user 1',quote);
            if (!quote.id) {
                return 'Select User';
            }
            var $state = $(
                '<span>' + quote.quote_no + '</span>'
            );
            if (typeof quote.quote_no === typeof undefined && typeof quote.email === typeof undefined) {
                $state = $(
                    '<span>' + quote.text + '</span>'
                );
            }
            return $state;
        }
    });
}

function initializePurchaseOrderSelect2(){
    $('#poNo').select2({
        ajax: {
            url: "/purchase-order/details",
            dataType: 'json',
            delay: 250,
            method: 'post',
            data: function (params) {
                return {
                    term: params.term,
                    // user_type: 'vendor'
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.data,
                    pagination: {
                        page: (params.page * data.per_page) < data.total
                    }
                };
            },
            cache: false
        },
        minimumInputLength: 1,
        // dropdownParent: $('#invoiceForm'),
        templateResult: function (po) {
            console.log('po',po);
            if (!po.id) {
                return po.po_no;
            }
            var $state = $(
                '<span clas="user-list">' + po.po_no + '</span>'
            );
            return $state;
        },
        templateSelection: function (po) {
            if (!po.id) {
                return 'Select PO';
            }
            var $state = $(
                '<span>' + po.po_no + '</span>'
            );
            if (typeof po.po_no === typeof undefined) {
                $state = $(
                    '<span>' + po.text + '</span>'
                );
            }

            return $state;
        }
    });
}

$(function (){
    initializeQuoteSelect2();
    initializePurchaseOrderSelect2();
});

