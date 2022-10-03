$(document).ready(function () {
    CKEDITOR.replace( 'review_product' );
    $('.select').select2();
    $('#price_old').keyup(function(){
        var price_old = parseInt($(this).val());
        var discount = $('#discount').val();    
        if(discount == 0 || discount == '' || discount == null){
            $('#price_new').val(price_old);
        }else{
            price_old = price_old.replace(/\D/g, "");
            var price_new = price_old * ((100 - discount)/100);
            price_new = replaceMoney(price_new);
            $('#price_new').val(price_new);
        }

    });
    $('#discount').keyup(function(){
        var price_old = parseInt($('#price_old').val());
        var discount = $(this).val();
        if(discount > 100){
            alert('Vui lòng nhập lại giảm giá');
            $(this).val('0');
        }
        var price_new = price_old * ((100 - discount)/100);
        $('#price_new').val(price_new); 
    });
    $('#discount').change(function(){
        var price_old = parseInt($('#price_old').val());
        var discount = $(this).val();
        if(discount > 100){
            alert('Vui lòng nhập lại giảm giá');
            $(this).val('0');
        }
        price_old = price_old.slice(0,-4);
        var price_new = price_old * ((100 - discount)/100);
        price_new = price_new.toFixed(3)
        price_new += '.000';
        $('#price_new').val(price_new);
    });
    // replace money
    // var price_res = document.querySelectorAll("#price_old");
    // for(price_re of price_res){
    //     price_re.onkeyup = formatCurrency;
    // }

    function formatCurrency(event){
        var input_var = event.target.value;
        if (input_var !=="") {
            event.target.value = input_var.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    }
    function replaceMoney(value){
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $("#add_product").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.wrap("<div class='vld-error'>")
        },
        rules: {
            "code_product": {
                required: true,
            },
            "name": {
                required: true,
            },
            "category": {
                required: true,
            },
            "ray_style": {
                required: true,
            },
            "manufacturer": {
                required: true,
            },
            "style": {
                required: true,
            },
            "connector": {
                required: true,
            },
            "price_old": {
                required: true,
            },
            "quantity": {
                required: true,
            },
            "parameter": {
                required: true,
            },
            "thuong_hieu": {
                required: true,
            },
            "model": {
                required: true,
            },
            "do_tuong_phan": {
                required: true,
            },
            "doc_ma_vach": {
                required: true,
            },
            "chan_de": {
                required: true,
            },
            "dien_ap": {
                required: true,
            },
            "cong_giao_tiep": {
                required: true,
            },
            "do_phan_giai": {
                required: true,
            },
            "do_ben": {
                required: true,
            },
            "goc_quet": {
                required: true,
            },
            "trong_luong": {
                required: true,
            },
            "kich_thuoc": {
                required: true,
            },
            "mau_sac": {
                required: true,
            },
            "phu_kien": {
                required: true,
            },
            "xuat_xu": {
                required: true,
            },
            "bao_hanh": {
                required: true,
            },
            "cong_nghe_quet": {
                required: true,
            },
            "title": {
                required: true,
            },
            "description": {
                required: true,
            },
            "keyword": {
                required: true,
            },
        },
        messages: {
            "code_product": {
                required: "Thông tin không được để trống",
            },
            "name": {
                required: "Thông tin không được để trống",
            },
            "category": {
                required: "Thông tin không được để trống",
            },
            "ray_style": {
                required: "Thông tin không được để trống",
            },
            "manufacturer": {
                required: "Thông tin không được để trống",
            },
            "style": {
                required: "Thông tin không được để trống",
            },
            "connector": {
                required: "Thông tin không được để trống",
            },
            "price_old": {
                required: "Thông tin không được để trống",
            },
            "quantity": {
                required: "Thông tin không được để trống",
            },
            "parameter": {
                required: "Thông tin không được để trống",
            },
            "thuong_hieu": {
                required: "Thông tin không được để trống",
            },
            "model": {
                required: "Thông tin không được để trống",
            },
            "do_tuong_phan": {
                required: "Thông tin không được để trống",
            },
            "doc_ma_vach": {
                required: "Thông tin không được để trống",
            },
            "chan_de": {
                required: "Thông tin không được để trống",
            },
            "dien_ap": {
                required: "Thông tin không được để trống",
            },
            "cong_giao_tiep": {
                required: "Thông tin không được để trống",
            },
            "do_phan_giai": {
                required: "Thông tin không được để trống",
            },
            "do_ben": {
                required: "Thông tin không được để trống",
            },
            "goc_quet": {
                required: "Thông tin không được để trống",
            },
            "trong_luong": {
                required: "Thông tin không được để trống",
            },
            "kich_thuoc": {
                required: "Thông tin không được để trống",
            },
            "mau_sac": {
                required: "Thông tin không được để trống",
            },
            "phu_kien": {
                required: "Thông tin không được để trống",
            },
            "xuat_xu": {
                required: "Thông tin không được để trống",
            },
            "bao_hanh": {
                required: "Thông tin không được để trống",
            },
            "cong_nghe_quet": {
                required: "Thông tin không được để trống",
            },
            "title": {
                required: "Thông tin không được để trống",
            },
            "description": {
                required: "Thông tin không được để trống",
            },
            "keyword": {
                required: "Thông tin không được để trống",
            },
        },
        submitHandler: function(formData) {
            // var a = document.querySelector("#add_product");
            // var b = a.querySelectorAll('[name]');
            // var formData = {};
            // for(isb of b){
            //     formData[isb.name] = isb.value;
            // }
            // var img = $('#image')[0].files[0];
            // formData["image"] = img;
            var fileUpload = $("#des_images");
            if (parseInt(fileUpload.get(0).files.length) > 3) {
                alert("Tối đa 3 ảnh"); return false;
            }
            var formData = new FormData();
            var review_product = CKEDITOR.instances.review_product.getData();
            formData.append('code_product', $('#code_product').val());
            formData.append('name', $('#name').val());
            formData.append('status', $('#status').val());
            formData.append('category', $('#category').val());
            formData.append('ray_style', $('#ray_style').val());
            formData.append('manufacturer', $('#manufacturer').val());
            formData.append('style', $('#style').val());
            formData.append('connector', $('#connector').val());
            formData.append('price_old', $('#price_old').val());
            formData.append('quantity', $('#quantity').val());
            formData.append('discount', $('#discount').val());
            formData.append('price_new', $('#price_new').val());
            formData.append('parameter', $('#parameter').val());
            formData.append('thuong_hieu', $('#thuong_hieu').val());
            formData.append('do_phan_giai', $('#do_phan_giai').val());
            formData.append('model', $('#model').val());
            formData.append('do_ben', $('#do_ben').val());
            formData.append('cong_nghe_quet', $('#cong_nghe_quet').val());
            formData.append('goc_quet', $('#goc_quet').val());
            formData.append('do_tuong_phan', $('#do_tuong_phan').val());
            formData.append('trong_luong', $('#trong_luong').val());
            formData.append('doc_ma_vach', $('#doc_ma_vach').val());
            formData.append('kich_thuoc', $('#kich_thuoc').val());
            formData.append('chan_de', $('#chan_de').val());
            formData.append('mau_sac', $('#mau_sac').val());
            formData.append('dien_ap', $('#dien_ap').val());
            formData.append('phu_kien', $('#phu_kien').val());
            formData.append('bao_hanh', $('#bao_hanh').val());
            formData.append('xuat_xu', $('#xuat_xu').val());
            formData.append('cong_giao_tiep', $('#cong_giao_tiep').val());
            formData.append('review_product', review_product);
            formData.append('tags', $('#tags').val().join());
            formData.append('title', $('#title').val());
            formData.append('description', $('#description').val());
            formData.append('keyword', $('#keyword').val());
            formData.append('image', $('#image')[0].files[0]);

            var totalfiles = document.getElementById('des_images').files.length;
            for (var index = 0; index < totalfiles; index++) {
              formData.append("des_images[]", document.getElementById('des_images').files[index]);
           }
            $.ajax({
                url: '/Admin/ajax_add_product',
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(res) {
                    // console.log(res);
                    if (res.kq == true) {
                        alert(res.msg);
                       window.location.href ="/admin/list_product";
                    }else{
                        alert(res.msg);
                    }
                }            
            });
            
        }
    });
    $("#edit_product").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.wrap("<div class='vld-error'>")
        },
        rules: {
            "code_product": {
                required: true,
            },
            "name": {
                required: true,
            },
            "category": {
                required: true,
            },
            "ray_style": {
                required: true,
            },
            "manufacturer": {
                required: true,
            },
            "style": {
                required: true,
            },
            "connector": {
                required: true,
            },
            "price_old": {
                required: true,
            },
            "quantity": {
                required: true,
            },
            "parameter": {
                required: true,
            },
            "thuong_hieu": {
                required: true,
            },
            "model": {
                required: true,
            },
            "do_tuong_phan": {
                required: true,
            },
            "doc_ma_vach": {
                required: true,
            },
            "chan_de": {
                required: true,
            },
            "dien_ap": {
                required: true,
            },
            "cong_giao_tiep": {
                required: true,
            },
            "do_phan_giai": {
                required: true,
            },
            "do_ben": {
                required: true,
            },
            "goc_quet": {
                required: true,
            },
            "trong_luong": {
                required: true,
            },
            "kich_thuoc": {
                required: true,
            },
            "mau_sac": {
                required: true,
            },
            "phu_kien": {
                required: true,
            },
            "xuat_xu": {
                required: true,
            },
            "bao_hanh": {
                required: true,
            },
            "cong_nghe_quet": {
                required: true,
            },
            "title": {
                required: true,
            },
            "description": {
                required: true,
            },
            "keyword": {
                required: true,
            },
        },
        messages: {
            "code_product": {
                required: "Thông tin không được để trống",
            },
            "name": {
                required: "Thông tin không được để trống",
            },
            "category": {
                required: "Thông tin không được để trống",
            },
            "ray_style": {
                required: "Thông tin không được để trống",
            },
            "manufacturer": {
                required: "Thông tin không được để trống",
            },
            "style": {
                required: "Thông tin không được để trống",
            },
            "connector": {
                required: "Thông tin không được để trống",
            },
            "price_old": {
                required: "Thông tin không được để trống",
            },
            "quantity": {
                required: "Thông tin không được để trống",
            },
            "parameter": {
                required: "Thông tin không được để trống",
            },
            "thuong_hieu": {
                required: "Thông tin không được để trống",
            },
            "model": {
                required: "Thông tin không được để trống",
            },
            "do_tuong_phan": {
                required: "Thông tin không được để trống",
            },
            "doc_ma_vach": {
                required: "Thông tin không được để trống",
            },
            "chan_de": {
                required: "Thông tin không được để trống",
            },
            "dien_ap": {
                required: "Thông tin không được để trống",
            },
            "cong_giao_tiep": {
                required: "Thông tin không được để trống",
            },
            "do_phan_giai": {
                required: "Thông tin không được để trống",
            },
            "do_ben": {
                required: "Thông tin không được để trống",
            },
            "goc_quet": {
                required: "Thông tin không được để trống",
            },
            "trong_luong": {
                required: "Thông tin không được để trống",
            },
            "kich_thuoc": {
                required: "Thông tin không được để trống",
            },
            "mau_sac": {
                required: "Thông tin không được để trống",
            },
            "phu_kien": {
                required: "Thông tin không được để trống",
            },
            "xuat_xu": {
                required: "Thông tin không được để trống",
            },
            "bao_hanh": {
                required: "Thông tin không được để trống",
            },
            "cong_nghe_quet": {
                required: "Thông tin không được để trống",
            },
            "title": {
                required: "Thông tin không được để trống",
            },
            "description": {
                required: "Thông tin không được để trống",
            },
            "keyword": {
                required: "Thông tin không được để trống",
            },
        },
        submitHandler: function(formData) {
            // var a = document.querySelector("#add_product");
            // var b = a.querySelectorAll('[name]');
            // var formData = {};
            // for(isb of b){
            //     formData[isb.name] = isb.value;
            // }
            // var img = $('#image')[0].files[0];
            // formData["image"] = img;
            var fileUpload = $("#des_images");
            if (parseInt(fileUpload.get(0).files.length)>3) {
                alert("Tối đa 3 ảnh"); return false;
            }
            var formData = new FormData();
            var review_product = CKEDITOR.instances.review_product.getData();
            formData.append('id', $('#id').val());
            formData.append('code_product', $('#code_product').val());
            formData.append('name', $('#name').val());
            formData.append('status', $('#status').val());
            formData.append('category', $('#category').val());
            formData.append('ray_style', $('#ray_style').val());
            formData.append('manufacturer', $('#manufacturer').val());
            formData.append('style', $('#style').val());
            formData.append('connector', $('#connector').val());
            formData.append('price_old', $('#price_old').val());
            formData.append('quantity', $('#quantity').val());
            formData.append('discount', $('#discount').val());
            formData.append('price_new', $('#price_new').val());
            formData.append('parameter', $('#parameter').val());
            formData.append('thuong_hieu', $('#thuong_hieu').val());
            formData.append('do_phan_giai', $('#do_phan_giai').val());
            formData.append('model', $('#model').val());
            formData.append('do_ben', $('#do_ben').val());
            formData.append('cong_nghe_quet', $('#cong_nghe_quet').val());
            formData.append('goc_quet', $('#goc_quet').val());
            formData.append('do_tuong_phan', $('#do_tuong_phan').val());
            formData.append('trong_luong', $('#trong_luong').val());
            formData.append('doc_ma_vach', $('#doc_ma_vach').val());
            formData.append('kich_thuoc', $('#kich_thuoc').val());
            formData.append('chan_de', $('#chan_de').val());
            formData.append('mau_sac', $('#mau_sac').val());
            formData.append('dien_ap', $('#dien_ap').val());
            formData.append('phu_kien', $('#phu_kien').val());
            formData.append('bao_hanh', $('#bao_hanh').val());
            formData.append('xuat_xu', $('#xuat_xu').val());
            formData.append('cong_giao_tiep', $('#cong_giao_tiep').val());
            formData.append('review_product', review_product);
            formData.append('tags', $('#tags').val().join());
            formData.append('title', $('#title').val());
            formData.append('description', $('#description').val());
            formData.append('keyword', $('#keyword').val());
            formData.append('image', $('#image')[0].files[0]);

           var totalfiles = document.getElementById('des_images').files.length;
            for (var index = 0; index < totalfiles; index++) {
              formData.append("des_images[]", document.getElementById('des_images').files[index]);
           }
            $.ajax({
                url: '/Admin/ajax_edit_product',
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(res) {
                    console.log(res);
                    if (res.kq == true) {
                        alert(res.msg);
                       window.location.href ="/admin/list_product";
                    }else{
                        alert(res.msg);
                    }
                }            
            });
            
        }
    });
});

// 2500 :giá cũ
// 32: %
// 2500*(100-32)/100= 