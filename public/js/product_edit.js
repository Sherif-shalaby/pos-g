$(document).ready(function () {
    tinymce.init({
        selector: "#product_details",
        height: 130,
        plugins: [
            "advlist autolink lists link charmap print preview anchor textcolor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime table contextmenu paste code wordcount",
        ],
        toolbar:
            "insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat",
        branding: false,
    });
});
$(".different_prices_for_stores_div").slideUp();
$("#different_prices_for_stores").change(function () {
    if ($(this).prop("checked")) {
        $(".different_prices_for_stores_div").slideDown();
    } else {
        $(".different_prices_for_stores_div").slideUp();
    }
});
$(".this_product_have_variant_div").slideUp();
$("#this_product_have_variant").change(function () {
    if ($(this).prop("checked")) {
        // $(
        //     "#multiple_units, #multiple_colors, #multiple_sizes, #multiple_grades"
        // ).selectpicker("val", "");
        // $(
        //     "#multiple_units, #multiple_colors, #multiple_sizes, #multiple_grades"
        // )
        //     .attr("disabled", true)
        //     .selectpicker("refresh");
        $(".this_product_have_variant_div").slideDown();
    } else {
        $(
            "#multiple_units, #multiple_colors, #multiple_sizes, #multiple_grades"
        )
            .attr("disabled", false)
            .selectpicker("refresh");
        $(".this_product_have_variant_div").slideUp();
    }
});
$(".show_to_customer_type_div").slideUp();
$("#show_to_customer").change(function () {
    if ($(this).prop("checked")) {
        $(".show_to_customer_type_div").slideUp();
    } else {
        $(".show_to_customer_type_div").slideDown();
    }
});
$(document).on("click", ".remove_row", function () {
    row_id = $(this).closest("tr").data("row_id");
    $(this).closest("tr").remove();
    $(".variant_store_checkbox_" + row_id).remove();
    $(".variant_store_prices_" + row_id).remove();
});

$(document).on("click", ".add_row", function () {
    var row_id = parseInt($("#row_id").val());
    // console.log($(".is_edit_service").val());
    var is_service_checked=document.querySelector('#is_service')
    let is_service=0;
    if(is_service_checked.checked == true){
        is_service=1;
    }
    console.log(is_service_checked.checked)
    $.ajax({
        method: "get",
        url: "/product/get-variation-row?row_id=" + row_id,
        data: {
            name: $("#name").val(),
            purchase_price: $("#purchase_price").val(),
            sell_price: $("#sell_price").val(),
            is_service: is_service
        },
        contentType: "html",
        success: function (result) {
            $("#variation_table tbody").prepend(result);
            $(".row_" + row_id)
                .find(".selectpicker")
                .selectpicker("refresh");
            $(".variant_store_prices_" + row_id).slideUp();

            $("#row_id").val(row_id + 1);
        },
    });
});
$(document).on("change", ".v_size, .v_color", function () {
    let row = $(this).parents(".variation_row");
    let name = row.find(".name_hidden").val();
    let color = row.find(".v_color :selected").text();
    let size = row.find(".v_size :selected").text();

    let product_name = name + " " + color + " " + size;
    row.find(".v_name").val(product_name);
});
$(document).on("click", ".variant_different_prices_for_stores", function () {
    let row_id = $(this).data("row_id");

    if ($(this).prop("checked")) {
        $(".variant_store_prices_" + row_id).slideDown();
    } else {
        $(".variant_store_prices_" + row_id).slideUp();
    }
});

// Dropzone.autoDiscover = false;
// myDropzone = new Dropzone("div#my-dropzone", {
//     addRemoveLinks: true,
//     autoProcessQueue: false,
//     uploadMultiple: true,
//     parallelUploads: 100,
//     maxFilesize: 12,
//     paramName: "images",
//     clickable: true,
//     method: "POST",
//     url: $("#product-edit-form").attr("action"),
//     headers: {
//         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//     },
//     renameFile: function (file) {
//         var dt = new Date();
//         var time = dt.getTime();
//         return time + file.name;
//     },
//     acceptedFiles: ".jpeg,.jpg,.png,.gif",
//     init: function () {
//         var myDropzone = this;
//         $("#submit-btn").on("click", function (e) {
//             e.preventDefault();
//             if ($("#product-edit-form").valid()) {
//                 tinyMCE.triggerSave();
//                 if (myDropzone.getAcceptedFiles().length) {
//                     myDropzone.processQueue();
//                 } else {
//                     $.ajax({
//                         type: "POST",
//                         url: $("#product-edit-form").attr("action"),
//                         data: $("#product-edit-form").serialize(),
//                         success: function (response) {
//                             if (response.success) {
//                                 swal("Success", response.msg, "success");
//                                 setTimeout(() => {
//                                     window.close();
//                                 }, 1000);
//                             }
//                         },
//                         error: function (response) {
//                             if (!response.success) {
//                                 swal("Error", response.msg, "error");
//                             }
//                         },
//                     });
//                 }
//             }
//         });
//
//         this.on("sending", function (file, xhr, formData) {
//             document.getElementById("loader").style.display = "block";
//             document.getElementById("content").style.display = "none";
//             var data = $("#product-edit-form").serializeArray();
//             $.each(data, function (key, el) {
//                 formData.append(el.name, el.value);
//             });
//         });
//         this.on("complete", function (file) {
//             this.removeAllFiles(true);
//             myFunction();
//         });
//     },
//     error: function (file, response) {
//         console.log(response);
//     },
//     successmultiple: function (file, response) {
//         if (response.success) {
//             swal("Success", response.msg, "success");
//             window.location.reload();
//         }
//         if (!response.success) {
//             swal("Error", response.msg, "error");
//         }
//     },
//     completemultiple: function (file, response) {},
//     reset: function () {
//         this.removeAllFiles(true);
//     },
// });

var modalTemplate = $("#product_cropper_modal");

// myDropzone.on("thumbnail", function (file) {
//     if (file.cropped) return;
//
//     var cachedFilename = file.name;
//     myDropzone.removeFile(file);
//
//     var $cropperModal = $(modalTemplate);
//     var $uploadCrop = $cropperModal.find("#product_crop");
//
//     $cropperModal.find(".product_preview_div").empty();
//
//     var $img = document.getElementById("product_sample_image");
//
//     var reader = new FileReader();
//     reader.onloadend = function () {
//         $($img).attr("src", reader.result);
//         $cropperModal.modal("show");
//         modalTemplate.on("shown.bs.modal", function () {
//             cropper = new Cropper($img, {
//                 initialAspectRatio: 1,
//                 viewMode: 3,
//                 preview: ".product_preview_div",
//             });
//         });
//     };
//     reader.readAsDataURL(file);
//
//     $uploadCrop.on("click", function () {
//         var blob = cropper.getCroppedCanvas().toDataURL();
//         var newFile = dataURItoBlob(blob);
//         newFile.cropped = true;
//         newFile.name = cachedFilename;
//
//         myDropzone.addFile(newFile);
//         $cropperModal.modal("hide");
//         cropper.destroy();
//         cropper = null;
//     });
// });
modalTemplate.on("hidden.bs.modal", function () {
    console.log(cropper);
    if (typeof cropper !== "undefined") {
        if (copper !== null) {
            // cropper.destroy();
            cropper = null;
        }
    }
});
// transform cropper dataURI output to a Blob which Dropzone accepts
function dataURItoBlob(dataURI) {
    var byteString = atob(dataURI.split(",")[1]);
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }
    return new Blob([ab], { type: "image/jpeg" });
}

$(document).on("submit", "form#quick_add_product_class_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $(".view_modal").modal("hide");
                var class_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/product-class/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#product_class_id").empty().append(data_html);
                        $("#product_class_id").selectpicker("refresh");
                        $("#product_class_id").val(class_id).change();
                    },
                });
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});
var sub_category_id = null;
$(document).on("submit", "form#quick_add_category_form", function (e) {
    e.preventDefault();
    var data = new FormData(this);

    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        data: data,
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $(".view_modal").modal("hide");
                var category_id = result.category_id;
                sub_category_id = result.sub_category_id;
                $.ajax({
                    method: "get",
                    url:
                        "/category/get-dropdown?product_class_id=" +
                        $("#product_class_id").val(),
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#category_id").empty().append(data_html);
                        $("#category_id").selectpicker("refresh");
                        if (category_id) {
                            $("#category_id").val(category_id).change();
                        }
                        if (sub_category_id) {
                            $("#sub_category_id").val(sub_category_id);
                        }
                    },
                });
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});
//
$(document).ready(function() {
    var product_class_id =$('#product_class_id').val();
    var category_id=$('#category_value_id').attr('data-category_id');
    var sub_category_id=$('#sub_category_id_data').attr('data-sub_category_id')
    console.log(category_id)
    $.ajax({
        method: "get",
        url:
            "/category/get-dropdown?product_class_id=" +product_class_id+"&type=category",
        data: {},
        contentType: "html",
        success: function (result) {

            console.log(result)
            $("#sub_category_id").selectpicker("val", sub_category_id).change();
            $("#sub_category_id").selectpicker("refresh");

            $("#category_id").empty().append(result).change();
            $("#category_id").selectpicker("refresh");
            // $("#category_id").val(category_id);

            if (category_id) {
                $("select#category_id").selectpicker("val", category_id).change();
            }
        },
    });
})
$(document).on("change", "#product_class_id", function () {
    $.ajax({
        method: "get",
        url:
            "/category/get-dropdown?product_class_id=" +
            $("#product_class_id").val()+"&type=category",
        data: {},
        contentType: "html",
        success: function (result) {
            $("#category_id").empty().append(result).change();
            $("#category_id").selectpicker("refresh");

            if (category_id) {
                $("#category_id").selectpicker("val", category_id);
            }
        },
    });
});

$(document).on("change", "#category_id", function () {
    var sub_category_id=$('#sub_category_id_data').attr('data-sub_category_id')
    $.ajax({
        method: "get",
        url:
            "/category/get-sub-category-dropdown?category_id=" +
            $("#category_id").val(),
        data: {},
        contentType: "html",
        success: function (result) {
            // console.log(result)
            $("#sub_category_id").empty().append(result).change();
            $("#sub_category_id").selectpicker("refresh");

            if (sub_category_id) {

                $("#sub_category_id").selectpicker("val", sub_category_id);
            }
        },
    });
});
$(document).on("click", ".add_discount_row", function () {
    let row_id = parseInt($("#raw_discount_index").val());
    $("#raw_discount_index").val(row_id + 1);

    $.ajax({
        method: "get",
        url: "/product/get-raw-discount",
        data: { row_id: row_id },
        success: function (result) {
            $("#consumption_table_discount > tbody").prepend(result);
            $(".selectpicker").selectpicker("refresh");
            // $(".datepicker").datepicker("refresh");
            $(".datepicker").datepicker({refresh:"refresh",todayHighlight: true});
            // $(".raw_material_unit_id").selectpicker("refresh");
        },
    });
});
var brand_id = null;
$(document).on("submit", "form#quick_add_brand_form", function (e) {
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $(".view_modal").modal("hide");
                brand_id = result.brand_id;
                get_brand_dropdown();
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});

function get_brand_dropdown() {
    let category_id = $("#category_id").val();
    let sub_category_id = $("#sub_category_id").val();
    $.ajax({
        method: "get",
        url: "/brand/get-dropdown",
        data: {},
        contactType: "html",
        success: function (data_html) {
            $("#brand_id").empty().append(data_html);
            $("#brand_id").selectpicker("refresh");
            if (brand_id) {
                $("#brand_id").selectpicker("val", brand_id);
            }
        },
    });
}
$(document).on("submit", "form#quick_add_tax_form", function (e) {
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $(".view_modal").modal("hide");
                var tax_id = result.tax_id;
                $.ajax({
                    method: "get",
                    url: "/tax/get-dropdown",
                    data: { type: "product_tax" },
                    contactType: "html",
                    success: function (data_html) {
                        $("#tax_id").empty().append(data_html);
                        $("#tax_id").selectpicker("refresh");
                        $("#tax_id").selectpicker("val", tax_id);
                    },
                });
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});
$(document).on("submit", "form#quick_add_supplier_form", function (e) {
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $(".view_modal").modal("hide");
                var supplier_id = result.supplier_id;
                $.ajax({
                    method: "get",
                    url: "/supplier/get-dropdown",
                    data: { type: "product_tax" },
                    contactType: "html",
                    success: function (data_html) {
                        $("#supplier_id").empty().append(data_html);
                        $("#supplier_id").selectpicker("refresh");
                        $("#supplier_id").selectpicker("val", supplier_id);
                    },
                });
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});
var multiple_units_array = [];
$("#multiple_units").change(function () {
    multiple_units_array.push($(this).val());
});
$(document).on("submit", "form#quick_add_unit_form", function (e) {
    $("form#quick_add_unit_form").validate();
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $(".view_modal").modal("hide");
                var unit_id = result.unit_id;
                multiple_units_array.push(unit_id);
                $.ajax({
                    method: "get",
                    url: "/unit/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#multiple_units").empty().append(data_html);
                        $("#multiple_units").selectpicker("refresh");
                        $("#multiple_units").selectpicker(
                            "val",
                            multiple_units_array
                        );
                        $("select.unit_id").empty().append(data_html);
                        $("select.unit_id").selectpicker("refresh");
                        $("select#multiple_units").change();
                    },
                });
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});
var multiple_colors_array = [];
$("#multiple_colors").change(function () {
    multiple_colors_array.push($(this).val());
});
$(document).on("submit", "form#quick_add_color_form", function (e) {
    $("form#quick_add_color_form").validate();
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $(".view_modal").modal("hide");
                var color_id = result.color_id;
                multiple_colors_array.push(color_id);
                $.ajax({
                    method: "get",
                    url: "/color/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#multiple_colors").empty().append(data_html);
                        $("#multiple_colors").selectpicker("refresh");
                        $("#multiple_colors").selectpicker(
                            "val",
                            multiple_colors_array
                        );
                    },
                });
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});
var multiple_sizes_array = [];
$("#multiple_sizes").change(function () {
    multiple_sizes_array.push($(this).val());
});
$(document).on("submit", "form#quick_add_size_form", function (e) {
    $("form#quick_add_size_form").validate();
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $(".view_modal").modal("hide");
                var size_id = result.size_id;
                multiple_sizes_array.push(size_id);
                $.ajax({
                    method: "get",
                    url: "/size/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#multiple_sizes").empty().append(data_html);
                        $("#multiple_sizes").selectpicker("refresh");
                        $("#multiple_sizes").selectpicker(
                            "val",
                            multiple_sizes_array
                        );
                    },
                });
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});
var multiple_grades_array = [];
$("#multiple_grades").change(function () {
    multiple_grades_array.push($(this).val());
});
$(document).on("submit", "form#quick_add_grade_form", function (e) {
    $("form#quick_add_grade_form").validate();
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $(".view_modal").modal("hide");
                var grade_id = result.grade_id;
                multiple_grades_array.push(grade_id);
                $.ajax({
                    method: "get",
                    url: "/grade/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#multiple_grades").empty().append(data_html);
                        $("#multiple_grades").selectpicker("refresh");
                        $("#multiple_grades").selectpicker(
                            "val",
                            multiple_grades_array
                        );
                    },
                });
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});

$("#expiry_date").change(function () {
    if (
        $(this).val() != undefined &&
        $(this).val() != "" &&
        $(this).val() != null
    ) {
        $(".warning").removeClass("hide");
        $(".convert_status_expire").removeClass("hide");
    } else {
        $(".warning").addClass("hide");
        $(".convert_status_expire").addClass("hide");
    }
});

$(document).on("change", "#sell_price", function () {
    $(".store_prices").val($(this).val());
});
$(document).on("change", "#sku", function () {
    let sku = $(this).val();

    $.ajax({
        method: "get",
        url: "/product/check-sku/" + sku,
        data: {},
        success: function (result) {
            console.log(result.success);
            if (!result.success) {
                swal("Error", result.msg, "error");
            }
        },
    });
});
$(document).on("change", "#purchase_price", function () {
    $(".default_purchase_price").val($(this).val());
});
$(document).on("change", "#sell_price", function () {
    $(".default_sell_price").val($(this).val());
});
$(document).on("click", ".delete-image", function () {
    let url = $(this).attr("data-href");
    let images_div = $(this).parent(".images_div");

    $.ajax({
        method: "get",
        url: url,
        data: {},
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $(images_div).remove();
            }
            if (!result.success) {
                swal("Error", result.msg, "error");
            }
        },
    });
});
$(document).on("change", "select.raw_material_id", function () {
    let tr = $(this).closest("tr");
    let raw_material_id = $(this).val();

    $.ajax({
        method: "get",
        url: "/product/get-raw-material-details/" + raw_material_id,
        data: {},
        success: function (result) {
            tr.find(".raw_material_price").val(
                result.raw_material.purchase_price
            );
            tr.find(".raw_material_unit_id").val(
                result.raw_material.multiple_units[0]
            );
            tr.find(".raw_material_unit_id").selectpicker("refresh");
            tr.find(".unit_label").text(
                tr.find("select.raw_material_unit_id option:selected").text()
            );
        },
    });
});

$(document).on("click", ".add_raw_material_row", function () {
    let row_id = parseInt($("#raw_material_row_index").val());
    $("#raw_material_row_index").val(row_id + 1);

    $.ajax({
        method: "get",
        url: "/product/get-raw-material-row",
        data: { row_id: row_id },
        success: function (result) {
            $("#consumption_table > tbody").prepend(result);
            $(".selectpicker").selectpicker("refresh");
            $(".raw_material_unit_id").selectpicker("refresh");
        },
    });
});
$(document).on(
    "change",
    ".raw_material_quantity, .raw_material_id, .raw_material_unit_id, #price_based_on_raw_material, #other_cost ",
    function () {
        calculate_price_base_on_raw_material();
    }
);
function calculate_price_base_on_raw_material() {
    if ($("#price_based_on_raw_material").prop("checked")) {
        $("#automatic_consumption").prop("checked", true);
        let total_raw_material_price = 0;
        $("#consumption_table > tbody > tr").each(function () {
            let raw_material_price = __read_number(
                $(this).find(".raw_material_price")
            );
            let raw_material_quantity = __read_number(
                $(this).find(".raw_material_quantity")
            );
            let raw_material_total = raw_material_price * raw_material_quantity;
            total_raw_material_price += raw_material_total;

            $(this)
                .find(".cost_label")
                .text(__currency_trans_from_en(raw_material_total, false));
        });
        let other_cost = __read_number($("#other_cost"));
        total_raw_material_price += other_cost;
        __write_number($("#purchase_price"), total_raw_material_price);
    } else {
        __write_number($("#purchase_price"), 0);
    }
    $("#purchase_price").change();
}
$(document).on("click", ".remove_raw_material_btn", function () {
    calculate_price_base_on_raw_material();
});
$(document).ready(function () {
    $("#discount").change();
    $("#consumption_table > tbody > tr").each(function () {
        let raw_material_price = __read_number(
            $(this).find(".raw_material_price")
        );
        let raw_material_quantity = __read_number(
            $(this).find(".raw_material_quantity")
        );
        let raw_material_total = raw_material_price * raw_material_quantity;

        $(this)
            .find(".cost_label")
            .text(__currency_trans_from_en(raw_material_total, false));
    });
});
$(document).on("change", "#discount", function () {
    let discount = __read_number($(this));
    if (discount > 0) {
        $("select#discount_customer_types").attr("required", true);
    } else {
        $("select#discount_customer_types").attr("required", false);
    }
});
$(document).on("change", "#is_service", function () {
    if ($(this).prop("checked")) {
        $(".supplier_div").removeClass("hide");
    } else {
        $(".supplier_div").addClass("hide");
    }
});
$(document).on("change", "#sell_price", function () {
    let sell_price = __read_number($(this));
    let purchase_price = __read_number($("#purchase_price"));

    if (sell_price < purchase_price) {
        swal(LANG.warning, LANG.sell_price_less_than_purchase_price, "warning");
        return;
    }
});
$(document).on("change",".is_discount_permenant",function () {
    $(this).closest("tr").find(".discount_start_date").prop('disabled', (i, v) => !v);
    $(this).closest("tr").find(".discount_start_date").val(null);
    $(this).closest("tr").find(".discount_end_date").prop('disabled', (i, v) => !v);
    $(this).closest("tr").find(".discount_end_date").val(null);
});

// $(document).on("change", "#name", function () {
//     let name=$(this).val();
//     $("#variation_table > tbody > tr").each(function () {
//         alert($(this).find('.v_sub_sku').val())
//         if($(this).find('.v_sub_sku').val()==$('#sku').val()){
            
//             $(this).find('.v_name').val(name);
//         }
//     });
// });