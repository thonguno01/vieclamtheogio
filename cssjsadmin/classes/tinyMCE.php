<?
/**
Show tinyMCE ra màn hình
*/
class tinyMCE{
	/**
	Khởi tạo hàm
	*/
	var $html_output = "";
	var $textarea_width = "500";
	
	//js_path : để load tinyMCE for crossdomain
	function tinyMCE($content, $text_area_id, $textarea_width="500", $textarea_height="300", $show_math=0, $js_path="/js/tinyMCE/"){
	
		$html_cleanup = new html_cleanup("");
		$this->textarea_width = $textarea_width;
		
		$math_plugin 	= "";
		$math_config 	= "";
		$math_control	= "";
		
		$cleanupstyles_plugin = ", cleanupstyles";
		
		if ($show_math == 1){
			$math_plugin 				= ", asciimath";
			//Nếu có math plugin thì ko chạy đc cleanup style
			$cleanupstyles_plugin 	= "";
			$math_config				 = "
			AScgiloc : 'http://mimetex.trithuc.info/cgi-bin/mimetex1.cgi',
			";
			$math_control = ",separator,asciimath,asciimathcharmap";
			$this->html_output .= '<div style="display:none"><script type="text/javascript" src="/js/tinyMCE/plugins/asciimath/js/ASCIIMathMLwFallback.js"></script></div>' . "\n";
			$this->html_output .= '<script type="text/javascript">var AMTcgiloc = "http://mimetex.trithuc.info/cgi-bin/mimetex1.cgi";</script>' . "\n";
		}
		
		$this->html_output .= '<script type="text/javascript" src="' . $js_path . 'tiny_mce.js"></script>' . "\n";
		$this->html_output .= '
			<script type="text/javascript">
				/* Default skin */
				tinyMCE.init({
					/* General options */
					mode : "exact",
					elements : "' . $text_area_id . '",
					width : "' . $textarea_width . '",
					height : "' . $textarea_height . '",
					theme : "advanced",
					/* Dùng domain */
					remove_script_host : false,
					convert_urls : true,
					/* Dùng đường dẫn tuyệt đối */
					relative_urls : false,
					verify_html : true,
					cleanup : true,
					language : "vi",
					plugins : "emotions, table, paste' . $cleanupstyles_plugin . $math_plugin . '", ' . "\n" . 
						$html_cleanup->generate_tinyMCE_rule() . "\n" . '
					/* Theme options */
					theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect,forecolor,backcolor",
					theme_advanced_buttons2 : "image,pasteword,link,unlink,emotions,|,table,tablecontrols,code' . $math_control . '",
					theme_advanced_buttons3 : "",
					theme_advanced_buttons4 : "",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "bottom",
					theme_advanced_resizing : true,
					theme_advanced_resizing_use_cookie : false,
					theme_advanced_path : false, ' . 
					$math_config . '
					/* Example content CSS (should be your site CSS) */
					content_css : "/js/tinyMCE/tinyMCE.css"
				});
				
			</script>

			<textarea id="' . $text_area_id . '" name="' . $text_area_id . '" rows="20" cols="80" style="width: ' . $this->textarea_width . 'px">' . htmlspecialchars($content, ENT_NOQUOTES) . '	
			</textarea>		
			';
		
	}
}
?>