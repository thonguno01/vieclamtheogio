<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Quản lý tài khoản
            <small>Thêm tài khoản admin</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Quản lý tài khoản</a></li>
            <li><a href="">Danh sách</a></li>
        </ol>
    </section>

    <div class="container">
        <div class="admin_avatar">
            <div class="admin_avatar_img">
                <img id="preview_logo" src="/images/n_defaul_avatar.svg">
            </div>
            <div class="admin_avatar_up">
                <label for="up_photo"><img src="/images/n_icon_cam_plus.svg"></label>
            </div>
            <input hidden id="up_photo" type="file" onchange="loadFile(event)" >
        </div>
        <div class="row">  
            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Username</span>
                <input type="text" class="form-control username_admin" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                <p class="admin_eror n_eror_username"></p>
            </div>
            
            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Name</span>
                <input type="text" class="form-control name_admin" placeholder="Name" aria-label="Name" aria-describedby="basic-addon1">
                <p class="admin_eror n_eror_name"></p>
            </div>
            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Email</span>
                <input type="text" class="form-control email_admin" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
                <p class="admin_eror n_eror_email"></p>
            </div>
            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Password</span>
                <input type="password" class="form-control pass_admin" placeholder="Phone" aria-label="Password" aria-describedby="basic-addon1">
                <p class="admin_eror n_eror_pass"></p>
            </div>
            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Rep Password</span>
                <input type="password" class="form-control re_pass_admin" placeholder="Email" aria-label="Rep Password" aria-describedby="basic-addon1">
                <p class="admin_eror n_eror_rep_pass"></p>
            </div>
            <div class="input-group mb-3 col-sm-6">
                <span class="input-group-text" id="basic-addon1">Phone</span>
                <input type="text" class="form-control phone_admin" placeholder="Email" aria-label="Phone" aria-describedby="basic-addon1">
                <p class="admin_eror n_eror_phone"></p>
            </div>
            <div class="dky_ntd_info status_acc mb-3">
                    <input type="radio" name="role_acc" value="0" hidden>
            </div>
            <button type="button" class="btn btn-primary add_new">Add new</button>
        </div>
    </div>
</div>