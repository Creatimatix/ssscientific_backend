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
    }
}

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
console.log("room", room);
function accessories() {
    room++;
    console.log("room", room);
    var objTo = document.getElementById('education_fields')
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass"+room);
    var rdiv = 'removeclass'+room;

    divtest.innerHTML = '<div class="row"> <div class="col-sm-3 nopadding"><div class="form-group"> <input type="text" class="form-control" id="modelname" name="modelname[]" placeholder="Model name"> </div> </div> <div class="col-sm-3 nopadding"> <div class="form-group"> <input type="text" class="form-control" id="acc_sku" name="acc_sku[]" value="" placeholder="SKU"> </div> </div> <div class="col-sm-3 nopadding"> <div class="form-group"> <input type="text" class="form-control" id="acc_pn_no" name="acc_pn_no[]" value="" placeholder="Pn No"> </div> </div> <div class="col-sm-3 nopadding"> <div class="form-group"> <input type="text" class="form-control" id="acc_hsn_no" name="acc_hsn_no[]" value="" placeholder="HSN No"> </div> </div> <div class="col-sm-3 nopadding"> <div class="form-group"> <div class="input-group"> <input type="text" class="form-control" id="acc_sale_price" name="acc_sale_price[]" value="" placeholder="Sale Price"> <div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_accessories('+ room +');"> <span class="fa fa-minus" aria-hidden="true"></span> </button> </div> </div> </div> </div> </div>';

    objTo.appendChild(divtest)
}
function remove_accessories(rid) {
    $('.removeclass'+rid).remove();
}
