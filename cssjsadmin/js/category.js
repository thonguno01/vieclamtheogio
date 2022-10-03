$(document).ready(function () {
    $("#add_edit_manufacturer").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.wrap("<div class='vld-error'>")
        },
        rules: {
            "name": {
                required: true,
            },
        },
        messages: {
            "name": {
                required: 'Tên hãng sản xuất không được để trống',
            },
        },
        submitHandler: function(form) {
            $.ajax({
                url: '/Admin/ajax_add_edit_manufacturer',
                type: 'POST',
                dataType: 'json',
                data: {
                  id: $("#id").val(),
                  name: $("#name").val(),
                  status: $("#status").val(),
                  submit: $("#submit").val(),
                 },
                success: function(res) {
                    console.log(res);
                    if (res.kq == true) {
                        alert(res.msg);
                       window.location.href ="/admin/list_manufacturer";
                    }else{
                        alert(res.msg);
                    }
                }            
            });
        }
    });
    $("#add_edit_category").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.wrap("<div class='vld-error'>")
        },
        rules: {
            "name": {
                required: true,
            },
        },
        messages: {
            "name": {
                required: 'Tên loại sản phẩm không được để trống',
            },
        },
        submitHandler: function(form) {
            $.ajax({
                url: '/Admin/ajax_add_edit_category',
                type: 'POST',
                dataType: 'json',
                data: {
                  id: $("#id").val(),
                  name: $("#name").val(),
                  status: $("#status").val(),
                  submit: $("#submit").val(),
                 },
                success: function(res) {
                    console.log(res);
                    if (res.kq == true) {
                        alert(res.msg);
                       window.location.href ="/admin/list_category";
                    }else{
                        alert(res.msg);
                    }
                }            
            });
        }
    });
    $("#add_edit_ray").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.wrap("<div class='vld-error'>")
        },
        rules: {
            "name": {
                required: true,
            },
        },
        messages: {
            "name": {
                required: 'Tên loại tia không được để trống',
            },
        },
        submitHandler: function(form) {
            $.ajax({
                url: '/Admin/ajax_add_edit_ray',
                type: 'POST',
                dataType: 'json',
                data: {
                  id: $("#id").val(),
                  name: $("#name").val(),
                  status: $("#status").val(),
                  submit: $("#submit").val(),
                 },
                success: function(res) {
                    console.log(res);
                    if (res.kq == true) {
                        alert(res.msg);
                       window.location.href ="/admin/list_ray_type";
                    }else{
                        alert(res.msg);
                    }
                }            
            });
        }
    });
    $("#add_edit_style").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.wrap("<div class='vld-error'>")
        },
        rules: {
            "name": {
                required: true,
            },
        },
        messages: {
            "name": {
                required: 'Tên kiểu dáng không được để trống',
            },
        },
        submitHandler: function(form) {
            $.ajax({
                url: '/Admin/ajax_add_edit_style',
                type: 'POST',
                dataType: 'json',
                data: {
                  id: $("#id").val(),
                  name: $("#name").val(),
                  status: $("#status").val(),
                  submit: $("#submit").val(),
                 },
                success: function(res) {
                    console.log(res);
                    if (res.kq == true) {
                        alert(res.msg);
                       window.location.href ="/admin/list_style";
                    }else{
                        alert(res.msg);
                    }
                }            
            });
        }
    });
    $("#add_edit_connect").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.wrap("<div class='vld-error'>")
        },
        rules: {
            "name": {
                required: true,
            },
        },
        messages: {
            "name": {
                required: 'Tên kiểu dáng không được để trống',
            },
        },
        submitHandler: function(form) {
            $.ajax({
                url: '/Admin/ajax_add_edit_connector',
                type: 'POST',
                dataType: 'json',
                data: {
                  id: $("#id").val(),
                  name: $("#name").val(),
                  status: $("#status").val(),
                  submit: $("#submit").val(),
                 },
                success: function(res) {
                    console.log(res);
                    if (res.kq == true) {
                        alert(res.msg);
                       window.location.href ="/admin/list_connector";
                    }else{
                        alert(res.msg);
                    }
                }            
            });
        }
    });
    $('.check-show').click(function() {
        var id = $(this).val();
        var action;
        if($(this).is(':checked')){
            action = 'show';
        }else{
            action = 'hidden';
        }
        $.ajax({
            url: '/Admin/index_product',
            type: 'POST',
            dataType: 'json',
            data: {id: id,action : action},
            success: function(res) {
                console.log(res);
                if (res.kq == true) {
                    location.reload();
                }
            }    
        });
    });
});