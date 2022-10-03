<? 
$list_city = array(
        1 => "Hà Nội",
        2 => "Hồ Chí Minh",
        3 => "An Giang",
        4 => "Bà Rịa Vũng Tàu",
        5 => "Bắc Cạn",
        6 => "Bắc Giang",
        7 => "Bạc Liêu",
        8 => "Bắc Ninh",
        9 => "Bến Tre",
        10 => "Biên Hòa",
        11 => "Bình Định",
        12 => "Bình Dương",
        13 => "Bình Phước",
        14 => "Bình Thuận",
        15 => "Cà Mau",
        16 => "Cần Thơ",
        17 => "Cao Bằng",
        18 => "Đà Nẵng",
        19 => "Đắc Lắc",
        20 => "Điện Biên",
        21 => "Đồng Nai",
        22 => "Đồng Thap",
        23 => "Gia Lai",
        24 => "Hà Giang",
        25 => "Hà Nam",
        26 => "Hà Tĩnh",
        27 => "Hải Dương",
        28 => "Hải Phòng",
        29 => "Hòa Bình",
        30 => "Huế ",
        31 => "Hưng Yên",
        32 => "Khánh Hòa",
        33 => "Kon Tum",
        34 => "Lai Châu",
        35 => "Lâm Đồng",
        36 => "Lào Cai",
        37 => "Long An",
        38 => "Nam Định",
        39 => "Nghệ An",
        40 => "Ninh Bình",
        41 => "Ninh Thuận",
        42 => "Phú Thọ",
        43 => "Phú Yên",
        44 => "Quảng Bình",
        45 => "Quảng Nam",
        46 => "Quảng Ngãi",
        47 => "Quảng Ninh",
        48 => "Quảng Trị",
        49 => "Sóc Trăng",
        50 => "Sơn La",
        51 => "Tây Ninh",
        52 => "Thái Bình",
        53 => "Thái Nguyên",
        54 => "Thanh Hóa",
        55 => "Tiền Giang",
        56 => "Trà Vinh",
        57 => "Tuyên Quang",
        58 => "Kiên Giang",
        59 => "Vĩnh Long",
        60 => "Vĩnh Phúc",
        61 => "Yên Bái",
        62 => "Khác "
);
function select_field($name,$array_value,$checked_value,$check=1){
?>
	<select name="<?=$name?>" id="<?=$name?>" onchange="loadState()">
			<?
			if($check !=1 ){
			?>
				<?
				foreach($array_value as $key => $value){
						?><option value="<?=$key?>" <? if(getValue($name,"int","POST")==$key) echo "selected";?>><?=$value?></option><?
				}
				?>
			<?
			}else{
			?>
				<?
				foreach($array_value as $key => $value){
				?><option value="<?=$key?>" <? if($checked_value == $key) echo "selected";?>><?=$value?></option><?
				}
				?>
			<?
			}
			?>
	</select>
<? 
}
function show_select_field($name,$array_value,$checked_value,$check=1){
?>
	<select name="<?=$name?>" id="<?=$name?>" >
            <option value="">Tỉnh/TP</option>
			<?
			if($check !=1 ){
			?>
				<?
				foreach($array_value as $key => $value){
						?><option value="<?=$key?>" <? if(getValue($name,"int","POST")==$key) echo "selected";?>><?=$value?></option><?
				}
				?>
			<?
			}else{
			?>
				<?
				foreach($array_value as $key => $value){
				?><option value="<?=$key?>" <? if($checked_value == $key) echo "selected";?>><?=$value?></option><?
				}
				?>
			<?
			}
			?>
	</select>
<? 
}