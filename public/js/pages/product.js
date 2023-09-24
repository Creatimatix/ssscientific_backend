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
            url: "/admin/ajax/product/delete-image",
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
