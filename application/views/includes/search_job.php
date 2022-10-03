<div class="n_search">
    <div class="n_findkey_contain">
        <input id="findkeyjob" class="n_key" type="text" placeholder="Nhập từ khóa mong muốn..." value='<?= isset($key) ? $key : '' ?>' oninput="this.value = this.value.replace(/^[' '.]/g, '');">
        <div class="autocomplete_tag" id="autocomplete_tag">
        </div>
    </div>
    <?php
    $list_tag = array_column(list_category_tag(), 'tag_name');
    $list_tag = json_encode($list_tag);
    ?>
    <script>
        var list_tag = <?= $list_tag ?>;
        localStorage.setItem("list_tag", list_tag);
    </script>
    <select id="n_cate" class="n_city">
        <option data-tokens="0" value="0">Chọn ngành nghề</option>
        <?php $category = list_category();
        foreach ($category as $value) : ?>
            <option <?= (isset($nn) && $value['cat_id'] == $nn) ? 'selected' : '' ?> value="<?= $value['cat_id'] ?>"><?= $value['cat_name'] ?></option>
        <?php endforeach; ?>
    </select>
    <select id="n_city" class="n_city">
        <option data-tokens="0" value="0">Tỉnh thành</option>
        <?php
        $cities = all_city();
        foreach ($cities as $key => $value) :
        ?>
            <option <?= (isset($tt) && $key == $tt) ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
        <?php endforeach; ?>
    </select>
    <button class="n_tim_kiem"> Tìm kiếm </button>
</div>
<div class="city_district">
    <div id="district">
        <p class="city_box_right_txt">Địa điểm nổi bật</p>
        <div class="city_box_right_content">
            <div class="district_col">
                <div class="district_col_title" onclick="city_click(1)">Hà Nội</div>
                <div class="district_col_txt" onclick="district_click(72)">Hai Bà Trưng</div>
                <div class="district_col_txt" onclick="district_click(70)">Cầu Giấy</div>
                <div class="district_col_txt" onclick="district_click(78)">Nam Từ Liêm</div>
                <div class="district_col_txt" onclick="district_click(69)">Long Biên</div>
                <div class="district_col_txt" onclick="district_click(74)">Thanh Xuân</div>
                <div class="district_col_txt" onclick="district_click()">Hoàng Mai</div>
            </div>
            <div class="district_col">
                <div class="district_col_title" onclick="city_click(45)">Hồ Chí Minh</div>
                <div class="district_col_txt" onclick="district_click(636)">Huyện Bình Chánh</div>
                <div class="district_col_txt" onclick="district_click(638)">Huyện Cần Giờ</div>
                <div class="district_col_txt" onclick="district_click(615)">Quận 1</div>
                <div class="district_col_txt" onclick="district_click(624)">Quận 2</div>
                <div class="district_col_txt" onclick="district_click(629)">Quận 5</div>
                <div class="district_col_txt" onclick="district_click(626)">Quận 10</div>
            </div>
            <div class="district_col">
                <div class="district_col_title" onclick="city_click(26)">Đà Nẵng</div>
                <div class="district_col_txt" onclick="district_click(427)">Huyện Cẩm Lệ</div>
                <div class="district_col_txt" onclick="district_click(424)">Huyện Hải Châu</div>
                <div class="district_col_txt" onclick="district_click(428)">Huyện Hòa Vang</div>
                <div class="district_col_txt" onclick="district_click(422)">Quận Liên Chiểu</div>
                <div class="district_col_txt" onclick="district_click(426)">Quận Ngũ Hành Sơn</div>
                <div class="district_col_txt" onclick="district_click(423)">Quận Thanh Khê</div>
            </div>
        </div>
    </div>
    <div class="city">
        <p class="city_box_right_txt">Danh sách địa điểm</p>
        <div id="city_lq"></div>
    </div>
    <img class="n_close_city_box" src="/images/n_icon_plus_black.svg">
</div>
<div class="drop_cate">
</div>