var product = {
    slugify: function (string) {
        return string
            .toString()
            .trim()
            .toLowerCase()
            .replace(/\s+/g, "-")
            .replace(/[^\w\-]+/g, "")
            .replace(/\-\-+/g, "-")
            .replace(/^-+/, "")
            .replace(/-+$/, "");
    },
    deleteImage: function (productImgId){
        $.ajax({
            type: 'get',
            url: siteUrl+"/admin/ajax/product/delete-image",
            data: {id_image:productImgId},
            success: function (data) {
                messages.saved("Image", "Image removed successfully.");
                $('#p_image_'+productImgId).hide();
                return false;
            }
        });
    },
    listTable: '#productTable',
    init: function () {
        var obj = this;
        var $table = $(obj.listTable);
        if ($table.length) {
            var dt = $table.DataTable({
                dom: 'Bfrtip',
                bProcessing: false,
                bServerSide: true,
                sAjaxSource: productAjax,
                fnServerParams: function (aoData) {
                    //d.type = 'bo';
                    aoData.push(
                    {
                        'name': 'id_category',
                        'value': $('#category_filter').val()
                    });
                },
                pageLength: 15,
                rowGroup: {
                    enable: false
                },
                autoWidth: false,
                columns: [
                    {data: 'id'},
                    {data: 'model_no'},
                    {data: 'brand'},
                    // {data: 'short_description', className: 'text-center'},
                    {data: 'status'},
                    {data: 'controls'}
                ],
                columnDefs: [
                    {className: 'text-center', "targets": [0]},
                    {className: 'text-center', "targets": [1]},
                    {className: 'text-center', "targets": [2]},
                    {className: 'text-center', "targets": [3]},
                    {className: 'text-center', "targets": [4]},
                    // {className: 'text-center', "targets": [5]}
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
            $('body').on('change', '#category_filter', function () {
                dt.ajax.reload();
            });
        }
    },
}

$(function (){
    product.init();
});

$('#productName').keyup(function () {
    var slug = product.slugify($(this).val());
    $('#txtSlug').val(slug);
    // }
});

$(function (){
    var productSuccessMsg = '';
    var productErrorMsg = '';
    if(productSuccessMsg){
        messages.saved("Product", productSuccessMsg);
    }
    if(productErrorMsg){
        messages.error("Product", productErrorMsg);
    }
});

$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#product_image').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });
});


const imageInput = document.getElementById('product_image');

console.log("imageInput => ", imageInput);

if(imageInput){
    imageInput.addEventListener('change', function () {
        const selectedFile = this.files[0];
        if (selectedFile) {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(selectedFile.type)) {
                messages.error("Upload","Please select a valid image file (JPEG, PNG, GIF).");
                this.value = ''; // Clear the file input
            }
        }
    });
}

function accessories() {
    room++;
    console.log("room", room);
    var objTo = document.getElementById('education_fields')
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass"+room);
    var rdiv = 'removeclass'+room;

    divtest.innerHTML = '<div class="row"> <div class="col-sm-5 nopadding"><div class="form-group"><textarea class="form-control" id="modelname" name="modelname[]" placeholder="Model Name"></textarea></div> </div> <div class="col-sm-2 nopadding"> <div class="form-group"> <input type="text" class="form-control" id="acc_pn_no" name="acc_pn_no[]" value="" placeholder="P/N"> </div> </div> <div class="col-sm-2 nopadding"> <div class="form-group"> <input type="text" class="form-control" id="acc_hsn_no" name="acc_hsn_no[]" value="" placeholder="HSN No"> </div> </div> <div class="col-sm-3 nopadding"> <div class="form-group"> <div class="input-group"> <input type="text" class="form-control" id="acc_sale_price" name="acc_sale_price[]" value="" placeholder="Sale Price"> <div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_accessories('+ room +');"> <span class="fa fa-minus" aria-hidden="true"></span> </button> </div> </div> </div> </div> </div>';

    objTo.appendChild(divtest)
}
function remove_accessories(rid) {
    $('.removeclass'+rid).remove();
}


// '<div class="col-sm-3 nopadding"> </div>  <div className="form-group"><input type="text" className="form-control" id="acc_sku" name="acc_sku[]" value=""\n' placeholder="SKU"></div>'
