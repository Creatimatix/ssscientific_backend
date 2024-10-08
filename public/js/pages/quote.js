var quote = {
    listTable: '#quoteTable',
    init: function () {
        var obj = this;
        var $table = $(obj.listTable);
        if ($table.length) {
            var dt = $table.DataTable({
                dom: 'Bfrtip',
                bProcessing: false,
                bServerSide: true,
                sAjaxSource: quoteAjax,
                // fnServerParams: function (aoData) {
                //     //d.type = 'bo';
                //     aoData.push(
                //         {
                //             'name': 'quote_status',
                //             'value': $('#quote_status').val()
                //         }, {
                //             'name': 'quote_type',
                //             'value': $('#chkTestQuote').is(':checked')
                //         });
                // },
                pageLength: 15,
                rowGroup: {
                    enable: false
                },
                autoWidth: false,
                columns: [
                    {data: 'id'},
                    {data: 'created_at'},
                    {data: 'quote_no'},
                    {data: 'company_info', className: 'text-center'},
                    {data: 'contact_info', className: 'text-center'},
                    {data: 'product_desc', className: 'text-center'},
                    {data: 'total_price'},
                    {data: 'created_by'},
                    {data: 'status'},
                    {data: 'controls'}
                ],
                columnDefs: [
                    {className: 'text-center', "targets": [0]},
                    {className: 'text-center', "targets": [1]},
                    {className: 'text-center', "targets": [2]},
                    {className: 'text-center', "targets": [3]},
                    {className: 'text-center', "targets": [4]},
                    {className: 'text-center', "targets": [5]},
                    {className: 'text-center', "targets": [6]},
                    {className: 'text-center', "targets": [7]},
                    {className: 'text-center', "targets": [8]},
                    {className: 'text-center', "targets": [9]}
                ],
                order: [[0, 'desc']],
                buttons: [
                    //'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                stateSave: false,
                // stateSaveCallback: function (settings, data) {
                //     localStorage.setItem('invoice_' + settings.sInstance, JSON.stringify(data));
                // },
                // stateLoadCallback: function (settings) {
                //     return JSON.parse(localStorage.getItem('invoice_' + settings.sInstance));
                // }
            });
            // $('body').on('click', '#refreshInvoices', function () {
            //     dt.ajax.reload();
            // });
            $('body').on('change', '#quote_status', function () {
                dt.ajax.reload();
            });
        }
    },
    searchProduct:function (e) {
        var sku = $(e).val();
        if(sku=='' || sku==null){
            return false;
        }
        var url = $(e).attr('data-action');
        // var state=$('#state').val();
        // purchase.disableSubmit(true);
        $('.productResultContainer').html('<p>Loading...</p>');
        $.get(url, {sku: sku}, function (date) {
            $('.productResultContainer').html(date);
            //$('.monthSwitch').trigger('change');
            // purchase.enableSubmit();
        }).error(function (data) {
            $('.productResultContainer').html(date);
        }).always(function () {
            // purchase.enableSubmit();
        });
        return false;
    },
    approveProposal: function(url){
        $('.confirmApprovalBtn').prop("disabled", true);
        $('.approvedProposalDiv').html('');
        var action_type = $('#action_type').val();
        var remark = $('#remark').val();
        $.post(url,{ action_type,remark} ,function(response){
            if(response.statusCode == 200){
                $('#confirmApprovalModal').modal('hide');
                $('.approvedButton').removeAttr('onclick');
                $('.approvedButton').text('Quote Approved');
                $('#update_proposal').css('display','none');
                $('#invoiceDownload').show();
                $('.approvedProposalDiv').html(response.approvedMsg);
                messages.saved('Proposal', response.message);
            }else{
                messages.error('Proposal', response.message);
                $('.confirmApprovalBtn').prop("disabled", false);
            }
        });
        return false;
    },
    send:function(url){
        $('.customerSendMailBtn').prop('disabled',true)
        $.get(url, function(response){
            $('.customerSendMailBtn').prop('disabled', false)
            if(response.statusCode == 200){
                messages.saved("Quote", response.message)
            }else{
                messages.saved("Quote", response.message)
            }
        })
    }
}

var itemlist = {
    add:function (e, url, combination_sku,product_sku) {
        $('.addMoreProductLable').hide();
        $('.cartItemsBlock').html('<div class="loadProducts">Please wait..</div>');
        var $tr = $(e).closest('tr');

        if($tr.find('._Qty').val()==''){
            messages.error('Required','Please enter qty of product');
            $tr.find('._Qty').focus();
            return;
        }
        if($tr.find('._AssetValue').val()==''){
            messages.error('Required','Please enter purchase cost');
            $tr.find('._AssetValue').focus();
            return;
        }

        var productId = $tr.find('._productId').val();
        var qty = $tr.find('._Qty').val();
        var assetValue=$tr.find('._AssetValue').val();
        var originalAssetValue=$('._originalAssetValue').val();

        $.post(url, {
            quote_id: $('#quote_id').val(),
            productId: productId,
            quantity: qty,
            assetValue:assetValue,
            originalAssetValue:originalAssetValue
        }, function(data){
            if(data.status){
                messages.saved('','Item added successfully');
            }else{
                messages.error('Product','data already added in cart');
            }
            itemlist.refreshView();
        });
        $('#ddlProducts').val(null).trigger('change');
        $('.productResultContainer').hide();
        $('.addMoreProductLable').show();
    },
    addAccessories:function (e, url, product_sku) {
        $('.cartItemsBlock').html('<div class="loadProducts">Please wait..</div>');
        var $tr = $(e).closest('tr');

        if($tr.find('._Qty').val()==''){
            messages.error('Required','Please enter qty of product');
            $tr.find('._Qty').focus();
            return;
        }
        if($tr.find('._AssetValue').val()==''){
            messages.error('Required','Please enter purchase cost');
            $tr.find('._AssetValue').focus();
            return;
        }

        var productId = $tr.find('._productId').val();
        var qty = $tr.find('._Qty').val();
        var assetValue = $tr.find('._AssetValue').val();
        var itemId = $tr.find('._itemId').val();
        var originalAssetValue=$('._originalAssetValue').val();

        $.post(url, {
            quote_id: $('#quote_id').val(),
            productId: productId,
            quantity: qty,
            assetValue:assetValue,
            originalAssetValue:originalAssetValue,
            itemId:itemId
        }, function(data){
            if(data.status){
                messages.saved('','Item added successfully');
            }else{
                messages.error('Product','data already added in cart');
            }
            itemlist.refreshView();
        });

    },
    refreshView:function(url, e){
        // if(typeof url === typeof undefined){
        //     url = itemsUrl;
        // }
        $('.cartItemsBlock').html('<div class="loadProducts">Please wait..</div>');
        if(typeof e === typeof undefined || !$(e).length){
            e = '.cartItemsBlock';
        }
        var quote_id = $('#quote_id').val();
        itemsUrl = siteUrl+'/quote/items/'+quote_id;
        $.get(itemsUrl, function(data){
            $(e).html(data.html);
        });
    },
    deleteRow:function(e, url, productinventoryid){
        if(confirm('Are you sure want to delete this Product? If you delete this product, it cannot be restored.')) {
            $.post(url, {
                productinventoryid: productinventoryid
            }, function (data) {
                messages.saved('', 'Item deleted successfully');
                itemlist.refreshView();
            });
        }
    },
    applyDiscount: function (e){
        $('#discountBtn').attr("disabled", true);
        var discountAmount = $('#discount').val();
        var totalOrderAmount = $('#totalOrderAmount').val();
        var discountPercentage = $('#discount_percentage').val();
        var url = $('#discountForm').attr('action');
        if (parseInt(discountAmount) >= parseInt(totalOrderAmount)) {
            $('#discountBtn').attr("disabled", false);
            messages.error('Discount', 'Discounted amount should not be greater than the total amount.');
            return false;
        }
        $.post(url,{
            discountAmount:discountAmount,
            discountPercentage:discountPercentage,
            quoteId: $('#quote_id').val()
        },function(response){
            messages.saved('Discount', 'discount applied successfully.');
            itemlist.refreshView();
        });
    },
    getAccessories: function(itemId){
        $('#accessoriesModal').modal('show');
        getAccessories('',itemId);
        // $('#accessoriesTable').DataTable();
    }
}

$(document).on('click','#quoteFormBtn',function(e){
    e.preventDefault();
    $(this).attr('disabled',true);
    var url = $('#quoteForm').attr('action');
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: $('#quoteForm').serialize()+"&formType=",
        success:function(response){
            if(response.statusCode === 200){
                $(this).attr('disabled',false);
                messages.saved("Quote", response.message);
                $('#quoteForm')[0].reset();

                if($('#quote_id').val() > 0){
                    window.location.reload();
                }else{
                    window.location.href=adminUrl+'/quote/edit/'+response.quoteId;
                }
            }else{
                $(this).attr('disabled',false);
                $('.quoteFormBtn').prop('disabled', false);
                if(response.statusCode == 400){
                    var str = '';
                    $.each(response.errors, function(key, value) {
                        if(key == 'id_user'){
                            key  =  'quoteCustomer';
                            if($('#quoteFormBtn').hasClass('quoteNewForm')){
                                $('#'+key).after('<div class="quote-error" style="display: block;position: absolute;margin-top: 43px;line-height: 16px;">'+value[0]+'</div>');
                            }else{
                                $('#'+key).after('<div class="quote-error" style="display: block;position: absolute;margin-top: 43px;">'+value[0]+'</div>');
                            }

                        }else{
                            $('#'+key).after('<div class="quote-error">'+value[0]+'</div>');
                        }

                    });
                    $('.quote_error').html(str);
                    messages.error("Error", 'Please enter valid form');

                }else{
                    messages.error('Error', response.message);
                }
            }
        }
    });
});

function fillBillingAddress(){

    if($("#billingChk").prop('checked') == true){

        if($('#address').val() == '' || $('#zipcode').val() == '' || $('#city').val() == '' || $('#state').val() == ''){
            $('#billingChk').prop("checked",false);
            // messages.error("Billing Address", "Please enter staging address.");
            // return false;
        }

        $('#billing_address').val($('#address').val());
        $('#billing_apt_no').val($('#apt_no').val());
        $('#billing_zipcode').val($('#zipcode').val());
        $('#billing_city').val($('#city').val());
        $('#billing_state').val($( "#state" ).val());
    }else{
        $('#billing_address').prop('readonly',false);
        $('#billing_apt_no').prop('readonly',false);
        $('#billing_zipcode').prop('readonly',false);
        $('#billing_city').prop('readonly',false);
        $('#billing_state').prop('readonly',false);
    }
}

$(function (){
    quote.init();
    initializeCustomerSelect2();
    initializeProductSelect2();
    itemlist.refreshView();
    $('#order_type').trigger('change')
});

function initializeCustomerSelect2(){
    $('#quoteCustomer').select2({
        ajax: {
            url: siteUrl+"/user/details",
            dataType: 'json',
            delay: 250,
            method: 'post',
            data: function (params) {
                return {
                    term: params.term,
                    user_type: 'customer'
                };
            },
            processResults: function (data, params) {
                console.log('data',data);
                console.log('params',params);
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
        dropdownParent: $('#quoteForm'),
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

function initializeProductSelect2(){
    $('#ddlProducts').select2({
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
                console.log('data',data);
                console.log('params',params);
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
        dropdownParent: $('#productForm'),
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

function getUserDetails(val,type, isUpdate = false){
    $.ajax({
        type: 'get',
        url: siteUrl+"/user/info",
        data: {id:val, type},
        success: function (data) {
            if(data.email){
                $('#email').val(data.email);
            }
            if(data.phone_number){
                $('#phone_number').val(data.phone_number);
            }
            if(data.gst_no){
                $('#gst_no').val(data.gst_no);
            }
            if(data.address){
                $('#address').val(data.address);
            }
            if(data.city){
                $('#city').val(data.city);
            }
            if(data.apt_no){
                $('#apt_no').val(data.apt_no);
            }
            if(data.zipcode){
                $('#zipcode').val(data.zipcode);
            }
            if(data.state){
                $('#state').val(data.state);
            }
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
$(document).on('change','#order_type', function(e){
    var orderType = $(this).val();
    if(orderType == 1){
        $('.depend_on_tendor').show();
    }else{
        $('.depend_on_tendor').hide();
    }
});
$(document).on('change','.trm_cond_checkbox', function(e){
    var val = $(this).val();
    if(val == 'igst'){
        $('#c_gst').val('');
        $('#s_gst').val('');
    }else{
        $('#i_gst').val('');
    }
    if ($(this).prop('checked')) {
        $('.trm_cond_checkbox').not(this).prop('checked', false);
    }
});

$(document).on('click','#is_amended', function(e){
    if($(this).prop('checked') == true){
        $('#amended_on').show();
    }else{
        $('#amended_on').val('');
        $('#amended_on').hide();
    }
});
$(document).on('click','#terms_condition_btn', function(e){
    const selectedCheckboxes = $('.trm_cond_checkbox:checked');
    var is_i_gst = $('#is_i_gst').val();
    var is_c_s_gst = $('#is_c_s_gst').val();


    if($('#installation').val() == ''){
        messages.error("T&C", "Please enter Installation Charge.");
        return false;
    }

    if (selectedCheckboxes.length > 0) {
        if($('#freight').val() == ''){
            messages.error("T&C", "Please enter Freight value");
            return false;
        }
        console.log("i_gest",$('#is_i_gst').prop('checked'));
        console.log("cs_gest",$('#is_c_s_gst').prop('checked'));
        if($('#is_i_gst').prop('checked') == true){
            if($('#i_gst').val() == ''){
                messages.error("T&C", "Please enter IGST value");
                return false;
            }
        }

        if($('#is_c_s_gst').prop('checked') == true){
            if($('#c_gst').val() == ''){
                messages.error("T&C", "Please enter CGST value");
                return false;
            }
            if($('#s_gst').val() == ''){
                messages.error("T&C", "Please enter SGST value");
                return false;
            }
        }


        // if($('#is_amended').prop('checked') == true){
        //     if($('#amended_on').val() == ''){
        //         messages.error("T&C", "Please choose amended date.");
        //         return false;
        //     }
        // }

        var freightType = $('#getFreightCharge').val();
        var freightPercentage = $('#freight_percentage').val();
        var installationType = $('#getInstallationCharge').val();
        var installationPercentage = $('#percentage').val();
        var warrantyNote = $('#warranty_note').val();
        var paymentTerms = $('#payment_terms').val();
        var validity = $('#validity').val();

        $.ajax({
            type: 'post',
            url: siteUrl+"/ajax/update-terms-n-conditions",
            data: {
                'quote_id':$('#quote_id').val(),
                'i_gst':$('#i_gst').val(),
                'c_gst':$('#c_gst').val(),
                's_gst':$('#s_gst').val(),
                'freight':$('#freight').val(),
                'installation':$('#installation').val(),
                'freightType': freightType,
                'freightPercentage': freightPercentage,
                'installationType': installationType,
                'installationPercentage': installationPercentage,
                'amended_on': $('#is_amended').prop('checked')?true:false,
                'warranty_note': warrantyNote,
                'payment_terms': paymentTerms,
                'validity': validity,
            },
            success: function (response) {
                if(response.statusCode == 200){
                    messages.saved('T&C', response.message);
                    itemlist.refreshView();
                }else{
                    messages.error('T&C', response.message);
                }
            }
        });
    } else {
        messages.error("T&C", 'Please select at least one checkbox.');
        return false;
    }
});


$(document).on('blur','#freight_percentage',function(e) {
    if($(this).val() > 0){
        getFreight();
    }
});
$(document).on('change','#getFreightCharge',function(e){
    getFreight();
});

$(document).on('blur','#percentage',function(e) {
    if($(this).val() > 0){
        getInstalltion();
    }
});
$(document).on('change','#getInstallationCharge',function(e){
    getInstalltion();
});

$(document).on('click','.showQuotePriview',function(e){
    $('#quotePreviewModal').modal('show');
    var quoteId = $('#quote_id').val();
    $.ajax({
        type: 'get',
        url: siteUrl+"/items/preview/"+quoteId,
        data: {
            'quoteId':quoteId
        },
        success: function (response) {
            $("#quoteItemDetails").html(response.html);
        }
    });
});
$(document).on('click','.isQuotePreviewBtn',function(e){
    var quoteId = $("#quote_id").val();
    if (!$('#is_preview').is(':checked')){
        messages.error("Preview","Please checked checkbox for confirm preview.")
        return false;
    }
    $.ajax({
        type: 'post',
        url: siteUrl+"/quote/update-preview",
        data: {quoteId},
        success: function (response) {
            messages.saved("Preview","You have confirmed the preview.");
            $('#quotePreviewModal').modal('hide');
            window.location.reload();
        }
    });
});

$(document).on('change','.is_payable',function(e){
    var isPayable = null;
    var itemId = $(this).attr('data-id');
    if($(this).prop('checked') == true){
        isPayable = 1;
    }else{
        isPayable = 0;
    }

    $.ajax({
        type: 'post',
        url: siteUrl+"/admin/ajax/accessories/charge",
        data: {
            'itemId':itemId,
            'isPayable':isPayable
        },
        success: function (response) {
            if(response.statusCode == 200){
                messages.saved('T&C', response.message);
                itemlist.refreshView();
            }else{
                messages.error('T&C', response.message);
            }
        }
    });
});

function getInstalltion(){
    quoteId = $('#quote_id').val();
    type = $('#getInstallationCharge').val();
    $('#installation').val('');
    if(type == '%'){
        $('#percentage').show();
    }else{
        $('#percentage').val('');
        $('#percentage').hide();
    }
    percentage = $('#percentage').val();
    $.ajax({
        type: 'get',
        url: siteUrl+"/ajax/getInstallationCharge",
        data: {quoteId:quoteId,type:type,val:percentage},
        success: function (data) {
            console.log('data',data)
            $('#installation').val(data);
        }
    });
}

function getFreight(){
    quoteId = $('#quote_id').val();
    type = $('#getFreightCharge').val();
    $('#freight').val('');
    if(type == '%'){
        $('#freight_percentage').show();
    }else{
        $('#freight_percentage').val('');
        $('#freight_percentage').hide();
    }
    percentage = $('#freight_percentage').val();
    $.ajax({
        type: 'get',
        url: siteUrl+"/ajax/getFreightCharge",
        data: {quoteId:quoteId,type:type,val:percentage},
        success: function (data) {
            console.log('data',data)
            $('#freight').val(data);
        }
    });
}

function getAccessories(textSearch = '', itemId){
    $('#accessoriesRowData').html("<td colspan='6' style='text-align:center;padding:10px'>loading....</td>");
    $.ajax({
        type: 'get',
        url: siteUrl+"/admin/ajax/accessories",
        data: {textSearch: textSearch,itemId: itemId},
        success: function (data) {
            $('#accessoriesRowData').html(data.htmlView);
        }
    });
}

$(document).on('change','#discount_type',function(e){
    type = $('#discount_type').val();
    $('#discount').val('');
    if(type == '%'){
        $('#discount_percentage').show();
        $('#discount').attr('disabled', true);
    }else{
        $('#discount').attr('disabled', false);
        $('#discount_percentage').val('');
        $('#discount_percentage').hide();
    }
});

$(document).on('keyup','#discount_percentage',function(e) {
    if($(this).val() > 0){
        getDiscount();
    }
});
function getDiscount(){
    quoteId = $('#quote_id').val();
    percentage = $('#discount_percentage').val();
    $.ajax({
        type: 'get',
        url: siteUrl+"/ajax/getDiscount",
        data: {quoteId:quoteId,type:type,val:percentage},
        success: function (data) {
            $('#discount').val(data);
        }
    });
}
