/* gettext library */

var catalog = new Array();

CKEDITOR.timestamp = "122345";

function pluralidx(count) {
    return count == 1 ? 0 : 1;
}

function gettext(msgid) {
    var value = catalog[msgid];
    if (typeof value == "undefined") {
        return msgid;
    } else {
        return typeof value == "string" ? value : value[0];
    }
}

function ngettext(singular, plural, count) {
    value = catalog[singular];
    if (typeof value == "undefined") {
        return count == 1 ? singular : plural;
    } else {
        return value[pluralidx(count)];
    }
}

function gettext_noop(msgid) {
    return msgid;
}

function pgettext(context, msgid) {
    var value = gettext(context + "" + msgid);
    if (value.indexOf("") != -1) {
        value = msgid;
    }
    return value;
}

function npgettext(context, singular, plural, count) {
    var value = ngettext(context + "" + singular, context + "" + plural, count);
    if (value.indexOf("") != -1) {
        value = ngettext(singular, plural, count);
    }
    return value;
}

function interpolate(fmt, obj, named) {
    if (named) {
        return fmt.replace(/%\(\w+\)s/g, function(match) {
            return String(obj[match.slice(2, -2)]);
        });
    } else {
        return fmt.replace(/%s/g, function(match) {
            return String(obj.shift());
        });
    }
}

/* formatting library */

var formats = new Array();

formats["DATETIME_FORMAT"] = "N j, Y, P";
formats["DATE_FORMAT"] = "N j, Y";
formats["DECIMAL_SEPARATOR"] = ".";
formats["MONTH_DAY_FORMAT"] = "F j";
formats["NUMBER_GROUPING"] = "3";
formats["TIME_FORMAT"] = "P";
formats["FIRST_DAY_OF_WEEK"] = "0";
formats["TIME_INPUT_FORMATS"] = ["%H:%M:%S", "%H:%M"];
formats["THOUSAND_SEPARATOR"] = ",";
formats["DATE_INPUT_FORMATS"] = ["%Y-%m-%d", "%m/%d/%Y", "%m/%d/%y"];
formats["YEAR_MONTH_FORMAT"] = "F Y";
formats["SHORT_DATE_FORMAT"] = "m/d/Y";
formats["SHORT_DATETIME_FORMAT"] = "m/d/Y P";
formats["DATETIME_INPUT_FORMATS"] = [
    "%Y-%m-%d %H:%M:%S",
    "%Y-%m-%d %H:%M",
    "%Y-%m-%d",
    "%m/%d/%Y %H:%M:%S",
    "%m/%d/%Y %H:%M",
    "%m/%d/%Y",
    "%m/%d/%y %H:%M:%S",
    "%m/%d/%y %H:%M",
    "%m/%d/%y",
];

function get_format(format_type) {
    var value = formats[format_type];
    if (typeof value == "undefined") {
        return msgid;
    } else {
        return value;
    }
}
/* End gettext */

(function(win) {
    // This represents the site configuration
    win.mdn = {
        build: "1843b89",
        // Properties and settings for CKEditor will go here
        ckeditor: {},
        // Feature test results and methods will be placed here
        features: {},
        // The path to media (images, CSS, JS) in MDN
        mediaPath: "https://developer.cdn.mozilla.net/media/",
        // Optimizely API
        optimizely: win["optimizely"] || [],
        // Site notifications
        notifications: [],
        // Wiki-specific settings will be placed here
        wiki: {
            autosuggestTitleUrl: "/en-US/docs/get-documents",
        },
        searchFilters: [{
                name: "Document type",
                slug: "type",
                order: 1,
                filters: [{
                        name: "Tools",
                        slug: "tools",
                        shortcut: null,
                    },
                    {
                        name: "Code Samples",
                        slug: "code",
                        shortcut: null,
                    },
                    {
                        name: "How-To & Tutorial",
                        slug: "howto",
                        shortcut: null,
                    },
                ],
            },
            {
                name: "Skill level",
                slug: "skill",
                order: 1,
                filters: [{
                        name: "I'm an Expert",
                        slug: "advanced",
                        shortcut: null,
                    },
                    {
                        name: "Intermediate",
                        slug: "intermediate",
                        shortcut: null,
                    },
                    {
                        name: "I'm Learning",
                        slug: "beginner",
                        shortcut: null,
                    },
                ],
            },
            {
                name: "Topics",
                slug: "topic",
                order: 1,
                filters: [{
                        name: "Open Web Apps",
                        slug: "apps",
                        shortcut: null,
                    },
                    {
                        name: "HTML",
                        slug: "html",
                        shortcut: null,
                    },
                    {
                        name: "CSS",
                        slug: "css",
                        shortcut: null,
                    },
                    {
                        name: "JavaScript",
                        slug: "js",
                        shortcut: null,
                    },
                    {
                        name: "APIs and DOM",
                        slug: "api",
                        shortcut: null,
                    },
                    {
                        name: "Canvas",
                        slug: "canvas",
                        shortcut: null,
                    },
                    {
                        name: "SVG",
                        slug: "svg",
                        shortcut: null,
                    },
                    {
                        name: "MathML",
                        slug: "mathml",
                        shortcut: null,
                    },
                    {
                        name: "WebGL",
                        slug: "webgl",
                        shortcut: null,
                    },
                    {
                        name: "XUL",
                        slug: "xul",
                        shortcut: null,
                    },
                    {
                        name: "Marketplace",
                        slug: "marketplace",
                        shortcut: null,
                    },
                    {
                        name: "Firefox",
                        slug: "firefox",
                        shortcut: null,
                    },
                    {
                        name: "Firefox for Android",
                        slug: "firefox-mobile",
                        shortcut: "fennec",
                    },
                    {
                        name: "Firefox for Desktop",
                        slug: "firefox-desktop",
                        shortcut: "fx",
                    },
                    {
                        name: "Firefox OS",
                        slug: "firefox-os",
                        shortcut: "fxos",
                    },
                    {
                        name: "Mobile",
                        slug: "mobile",
                        shortcut: null,
                    },
                    {
                        name: "Web Development",
                        slug: "webdev",
                        shortcut: null,
                    },
                    {
                        name: "Add-ons & Extensions",
                        slug: "addons",
                        shortcut: null,
                    },
                    {
                        name: "Games",
                        slug: "games",
                        shortcut: null,
                    },
                    {
                        name: "Writing Documentation",
                        slug: "docs",
                        shortcut: null,
                    },
                ],
            },
        ],
    };

    // Ensures gettext always returns something, is always set
    win.gettext = function(x) {
        return x;
    };
})(window);

(function(e, t, a) {
    a.extend({
        parseQuerystring: function(e) {
            var t = {};
            var n = (e || location.search).replace("?", "");
            var i = n.split("&");
            a.each(i, function(e, a) {
                var n = a.split("=");
                t[n[0]] = n[1];
            });
            return t;
        },
        slugifyString: function(e, t, a) {
            var n = new RegExp("[?&\"'#*$" + (t ? "" : "/") + " +?]", "g");
            var i = e.replace(n, "_").replace(/\$/g, "");
            if (!a) {
                i = i.replace(/_+/g, "_");
            }
            return i;
        },
    });
})(window, document, jQuery);

(function() {
    /*/
	CKEDITOR.on('instanceReady', function(ev) {
		var writer = ev.editor.dataProcessor.writer;

		// Tighten up the indentation a bit from the default of wide tabs.
		writer.indentationChars = ' ';

		// Configure this set of tags to open and close all on the same line, if
		// possible.
		var oneliner_tags = [
			'hgroup', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
			'p', 'th', 'td', 'li'
		];
		for (var i = 0, tag; tag = oneliner_tags[i]; i++) {
			writer.setRules(tag, {
				indent: true,
				breakBeforeOpen: true,
				breakAfterOpen: false,
				breakBeforeClose: false,
				breakAfterClose: true
			});
		}

		// Retrieve nodes important to moving the path bar to the top
		var tbody = ev.editor._.cke_contents.$.parentNode.parentNode;
		var pathP = tbody.lastChild.childNodes[0].childNodes[1];
		var toolbox = tbody.childNodes[0].childNodes[0].childNodes[0];

		if (toolbox && pathP) {
			toolbox.appendChild(pathP);
		}

		// Callback for inline, if necessary
		var callback = CKEDITOR.inlineCallback;
		callback && callback(ev);
	});
	//*/

    // Prevent bad on* attributes (https://github.com/ckeditor/ckeditor-dev/commit/1b9a322)
    var oldHtmlDataProcessorProto = CKEDITOR.htmlDataProcessor.prototype.toHtml;
    CKEDITOR.htmlDataProcessor.prototype.toHtml = function(data, fixForBody) {
        data = protectInsecureAttributes(data);
        data = oldHtmlDataProcessorProto.apply(this, arguments);
        data = data.replace(new RegExp("data-cke-" + CKEDITOR.rnd + "-", "ig"), "");

        function protectInsecureAttributes(html) {
            return html.replace(
                /([^a-z0-9<\-])(on\w{3,})(?!>)/gi,
                "$1data-cke-" + CKEDITOR.rnd + "-$2"
            );
        }
        return data;
    };

    // Provide redirect pattern for corresponding plugin
    mdn.ckeditor.redirectPattern =
        'REDIRECT <a class="redirect" href="%(href)s">%(title)s</a>';

    (function() {
        // Brick dialog "changed" prompts
        /*/
		var originalOn = CKEDITOR.dialog.prototype.on;
		CKEDITOR.dialog.prototype.on = function(event, callback) {
			// If it's the cancel event that pops up the confirmation, just get out
			if (event == 'cancel' && callback.toString().indexOf('confirmCancel') != -1) {
				return true;
			}
			originalOn.apply(this, arguments);
		};
		//*/

        // <time> elements should be inline
        CKEDITOR.dtd.$inline["time"] = 1;
        delete CKEDITOR.dtd.$block["time"];

        // Tell CKEditor that <i> elements are block so empty <i>'s aren't removed
        // This is essentially for Font-Awesome
        CKEDITOR.dtd.$block["i"] = 1;
        delete CKEDITOR.dtd.$removeEmpty["i"];

        // Manage key presses
        var keys = (mdn.ckeditor.keys = {
            control2: CKEDITOR.CTRL + 50,
            control3: CKEDITOR.CTRL + 51,
            control4: CKEDITOR.CTRL + 52,
            control5: CKEDITOR.CTRL + 53,
            control6: CKEDITOR.CTRL + 54,
            controlK: CKEDITOR.CTRL + 75,
            controlL: CKEDITOR.CTRL + 76,
            controlShiftL: CKEDITOR.CTRL + CKEDITOR.SHIFT + 76,
            controlS: CKEDITOR.CTRL + 83,
            controlO: CKEDITOR.CTRL + 79,
            controlP: CKEDITOR.CTRL + 80,
            controlShiftO: CKEDITOR.CTRL + CKEDITOR.SHIFT + 79,
            controlShiftS: CKEDITOR.CTRL + CKEDITOR.SHIFT + 83,
            shiftSpace: CKEDITOR.SHIFT + 32,
            tab: 9,
            shiftTab: CKEDITOR.SHIFT + 9,
            enter: 13,
            back: 1114149,
            forward: 1114151,
        });
        var block = function(k) {
            return CKEDITOR.config.blockedKeystrokes.push(keys[k]);
        };

        // Prevent key handling
        block("tab");
        block("shiftTab");
        block("control2");
        block("control3");
        block("control4");
        block("control5");
        block("control6");
        block("controlO");
        block("controlS");
        block("controlShiftL");
        block("controlShiftO");
    })();

    /**
     * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
     * For licensing, see LICENSE.html or http://ckeditor.com/license
     */
    CKEDITOR.editorConfig = function(config) {
        /***
	 * CKeditor config
	 * Resize
			config.resize_enabled
			config.resize_minWidth and config.resize_maxWidth
			config.resize_minHeight and config.resize_maxHeight
	 * Filebrowser
			config.filebrowserBrowseUrl = "../../resource/ckeditor/ckfinder/ckfinder.html",
			config.filebrowserUploadUrl = "../../resource/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
			config.filebrowserImageUploadUrl = "../../resource/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
			config.filebrowserFlashUploadUrl = "../../resource/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash",
			config.filebrowserImageThumbsUploadUrl = 'upload.php?type=Images&makeThumb=true';
			config.filebrowserImageResizeUploadUrl = 'upload.php?type=Images&resize=true';
			config.doksoft_uploader_url = '';
	 * Basic Plugin
	 		config.plugins = 'dialogui,dialog,about,basicstyles,clipboard,button,toolbar,enterkey,entities,floatingspace,wysiwygarea,indent,indentlist,fakeobjects,link,list,undo';
	 * Standard Plugin
	 		config.plugins = 'dialogui,dialog,about,a11yhelp,basicstyles,blockquote,clipboard,panel,floatpanel,menu,contextmenu,resize,button,toolbar,elementspath,enterkey,entities,popup,filebrowser,floatingspace,listblock,richcombo,format,horizontalrule,htmlwriter,wysiwygarea,image,indent,indentlist,fakeobjects,link,list,magicline,maximize,pastetext,pastefromword,removeformat,showborders,sourcearea,specialchar,menubutton,scayt,stylescombo,tab,table,tabletools,undo,wsc';
	 * Full Plugin
	 		config.plugins = 'dialogui,dialog,about,a11yhelp,dialogadvtab,basicstyles,bidi,blockquote,clipboard,button,panelbutton,panel,floatpanel,colorbutton,colordialog,templates,menu,contextmenu,div,resize,toolbar,elementspath,enterkey,entities,popup,filebrowser,find,fakeobjects,flash,floatingspace,listblock,richcombo,font,forms,format,horizontalrule,htmlwriter,iframe,wysiwygarea,image,indent,indentblock,indentlist,smiley,justify,menubutton,language,link,list,liststyle,magicline,maximize,newpage,pagebreak,pastetext,pastefromword,preview,print,removeformat,save,selectall,showblocks,showborders,sourcearea,specialchar,scayt,stylescombo,tab,table,tabletools,undo,wsc';
	***/

        // Ngon ngu
        config.language = "vi";

        // UI color
        config.uiColor = "#CCCCCC";

        // Skin
        config.skin = "moono_blue";

        // Css
        //config.contentsCss		= ['/admin/resource/ckeditor/bootstrap.css'];

        /***
         * Cho phep cac the
         * config.allowedcontent = "p h1{text-align}; a[!href]; strong em; p(tip)";
         ***/
        config.allowedContent = true; // to allow all

        // Cho phep them mot so the
        config.extraAllowedContent = "";

        // Khong tu dong kt chinh ta
        config.scayt_autoStartup = false;
        config.disableNativeSpellChecker = true;

        // File browser
        (config.filebrowserBrowseUrl =
            "https://vieclamtheogio.vieclam123.vn/ckeditor/ckfinder/ckfinder.php"),
        (config.filebrowserUploadUrl =
            "https://vieclamtheogio.vieclam123.vn/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files"),
        (config.filebrowserImageUploadUrl =
            "https://vieclamtheogio.vieclam123.vn/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images"),
        (config.filebrowserFlashUploadUrl =
            "https://vieclamtheogio.vieclam123.vn/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash"),
        // My Plugin
        /*/		
	config.plugins =
	// Plugin
		'dialogui,' + // Core
		'dialog,' + // Core
		'dialogadvtab,' +	// Core - Dùng nâng cao cho dialog Link,Image,Flash,Table,IFrame,Div Container						
		'button,' + // Core
		'panelbutton,' + // Core - Nâng cao của button trình đơn thả xuống, vd: bảng điều khiển màu sắc, ...
		'panel,' + // Plugin này sử dụng cùng với các plugin floatpanel cung cấp cơ sở của tất cả các bảng giao diện người dùng biên tập - thả xuống, menu, vv
		'floatpanel,' + // Plugin này cùng với các plugin của bảng điều khiển là cung cấp cơ sở của tất cả các bảng giao diện người dùng biên tập - thả xuống, menu, vv	
		'menu,' + // Plugin chứa phương pháp để xây dựng thực đơn CKEditor (ví dụ như trình đơn ngữ cảnh hoặc menu thả xuống).
		'contextmenu,' + // menu ngữ cảnh sử dụng thay vì trình duyệt, manage menu item and group
		'resize,' + // thay đổi kích thước editor
		'elementspath,' + // Ở dưới cùng cho biết danh sách HTML và thẻ HTML hiện tại ở vị trí con trỏ
		'enterkey,' + // Điều chỉnh hành động khi nhấn enter, shift + enter, ...
		'entities,' + // entities code
		'popup,' + // thêm một chức năng công cụ để mở trang web trong cửa sổ popup.
		'filebrowser,' + // Liên kết ckeditor với bất kỳ trình quản lý file nào bên ngoài	
		'fakeobjects,' +
		'floatingspace,' + // Điều chỉnh vị trí tốt nhất cho ckeditor ở chế độ inline
		'listblock,' + // xây dựng một danh sách thả trong bảng biên tập. vd: thấy trong rich combo, list item with label 
		'richcombo,' + // sử dụng để xây dựng Dropdowns như Styles, Định dạng, cỡ chữ, vv
		'htmlwriter,' + // linh hoạt đầu ra định dạng HTML, với một số tùy chọn cấu hình để kiểm soát các định dạng đầu ra trình biên tập.
		'menubutton,' + // cung cấp một giao diện người dùng phần nút menu khi nhấp vào sẽ mở ra một trình đơn thả xuống với một danh sách các tùy chọn.
		'liststyle,' + // Thêm danh sách số
		'magicline,' + // làm dễ dàng hơn để đặt con trỏ và thêm nội dung tại thẻ như images, tables hoặc <div>
		'showborders,' + // hiển thị đường viền xung quanh bảng.
		'tab,' + // Hỗ trợ xử lý tab trên editor. vd: tab trên table
	// Line 1
		'sourcearea,' + // Mã nhúng
		//'save,' + // Lưu
		//'newpage,' + // Trang mới
		'preview,' + // Xem trước
		'print,' + // In
		//'templates,' + // Mẫu
		'clipboard,' + // Cut, Copy, Paste
		'pastetext,' + // Copy như text
		'pastefromword,' + // Copy từ word - Gồm cả clipboard
		'undo,' + // Hoàn tác
		'find,' + // Tìm và thay thế
		//'selectall,' + // Chọn tất cả
		//'wsc,' + // Button kiểm tra chính tả
		//'scayt,' + // Kiểm tra chính tả
		//'forms,' + // Form
	// Line 2		
		'basicstyles,' + // B, I, U ...
		'removeformat,' + // Loại bỏ style
		'list,' + // Ul,li
		'indent,' + // marginleft 40px
		'indentblock,' + // marginleft 40px
		'indentlist,' + // marginleft 40px
		'blockquote,' + // Quote
		//'div,' + // Div
		'justify,' + // Căn chỉnh
		//'bidi,' + // Trái sang phải, phải sáng trái
		//'language,' + // Chọn ngôn ngữ
		'link,' + // Đường dẫn
		'image,' + // Ảnh
		//'flash,' + // Flash
		'table,' + // Kẻ bảng
		'tabletools,' + // Kẻ bảng
		'horizontalrule,' + // Line <hr>
		//'smiley,' + // Mặt cười
		//'specialchar,' + // Ký tự đặc biệt
		//'pagebreak,' + // Ngắt trang
		'iframe,' + // Iframe
	// Line 3
		'stylescombo,' + // Style
		'format,' + // Format
		'font,' + // Font + size	
		'colorbutton,' + // Color button
		'colordialog,' + // Color dialog
		'maximize,' + // Full width height ckeditor
		//'showblocks,' + // Show block
		//'about,' + // Giới thiệu
		//'a11yhelp,' + // Help - Dùng alt + 0 để bật hướng dẫn
	// Toolbar create			
		'toolbar,' + // Thanh công cụ
		'wysiwygarea' // Khởi tạo
		;
	//*/

        // Them Plugin
        (config.extraPlugins =
            "mdn-buttons,mdn-sampler,mdn-keystrokes,mdn-syntaxhighlighter,image2,quicktable,simpleuploads,accordion,doksoft_stat,doksoft_backup,doksoft_button,doksoft_youtube,doksoft_maps,doksoft_html");

        // Xoa Plugin
        //config.removePlugins = 'forms, save, print, newpage, templates, bidi';

        /***
	 * Toolbar
	 * config.toolbarCanCollapse = false;
	 * config.colorButton_enableMore = false;
	 * Full
		 	config.toolbar = [
				{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
				{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
				{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
				{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
			        'HiddenField' ] },
				'/',
				{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
				{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
				'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
				{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
				{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
				'/',
				{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
				{ name: 'colors', items : [ 'TextColor','BGColor' ] },
				{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
			];
	***/
        config.toolbar = [{
                name: "document",
                items: [
                    "Source",
                    "autoFormat",
                    "CommentSelectedRange",
                    "UncommentSelectedRange",
                    "AutoComplete",
                ],
            },
            { name: "more", items: ["Preview", "Print", "Find"] },
            { name: "clipboard", items: ["PasteText", "PasteFromWord"] },
            { name: "links", items: ["Link", "Unlink", "Anchor"] },
            { name: "insert", items: ["Image", "addImage", "addFile"] },
            {
                name: "smart",
                items: [
                    "doksoft_html",
                    "Table",
                    "doksoft_button",
                    "doksoft_youtube",
                    "doksoft_maps",
                    "doksoft_backup_save",
                    "doksoft_backup_load",
                    "Accordion",
                ],
            },
            {
                name: "paragraph",
                items: [
                    "JustifyLeft",
                    "JustifyCenter",
                    "JustifyRight",
                    "JustifyBlock",
                    "-",
                    "NumberedList",
                    "BulletedList",
                    "-",
                    "Outdent",
                    "Indent",
                    "-",
                    "Blockquote",
                ],
            },
            "/",
            { name: "styles", items: ["Styles", "Format", "Font", "FontSize"] },
            {
                name: "buttonH",
                items: [
                    "h1Button",
                    "h2Button",
                    "h3Button",
                    "h4Button",
                    "h5Button",
                    "h6Button",
                    "preButton",
                    "codeButton",
                    "mdn-syntaxhighlighter",
                    "Syntaxhighlight",
                    "mdn-sampler",
                ],
            },
            {
                name: "basicstyles",
                items: ["Bold", "Italic", "Underline", "-", "RemoveFormat"],
            },
            { name: "colors", items: ["TextColor", "BGColor"] },
            { name: "tools", items: ["Maximize"] },
        ];

        /***
         * SimpleUpload Config
         ***/

        // Dung luong file cho phep
        config.simpleuploads_maxFileSize = "";

        // File khong hop le
        config.simpleuploads_invalidExtensions = "";

        // File hop le
        config.simpleuploads_acceptedExtensions =
            "doc|docx|xls|xlsx|ppt|pdf|txt|rar|zip|jpeg|JPEG|jpg|gif|png|bmp";

        // File anh hop le
        config.simpleuploads_imageExtensions = "JPEG|jpeg|gif|png|bmp|jpg|JPG";

        // Kiem tra kich thuoc toi da
        config.simpleuploads_maximumDimensions = true;

        // Convert file tu bmp sang png
        config.simpleuploads_convertBmp = true;

        /***
         * Doksoft Backup
         ***/
        config.doksoft_backup_interval = 3e4; // 30s
        config.doksoft_backup_snapshots_limit = 20; // 20 ban ghi
        config.doksoft_backup_save_before_load = true; // Luu truoc khi soan thao
        config.doksoft_backup_move_to_footer = true;
        config.doksoft_backup_add_background_in_footer = true;
        config.doksoft_backup_add_text_to_load_button = true;
        config.doksoft_backup_date_format = "HH:MM dd/mm/yyyy";
        config.doksoft_backup_additional_id = "";

        /***
         * Doksoft Youtube
         ***/
        config.doksoft_youtube_apiKey = "AIzaSyA-aKbivWEGhF97A57LAEnyKl1-j57YBEc";
        config.doksoft_youtube_maxResults = 25;
        config.doksoft_youtube_showSuggested = true;
        config.doksoft_youtube_enablePrivacyMode = false;
        config.doksoft_youtube_useOldCode = false;
    };
})();