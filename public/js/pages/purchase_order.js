
function initializeVendorSelect2(){
    $('#vendorUser').select2({
        ajax: {
            url: "/user/details",
            dataType: 'json',
            delay: 250,
            method: 'post',
            data: function (params) {
                return {
                    term: params.term,
                    user_type: 'vendor'
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
        // dropdownParent: $('#poForm'),
        templateResult: function (user) {
            console.log('user',user);
            if (!user.id) {
                return user.first_name + ' ' + user.last_name;
            }
            var $state = $(
                '<span clas="user-list">' + user.first_name + ' ' + user.last_name + '(<em>' + user.email + '</em>)</span>'
            );
            return $state;
        },
        templateSelection: function (user) {
            console.log('user 1',user);
            if (!user.id) {
                return 'Select User';
            }
            var $state = $(
                '<span>' + user.full_name + ' (' + user.email + ')</span>'
            );
            if (typeof user.full_name === typeof undefined && typeof user.email === typeof undefined) {
                $state = $(
                    '<span>' + user.text + '</span>'
                );
            }

            return $state;
        }
    });
}


function initializeProductSelect2(){
    $('#ddlVendorProducts').select2({
        ajax: {
            url: "/admin/ajax/products",
            dataType: 'json',
            delay: 250,
            method: 'get',
            data: function (params) {
                return {
                    term: params.term
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
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
        // dropdownParent: $('#productForm'),
        templateResult: function (product) {
            console.log('product',product);
            if (!product.id) {
                return product.name;
            }
            var $state = $(
                '<span clas="user-list">' + product.name + '</span>'
            );
            return $state;
        },
        templateSelection: function (product) {
            console.log('user 1',product);
            if (!product.id) {
                return 'Select Product';
            }
            var $state = $(
                '<span>' + product.name + '</span>'
            );
            if (typeof product.name === typeof undefined) {
                $state = $(
                    '<span>' + product.text + '</span>'
                );
            }

            return $state;
        }
    });
}

$(function (){
    initializeVendorSelect2();
    initializeProductSelect2();
});

function getVendorDetails(val,type, isUpdate = false){
    $.ajax({
        type: 'get',
        url: "/user/info",
        data: {id:val},
        success: function (data) {
            console.log('vendor',data)
        }
    });
}

function searchVendorProduct(val,type, isUpdate = false){
    var sku = val;
    if(sku=='' || sku==null){
        return false;
    }
    $('.productResultContainer').html('<p>Loading...</p>');
    $.ajax({
        type: 'get',
        url: "/admin/ajax/product",
        data: {id:val},
        success: function (data) {
            console.log('data',data)
            $('.productResultContainer').html(data.htmlView);
        }
    });
}
