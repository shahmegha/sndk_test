$(document).ready(function () {
    if ($('#sub_category_id').val() === '') {
        $('#sub_category_div').hide();
    } else {
        $('#sub_category_div').show();
    }

    $('#category_id').on('change', function () {
        $('#sub_category_div').show();
        $('#sub_category_id option').hide();
        $('#sub_category_id option[data-option-category="' + $(this).val() + '"]').show();
    });

    // Once image delete button clicked
    $('.image_single_delete').click(function () {
        var image_delete_id = $(this).data('product-image-id');
        var deleted_image_id = $('#product_image_delete').val();
        if (deleted_image_id === '') {
            $('#product_image_delete').val(image_delete_id);
        } else {
            var deleted_image_arr = deleted_image_id.split(",");
            deleted_image_arr.push(image_delete_id);
            $('#product_image_delete').val(deleted_image_arr.join(','));
        }
        $('.product_image_single_' + image_delete_id).remove();
    });

    var maxField = 10; //Attribute fields increment limitation
    var attributeAddButton = $('#attribute_fields_button'); //Add button Attribute selector
    var attributeWrapper = $('#attribute_fields_group'); //Attribute field wrapper

    // Once add button is clicked
    $(attributeAddButton).click(function () {
        var attributeCounter = $('.attribute_single').length;
        var newAttibuteNo = attributeCounter + 1;
        var fieldHTML = $('.attribute_single').clone(true);
        fieldHTML.find('.attribute_single_delete').attr('data-product-attr-no', newAttibuteNo);
        fieldHTML.find('.attribute_single_id').attr('name', 'product_attribute[' + (newAttibuteNo - 1) + '][id]').attr('value', '');
        fieldHTML.find('.attribute_single_size').attr('name', 'product_attribute[' + (newAttibuteNo - 1) + '][size]').attr('value', '');
        fieldHTML.find('.attribute_single_price').attr('name', 'product_attribute[' + (newAttibuteNo - 1) + '][price]').attr('value', '');
        //Check maximum number of input fields
        if (attributeCounter < maxField) {
            var appendHtml = '<div class="attribute_single attribute_single_' + newAttibuteNo + '"> ' + $(fieldHTML).html() + '</div>';
            $(attributeWrapper).append(appendHtml); //Add field html
        } else {
            alert('A maximum of ' + maxField + ' attribute are allowed to be added. ');
        }
    });

    // Once attribute remove button is clicked
    $('.attribute_single_delete').on('click', function (e) {
        e.preventDefault();
        var attribute_number = $(this).data('product-attr-no');
        var attributeCounter = $('.attribute_single').length;
        //Check maximum number of input fields
        if (1 < attributeCounter) {
            $('.attribute_single_' + attribute_number).remove(); //Remove field html
        } else {
            alert('A minimum of one attribute are should be added.');
        }

    });

    $("#product_form").validate({
        errorClass: "text-red-600 error",
        rules: {
            category_id: {
                required: true
            },
            sub_category_id: {
                required: function () {
                    console.log($('#sub_category_id option[data-option-category="' + $('#category_id').val() + '"]').length);
                    return $('#sub_category_id option[data-option-category="' + $('#category_id').val() + '"]').length > 0;
                }
            },
            product_name: {
                required: true,
                maxlength: 255
            },
            regular_price: {
                required: true
            },
            "product_images[]": {
                required: function () {
                    return $('#mode').val() === 'add';
                },
                extension:"jpeg|jpg|png",
                filesize: 10
            },
            "product_attribute[][size]": {
                required: true
            },
            "product_attribute[][price]": {
                required: true
            }
        },
        messages: {
            category_id: {
                required: "Please select category."
            },
            sub_category_id: {
                required: "Please select sub category."
            },
            product_name: {
                required: "Please enter product name."
            },
            regular_price: {
                required: "Please enter reqular price."
            },
            "product_images[]": {
                required: "Please select product images.",
                extension: "Please select only image with jpeg,jpg or png extesion."
            },
            "product_attribute[][size]": {
                required: 'Please enter size'
            },
            "product_attribute[][price]": {
                required: 'Please enter size'
            }
        }
    });
});