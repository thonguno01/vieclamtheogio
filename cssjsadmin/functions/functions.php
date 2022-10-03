<?php
function getmail($string)
{
    $emails = '';
    foreach (preg_split('/\s/', $string) as $token) {
        $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        if ($email !== false) {
            $emails[] = $email;
        }
    }
    return $emails;
}
function gethumbnail($url, $nameimg, $timeimage, $width2, $height2, $optimize)
{
    $url = str_replace("..", "", $url);
    $url2 = ".." . $url;
    if (file_exists($url2)) {
        if (count(getimagesize($url2)) > 1) {
            if ($timeimage == 0) {
                $time = explode("/", $url);
                $year = $time[2];
                $month = $time[3];
                $day = $time[4];
            } else {
                $day           = date("d", $timeimage);
                $month         = date("m", $timeimage);
                $year          = date("Y", $timeimage);
            }
            if ($width2 == 0 && $height2 == 0 && $optimize == 0) {
                $linkimg = $url;
                $linkpath = '';
            } else {
                $linka = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/" . $nameimg;
                $linkpath = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/";
                if (!file_exists($linka)) {
                    is_dir($linkpath) || @mkdir($linkpath, 0777, true) || die("Can't Create folder");
                    $linkimg = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/" . $nameimg;
                    $urlrw = ".." . $url;
                    $folder = str_replace($nameimg, "", $urlrw);
                    resize_image($folder, $nameimg, $width2, $height2, $optimize, '', $linkpath);
                } else {
                    $linkimg = $linka;
                }
            }
        } else {
            $linkimg = '/images/noimage.png';
        }
    } else {
        $linkimg = '/images/noimage.png';
    }
    return $linkimg;
}
function gethumbnailuv($url, $nameimg, $timeimage, $width2, $height2, $optimize)
{
    $url = str_replace("..", "", $url);
    $url2 = ".." . $url;
    if (file_exists($url2)) {
        if (count(getimagesize($url2)) > 1) {
            if ($timeimage == 0) {
                $time = explode("/", $url);
                $year = $time[2];
                $month = $time[3];
                $day = $time[4];
            } else {
                $day           = date("d", $timeimage);
                $month         = date("m", $timeimage);
                $year          = date("Y", $timeimage);
            }
            if ($width2 == 0 && $height2 == 0 && $optimize == 0) {
                $linkimg = $url;
                $linkpath = '';
            } else {
                $linka = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/" . $nameimg;
                $linkpath = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/";
                if (!file_exists($linka)) {
                    is_dir($linkpath) || @mkdir($linkpath, 0777, true) || die("Can't Create folder");
                    $linkimg = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/" . $nameimg;
                    $urlrw = ".." . $url;
                    $folder = str_replace($nameimg, "", $urlrw);
                    resize_image($folder, $nameimg, $width2, $height2, $optimize, '', $linkpath);
                } else {
                    $linkimg = $linka;
                }
            }
        } else {
            $linkimg = '/images/man-01.png';
        }
    } else {
        $linkimg = '/images/man-01.png';
    }
    return $linkimg;
}
function gethumbnail58($url, $nameimg, $timeimage, $width2, $height2, $optimize)
{
    $url = str_replace("..", "", $url);
    $url2 = ".." . $url;
    if (file_exists($url2)) {
        if (count(getimagesize($url2)) > 1) {
            if ($timeimage == 0) {
                $time = explode("/", $url);
                $year = $time[2];
                $month = $time[3];
                $day = $time[4];
            } else {
                $day           = date("d", $timeimage);
                $month         = date("m", $timeimage);
                $year          = date("Y", $timeimage);
            }
            if ($width2 == 0 && $height2 == 0 && $optimize == 0) {
                $linkimg = $url;
                $linkpath = '';
            } else {
                $linka = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/" . $nameimg;
                $linkpath = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/";
                if (!file_exists($linka)) {
                    is_dir($linkpath) || @mkdir($linkpath, 0777, true) || die("Can't Create folder");
                    $linkimg = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/" . $nameimg;
                    $urlrw = ".." . $url;
                    $folder = str_replace($nameimg, "", $urlrw);
                    resize_image($folder, $nameimg, $width2, $height2, $optimize, '', $linkpath);
                } else {
                    $linkimg = $linka;
                }
            }
        } else {
            $linkimg = '/images/no58.png';
        }
    } else {
        $linkimg = '/images/no58.png';
    }
    return $linkimg;
}
function gethumbnailcom($url, $nameimg, $timeimage, $width2, $height2, $optimize)
{
    $url = str_replace("..", "", $url);
    $url2 = ".." . $url;
    if (file_exists($url2)) {
        if (count(getimagesize($url2)) > 1) {
            if ($timeimage == 0) {
                $time = explode("/", $url);
                $year = $time[2];
                $month = $time[3];
                $day = $time[4];
            } else {
                $day           = date("d", $timeimage);
                $month         = date("m", $timeimage);
                $year          = date("Y", $timeimage);
            }
            if ($width2 == 0 && $height2 == 0 && $optimize == 0) {
                $linkimg = $url;
                $linkpath = '';
            } else {
                $linka = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/" . $nameimg;
                $linkpath = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/";
                if (!file_exists($linka)) {
                    is_dir($linkpath) || @mkdir($linkpath, 0777, true) || die("Can't Create folder");
                    $linkimg = "../thumb/" . $year . "/" . $month . "/" . $day . "/" . $width2 . "/" . $height2 . "/" . $nameimg;
                    $urlrw = ".." . $url;
                    $folder = str_replace($nameimg, "", $urlrw);
                    resize_image($folder, $nameimg, $width2, $height2, $optimize, '', $linkpath);
                } else {
                    $linkimg = $linka;
                }
            }
        } else {
            $linkimg = '/images/nohome.jpg';
        }
    } else {
        $linkimg = '/images/nohome.jpg';
    }
    return $linkimg;
}
function name_company($name)
{
    $name = trim($name);
    $name = mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
    $name = str_replace("tnhh", "TNHH", $name);
    $name = str_replace("Tnhh", "TNHH", $name);
    $name = str_replace("cp", "CP", $name);
    $name = str_replace("Cp", "CP", $name);
    return $name;
}
function name_uv($name)
{
    $name = trim($name);
    $name = mb_strtolower($name, 'UTF-8');
    $name = mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
    return $name;
}
function generate_name($filename, $prefix = "")
{
    $name = "";
    for ($i = 0; $i < 3; $i++) {
        $name .= chr(rand(97, 122));
    }
    $today = getdate();
    if ($prefix == "")
        $name .= $today[0];
    else
        $name = $prefix . $name . $today[0];
    $ext = substr($filename, (strrpos($filename, ".") + 1));
    return $name . "." . $ext;
}
function clean_space($str)
{
    $str = utf8_decode($str);
    $str = str_replace("&nbsp;", "", $str);
    $str = preg_replace('/\s+/', ' ', $str);
    $str = trim($str);
    return $str;
}
function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1) {
        return '0 giây';
    }

    $a = array(
        365 * 24 * 60 * 60  =>  'năm',
        30 * 24 * 60 * 60  =>  'tháng',
        24 * 60 * 60  =>  'ngày',
        60 * 60  =>  'giờ',
        60  =>  'phút',
        1  =>  'giây'
    );
    $a_plural = array(
        'năm'  => 'năm',
        'tháng' => 'tháng',
        'ngày' => 'ngày',
        'giờ'  => 'giờ',
        'phút' => 'phút',
        'giây' => 'giây'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' trước';
        }
    }
}
function time_elapsed_string_2($ptime)
{
    $etime = $ptime - time();

    if ($etime < 1) {
        return '0';
    }

    $a = array(
        365 * 24 * 60 * 60  =>  'năm',
        30 * 24 * 60 * 60  =>  'tháng',
        24 * 60 * 60  =>  'ngày',
        60 * 60  =>  'giờ',
        60  =>  'phút',
        1  =>  'giây'
    );
    $a_plural = array(
        'năm'  => 'năm',
        'tháng' => 'tháng',
        'ngày' => 'ngày',
        'giờ'  => 'giờ',
        'phút' => 'phút',
        'giây' => 'giây'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str);
        }
    }
}
function geturlimageAvatar($timeimage)
{
    $month  = date('m', $timeimage);
    $year   = date('Y', $timeimage);
    $day    = date('d', $timeimage);
    $dir        = "../pictures/" . $year . "/" . $month . "/" . $day . "/"; // Full Path
    is_dir($dir) || @mkdir($dir, 0777, true) || die("Can't Create folder");
    return $dir;
}
function getimageuv($timeimage)
{
    $month  = date('m', $timeimage);
    $year   = date('Y', $timeimage);
    $day    = date('d', $timeimage);
    $dir        = "../pictures/uv/" . $year . "/" . $month . "/" . $day . "/"; // Full Path
    is_dir($dir) || @mkdir($dir, 0777, true) || die("Can't Create folder");
    return $dir;
}
function getcvuv($timeimage)
{
    $month  = date('m', $timeimage);
    $year   = date('Y', $timeimage);
    $day    = date('d', $timeimage);
    $dir        = "../pictures/cv/" . $year . "/" . $month . "/" . $day . "/"; // Full Path
    is_dir($dir) || @mkdir($dir, 0777, true) || die("Can't Create folder");
    return $dir;
}
function getcvuv2($timeimage)
{
    $month  = date('m', $timeimage);
    $year   = date('Y', $timeimage);
    $day    = date('d', $timeimage);
    $dir        = "/pictures/cv/" . $year . "/" . $month . "/" . $day . "/"; // Full Path
    return $dir;
}
function getlogouv($timeimage)
{
    $month  = date('m', $timeimage);
    $year   = date('Y', $timeimage);
    $day    = date('d', $timeimage);
    $dir        = "/pictures/uv/" . $year . "/" . $month . "/" . $day . "/"; // Full Path
    return $dir;
}
function getlogo($timeimage)
{
    $img_first     = explode(',', $timeimage);
    $img_f_name    = $img_first[0];
    $time_img      = intval(preg_replace("/[^0-9]/i", "", $img_f_name));
    $day           = date("d", $time_img);
    $month         = date("m", $time_img);
    $year          = date("Y", $time_img);
    $get_full_path = "/pictures/vip/" . $year . "/" . $month . "/" . $day . "/" . $img_f_name;
    return $get_full_path;
}
function getimagemeta($timeimage)
{
    $month  = date('m', $timeimage);
    $year   = date('Y', $timeimage);
    $day    = date('d', $timeimage);
    $dir        = "../pictures/" . $year . "/" . $month . "/" . $day . "/"; // Full Path
    is_dir($dir) || @mkdir($dir, 0777, true) || die("Can't Create folder");
    return $dir;
}
function decodeHtmlEnt($str)
{
    $ret = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
    $p2 = -1;
    for (;;) {
        $p = strpos($ret, '&#', $p2 + 1);
        if ($p === FALSE)
            break;
        $p2 = strpos($ret, ';', $p);
        if ($p2 === FALSE)
            break;

        if (substr($ret, $p + 2, 1) == 'x')
            $char = hexdec(substr($ret, $p + 3, $p2 - $p - 3));
        else
            $char = intval(substr($ret, $p + 2, $p2 - $p - 2));

        //echo "$char\n";
        $newchar = iconv(
            'UCS-4',
            'UTF-8',
            chr(($char >> 24) & 0xFF) . chr(($char >> 16) & 0xFF) . chr(($char >> 8) & 0xFF) . chr($char & 0xFF)
        );
        //echo "$newchar<$p<$p2<<\n";
        $ret = substr_replace($ret, $newchar, $p, 1 + $p2 - $p);
        $p2 = $p + strlen($newchar);
    }
    return $ret;
}
function mb_ucfirst($string, $encoding)
{
    $strlen = mb_strlen($string, $encoding);
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}
function base64_url_encode($input)
{
    return strtr(base64_encode($input), '+/=', '_,-');
}

function base64_url_decode($input)
{
    return base64_decode(strtr($input, '_,-', '+/='));
}
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function arrss($item1, $item2)
{
    $abc = '';
    if ($item2 <= 3) {
        $abc = 2;
    } else if ($item2 > 3 && $item2 <= 5) {
        $abc = 3;
    } else if ($item2 > 5 && $item2 <= 7) {
        $abc = 4;
    } else if ($item2 > 7 && $item2 <= 10) {
        $abc = 5;
    } else if ($item2 > 10 && $item2 <= 15) {
        $abc = 6;
    } else if ($item2 > 15 && $item2 <= 20) {
        $abc = 7;
    } else if ($item2 > 20 && $item2 <= 30) {
        $abc = 8;
    } else if ($item2 > 30) {
        $abc = 9;
    }
    return $abc;
}
function getmoney222($string)
{
    $value = '';
    $string = trim($string);
    $string = removeHTML($string);
    $string = removeAccent($string);
    if (preg_match("/trieu/", $string) == true) {
        if (preg_match("/Hon/", $string) == true) {
            if (preg_match("VND", $string) == true) {
                $string = str_replace("VND", "", $string);
            }
            $string = str_replace("Hon", "", $string);
            $string = explode(",", $string);
            $string = $string[0];
            $value = arrss(0, $string);
        } else {
            $string = str_replace("trieu", "", $string);
            $string = trim($string);
            if (preg_match("/-/", $string) == true) {
                $arrmn = explode("-", $string);
                $onearr = explode(",", $arrmn[0]);
                $onearr = $onearr[0];
                $onearr = trim($onearr);
                $twoarr = explode(",", $arrmn[1]);
                $twoarr = $twoarr[0];
                $twoarr = trim($twoarr);
                $value =  arrss($onearr, $twoarr);
            } else {
                $onearr = explode(",", $string);
                $onearr = $onearr[0];
                $value = arrss(0, $onearr);
            }
        }
    } else if (preg_match("/VND/", $string) == true) {
        if (preg_match("/Hon/", $string) == true) {
            if (preg_match("VND", $string) == true) {
                $string = str_replace("VND", "", $string);
            }
            $string = str_replace("Hon", "", $string);
            $string = explode(",", $string);
            $string = $string[0];
            $value = arrss(0, $string + 1);
        } else {
            $string = str_replace("VND", "", $string);
            $string = trim($string);
            if (preg_match("/-/", $string) == true) {
                $arrmn = explode("-", $string);
                $onearr = explode(",", $arrmn[0]);
                $onearr = $onearr[0];
                $onearr = trim($onearr);
                $twoarr = explode(",", $arrmn[1]);
                $twoarr = $twoarr[0];
                $twoarr = trim($twoarr);
                $value =  arrss($onearr, $twoarr);
            } else {
                $onearr = explode(",", $string);
                $onearr = $onearr[0];
                $value = arrss(0, $onearr);
            }
        }
    } else if (preg_match("/Thuong luong/", $string) == true) {
        echo "Thỏa thuận";
        $value = 1;
    } else if (preg_match("/Canh tranh/", $string) == true) {
        echo "Thỏa thuận";
        $value = 1;
    } else if (preg_match("/USD/", $string) == true) {
        if (preg_match("/Hon/", $string) == true) {
            $string = str_replace("USD", "", $string);
            $string = str_replace("Hon", "", $string);
            $string = str_replace(",", "", $string);
            $string = $string * 22000;
            $string = number_format($string);
            $string = explode(",", $string);
            $string = $string[0];
            $value = arrss(0, $string + 2);
        } else {
            $string = str_replace("USD", "", $string);
            $string = str_replace(",", "", $string);
            if (preg_match("/-/", $string) == true) {
                $arrmn  = explode("-", $string);
                $oneusd = $arrmn[0] * 22000;
                $oneusd = number_format($oneusd);
                $onearr = explode(",", $oneusd);
                $onedola = $onearr[0];
                $twousd = $arrmn[1] * 22000;
                $twousd = number_format($twousd);
                $twoarr = explode(",", $twousd);
                $twodola = $twoarr[0];
                $value = arrss($onedola, $twodola);
            } else {
                $string = $string * 22000;
                $string = number_format($string);
                $string = explode(",", $string);
                $string = $string[0];
                $value = arrss(0, $string);
            }
        }
    }
    return $value;
}
function getforderimgone($img_name)
{
    $img_first     = explode(',', $img_name);
    $img_f_name    = $img_first[0];
    $time_img      = intval(preg_replace("/[^0-9]/i", "", $img_f_name));
    $day           = date("d", $time_img);
    $month         = date("m", $time_img);
    $year          = date("Y", $time_img);
    $get_full_path = "/pictures/pickfullsize/" . $year . "/" . $month . "/" . $day . "/" . $img_f_name;
    return $get_full_path;
}
function getforderimgmedium($img_name)
{
    $img_first     = explode(',', $img_name);
    $img_f_name    = $img_first[0];
    $time_img      = intval(preg_replace("/[^0-9]/i", "", $img_f_name));
    $day           = date("d", $time_img);
    $month         = date("m", $time_img);
    $year          = date("Y", $time_img);
    $get_full_path = "/pictures/pickmediumsize/" . $year . "/" . $month . "/" . $day . "/medium_" . $img_f_name;
    return $get_full_path;
}
function getforderimgtiny($img_name)
{
    $img_first     = explode(',', $img_name);
    $img_f_name    = $img_first[0];
    $time_img      = intval(preg_replace("/[^0-9]/i", "", $img_f_name));
    $day           = date("d", $time_img);
    $month         = date("m", $time_img);
    $year          = date("Y", $time_img);
    $get_full_path = "/pictures/picktinysize/" . $year . "/" . $month . "/" . $day . "/tiny_" . $img_f_name;
    return $get_full_path;
}
function getmoney($price, $type_pr)
{
    if ($type_pr == 1) {
        $price   = intval($price);
    }
    if ($type_pr == 0) {
        $price   = intval($price) * 22;
    }
    if ($type_pr == 1) {
        if (strlen($price) >= 4) {
            $res  = substr($price, 0, 1);
            $ris  = substr($price, strlen($price) - 3);
            $ras  = substr($ris, 0, 1);
            $ras1 = substr($ris, 1, 2);
            $ras2 = substr($ris, 2, 3);
            if ($ras == 0) {
                $ris = str_replace("0", "", $ris);
            }
            if ($ras1 == 0 && $ras == 0) {
                $ris = str_replace("0", "", $ris);
                $ris = str_replace("0", "");
            }
            if ($ras2 == 0 && $ras == 0 && $ras1 == 0) {
                $ris = str_replace("0", "", $ris);
                $ris = str_replace("0", "", $ris);
                $ris = str_replace("0", "", $ris);
            }
            return $res . " tỷ " . $ris . " triệu";
        } else {
            return $price . " triệu";
        }
    }
}
function cut_string2($str, $length, $char = "...")
{
    //Nếu chuỗi cần cắt nhỏ hơn $length thì return luôn
    $strlen    = mb_strlen($str, "UTF-8");
    if ($strlen <= $length) return $str;

    //Cắt chiều dài chuỗi $str tới đoạn cần lấy
    $substr    = mb_substr($str, 0, $length, "UTF-8");
    if (mb_substr($str, $length, 1, "UTF-8") == " ") return $substr . $char;

    //Xác định dấu " " cuối cùng trong chuỗi $substr vừa cắt
    $strPoint = mb_strrpos($substr, " ", "UTF-8");

    //Return string
    if ($strPoint < $length - 20) return $substr . $char;
    else return mb_substr($substr, 0, $strPoint, "UTF-8") . $char;
}

function getDomain($url)
{
    $url    = trim($url);
    if ($url == "") return "";

    $domain_return    = "";
    //$nowww			= ereg_replace('www\.', '', $url);
    /**
     * Edit 26/03/2014
     * Sửa hàm ereg_replace thành str_replace để cho khỏi lỗi
     */
    $nowww            = str_replace('www.', '', $url);
    $domain            = @parse_url($nowww);

    if ($domain !== false) {
        if (isset($domain["host"]) && $domain["host"] != "") $domain_return    = $domain["host"];
        elseif (isset($domain["path"]) && $domain["path"] != "") $domain_return    = $domain["path"];
    }

    return $domain_return;
}
function sw_get_current_weekday()
{
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $weekday = date("l");
    $weekday = strtolower($weekday);
    switch ($weekday) {
        case 'monday':
            $weekday = 'Thứ hai';
            break;
        case 'tuesday':
            $weekday = 'Thứ ba';
            break;
        case 'wednesday':
            $weekday = 'Thứ tư';
            break;
        case 'thursday':
            $weekday = 'Thứ năm';
            break;
        case 'friday':
            $weekday = 'Thứ sáu';
            break;
        case 'saturday':
            $weekday = 'Thứ bảy';
            break;
        default:
            $weekday = 'Chủ nhật';
            break;
    }
    return $weekday . ', ' . date('d/m/Y H:i') . " GTM+7";
}
function array_currency()
{
    $arrReturn    = array(0 => "USD", 1 => "EUR");
    return $arrReturn;
}

function array_language()
{
    $db_language    = new db_query("SELECT * FROM languages ORDER BY lang_id ASC");
    $arrReturn        = array();
    while ($row = mysql_fetch_array($db_language->result)) {
        $arrReturn[$row["lang_id"]] = array($row["lang_code"], $row["lang_name"]);
    }
    return $arrReturn;
}

function array_length_of_stay_tour()
{
    $arrReturn    = array(
        1 => "1 " . tdt("day"),
        2 => "2 - 5 " . tdt("days"),
        3 => "6 - 9 " . tdt("days"),
        4 => "10 - 16 " . tdt("days"),
        5 => "17 " . tdt("and_more_days"),
    );
    return $arrReturn;
}

function array_star_rating_hotel()
{
    $arrReturn    = array(
        2 => "2 " . tdt("stars"),
        3 => "3 " . tdt("stars"),
        4 => "4 " . tdt("stars"),
        5 => "5 " . tdt("stars"),
    );
    return $arrReturn;
}

function array_service()
{
    $arrReturn    = array(
        1 => tdt("Air_ticket"),
        2 => tdt("Train_ticket"),
        3 => tdt("Visa"),
        4 => tdt("Car_for_rent"),
    );
    return $arrReturn;
}

function callback($buffer)
{
    $str        = array("   ", chr(9), chr(10));
    $buffer    = str_replace($str, "", $buffer);
    return $buffer;
}

function check_email_address($email)
{
    //First, we check that there's one @ symbol, and that the lengths are right
    if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        //Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    //Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
            return false;
        }
    }
    if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
        //Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                return false;
            }
        }
    }
    return true;
}

function check_session_security($security_code)
{
    $return = 1;
    if (!isset($_SESSION["session_security_code"])) $_SESSION["session_security_code"] = generate_security_code();
    if ($security_code != $_SESSION["session_security_code"]) {
        $return = 0;
    }
    // Reset lại session security code
    $_SESSION["session_security_code"] = generate_security_code();
    return $return;
}

function count_online()
{
    $visited_timeout        = 10 * 60;
    $last_visited_time    = time();
    //Kiem tra co session_id hay ko, neu co
    if (session_id() != "") {
        $db_exec    = new db_execute("REPLACE INTO active_users(au_session_id, au_last_visit) VALUES('" . session_id() . "', " . $last_visited_time . ")");
        unset($db_exec);
    }
    // Delete timeout
    $db_exec    = new db_execute("DELETE FROM active_users WHERE au_last_visit < " . ($last_visited_time - $visited_timeout));
    unset($db_exec);
    // Select Count
    $db_count = new db_query("SELECT count(*) AS count FROM active_users");
    $row        = mysql_fetch_array($db_count->result);
    unset($db_count);
    // Return value
    return $row["count"];
}

function count_visited()
{
    $db_count    = new db_query("SELECT vis_counter FROM visited");
    $row = mysql_fetch_array($db_count->result);
    unset($db_count);
    return $row["vis_counter"];
}

function cut_string($str, $length, $char = " ...")
{
    //Nếu chuỗi cần cắt nhỏ hơn $length thì return luôn
    $strlen    = mb_strlen($str, "UTF-8");
    if ($strlen <= $length) return $str;

    //Cắt chiều dài chuỗi $str tới đoạn cần lấy
    $substr    = mb_substr($str, 0, $length, "UTF-8");
    if (mb_substr($str, $length, 1, "UTF-8") == " ") return $substr . $char;

    //Xác định dấu " " cuối cùng trong chuỗi $substr vừa cắt
    $strPoint = mb_strrpos($substr, " ", "UTF-8");

    //Return string
    if ($strPoint < $length - 20) return $substr . $char;
    else return mb_substr($substr, 0, $strPoint, "UTF-8") . $char;
}

function format_number($number, $num_decimal = 2, $edit = 0)
{
    if ($edit == 0) {
        $return    = number_format($number, $num_decimal, ",", ".");
        $stt    = -1;
        for ($i = $num_decimal; $i > 0; $i--) {
            $stt++;
            if (intval(substr($return, -$i, $i)) == 0) {
                $return = number_format($number, $stt, ",", ".");
                break;
            }
        }
        return $return;
    } else {
        $return    = number_format($number, 2, ".", ",");
        if (intval(substr($return, -2, 2)) == 0) $return = number_format($number, 0, ".", ",");
        return $return;
    }
}

function format_currency($value = "")
{
    $str        =    $value;
    if ($value != "") {
        $str        =    number_format(round($value / 1000) * 1000, 0, "", ",");
    }
    return $str;
}

function generate_array_variable($variable)
{
    $list            = tdt($variable);
    $arrTemp        = explode("{-break-}", $list);
    $arrReturn    = array();
    for ($i = 0; $i < count($arrTemp); $i++) $arrReturn[$i] = trim($arrTemp[$i]);
    return $arrReturn;
}

function generate_security_code()
{
    $code    = rand(1000, 9999);
    return $code;
}

function getURL($serverName = 0, $scriptName = 0, $fileName = 1, $queryString = 1, $varDenied = '')
{
    $url     = '';
    $slash = '/';
    if ($scriptName != 0) $slash    = "";
    if ($serverName != 0) {
        if (isset($_SERVER['SERVER_NAME'])) {
            $url .= 'http://' . $_SERVER['SERVER_NAME'];
            if (isset($_SERVER['SERVER_PORT'])) $url .= ":" . $_SERVER['SERVER_PORT'];
            $url .= $slash;
        }
    }
    if ($scriptName != 0) {
        if (isset($_SERVER['SCRIPT_NAME']))    $url .= substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
    }
    if ($fileName    != 0) {
        if (isset($_SERVER['SCRIPT_NAME']))    $url .= substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
    }
    if ($queryString != 0) {
        $url .= '?';
        reset($_GET);
        $i = 0;
        if ($varDenied != '') {
            $arrVarDenied = explode('|', $varDenied);
            while (list($k, $v) = each($_GET)) {
                if (array_search($k, $arrVarDenied) === false) {
                    $i++;
                    if ($i > 1) $url .= '&' . $k . '=' . @urlencode($v);
                    else $url .= $k . '=' . @urlencode($v);
                }
            }
        } else {
            while (list($k, $v) = each($_GET)) {
                $i++;
                if ($i > 1) $url .= '&' . $k . '=' . @urlencode($v);
                else $url .= $k . '=' . @urlencode($v);
            }
        }
    }
    $url = str_replace('"', '&quot;', strval($url));
    return $url;
}

function getURLhoakhoi($serverName = 0, $scriptName = 0, $fileName = 1, $queryString = 1, $varDenied = '')
{
    $url     = '';
    $slash = '/';
    if ($scriptName != 0) $slash    = "";
    if ($serverName != 0) {
        if (isset($_SERVER['SERVER_NAME'])) {
            $url .= 'http://' . $_SERVER['SERVER_NAME'];
            if (isset($_SERVER['SERVER_PORT'])) $url .= ":" . $_SERVER['SERVER_PORT'];
            $url .= $slash;
        }
    }
    if ($scriptName != 0) {
        if (isset($_SERVER['SCRIPT_NAME']))    $url .= substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
    }
    if ($fileName    != 0) {
        if (isset($_SERVER['SCRIPT_NAME']))    $url .= substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
    }
    if ($queryString != 0) {
        $url .= '?';
        reset($_GET);
        $i = 0;
        if ($varDenied != '') {
            $arrVarDenied = explode('|', $varDenied);
            while (list($k, $v) = each($_GET)) {
                if (array_search($k, $arrVarDenied) === false) {
                    $i++;
                    if ($i > 1) $url .= '&' . $k . '=' . @urlencode($v);
                    else $url .= $k . '=' . @urlencode($v);
                }
            }
        } else {
            while (list($k, $v) = each($_GET)) {
                $i++;
                if ($i > 1) $url .= '&' . $k . '=' . @urlencode($v);
                else $url .= $k . '=' . @urlencode($v);
            }
        }
    }
    $url = str_replace('"', '&quot;', strval($url));
    return $url;
}

function getValue($value_name, $data_type = "int", $method = "GET", $default_value = 0, $advance = 0)
{
    $value = $default_value;
    switch ($method) {
        case "GET":
            if (isset($_GET[$value_name])) $value = $_GET[$value_name];
            break;
        case "POST":
            if (isset($_POST[$value_name])) $value = $_POST[$value_name];
            break;
        case "COOKIE":
            if (isset($_COOKIE[$value_name])) $value = $_COOKIE[$value_name];
            break;
        case "SESSION":
            if (isset($_SESSION[$value_name])) $value = $_SESSION[$value_name];
            break;
        default:
            if (isset($_GET[$value_name])) $value = $_GET[$value_name];
            break;
    }
    /**
     * Edit 26/03/2014
     * - Sửa lại để không dính lỗi trên PHP 5.4 với hàm strval khi get arr
     */
    $data_type = trim(strtolower($data_type));
    switch ($data_type) {
        case 'int':
            $returnValue = intval($value);
            break;
        case 'str':
            $returnValue = strval($value);
            break;
        case 'flo':
            $returnValue = floatval($value);
            break;
        case 'dbl':
            $returnValue = doubleval($value);
            break;
        case 'arr':
            $returnValue = $value;
            break;
        default:
            //Nếu mặc định ko truyền data_type thì là kiểu int
            $returnValue = intval($value);
            break;
    }
    //Check xem có cần format giá trị trả về hay không??
    if ($advance != 0 && is_string($returnValue)) {
        switch ($advance) {
            case 1:
                $returnValue = replaceMQ($returnValue);
                break;
            case 2:
                $returnValue = htmlspecialbo($returnValue);
                break;
        }
    }
    //Do số quá lớn nên phải kiểm tra trước khi trả về giá trị
    if (($data_type != "str") && !is_array($returnValue) && (strval($returnValue) == "INF")) return 0;
    return $returnValue;
    /*
	$valueArray	= array("int" => intval($value), "str" => trim(strval($value)), "flo" => floatval($value), "dbl" => doubleval($value), "arr" => $value);
	foreach($valueArray as $key => $returnValue){
		if($data_type == $key){
			if($advance != 0){
				switch($advance){
					case 1:
						$returnValue = replaceMQ($returnValue);
						break;
					case 2:
						$returnValue = htmlspecialbo($returnValue);
						break;
				}
			}
			//Do số quá lớn nên phải kiểm tra trước khi trả về giá trị
			if((strval($returnValue) == "INF") && ($data_type != "str")) return 0;
			return $returnValue;
			break;
		}
	}
	return (intval($value));
   */
}

function get_server_name()
{
    $server = $_SERVER['SERVER_NAME'];
    if (strpos($server, "asiaqueentour.com") !== false) return "http://www.asiaqueentour.com";
    else return "http://" . $server . ":" . $_SERVER['SERVER_PORT'];
}

function htmlspecialbo($str)
{
    $arrDenied    = array('<', '>', '\"', '"');
    $arrReplace    = array('&lt;', '&gt;', '&quot;', '&quot;');
    $str = str_replace($arrDenied, $arrReplace, $str);
    return $str;
}

function javascript_writer($str)
{
    $mytextencode = "";
    for ($i = 0; $i < strlen($str); $i++) {
        $mytextencode .= ord(substr($str, $i, 1)) . ",";
    }
    if ($mytextencode != "") $mytextencode .= "32";
    return "<script language='javascript'>document.write(String.fromCharCode(" . $mytextencode . "));</script>";
}

function lang_path()
{
    global $lang_id;
    global $array_lang;
    global $con_root_path;
    $default_lang = 1;
    $path    = ($lang_id == $default_lang) ? $con_root_path : $con_root_path . $array_lang[$lang_id][0] . "/";
    return $path;
}

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function random()
{
    $rand_value = "";
    $rand_value .= rand(1000, 9999);
    $rand_value .= chr(rand(65, 90));
    $rand_value .= rand(1000, 9999);
    $rand_value .= chr(rand(97, 122));
    $rand_value .= rand(1000, 9999);
    $rand_value .= chr(rand(97, 122));
    $rand_value .= rand(1000, 9999);
    return $rand_value;
}

function redirect($url)
{
    $url    = htmlspecialbo($url);
    echo '<script type="text/javascript">window.location.href = "' . $url . '";</script>';
    exit();
}

function removeAccent($mystring)
{
    $marTViet = array(
        // Chữ thường
        "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
        "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
        "ì", "í", "ị", "ỉ", "ĩ",
        "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ",
        "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
        "ỳ", "ý", "ỵ", "ỷ", "ỹ",
        "đ", "Đ", "'",
        // Chữ hoa
        "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
        "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
        "Ì", "Í", "Ị", "Ỉ", "Ĩ",
        "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
        "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
        "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
        "Đ", "Đ", "'"
    );
    $marKoDau = array(
        /// Chữ thường
        "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
        "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
        "i", "i", "i", "i", "i",
        "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
        "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
        "y", "y", "y", "y", "y",
        "d", "D", "",
        //Chữ hoa
        "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
        "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
        "I", "I", "I", "I", "I",
        "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
        "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
        "Y", "Y", "Y", "Y", "Y",
        "D", "D", "",
    );
    return str_replace($marTViet, $marKoDau, $mystring);
}

function removeHTML($string)
{
    $string = preg_replace('/<script.*?\>.*?<\/script>/si', ' ', $string);
    $string = preg_replace('/<style.*?\>.*?<\/style>/si', ' ', $string);
    $string = preg_replace('/<.*?\>/si', ' ', $string);
    $string = str_replace('&nbsp;', ' ', $string);
    $string = mb_convert_encoding($string, "UTF-8", "UTF-8");
    $string = str_replace(array(chr(9), chr(10), chr(13)), ' ', $string);
    for ($i = 0; $i <= 5; $i++) $string = str_replace('  ', ' ', $string);
    return $string;
}

function removeLink($string)
{
    $string = preg_replace('/<a.*?\>/si', '', $string);
    $string = preg_replace('/<\/a>/si', '', $string);
    return $string;
}

function replaceFCK($string, $type = 0)
{
    $array_fck    = array(
        "&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Egrave;", "&Eacute;", "&Ecirc;", "&Igrave;", "&Iacute;", "&Icirc;",
        "&Iuml;", "&ETH;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ugrave;", "&Uacute;", "&Yacute;", "&agrave;",
        "&aacute;", "&acirc;", "&atilde;", "&egrave;", "&eacute;", "&ecirc;", "&igrave;", "&iacute;", "&ograve;", "&oacute;",
        "&ocirc;", "&otilde;", "&ugrave;", "&uacute;", "&ucirc;", "&yacute;",
    );
    $array_text    = array(
        "À", "Á", "Â", "Ã", "È", "É", "Ê", "Ì", "Í", "Î",
        "Ï", "Ð", "Ò", "Ó", "Ô", "Õ", "Ù", "Ú", "Ý", "à",
        "á", "â", "ã", "è", "é", "ê", "ì", "í", "ò", "ó",
        "ô", "õ", "ù", "ú", "û", "ý",
    );
    if ($type == 1) $string = str_replace($array_fck, $array_text, $string);
    else $string = str_replace($array_text, $array_fck, $string);
    return $string;
}

function replaceJS($text)
{
    $arr_str = array("\'", "'", '"', "&#39", "&#39;", chr(10), chr(13), "\n");
    $arr_rep = array(" ", " ", '&quot;', " ", " ", " ", " ");
    $text        = str_replace($arr_str, $arr_rep, $text);
    $text        = str_replace("    ", " ", $text);
    $text        = str_replace("   ", " ", $text);
    $text        = str_replace("  ", " ", $text);
    return $text;
}

function replace_keyword_search($keyword, $lower = 1)
{
    if ($lower == 1) $keyword    = mb_strtolower($keyword, "UTF-8");
    $keyword    = replaceMQ($keyword);
    $arrRep    = array("'", '"', "-", "+", "=", "*", "?", "/", "!", "~", "#", "@", "%", "$", "^", "&", "(", ")", ";", ":", "\\", ".", ",", "[", "]", "{", "}", "‘", "’", '“', '”');
    $keyword    = str_replace($arrRep, " ", $keyword);
    $keyword    = str_replace("  ", " ", $keyword);
    $keyword    = str_replace("  ", " ", $keyword);
    return $keyword;
}

function replaceMQ($text)
{
    $text    = str_replace("\'", "'", $text);
    $text    = str_replace("'", "", $text);
    $text    = str_replace("\\", "", $text);
    $text = str_replace('"', "", $text);
    return $text;
}

function remove_magic_quote($str)
{
    $str = str_replace("\'", "'", $str);
    $str = str_replace("\&quot;", "&quot;", $str);
    $str = str_replace("\\\\", "\\", $str);
    return $str;
}

function tdt($variable)
{
    global $lang_display;
    if (isset($lang_display[$variable])) {
        if (trim($lang_display[$variable]) == "") {
            return "#" . $variable . "#";
        } else {
            $arrStr    = array("\\\\'", '\"');
            $arrRep    = array("\\'", '"');
            return str_replace($arrStr, $arrRep, $lang_display[$variable]);
        }
    } else {
        return "_@" . $variable . "@_";
    }
}

function isIE6()
{
    if (preg_match('/\bmsie 6/i', $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

function check_overflow_description($description, $width, $class_add = "description_overflow", $maxChar = 40)
{
    $count    = mb_strlen($description, "UTF-8");
    for ($i = 120; $i < 900; $i += 40) {
        if ($width < $i) break;
        $maxChar += 10;
    }
    $class    = ($count > $maxChar ? " " . $class_add : '');
    return $class;
}

function checktextlower($content = "")
{
    $content    =    str_replace(" ", "", $content);
    $array    =    str_split($content);
    $count    =    0;
    foreach ($array as $key => $value) {
        $asc    =    ord($value);
        if ($asc >= 65 && $asc <= 90)    $count++;
    }
    return $count;
}

//Replace " -> &quot; (chống phá ngoặc)
function removeQ($string)
{
    $string = str_replace('\"', '"', $string);
    $string = str_replace("\'", "'", $string);
    $string = str_replace("\&quot;", "&quot;", $string);
    $string = str_replace("\\\\", "\\", $string);
    return str_replace('"', "&quot;", $string);
}

/** Hàm ghi lượt xem tin tức**/
function check_visit_news($new_id, $last_count_visit)
{
    $count_visit = $last_count_visit + 1;
    $sql = "UPDATE news_visit SET nev_visit = " . $count_visit . " WHERE nev_id =" . $new_id;
    $db_news = new db_query($sql);
}
/**
 * Ham lay tin tuc
 * @param
 * new_id : id cu the cua tin tuc
 * start , limit : gioi han so tin tuc lay ra
 * hot : 1: chi lay tin hot , 0 : khong kiem tra tin hot
 * new_type : 0 : tin tuc , 1 : tin gioi thieu , 2 : giai phap marketing
 */
function get_news($new_id = 0, $start = 0, $limit = 1, $new_type = 0, $order = "", $keywords = "", $new_sub_type = false)
{
    $sql = "SELECT
	          *
	      FROM
	          news
	      INNER JOIN news_visit ON new_id = nev_id
	      WHERE new_active = 1 ";
    if ($new_id != 0) {
        $sql .= "AND new_id =" . $new_id . " ";
    } else {
        $sql    .=    " AND new_type = " . $new_type;
    }
    /*
	if($hot != 0){
	  $sql .= "AND new_is_hot = 1 ";
	}*/
    if ($new_sub_type !== false) {
        $sql    .=    " AND new_sub_type = " . intval($new_sub_type);
    }
    if ($keywords != "") {
        $sql .= " AND (
	      match(new_title,new_brief,new_description) against('" . $keywords . "')
	      OR new_title LIKE '%" . $keywords . "%'
	      OR new_brief LIKE '%" . $keywords . "%'
	      ) ";
    }


    $sql .= " ORDER BY " . $order . " new_is_hot DESC,new_up_time DESC,new_view DESC ";
    $sql .= " LIMIT " . $start . "," . $limit . " ";
    //echo $sql;
    $arr_size    =    array(
        "small", "medium", "init"
    );
    $path_img    =    "/pictures/news/";
    $db_news = new db_query($sql, __FILE__ . __LINE__, 'USE_SLAVE');
    $result = array();
    while ($row = mysql_fetch_assoc($db_news->result)) {
        foreach ($arr_size as $size) {
            $row['new_image_url_' . $size]    =    $path_img . $size . '_' . $row['new_image_url'];
        }
        $result[$row['new_id']] = $row;
    }
    unset($db_news);
    return $result;
}

function count_news($new_type = 0, $new_sub_type = false)
{
    $cond            =    "";
    if ($new_sub_type !== false) {
        $cond        =    " AND new_sub_type = " . intval($new_sub_type);
    }
    $sql            =    "SELECT COUNT(*) as count FROM news WHERE new_type = " . $new_type . " AND new_active = 1 " . $cond;
    $db_count    =    new db_count($sql);
    $total        =    $db_count->total;
    unset($db_count);
    return $total;
}

function show_page($total, $item_per_page, $current_page, $href = "/home/tintuc/")
{
    $str     =     '';
    if ($total <= 1) {
        return '';
    }
    if ($current_page == 1) {
        $str .= '<li class="onpage"><a>1</a></li>';
    } elseif ($current_page > 3) {
        $str .= '<li class="" ><a data-pjax="#page" href="' . $href . '1">1</a></li> ...';
    } else {
        $str .= '<li class=""><a data-pjax="#page" href="' . $href . '1">1</a></li>';
    }
    for ($i = 2; $i <= $total; $i++) {
        if ($i >= $current_page - 1 && $i <= $current_page + 2) {
            if ($i == $current_page) {
                $str .= '<li class="onpage"><a>' . $i . '</a></li>';
            } else {
                $str .= '<li class="" ><a data-pjax="#page" href="' . $href . $i . '">' . $i . '</a></li>';
            }
        }
    }
    if ($total >  $current_page + 2) {
        $str .= '... <li class=""><a data-pjax="#page" href="' . $href . $total . '">' . $total . '</a></li>';
    }
    return $str;
}
function winPromptLogin($myuser)
{
    $str = '';
    if ($myuser->logged == 0) {
        $str .= 'onclick="windowPrompt({ href: \'/includes_v2/inc_login.php\', ajax: true, width: 500, height: 200, });"';
    }
    return $str;
}
function inputCheckbox($number = 4)
{
    $str = '';
    for ($i = 1; $i <= $number; $i++) {
        $str .= '<input class="check" type="checkbox" checked="true" />';
        $str .= '<img class="checkimg" src="/themes/v2/img/checked.jpg" />';
    }
    return $str;
}
/** Hàm lấy website **/
function get_websites($web_id = 0, $start = 0, $limit = 1000, $conditions = '', $cat_value = 0, $order = '')
{
    global $ads_internal_website;
    global $ads_user_free;
    global $myuser;
    if (in_array($myuser->u_id, $ads_user_free)) {
        $conditions    .=    ' AND web_id IN (' . implode(',', $ads_internal_website) . ') ';
    }
    $sql =  "
	      SELECT
	          *,
	          IF(web_domain LIKE 'http://www.vatgia.com/%', 1, 0) AS vatgia
	      FROM
	          websites
	      WHERE
	          web_active = 1
	          AND web_suspend = 0
	          AND web_id > 0 " . $conditions;
    if ($web_id != 0) {
        $sql .= " AND web_id = " . $web_id . " ";
    }
    // ORDER
    $sql    .=    " ORDER BY vatgia DESC ";
    $sql    .=    ($order != '') ? ',' . $order : '';

    // LIMIT
    $sql    .= " LIMIT " . $start . "," . $limit . " ";

    //echo $sql;
    $db_web = new db_query($sql, __FILE__, "USE_SLAVE");
    $result = array();
    while ($row = mysql_fetch_assoc($db_web->result)) {
        if ($row['web_logo'] != '') {
            $row['web_logo'] = "/pictures/web_logo/" . $row['web_logo'];
        } else {
            $row['web_logo'] = "/pictures/web_logo/myad_gray_logo.png";
        }
        $result[$row['web_id']] = $row;
    }
    unset($db_web);
    return $result;
}

/** Hàm lấy Ads ***/
function get_ads($adv_id)
{
    $city_arr = array(
        '1' => 'Toàn Quốc',
        '2' => 'Miền Bắc',
        '3' => 'Miền Trung',
        '4' => 'Miền Nam',
    );
    $sql = "
            SELECT
                advertising.*,
                campaign.cam_name as campaign_name
            FROM
                advertising
                LEFT OUTER JOIN campaign ON adv_campaign_id = cam_id
            WHERE
                adv_id = " . $adv_id . "";
    $db_adv = new db_query($sql, __FILE__, "USE_SLAVE");
    $result = array();
    while ($row = mysql_fetch_assoc($db_adv->result)) {
        if ($row['adv_city'] != '') {
            $row['adv_city'] = explode(',', $row['adv_city']);
            $cities = '';
            foreach ($row['adv_city'] as $id => $city) {
                $cities .= $city_arr[$city] . ",";
            }
            $row['adv_city'] = $cities;
        }
        $days = round(($row['adv_end'] - $row['adv_start']) / 86400);
        $row['adv_run_day'] = $days . " ngày từ " . date("d-m-Y", $row['adv_start']) . " đến " . date("d-m-Y", $row['adv_end']);
        $img_name = $row['adv_picture'];
        $row['adv_picture'] = "/pictures/ads_upload/" . $img_name;
        $row['adv_picture_awtop'] = "/pictures/ads_upload/alwaystop_" . $img_name;
        $row['adv_sale_percent'] = format_number(100 - ($row['adv_price'] * 100 / $row['adv_original_price']), 0);
        $web_name = explode('/', $row['adv_link']);
        if ($web_name[0] == "http:" || $web_name[0] == "https:" || $web_name[0] == "ftp:" || $web_name[0] == "ftps:") {
            $row['adv_web_name'] = $web_name[2];
        } else {
            $row['adv_web_name'] = $web_name[0];
        }
        $result[$row['adv_id']] = $row;
    }
    unset($db_adv);
    return $result;
}

/** Hàm lấy Category website ***/
function get_categories_web($cat_id = 0)
{
    $sql = "
            SELECT
                *
            FROM
                categories_ads
            WHERE
                caa_active = 1";
    if ($cat_id != 0) {
        $sql .= " AND caa_id = " . replaceMQ($cat_id) . " ";
    }
    $db_category = new db_query($sql, __FILE__, "USE_SLAVE");
    $result = array();
    while ($row = mysql_fetch_assoc($db_category->result)) {
        if (!file_exists('../pictures/categories_icon/small_' . $row['caa_icon']) || $row['caa_icon'] == '') {
            $row['caa_icon'] = '/pictures/categories_icon/orange_logo.png';
        } else {
            $row['caa_icon'] = '/pictures/categories_icon/small_' . $row['caa_icon'];
        }
        if ($cat_id != 0)
            $result = $row;
        else
            $result[$row['caa_id']] = $row;
    }
    unset($db_category);
    return $result;
}

/** Hàm lấy list chiến dịch ***/
function get_campaign($user_id)
{
    $sql = "
            SELECT
                *,IF(cam_total_adv >= " . MAX_ADV_CAMPAIGN . ",1,0) as total_order
            FROM
                campaign
            WHERE
                cam_user_id =" . replaceMQ($user_id) . "
            GROUP BY
            	cam_id
            ORDER BY
                total_order ASC, cam_id DESC
                ";
    $db_campaign = new db_query($sql, __FILE__, "USE_SLAVE");
    $result = array();
    while ($row = mysql_fetch_assoc($db_campaign->result)) {
        $result[$row['cam_id']] = $row;
    }
    unset($db_campaign);
    return $result;
}

function average($arr_1, $arr_2, $edit = 0)
{
    $arrNew = array();
    foreach ($arr_1 as $key => $value) {
        if ($arr_2[$key] > 0) {
            if ($edit != 0) {
                $value = $value * 100;
            }
            $temp = format_number($value / $arr_2[$key], 2, 1);
            $temp = floatval($temp);
        } else {
            $temp = 0;
        }
        array_push($arrNew, $temp);
    }
    return $arrNew;
}

/*
function get_total_click($start, $end){
    $clicks = array();
    for( $i = 0; $i < 100; $i++ ){
        $sql = '
            SELECT
                aus_website,
                count(aus_id) as total_click,
                sum(aus_money) as total_money
            FROM
                ads_user_spent_' . $i . '
            WHERE
                aus_time >= ' . $start . '
                AND aus_time <= ' . $end . '
            GROUP BY
                aus_website
        ';
        $re = new db_query($sql, __FILE__.__LINE__, 'USE_SLAVE');

        while( $row = mysql_fetch_assoc( $re->result ) ){
            //debug( $row );
            if( !isset( $clicks[$row['aus_website']] ) ){
                $clicks[$row['aus_website']]['website_id'] = $row['aus_website'];
                $clicks[$row['aus_website']]['click'] = 0;
                $clicks[$row['aus_website']]['money'] = 0;
            }
            $clicks[$row['aus_website']]['click'] += $row['total_click'];
            $clicks[$row['aus_website']]['money'] += $row['total_money'];
        }
    }
    return $clicks;
}
*/
function cate(&$cats, $parrent_id = 0, $id = 0)
{
    if (is_array($cats) && !empty($cats)) {
        if ($parrent_id == 0) {
            foreach ($cats as $id => $cat) {
                if ($cat['cat_parent_id'] > 0) {
                    cate($cats, $cat['cat_parent_id'], $id);
                }
            }
        } else {
            if (isset($cats[$parrent_id])) {
                $cats[$parrent_id]['childs'][$id] = $cats[$id];
                unset($cats[$id]);
            }
        }
    } else {
    }
}

function get_category_website($web_id)
{
    $sql = '
    SELECT
        *
    FROM
        categories_website_' . replaceMQ($web_id) . '
    WHERE
        cat_active = 1
    ORDER BY
   	    cat_order ASC,
        cat_parent_id ASC
';
    $db = new db_query($sql, __FILE__ . __LINE__, 'USE_SLAVE');
    $cats = array();
    if (mysql_num_rows($db->result) > 0) {
        while ($row = mysql_fetch_assoc($db->result)) {
            $cats[$row['cat_id']] = $row;
        }
        cate($cats);
        //debug( $cats );
    }
    return $cats;
}

function remove_http($link)
{
    $str = explode('/', $link);
    if ($str[0] == 'http:' || $str[0] == 'https:' || $str[0] == 'ftp:' || $str[0] == 'ftps:') {
        return $str[2];
    }
    return $str[0];
}
function is_first_time()
{
    if (isset($_SESSION['userloginhits']) && $_SESSION['userloginhits'] <= 3) {
        if (!isset($_COOKIE['view_tut'])) {
            //$_COOKIE['view_tut'] = 1;
            setcookie('view_tut', 1, time() + 86400 * 100, '/');
            //echo $_SESSION['userloginhits'];
            return true;
        }
    }
    return false;
}

function check_box_filter($arr_value, $value_check, $data_group = '', $input_name = '', $noncheck = 0)
{
    $str = '';
    if ($data_group != '') $data_group = 'data-group="' . $data_group . '"';
    foreach ($arr_value as $key => $value) {
        $active = '';
        $checked = '';
        $onclick = '';
        if ($key & $value_check || (is_array($value_check) && in_array($key, $value_check))) {
            $active = 'active';
            $checked = 'checked="true"';
        }
        if ($noncheck == 1) {
            $active = '';
            $checked = '';
        }
        if ($value == 'Đấu giá click')
            $onclick = 'onclick="show_price_click(this)"';
        $str .= '<a ' . $onclick . 'class="toggle-btn toggle-btn-small ' . $active . '" ' . $data_group . '>';
        $str .= $value;
        $str .= '<input name="' . $input_name . '[' . $key . ']" type="checkbox" value="' . $key . '" class="' . $input_name . ' hidden web-filter" ' . $checked . '/>';
        $str .= '</a>';
    }
    return $str;
}

function get_faq()
{
    $result = array();
    $sql = 'SELECT
                *
            FROM
                faq
            WHERE
                faq_active = 1';
    $db_select = new db_query($sql);
    while ($row = mysql_fetch_assoc($db_select->result)) {
        $result[$row['faq_type']][$row['faq_group']][$row['faq_id']] = $row;
    }
    return $result;
}

function get_faq_homepage()
{
    $result = array();
    $sql = 'SELECT
                *
            FROM
                faq
            WHERE
                faq_home_page  = 1';
    $db_select = new db_query($sql);
    while ($row = mysql_fetch_assoc($db_select->result)) {
        $result[$row['faq_id']] = $row;
    }
    return $result;
}

function convert_bb_code($string)
{
    $arry_source = array(
        '[b]',
        '[color=red]',
        '[b][color=red]',
        '[/b]',
        '[/color]',
        '[/color][/b]'
    );
    $arry_replace = array(
        '<span style="font-weight: bold">',
        '<span style="color: red">',
        '<span style="font-weight: bold; color: red;">',
        '</span>',
        '</span>',
        '</span>'
    );
    return str_replace($arry_source, $arry_replace, $string);
}

function remove_bb_code($string)
{
    $arry_source = array(
        '[b]',
        '[color=red]',
        '[b][color=red]',
        '[/b]',
        '[/color]',
        '[/color][/b]'
    );
    $arry_replace = array(
        '', '', '', '', '', ''
    );
    return str_replace($arry_source, $arry_replace, $string);
}

function check_length_special($str)
{
    $length = 0;
    $reg_b = '/\[b\](.*?)\[\/b\]/';
    $reg_color = '/\[color=red\](.*?)\[\/color\]/';

    if (preg_match($reg_color, $str) != 0)
        preg_match_all($reg_color, $str, $matches_color);
    else
        $matches_color[1] = array();

    foreach ($matches_color[1] as $key => $value) {
        $length += strlen(removeAccent($value));
    }

    if (preg_match($reg_b, $str) != 0)
        preg_match_all($reg_b, $str, $matches_b);
    else
        $matches_b[1] = array();

    foreach ($matches_b[1] as $key => $value) {
        if (preg_match($reg_color, $value) == 0)
            $length += strlen(removeAccent($value));
    }
    return $length;
}

function show_adv_filter($arr_filter, $arr_value)
{
    $str = '';
    foreach ($arr_filter as $id => $value) {
        if ($arr_value & $id) {
            $str .= ',' . $value;
        }
    }
    return substr($str, 1);
}

function dump_log($data = array(), $path = '../../logs/log.txt')
{
    $handle = @fopen($path, 'a+');
    $data   = var_export($data, true);
    $data   = date('H:i:s d/m/Y') . ' - ' . $data;
    if ($handle) {
        fwrite($handle, $data);
        fclose($handle);
    }
}

function savelog1($filename, $content)
{
    $log_path     =   $_SERVER["DOCUMENT_ROOT"] . "/ipstore/";
    $handle       =   @fopen($log_path . $filename, "a");
    //Neu handle chua co mo thêm ../
    if (!$handle) $handle = @fopen($filename, "a");
    //Neu ko mo dc lan 2 thi exit luon
    if (!$handle) exit();
    fwrite($handle, gmdate("d/m/Y h:i:s A") . " " . $content . " " . @$_SERVER["REQUEST_URI"] . "\n");
    fclose($handle);
}

function get_message($user_id, $start_time = 0, $end_time = 0, $limit = 5, $unread = true)
{
    $sql = '
        SELECT
            *
        FROM
            user_message_receive
            INNER JOIN user_message ON umr_message_id = usm_id
        WHERE
            umr_user_id = ' . $user_id . '
            AND ' . ($unread ? 'umr_read = 0' : '1') . '
    ';
    if ($start_time && $end_time) {
        $sql .= ' AND umr_time >= ' . $start_time . ' AND umr_time <= ' . $end_time;
    }
    $sql .= ' ORDER BY umr_time DESC LIMIT ' . $limit;
    $db = new db_query($sql, __FILE__ . __LINE__, 'USE_SLAVE');
    $user_message = array();
    if (mysql_num_rows($db->result) > 0) {
        while ($row = mysql_fetch_assoc($db->result)) {
            $user_message[$row['usm_id']] = $row;
        }
    }
    return $user_message;
}

function total_message($user_id, $start_time = 0, $end_time = 0, $unread = true)
{
    $sql = '
        SELECT
            count(*) as count
        FROM
            user_message_receive
            INNER JOIN user_message ON umr_message_id = usm_id
        WHERE
            umr_user_id = ' . $user_id . '
            AND ' . ($unread ? 'umr_read = 0' : '1') . '
    ';
    if ($start_time && $end_time) {
        $sql .= ' AND umr_time >= ' . $start_time . ' AND umr_time <= ' . $end_time;
    }
    $count = new db_query($sql);
    $count = mysql_fetch_assoc($count->result);
    return $count['count'];
}

function send_message($array_user_id, $content)
{
    if ($content) {
        $form = new generate_form();
        $form->addTable('user_message');
        $form->add('usm_content', 'content', 0, 1, $content);
        $time = time();
        $form->add('usm_time', 'time', 1, 1, time());
        $form->evaluate();
        $db = new db_execute_return();
        $last_mess_id = $db->db_execute($form->generate_insert_SQL());
        unset($db);
        unset($form);
        foreach ($array_user_id as $user_id) {
            $form = new generate_form();
            $form->addTable('user_message_receive');
            $form->add('umr_user_id', 'user_id', 1, 1, $user_id);
            $form->add('umr_message_id', 'last_mess_id', 1, 1, $last_mess_id);
            $form->add('umr_time', 'time', 1, 1, time());
            $form->evaluate();
            $db = new db_execute($form->generate_insert_SQL());
            unset($db);
            unset($form);
        }
    }
}

//Hàm format thông báo lỗi
//Click vào focus vào trường tương ứng
function err_focus($element_id, $mess, $class_err_mess = 'err_mess')
{
    return '<a class="' . $class_err_mess . '" href="javascript:void(0);" onclick="$(\'#' . $element_id . '\').focus();">' . $mess . '</a>';
}

//Hàm lấy ip của máy khách
function client_ip()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }
}

//Hàm tạo mới campagin trả về cam_id
function create_campaign($cam_name, $user_id)
{
    if ($cam_name && $cam_name != '' && intval($user_id) > 0) {
        $sql    = '
            INSERT INTO
                campaign(cam_name, cam_user_id)
            VALUES(\'' . mysql_real_escape_string($cam_name) . '\', ' . intval($user_id) . ')
        ';
        $db_insert  = new db_execute_return();
        $last_id    = $db_insert->db_execute($sql, __FILE__ . __LINE__);
        return intval($last_id);
    }
    return 0;
}
/**
 * Hàm update số lượng quảng cáo
 * @param $type
 * 0 : Tăng
 * 1 : Giảm
 */
function update_total_adv($cam_id = 0, $type = 0)
{
    if ($cam_id <= 0)
        return false;
    if ($type == 0)
        $sql_update    =    "UPDATE campaign SET cam_total_adv = cam_total_adv + 1 WHERE cam_id = " . $cam_id;
    else
        $sql_update    =    "UPDATE campaign SET cam_total_adv = cam_total_adv - 1 WHERE cam_id = " . $cam_id;
    $db_update    =    new db_execute($sql_update, __FILE__ . __LINE__);
    unset($db_update);
    return true;
}

// Hàm api lấy banner html trả về
function get_banner_html($package)
{
    $ban_html      =    $package['html'];
    $pos_code        =    $package['pos_code'];
    $owner_id        =    $package['owner_id'];
    $item_id            =    $package['item_id'];
    $end_time        =    $package['end_time'];
    $ban_name        =    $package['ban_name'];
    $web_id            =    $package['web_id'];
    $cat_id            =    $package['cat_id'];
    $active            =    $package['active'];
    $get_img       =  $package['get_img'];
    // Mã check sum để lưu ảnh
    $key_checksum    =    md5('bansuachuanepcam');
    // Active
    $ban_active    =    ($active) ? 1 : 0;

    // Replace ngược lại để ko giữ dấu &
    $ban_html    =    str_replace('myADbanner_and', '&', $ban_html);

    if ($ban_html == '' || $pos_code == '')
        return '';
    // Kiểm tra mã code nhập tồn tại hay không
    $pos     =    check_pos_code($pos_code);
    if (!$pos)
        return '';
    else {
        $bap_id                 =  $pos['bap_id'];
        $bap_select_category     =    $pos['bap_select_category'];
        $banner                 =  new Banner();
        $banner->get_position_web(" AND wbp_position_id = " . $bap_id);
        $list_web_id            =  isset($banner->list_web_position[$bap_id]) ? $banner->list_web_position[$bap_id] : array();
        if (empty($web_id)) {
            $web_id  =  $list_web_id;
        }
    }

    // Kiểm tra đã ngày kết thúc hợp lệ hay ko
    $end_time    =    ($end_time >= strtotime("Today"))  ?  $end_time : (strtotime("Today") + 86400);
    // Kiểm tra đã tồn tại banner chưa
    $row            =    array();
    $sql_check    =    "SELECT
                        ban_id
                     FROM
                        banner
                     WHERE
                        ban_position_id = " . $bap_id . "
                        AND ban_owner_id = " . $owner_id . "
                        AND ban_item_id = " . $item_id;
    $db_check    =    new db_query($sql_check, __FILE__ . __LINE__, "USE_SLAVE");
    $row            =    mysql_fetch_assoc($db_check->result);
    if (!empty($row)) {
        $ban_id    =    $row['ban_id'];
        $update     =    true;
    } else {
        // Tạo 1 banner để lấy id
        $update    =    false;
        $start_time    =    strtotime('Today');
        $last_update    =    time();
        $ban_admin_id    =    1;
        $sql_insert    =    "INSERT INTO
                           banner
                           (ban_position_id
                           ,ban_active
                           ,ban_start
                           ,ban_end
                           ,ban_admin_id
                           ,ban_last_time_update
                           ,ban_owner_id
                           ,ban_item_id
                           ,ban_admin_status
                           ,ban_name) VALUES";
        $sql_insert    .=    "(" . $bap_id . "
                     ," . $ban_active . "
                     ," . $start_time . "
                     ," . $end_time . "
                     ," . $ban_admin_id . "
                     ," . $last_update . "
                     ," . $owner_id . "
                     ," . $item_id . "
                     ,1
                     ,'" . $ban_name . "')";
        $db_insert    =    new db_execute_return();
        $ban_id        =    $db_insert->db_execute($sql_insert);
    }
    unset($db_check);
    // Lọc html để insert
    $ban_html     =     stripcslashes($ban_html);
    // Gán vào dom
    $html        =    str_get_html($ban_html);
    /* Lọc src ảnh */
    if ($get_img) {
        foreach ($html->find('img') as $img) {
            if (!in_array('media.vatgia.vn', explode('/', $img->src))) {
                // Loại http://
                $src    =    @end(explode('//', $img->src));
                // Lấy checksum
                $checksum    =    md5($src . $key_checksum);
                // Lấy tên ảnh
                $img_name    =    @end(explode('/', $src));
                // Loại tên ảnh khỏi src
                $src            =    str_replace($img_name, '', $src);
                // Lấy đuôi ảnh
                $ext            =    @end(explode('.', $img_name));
                // Lấy tên ảnh bỏ đuôi
                $img_name    =    str_replace($ext, '', $img_name);

                $img->src    =    'http://media.myad.vn/photo/3rdparty/' . $src . $img_name . $checksum . '.' . $ext;
            }
        }
    }
    // Lọc href của thẻ a thay thế để đo click
    foreach ($html->find('a') as $a) {
        $domain    =    ($_SERVER['SERVER_NAME'] == 'localhost') ? 'localhost:9013' : 'ad.vatgia.com';
        if (!in_array($domain, explode('/', $a->href)))
            $a->href    =    genarateURL($ban_id, $a->href, $web_id, $bap_id);
    }
    // sau khi lọc xong thì save lại
    $ban_html     =    $html->save();

    unset($html);
    // Clean html
    $html_cleanup    =    new html_cleanup($ban_html);
    $html_cleanup->clean();
    $ban_html        =    $html_cleanup->output_html;
    $ban_html        =    htmlspecialbo($ban_html);
    $ban_html        =    replaceMQ($ban_html);

    unset($html_cleanup);

    if ($ban_html != '') {
        // Update lại vào cơ sở dữ liệu
        $db_update    =    new db_execute("UPDATE
                                       banner
                                    SET
                                       ban_name = '" . $ban_name . "'
                                       ,ban_link = 'Link " . $ban_id . "'
                                       ,ban_html = '" . $ban_html . "'
                                       ,ban_end = " . $end_time . "
                                       ,ban_active = " . $ban_active . "
                                    WHERE
                                       ban_id = " . $ban_id);
        unset($db_update);
    } elseif (!$update) {
        $db_delete    =    new db_execute("DELETE FROM banner WHERE ban_id = " . $ban_id);
        unset($db_delete);
    }

    foreach ($web_id as $key => $value) {
        // Nếu id web ko hợp lệ thì bỏ qua
        if (!in_array($value, $list_web_id))
            continue;
        // Nếu là update thì xóa category cũ
        if ($update) {
            $sql_delete    =    'DELETE FROM banner_category_' . $value . ' WHERE bac_banner_id = ' . $ban_id;
            $db_del        =    new db_execute($sql_delete);
            unset($db_del);
        }
        // Bắt đầu insert vào bảng category
        if ($bap_select_category == 0)
            $cat_id[$value]   =  array(0);
        if (!isset($cat_id[$value]))
            $cat_id[$value]   =  array(0);
        foreach ($cat_id[$value] as $id) {
            $sql_cat        =    'INSERT IGNORE INTO banner_category_' . $value . ' (bac_category_id,bac_banner_id) VALUES (' . $id . ',' . $ban_id . ')';
            $db_excute    =    new db_execute($sql_cat);
            unset($db_excute);
        }
    }

    // Ghi lại log
    $type_post    =    ($update) ?  1  :  0;
    $ip_post        =    ip2long($_SERVER['REMOTE_ADDR']);
    $sql_log        =    "	INSERT IGNORE INTO banner_post_log(bpl_ban_id,bpl_time,bpl_type_post,bpl_ip) VALUES
							(" . $ban_id . "," . time() . "," . $type_post . "," . $ip_post . ")";
    $db_log        =    new db_execute($sql_log);
    unset($db_log);
    return $ban_html;
}

/**
 * Hàm tạo url cho banner
 */
function genarateURL($ban_id, $link, $web_id, $pos_id)
{
    $arr_url    =   array(
        'ban_id'    => $ban_id,
        'ban_link'  => $link,
        'cat_id'        =>    0,
        'web_id'    => $web_id,
        'pos_id'    => $pos_id
    );
    if ($_SERVER['SERVER_NAME'] == 'localhost') {
        $domain    =    'localhost:9013';
    } else {
        $domain    =    'http://ad.vatgia.com';
    }
    return $domain . '/a/b_click.php?data=' . base64_url_encode(json_encode($arr_url));
}

/**
 * Hàm check mã code vị trí banner
 */
function check_pos_code($pos_code = '')
{
    if ($pos_code == '')
        return false;
    $sql_check     =    "SELECT bap_id,bap_web_id,bap_select_category FROM banner_position WHERE bap_code = '" . $pos_code . "'";
    $db_check    =    new db_query($sql_check, __FILE__ . __LINE__, "USE_SLAVE");
    while ($row = mysql_fetch_assoc($db_check->result)) {
        return $row;
    }
    return false;
}
/** CHECK IP REDIS **/
function checkIp_redis()
{
    require_once('../classes/redis_store.php');
    $ip = $_SERVER['REMOTE_ADDR'];
    $redis    = new redis_store();
    //Nếu connect được thì OK
    if (!$redis->test_connect())
        exit;

    $list_ip     =     $redis->keys('banner_ip:*');
    if (!empty($list_ip)) {
        foreach ($list_ip as $key) {
            $ext    =    explode(':', $key);
            $ip_set    =    (isset($ext[1])) ? $ext[1] : 0;
            if ($ip == $ip_set) {
                return true;
            }
        }
    } else {
        return false;
    }
    return false;
}

/** Hàm lấy thông tin vị trí **/
function get_banner_position($pos_id = 0, $for_sale = 0)
{
    $arr_return     =    array();
    $cond                =    "";

    if ($for_sale == 1)
        $cond    .=    " AND bap_for_sale = 1";
    if ($pos_id > 0)
        $cond    .=    " AND bap_id = " . $pos_id;

    $sql    =    "SELECT banner_position.*,web_domain FROM banner_position INNER JOIN websites ON bap_web_id = web_id WHERE 1 AND bap_active = 1" . $cond;
    $db_query    =    new db_query($sql, __FILE__ . __LINE__, "USE_SLAVE");
    $arr_return    =    $db_query->result_array('bap_id');
    unset($db_query);
    return $arr_return;
}

/** Hàm lấy tooltip **/
function get_tooltip()
{
    $sql            =    "SELECT * FROM tooltip";
    $db_query    =    new db_query($sql, __FILE__ . __LINE__, "USE_SLAVE");
    $arr_return    =    array();
    while ($row    =    mysql_fetch_assoc($db_query->result)) {
        $row['tt_element']        =    html_entity_decode($row['tt_element']);
        $arr_return[$row['tt_element']]    =    array(
            'position'    =>    $row['tt_position'],
            'content'    =>    html_entity_decode($row['tt_content'])
        );
    }
    unset($db_query);
    return $arr_return;
}

/**
 * Hàm check debug
 */
function show_debug()
{
    $dump    =  getValue("dump", "int", "GET", 0);
    if ($dump == 1  && $_SERVER['REMOTE_ADDR'] == '118.70.233.70') {
        return true;
    }
    return false;
}

function getList($strquery)
{
    $query =  new db_query($strquery);
    $return = $query->objectList();
    $query->close();
    return $return;
}

function getItem($strquery)
{
    $query =  new db_query($strquery);
    $return = $query->objectItems();
    $query->close();
    return $return;
}

function getRow($strquery)
{
    $query =  new db_query($strquery);
    $return = mysql_fetch_row($query->result);
    $query->close();
    return $return;
}

function getnumRow($strquery)
{
    $query =  new db_query($strquery);
    $return = mysql_num_rows($query->result);
    $query->close();
    return $return;
}
function list_cate_par_2($catid)
{
    $result = $catid . ',';
    $db_sel = new db_query("SELECT * FROM categories_multi WHERE cat_parent_id = " . $catid . " AND cat_active = 1");
    if (mysql_num_rows($db_sel->result) > 0) {
        while ($row = mysql_fetch_assoc($db_sel->result)) {
            $result .= $row['cat_id'] . ',';
        }
    }
    return substr($result, 0, -1);
}
function up_view_day($news_id)
{
    $news_id = intval($news_id);
    $sql = "UPDATE news SET new_view = new_view + 1 WHERE new_id = " . $news_id . " ";
    $db = new db_query($sql);
    unset($db);
}

// Tạo mục lục
function makeML($content, $search = '', $replace = '')
{
    if ($content != '') {
        require_once("simple_html_dom.php");
        $html = str_get_html($content);
        $h2s = $html->find("h2,h3,h4,.h2-class,.h3-class");
        $patterns = array('/\d+\.\d+\.\d+\.\s/i', '/\d+\.\d+\.\s/i', '/\d+\.\s/i');
        $ml = "<nav class='table-of-contents'><p class='tt_phu_luc'><span>Mục lục:</span></p><ul>";
        $i = $u = $j = 0;

        if (!empty($h2s)) {
            foreach ($h2s as $h2) {
                $text = preg_replace($patterns, '', str_replace('&nbsp;', ' ', $h2->plaintext), 1);
                $id = replaceTitle($text);
                if ($id == $search) {
                    $id = $replace;
                }
                $h2->id = $id;
                if ($h2->tag == 'h2' || $h2->class == 'h2-class') {
                    $i++;
                    $ml .= "<li><a class=ul_h2 href='#" . $id . "'>" . $i . ". " . $text . "</a></li>";
                    $j = 0;
                }
                if ($h2->tag == 'h3' || $h2->class == 'h3-class') {
                    $j++;
                    $ml .= "<li><a class=ul_h3 href='#" . $id . "'>" . $i . "." . $j . ". " . $text . "</a></li>";
                    $u = 0;
                }
                if ($h2->tag == 'h4') {
                    $u++;
                    $ml .= "<li><a class=ul_h4 href='#" . $id . "'>" . $i . "." . $j . "." . $u . ". " . $text . "</a></li>";
                }
            }
            $ml .= '</ul>';
            echo $ml;
        }
    }
}
function makeML_content($content, $search = '', $replace = '')
{
    if ($content != '') {
        $html = str_get_html($content);
        $h2s = $html->find("h2,h3,h4,.h2-class,.h3-class");
        $patterns = array('/\d+\.\d+\.\d+\.\s/i', '/\d+\.\d+\.\s/i', '/\d+\.\s/i');
        foreach ($h2s as $h2) {
            $text = preg_replace($patterns, '', str_replace('&nbsp;', ' ', $h2->plaintext), 1);
            $id = replaceTitle($text);
            if ($id == $search && $id != '') {
                $id = $replace;
            }
            $h2->id = $id;
        }
        $html = $html->save();
        return $html;
    }
}
function show_array($arr)
{
    if (is_array($arr)) {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }
}
function images($day, $avatar){
     $dir ="../upload/gs/";
     $year = date('Y', $day);
     $dir_year = $dir.$year;
     $month = date('m',$day);
     $dir_month = $dir.$year.'/'.$month;
     $day = date('d',$day);

     $ugs_day_avt = $dir.$year.'/'.$month.'/'.$day.'/'.$avatar;

     echo $ugs_day_avt;
}

function images_ph($day, $avatar){
     $dir ="../upload/ph/";
     $year = date('Y', $day);
     $dir_year = $dir.$year;
     $month = date('m',$day);
     $dir_month = $dir.$year.'/'.$month;
     $day = date('d',$day);

     $ugs_day_avt = $dir.$year.'/'.$month.'/'.$day.'/'.$avatar;

     echo $ugs_day_avt;
}
function rewriteUrlClass($alias, $id){
    return "/".$alias."-c".$id.".html";
}
function rewriteUrlTutor($ugs_name, $id){
    $alias = replaceTitle($ugs_name);                                   
    return "/".$alias."-gs".$id.".html";
}
function rewriteUrlParent($ugs_name, $id){
    $alias = replaceTitle($ugs_name);                                   
    return "/".$alias."-ph".$id.".html";
}
function update($tbl_name, $data = array(), $condition = array())
{
    $txt_column = '';
    $where = '';
    if ($tbl_name != '' && !empty($data)) {
        foreach ($data as $key => $value) {
            $txt_column .= "`" . $key . "` = " . "'" . $value . "',";
        }
        $txt_column = rtrim($txt_column, ',');
        if (!empty($condition)) {
            foreach ($condition as $key => $val) {
                $where .= "AND `" . $key . "` = '" . $val . "'";
            }
        }
        $result = "UPDATE " . $tbl_name . " SET " . $txt_column . " WHERE 1 " . $where . " ";
        $db = new db_query($result);
    }
}

function add($tbl_name, $data = array()){
    $columns = '';
    $value = '';
    if(!empty($data) && $tbl_name != ''){
        foreach($data as $key => $val){
            $columns .= "`".$key."`,";
            $value .= "'".$val."',";
        }
        $columns = rtrim($columns,',');
        $value = rtrim($value, ',');
        $sql = "INSERT INTO ".$tbl_name."(".$columns.") VALUES (".$value.") ";
        $db = new db_query($sql);
    }
}


