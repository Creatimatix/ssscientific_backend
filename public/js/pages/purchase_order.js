
function initializeVendorSelect2(){
    $('#vendorUser').select2({
        ajax: {
            url: siteUrl+"/user/details",
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
            var companyName =  (typeof(user.company_name) !== "undefined" && user.company_name !== null )? user.company_name : '';
            var $state = $(
                // '<span clas="user-list">' + user.first_name + ' ' + user.last_name + '(<em>' + user.email + '</em>)</span>'
                '<span class="user-list">' + companyName + ' ' + '(<em>' + user.first_name + ' ' + user.last_name + '</em>)</span>'
            );
            return $state;
        },
        templateSelection: function (user) {
            if (!user.id) {
                return 'Select Company';
            }
            var companyName =  (typeof(user.company_name) !== "undefined" && user.company_name !== null )? user.company_name : '';
            var $state = $(
                '<span>' + companyName + ' (' +  user.first_name + ' ' + user.last_name + ')</span>'
            );
            if (typeof user.company_name === typeof undefined && typeof user.email === typeof undefined) {
                $state = $(
                    '<span>' + user.text + '</span>'
                );
            }
            return $state;
        }
    });
}


function initializeProductSelect2(elementSelector){
    $(elementSelector).select2({
        ajax: {
            url: siteUrl+"/admin/ajax/products",
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
    initializeProductSelect2('#ddlVendorProducts');
});

function getVendorDetails(val,type, isUpdate = false){
    $.ajax({
        type: 'get',
        url: siteUrl+"/user/info",
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
        url: siteUrl+"/admin/ajax/product",
        data: {id:val},
        success: function (data) {
            console.log('data',data)
            $('.productResultContainer').html(data.htmlView);
        }
    });
}


function searchProduct(val,type, isUpdate = false){
    var sku = val;
    if(sku=='' || sku==null){
        return false;
    }
    $('.addMoreProductLable').hide();
    $('.productResultContainer').html('<p>Loading...</p>');
    $.ajax({
        type: 'get',
        url: siteUrl+"/admin/ajax/product",
        data: {id:val},
        success: function (data) {
            $('.productResultContainer').html(data.htmlView);
            $('.productResultContainer').show();
        }
    });
}

function addProduct() {
    room++;
    console.log("room", room);
    var objTo = document.getElementById('education_fields')
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass"+room);
    var rdiv = 'removeclass'+room;
    var selectId = 'ddlVendorProducts_'+room;
    divtest.innerHTML = '<div class="row"> <div class="col-sm-5 nopadding"><div class="form-group"><select class="form-control select2bs4" data-resource="product" data-parent="#'+selectId+'" style="width: 100%;" name="product[]" id="'+selectId+'" onchange="return searchVendorProduct(this.value,1)"> <option value="">Select Product</option></select></div></div><div class="col-sm-4 nopadding"> <div class="form-group"><input type="number " class="form-control" id="quantity" name="quantity[]" value="" placeholder="Quantity"></div></div><div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_product('+ room +');"> <span class="fa fa-minus" aria-hidden="true"></span> </button> </div> </div> </div> </div> </div>';

    objTo.appendChild(divtest)
    initializeProductSelect2('#'+selectId);
}

function remove_product(rid) {
    $('.removeclass'+rid).remove();
}
