(function() {
  if (window.CKEDITOR && window.CKEDITOR.dom) {
    return;
  }
  if (!window.CKEDITOR) {
    window.CKEDITOR = function() {
      var optgroup = {
        timestamp : "C6HH5UF",
        version : "3.6.4",
        revision : "7575",
        rnd : Math.floor(Math.random() * 900) + 100,
        _ : {},
        status : "unloaded",
        basePath : function() {
          var path = window.CKEDITOR_BASEPATH || "";
          if (!path) {
            var codeSegments = document.getElementsByTagName("script");
            var i = 0;
            for (;i < codeSegments.length;i++) {
              var styleSheets = codeSegments[i].src.match(/(^|.*[\\\/])ckeditor(?:_basic)?(?:_source)?.js(?:\?.*)?$/i);
              if (styleSheets) {
                path = styleSheets[1];
                break;
              }
            }
          }
          if (path.indexOf(":/") == -1) {
            if (path.indexOf("/") === 0) {
              path = location.href.match(/^.*?:\/\/[^\/]*/)[0] + path;
            } else {
              path = location.href.match(/^[^\?]*\/(?:)/)[0] + path;
            }
          }
          if (!path) {
            throw'The CKEditor installation path could not be automatically detected. Please set the global variable "CKEDITOR_BASEPATH" before creating editor instances.';
          }
          return path;
        }(),
        getUrl : function(resource) {
          if (resource.indexOf(":/") == -1 && resource.indexOf("/") !== 0) {
            resource = this.basePath + resource;
          }
          if (this.timestamp && (resource.charAt(resource.length - 1) != "/" && !/[&?]t=/.test(resource))) {
            resource += (resource.indexOf("?") >= 0 ? "&" : "?") + "t=" + this.timestamp;
          }
          return resource;
        }
      };
      var newGetUrl = window.CKEDITOR_GETURL;
      if (newGetUrl) {
        var originalGetUrl = optgroup.getUrl;
        optgroup.getUrl = function(pdataOld) {
          return newGetUrl.call(optgroup, pdataOld) || originalGetUrl.call(optgroup, pdataOld);
        };
      }
      return optgroup;
    }();
  }
  var self = CKEDITOR;
  if (!self.event) {
    self.event = function() {
    };
    self.event.implementOn = function(object) {
      var iterable = self.event.prototype;
      var key;
      for (key in iterable) {
        if (object[key] == undefined) {
          object[key] = iterable[key];
        }
      }
    };
    self.event.prototype = function() {
      var getPrivate = function(obj) {
        var pdataOld = obj.getPrivate && obj.getPrivate() || (obj._ || (obj._ = {}));
        return pdataOld.events || (pdataOld.events = {});
      };
      var eventEntry = function(eventName) {
        this.name = eventName;
        this.listeners = [];
      };
      eventEntry.prototype = {
        getListenerIndex : function(fn) {
          var i = 0;
          var codeSegments = this.listeners;
          for (;i < codeSegments.length;i++) {
            if (codeSegments[i].fn == fn) {
              return i;
            }
          }
          return-1;
        }
      };
      return{
        on : function(name, listener, optgroup, mayParseLabeledStatementInstead, expectedNumberOfNodes) {
          var events = getPrivate(this);
          var event = events[name] || (events[name] = new eventEntry(name));
          if (event.getListenerIndex(listener) < 0) {
            var listeners = event.listeners;
            if (!optgroup) {
              optgroup = this;
            }
            if (isNaN(expectedNumberOfNodes)) {
              expectedNumberOfNodes = 10;
            }
            var self = this;
            var listenerFirer = function(editor, publisherData, stopFn, cancelFn) {
              var pdataOld = {
                name : name,
                sender : this,
                editor : editor,
                data : publisherData,
                listenerData : mayParseLabeledStatementInstead,
                stop : stopFn,
                cancel : cancelFn,
                removeListener : function() {
                  self.removeListener(name, listener);
                }
              };
              listener.call(optgroup, pdataOld);
              return pdataOld.data;
            };
            listenerFirer.fn = listener;
            listenerFirer.priority = expectedNumberOfNodes;
            var i = listeners.length - 1;
            for (;i >= 0;i--) {
              if (listeners[i].priority <= expectedNumberOfNodes) {
                listeners.splice(i + 1, 0, listenerFirer);
                return;
              }
            }
            listeners.unshift(listenerFirer);
          }
        },
        fire : function() {
          var queuedFn = false;
          var o = function() {
            queuedFn = true;
          };
          var pos = false;
          var cancelEvent = function() {
            pos = true;
          };
          return function(eventName, data, isXML) {
            var event = getPrivate(this)[eventName];
            var fn = queuedFn;
            var savedPos4 = pos;
            queuedFn = pos = false;
            if (event) {
              var listeners = event.listeners;
              if (listeners.length) {
                listeners = listeners.slice(0);
                var i = 0;
                for (;i < listeners.length;i++) {
                  var retData = listeners[i].call(this, isXML, data, o, cancelEvent);
                  if (typeof retData != "undefined") {
                    data = retData;
                  }
                  if (queuedFn || pos) {
                    break;
                  }
                }
              }
            }
            var cb = pos || (typeof data == "undefined" ? false : data);
            queuedFn = fn;
            pos = savedPos4;
            return cb;
          };
        }(),
        fireOnce : function(eventName, opt_attributes, editor) {
          var ret = this.fire(eventName, opt_attributes, editor);
          delete getPrivate(this)[eventName];
          return ret;
        },
        removeListener : function(name, listener) {
          var event = getPrivate(this)[name];
          if (event) {
            var i = event.getListenerIndex(listener);
            if (i >= 0) {
              event.listeners.splice(i, 1);
            }
          }
        },
        hasListeners : function(eventName) {
          var event = getPrivate(this)[eventName];
          return event && event.listeners.length > 0;
        }
      };
    }();
  }
  if (!self.editor) {
    self.ELEMENT_MODE_NONE = 0;
    self.ELEMENT_MODE_REPLACE = 1;
    self.ELEMENT_MODE_APPENDTO = 2;
    self.editor = function(instanceConfig, code, element, data) {
      var optgroup = this;
      optgroup._ = {
        instanceConfig : instanceConfig,
        element : code,
        data : data
      };
      optgroup.elementMode = element || 0;
      self.event.call(optgroup);
      optgroup._init();
    };
    self.editor.replace = function(name, value) {
      var element = name;
      if (typeof element != "object") {
        element = document.getElementById(name);
        if (element && element.tagName.toLowerCase() in {
          style : 1,
          script : 1,
          base : 1,
          link : 1,
          meta : 1,
          title : 1
        }) {
          element = null;
        }
        if (!element) {
          var headNode = 0;
          var array = document.getElementsByName(name);
          for (;(element = array[headNode++]) && element.tagName.toLowerCase() != "textarea";) {
          }
        }
        if (!element) {
          throw'[CKEDITOR.editor.replace] The element with id or name "' + name + '" was not found.';
        }
      }
      element.style.visibility = "hidden";
      return new self.editor(value, element, 1);
    };
    self.editor.appendTo = function(element, data, t) {
      var current = element;
      if (typeof current != "object") {
        current = document.getElementById(element);
        if (!current) {
          throw'[CKEDITOR.editor.appendTo] The element with id "' + element + '" was not found.';
        }
      }
      return new self.editor(data, current, 2, t);
    };
    self.editor.prototype = {
      _init : function() {
        var eventPath = self.editor._pending || (self.editor._pending = []);
        eventPath.push(this);
      },
      fire : function(name, opt_attributes) {
        return self.event.prototype.fire.call(this, name, opt_attributes, this);
      },
      fireOnce : function(pdataOld, inplace) {
        return self.event.prototype.fireOnce.call(this, pdataOld, inplace, this);
      }
    };
    self.event.implementOn(self.editor.prototype, true);
  }
  if (!self.env) {
    self.env = function() {
      var agent = navigator.userAgent.toLowerCase();
      var opera = window.opera;
      var env = {
        ie : false,
        opera : !!opera && opera.version,
        webkit : agent.indexOf(" applewebkit/") > -1,
        air : agent.indexOf(" adobeair/") > -1,
        mac : agent.indexOf("macintosh") > -1,
        quirks : document.compatMode == "BackCompat",
        mobile : agent.indexOf("mobile") > -1,
        iOS : /(ipad|iphone|ipod)/.test(agent),
        isCustomDomain : function() {
          if (!this.ie) {
            return false;
          }
          var domain = document.domain;
          var hostname = window.location.hostname;
          return domain != hostname && domain != "[" + hostname + "]";
        },
        secure : location.protocol == "https:"
      };
      env.gecko = navigator.product == "Gecko" && (!env.webkit && !env.opera);
      var version = 0;
      if (env.ie) {
        version = parseFloat(agent.match(/msie (\d+)/)[1]);
        env.ie8 = !!document.documentMode;
        env.ie8Compat = document.documentMode == 8;
        env.ie9Compat = document.documentMode == 9;
        env.ie7Compat = version == 7 && !document.documentMode || document.documentMode == 7;
        env.ie6Compat = version < 7 || env.quirks;
      }
      if (env.gecko) {
        var directives = agent.match(/rv:([\d\.]+)/);
        if (directives) {
          directives = directives[1].split(".");
          version = directives[0] * 1E4 + (directives[1] || 0) * 100 + +(directives[2] || 0);
        }
      }
      if (env.opera) {
        version = parseFloat(opera.version());
      }
      if (env.air) {
        version = parseFloat(agent.match(/ adobeair\/(\d+)/)[1]);
      }
      if (env.webkit) {
        version = parseFloat(agent.match(/ applewebkit\/(\d+)/)[1]);
      }
      env.version = version;
      env.isCompatible = env.iOS && version >= 534 || !env.mobile && (env.ie && version >= 6 || (env.gecko && version >= 10801 || (env.opera && version >= 9.5 || (env.air && version >= 1 || (env.webkit && version >= 522 || false)))));
      env.cssClass = "cke_browser_" + (env.ie ? "ie" : env.gecko ? "gecko" : env.opera ? "opera" : env.webkit ? "webkit" : "unknown");
      if (env.quirks) {
        env.cssClass += " cke_browser_quirks";
      }
      if (env.ie) {
        env.cssClass += " cke_browser_ie" + (env.version < 7 ? "6" : env.version >= 8 ? document.documentMode : "7");
        if (env.quirks) {
          env.cssClass += " cke_browser_iequirks";
        }
      }
      if (env.gecko && version < 10900) {
        env.cssClass += " cke_browser_gecko18";
      }
      if (env.air) {
        env.cssClass += " cke_browser_air";
      }
      return env;
    }();
  }
  var env = self.env;
  var href = env.ie;
  if (self.status == "unloaded") {
    (function() {
      self.event.implementOn(self);
      self.loadFullCore = function() {
        if (self.status != "basic_ready") {
          self.loadFullCore._load = 1;
          return;
        }
        delete self.loadFullCore;
        var requireScript = document.createElement("script");
        requireScript.type = "text/javascript";
        requireScript.src = self.basePath + "ckeditor.js";
        document.getElementsByTagName("head")[0].appendChild(requireScript);
      };
      self.loadFullCoreTimeout = 0;
      self.replaceClass = "ckeditor";
      self.replaceByClassEnabled = 1;
      var createInstance = function(label, actual, callback, data) {
        if (env.isCompatible) {
          if (self.loadFullCore) {
            self.loadFullCore();
          }
          var optgroup = callback(label, actual, data);
          self.add(optgroup);
          return optgroup;
        }
        return null;
      };
      self.replace = function(name, value) {
        return createInstance(name, value, self.editor.replace);
      };
      self.appendTo = function(element, config, data) {
        return createInstance(element, config, self.editor.appendTo, data);
      };
      self.add = function(name) {
        var configList = this._.pending || (this._.pending = []);
        configList.push(name);
      };
      self.replaceAll = function() {
        var codeSegments = document.getElementsByTagName("textarea");
        var i = 0;
        for (;i < codeSegments.length;i++) {
          var pdataOld = null;
          var optgroup = codeSegments[i];
          if (!optgroup.name && !optgroup.id) {
            continue;
          }
          if (typeof arguments[0] == "string") {
            var nocode = new RegExp("(?:^|\\s)" + arguments[0] + "(?:$|\\s)");
            if (!nocode.test(optgroup.className)) {
              continue;
            }
          } else {
            if (typeof arguments[0] == "function") {
              pdataOld = {};
              if (arguments[0](optgroup, pdataOld) === false) {
                continue;
              }
            }
          }
          this.replace(optgroup, pdataOld);
        }
      };
      (function() {
        var onload = function() {
          var loadFullCore = self.loadFullCore;
          var loadFullCoreTimeout = self.loadFullCoreTimeout;
          if (self.replaceByClassEnabled) {
            self.replaceAll(self.replaceClass);
          }
          self.status = "basic_ready";
          if (loadFullCore && loadFullCore._load) {
            loadFullCore();
          } else {
            if (loadFullCoreTimeout) {
              setTimeout(function() {
                if (self.loadFullCore) {
                  self.loadFullCore();
                }
              }, loadFullCoreTimeout * 1E3);
            }
          }
        };
        if (window.addEventListener) {
          window.addEventListener("load", onload, false);
        } else {
          if (window.attachEvent) {
            window.attachEvent("onload", onload);
          }
        }
      })();
      self.status = "basic_loaded";
    })();
  }
  self.dom = {};
  var dom = self.dom;
  (function() {
    var functions = [];
    self.on("reset", function() {
      functions = [];
    });
    self.tools = {
      arrayCompare : function(arrayA, arrayB) {
        if (!arrayA && !arrayB) {
          return true;
        }
        if (!arrayA || (!arrayB || arrayA.length != arrayB.length)) {
          return false;
        }
        var i = 0;
        for (;i < arrayA.length;i++) {
          if (arrayA[i] != arrayB[i]) {
            return false;
          }
        }
        return true;
      },
      clone : function(val) {
        var copy;
        if (val && val instanceof Array) {
          copy = [];
          var attr = 0;
          for (;attr < val.length;attr++) {
            copy[attr] = this.clone(val[attr]);
          }
          return copy;
        }
        if (val === null || (typeof val != "object" || (val instanceof String || (val instanceof Number || (val instanceof Boolean || (val instanceof Date || val instanceof RegExp)))))) {
          return val;
        }
        copy = new val.constructor;
        var i;
        for (i in val) {
          var item = val[i];
          copy[i] = this.clone(item);
        }
        return copy;
      },
      capitalize : function(value) {
        return value.charAt(0).toUpperCase() + value.substring(1).toLowerCase();
      },
      extend : function(opt_attributes) {
        var argsLength = arguments.length;
        var overwrite;
        var obj;
        if (typeof(overwrite = arguments[argsLength - 1]) == "boolean") {
          argsLength--;
        } else {
          if (typeof(overwrite = arguments[argsLength - 2]) == "boolean") {
            obj = arguments[argsLength - 1];
            argsLength -= 2;
          }
        }
        var argsIndex = 1;
        for (;argsIndex < argsLength;argsIndex++) {
          var iterable = arguments[argsIndex];
          var key;
          for (key in iterable) {
            if (overwrite === true || opt_attributes[key] == undefined) {
              if (!obj || key in obj) {
                opt_attributes[key] = iterable[key];
              }
            }
          }
        }
        return opt_attributes;
      },
      prototypedCopy : function(source) {
        var copy = function() {
        };
        copy.prototype = source;
        return new copy;
      },
      isArray : function(obj) {
        return!!obj && obj instanceof Array;
      },
      isEmpty : function(obj) {
        var member;
        for (member in obj) {
          if (obj.hasOwnProperty(member)) {
            return false;
          }
        }
        return true;
      },
      cssStyleToDomStyle : function() {
        var test = document.createElement("div").style;
        var cssFloat = typeof test.cssFloat != "undefined" ? "cssFloat" : typeof test.styleFloat != "undefined" ? "styleFloat" : "float";
        return function(cssName) {
          if (cssName == "float") {
            return cssFloat;
          } else {
            return cssName.replace(/-./g, function(rgb) {
              return rgb.substr(1).toUpperCase();
            });
          }
        };
      }(),
      buildStyleHtml : function(parts) {
        parts = [].concat(parts);
        var part;
        var tagNameArr = [];
        var i = 0;
        for (;i < parts.length;i++) {
          part = parts[i];
          if (/@import|[{}]/.test(part)) {
            tagNameArr.push("<style>" + part + "</style>");
          } else {
            tagNameArr.push('<link type="text/css" rel=stylesheet href="' + part + '">');
          }
        }
        return tagNameArr.join("");
      },
      htmlEncode : function(value) {
        var standard = function(value) {
          var span = new dom.element("span");
          span.setText(value);
          return span.getHtml();
        };
        var fix1 = standard("\n").toLowerCase() == "<br>" ? function(iterator) {
          return standard(iterator).replace(/<br>/gi, "\n");
        } : standard;
        var fix2 = standard(">") == ">" ? function(iterator) {
          return fix1(iterator).replace(/>/g, "&gt;");
        } : fix1;
        var fix3 = standard("  ") == "&nbsp; " ? function(iterator) {
          return fix2(iterator).replace(/&nbsp;/g, " ");
        } : fix2;
        this.htmlEncode = fix3;
        return this.htmlEncode(value);
      },
      htmlEncodeAttr : function(code) {
        return code.replace(/"/g, "&quot;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
      },
      getNextNumber : function() {
        var f = 0;
        return function() {
          return++f;
        };
      }(),
      getNextId : function() {
        return "cke_" + this.getNextNumber();
      },
      override : function(override, functionBuilder) {
        return functionBuilder(override);
      },
      setTimeout : function(fn, min1, scope, args, ownerWindow) {
        if (!ownerWindow) {
          ownerWindow = window;
        }
        if (!scope) {
          scope = ownerWindow;
        }
        return ownerWindow.setTimeout(function() {
          if (args) {
            fn.apply(scope, [].concat(args));
          } else {
            fn.apply(scope);
          }
        }, min1 || 0);
      },
      trim : function() {
        var optgroup = /(?:^[ \t\n\r]+)|(?:[ \t\n\r]+$)/g;
        return function(option) {
          return option.replace(optgroup, "");
        };
      }(),
      ltrim : function() {
        var optgroup = /^[ \t\n\r]+/g;
        return function(option) {
          return option.replace(optgroup, "");
        };
      }(),
      rtrim : function() {
        var optgroup = /[ \t\n\r]+$/g;
        return function(option) {
          return option.replace(optgroup, "");
        };
      }(),
      indexOf : Array.prototype.indexOf ? function(key, timer) {
        return key.indexOf(timer);
      } : function(key, timer) {
        var i = 0;
        var valuesLen = key.length;
        for (;i < valuesLen;i++) {
          if (key[i] === timer) {
            return i;
          }
        }
        return-1;
      },
      bind : function(func, value) {
        return function() {
          return func.apply(value, arguments);
        };
      },
      createClass : function(definition) {
        var $ = definition.$;
        var baseClass = definition.base;
        var privates = definition.privates || definition._;
        var proto = definition.proto;
        var statics = definition.statics;
        if (privates) {
          var fun = $;
          $ = function() {
            var obj = this;
            var _ = obj._ || (obj._ = {});
            var privateName;
            for (privateName in privates) {
              var priv = privates[privateName];
              _[privateName] = typeof priv == "function" ? self.tools.bind(priv, obj) : priv;
            }
            fun.apply(obj, arguments);
          };
        }
        if (baseClass) {
          $.prototype = this.prototypedCopy(baseClass.prototype);
          $.prototype["constructor"] = $;
          $.prototype.base = function() {
            this.base = baseClass.prototype.base;
            baseClass.apply(this, arguments);
            this.base = arguments.callee;
          };
        }
        if (proto) {
          this.extend($.prototype, proto, true);
        }
        if (statics) {
          this.extend($, statics, true);
        }
        return $;
      },
      addFunction : function(fn, scope) {
        return functions.push(function() {
          return fn.apply(scope || this, arguments);
        }) - 1;
      },
      removeFunction : function(ref) {
        functions[ref] = null;
      },
      callFunction : function(name) {
        var fn = functions[name];
        return fn && fn.apply(window, Array.prototype.slice.call(arguments, 1));
      },
      cssLength : function() {
        return function(length) {
          return length + (!length || isNaN(Number(length)) ? "" : "px");
        };
      }(),
      convertToPx : function() {
        var node;
        return function(value) {
          if (!node) {
            node = dom.element.createFromHtml('<div style="position:absolute;left:-9999px;top:-9999px;margin:0px;padding:0px;border:0px;"></div>', self.document);
            self.document.getBody().append(node);
          }
          if (!/%$/.test(value)) {
            node.setStyle("width", value);
            return node.$.clientWidth;
          }
          return value;
        };
      }(),
      repeat : function(sep, times) {
        return(new Array(times + 1)).join(sep);
      },
      tryThese : function() {
        var returnValue;
        var i = 0;
        var argLength = arguments.length;
        for (;i < argLength;i++) {
          var lambda = arguments[i];
          try {
            returnValue = lambda();
            break;
          } catch (j) {
          }
        }
        return returnValue;
      },
      genKey : function() {
        return Array.prototype.slice.call(arguments).join("-");
      }
    };
  })();
  var $ = self.tools;
  self.dtd = function() {
    var merge = $.extend;
    var A = {
      isindex : 1,
      fieldset : 1
    };
    var B = {
      input : 1,
      button : 1,
      select : 1,
      textarea : 1,
      label : 1
    };
    var C = merge({
      a : 1
    }, B);
    var D = merge({
      iframe : 1
    }, C);
    var E = {
      hr : 1,
      ul : 1,
      menu : 1,
      div : 1,
      section : 1,
      header : 1,
      footer : 1,
      nav : 1,
      article : 1,
      aside : 1,
      figure : 1,
      dialog : 1,
      hgroup : 1,
      mark : 1,
      time : 1,
      meter : 1,
      command : 1,
      keygen : 1,
      output : 1,
      progress : 1,
      audio : 1,
      video : 1,
      details : 1,
      datagrid : 1,
      datalist : 1,
      blockquote : 1,
      noscript : 1,
      table : 1,
      center : 1,
      address : 1,
      dir : 1,
      pre : 1,
      h5 : 1,
      dl : 1,
      h4 : 1,
      noframes : 1,
      h6 : 1,
      ol : 1,
      h1 : 1,
      h3 : 1,
      h2 : 1
    };
    var F = {
      ins : 1,
      del : 1,
      script : 1,
      style : 1
    };
    var G = merge({
      b : 1,
      acronym : 1,
      bdo : 1,
      "var" : 1,
      "#" : 1,
      abbr : 1,
      code : 1,
      br : 1,
      i : 1,
      cite : 1,
      kbd : 1,
      u : 1,
      strike : 1,
      s : 1,
      tt : 1,
      strong : 1,
      q : 1,
      samp : 1,
      em : 1,
      dfn : 1,
      span : 1,
      wbr : 1
    }, F);
    var H = merge({
      sub : 1,
      img : 1,
      object : 1,
      sup : 1,
      basefont : 1,
      map : 1,
      applet : 1,
      font : 1,
      big : 1,
      small : 1,
      mark : 1
    }, G);
    var I = merge({
      p : 1
    }, H);
    var J = merge({
      iframe : 1
    }, H, B);
    var K = {
      img : 1,
      noscript : 1,
      br : 1,
      kbd : 1,
      center : 1,
      button : 1,
      basefont : 1,
      h5 : 1,
      h4 : 1,
      samp : 1,
      h6 : 1,
      ol : 1,
      h1 : 1,
      h3 : 1,
      h2 : 1,
      form : 1,
      font : 1,
      "#" : 1,
      select : 1,
      menu : 1,
      ins : 1,
      abbr : 1,
      label : 1,
      code : 1,
      table : 1,
      script : 1,
      cite : 1,
      input : 1,
      iframe : 1,
      strong : 1,
      textarea : 1,
      noframes : 1,
      big : 1,
      small : 1,
      span : 1,
      hr : 1,
      sub : 1,
      bdo : 1,
      "var" : 1,
      div : 1,
      section : 1,
      header : 1,
      footer : 1,
      nav : 1,
      article : 1,
      aside : 1,
      figure : 1,
      dialog : 1,
      hgroup : 1,
      mark : 1,
      time : 1,
      meter : 1,
      menu : 1,
      command : 1,
      keygen : 1,
      output : 1,
      progress : 1,
      audio : 1,
      video : 1,
      details : 1,
      datagrid : 1,
      datalist : 1,
      object : 1,
      sup : 1,
      strike : 1,
      dir : 1,
      map : 1,
      dl : 1,
      applet : 1,
      del : 1,
      isindex : 1,
      fieldset : 1,
      ul : 1,
      b : 1,
      acronym : 1,
      a : 1,
      blockquote : 1,
      i : 1,
      u : 1,
      s : 1,
      tt : 1,
      address : 1,
      q : 1,
      pre : 1,
      p : 1,
      em : 1,
      dfn : 1
    };
    var L = merge({
      a : 1
    }, J);
    var M = {
      tr : 1
    };
    var N = {
      "#" : 1
    };
    var O = merge({
      param : 1
    }, K);
    var P = merge({
      form : 1
    }, A, D, E, I);
    var Q = {
      li : 1
    };
    var R = {
      style : 1,
      script : 1
    };
    var headTags = {
      base : 1,
      link : 1,
      meta : 1,
      title : 1
    };
    var T = merge(headTags, R);
    var U = {
      head : 1,
      body : 1
    };
    var V = {
      html : 1
    };
    var block = {
      address : 1,
      blockquote : 1,
      center : 1,
      dir : 1,
      div : 1,
      section : 1,
      header : 1,
      footer : 1,
      nav : 1,
      article : 1,
      aside : 1,
      figure : 1,
      dialog : 1,
      hgroup : 1,
      time : 1,
      meter : 1,
      menu : 1,
      command : 1,
      keygen : 1,
      output : 1,
      progress : 1,
      audio : 1,
      video : 1,
      details : 1,
      datagrid : 1,
      datalist : 1,
      dl : 1,
      fieldset : 1,
      form : 1,
      h1 : 1,
      h2 : 1,
      h3 : 1,
      h4 : 1,
      h5 : 1,
      h6 : 1,
      hr : 1,
      isindex : 1,
      noframes : 1,
      ol : 1,
      p : 1,
      pre : 1,
      table : 1,
      ul : 1
    };
    return{
      $nonBodyContent : merge(V, U, headTags),
      $block : block,
      $blockLimit : {
        body : 1,
        div : 1,
        section : 1,
        header : 1,
        footer : 1,
        nav : 1,
        article : 1,
        aside : 1,
        figure : 1,
        dialog : 1,
        hgroup : 1,
        time : 1,
        meter : 1,
        menu : 1,
        command : 1,
        keygen : 1,
        output : 1,
        progress : 1,
        audio : 1,
        video : 1,
        details : 1,
        datagrid : 1,
        datalist : 1,
        td : 1,
        th : 1,
        caption : 1,
        form : 1
      },
      $inline : L,
      $body : merge({
        script : 1,
        style : 1
      }, block),
      $cdata : {
        script : 1,
        style : 1
      },
      $empty : {
        area : 1,
        base : 1,
        br : 1,
        col : 1,
        hr : 1,
        img : 1,
        input : 1,
        link : 1,
        meta : 1,
        param : 1,
        wbr : 1
      },
      $listItem : {
        dd : 1,
        dt : 1,
        li : 1
      },
      $list : {
        ul : 1,
        ol : 1,
        dl : 1
      },
      $nonEditable : {
        applet : 1,
        button : 1,
        embed : 1,
        iframe : 1,
        map : 1,
        object : 1,
        option : 1,
        script : 1,
        textarea : 1,
        param : 1,
        audio : 1,
        video : 1
      },
      $captionBlock : {
        caption : 1,
        legend : 1
      },
      $removeEmpty : {
        abbr : 1,
        acronym : 1,
        address : 1,
        b : 1,
        bdo : 1,
        big : 1,
        cite : 1,
        code : 1,
        del : 1,
        dfn : 1,
        em : 1,
        font : 1,
        i : 1,
        ins : 1,
        label : 1,
        kbd : 1,
        q : 1,
        s : 1,
        samp : 1,
        small : 1,
        span : 1,
        strike : 1,
        strong : 1,
        sub : 1,
        sup : 1,
        tt : 1,
        u : 1,
        "var" : 1,
        mark : 1
      },
      $tabIndex : {
        a : 1,
        area : 1,
        button : 1,
        input : 1,
        object : 1,
        select : 1,
        textarea : 1
      },
      $tableContent : {
        caption : 1,
        col : 1,
        colgroup : 1,
        tbody : 1,
        td : 1,
        tfoot : 1,
        th : 1,
        thead : 1,
        tr : 1
      },
      html : U,
      head : T,
      style : N,
      script : N,
      body : P,
      base : {},
      link : {},
      meta : {},
      title : N,
      col : {},
      tr : {
        td : 1,
        th : 1
      },
      img : {},
      colgroup : {
        col : 1
      },
      noscript : P,
      td : P,
      br : {},
      wbr : {},
      th : P,
      center : P,
      kbd : L,
      button : merge(I, E),
      basefont : {},
      h5 : L,
      h4 : L,
      samp : L,
      h6 : L,
      ol : Q,
      h1 : L,
      h3 : L,
      option : N,
      h2 : L,
      form : merge(A, D, E, I),
      select : {
        optgroup : 1,
        option : 1
      },
      font : L,
      ins : L,
      menu : Q,
      abbr : L,
      label : L,
      table : {
        thead : 1,
        col : 1,
        tbody : 1,
        tr : 1,
        colgroup : 1,
        caption : 1,
        tfoot : 1
      },
      code : L,
      tfoot : M,
      cite : L,
      li : P,
      input : {},
      iframe : P,
      strong : L,
      textarea : N,
      noframes : P,
      big : L,
      small : L,
      span : L,
      hr : {},
      dt : L,
      sub : L,
      optgroup : {
        option : 1
      },
      param : {},
      bdo : L,
      "var" : L,
      div : P,
      object : O,
      sup : L,
      dd : P,
      strike : L,
      area : {},
      dir : Q,
      map : merge({
        area : 1,
        form : 1,
        p : 1
      }, A, F, E),
      applet : O,
      dl : {
        dt : 1,
        dd : 1
      },
      del : L,
      isindex : {},
      fieldset : merge({
        legend : 1
      }, K),
      thead : M,
      ul : Q,
      acronym : L,
      b : L,
      a : J,
      blockquote : P,
      caption : L,
      i : L,
      u : L,
      tbody : M,
      s : L,
      address : merge(D, I),
      tt : L,
      legend : L,
      q : L,
      pre : merge(G, C),
      p : L,
      em : L,
      dfn : L,
      section : P,
      header : P,
      footer : P,
      nav : P,
      article : P,
      aside : P,
      figure : P,
      dialog : P,
      hgroup : P,
      mark : L,
      time : L,
      meter : L,
      menu : L,
      command : L,
      keygen : L,
      output : L,
      progress : O,
      audio : O,
      video : O,
      details : O,
      datagrid : O,
      datalist : O
    };
  }();
  var dtd = self.dtd;
  dom.event = function(options) {
    this.$ = options;
  };
  dom.event.prototype = {
    getKey : function() {
      return this.$.keyCode || this.$.which;
    },
    getKeystroke : function() {
      var r = this;
      var keystroke = r.getKey();
      if (r.$.ctrlKey || r.$.metaKey) {
        keystroke += 1114112;
      }
      if (r.$.shiftKey) {
        keystroke += 2228224;
      }
      if (r.$.altKey) {
        keystroke += 4456448;
      }
      return keystroke;
    },
    preventDefault : function(dataAndEvents) {
      var $ = this.$;
      if ($.preventDefault) {
        $.preventDefault();
      } else {
        $.returnValue = false;
      }
      if (dataAndEvents) {
        this.stopPropagation();
      }
    },
    stopPropagation : function() {
      var $ = this.$;
      if ($.stopPropagation) {
        $.stopPropagation();
      } else {
        $.cancelBubble = true;
      }
    },
    getTarget : function() {
      var rawNode = this.$.target || this.$.srcElement;
      return rawNode ? new dom.node(rawNode) : null;
    }
  };
  self.CTRL = 1114112;
  self.SHIFT = 2228224;
  self.ALT = 4456448;
  dom.domObject = function(nativeDomObject) {
    if (nativeDomObject) {
      this.$ = nativeDomObject;
    }
  };
  dom.domObject.prototype = function() {
    var getNativeListener = function(domObject, eventName) {
      return function(domEvent) {
        if (typeof self != "undefined") {
          domObject.fire(eventName, new dom.event(domEvent));
        }
      };
    };
    return{
      getPrivate : function() {
        var priv;
        if (!(priv = this.getCustomData("_"))) {
          this.setCustomData("_", priv = {});
        }
        return priv;
      },
      on : function(name) {
        var doc = this;
        var node = doc.getCustomData("_cke_nativeListeners");
        if (!node) {
          node = {};
          doc.setCustomData("_cke_nativeListeners", node);
        }
        if (!node[name]) {
          var wrapHandler = node[name] = getNativeListener(doc, name);
          if (doc.$.addEventListener) {
            doc.$.addEventListener(name, wrapHandler, !!self.event.useCapture);
          } else {
            if (doc.$.attachEvent) {
              doc.$.attachEvent("on" + name, wrapHandler);
            }
          }
        }
        return self.event.prototype.on.apply(doc, arguments);
      },
      removeListener : function(name) {
        var doc = this;
        self.event.prototype.removeListener.apply(doc, arguments);
        if (!doc.hasListeners(name)) {
          var style = doc.getCustomData("_cke_nativeListeners");
          var domContentLoaded = style && style[name];
          if (domContentLoaded) {
            if (doc.$.removeEventListener) {
              doc.$.removeEventListener(name, domContentLoaded, false);
            } else {
              if (doc.$.detachEvent) {
                doc.$.detachEvent("on" + name, domContentLoaded);
              }
            }
            delete style[name];
          }
        }
      },
      removeAllListeners : function() {
        var doc = this;
        var testSource = doc.getCustomData("_cke_nativeListeners");
        var name;
        for (name in testSource) {
          var ref = testSource[name];
          if (doc.$.detachEvent) {
            doc.$.detachEvent("on" + name, ref);
          } else {
            if (doc.$.removeEventListener) {
              doc.$.removeEventListener(name, ref, false);
            }
          }
          delete testSource[name];
        }
      }
    };
  }();
  (function(domObjectProto) {
    var customData = {};
    self.on("reset", function() {
      customData = {};
    });
    domObjectProto.equals = function(name) {
      return name && name.$ === this.$;
    };
    domObjectProto.setCustomData = function(key, dataAndEvents) {
      var expandoNumber = this.getUniqueId();
      var $cookies = customData[expandoNumber] || (customData[expandoNumber] = {});
      $cookies[key] = dataAndEvents;
      return this;
    };
    domObjectProto.getCustomData = function(key) {
      var expandoNumber = this.$["data-cke-expando"];
      var dataSlot = expandoNumber && customData[expandoNumber];
      return dataSlot && dataSlot[key];
    };
    domObjectProto.removeCustomData = function(key) {
      var expandoNumber = this.$["data-cke-expando"];
      var dataSlot = expandoNumber && customData[expandoNumber];
      var retval = dataSlot && dataSlot[key];
      if (typeof retval != "undefined") {
        delete dataSlot[key];
      }
      return retval || null;
    };
    domObjectProto.clearCustomData = function() {
      this.removeAllListeners();
      var expandoNumber = this.$["data-cke-expando"];
      if (expandoNumber) {
        delete customData[expandoNumber];
      }
    };
    domObjectProto.getUniqueId = function() {
      return this.$["data-cke-expando"] || (this.$["data-cke-expando"] = $.getNextNumber());
    };
    self.event.implementOn(domObjectProto);
  })(dom.domObject.prototype);
  dom.window = function(isXML) {
    dom.domObject.call(this, isXML);
  };
  dom.window.prototype = new dom.domObject;
  $.extend(dom.window.prototype, {
    focus : function() {
      if (env.webkit && this.$.parent) {
        this.$.parent.focus();
      }
      this.$.focus();
    },
    getViewPaneSize : function() {
      var doc = this.$.document;
      var stdMode = doc.compatMode == "CSS1Compat";
      return{
        width : (stdMode ? doc.documentElement.clientWidth : doc.body.clientWidth) || 0,
        height : (stdMode ? doc.documentElement.clientHeight : doc.body.clientHeight) || 0
      };
    },
    getScrollPosition : function() {
      var $ = this.$;
      if ("pageXOffset" in $) {
        return{
          x : $.pageXOffset || 0,
          y : $.pageYOffset || 0
        };
      } else {
        var doc = $.document;
        return{
          x : doc.documentElement.scrollLeft || (doc.body.scrollLeft || 0),
          y : doc.documentElement.scrollTop || (doc.body.scrollTop || 0)
        };
      }
    }
  });
  dom.document = function(name) {
    dom.domObject.call(this, name);
  };
  var doc = dom.document;
  doc.prototype = new dom.domObject;
  $.extend(doc.prototype, {
    appendStyleSheet : function(cssFileUrl) {
      if (this.$.createStyleSheet) {
        this.$.createStyleSheet(cssFileUrl);
      } else {
        var link = new dom.element("link");
        link.setAttributes({
          rel : "stylesheet",
          type : "text/css",
          href : cssFileUrl
        });
        this.getHead().append(link);
      }
    },
    appendStyleText : function(cssStyleText) {
      var doc = this;
      if (doc.$.createStyleSheet) {
        var styleSheet = doc.$.createStyleSheet("");
        styleSheet.cssText = cssStyleText;
      } else {
        var style = new dom.element("style", doc);
        style.append(new dom.text(cssStyleText, doc));
        doc.getHead().append(style);
      }
    },
    createElement : function(name, attrs) {
      var element = new dom.element(name, this);
      if (attrs) {
        if (attrs.attributes) {
          element.setAttributes(attrs.attributes);
        }
        if (attrs.styles) {
          element.setStyles(attrs.styles);
        }
      }
      return element;
    },
    createText : function(text) {
      return new dom.text(text, this);
    },
    focus : function() {
      this.getWindow().focus();
    },
    getById : function(id) {
      var found = this.$.getElementById(id);
      return found ? new dom.element(found) : null;
    },
    getByAddress : function(codeSegments, normalized) {
      var $ = this.$.documentElement;
      var i = 0;
      for (;$ && i < codeSegments.length;i++) {
        var target = codeSegments[i];
        if (!normalized) {
          $ = $.childNodes[target];
          continue;
        }
        var currentIndex = -1;
        var j = 0;
        for (;j < $.childNodes.length;j++) {
          var candidate = $.childNodes[j];
          if (normalized === true && (candidate.nodeType == 3 && (candidate.previousSibling && candidate.previousSibling.nodeType == 3))) {
            continue;
          }
          currentIndex++;
          if (currentIndex == target) {
            $ = candidate;
            break;
          }
        }
      }
      return $ ? new dom.node($) : null;
    },
    getElementsByTag : function(selector, err) {
      if (!(href && !(document.documentMode > 8)) && err) {
        selector = err + ":" + selector;
      }
      return new dom.nodeList(this.$.getElementsByTagName(selector));
    },
    getHead : function() {
      var head = this.$.getElementsByTagName("head")[0];
      if (!head) {
        head = this.getDocumentElement().append(new dom.element("head"), true);
      } else {
        head = new dom.element(head);
      }
      return(this.getHead = function() {
        return head;
      })();
    },
    getBody : function() {
      var body = new dom.element(this.$.body);
      return(this.getBody = function() {
        return body;
      })();
    },
    getDocumentElement : function() {
      var documentElement = new dom.element(this.$.documentElement);
      return(this.getDocumentElement = function() {
        return documentElement;
      })();
    },
    getWindow : function() {
      var win = new dom.window(this.$.parentWindow || this.$.defaultView);
      return(this.getWindow = function() {
        return win;
      })();
    },
    write : function(text) {
      var frameDocument = this;
      frameDocument.$.open("text/html", "replace");
      if (env.isCustomDomain()) {
        frameDocument.$.domain = document.domain;
      }
      frameDocument.$.write(text);
      frameDocument.$.close();
    }
  });
  dom.node = function(name) {
    if (name) {
      var type = name.nodeType == 9 ? "document" : name.nodeType == 1 ? "element" : name.nodeType == 3 ? "text" : name.nodeType == 8 ? "comment" : "domObject";
      return new dom[type](name);
    }
    return this;
  };
  dom.node.prototype = new dom.domObject;
  self.NODE_ELEMENT = 1;
  self.NODE_DOCUMENT = 9;
  self.NODE_TEXT = 3;
  self.NODE_COMMENT = 8;
  self.NODE_DOCUMENT_FRAGMENT = 11;
  self.POSITION_IDENTICAL = 0;
  self.POSITION_DISCONNECTED = 1;
  self.POSITION_FOLLOWING = 2;
  self.POSITION_PRECEDING = 4;
  self.POSITION_IS_CONTAINED = 8;
  self.POSITION_CONTAINS = 16;
  $.extend(dom.node.prototype, {
    appendTo : function(element, node) {
      element.append(this, node);
      return element;
    },
    clone : function(recurring, dataAndEvents) {
      var $clone = this.$.cloneNode(recurring);
      var removeIds = function(node) {
        if (node.nodeType != 1) {
          return;
        }
        if (!dataAndEvents) {
          node.removeAttribute("id", false);
        }
        node.removeAttribute("data-cke-expando", false);
        if (recurring) {
          var codeSegments = node.childNodes;
          var i = 0;
          for (;i < codeSegments.length;i++) {
            removeIds(codeSegments[i]);
          }
        }
      };
      removeIds($clone);
      return new dom.node($clone);
    },
    hasPrevious : function() {
      return!!this.$.previousSibling;
    },
    hasNext : function() {
      return!!this.$.nextSibling;
    },
    insertAfter : function(name) {
      name.$.parentNode.insertBefore(this.$, name.$.nextSibling);
      return name;
    },
    insertBefore : function(name) {
      name.$.parentNode.insertBefore(this.$, name.$);
      return name;
    },
    insertBeforeMe : function(node) {
      this.$.parentNode.insertBefore(node.$, this.$);
      return node;
    },
    getAddress : function(isXML) {
      var address = [];
      var $documentElement = this.getDocument().$.documentElement;
      var node = this.$;
      for (;node && node != $documentElement;) {
        var parentNode = node.parentNode;
        if (parentNode) {
          address.unshift(this.getIndex.call({
            $ : node
          }, isXML));
        }
        node = parentNode;
      }
      return address;
    },
    getDocument : function() {
      return new doc(this.$.ownerDocument || this.$.parentNode.ownerDocument);
    },
    getIndex : function(dataAndEvents) {
      var current = this.$;
      var index = 0;
      for (;current = current.previousSibling;) {
        if (dataAndEvents && (current.nodeType == 3 && (!current.nodeValue.length || current.previousSibling && current.previousSibling.nodeType == 3))) {
          continue;
        }
        index++;
      }
      return index;
    },
    getNextSourceNode : function(recurring, opt_isDefault, guard) {
      if (guard && !guard.call) {
        var match = guard;
        guard = function(node) {
          return!node.equals(match);
        };
      }
      var node = !recurring && (this.getFirst && this.getFirst());
      var parent;
      if (!node) {
        if (this.type == 1 && (guard && guard(this, true) === false)) {
          return null;
        }
        node = this.getNext();
      }
      for (;!node && (parent = (parent || this).getParent());) {
        if (guard && guard(parent, true) === false) {
          return null;
        }
        node = parent.getNext();
      }
      if (!node) {
        return null;
      }
      if (guard && guard(node) === false) {
        return null;
      }
      if (opt_isDefault && opt_isDefault != node.type) {
        return node.getNextSourceNode(false, opt_isDefault, guard);
      }
      return node;
    },
    getPreviousSourceNode : function(recurring, nodeType, guard) {
      if (guard && !guard.call) {
        var match = guard;
        guard = function(node) {
          return!node.equals(match);
        };
      }
      var node = !recurring && (this.getLast && this.getLast());
      var parent;
      if (!node) {
        if (this.type == 1 && (guard && guard(this, true) === false)) {
          return null;
        }
        node = this.getPrevious();
      }
      for (;!node && (parent = (parent || this).getParent());) {
        if (guard && guard(parent, true) === false) {
          return null;
        }
        node = parent.getPrevious();
      }
      if (!node) {
        return null;
      }
      if (guard && guard(node) === false) {
        return null;
      }
      if (nodeType && node.type != nodeType) {
        return node.getPreviousSourceNode(false, nodeType, guard);
      }
      return node;
    },
    getPrevious : function(evaluator) {
      var previous = this.$;
      var optgroup;
      do {
        previous = previous.previousSibling;
        optgroup = previous && (previous.nodeType != 10 && new dom.node(previous));
      } while (optgroup && (evaluator && !evaluator(optgroup)));
      return optgroup;
    },
    getNext : function(evaluator) {
      var next = this.$;
      var optgroup;
      do {
        next = next.nextSibling;
        optgroup = next && new dom.node(next);
      } while (optgroup && (evaluator && !evaluator(optgroup)));
      return optgroup;
    },
    getParent : function() {
      var parent = this.$.parentNode;
      return parent && parent.nodeType == 1 ? new dom.node(parent) : null;
    },
    getParents : function(closerFirst) {
      var node = this;
      var parents = [];
      do {
        parents[closerFirst ? "push" : "unshift"](node);
      } while (node = node.getParent());
      return parents;
    },
    getCommonAncestor : function(root) {
      var node = this;
      if (root.equals(node)) {
        return node;
      }
      if (root.contains && root.contains(node)) {
        return root;
      }
      var n = node.contains ? node : node.getParent();
      do {
        if (n.contains(root)) {
          return n;
        }
      } while (n = n.getParent());
      return null;
    },
    getPosition : function(node) {
      var node1 = this.$;
      var node2 = node.$;
      if (node1.compareDocumentPosition) {
        return node1.compareDocumentPosition(node2);
      }
      if (node1 == node2) {
        return 0;
      }
      if (this.type == 1 && node.type == 1) {
        if (node1.contains) {
          if (node1.contains(node2)) {
            return 16 + 4;
          }
          if (node2.contains(node1)) {
            return 8 + 2;
          }
        }
        if ("sourceIndex" in node1) {
          return node1.sourceIndex < 0 || node2.sourceIndex < 0 ? 1 : node1.sourceIndex < node2.sourceIndex ? 4 : 2;
        }
      }
      var addressOfThis = this.getAddress();
      var addressOfOther = node.getAddress();
      var minLevel = Math.min(addressOfThis.length, addressOfOther.length);
      var i = 0;
      for (;i <= minLevel - 1;i++) {
        if (addressOfThis[i] != addressOfOther[i]) {
          if (i < minLevel) {
            return addressOfThis[i] < addressOfOther[i] ? 4 : 2;
          }
          break;
        }
      }
      return addressOfThis.length < addressOfOther.length ? 16 + 4 : 8 + 2;
    },
    getAscendant : function(name, dataAndEvents) {
      var $ = this.$;
      var f;
      if (!dataAndEvents) {
        $ = $.parentNode;
      }
      for (;$;) {
        if ($.nodeName && (f = $.nodeName.toLowerCase(), typeof name == "string" ? f == name : f in name)) {
          return new dom.node($);
        }
        $ = $.parentNode;
      }
      return null;
    },
    hasAscendant : function(name, dataAndEvents) {
      var $ = this.$;
      if (!dataAndEvents) {
        $ = $.parentNode;
      }
      for (;$;) {
        if ($.nodeName && $.nodeName.toLowerCase() == name) {
          return true;
        }
        $ = $.parentNode;
      }
      return false;
    },
    move : function(element, dataAndEvents) {
      element.append(this.remove(), dataAndEvents);
    },
    remove : function(name) {
      var pdataOld = this.$;
      var parent = pdataOld.parentNode;
      if (parent) {
        if (name) {
          var child;
          for (;child = pdataOld.firstChild;) {
            parent.insertBefore(pdataOld.removeChild(child), pdataOld);
          }
        }
        parent.removeChild(pdataOld);
      }
      return this;
    },
    replace : function(name) {
      this.insertBefore(name);
      name.remove();
    },
    trim : function() {
      this.ltrim();
      this.rtrim();
    },
    ltrim : function() {
      var outer = this;
      var child;
      for (;outer.getFirst && (child = outer.getFirst());) {
        if (child.type == 3) {
          var trimmed = $.ltrim(child.getText());
          var originalLength = child.getLength();
          if (!trimmed) {
            child.remove();
            continue;
          } else {
            if (trimmed.length < originalLength) {
              child.split(originalLength - trimmed.length);
              outer.$.removeChild(outer.$.firstChild);
            }
          }
        }
        break;
      }
    },
    rtrim : function() {
      var element = this;
      var child;
      for (;element.getLast && (child = element.getLast());) {
        if (child.type == 3) {
          var trimmed = $.rtrim(child.getText());
          var originalLength = child.getLength();
          if (!trimmed) {
            child.remove();
            continue;
          } else {
            if (trimmed.length < originalLength) {
              child.split(trimmed.length);
              element.$.lastChild.parentNode.removeChild(element.$.lastChild);
            }
          }
        }
        break;
      }
      if (!href && !env.opera) {
        child = element.$.lastChild;
        if (child && (child.type == 1 && child.nodeName.toLowerCase() == "br")) {
          child.parentNode.removeChild(child);
        }
      }
    },
    isReadOnly : function() {
      var element = this;
      if (this.type != 1) {
        element = this.getParent();
      }
      if (element && typeof element.$.isContentEditable != "undefined") {
        return!(element.$.isContentEditable || element.data("cke-editable"));
      } else {
        var current = element;
        for (;current;) {
          if (current.is("body") || !!current.data("cke-editable")) {
            break;
          }
          if (current.getAttribute("contentEditable") == "false") {
            return true;
          } else {
            if (current.getAttribute("contentEditable") == "true") {
              break;
            }
          }
          current = current.getParent();
        }
        return false;
      }
    }
  });
  dom.nodeList = function(nativeList) {
    this.$ = nativeList;
  };
  dom.nodeList.prototype = {
    count : function() {
      return this.$.length;
    },
    getItem : function(index) {
      var $node = this.$[index];
      return $node ? new dom.node($node) : null;
    }
  };
  dom.element = function(name, value) {
    if (typeof name == "string") {
      name = (value ? value.$ : document).createElement(name);
    }
    dom.domObject.call(this, name);
  };
  var Node = dom.element;
  Node.get = function(element) {
    return element && (element.$ ? element : new Node(element));
  };
  Node.prototype = new dom.node;
  Node.createFromHtml = function(html, val) {
    var temp = new Node("div", val);
    temp.setHtml(html);
    return temp.getFirst().remove();
  };
  Node.setMarker = function(database, element, name, dataAndEvents) {
    var id = element.getCustomData("list_marker_id") || element.setCustomData("list_marker_id", $.getNextNumber()).getCustomData("list_marker_id");
    var old = element.getCustomData("list_marker_names") || element.setCustomData("list_marker_names", {}).getCustomData("list_marker_names");
    database[id] = element;
    old[name] = 1;
    return element.setCustomData(name, dataAndEvents);
  };
  Node.clearAllMarkers = function(database) {
    var i;
    for (i in database) {
      Node.clearMarkers(database, database[i], 1);
    }
  };
  Node.clearMarkers = function(database, element, dataAndEvents) {
    var names = element.getCustomData("list_marker_names");
    var id = element.getCustomData("list_marker_id");
    var i;
    for (i in names) {
      element.removeCustomData(i);
    }
    element.removeCustomData("list_marker_names");
    if (dataAndEvents) {
      element.removeCustomData("list_marker_id");
      delete database[id];
    }
  };
  $.extend(Node.prototype, {
    type : 1,
    addClass : function(className) {
      var c = this.$.className;
      if (c) {
        var re = new RegExp("(?:^|\\s)" + className + "(?:\\s|$)", "");
        if (!re.test(c)) {
          c += " " + className;
        }
      }
      this.$.className = c || className;
    },
    removeClass : function(className) {
      var c = this.getAttribute("class");
      if (c) {
        var optgroup = new RegExp("(?:^|\\s+)" + className + "(?=\\s|$)", "i");
        if (optgroup.test(c)) {
          c = c.replace(optgroup, "").replace(/^\s+/, "");
          if (c) {
            this.setAttribute("class", c);
          } else {
            this.removeAttribute("class");
          }
        }
      }
    },
    hasClass : function(className) {
      var regex = new RegExp("(?:^|\\s+)" + className + "(?=\\s|$)", "");
      return regex.test(this.getAttribute("class"));
    },
    append : function(node, dataAndEvents) {
      var element = this;
      if (typeof node == "string") {
        node = element.getDocument().createElement(node);
      }
      if (dataAndEvents) {
        element.$.insertBefore(node.$, element.$.firstChild);
      } else {
        element.$.appendChild(node.$);
      }
      return node;
    },
    appendHtml : function(html) {
      var element = this;
      if (!element.$.childNodes.length) {
        element.setHtml(html);
      } else {
        var div = new Node("div", element.getDocument());
        div.setHtml(html);
        div.moveChildren(element);
      }
    },
    appendText : function(text) {
      if (this.$.text != undefined) {
        this.$.text += text;
      } else {
        this.append(new dom.text(text));
      }
    },
    appendBogus : function() {
      var element = this;
      var node = element.getLast();
      for (;node && (node.type == 3 && !$.rtrim(node.getText()));) {
        node = node.getPrevious();
      }
      if (!node || (!node.is || !node.is("br"))) {
        var n = env.opera ? element.getDocument().createText("") : element.getDocument().createElement("br");
        if (env.gecko) {
          n.setAttribute("type", "_moz");
        }
        element.append(n);
      }
    },
    breakParent : function(child) {
      var startNode = this;
      var range = new dom.range(startNode.getDocument());
      range.setStartAfter(startNode);
      range.setEndAfter(child);
      var clone2 = range.extractContents();
      range.insertNode(startNode.remove());
      clone2.insertAfterNode(startNode);
    },
    contains : href || env.webkit ? function(node) {
      var $ = this.$;
      return node.type != 1 ? $.contains(node.getParent().$) : $ != node.$ && $.contains(node.$);
    } : function(node) {
      return!!(this.$.compareDocumentPosition(node.$) & 16);
    },
    focus : function() {
      function listener() {
        try {
          this.$.focus();
        } catch (j) {
        }
      }
      return function(dataAndEvents) {
        if (dataAndEvents) {
          $.setTimeout(listener, 100, this);
        } else {
          listener.call(this);
        }
      };
    }(),
    getHtml : function() {
      var text = this.$.innerHTML;
      return href ? text.replace(/<\?[^>]*>/g, "") : text;
    },
    getOuterHtml : function() {
      var config = this;
      if (config.$.outerHTML) {
        return config.$.outerHTML.replace(/<\?[^>]*>/, "");
      }
      var tmpDiv = config.$.ownerDocument.createElement("div");
      tmpDiv.appendChild(config.$.cloneNode(true));
      return tmpDiv.innerHTML;
    },
    setHtml : function(str) {
      return this.$.innerHTML = str;
    },
    setText : function(text) {
      Node.prototype.setText = this.$.innerText != undefined ? function(text) {
        return this.$.innerText = text;
      } : function(text) {
        return this.$.textContent = text;
      };
      return this.setText(text);
    },
    getAttribute : function() {
      var standard = function(name) {
        return this.$.getAttribute(name, 2);
      };
      if (href && (env.ie7Compat || env.ie6Compat)) {
        return function(name) {
          var optgroup = this;
          switch(name) {
            case "class":
              name = "className";
              break;
            case "http-equiv":
              name = "httpEquiv";
              break;
            case "name":
              return optgroup.$.name;
            case "tabindex":
              var el = standard.call(optgroup, name);
              if (el !== 0 && optgroup.$.tabIndex === 0) {
                el = null;
              }
              return el;
              break;
            case "checked":
              var attr = optgroup.$.attributes.getNamedItem(name);
              var attrValue = attr.specified ? attr.nodeValue : optgroup.$.checked;
              return attrValue ? "checked" : null;
            case "hspace":
            ;
            case "value":
              return optgroup.$[name];
            case "style":
              return optgroup.$.style.cssText;
            case "contenteditable":
            ;
            case "contentEditable":
              return optgroup.$.attributes.getNamedItem("contentEditable").specified ? optgroup.$.getAttribute("contentEditable") : null;
          }
          return standard.call(optgroup, name);
        };
      } else {
        return standard;
      }
    }(),
    getChildren : function() {
      return new dom.nodeList(this.$.childNodes);
    },
    getComputedStyle : href ? function(property) {
      return this.$.currentStyle[$.cssStyleToDomStyle(property)];
    } : function(property) {
      return this.getWindow().$.getComputedStyle(this.$, "").getPropertyValue(property);
    },
    getDtd : function() {
      var pDtd = dtd[this.getName()];
      this.getDtd = function() {
        return pDtd;
      };
      return pDtd;
    },
    getElementsByTag : doc.prototype.getElementsByTag,
    getTabIndex : href ? function() {
      var tabIndex = this.$.tabIndex;
      if (tabIndex === 0 && (!dtd.$tabIndex[this.getName()] && parseInt(this.getAttribute("tabindex"), 10) !== 0)) {
        tabIndex = -1;
      }
      return tabIndex;
    } : env.webkit ? function() {
      var tabIndex = this.$.tabIndex;
      if (tabIndex == undefined) {
        tabIndex = parseInt(this.getAttribute("tabindex"), 10);
        if (isNaN(tabIndex)) {
          tabIndex = -1;
        }
      }
      return tabIndex;
    } : function() {
      return this.$.tabIndex;
    },
    getText : function() {
      return this.$.textContent || (this.$.innerText || "");
    },
    getWindow : function() {
      return this.getDocument().getWindow();
    },
    getId : function() {
      return this.$.id || null;
    },
    getNameAtt : function() {
      return this.$.name || null;
    },
    getName : function() {
      var nodeName = this.$.nodeName.toLowerCase();
      if (href && !(document.documentMode > 8)) {
        var scopeName = this.$.scopeName;
        if (scopeName != "HTML") {
          nodeName = scopeName.toLowerCase() + ":" + nodeName;
        }
      }
      return(this.getName = function() {
        return nodeName;
      })();
    },
    getValue : function() {
      return this.$.value;
    },
    getFirst : function(evaluator) {
      var first = this.$.firstChild;
      var optgroup = first && new dom.node(first);
      if (optgroup && (evaluator && !evaluator(optgroup))) {
        optgroup = optgroup.getNext(evaluator);
      }
      return optgroup;
    },
    getLast : function(evaluator) {
      var last = this.$.lastChild;
      var optgroup = last && new dom.node(last);
      if (optgroup && (evaluator && !evaluator(optgroup))) {
        optgroup = optgroup.getPrevious(evaluator);
      }
      return optgroup;
    },
    getStyle : function(name) {
      return this.$.style[$.cssStyleToDomStyle(name)];
    },
    is : function() {
      var name = this.getName();
      var i = 0;
      for (;i < arguments.length;i++) {
        if (arguments[i] == name) {
          return true;
        }
      }
      return false;
    },
    isEditable : function(recurring) {
      var element = this;
      var name = element.getName();
      if (element.isReadOnly() || (element.getComputedStyle("display") == "none" || (element.getComputedStyle("visibility") == "hidden" || (element.is("a") && (element.data("cke-saved-name") && !element.getChildCount()) || (dtd.$nonEditable[name] || dtd.$empty[name]))))) {
        return false;
      }
      if (recurring !== false) {
        var m = dtd[name] || dtd.span;
        return m && m["#"];
      }
      return true;
    },
    isIdentical : function(otherElement) {
      if (this.getName() != otherElement.getName()) {
        return false;
      }
      var thisAttribs = this.$.attributes;
      var otherAttribs = otherElement.$.attributes;
      var valuesLen = thisAttribs.length;
      var otherLength = otherAttribs.length;
      var i = 0;
      for (;i < valuesLen;i++) {
        var attribute = thisAttribs[i];
        if (attribute.nodeName == "_moz_dirty") {
          continue;
        }
        if ((!href || attribute.specified && attribute.nodeName != "data-cke-expando") && attribute.nodeValue != otherElement.getAttribute(attribute.nodeName)) {
          return false;
        }
      }
      if (href) {
        i = 0;
        for (;i < otherLength;i++) {
          attribute = otherAttribs[i];
          if (attribute.specified && (attribute.nodeName != "data-cke-expando" && attribute.nodeValue != this.getAttribute(attribute.nodeName))) {
            return false;
          }
        }
      }
      return true;
    },
    isVisible : function() {
      var element = this;
      var i = (element.$.offsetHeight || element.$.offsetWidth) && element.getComputedStyle("visibility") != "hidden";
      var currentWindow;
      var elementWindowFrame;
      if (i && (env.webkit || env.opera)) {
        currentWindow = element.getWindow();
        if (!currentWindow.equals(self.document.getWindow()) && (elementWindowFrame = currentWindow.$.frameElement)) {
          i = (new Node(elementWindowFrame)).isVisible();
        }
      }
      return!!i;
    },
    isEmptyInlineRemoveable : function() {
      if (!dtd.$removeEmpty[this.getName()]) {
        return false;
      }
      var children = this.getChildren();
      var i = 0;
      var padLength = children.count();
      for (;i < padLength;i++) {
        var child = children.getItem(i);
        if (child.type == 1 && child.data("cke-bookmark")) {
          continue;
        }
        if (child.type == 1 && !child.isEmptyInlineRemoveable() || child.type == 3 && $.trim(child.getText())) {
          return false;
        }
      }
      return true;
    },
    hasAttributes : href && (env.ie7Compat || env.ie6Compat) ? function() {
      var attributes = this.$.attributes;
      var i = 0;
      for (;i < attributes.length;i++) {
        var attribute = attributes[i];
        switch(attribute.nodeName) {
          case "class":
            if (this.getAttribute("class")) {
              return true;
            }
          ;
          case "data-cke-expando":
            continue;
          default:
            if (attribute.specified) {
              return true;
            }
          ;
        }
      }
      return false;
    } : function() {
      var attrs = this.$.attributes;
      var al = attrs.length;
      var execludeAttrs = {
        "data-cke-expando" : 1,
        _moz_dirty : 1
      };
      return al > 0 && (al > 2 || (!execludeAttrs[attrs[0].nodeName] || al == 2 && !execludeAttrs[attrs[1].nodeName]));
    },
    hasAttribute : function() {
      function standard(name) {
        var $attr = this.$.attributes.getNamedItem(name);
        return!!($attr && $attr.specified);
      }
      return href && env.version < 8 ? function(isXML) {
        if (isXML == "name") {
          return!!this.$.name;
        }
        return standard.call(this, isXML);
      } : standard;
    }(),
    hide : function() {
      this.setStyle("display", "none");
    },
    moveChildren : function(el, toStart) {
      var node = this.$;
      el = el.$;
      if (node == el) {
        return;
      }
      var child;
      if (toStart) {
        for (;child = node.lastChild;) {
          el.insertBefore(node.removeChild(child), el.firstChild);
        }
      } else {
        for (;child = node.firstChild;) {
          el.appendChild(node.removeChild(child));
        }
      }
    },
    mergeSiblings : function() {
      function mergeElements(element, sibling, isNext) {
        if (sibling && sibling.type == 1) {
          var pendingNodes = [];
          for (;sibling.data("cke-bookmark") || sibling.isEmptyInlineRemoveable();) {
            pendingNodes.push(sibling);
            sibling = isNext ? sibling.getNext() : sibling.getPrevious();
            if (!sibling || sibling.type != 1) {
              return;
            }
          }
          if (element.isIdentical(sibling)) {
            var innerSibling = isNext ? element.getLast() : element.getFirst();
            for (;pendingNodes.length;) {
              pendingNodes.shift().move(element, !isNext);
            }
            sibling.moveChildren(element, !isNext);
            sibling.remove();
            if (innerSibling && innerSibling.type == 1) {
              innerSibling.mergeSiblings();
            }
          }
        }
      }
      return function(dataAndEvents) {
        var element = this;
        if (!(dataAndEvents === false || (dtd.$removeEmpty[element.getName()] || element.is("a")))) {
          return;
        }
        mergeElements(element, element.getNext(), true);
        mergeElements(element, element.getPrevious());
      };
    }(),
    show : function() {
      this.setStyles({
        display : "",
        visibility : ""
      });
    },
    setAttribute : function() {
      var standard = function(name, value) {
        this.$.setAttribute(name, value);
        return this;
      };
      if (href && (env.ie7Compat || env.ie6Compat)) {
        return function(name, value) {
          var optgroup = this;
          if (name == "class") {
            optgroup.$.className = value;
          } else {
            if (name == "style") {
              optgroup.$.style.cssText = value;
            } else {
              if (name == "tabindex") {
                optgroup.$.tabIndex = value;
              } else {
                if (name == "checked") {
                  optgroup.$.checked = value;
                } else {
                  if (name == "contenteditable") {
                    standard.call(optgroup, "contentEditable", value);
                  } else {
                    standard.apply(optgroup, arguments);
                  }
                }
              }
            }
          }
          return optgroup;
        };
      } else {
        if (env.ie8Compat && env.secure) {
          return function(attributeName, optionsString) {
            if (attributeName == "src" && optionsString.match(/^http:\/\//)) {
              try {
                standard.apply(this, arguments);
              } catch (l) {
              }
            } else {
              standard.apply(this, arguments);
            }
            return this;
          };
        } else {
          return standard;
        }
      }
    }(),
    setAttributes : function(attributes) {
      var a;
      for (a in attributes) {
        this.setAttribute(a, attributes[a]);
      }
      return this;
    },
    setValue : function(value) {
      this.$.value = value;
      return this;
    },
    removeAttribute : function() {
      var standard = function(name) {
        this.$.removeAttribute(name);
      };
      if (href && (env.ie7Compat || env.ie6Compat)) {
        return function(isXML) {
          if (isXML == "class") {
            isXML = "className";
          } else {
            if (isXML == "tabindex") {
              isXML = "tabIndex";
            } else {
              if (isXML == "contenteditable") {
                isXML = "contentEditable";
              }
            }
          }
          standard.call(this, isXML);
        };
      } else {
        return standard;
      }
    }(),
    removeAttributes : function(attributes) {
      if ($.isArray(attributes)) {
        var i = 0;
        for (;i < attributes.length;i++) {
          this.removeAttribute(attributes[i]);
        }
      } else {
        var key;
        for (key in attributes) {
          if (attributes.hasOwnProperty(key)) {
            this.removeAttribute(key);
          }
        }
      }
    },
    removeStyle : function(name) {
      var s = this.$.style;
      if (s.removeProperty) {
        s.removeProperty(name);
      } else {
        s.removeAttribute($.cssStyleToDomStyle(name));
      }
      if (!this.$.style.cssText) {
        this.removeAttribute("style");
      }
    },
    setStyle : function(prop, value) {
      this.$.style[$.cssStyleToDomStyle(prop)] = value;
      return this;
    },
    setStyles : function(opt_attributes) {
      var prop;
      for (prop in opt_attributes) {
        this.setStyle(prop, opt_attributes[prop]);
      }
      return this;
    },
    setOpacity : function(opacity) {
      if (href && env.version < 9) {
        opacity = Math.round(opacity * 100);
        this.setStyle("filter", opacity >= 100 ? "" : "progid:DXImageTransform.Microsoft.Alpha(opacity=" + opacity + ")");
      } else {
        this.setStyle("opacity", opacity);
      }
    },
    unselectable : env.gecko ? function() {
      this.$.style.MozUserSelect = "none";
      this.on("dragstart", function(evt) {
        evt.data.preventDefault();
      });
    } : env.webkit ? function() {
      this.$.style.KhtmlUserSelect = "none";
      this.on("dragstart", function(evt) {
        evt.data.preventDefault();
      });
    } : function() {
      if (href || env.opera) {
        var element = this.$;
        var seed = element.getElementsByTagName("*");
        var elem;
        var i = 0;
        element.unselectable = "on";
        for (;elem = seed[i++];) {
          switch(elem.tagName.toLowerCase()) {
            case "iframe":
            ;
            case "textarea":
            ;
            case "input":
            ;
            case "select":
              break;
            default:
              elem.unselectable = "on";
          }
        }
      }
    },
    getPositionedAncestor : function() {
      var current = this;
      for (;current.getName() != "html";) {
        if (current.getComputedStyle("position") != "static") {
          return current;
        }
        current = current.getParent();
      }
      return null;
    },
    getDocumentPosition : function(refDocument) {
      var node = this;
      var x = 0;
      var top = 0;
      var doc = node.getDocument();
      var body = doc.getBody();
      var quirks = doc.$.compatMode == "BackCompat";
      if (document.documentElement.getBoundingClientRect) {
        var otherElementRect = node.$.getBoundingClientRect();
        var $doc = doc.$;
        var $docElem = $doc.documentElement;
        var topMarginOfBody = $docElem.clientTop || (body.$.clientTop || 0);
        var itemWidth = $docElem.clientLeft || (body.$.clientLeft || 0);
        var t = true;
        if (href) {
          var inDocElem = doc.getDocumentElement().contains(node);
          var inBody = doc.getBody().contains(node);
          t = quirks && inBody || !quirks && inDocElem;
        }
        if (t) {
          x = otherElementRect.left + (!quirks && $docElem.scrollLeft || body.$.scrollLeft);
          x -= itemWidth;
          top = otherElementRect.top + (!quirks && $docElem.scrollTop || body.$.scrollTop);
          top -= topMarginOfBody;
        }
      } else {
        var current = node;
        var previous = null;
        var el;
        for (;current && !(current.getName() == "body" || current.getName() == "html");) {
          x += current.$.offsetLeft - current.$.scrollLeft;
          top += current.$.offsetTop - current.$.scrollTop;
          if (!current.equals(node)) {
            x += current.$.clientLeft || 0;
            top += current.$.clientTop || 0;
          }
          var scrollElement = previous;
          for (;scrollElement && !scrollElement.equals(current);) {
            x -= scrollElement.$.scrollLeft;
            top -= scrollElement.$.scrollTop;
            scrollElement = scrollElement.getParent();
          }
          previous = current;
          current = (el = current.$.offsetParent) ? new Node(el) : null;
        }
      }
      if (refDocument) {
        var d = node.getWindow();
        var res = refDocument.getWindow();
        if (!d.equals(res) && d.$.frameElement) {
          var scroll = (new Node(d.$.frameElement)).getDocumentPosition(refDocument);
          x += scroll.x;
          top += scroll.y;
        }
      }
      if (!document.documentElement.getBoundingClientRect) {
        if (env.gecko && !quirks) {
          x += node.$.clientLeft ? 1 : 0;
          top += node.$.clientTop ? 1 : 0;
        }
      }
      return{
        x : x,
        y : top
      };
    },
    scrollIntoView : function(deepDataAndEvents) {
      var parent = this.getParent();
      if (!parent) {
        return;
      }
      do {
        var k = parent.$.clientWidth && parent.$.clientWidth < parent.$.scrollWidth || parent.$.clientHeight && parent.$.clientHeight < parent.$.scrollHeight;
        if (k) {
          this.scrollIntoParent(parent, deepDataAndEvents, 1);
        }
        if (parent.is("html")) {
          var win = parent.getWindow();
          try {
            var iframe = win.$.frameElement;
            if (iframe) {
              parent = new Node(iframe);
            }
          } catch (n) {
          }
        }
      } while (parent = parent.getParent());
    },
    scrollIntoParent : function(parent, deepDataAndEvents, dataAndEvents) {
      function scrollBy(x, y) {
        if (/body|html/.test(parent.getName())) {
          parent.getWindow().$.scrollBy(x, y);
        } else {
          parent.$.scrollLeft += x;
          parent.$.scrollTop += y;
        }
      }
      function screenPos(element, name) {
        var pos = {
          x : 0,
          y : 0
        };
        if (!element.is(isQuirks ? "body" : "html")) {
          var box = element.$.getBoundingClientRect();
          pos.x = box.left;
          pos.y = box.top;
        }
        var win = element.getWindow();
        if (!win.equals(name)) {
          var outerPos = screenPos(Node.get(win.$.frameElement), name);
          pos.x += outerPos.x;
          pos.y += outerPos.y;
        }
        return pos;
      }
      function margin(el, side) {
        return parseInt(el.getComputedStyle("margin-" + side) || 0, 10) || 0;
      }
      if (!parent) {
        parent = this.getWindow();
      }
      var doc = parent.getDocument();
      var isQuirks = doc.$.compatMode == "BackCompat";
      if (parent instanceof dom.window) {
        parent = isQuirks ? doc.getBody() : doc.getDocumentElement();
      }
      var win = parent.getWindow();
      var thisPos = screenPos(this, win);
      var parentPos = screenPos(parent, win);
      var eh = this.$.offsetHeight;
      var ew = this.$.offsetWidth;
      var ch = parent.$.clientHeight;
      var cw = parent.$.clientWidth;
      var lastCoords;
      var currentPosition;
      lastCoords = {
        x : thisPos.x - margin(this, "left") - parentPos.x || 0,
        y : thisPos.y - margin(this, "top") - parentPos.y || 0
      };
      currentPosition = {
        x : thisPos.x + ew + margin(this, "right") - (parentPos.x + cw) || 0,
        y : thisPos.y + eh + margin(this, "bottom") - (parentPos.y + ch) || 0
      };
      if (lastCoords.y < 0 || currentPosition.y > 0) {
        scrollBy(0, deepDataAndEvents === true ? lastCoords.y : deepDataAndEvents === false ? currentPosition.y : lastCoords.y < 0 ? lastCoords.y : currentPosition.y);
      }
      if (dataAndEvents && (lastCoords.x < 0 || currentPosition.x > 0)) {
        scrollBy(lastCoords.x < 0 ? lastCoords.x : currentPosition.x, 0);
      }
    },
    setState : function(state) {
      var element = this;
      switch(state) {
        case 1:
          element.addClass("cke_on");
          element.removeClass("cke_off");
          element.removeClass("cke_disabled");
          break;
        case 0:
          element.addClass("cke_disabled");
          element.removeClass("cke_off");
          element.removeClass("cke_on");
          break;
        default:
          element.addClass("cke_off");
          element.removeClass("cke_on");
          element.removeClass("cke_disabled");
          break;
      }
    },
    getFrameDocument : function() {
      var $ = this.$;
      try {
        $.contentWindow.document;
      } catch (j) {
        $.src = $.src;
        if (href && env.version < 7) {
          window.showModalDialog('javascript:document.write("<script>window.setTimeout(function(){window.close();},50);\x3c/script>")');
        }
      }
      return $ && new doc($.contentWindow.document);
    },
    copyAttributes : function(node, opts) {
      var element = this;
      var codeSegments = element.$.attributes;
      opts = opts || {};
      var i = 0;
      for (;i < codeSegments.length;i++) {
        var attribute = codeSegments[i];
        var attrName = attribute.nodeName.toLowerCase();
        var attrValue;
        if (attrName in opts) {
          continue;
        }
        if (attrName == "checked" && (attrValue = element.getAttribute(attrName))) {
          node.setAttribute(attrName, attrValue);
        } else {
          if (attribute.specified || href && (attribute.nodeValue && attrName == "value")) {
            attrValue = element.getAttribute(attrName);
            if (attrValue === null) {
              attrValue = attribute.nodeValue;
            }
            node.setAttribute(attrName, attrValue);
          }
        }
      }
      if (element.$.style.cssText !== "") {
        node.$.style.cssText = element.$.style.cssText;
      }
    },
    renameNode : function(key) {
      var element = this;
      if (element.getName() == key) {
        return;
      }
      var value = element.getDocument();
      var node = new Node(key, value);
      element.copyAttributes(node);
      element.moveChildren(node);
      if (element.getParent()) {
        element.$.parentNode.replaceChild(node.$, element.$);
      }
      node.$["data-cke-expando"] = element.$["data-cke-expando"];
      element.$ = node.$;
    },
    getChild : function(recurring) {
      var $ = this.$;
      if (!recurring.slice) {
        $ = $.childNodes[recurring];
      } else {
        for (;recurring.length > 0 && $;) {
          $ = $.childNodes[recurring.shift()];
        }
      }
      return $ ? new dom.node($) : null;
    },
    getChildCount : function() {
      return this.$.childNodes.length;
    },
    disableContextMenu : function() {
      this.on("contextmenu", function(evt) {
        if (!evt.data.getTarget().hasClass("cke_enable_context_menu")) {
          evt.data.preventDefault();
        }
      });
    },
    getDirection : function(dataAndEvents) {
      var element = this;
      return dataAndEvents ? element.getComputedStyle("direction") || (element.getDirection() || (element.getDocument().$.dir || element.getDocument().getBody().getDirection(1))) : element.getStyle("direction") || element.getAttribute("dir");
    },
    data : function(name, value) {
      name = "data-" + name;
      if (value === undefined) {
        return this.getAttribute(name);
      } else {
        if (value === false) {
          this.removeAttribute(name);
        } else {
          this.setAttribute(name, value);
        }
      }
      return null;
    }
  });
  (function() {
    function check(socket) {
      var VALUE = 0;
      var i = 0;
      var valuesLen = options[socket].length;
      for (;i < valuesLen;i++) {
        VALUE += parseInt(this.getComputedStyle(options[socket][i]) || 0, 10) || 0;
      }
      return VALUE;
    }
    var options = {
      width : ["border-left-width", "border-right-width", "padding-left", "padding-right"],
      height : ["border-top-width", "border-bottom-width", "padding-top", "padding-bottom"]
    };
    Node.prototype.setSize = function(isXML, s, dataAndEvents) {
      if (typeof s == "number") {
        if (dataAndEvents && !(href && env.quirks)) {
          s -= check.call(this, isXML);
        }
        this.setStyle(isXML, s + "px");
      }
    };
    Node.prototype.getSize = function(pdataOld, dataAndEvents) {
      var size = Math.max(this.$["offset" + $.capitalize(pdataOld)], this.$["client" + $.capitalize(pdataOld)]) || 0;
      if (dataAndEvents) {
        size -= check.call(this, pdataOld);
      }
      return size;
    };
  })();
  self.command = function(name, value) {
    this.uiItems = [];
    this.exec = function(str) {
      var optgroup = this;
      if (optgroup.state == 0) {
        return false;
      }
      if (optgroup.editorFocus) {
        name.focus();
      }
      if (optgroup.fire("exec") === true) {
        return true;
      }
      return value.exec.call(optgroup, name, str) !== false;
    };
    this.refresh = function() {
      if (this.fire("refresh") === true) {
        return true;
      }
      return value.refresh && value.refresh.apply(this, arguments) !== false;
    };
    $.extend(this, value, {
      modes : {
        wysiwyg : 1
      },
      editorFocus : 1,
      state : 2
    });
    self.event.call(this);
  };
  self.command.prototype = {
    enable : function() {
      var self = this;
      if (self.state == 0) {
        self.setState(!self.preserveState || typeof self.previousState == "undefined" ? 2 : self.previousState);
      }
    },
    disable : function() {
      this.setState(0);
    },
    setState : function(state) {
      var self = this;
      if (self.state == state) {
        return false;
      }
      self.previousState = self.state;
      self.state = state;
      self.fire("state");
      return true;
    },
    toggleState : function() {
      var self = this;
      if (self.state == 2) {
        self.setState(1);
      } else {
        if (self.state == 1) {
          self.setState(2);
        }
      }
    }
  };
  self.event.implementOn(self.command.prototype, true);
  self.ENTER_P = 1;
  self.ENTER_BR = 2;
  self.ENTER_DIV = 3;
  self.config = {
    customConfig : "config.js",
    autoUpdateElement : true,
    baseHref : "",
    contentsCss : self.basePath + "contents.css",
    contentsLangDirection : "ui",
    contentsLanguage : "",
    language : "",
    defaultLanguage : "en",
    enterMode : 1,
    forceEnterMode : false,
    shiftEnterMode : 2,
    corePlugins : "",
    docType : '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
    bodyId : "",
    bodyClass : "",
    fullPage : false,
    height : 200,
    plugins : "about,a11yhelp,basicstyles,bidi,blockquote,button,clipboard,colorbutton,colordialog,contextmenu,dialogadvtab,div,elementspath,enterkey,entities,filebrowser,find,flash,font,format,forms,horizontalrule,htmldataprocessor,iframe,image,indent,justify,keystrokes,link,list,liststyle,maximize,newpage,pagebreak,pastefromword,pastetext,popup,preview,print,removeformat,resize,save,scayt,showblocks,showborders,smiley,sourcearea,specialchar,stylescombo,tab,table,tabletools,templates,toolbar,undo,wsc,wysiwygarea",
    extraPlugins : "",
    removePlugins : "",
    protectedSource : [],
    tabIndex : 0,
    theme : "default",
    skin : "kama",
    width : "",
    baseFloatZIndex : 1E4
  };
  var config = self.config;
  self.focusManager = function(editor) {
    if (editor.focusManager) {
      return editor.focusManager;
    }
    this.hasFocus = false;
    this._ = {
      editor : editor
    };
    return this;
  };
  self.focusManager.prototype = {
    focus : function() {
      var focusManager = this;
      if (focusManager._.timer) {
        clearTimeout(focusManager._.timer);
      }
      if (!focusManager.hasFocus) {
        if (self.currentInstance) {
          self.currentInstance.focusManager.forceBlur();
        }
        var editor = focusManager._.editor;
        editor.container.getChild(1).addClass("cke_focus");
        focusManager.hasFocus = true;
        editor.fire("focus");
      }
    },
    blur : function() {
      var focusManager = this;
      if (focusManager._.timer) {
        clearTimeout(focusManager._.timer);
      }
      focusManager._.timer = setTimeout(function() {
        delete focusManager._.timer;
        focusManager.forceBlur();
      }, 100);
    },
    forceBlur : function() {
      if (this.hasFocus) {
        var editor = this._.editor;
        editor.container.getChild(1).removeClass("cke_focus");
        this.hasFocus = false;
        editor.fire("blur");
      }
    }
  };
  (function() {
    var j = {};
    self.lang = {
      languages : {
        af : 1,
        ar : 1,
        bg : 1,
        bn : 1,
        bs : 1,
        ca : 1,
        cs : 1,
        cy : 1,
        da : 1,
        de : 1,
        el : 1,
        "en-au" : 1,
        "en-ca" : 1,
        "en-gb" : 1,
        en : 1,
        eo : 1,
        es : 1,
        et : 1,
        eu : 1,
        fa : 1,
        fi : 1,
        fo : 1,
        "fr-ca" : 1,
        fr : 1,
        gl : 1,
        gu : 1,
        he : 1,
        hi : 1,
        hr : 1,
        hu : 1,
        is : 1,
        it : 1,
        ja : 1,
        ka : 1,
        km : 1,
        ko : 1,
        lt : 1,
        lv : 1,
        mn : 1,
        ms : 1,
        nb : 1,
        nl : 1,
        no : 1,
        pl : 1,
        "pt-br" : 1,
        pt : 1,
        ro : 1,
        ru : 1,
        sk : 1,
        sl : 1,
        "sr-latn" : 1,
        sr : 1,
        sv : 1,
        th : 1,
        tr : 1,
        uk : 1,
        vi : 1,
        "zh-cn" : 1,
        zh : 1
      },
      load : function(url, options, callback) {
        if (!url || !self.lang.languages[url]) {
          url = this.detect(options, url);
        }
        if (!this[url]) {
          self.scriptLoader.load(self.getUrl("lang/" + url + ".js"), function() {
            callback(url, this[url]);
          }, this);
        } else {
          callback(url, this[url]);
        }
      },
      detect : function(defaultLanguage, query) {
        var languages = this.languages;
        query = query || (navigator.userLanguage || (navigator.language || defaultLanguage));
        var parts = query.toLowerCase().match(/([a-z]+)(?:-([a-z]+))?/);
        var lang = parts[1];
        var locale = parts[2];
        if (languages[lang + "-" + locale]) {
          lang = lang + "-" + locale;
        } else {
          if (!languages[lang]) {
            lang = null;
          }
        }
        self.lang.detect = lang ? function() {
          return lang;
        } : function(optionsString) {
          return optionsString;
        };
        return lang || defaultLanguage;
      }
    };
  })();
  self.scriptLoader = function() {
    var urlFetched = {};
    var waitingList = {};
    return{
      load : function(urls, options, optgroup, recurring) {
        var methodInvoked = typeof urls == "string";
        if (methodInvoked) {
          urls = [urls];
        }
        if (!optgroup) {
          optgroup = self;
        }
        var j = urls.length;
        var pdataOld = [];
        var pdataCur = [];
        var doCallback = function(isXML) {
          if (options) {
            if (methodInvoked) {
              options.call(optgroup, isXML);
            } else {
              options.call(optgroup, pdataOld, pdataCur);
            }
          }
        };
        if (j === 0) {
          doCallback(true);
          return;
        }
        var checkLoaded = function(url, success) {
          (success ? pdataOld : pdataCur).push(url);
          if (--j <= 0) {
            if (recurring) {
              self.document.getDocumentElement().removeStyle("cursor");
            }
            doCallback(success);
          }
        };
        var onLoad = function(url, success) {
          urlFetched[url] = 1;
          var waitingInfo = waitingList[url];
          delete waitingList[url];
          var i = 0;
          for (;i < waitingInfo.length;i++) {
            waitingInfo[i](url, success);
          }
        };
        var loadScript = function(url) {
          if (urlFetched[url]) {
            checkLoaded(url, true);
            return;
          }
          var configList = waitingList[url] || (waitingList[url] = []);
          configList.push(checkLoaded);
          if (configList.length > 1) {
            return;
          }
          var script = new Node("script");
          script.setAttributes({
            type : "text/javascript",
            src : url
          });
          if (options) {
            if (href) {
              script.$.onreadystatechange = function() {
                if (script.$.readyState == "loaded" || script.$.readyState == "complete") {
                  script.$.onreadystatechange = null;
                  onLoad(url, true);
                }
              };
            } else {
              script.$.onload = function() {
                setTimeout(function() {
                  onLoad(url, true);
                }, 0);
              };
              script.$.onerror = function() {
                onLoad(url, false);
              };
            }
          }
          script.appendTo(self.document.getHead());
        };
        if (recurring) {
          self.document.getDocumentElement().setStyle("cursor", "wait");
        }
        var i = 0;
        for (;i < j;i++) {
          loadScript(urls[i]);
        }
      }
    };
  }();
  self.resourceManager = function(basePath, fileName) {
    var options = this;
    options.basePath = basePath;
    options.fileName = fileName;
    options.registered = {};
    options.loaded = {};
    options.externals = {};
    options._ = {
      waitingList : {}
    };
  };
  self.resourceManager.prototype = {
    add : function(name, opt_attributes) {
      if (this.registered[name]) {
        throw'[CKEDITOR.resourceManager.add] The resource name "' + name + '" is already registered.';
      }
      self.fire(name + $.capitalize(this.fileName) + "Ready", this.registered[name] = opt_attributes || {});
    },
    get : function(name) {
      return this.registered[name] || null;
    },
    getPath : function(name) {
      var external = this.externals[name];
      return self.getUrl(external && external.dir || this.basePath + name + "/");
    },
    getFilePath : function(name) {
      var external = this.externals[name];
      return self.getUrl(this.getPath(name) + (external && typeof external.file == "string" ? external.file : this.fileName + ".js"));
    },
    addExternal : function(names, deepDataAndEvents, fileName) {
      names = names.split(",");
      var i = 0;
      for (;i < names.length;i++) {
        var name = names[i];
        this.externals[name] = {
          dir : deepDataAndEvents,
          file : fileName
        };
      }
    },
    load : function(obj, options, optgroup) {
      if (!$.isArray(obj)) {
        obj = obj ? [obj] : [];
      }
      var changes = this.loaded;
      var registered = this.registered;
      var val = [];
      var urlsNames = {};
      var pdataOld = {};
      var i = 0;
      for (;i < obj.length;i++) {
        var name = obj[i];
        if (!name) {
          continue;
        }
        if (!changes[name] && !registered[name]) {
          var url = this.getFilePath(name);
          val.push(url);
          if (!(url in urlsNames)) {
            urlsNames[url] = [];
          }
          urlsNames[url].push(name);
        } else {
          pdataOld[name] = this.get(name);
        }
      }
      self.scriptLoader.load(val, function(codeSegments, failed) {
        if (failed.length) {
          throw'[CKEDITOR.resourceManager.load] Resource name "' + urlsNames[failed[0]].join(",") + '" was not found at "' + failed[0] + '".';
        }
        var i = 0;
        for (;i < codeSegments.length;i++) {
          var diffs = urlsNames[codeSegments[i]];
          var x = 0;
          for (;x < diffs.length;x++) {
            var field = diffs[x];
            pdataOld[field] = this.get(field);
            changes[field] = 1;
          }
        }
        options.call(optgroup, pdataOld);
      }, this);
    }
  };
  self.plugins = new self.resourceManager("plugins/", "plugin");
  var editor = self.plugins;
  editor.load = $.override(editor.load, function(next_callback) {
    return function(isXML, method, scope) {
      var pdataOld = {};
      var loadPlugins = function(isXML) {
        next_callback.call(this, isXML, function(plugins) {
          $.extend(pdataOld, plugins);
          var udataCur = [];
          var i;
          for (i in plugins) {
            var plugin = plugins[i];
            var requires = plugin && plugin.requires;
            if (requires) {
              var j = 0;
              for (;j < requires.length;j++) {
                if (!pdataOld[requires[j]]) {
                  udataCur.push(requires[j]);
                }
              }
            }
          }
          if (udataCur.length) {
            loadPlugins.call(this, udataCur);
          } else {
            for (i in pdataOld) {
              plugin = pdataOld[i];
              if (plugin.onLoad && !plugin.onLoad._called) {
                plugin.onLoad();
                plugin.onLoad._called = 1;
              }
            }
            if (method) {
              method.call(scope || window, pdataOld);
            }
          }
        }, this);
      };
      loadPlugins.call(this, isXML);
    };
  });
  editor.setLang = function(field, id, module) {
    var editor = this.get(field);
    var running = editor.langEntries || (editor.langEntries = {});
    var methods = editor.lang || (editor.lang = []);
    if ($.indexOf(methods, id) == -1) {
      methods.push(id);
    }
    running[id] = module;
  };
  self.skins = function() {
    var loaded = {};
    var paths = {};
    var loadPart = function(x, skinName, part, callback) {
      function fixCSSTextRelativePath(cssStyleText, g) {
        return cssStyleText.replace(/url\s*\(([\s'"]*)(.*?)([\s"']*)\)/g, function(match, b, qualifier, dataAndEvents) {
          if (/^\/|^\w?:/.test(qualifier)) {
            return match;
          } else {
            return "url(" + g + b + qualifier + dataAndEvents + ")";
          }
        });
      }
      var skinDefinition = loaded[skinName];
      if (!x.skin) {
        x.skin = skinDefinition;
        if (skinDefinition.init) {
          skinDefinition.init(x);
        }
      }
      var appendSkinPath = function(fileNames) {
        var n = 0;
        for (;n < fileNames.length;n++) {
          fileNames[n] = self.getUrl(paths[skinName] + fileNames[n]);
        }
      };
      part = skinDefinition[part];
      var u = !part || !!part._isLoaded;
      if (u) {
        if (callback) {
          callback();
        }
      } else {
        var codeSegments = part._pending || (part._pending = []);
        codeSegments.push(callback);
        if (codeSegments.length > 1) {
          return;
        }
        var a = !part.css || !part.css.length;
        var b = !part.js || !part.js.length;
        var checkIsLoaded = function() {
          if (a && b) {
            part._isLoaded = 1;
            var i = 0;
            for (;i < codeSegments.length;i++) {
              if (codeSegments[i]) {
                codeSegments[i]();
              }
            }
          }
        };
        if (!a) {
          var cssPart = part.css;
          if ($.isArray(cssPart)) {
            appendSkinPath(cssPart);
            var c = 0;
            for (;c < cssPart.length;c++) {
              self.document.appendStyleSheet(cssPart[c]);
            }
          } else {
            cssPart = fixCSSTextRelativePath(cssPart, self.getUrl(paths[skinName]));
            self.document.appendStyleText(cssPart);
          }
          part.css = cssPart;
          a = 1;
        }
        if (!b) {
          appendSkinPath(part.js);
          self.scriptLoader.load(part.js, function() {
            b = 1;
            checkIsLoaded();
          });
        }
        checkIsLoaded();
      }
    };
    return{
      add : function(name, opt_attributes) {
        loaded[name] = opt_attributes;
        opt_attributes.skinPath = paths[name] || (paths[name] = self.getUrl("skins/" + name + "/"));
      },
      load : function(editor, options, callback) {
        var skinName = editor.skinName;
        var skinPath = editor.skinPath;
        if (loaded[skinName]) {
          loadPart(editor, skinName, options, callback);
        } else {
          paths[skinName] = skinPath;
          self.scriptLoader.load(self.getUrl(skinPath + "skin.js"), function() {
            loadPart(editor, skinName, options, callback);
          });
        }
      }
    };
  }();
  self.themes = new self.resourceManager("themes/", "theme");
  self.ui = function(editor) {
    if (editor.ui) {
      return editor.ui;
    }
    this._ = {
      handlers : {},
      items : {},
      editor : editor
    };
    return this;
  };
  var options = self.ui;
  options.prototype = {
    add : function(name, opt_attributes, type) {
      this._.items[name] = {
        type : opt_attributes,
        command : type.command || null,
        args : Array.prototype.slice.call(arguments, 2)
      };
    },
    create : function(id) {
      var self = this;
      var item = self._.items[id];
      var handler = item && self._.handlers[item.type];
      var command = item && (item.command && self._.editor.getCommand(item.command));
      var attributes = handler && handler.create.apply(self, item.args);
      if (item) {
        attributes = $.extend(attributes, self._.editor.skin[item.type], true);
      }
      if (command) {
        command.uiItems.push(attributes);
      }
      return attributes;
    },
    addHandler : function(name, fn) {
      this._.handlers[name] = fn;
    }
  };
  self.event.implementOn(options);
  (function() {
    function updateCommands() {
      var command;
      var commands = this._.commands;
      var mode = this.mode;
      if (!mode) {
        return;
      }
      var name;
      for (name in commands) {
        command = commands[name];
        command[command.startDisabled ? "disable" : this.readOnly && !command.readOnly ? "disable" : command.modes[mode] ? "enable" : "disable"]();
      }
    }
    var nameCounter = 0;
    var getNewName = function() {
      var name = "editor" + ++nameCounter;
      return self.instances && self.instances[name] ? getNewName() : name;
    };
    var urlFetched = {};
    var loadConfig = function(optgroup) {
      var url = optgroup.config.customConfig;
      if (!url) {
        return false;
      }
      url = self.getUrl(url);
      var options = urlFetched[url] || (urlFetched[url] = {});
      if (options.fn) {
        options.fn.call(optgroup, optgroup.config);
        if (self.getUrl(optgroup.config.customConfig) == url || !loadConfig(optgroup)) {
          optgroup.fireOnce("customConfigLoaded");
        }
      } else {
        self.scriptLoader.load(url, function() {
          if (self.editorConfig) {
            options.fn = self.editorConfig;
          } else {
            options.fn = function() {
            };
          }
          loadConfig(optgroup);
        });
      }
      return true;
    };
    var initConfig = function(editor, instanceConfig) {
      editor.on("customConfigLoaded", function() {
        if (instanceConfig) {
          if (instanceConfig.on) {
            var eventName;
            for (eventName in instanceConfig.on) {
              editor.on(eventName, instanceConfig.on[eventName]);
            }
          }
          $.extend(editor.config, instanceConfig, true);
          delete editor.config.on;
        }
        onConfigLoaded(editor);
      });
      if (instanceConfig && instanceConfig.customConfig != undefined) {
        editor.config.customConfig = instanceConfig.customConfig;
      }
      if (!loadConfig(editor)) {
        editor.fireOnce("customConfigLoaded");
      }
    };
    var onConfigLoaded = function(editor) {
      var skin = editor.config.skin.split(",");
      var skinName = skin[0];
      var skinPath = self.getUrl(skin[1] || "skins/" + skinName + "/");
      editor.skinName = skinName;
      editor.skinPath = skinPath;
      editor.skinClass = "cke_skin_" + skinName;
      editor.tabIndex = editor.config.tabIndex || (editor.element.getAttribute("tabindex") || 0);
      editor.readOnly = !!(editor.config.readOnly || editor.element.getAttribute("disabled"));
      editor.fireOnce("configLoaded");
      loadSkin(editor);
    };
    var loadLang = function(editor) {
      self.lang.load(editor.config.language, editor.config.defaultLanguage, function(languageCode, lang) {
        editor.langCode = languageCode;
        editor.lang = $.prototypedCopy(lang);
        if (env.gecko && (env.version < 10900 && editor.lang.dir == "rtl")) {
          editor.lang.dir = "ltr";
        }
        editor.fire("langLoaded");
        var config = editor.config;
        if (config.contentsLangDirection == "ui") {
          config.contentsLangDirection = editor.lang.dir;
        }
        loadPlugins(editor);
      });
    };
    var loadPlugins = function(data) {
      var config = data.config;
      var plugins = config.plugins;
      var extraPlugins = config.extraPlugins;
      var removePlugins = config.removePlugins;
      if (extraPlugins) {
        var optgroup = new RegExp("(?:^|,)(?:" + extraPlugins.replace(/\s*,\s*/g, "|") + ")(?=,|$)", "g");
        plugins = plugins.replace(optgroup, "");
        plugins += "," + extraPlugins;
      }
      if (removePlugins) {
        optgroup = new RegExp("(?:^|,)(?:" + removePlugins.replace(/\s*,\s*/g, "|") + ")(?=,|$)", "g");
        plugins = plugins.replace(optgroup, "");
      }
      if (env.air) {
        plugins += ",adobeair";
      }
      editor.load(plugins.split(","), function(plugins) {
        var pluginsArray = [];
        var languageCodes = [];
        var url = [];
        data.plugins = plugins;
        var pluginName;
        for (pluginName in plugins) {
          var plugin = plugins[pluginName];
          var path = plugin.lang;
          var pluginPath = editor.getPath(pluginName);
          var lang = null;
          plugin.path = pluginPath;
          if (path) {
            lang = $.indexOf(path, data.langCode) >= 0 ? data.langCode : path[0];
            if (!plugin.langEntries || !plugin.langEntries[lang]) {
              url.push(self.getUrl(pluginPath + "lang/" + lang + ".js"));
            } else {
              $.extend(data.lang, plugin.langEntries[lang]);
              lang = null;
            }
          }
          languageCodes.push(lang);
          pluginsArray.push(plugin);
        }
        self.scriptLoader.load(url, function() {
          var methods = ["beforeInit", "init", "afterInit"];
          var m = 0;
          for (;m < methods.length;m++) {
            var i = 0;
            for (;i < pluginsArray.length;i++) {
              var plugin = pluginsArray[i];
              if (m === 0 && (languageCodes[i] && plugin.lang)) {
                $.extend(data.lang, plugin.langEntries[languageCodes[i]]);
              }
              if (plugin[methods[m]]) {
                plugin[methods[m]](data);
              }
            }
          }
          data.fire("pluginsLoaded");
          loadTheme(data);
        });
      });
    };
    var loadSkin = function(url) {
      self.skins.load(url, "editor", function() {
        loadLang(url);
      });
    };
    var loadTheme = function(editor) {
      var theme = editor.config.theme;
      self.themes.load(theme, function() {
        var editorTheme = editor.theme = self.themes.get(theme);
        editorTheme.path = self.themes.getPath(theme);
        editorTheme.build(editor);
        if (editor.config.autoUpdateElement) {
          attachToForm(editor);
        }
      });
    };
    var attachToForm = function(editor) {
      var element = editor.element;
      if (editor.elementMode == 1 && element.is("textarea")) {
        var form = element.$.form && new Node(element.$.form);
        if (form) {
          var ondata = function() {
            editor.updateElement();
          };
          form.on("submit", ondata);
          if (!form.$.submit.nodeName && !form.$.submit.length) {
            form.$.submit = $.override(form.$.submit, function(matcherFunction) {
              return function() {
                editor.updateElement();
                if (matcherFunction.apply) {
                  matcherFunction.apply(this, arguments);
                } else {
                  matcherFunction();
                }
              };
            });
          }
          editor.on("destroy", function() {
            form.removeListener("submit", ondata);
          });
        }
      }
    };
    self.editor.prototype._init = function() {
      var editor = this;
      var element = Node.get(editor._.element);
      var instanceConfig = editor._.instanceConfig;
      delete editor._.element;
      delete editor._.instanceConfig;
      editor._.commands = {};
      editor._.styles = [];
      editor.element = element;
      editor.name = element && (editor.elementMode == 1 && (element.getId() || element.getNameAtt())) || getNewName();
      if (editor.name in self.instances) {
        throw'[CKEDITOR.editor] The instance "' + editor.name + '" already exists.';
      }
      editor.id = $.getNextId();
      editor.config = $.prototypedCopy(config);
      editor.ui = new options(editor);
      editor.focusManager = new self.focusManager(editor);
      self.fire("instanceCreated", null, editor);
      editor.on("mode", updateCommands, null, null, 1);
      editor.on("readOnly", updateCommands, null, null, 1);
      initConfig(editor, instanceConfig);
    };
  })();
  $.extend(self.editor.prototype, {
    addCommand : function(name, opt_attributes) {
      return this._.commands[name] = new self.command(this, opt_attributes);
    },
    addCss : function(css) {
      this._.styles.push(css);
    },
    destroy : function(dataAndEvents) {
      var optgroup = this;
      if (!dataAndEvents) {
        optgroup.updateElement();
      }
      optgroup.fire("destroy");
      if (optgroup.theme) {
        optgroup.theme.destroy(optgroup);
      }
      self.remove(optgroup);
      self.fire("instanceDestroyed", null, optgroup);
    },
    execCommand : function(command, mayParseLabeledStatementInstead) {
      var options = this.getCommand(command);
      var eventData = {
        name : command,
        commandData : mayParseLabeledStatementInstead,
        command : options
      };
      if (options && options.state != 0) {
        if (this.fire("beforeCommandExec", eventData) !== true) {
          eventData.returnValue = options.exec(eventData.commandData);
          if (!options.async && this.fire("afterCommandExec", eventData) !== true) {
            return eventData.returnValue;
          }
        }
      }
      return false;
    },
    getCommand : function(name) {
      return this._.commands[name];
    },
    getData : function() {
      var editor = this;
      editor.fire("beforeGetData");
      var eventData = editor._.data;
      if (typeof eventData != "string") {
        var element = editor.element;
        if (element && editor.elementMode == 1) {
          eventData = element.is("textarea") ? element.getValue() : element.getHtml();
        } else {
          eventData = "";
        }
      }
      eventData = {
        dataValue : eventData
      };
      editor.fire("getData", eventData);
      return eventData.dataValue;
    },
    getSnapshot : function() {
      var data = this.fire("getSnapshot");
      if (typeof data != "string") {
        var element = this.element;
        if (element && this.elementMode == 1) {
          data = element.is("textarea") ? element.getValue() : element.getHtml();
        }
      }
      return data;
    },
    loadSnapshot : function(opt_attributes) {
      this.fire("loadSnapshot", opt_attributes);
    },
    setData : function(data, callback, dataAndEvents) {
      if (callback) {
        this.on("dataReady", function(evt) {
          evt.removeListener();
          callback.call(evt.editor);
        });
      }
      var eventData = {
        dataValue : data
      };
      if (!dataAndEvents) {
        this.fire("setData", eventData);
      }
      this._.data = eventData.dataValue;
      if (!dataAndEvents) {
        this.fire("afterSetData", eventData);
      }
    },
    setReadOnly : function(isReadOnly) {
      isReadOnly = isReadOnly == undefined || isReadOnly;
      if (this.readOnly != isReadOnly) {
        this.readOnly = isReadOnly;
        this.fire("readOnly");
      }
    },
    insertHtml : function(opt_attributes) {
      this.fire("insertHtml", opt_attributes);
    },
    insertText : function(attributes) {
      this.fire("insertText", attributes);
    },
    insertElement : function(attributes) {
      this.fire("insertElement", attributes);
    },
    checkDirty : function() {
      return this.mayBeDirty && this._.previousValue !== this.getSnapshot();
    },
    resetDirty : function() {
      if (this.mayBeDirty) {
        this._.previousValue = this.getSnapshot();
      }
    },
    updateElement : function() {
      var editor = this;
      var element = editor.element;
      if (element && editor.elementMode == 1) {
        var value = editor.getData();
        if (editor.config.htmlEncodeOutput) {
          value = $.htmlEncode(value);
        }
        if (element.is("textarea")) {
          element.setValue(value);
        } else {
          element.setHtml(value);
        }
      }
    }
  });
  self.on("loaded", function() {
    var codeSegments = self.editor._pending;
    if (codeSegments) {
      delete self.editor._pending;
      var i = 0;
      for (;i < codeSegments.length;i++) {
        codeSegments[i]._init();
      }
    }
  });
  self.htmlParser = function() {
    this._ = {
      htmlPartsRegex : new RegExp("<(?:(?:\\/([^>]+)>)|(?:!--([\\S|\\s]*?)--\x3e)|(?:([^\\s>]+)\\s*((?:(?:\"[^\"]*\")|(?:'[^']*')|[^\"'>])*)\\/?>))", "g")
    };
  };
  (function() {
    var braces = /([\w\-:.]+)(?:(?:\s*=\s*(?:(?:"([^"]*)")|(?:'([^']*)')|([^\s>]+)))|(?=\s|$))/g;
    var booleanAttrs = {
      checked : 1,
      compact : 1,
      declare : 1,
      defer : 1,
      disabled : 1,
      ismap : 1,
      multiple : 1,
      nohref : 1,
      noresize : 1,
      noshade : 1,
      nowrap : 1,
      readonly : 1,
      selected : 1
    };
    self.htmlParser.prototype = {
      onTagOpen : function() {
      },
      onTagClose : function() {
      },
      onText : function() {
      },
      onCDATA : function() {
      },
      onComment : function() {
      },
      parse : function(x) {
        var parser = this;
        var pos;
        var tagName;
        var start = 0;
        var cdata;
        for (;pos = parser._.htmlPartsRegex.exec(x);) {
          var i = pos.index;
          if (i > start) {
            var text = x.substring(start, i);
            if (cdata) {
              cdata.push(text);
            } else {
              parser.onText(text);
            }
          }
          start = parser._.htmlPartsRegex.lastIndex;
          if (tagName = pos[1]) {
            tagName = tagName.toLowerCase();
            if (cdata && dtd.$cdata[tagName]) {
              parser.onCDATA(cdata.join(""));
              cdata = null;
            }
            if (!cdata) {
              parser.onTagClose(tagName);
              continue;
            }
          }
          if (cdata) {
            cdata.push(pos[0]);
            continue;
          }
          if (tagName = pos[3]) {
            tagName = tagName.toLowerCase();
            if (/="/.test(tagName)) {
              continue;
            }
            var obj = {};
            var parts;
            var nextLine = pos[4];
            var selfClosing = !!(nextLine && nextLine.charAt(nextLine.length - 1) == "/");
            if (nextLine) {
              for (;parts = braces.exec(nextLine);) {
                var prop = parts[1].toLowerCase();
                var val = parts[2] || (parts[3] || (parts[4] || ""));
                if (!val && booleanAttrs[prop]) {
                  obj[prop] = prop;
                } else {
                  obj[prop] = val;
                }
              }
            }
            parser.onTagOpen(tagName, obj, selfClosing);
            if (!cdata && dtd.$cdata[tagName]) {
              cdata = [];
            }
            continue;
          }
          if (tagName = pos[2]) {
            parser.onComment(tagName);
          }
        }
        if (x.length > start) {
          parser.onText(x.substring(start, x.length));
        }
      }
    };
  })();
  self.htmlParser.comment = function(value) {
    this.value = value;
    this._ = {
      isBlockLike : false
    };
  };
  self.htmlParser.comment.prototype = {
    type : 8,
    writeHtml : function(writer, filter) {
      var comment = this.value;
      if (filter) {
        if (!(comment = filter.onComment(comment, this))) {
          return;
        }
        if (typeof comment != "string") {
          comment.parent = this.parent;
          comment.writeHtml(writer, filter);
          return;
        }
      }
      writer.comment(comment);
    }
  };
  (function() {
    self.htmlParser.text = function(name) {
      this.value = name;
      this._ = {
        isBlockLike : false
      };
    };
    self.htmlParser.text.prototype = {
      type : 3,
      writeHtml : function(writer, filter) {
        var optgroup = this.value;
        if (filter && !(optgroup = filter.onText(optgroup, this))) {
          return;
        }
        writer.text(optgroup);
      }
    };
  })();
  (function() {
    self.htmlParser.cdata = function(value) {
      this.value = value;
    };
    self.htmlParser.cdata.prototype = {
      type : 3,
      writeHtml : function(writer) {
        writer.write(this.value);
      }
    };
  })();
  self.htmlParser.fragment = function() {
    this.children = [];
    this.parent = null;
    this._ = {
      isBlockLike : true,
      hasInlineStarted : false
    };
  };
  (function() {
    function isRemoveEmpty(node) {
      return node.name == "a" && node.attributes.href || dtd.$removeEmpty[node.name];
    }
    var nonBreakingBlocks = $.extend({
      table : 1,
      ul : 1,
      ol : 1,
      dl : 1
    }, dtd.table, dtd.ul, dtd.ol, dtd.dl);
    var optionalCloseTags = href && env.version < 8 ? {
      dd : 1,
      dt : 1
    } : {};
    var listBlocks = {
      ol : 1,
      ul : 1
    };
    var rootDtd = $.extend({}, {
      html : 1
    }, dtd.html, dtd.body, dtd.head, {
      style : 1,
      script : 1
    });
    self.htmlParser.fragment.fromHtml = function(data, fixForBody, contextNode) {
      function checkPending(name) {
        var E;
        if (pendingInline.length > 0) {
          var i = 0;
          for (;i < pendingInline.length;i++) {
            var pendingElement = pendingInline[i];
            var pendingName = pendingElement.name;
            var old = dtd[pendingName];
            var currentDtd = currentNode.name && dtd[currentNode.name];
            if ((!currentDtd || currentDtd[pendingName]) && (!name || (!old || (old[name] || !dtd[name])))) {
              if (!E) {
                sendPendingBRs();
                E = 1;
              }
              pendingElement = pendingElement.clone();
              pendingElement.parent = currentNode;
              currentNode = pendingElement;
              pendingInline.splice(i, 1);
              i--;
            } else {
              if (pendingName == currentNode.name) {
                addElement(currentNode, currentNode.parent, 1);
                i--;
              }
            }
          }
        }
      }
      function sendPendingBRs() {
        for (;movedNodes.length;) {
          addElement(movedNodes.shift(), currentNode);
        }
      }
      function addElement(node, target, moveCurrent) {
        if (node.previous !== undefined) {
          return;
        }
        target = target || (currentNode || fragment);
        var savedCurrent = currentNode;
        if (fixForBody && (!target.type || target.name == "body")) {
          var name;
          var realName;
          if (node.attributes && (realName = node.attributes["data-cke-real-element-type"])) {
            name = realName;
          } else {
            name = node.name;
          }
          if (name && !(name in dtd.$body || (name == "body" || node.isOrphan))) {
            currentNode = target;
            parser.onTagOpen(fixForBody, {});
            node.returnPoint = target = currentNode;
          }
        }
        if (node._.isBlockLike && (node.name != "pre" && node.name != "textarea")) {
          var i = node.children.length;
          var elem = node.children[i - 1];
          var val;
          if (elem && elem.type == 3) {
            if (!(val = $.rtrim(elem.value))) {
              node.children.length = i - 1;
            } else {
              elem.value = val;
            }
          }
        }
        target.add(node);
        if (node.name == "pre") {
          inPre = false;
        }
        if (node.name == "textarea") {
          inTextarea = false;
        }
        if (node.returnPoint) {
          currentNode = node.returnPoint;
          delete node.returnPoint;
        } else {
          currentNode = moveCurrent ? target : savedCurrent;
        }
      }
      var parser = new self.htmlParser;
      var fragment = contextNode || new self.htmlParser.fragment;
      var pendingInline = [];
      var movedNodes = [];
      var currentNode = fragment;
      var inTextarea = false;
      var inPre = false;
      parser.onTagOpen = function(tagName, attributes, selfClosing, optionalClose) {
        var element = new self.htmlParser.element(tagName, attributes);
        if (element.isUnknown && selfClosing) {
          element.isEmpty = true;
        }
        element.isOptionalClose = tagName in optionalCloseTags || optionalClose;
        if (isRemoveEmpty(element)) {
          pendingInline.push(element);
          return;
        } else {
          if (tagName == "pre") {
            inPre = true;
          } else {
            if (tagName == "br" && inPre) {
              currentNode.add(new self.htmlParser.text("\n"));
              return;
            } else {
              if (tagName == "textarea") {
                inTextarea = true;
              }
            }
          }
        }
        if (tagName == "br") {
          movedNodes.push(element);
          return;
        }
        for (;1;) {
          var currentName = currentNode.name;
          var currentDtd = currentName ? dtd[currentName] || (currentNode._.isBlockLike ? dtd.div : dtd.span) : rootDtd;
          if (!element.isUnknown && (!currentNode.isUnknown && !currentDtd[tagName])) {
            if (currentNode.isOptionalClose) {
              parser.onTagClose(currentName);
            } else {
              if (tagName in listBlocks && currentName in listBlocks) {
                var children = currentNode.children;
                var lastChild = children[children.length - 1];
                if (!(lastChild && lastChild.name == "li")) {
                  addElement(lastChild = new self.htmlParser.element("li"), currentNode);
                }
                if (!element.returnPoint) {
                  element.returnPoint = currentNode;
                }
                currentNode = lastChild;
              } else {
                if (tagName in dtd.$listItem && currentName != tagName) {
                  parser.onTagOpen(tagName == "li" ? "ul" : "dl", {}, 0, 1);
                } else {
                  if (currentName in nonBreakingBlocks && currentName != tagName) {
                    if (!element.returnPoint) {
                      element.returnPoint = currentNode;
                    }
                    currentNode = currentNode.parent;
                  } else {
                    if (currentName in dtd.$inline) {
                      pendingInline.unshift(currentNode);
                    }
                    if (currentNode.parent) {
                      addElement(currentNode, currentNode.parent, 1);
                    } else {
                      element.isOrphan = 1;
                      break;
                    }
                  }
                }
              }
            }
          } else {
            break;
          }
        }
        checkPending(tagName);
        sendPendingBRs();
        element.parent = currentNode;
        if (element.isEmpty) {
          addElement(element);
        } else {
          currentNode = element;
        }
      };
      parser.onTagClose = function(tagName) {
        var i = pendingInline.length - 1;
        for (;i >= 0;i--) {
          if (tagName == pendingInline[i].name) {
            pendingInline.splice(i, 1);
            return;
          }
        }
        var pendingAdd = [];
        var newPendingInline = [];
        var candidate = currentNode;
        for (;candidate != fragment && candidate.name != tagName;) {
          if (!candidate._.isBlockLike) {
            newPendingInline.unshift(candidate);
          }
          pendingAdd.push(candidate);
          candidate = candidate.returnPoint || candidate.parent;
        }
        if (candidate != fragment) {
          i = 0;
          for (;i < pendingAdd.length;i++) {
            var node = pendingAdd[i];
            addElement(node, node.parent);
          }
          currentNode = candidate;
          if (candidate._.isBlockLike) {
            sendPendingBRs();
          }
          addElement(candidate, candidate.parent);
          if (candidate == currentNode) {
            currentNode = currentNode.parent;
          }
          pendingInline = pendingInline.concat(newPendingInline);
        }
        if (tagName == "body") {
          fixForBody = false;
        }
      };
      parser.onText = function(text) {
        if ((!currentNode._.hasInlineStarted || movedNodes.length) && (!inPre && !inTextarea)) {
          text = $.ltrim(text);
          if (text.length === 0) {
            return;
          }
        }
        var currentName = currentNode.name;
        var currentDtd = currentName ? dtd[currentName] || (currentNode._.isBlockLike ? dtd.div : dtd.span) : rootDtd;
        if (!inTextarea && (!currentDtd["#"] && currentName in nonBreakingBlocks)) {
          parser.onTagOpen(currentName in listBlocks ? "li" : currentName == "dl" ? "dd" : currentName == "table" ? "tr" : currentName == "tr" ? "td" : "");
          parser.onText(text);
          return;
        }
        sendPendingBRs();
        checkPending();
        if (fixForBody && ((!currentNode.type || currentNode.name == "body") && $.trim(text))) {
          this.onTagOpen(fixForBody, {}, 0, 1);
        }
        if (!inPre && !inTextarea) {
          text = text.replace(/[\t\r\n ]{2,}|[\t\r\n]/g, " ");
        }
        currentNode.add(new self.htmlParser.text(text));
      };
      parser.onCDATA = function(cdata) {
        currentNode.add(new self.htmlParser.cdata(cdata));
      };
      parser.onComment = function(comment) {
        sendPendingBRs();
        checkPending();
        currentNode.add(new self.htmlParser.comment(comment));
      };
      parser.parse(data);
      sendPendingBRs(!href && 1);
      for (;currentNode != fragment;) {
        addElement(currentNode, currentNode.parent, 1);
      }
      return fragment;
    };
    self.htmlParser.fragment.prototype = {
      add : function(name, opt_attributes) {
        var self = this;
        if (isNaN(opt_attributes)) {
          opt_attributes = self.children.length;
        }
        var current = opt_attributes > 0 ? self.children[opt_attributes - 1] : null;
        if (current) {
          if (name._.isBlockLike && current.type == 3) {
            current.value = $.rtrim(current.value);
            if (current.value.length === 0) {
              self.children.pop();
              self.add(name);
              return;
            }
          }
          current.next = name;
        }
        name.previous = current;
        name.parent = self;
        self.children.splice(opt_attributes, 0, name);
        self._.hasInlineStarted = name.type == 3 || name.type == 1 && !name._.isBlockLike;
      },
      writeHtml : function(writer, filter) {
        var isChildrenFiltered;
        this.filterChildren = function() {
          var pdataOld = new self.htmlParser.basicWriter;
          this.writeChildrenHtml.call(this, pdataOld, filter, true);
          var html = pdataOld.getHtml();
          this.children = (new self.htmlParser.fragment.fromHtml(html)).children;
          isChildrenFiltered = 1;
        };
        if (!this.name) {
          if (filter) {
            filter.onFragment(this);
          }
        }
        this.writeChildrenHtml(writer, isChildrenFiltered ? null : filter);
      },
      writeChildrenHtml : function(writer, filter) {
        var i = 0;
        for (;i < this.children.length;i++) {
          this.children[i].writeHtml(writer, filter);
        }
      }
    };
  })();
  self.htmlParser.element = function(name, value) {
    var element = this;
    element.name = name;
    element.attributes = value || {};
    element.children = [];
    var realName = name || "";
    var prefixed = realName.match(/^cke:(.*)/);
    if (prefixed) {
      realName = prefixed[1];
    }
    var isBlockLike = !!(dtd.$nonBodyContent[realName] || (dtd.$block[realName] || (dtd.$listItem[realName] || (dtd.$tableContent[realName] || (dtd.$nonEditable[realName] || realName == "br")))));
    element.isEmpty = !!dtd.$empty[name];
    element.isUnknown = !dtd[name];
    element._ = {
      isBlockLike : isBlockLike,
      hasInlineStarted : element.isEmpty || !isBlockLike
    };
  };
  self.htmlParser.cssStyle = function() {
    var styleText;
    var arg = arguments[0];
    var rules = {};
    styleText = arg instanceof self.htmlParser.element ? arg.attributes.style : arg;
    (styleText || "").replace(/&quot;/g, '"').replace(/\s*([^ :;]+)\s*:\s*([^;]+)\s*(?=;|$)/g, function(dataAndEvents, name, value) {
      if (name == "font-family") {
        value = value.replace(/["']/g, "");
      }
      rules[name.toLowerCase()] = value;
    });
    return{
      rules : rules,
      populate : function(obj) {
        var style = this.toString();
        if (style) {
          if (obj instanceof Node) {
            obj.setAttribute("style", style);
          } else {
            if (obj instanceof self.htmlParser.element) {
              obj.attributes.style = style;
            } else {
              obj.style = style;
            }
          }
        }
      },
      "toString" : function() {
        var output = [];
        var i;
        for (i in rules) {
          if (rules[i]) {
            output.push(i, ":", rules[i], ";");
          }
        }
        return output.join("");
      }
    };
  };
  (function() {
    var sortAttribs = function(a, b) {
      a = a[0];
      b = b[0];
      return a < b ? -1 : a > b ? 1 : 0;
    };
    self.htmlParser.element.prototype = {
      type : 1,
      add : self.htmlParser.fragment.prototype.add,
      clone : function() {
        return new self.htmlParser.element(this.name, this.attributes);
      },
      writeHtml : function(pdataOld, filter) {
        var attributes = this.attributes;
        var optgroup = this;
        var writeName = optgroup.name;
        var a;
        var newAttrName;
        var value;
        var isChildrenFiltered;
        optgroup.filterChildren = function() {
          if (!isChildrenFiltered) {
            var pdataOld = new self.htmlParser.basicWriter;
            self.htmlParser.fragment.prototype.writeChildrenHtml.call(optgroup, pdataOld, filter);
            optgroup.children = (new self.htmlParser.fragment.fromHtml(pdataOld.getHtml(), 0, optgroup.clone())).children;
            isChildrenFiltered = 1;
          }
        };
        if (filter) {
          for (;;) {
            if (!(writeName = filter.onElementName(writeName))) {
              return;
            }
            optgroup.name = writeName;
            if (!(optgroup = filter.onElement(optgroup))) {
              return;
            }
            optgroup.parent = this.parent;
            if (optgroup.name == writeName) {
              break;
            }
            if (optgroup.type != 1) {
              optgroup.writeHtml(pdataOld, filter);
              return;
            }
            writeName = optgroup.name;
            if (!writeName) {
              var k = 0;
              var kl = this.children.length;
              for (;k < kl;k++) {
                this.children[k].parent = optgroup.parent;
              }
              this.writeChildrenHtml.call(optgroup, pdataOld, isChildrenFiltered ? null : filter);
              return;
            }
          }
          attributes = optgroup.attributes;
        }
        pdataOld.openTag(writeName, attributes);
        var attribsArray = [];
        var i = 0;
        for (;i < 2;i++) {
          for (a in attributes) {
            newAttrName = a;
            value = attributes[a];
            if (i == 1) {
              attribsArray.push([a, value]);
            } else {
              if (filter) {
                for (;;) {
                  if (!(newAttrName = filter.onAttributeName(a))) {
                    delete attributes[a];
                    break;
                  } else {
                    if (newAttrName != a) {
                      delete attributes[a];
                      a = newAttrName;
                      continue;
                    } else {
                      break;
                    }
                  }
                }
                if (newAttrName) {
                  if ((value = filter.onAttribute(optgroup, newAttrName, value)) === false) {
                    delete attributes[newAttrName];
                  } else {
                    attributes[newAttrName] = value;
                  }
                }
              }
            }
          }
        }
        if (pdataOld.sortAttributes) {
          attribsArray.sort(sortAttribs);
        }
        var len = attribsArray.length;
        i = 0;
        for (;i < len;i++) {
          var attrib = attribsArray[i];
          pdataOld.attribute(attrib[0], attrib[1]);
        }
        pdataOld.openTagClose(writeName, optgroup.isEmpty);
        if (!optgroup.isEmpty) {
          this.writeChildrenHtml.call(optgroup, pdataOld, isChildrenFiltered ? null : filter);
          pdataOld.closeTag(writeName);
        }
      },
      writeChildrenHtml : function(writer, filter) {
        self.htmlParser.fragment.prototype.writeChildrenHtml.apply(this, arguments);
      }
    };
  })();
  (function() {
    function filterName(name, filters) {
      var i = 0;
      for (;name && i < filters.length;i++) {
        var filter = filters[i];
        name = name.replace(filter[0], filter[1]);
      }
      return name;
    }
    function addItemsToList(list, items, priority) {
      if (typeof items == "function") {
        items = [items];
      }
      var i;
      var j;
      var listLength = list.length;
      var itemsLength = items && items.length;
      if (itemsLength) {
        i = 0;
        for (;i < listLength && list[i].pri < priority;i++) {
        }
        j = itemsLength - 1;
        for (;j >= 0;j--) {
          var item = items[j];
          if (item) {
            item.pri = priority;
            list.splice(i, 0, item);
          }
        }
      }
    }
    function addNamedItems(hashTable, items, priority) {
      if (items) {
        var name;
        for (name in items) {
          var current = hashTable[name];
          hashTable[name] = transformNamedItem(current, items[name], priority);
          if (!current) {
            hashTable.$length++;
          }
        }
      }
    }
    function transformNamedItem(current, item, priority) {
      if (item) {
        item.pri = priority;
        if (current) {
          if (!current.splice) {
            if (current.pri > priority) {
              current = [item, current];
            } else {
              current = [current, item];
            }
            current.filter = callItems;
          } else {
            addItemsToList(current, item, priority);
          }
          return current;
        } else {
          item.filter = item;
          return item;
        }
      }
    }
    function callItems(currentEntry) {
      var r = currentEntry.type || currentEntry instanceof self.htmlParser.fragment;
      var i = 0;
      for (;i < this.length;i++) {
        if (r) {
          var orgType = currentEntry.type;
          var orgName = currentEntry.name;
        }
        var fn = this[i];
        var ret = fn.apply(window, arguments);
        if (ret === false) {
          return ret;
        }
        if (r) {
          if (ret && (ret.name != orgName || ret.type != orgType)) {
            return ret;
          }
        } else {
          if (typeof ret != "string") {
            return ret;
          }
        }
        if (ret != undefined) {
          currentEntry = ret;
        }
      }
      return currentEntry;
    }
    self.htmlParser.filter = $.createClass({
      $ : function(name) {
        this._ = {
          elementNames : [],
          attributeNames : [],
          elements : {
            $length : 0
          },
          attributes : {
            $length : 0
          }
        };
        if (name) {
          this.addRules(name, 10);
        }
      },
      proto : {
        addRules : function(opt_attributes, priority) {
          var self = this;
          if (typeof priority != "number") {
            priority = 10;
          }
          addItemsToList(self._.elementNames, opt_attributes.elementNames, priority);
          addItemsToList(self._.attributeNames, opt_attributes.attributeNames, priority);
          addNamedItems(self._.elements, opt_attributes.elements, priority);
          addNamedItems(self._.attributes, opt_attributes.attributes, priority);
          self._.text = transformNamedItem(self._.text, opt_attributes.text, priority) || self._.text;
          self._.comment = transformNamedItem(self._.comment, opt_attributes.comment, priority) || self._.comment;
          self._.root = transformNamedItem(self._.root, opt_attributes.root, priority) || self._.root;
        },
        onElementName : function(name) {
          return filterName(name, this._.elementNames);
        },
        onAttributeName : function(name) {
          return filterName(name, this._.attributeNames);
        },
        onText : function(text) {
          var textFilter = this._.text;
          return textFilter ? textFilter.filter(text) : text;
        },
        onComment : function(text, comment) {
          var textFilter = this._.comment;
          return textFilter ? textFilter.filter(text, comment) : text;
        },
        onFragment : function(element) {
          var rootFilter = this._.root;
          return rootFilter ? rootFilter.filter(element) : element;
        },
        onElement : function(element) {
          var context = this;
          var model = [context._.elements["^"], context._.elements[element.name], context._.elements.$];
          var instance;
          var ret;
          var instanceName = 0;
          for (;instanceName < 3;instanceName++) {
            instance = model[instanceName];
            if (instance) {
              ret = instance.filter(element, context);
              if (ret === false) {
                return null;
              }
              if (ret && ret != element) {
                return context.onNode(ret);
              }
              if (element.parent && !element.name) {
                break;
              }
            }
          }
          return element;
        },
        onNode : function(node) {
          var type = node.type;
          return type == 1 ? this.onElement(node) : type == 3 ? new self.htmlParser.text(this.onText(node.value)) : type == 8 ? new self.htmlParser.comment(this.onComment(node.value)) : null;
        },
        onAttribute : function(name, attrName, value) {
          var jQuery = this._.attributes[attrName];
          if (jQuery) {
            var ret = jQuery.filter(value, name, this);
            if (ret === false) {
              return false;
            }
            if (typeof ret != "undefined") {
              return ret;
            }
          }
          return value;
        }
      }
    });
  })();
  self.htmlParser.basicWriter = $.createClass({
    $ : function() {
      this._ = {
        output : []
      };
    },
    proto : {
      openTag : function(tagName, opt_attributes) {
        this._.output.push("<", tagName);
      },
      openTagClose : function(tagName, isSelfClose) {
        if (isSelfClose) {
          this._.output.push(" />");
        } else {
          this._.output.push(">");
        }
      },
      attribute : function(attName, attValue) {
        if (typeof attValue == "string") {
          attValue = $.htmlEncodeAttr(attValue);
        }
        this._.output.push(" ", attName, '="', attValue, '"');
      },
      closeTag : function(tagName) {
        this._.output.push("</", tagName, ">");
      },
      text : function(name) {
        this._.output.push(name);
      },
      comment : function(comment) {
        this._.output.push("\x3c!--", comment, "--\x3e");
      },
      write : function(text) {
        this._.output.push(text);
      },
      reset : function() {
        this._.output = [];
        this._.indent = false;
      },
      getHtml : function(dataAndEvents) {
        var html = this._.output.join("");
        if (dataAndEvents) {
          this.reset();
        }
        return html;
      }
    }
  });
  delete self.loadFullCore;
  self.instances = {};
  self.document = new doc(document);
  self.add = function(name) {
    self.instances[name.name] = name;
    name.on("focus", function() {
      if (self.currentInstance != name) {
        self.currentInstance = name;
        self.fire("currentInstance");
      }
    });
    name.on("blur", function() {
      if (self.currentInstance == name) {
        self.currentInstance = null;
        self.fire("currentInstance");
      }
    });
  };
  self.remove = function(name) {
    delete self.instances[name.name];
  };
  self.on("instanceDestroyed", function() {
    if ($.isEmpty(this.instances)) {
      self.fire("reset");
    }
  });
  self.TRISTATE_ON = 1;
  self.TRISTATE_OFF = 2;
  self.TRISTATE_DISABLED = 0;
  dom.comment = function(isXML, ownerDocument) {
    if (typeof isXML == "string") {
      isXML = (ownerDocument ? ownerDocument.$ : document).createComment(isXML);
    }
    dom.domObject.call(this, isXML);
  };
  dom.comment.prototype = new dom.node;
  $.extend(dom.comment.prototype, {
    type : 8,
    getOuterHtml : function() {
      return "\x3c!--" + this.$.nodeValue + "--\x3e";
    }
  });
  (function() {
    var pathBlockElements = {
      address : 1,
      blockquote : 1,
      dl : 1,
      h1 : 1,
      h2 : 1,
      h3 : 1,
      h4 : 1,
      h5 : 1,
      h6 : 1,
      p : 1,
      pre : 1,
      li : 1,
      dt : 1,
      dd : 1,
      legend : 1,
      caption : 1
    };
    var pathBlockLimitElements = {
      body : 1,
      div : 1,
      table : 1,
      tbody : 1,
      tr : 1,
      td : 1,
      th : 1,
      form : 1,
      fieldset : 1
    };
    var checkHasBlock = function(element) {
      var trs = element.getChildren();
      var i = 0;
      var padLength = trs.count();
      for (;i < padLength;i++) {
        var field = trs.getItem(i);
        if (field.type == 1 && dtd.$block[field.getName()]) {
          return true;
        }
      }
      return false;
    };
    dom.elementPath = function(lastNode) {
      var that = this;
      var block = null;
      var error = null;
      var elements = [];
      var e = lastNode;
      for (;e;) {
        if (e.type == 1) {
          if (!that.lastElement) {
            that.lastElement = e;
          }
          var elementName = e.getName();
          if (!error) {
            if (!block && pathBlockElements[elementName]) {
              block = e;
            }
            if (pathBlockLimitElements[elementName]) {
              if (!block && (elementName == "div" && !checkHasBlock(e))) {
                block = e;
              } else {
                error = e;
              }
            }
          }
          elements.push(e);
          if (elementName == "body") {
            break;
          }
        }
        e = e.getParent();
      }
      that.block = block;
      that.blockLimit = error;
      that.elements = elements;
    };
  })();
  dom.elementPath.prototype = {
    compare : function(otherPath) {
      var thisElements = this.elements;
      var otherElements = otherPath && otherPath.elements;
      if (!otherElements || thisElements.length != otherElements.length) {
        return false;
      }
      var i = 0;
      for (;i < thisElements.length;i++) {
        if (!thisElements[i].equals(otherElements[i])) {
          return false;
        }
      }
      return true;
    },
    contains : function(node) {
      var codeSegments = this.elements;
      var i = 0;
      for (;i < codeSegments.length;i++) {
        if (codeSegments[i].getName() in node) {
          return codeSegments[i];
        }
      }
      return null;
    }
  };
  dom.text = function(name, value) {
    if (typeof name == "string") {
      name = (value ? value.$ : document).createTextNode(name);
    }
    this.$ = name;
  };
  dom.text.prototype = new dom.node;
  $.extend(dom.text.prototype, {
    type : 3,
    getLength : function() {
      return this.$.nodeValue.length;
    },
    getText : function() {
      return this.$.nodeValue;
    },
    setText : function(text) {
      this.$.nodeValue = text;
    },
    split : function(offset) {
      var optgroup = this;
      if (href && offset == optgroup.getLength()) {
        var options = optgroup.getDocument().createText("");
        options.insertAfter(optgroup);
        return options;
      }
      var base64 = optgroup.getDocument();
      var rvar = new dom.text(optgroup.$.splitText(offset), base64);
      if (env.ie8) {
        var c = new dom.text("", base64);
        c.insertAfter(rvar);
        c.remove();
      }
      return rvar;
    },
    substring : function(from, start) {
      if (typeof start != "number") {
        return this.$.nodeValue.substr(from);
      } else {
        return this.$.nodeValue.substring(from, start);
      }
    }
  });
  dom.documentFragment = function(ownerDocument) {
    ownerDocument = ownerDocument || self.document;
    this.$ = ownerDocument.$.createDocumentFragment();
  };
  $.extend(dom.documentFragment.prototype, Node.prototype, {
    type : 11,
    insertAfterNode : function(node) {
      node = node.$;
      node.parentNode.insertBefore(this.$, node.nextSibling);
    }
  }, true, {
    append : 1,
    appendBogus : 1,
    getFirst : 1,
    getLast : 1,
    appendTo : 1,
    moveChildren : 1,
    insertBefore : 1,
    insertAfterNode : 1,
    replace : 1,
    trim : 1,
    type : 1,
    ltrim : 1,
    rtrim : 1,
    getDocument : 1,
    getChildCount : 1,
    getChild : 1,
    getChildren : 1
  });
  (function() {
    function iterate(rtl, breakOnFalse) {
      var range = this.range;
      if (this._.end) {
        return null;
      }
      if (!this._.start) {
        this._.start = 1;
        if (range.collapsed) {
          this.end();
          return null;
        }
        range.optimize();
      }
      var node;
      var startCt = range.startContainer;
      var endCt = range.endContainer;
      var startOffset = range.startOffset;
      var endOffset = range.endOffset;
      var guard;
      var userGuard = this.guard;
      var type = this.type;
      var getSourceNodeFn = rtl ? "getPreviousSourceNode" : "getNextSourceNode";
      if (!rtl && !this._.guardLTR) {
        var limitLTR = endCt.type == 1 ? endCt : endCt.getParent();
        var match = endCt.type == 1 ? endCt.getChild(endOffset) : endCt.getNext();
        this._.guardLTR = function(node, dataAndEvents) {
          return(!dataAndEvents || !limitLTR.equals(node)) && ((!match || !node.equals(match)) && (node.type != 1 || (!dataAndEvents || node.getName() != "body")));
        };
      }
      if (rtl && !this._.guardRTL) {
        var limitRTL = startCt.type == 1 ? startCt : startCt.getParent();
        var rvar = startCt.type == 1 ? startOffset ? startCt.getChild(startOffset - 1) : null : startCt.getPrevious();
        this._.guardRTL = function(node, dataAndEvents) {
          return(!dataAndEvents || !limitRTL.equals(node)) && ((!rvar || !node.equals(rvar)) && (node.type != 1 || (!dataAndEvents || node.getName() != "body")));
        };
      }
      var stopGuard = rtl ? this._.guardRTL : this._.guardLTR;
      if (userGuard) {
        guard = function(node, dataAndEvents) {
          if (stopGuard(node, dataAndEvents) === false) {
            return false;
          }
          return userGuard(node, dataAndEvents);
        };
      } else {
        guard = stopGuard;
      }
      if (this.current) {
        node = this.current[getSourceNodeFn](false, type, guard);
      } else {
        if (rtl) {
          node = endCt;
          if (node.type == 1) {
            if (endOffset > 0) {
              node = node.getChild(endOffset - 1);
            } else {
              node = guard(node, true) === false ? null : node.getPreviousSourceNode(true, type, guard);
            }
          }
        } else {
          node = startCt;
          if (node.type == 1) {
            if (!(node = node.getChild(startOffset))) {
              node = guard(startCt, true) === false ? null : startCt.getNextSourceNode(true, type, guard);
            }
          }
        }
        if (node && guard(node) === false) {
          node = null;
        }
      }
      for (;node && !this._.end;) {
        this.current = node;
        if (!this.evaluator || this.evaluator(node) !== false) {
          if (!breakOnFalse) {
            return node;
          }
        } else {
          if (breakOnFalse && this.evaluator) {
            return false;
          }
        }
        node = node[getSourceNodeFn](false, type, guard);
      }
      this.end();
      return this.current = null;
    }
    function find(isXML) {
      var subKey;
      var result = null;
      for (;subKey = iterate.call(this, isXML);) {
        result = subKey;
      }
      return result;
    }
    dom.walker = $.createClass({
      $ : function(name) {
        this.range = name;
        this._ = {};
      },
      proto : {
        end : function() {
          this._.end = 1;
        },
        next : function() {
          return iterate.call(this);
        },
        previous : function() {
          return iterate.call(this, 1);
        },
        checkForward : function() {
          return iterate.call(this, 0, 1) !== false;
        },
        checkBackward : function() {
          return iterate.call(this, 1, 1) !== false;
        },
        lastForward : function() {
          return find.call(this);
        },
        lastBackward : function() {
          return find.call(this, 1);
        },
        reset : function() {
          delete this.current;
          this._ = {};
        }
      }
    });
    var blockBoundaryDisplayMatch = {
      block : 1,
      "list-item" : 1,
      table : 1,
      "table-row-group" : 1,
      "table-header-group" : 1,
      "table-footer-group" : 1,
      "table-row" : 1,
      "table-column-group" : 1,
      "table-column" : 1,
      "table-cell" : 1,
      "table-caption" : 1
    };
    Node.prototype.isBlockBoundary = function(opt_attributes) {
      var record = opt_attributes ? $.extend({}, dtd.$block, opt_attributes || {}) : dtd.$block;
      return this.getComputedStyle("float") == "none" && blockBoundaryDisplayMatch[this.getComputedStyle("display")] || record[this.getName()];
    };
    dom.walker.blockBoundary = function(opt_attributes) {
      return function(node, dataAndEvents) {
        return!(node.type == 1 && node.isBlockBoundary(opt_attributes));
      };
    };
    dom.walker.listItemBoundary = function() {
      return this.blockBoundary({
        br : 1
      });
    };
    dom.walker.bookmark = function(recurring, dataAndEvents) {
      function isBookmarkNode(node) {
        return node && (node.getName && (node.getName() == "span" && node.data("cke-bookmark")));
      }
      return function(node) {
        var isBookmark;
        var parent;
        isBookmark = node && (!node.getName && ((parent = node.getParent()) && isBookmarkNode(parent)));
        isBookmark = recurring ? isBookmark : isBookmark || isBookmarkNode(node);
        return!!(dataAndEvents ^ isBookmark);
      };
    };
    dom.walker.whitespaces = function(dataAndEvents) {
      return function(range) {
        var rangeContainer = range && (range.type == 3 && !$.trim(range.getText()));
        return!!(dataAndEvents ^ rangeContainer);
      };
    };
    dom.walker.invisible = function(dataAndEvents) {
      var traverseNode = dom.walker.whitespaces();
      return function(node) {
        var v = traverseNode(node) || node.is && !node.$.offsetHeight;
        return!!(dataAndEvents ^ v);
      };
    };
    dom.walker.nodeType = function(type, isReject) {
      return function(panel) {
        return!!(isReject ^ panel.type == type);
      };
    };
    dom.walker.bogus = function(isReject) {
      function nonEmpty(node) {
        return!isBookmark(node) && !isWhitespaces(node);
      }
      return function(node) {
        var isWhitespace = !href ? node.is && node.is("br") : node.getText && rhtml.test(node.getText());
        if (isWhitespace) {
          var parent = node.getParent();
          var next = node.getNext(nonEmpty);
          isWhitespace = parent.isBlockBoundary() && (!next || next.type == 1 && next.isBlockBoundary());
        }
        return!!(isReject ^ isWhitespace);
      };
    };
    var rhtml = /^[\t\r\n ]*(?:&nbsp;|\xa0)$/;
    var isBookmark = dom.walker.whitespaces();
    var isWhitespaces = dom.walker.bookmark();
    var toSkip = function(node) {
      return isWhitespaces(node) || (isBookmark(node) || node.type == 1 && (node.getName() in dtd.$inline && !(node.getName() in dtd.$empty)));
    };
    Node.prototype.getBogus = function() {
      var tail = this;
      do {
        tail = tail.getPreviousSourceNode();
      } while (toSkip(tail));
      if (tail && (!href ? tail.is && tail.is("br") : tail.getText && rhtml.test(tail.getText()))) {
        return tail;
      }
      return false;
    };
  })();
  dom.range = function(stop) {
    var obj = this;
    obj.startContainer = null;
    obj.startOffset = null;
    obj.endContainer = null;
    obj.endOffset = null;
    obj.collapsed = true;
    obj.document = stop;
  };
  (function() {
    function getCheckStartEndBlockEvalFunction(recurring) {
      var v = false;
      var traverseNode = dom.walker.bookmark(true);
      var rhtml = /^[\t\r\n ]*(?:&nbsp;|\xa0)$/;
      return function(node) {
        if (traverseNode(node)) {
          return true;
        }
        if (node.type == 3) {
          if (href && (rhtml.test(node.getText()) && (!v && !(recurring && node.getNext())))) {
            v = true;
          } else {
            if (node.hasAscendant("pre") || $.trim(node.getText()).length) {
              return false;
            }
          }
        } else {
          if (node.type == 1) {
            if (!inlineChildReqElements[node.getName()]) {
              if (!href && (node.is("br") && (!v && !(recurring && node.getNext())))) {
                v = true;
              } else {
                return false;
              }
            }
          }
        }
        return true;
      };
    }
    function guard(checkStart) {
      return function(node) {
        return!checkStart && isBogus(node) || (node.type == 3 ? !$.trim(node.getText()) || !!node.getParent().data("cke-bookmark") : node.getName() in dtd.$removeEmpty);
      };
    }
    function alpha(a) {
      return!isUndefinedOrNull(a) && !bindCallbacks(a);
    }
    var updateCollapsed = function(range) {
      range.collapsed = range.startContainer && (range.endContainer && (range.startContainer.equals(range.endContainer) && range.startOffset == range.endOffset));
    };
    var execContentsAction = function(range, recurring, docFrag, deepDataAndEvents) {
      range.optimizeBookmark();
      var startNode = range.startContainer;
      var endNode = range.endContainer;
      var startOffset = range.startOffset;
      var endOffset = range.endOffset;
      var C;
      var elem;
      if (endNode.type == 3) {
        endNode = endNode.split(endOffset);
      } else {
        if (endNode.getChildCount() > 0) {
          if (endOffset >= endNode.getChildCount()) {
            endNode = endNode.append(range.document.createText(""));
            elem = true;
          } else {
            endNode = endNode.getChild(endOffset);
          }
        }
      }
      if (startNode.type == 3) {
        startNode.split(startOffset);
        if (startNode.equals(endNode)) {
          endNode = startNode.getNext();
        }
      } else {
        if (!startOffset) {
          startNode = startNode.getFirst().insertBeforeMe(range.document.createText(""));
          C = true;
        } else {
          if (startOffset >= startNode.getChildCount()) {
            startNode = startNode.append(range.document.createText(""));
            C = true;
          } else {
            startNode = startNode.getChild(startOffset).getPrevious();
          }
        }
      }
      var startParents = startNode.getParents();
      var endParents = endNode.getParents();
      var i;
      var optgroup;
      var node;
      i = 0;
      for (;i < startParents.length;i++) {
        optgroup = startParents[i];
        node = endParents[i];
        if (!optgroup.equals(node)) {
          break;
        }
      }
      var clone = docFrag;
      var levelStartNode;
      var levelClone;
      var currentNode;
      var nextNode;
      var j = i;
      for (;j < startParents.length;j++) {
        levelStartNode = startParents[j];
        if (clone && !levelStartNode.equals(startNode)) {
          levelClone = clone.append(levelStartNode.clone());
        }
        currentNode = levelStartNode.getNext();
        for (;currentNode;) {
          if (currentNode.equals(endParents[j]) || currentNode.equals(endNode)) {
            break;
          }
          nextNode = currentNode.getNext();
          if (recurring == 2) {
            clone.append(currentNode.clone(true));
          } else {
            currentNode.remove();
            if (recurring == 1) {
              clone.append(currentNode);
            }
          }
          currentNode = nextNode;
        }
        if (clone) {
          clone = levelClone;
        }
      }
      clone = docFrag;
      var k = i;
      for (;k < endParents.length;k++) {
        levelStartNode = endParents[k];
        if (recurring > 0 && !levelStartNode.equals(endNode)) {
          levelClone = clone.append(levelStartNode.clone());
        }
        if (!startParents[k] || levelStartNode.$.parentNode != startParents[k].$.parentNode) {
          currentNode = levelStartNode.getPrevious();
          for (;currentNode;) {
            if (currentNode.equals(startParents[k]) || currentNode.equals(startNode)) {
              break;
            }
            nextNode = currentNode.getPrevious();
            if (recurring == 2) {
              clone.$.insertBefore(currentNode.$.cloneNode(true), clone.$.firstChild);
            } else {
              currentNode.remove();
              if (recurring == 1) {
                clone.$.insertBefore(currentNode.$, clone.$.firstChild);
              }
            }
            currentNode = nextNode;
          }
        }
        if (clone) {
          clone = levelClone;
        }
      }
      if (recurring == 2) {
        var startTextNode = range.startContainer;
        if (startTextNode.type == 3) {
          startTextNode.$.data += startTextNode.$.nextSibling.data;
          startTextNode.$.parentNode.removeChild(startTextNode.$.nextSibling);
        }
        var endTextNode = range.endContainer;
        if (endTextNode.type == 3 && endTextNode.$.nextSibling) {
          endTextNode.$.data += endTextNode.$.nextSibling.data;
          endTextNode.$.parentNode.removeChild(endTextNode.$.nextSibling);
        }
      } else {
        if (optgroup && (node && (startNode.$.parentNode != optgroup.$.parentNode || endNode.$.parentNode != node.$.parentNode))) {
          var theLength = node.getIndex();
          if (C && node.$.parentNode == startNode.$.parentNode) {
            theLength--;
          }
          if (deepDataAndEvents && optgroup.type == 1) {
            var self = Node.createFromHtml('<span data-cke-bookmark="1" style="display:none">&nbsp;</span>', range.document);
            self.insertAfter(optgroup);
            optgroup.mergeSiblings(false);
            range.moveToBookmark({
              startNode : self
            });
          } else {
            range.setStart(node.getParent(), theLength);
          }
        }
        range.collapse(true);
      }
      if (C) {
        startNode.remove();
      }
      if (elem && endNode.$.parentNode) {
        endNode.remove();
      }
    };
    var inlineChildReqElements = {
      abbr : 1,
      acronym : 1,
      b : 1,
      bdo : 1,
      big : 1,
      cite : 1,
      code : 1,
      del : 1,
      dfn : 1,
      em : 1,
      font : 1,
      i : 1,
      ins : 1,
      label : 1,
      kbd : 1,
      q : 1,
      samp : 1,
      small : 1,
      span : 1,
      strike : 1,
      strong : 1,
      sub : 1,
      sup : 1,
      tt : 1,
      u : 1,
      "var" : 1
    };
    var isBogus = dom.walker.bogus();
    var isUndefinedOrNull = new dom.walker.whitespaces;
    var bindCallbacks = new dom.walker.bookmark;
    dom.range.prototype = {
      clone : function() {
        var self = this;
        var clone = new dom.range(self.document);
        clone.startContainer = self.startContainer;
        clone.startOffset = self.startOffset;
        clone.endContainer = self.endContainer;
        clone.endOffset = self.endOffset;
        clone.collapsed = self.collapsed;
        return clone;
      },
      collapse : function(recurring) {
        var self = this;
        if (recurring) {
          self.endContainer = self.startContainer;
          self.endOffset = self.startOffset;
        } else {
          self.startContainer = self.endContainer;
          self.startOffset = self.endOffset;
        }
        self.collapsed = true;
      },
      cloneContents : function() {
        var docFrag = new dom.documentFragment(this.document);
        if (!this.collapsed) {
          execContentsAction(this, 2, docFrag);
        }
        return docFrag;
      },
      deleteContents : function(deepDataAndEvents) {
        if (this.collapsed) {
          return;
        }
        execContentsAction(this, 0, null, deepDataAndEvents);
      },
      extractContents : function(deepDataAndEvents) {
        var docFrag = new dom.documentFragment(this.document);
        if (!this.collapsed) {
          execContentsAction(this, 1, docFrag, deepDataAndEvents);
        }
        return docFrag;
      },
      createBookmark : function(dataAndEvents) {
        var range = this;
        var startNode;
        var endNode;
        var baseId;
        var clone;
        var collapsed = range.collapsed;
        startNode = range.document.createElement("span");
        startNode.data("cke-bookmark", 1);
        startNode.setStyle("display", "none");
        startNode.setHtml("&nbsp;");
        if (dataAndEvents) {
          baseId = "cke_bm_" + $.getNextNumber();
          startNode.setAttribute("id", baseId + (collapsed ? "C" : "S"));
        }
        if (!collapsed) {
          endNode = startNode.clone();
          endNode.setHtml("&nbsp;");
          if (dataAndEvents) {
            endNode.setAttribute("id", baseId + "E");
          }
          clone = range.clone();
          clone.collapse();
          clone.insertNode(endNode);
        }
        clone = range.clone();
        clone.collapse(true);
        clone.insertNode(startNode);
        if (endNode) {
          range.setStartAfter(startNode);
          range.setEndBefore(endNode);
        } else {
          range.moveToPosition(startNode, 4);
        }
        return{
          startNode : dataAndEvents ? baseId + (collapsed ? "C" : "S") : startNode,
          endNode : dataAndEvents ? baseId + "E" : endNode,
          serializable : dataAndEvents,
          collapsed : collapsed
        };
      },
      createBookmark2 : function(normalized) {
        var self = this;
        var startContainer = self.startContainer;
        var endContainer = self.endContainer;
        var startOffset = self.startOffset;
        var endOffset = self.endOffset;
        var collapsed = self.collapsed;
        var child;
        var previous;
        if (!startContainer || !endContainer) {
          return{
            start : 0,
            end : 0
          };
        }
        if (normalized) {
          if (startContainer.type == 1) {
            child = startContainer.getChild(startOffset);
            if (child && (child.type == 3 && (startOffset > 0 && child.getPrevious().type == 3))) {
              startContainer = child;
              startOffset = 0;
            }
            if (child && child.type == 1) {
              startOffset = child.getIndex(1);
            }
          }
          for (;startContainer.type == 3 && ((previous = startContainer.getPrevious()) && previous.type == 3);) {
            startContainer = previous;
            startOffset += previous.getLength();
          }
          if (!collapsed) {
            if (endContainer.type == 1) {
              child = endContainer.getChild(endOffset);
              if (child && (child.type == 3 && (endOffset > 0 && child.getPrevious().type == 3))) {
                endContainer = child;
                endOffset = 0;
              }
              if (child && child.type == 1) {
                endOffset = child.getIndex(1);
              }
            }
            for (;endContainer.type == 3 && ((previous = endContainer.getPrevious()) && previous.type == 3);) {
              endContainer = previous;
              endOffset += previous.getLength();
            }
          }
        }
        return{
          start : startContainer.getAddress(normalized),
          end : collapsed ? null : endContainer.getAddress(normalized),
          startOffset : startOffset,
          endOffset : endOffset,
          normalized : normalized,
          collapsed : collapsed,
          is2 : true
        };
      },
      moveToBookmark : function(bookmark) {
        var self = this;
        if (bookmark.is2) {
          var startContainer = self.document.getByAddress(bookmark.start, bookmark.normalized);
          var startOffset = bookmark.startOffset;
          var endContainer = bookmark.end && self.document.getByAddress(bookmark.end, bookmark.normalized);
          var endOffset = bookmark.endOffset;
          self.setStart(startContainer, startOffset);
          if (endContainer) {
            self.setEnd(endContainer, endOffset);
          } else {
            self.collapse(true);
          }
        } else {
          var serializable = bookmark.serializable;
          var startNode = serializable ? self.document.getById(bookmark.startNode) : bookmark.startNode;
          var endNode = serializable ? self.document.getById(bookmark.endNode) : bookmark.endNode;
          self.setStartBefore(startNode);
          startNode.remove();
          if (endNode) {
            self.setEndBefore(endNode);
            endNode.remove();
          } else {
            self.collapse(true);
          }
        }
      },
      getBoundaryNodes : function() {
        var self = this;
        var startNode = self.startContainer;
        var endNode = self.endContainer;
        var startOffset = self.startOffset;
        var endOffset = self.endOffset;
        var childCount;
        if (startNode.type == 1) {
          childCount = startNode.getChildCount();
          if (childCount > startOffset) {
            startNode = startNode.getChild(startOffset);
          } else {
            if (childCount < 1) {
              startNode = startNode.getPreviousSourceNode();
            } else {
              startNode = startNode.$;
              for (;startNode.lastChild;) {
                startNode = startNode.lastChild;
              }
              startNode = new dom.node(startNode);
              startNode = startNode.getNextSourceNode() || startNode;
            }
          }
        }
        if (endNode.type == 1) {
          childCount = endNode.getChildCount();
          if (childCount > endOffset) {
            endNode = endNode.getChild(endOffset).getPreviousSourceNode(true);
          } else {
            if (childCount < 1) {
              endNode = endNode.getPreviousSourceNode();
            } else {
              endNode = endNode.$;
              for (;endNode.lastChild;) {
                endNode = endNode.lastChild;
              }
              endNode = new dom.node(endNode);
            }
          }
        }
        if (startNode.getPosition(endNode) & 2) {
          startNode = endNode;
        }
        return{
          startNode : startNode,
          endNode : endNode
        };
      },
      getCommonAncestor : function(recurring, dataAndEvents) {
        var self = this;
        var node = self.startContainer;
        var source = self.endContainer;
        var target;
        if (node.equals(source)) {
          if (recurring && (node.type == 1 && self.startOffset == self.endOffset - 1)) {
            target = node.getChild(self.startOffset);
          } else {
            target = node;
          }
        } else {
          target = node.getCommonAncestor(source);
        }
        return dataAndEvents && !target.is ? target.getParent() : target;
      },
      optimize : function() {
        var rng = this;
        var container = rng.startContainer;
        var offset = rng.startOffset;
        if (container.type != 1) {
          if (!offset) {
            rng.setStartBefore(container);
          } else {
            if (offset >= container.getLength()) {
              rng.setStartAfter(container);
            }
          }
        }
        container = rng.endContainer;
        offset = rng.endOffset;
        if (container.type != 1) {
          if (!offset) {
            rng.setEndBefore(container);
          } else {
            if (offset >= container.getLength()) {
              rng.setEndAfter(container);
            }
          }
        }
      },
      optimizeBookmark : function() {
        var self = this;
        var startNode = self.startContainer;
        var endNode = self.endContainer;
        if (startNode.is && (startNode.is("span") && startNode.data("cke-bookmark"))) {
          self.setStartAt(startNode, 3);
        }
        if (endNode && (endNode.is && (endNode.is("span") && endNode.data("cke-bookmark")))) {
          self.setEndAt(endNode, 4);
        }
      },
      trim : function(text, dataAndEvents) {
        var self = this;
        var startContainer = self.startContainer;
        var startOffset = self.startOffset;
        var collapsed = self.collapsed;
        if ((!text || collapsed) && (startContainer && startContainer.type == 3)) {
          if (!startOffset) {
            startOffset = startContainer.getIndex();
            startContainer = startContainer.getParent();
          } else {
            if (startOffset >= startContainer.getLength()) {
              startOffset = startContainer.getIndex() + 1;
              startContainer = startContainer.getParent();
            } else {
              var nextText = startContainer.split(startOffset);
              startOffset = startContainer.getIndex() + 1;
              startContainer = startContainer.getParent();
              if (self.startContainer.equals(self.endContainer)) {
                self.setEnd(nextText, self.endOffset - self.startOffset);
              } else {
                if (startContainer.equals(self.endContainer)) {
                  self.endOffset += 1;
                }
              }
            }
          }
          self.setStart(startContainer, startOffset);
          if (collapsed) {
            self.collapse(true);
            return;
          }
        }
        var endContainer = self.endContainer;
        var endOffset = self.endOffset;
        if (!(dataAndEvents || collapsed) && (endContainer && endContainer.type == 3)) {
          if (!endOffset) {
            endOffset = endContainer.getIndex();
            endContainer = endContainer.getParent();
          } else {
            if (endOffset >= endContainer.getLength()) {
              endOffset = endContainer.getIndex() + 1;
              endContainer = endContainer.getParent();
            } else {
              endContainer.split(endOffset);
              endOffset = endContainer.getIndex() + 1;
              endContainer = endContainer.getParent();
            }
          }
          self.setEnd(endContainer, endOffset);
        }
      },
      enlarge : function(expectedNumberOfNonCommentArgs, dataAndEvents) {
        switch(expectedNumberOfNonCommentArgs) {
          case 1:
            if (this.collapsed) {
              return;
            }
            var vvar = this.getCommonAncestor();
            var body = this.document.getBody();
            var a;
            var b;
            var enlargeable;
            var sibling;
            var stack;
            var memory = false;
            var result;
            var xhtml;
            var container = this.startContainer;
            var offset = this.startOffset;
            if (container.type == 3) {
              if (offset) {
                container = !$.trim(container.substring(0, offset)).length && container;
                memory = !!container;
              }
              if (container) {
                if (!(sibling = container.getPrevious())) {
                  enlargeable = container.getParent();
                }
              }
            } else {
              if (offset) {
                sibling = container.getChild(offset - 1) || container.getLast();
              }
              if (!sibling) {
                enlargeable = container;
              }
            }
            for (;enlargeable || sibling;) {
              if (enlargeable && !sibling) {
                if (!stack && enlargeable.equals(vvar)) {
                  stack = true;
                }
                if (!body.contains(enlargeable)) {
                  break;
                }
                if (!memory || enlargeable.getComputedStyle("display") != "inline") {
                  memory = false;
                  if (stack) {
                    a = enlargeable;
                  } else {
                    this.setStartBefore(enlargeable);
                  }
                }
                sibling = enlargeable.getPrevious();
              }
              for (;sibling;) {
                result = false;
                if (sibling.type == 8) {
                  sibling = sibling.getPrevious();
                  continue;
                } else {
                  if (sibling.type == 3) {
                    xhtml = sibling.getText();
                    if (/[^\s\ufeff]/.test(xhtml)) {
                      sibling = null;
                    }
                    result = /[\s\ufeff]$/.test(xhtml);
                  } else {
                    if ((sibling.$.offsetWidth > 0 || dataAndEvents && sibling.is("br")) && !sibling.data("cke-bookmark")) {
                      if (memory && dtd.$removeEmpty[sibling.getName()]) {
                        xhtml = sibling.getText();
                        if (/[^\s\ufeff]/.test(xhtml)) {
                          sibling = null;
                        } else {
                          var t = sibling.$.getElementsByTagName("*");
                          var k = 0;
                          var target;
                          for (;target = t[k++];) {
                            if (!dtd.$removeEmpty[target.nodeName.toLowerCase()]) {
                              sibling = null;
                              break;
                            }
                          }
                        }
                        if (sibling) {
                          result = !!xhtml.length;
                        }
                      } else {
                        sibling = null;
                      }
                    }
                  }
                }
                if (result) {
                  if (memory) {
                    if (stack) {
                      a = enlargeable;
                    } else {
                      if (enlargeable) {
                        this.setStartBefore(enlargeable);
                      }
                    }
                  } else {
                    memory = true;
                  }
                }
                if (sibling) {
                  var next = sibling.getPrevious();
                  if (!enlargeable && !next) {
                    enlargeable = sibling;
                    sibling = null;
                    break;
                  }
                  sibling = next;
                } else {
                  enlargeable = null;
                }
              }
              if (enlargeable) {
                enlargeable = enlargeable.getParent();
              }
            }
            container = this.endContainer;
            offset = this.endOffset;
            enlargeable = sibling = null;
            stack = memory = false;
            if (container.type == 3) {
              container = !$.trim(container.substring(offset)).length && container;
              memory = !(container && container.getLength());
              if (container) {
                if (!(sibling = container.getNext())) {
                  enlargeable = container.getParent();
                }
              }
            } else {
              sibling = container.getChild(offset);
              if (!sibling) {
                enlargeable = container;
              }
            }
            for (;enlargeable || sibling;) {
              if (enlargeable && !sibling) {
                if (!stack && enlargeable.equals(vvar)) {
                  stack = true;
                }
                if (!body.contains(enlargeable)) {
                  break;
                }
                if (!memory || enlargeable.getComputedStyle("display") != "inline") {
                  memory = false;
                  if (stack) {
                    b = enlargeable;
                  } else {
                    if (enlargeable) {
                      this.setEndAfter(enlargeable);
                    }
                  }
                }
                sibling = enlargeable.getNext();
              }
              for (;sibling;) {
                result = false;
                if (sibling.type == 3) {
                  xhtml = sibling.getText();
                  if (/[^\s\ufeff]/.test(xhtml)) {
                    sibling = null;
                  }
                  result = /^[\s\ufeff]/.test(xhtml);
                } else {
                  if (sibling.type == 1) {
                    if ((sibling.$.offsetWidth > 0 || dataAndEvents && sibling.is("br")) && !sibling.data("cke-bookmark")) {
                      if (memory && dtd.$removeEmpty[sibling.getName()]) {
                        xhtml = sibling.getText();
                        if (/[^\s\ufeff]/.test(xhtml)) {
                          sibling = null;
                        } else {
                          t = sibling.$.getElementsByTagName("*");
                          k = 0;
                          for (;target = t[k++];) {
                            if (!dtd.$removeEmpty[target.nodeName.toLowerCase()]) {
                              sibling = null;
                              break;
                            }
                          }
                        }
                        if (sibling) {
                          result = !!xhtml.length;
                        }
                      } else {
                        sibling = null;
                      }
                    }
                  } else {
                    result = 1;
                  }
                }
                if (result) {
                  if (memory) {
                    if (stack) {
                      b = enlargeable;
                    } else {
                      this.setEndAfter(enlargeable);
                    }
                  }
                }
                if (sibling) {
                  next = sibling.getNext();
                  if (!enlargeable && !next) {
                    enlargeable = sibling;
                    sibling = null;
                    break;
                  }
                  sibling = next;
                } else {
                  enlargeable = null;
                }
              }
              if (enlargeable) {
                enlargeable = enlargeable.getParent();
              }
            }
            if (a && b) {
              vvar = a.contains(b) ? b : a;
              this.setStartBefore(vvar);
              this.setEndAfter(vvar);
            }
            break;
          case 2:
          ;
          case 3:
            var walkerRange = new dom.range(this.document);
            body = this.document.getBody();
            walkerRange.setStartAt(body, 1);
            walkerRange.setEnd(this.startContainer, this.startOffset);
            var walker = new dom.walker(walkerRange);
            var blockBoundary;
            var tailBr;
            var notBlockBoundary = dom.walker.blockBoundary(expectedNumberOfNonCommentArgs == 3 ? {
              br : 1
            } : null);
            var boundaryGuard = function(node) {
              var retval = notBlockBoundary(node);
              if (!retval) {
                blockBoundary = node;
              }
              return retval;
            };
            var tailBrGuard = function(node) {
              var retval = boundaryGuard(node);
              if (!retval && (node.is && node.is("br"))) {
                tailBr = node;
              }
              return retval;
            };
            walker.guard = boundaryGuard;
            enlargeable = walker.lastBackward();
            blockBoundary = blockBoundary || body;
            this.setStartAt(blockBoundary, !blockBoundary.is("br") && (!enlargeable && this.checkStartOfBlock() || enlargeable && blockBoundary.contains(enlargeable)) ? 1 : 4);
            if (expectedNumberOfNonCommentArgs == 3) {
              var theRange = this.clone();
              walker = new dom.walker(theRange);
              var traverseNode = dom.walker.whitespaces();
              var whitespaces = dom.walker.bookmark();
              walker.evaluator = function(node) {
                return!traverseNode(node) && !whitespaces(node);
              };
              var msg = walker.previous();
              if (msg && (msg.type == 1 && msg.is("br"))) {
                return;
              }
            }
            walkerRange = this.clone();
            walkerRange.collapse();
            walkerRange.setEndAt(body, 2);
            walker = new dom.walker(walkerRange);
            walker.guard = expectedNumberOfNonCommentArgs == 3 ? tailBrGuard : boundaryGuard;
            blockBoundary = null;
            enlargeable = walker.lastForward();
            blockBoundary = blockBoundary || body;
            this.setEndAt(blockBoundary, !enlargeable && this.checkEndOfBlock() || enlargeable && blockBoundary.contains(enlargeable) ? 2 : 3);
            if (tailBr) {
              this.setEndAfter(tailBr);
            }
          ;
        }
      },
      shrink : function(mode, dataAndEvents) {
        if (!this.collapsed) {
          mode = mode || 2;
          var walkerRange = this.clone();
          var startContainer = this.startContainer;
          var endContainer = this.endContainer;
          var startOffset = this.startOffset;
          var endOffset = this.endOffset;
          var collapsed = this.collapsed;
          var program = 1;
          var inverse = 1;
          if (startContainer && startContainer.type == 3) {
            if (!startOffset) {
              walkerRange.setStartBefore(startContainer);
            } else {
              if (startOffset >= startContainer.getLength()) {
                walkerRange.setStartAfter(startContainer);
              } else {
                walkerRange.setStartBefore(startContainer);
                program = 0;
              }
            }
          }
          if (endContainer && endContainer.type == 3) {
            if (!endOffset) {
              walkerRange.setEndBefore(endContainer);
            } else {
              if (endOffset >= endContainer.getLength()) {
                walkerRange.setEndAfter(endContainer);
              } else {
                walkerRange.setEndAfter(endContainer);
                inverse = 0;
              }
            }
          }
          var walker = new dom.walker(walkerRange);
          var traverseNode = dom.walker.bookmark();
          walker.evaluator = function(node) {
            return node.type == (mode == 1 ? 1 : 3);
          };
          var match;
          walker.guard = function(node, dataAndEvents) {
            if (traverseNode(node)) {
              return true;
            }
            if (mode == 1 && node.type == 3) {
              return false;
            }
            if (dataAndEvents && node.equals(match)) {
              return false;
            }
            if (!dataAndEvents && node.type == 1) {
              match = node;
            }
            return true;
          };
          if (program) {
            var textStart = walker[mode == 1 ? "lastForward" : "next"]();
            if (textStart) {
              this.setStartAt(textStart, dataAndEvents ? 1 : 3);
            }
          }
          if (inverse) {
            walker.reset();
            var textEnd = walker[mode == 1 ? "lastBackward" : "previous"]();
            if (textEnd) {
              this.setEndAt(textEnd, dataAndEvents ? 2 : 4);
            }
          }
          return!!(program || inverse);
        }
      },
      insertNode : function(node) {
        var range = this;
        range.optimizeBookmark();
        range.trim(false, true);
        var startContainer = range.startContainer;
        var recurring = range.startOffset;
        var optgroup = startContainer.getChild(recurring);
        if (optgroup) {
          node.insertBefore(optgroup);
        } else {
          startContainer.append(node);
        }
        if (node.getParent().equals(range.endContainer)) {
          range.endOffset++;
        }
        range.setStartBefore(node);
      },
      moveToPosition : function(node, opt_attributes) {
        this.setStartAt(node, opt_attributes);
        this.collapse(true);
      },
      selectNodeContents : function(node) {
        this.setStart(node, 0);
        this.setEnd(node, node.type == 3 ? node.getLength() : node.getChildCount());
      },
      setStart : function(startNode, offset) {
        var self = this;
        if (startNode.type == 1 && dtd.$empty[startNode.getName()]) {
          offset = startNode.getIndex();
          startNode = startNode.getParent();
        }
        self.startContainer = startNode;
        self.startOffset = offset;
        if (!self.endContainer) {
          self.endContainer = startNode;
          self.endOffset = offset;
        }
        updateCollapsed(self);
      },
      setEnd : function(endNode, endOffset) {
        var self = this;
        if (endNode.type == 1 && dtd.$empty[endNode.getName()]) {
          endOffset = endNode.getIndex() + 1;
          endNode = endNode.getParent();
        }
        self.endContainer = endNode;
        self.endOffset = endOffset;
        if (!self.startContainer) {
          self.startContainer = endNode;
          self.startOffset = endOffset;
        }
        updateCollapsed(self);
      },
      setStartAfter : function(node) {
        this.setStart(node.getParent(), node.getIndex() + 1);
      },
      setStartBefore : function(node) {
        this.setStart(node.getParent(), node.getIndex());
      },
      setEndAfter : function(node) {
        this.setEnd(node.getParent(), node.getIndex() + 1);
      },
      setEndBefore : function(node) {
        this.setEnd(node.getParent(), node.getIndex());
      },
      setStartAt : function(node, expectedNumberOfNonCommentArgs) {
        var range = this;
        switch(expectedNumberOfNonCommentArgs) {
          case 1:
            range.setStart(node, 0);
            break;
          case 2:
            if (node.type == 3) {
              range.setStart(node, node.getLength());
            } else {
              range.setStart(node, node.getChildCount());
            }
            break;
          case 3:
            range.setStartBefore(node);
            break;
          case 4:
            range.setStartAfter(node);
        }
        updateCollapsed(range);
      },
      setEndAt : function(node, opt_attributes) {
        var range = this;
        switch(opt_attributes) {
          case 1:
            range.setEnd(node, 0);
            break;
          case 2:
            if (node.type == 3) {
              range.setEnd(node, node.getLength());
            } else {
              range.setEnd(node, node.getChildCount());
            }
            break;
          case 3:
            range.setEndBefore(node);
            break;
          case 4:
            range.setEndAfter(node);
        }
        updateCollapsed(range);
      },
      fixBlock : function(recurring, tr) {
        var range = this;
        var bookmark = range.createBookmark();
        var block = range.document.createElement(tr);
        range.collapse(recurring);
        range.enlarge(2);
        range.extractContents().appendTo(block);
        block.trim();
        if (!href) {
          block.appendBogus();
        }
        range.insertNode(block);
        range.moveToBookmark(bookmark);
        return block;
      },
      splitBlock : function(blockTag) {
        var self = this;
        var startPath = new dom.elementPath(self.startContainer);
        var endPath = new dom.elementPath(self.endContainer);
        var startBlockLimit = startPath.blockLimit;
        var rvar = endPath.blockLimit;
        var startBlock = startPath.block;
        var endBlock = endPath.block;
        var elementPath = null;
        if (!startBlockLimit.equals(rvar)) {
          return null;
        }
        if (blockTag != "br") {
          if (!startBlock) {
            startBlock = self.fixBlock(true, blockTag);
            endBlock = (new dom.elementPath(self.endContainer)).block;
          }
          if (!endBlock) {
            endBlock = self.fixBlock(false, blockTag);
          }
        }
        var isStartOfBlock = startBlock && self.checkStartOfBlock();
        var isEndOfBlock = endBlock && self.checkEndOfBlock();
        self.deleteContents();
        if (startBlock && startBlock.equals(endBlock)) {
          if (isEndOfBlock) {
            elementPath = new dom.elementPath(self.startContainer);
            self.moveToPosition(endBlock, 4);
            endBlock = null;
          } else {
            if (isStartOfBlock) {
              elementPath = new dom.elementPath(self.startContainer);
              self.moveToPosition(startBlock, 3);
              startBlock = null;
            } else {
              endBlock = self.splitElement(startBlock);
              if (!href && !startBlock.is("ul", "ol")) {
                startBlock.appendBogus();
              }
            }
          }
        }
        return{
          previousBlock : startBlock,
          nextBlock : endBlock,
          wasStartOfBlock : isStartOfBlock,
          wasEndOfBlock : isEndOfBlock,
          elementPath : elementPath
        };
      },
      splitElement : function(optgroup) {
        var self = this;
        if (!self.collapsed) {
          return null;
        }
        self.setEndAt(optgroup, 2);
        var container = self.extractContents();
        var clone = optgroup.clone(false);
        container.appendTo(clone);
        clone.insertAfter(optgroup);
        self.moveToPosition(optgroup, 4);
        return clone;
      },
      checkBoundaryOfElement : function(element, expectedNumberOfNonCommentArgs) {
        var checkStart = expectedNumberOfNonCommentArgs == 1;
        var walkerRange = this.clone();
        walkerRange.collapse(checkStart);
        walkerRange[checkStart ? "setStartAt" : "setEndAt"](element, checkStart ? 1 : 2);
        var walker = new dom.walker(walkerRange);
        walker.evaluator = guard(checkStart);
        return walker[checkStart ? "checkBackward" : "checkForward"]();
      },
      checkStartOfBlock : function() {
        var self = this;
        var startContainer = self.startContainer;
        var startOffset = self.startOffset;
        if (startOffset && startContainer.type == 3) {
          var codeSegments = $.ltrim(startContainer.substring(0, startOffset));
          if (codeSegments.length) {
            return false;
          }
        }
        var path = new dom.elementPath(self.startContainer);
        var walkerRange = self.clone();
        walkerRange.collapse(true);
        walkerRange.setStartAt(path.block || path.blockLimit, 1);
        var walker = new dom.walker(walkerRange);
        walker.evaluator = getCheckStartEndBlockEvalFunction(true);
        return walker.checkBackward();
      },
      checkEndOfBlock : function() {
        var self = this;
        var endContainer = self.endContainer;
        var endOffset = self.endOffset;
        if (endContainer.type == 3) {
          var codeSegments = $.rtrim(endContainer.substring(endOffset));
          if (codeSegments.length) {
            return false;
          }
        }
        var path = new dom.elementPath(self.endContainer);
        var walkerRng = self.clone();
        walkerRng.collapse(false);
        walkerRng.setEndAt(path.block || path.blockLimit, 2);
        var walker = new dom.walker(walkerRng);
        walker.evaluator = getCheckStartEndBlockEvalFunction(false);
        return walker.checkForward();
      },
      checkReadOnly : function() {
        function checkNodesEditable(node, name) {
          for (;node;) {
            if (node.type == 1) {
              if (node.getAttribute("contentEditable") == "false" && !node.data("cke-editable")) {
                return 0;
              } else {
                if (node.is("html") || node.getAttribute("contentEditable") == "true" && (node.contains(name) || node.equals(name))) {
                  break;
                }
              }
            }
            node = node.getParent();
          }
          return 1;
        }
        return function() {
          var startNode = this.startContainer;
          var endNode = this.endContainer;
          return!(checkNodesEditable(startNode, endNode) && checkNodesEditable(endNode, startNode));
        };
      }(),
      moveToElementEditablePosition : function(el, isMoveToEnd) {
        function nextDFS(node, childOnly) {
          var next;
          if (node.type == 1 && node.isEditable(false)) {
            next = node[isMoveToEnd ? "getLast" : "getFirst"](alpha);
          }
          if (!childOnly && !next) {
            next = node[isMoveToEnd ? "getPrevious" : "getNext"](alpha);
          }
          return next;
        }
        var rhtml = /^[\t\r\n ]*(?:&nbsp;|\xa0)$/;
        if (el.type == 1 && !el.isEditable(false)) {
          this.moveToPosition(el, isMoveToEnd ? 4 : 3);
          return true;
        }
        var found = 0;
        for (;el;) {
          if (el.type == 3) {
            if (isMoveToEnd && (this.checkEndOfBlock() && rhtml.test(el.getText()))) {
              this.moveToPosition(el, 3);
            } else {
              this.moveToPosition(el, isMoveToEnd ? 4 : 3);
            }
            found = 1;
            break;
          }
          if (el.type == 1) {
            if (el.isEditable()) {
              this.moveToPosition(el, isMoveToEnd ? 2 : 1);
              found = 1;
            } else {
              if (isMoveToEnd && (el.is("br") && this.checkEndOfBlock())) {
                this.moveToPosition(el, 3);
              }
            }
          }
          el = nextDFS(el, found);
        }
        return!!found;
      },
      moveToElementEditStart : function(target) {
        return this.moveToElementEditablePosition(target);
      },
      moveToElementEditEnd : function(target) {
        return this.moveToElementEditablePosition(target, true);
      },
      getEnclosedNode : function() {
        var walkerRange = this.clone();
        walkerRange.optimize();
        if (walkerRange.startContainer.type != 1 || walkerRange.endContainer.type != 1) {
          return null;
        }
        var walker = new dom.walker(walkerRange);
        var isNotBookmarks = dom.walker.bookmark(true);
        var isNotWhitespaces = dom.walker.whitespaces(true);
        var evaluator = function(node) {
          return isNotWhitespaces(node) && isNotBookmarks(node);
        };
        walkerRange.evaluator = evaluator;
        var parent = walker.next();
        walker.reset();
        return parent && parent.equals(walker.previous()) ? parent : null;
      },
      getTouchedStartNode : function() {
        var container = this.startContainer;
        if (this.collapsed || container.type != 1) {
          return container;
        }
        return container.getChild(this.startOffset) || container;
      },
      getTouchedEndNode : function() {
        var container = this.endContainer;
        if (this.collapsed || container.type != 1) {
          return container;
        }
        return container.getChild(this.endOffset - 1) || container;
      }
    };
  })();
  self.POSITION_AFTER_START = 1;
  self.POSITION_BEFORE_END = 2;
  self.POSITION_BEFORE_START = 3;
  self.POSITION_AFTER_END = 4;
  self.ENLARGE_ELEMENT = 1;
  self.ENLARGE_BLOCK_CONTENTS = 2;
  self.ENLARGE_LIST_ITEM_CONTENTS = 3;
  self.START = 1;
  self.END = 2;
  self.STARTEND = 3;
  self.SHRINK_ELEMENT = 1;
  self.SHRINK_TEXT = 2;
  (function() {
    function updateDirtyRange(bookmark, dirtyRange, checkEnd) {
      var serializable = bookmark.serializable;
      var container = dirtyRange[checkEnd ? "endContainer" : "startContainer"];
      var offset = checkEnd ? "endOffset" : "startOffset";
      var bookmarkStart = serializable ? dirtyRange.document.getById(bookmark.startNode) : bookmark.startNode;
      var bookmarkEnd = serializable ? dirtyRange.document.getById(bookmark.endNode) : bookmark.endNode;
      if (container.equals(bookmarkStart.getPrevious())) {
        dirtyRange.startOffset = dirtyRange.startOffset - container.getLength() - bookmarkEnd.getPrevious().getLength();
        container = bookmarkEnd.getNext();
      } else {
        if (container.equals(bookmarkEnd.getPrevious())) {
          dirtyRange.startOffset = dirtyRange.startOffset - container.getLength();
          container = bookmarkEnd.getNext();
        }
      }
      if (container.equals(bookmarkStart.getParent())) {
        dirtyRange[offset]++;
      }
      if (container.equals(bookmarkEnd.getParent())) {
        dirtyRange[offset]++;
      }
      dirtyRange[checkEnd ? "endContainer" : "startContainer"] = container;
      return dirtyRange;
    }
    dom.rangeList = function(ranges) {
      if (ranges instanceof dom.rangeList) {
        return ranges;
      }
      if (!ranges) {
        ranges = [];
      } else {
        if (ranges instanceof dom.range) {
          ranges = [ranges];
        }
      }
      return $.extend(ranges, mixins);
    };
    var mixins = {
      createIterator : function() {
        var rangeList = this;
        var bookmark = dom.walker.bookmark();
        var guard = function(node) {
          return!(node.is && node.is("tr"));
        };
        var bookmarks = [];
        var current;
        return{
          getNextRange : function(dataAndEvents) {
            current = current == undefined ? 0 : current + 1;
            var range = rangeList[current];
            if (range && rangeList.length > 1) {
              if (!current) {
                var i = rangeList.length - 1;
                for (;i >= 0;i--) {
                  bookmarks.unshift(rangeList[i].createBookmark(true));
                }
              }
              if (dataAndEvents) {
                var mergeCount = 0;
                for (;rangeList[current + mergeCount + 1];) {
                  var doc = range.document;
                  var x = 0;
                  var left = doc.getById(bookmarks[mergeCount].endNode);
                  var pattern = doc.getById(bookmarks[mergeCount + 1].startNode);
                  var next;
                  for (;1;) {
                    next = left.getNextSourceNode(false);
                    if (!pattern.equals(next)) {
                      if (bookmark(next) || next.type == 1 && next.isBlockBoundary()) {
                        left = next;
                        continue;
                      }
                    } else {
                      x = 1;
                    }
                    break;
                  }
                  if (!x) {
                    break;
                  }
                  mergeCount++;
                }
              }
              range.moveToBookmark(bookmarks.shift());
              for (;mergeCount--;) {
                next = rangeList[++current];
                next.moveToBookmark(bookmarks.shift());
                range.setEnd(next.endContainer, next.endOffset);
              }
            }
            return range;
          }
        };
      },
      createBookmarks : function(dataAndEvents) {
        var codeSegments = this;
        var retval = [];
        var bookmark;
        var i = 0;
        for (;i < codeSegments.length;i++) {
          retval.push(bookmark = codeSegments[i].createBookmark(dataAndEvents, true));
          var j = i + 1;
          for (;j < codeSegments.length;j++) {
            codeSegments[j] = updateDirtyRange(bookmark, codeSegments[j]);
            codeSegments[j] = updateDirtyRange(bookmark, codeSegments[j], true);
          }
        }
        return retval;
      },
      createBookmarks2 : function(normalized) {
        var bookmarks = [];
        var i = 0;
        for (;i < this.length;i++) {
          bookmarks.push(this[i].createBookmark2(normalized));
        }
        return bookmarks;
      },
      moveToBookmarks : function(bookmarks) {
        var i = 0;
        for (;i < this.length;i++) {
          this[i].moveToBookmark(bookmarks[i]);
        }
      }
    };
  })();
  (function() {
    if (env.webkit) {
      env.hc = false;
      return;
    }
    var hcDetect = Node.createFromHtml('<div style="width:0px;height:0px;position:absolute;left:-10000px;border: 1px solid;border-color: red blue;"></div>', self.document);
    hcDetect.appendTo(self.document.getHead());
    try {
      env.hc = hcDetect.getComputedStyle("border-top-color") == hcDetect.getComputedStyle("border-right-color");
    } catch (m) {
      env.hc = false;
    }
    if (env.hc) {
      env.cssClass += " cke_hc";
    }
    hcDetect.remove();
  })();
  editor.load(config.corePlugins.split(","), function() {
    self.status = "loaded";
    self.fire("loaded");
    var codeSegments = self._.pending;
    if (codeSegments) {
      delete self._.pending;
      var i = 0;
      for (;i < codeSegments.length;i++) {
        self.add(codeSegments[i]);
      }
    }
  });
  if (href) {
    try {
      document.execCommand("BackgroundImageCache", false, true);
    } catch (l) {
    }
  }
  self.skins.add("kama", function() {
    var id = "cke_ui_color";
    return{
      editor : {
        css : ["editor.css"]
      },
      dialog : {
        css : ["dialog.css"]
      },
      richcombo : {
        canGroup : false
      },
      templates : {
        css : ["templates.css"]
      },
      margins : [0, 0, 0, 0],
      init : function(editor) {
        function getStylesheet(iframe) {
          var node = iframe.getById(id);
          if (!node) {
            node = iframe.getHead().append("style");
            node.setAttribute("id", id);
            node.setAttribute("type", "text/css");
          }
          return node;
        }
        function updateStylesheets(styleNodes, styleContent, replace) {
          var r;
          var i;
          var content;
          var id = 0;
          for (;id < styleNodes.length;id++) {
            if (env.webkit) {
              i = 0;
              for (;i < styleContent.length;i++) {
                content = styleContent[i][1];
                r = 0;
                for (;r < replace.length;r++) {
                  content = content.replace(replace[r][0], replace[r][1]);
                }
                styleNodes[id].$.sheet.addRule(styleContent[i][0], content);
              }
            } else {
              content = styleContent;
              r = 0;
              for (;r < replace.length;r++) {
                content = content.replace(replace[r][0], replace[r][1]);
              }
              if (href) {
                styleNodes[id].$.styleSheet.cssText += content;
              } else {
                styleNodes[id].$.innerHTML += content;
              }
            }
          }
        }
        if (editor.config.width && !isNaN(editor.config.width)) {
          editor.config.width -= 12;
        }
        var uiColorMenus = [];
        var r20 = /\$color/g;
        var uiColorMenuCss = "/* UI Color Support */.cke_skin_kama .cke_menuitem .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a:focus .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a:active .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover .cke_label,.cke_skin_kama .cke_menuitem a:focus .cke_label,.cke_skin_kama .cke_menuitem a:active .cke_label{\tbackground-color: $color !important;}.cke_skin_kama .cke_menuitem a.cke_disabled:hover .cke_label,.cke_skin_kama .cke_menuitem a.cke_disabled:focus .cke_label,.cke_skin_kama .cke_menuitem a.cke_disabled:active .cke_label{\tbackground-color: transparent !important;}.cke_skin_kama .cke_menuitem a.cke_disabled:hover .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a.cke_disabled:focus .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a.cke_disabled:active .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a.cke_disabled .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuseparator{\tbackground-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover,.cke_skin_kama .cke_menuitem a:focus,.cke_skin_kama .cke_menuitem a:active{\tbackground-color: $color !important;}";
        if (env.webkit) {
          uiColorMenuCss = uiColorMenuCss.split("}").slice(0, -1);
          var i = 0;
          for (;i < uiColorMenuCss.length;i++) {
            uiColorMenuCss[i] = uiColorMenuCss[i].split("{");
          }
        }
        var rreturn = /\$color/g;
        $.extend(editor, {
          uiColor : null,
          getUiColor : function() {
            return this.uiColor;
          },
          setUiColor : function(color) {
            var cssContent;
            var uiStyle = getStylesheet(self.document);
            var y = "." + editor.id;
            var type = [y + " .cke_wrapper", y + "_dialog .cke_dialog_contents", y + "_dialog a.cke_dialog_tab", y + "_dialog .cke_dialog_footer"].join(",");
            var pageX = "background-color: $color !important;";
            if (env.webkit) {
              cssContent = [[type, pageX]];
            } else {
              cssContent = type + "{" + pageX + "}";
            }
            return(this.setUiColor = function(color) {
              var replace = [[rreturn, color]];
              editor.uiColor = color;
              updateStylesheets([uiStyle], cssContent, replace);
              updateStylesheets(uiColorMenus, uiColorMenuCss, replace);
            })(color);
          }
        });
        editor.on("menuShow", function(messageEvent) {
          var panel = messageEvent.data[0];
          var iframe = panel.element.getElementsByTag("iframe").getItem(0).getFrameDocument();
          if (!iframe.getById("cke_ui_color")) {
            var node = getStylesheet(iframe);
            uiColorMenus.push(node);
            var z = editor.getUiColor();
            if (z) {
              updateStylesheets([node], uiColorMenuCss, [[rreturn, z]]);
            }
          }
        });
        if (editor.config.uiColor) {
          editor.setUiColor(editor.config.uiColor);
        }
      }
    };
  }());
  (function() {
    function dialogSetup() {
      self.dialog.on("resize", function(browserEvent) {
        var data = browserEvent.data;
        var width = data.width;
        var height = data.height;
        var dialog = data.dialog;
        var contents = dialog.parts.contents;
        if (data.skin != "kama") {
          return;
        }
        contents.setStyles({
          width : width + "px",
          height : height + "px"
        });
      });
    }
    if (self.dialog) {
      dialogSetup();
    } else {
      self.on("dialogPluginReady", dialogSetup);
    }
  })();
  editor.add("about", {
    requires : ["dialog"],
    init : function(editor) {
      var command = editor.addCommand("about", new self.dialogCommand("about"));
      command.modes = {
        wysiwyg : 1,
        source : 1
      };
      command.canUndo = false;
      command.readOnly = 1;
      editor.ui.addButton("About", {
        label : editor.lang.about.title,
        command : "about"
      });
      self.dialog.add("about", this.path + "dialogs/about.js");
    }
  });
  (function() {
    var rvar = "a11yhelp";
    var optgroup = "a11yHelp";
    editor.add(rvar, {
      requires : ["dialog"],
      availableLangs : {
        cs : 1,
        cy : 1,
        da : 1,
        de : 1,
        el : 1,
        en : 1,
        eo : 1,
        fa : 1,
        fi : 1,
        fr : 1,
        gu : 1,
        he : 1,
        it : 1,
        mk : 1,
        nb : 1,
        nl : 1,
        no : 1,
        "pt-br" : 1,
        ro : 1,
        tr : 1,
        ug : 1,
        vi : 1,
        "zh-cn" : 1
      },
      init : function(editor) {
        var plugin = this;
        editor.addCommand(optgroup, {
          exec : function() {
            var langCode = editor.langCode;
            langCode = plugin.availableLangs[langCode] ? langCode : "en";
            self.scriptLoader.load(self.getUrl(plugin.path + "lang/" + langCode + ".js"), function() {
              $.extend(editor.lang, plugin.langEntries[langCode]);
              editor.openDialog(optgroup);
            });
          },
          modes : {
            wysiwyg : 1,
            source : 1
          },
          readOnly : 1,
          canUndo : false
        });
        self.dialog.add(optgroup, this.path + "dialogs/a11yhelp.js");
      }
    });
  })();
  editor.add("basicstyles", {
    requires : ["styles", "button"],
    init : function(editor) {
      var addButtonCommand = function(buttonName, buttonLabel, commandName, styleDefiniton) {
        var style = new self.style(styleDefiniton);
        editor.attachStyleStateChange(style, function(doc) {
          if (!editor.readOnly) {
            editor.getCommand(commandName).setState(doc);
          }
        });
        editor.addCommand(commandName, new self.styleCommand(style));
        editor.ui.addButton(buttonName, {
          label : buttonLabel,
          command : commandName
        });
      };
      var config = editor.config;
      var lang = editor.lang;
      addButtonCommand("Bold", lang.bold, "bold", config.coreStyles_bold);
      addButtonCommand("Italic", lang.italic, "italic", config.coreStyles_italic);
      addButtonCommand("Underline", lang.underline, "underline", config.coreStyles_underline);
      addButtonCommand("Strike", lang.strike, "strike", config.coreStyles_strike);
      addButtonCommand("Subscript", lang.subscript, "subscript", config.coreStyles_subscript);
      addButtonCommand("Superscript", lang.superscript, "superscript", config.coreStyles_superscript);
    }
  });
  config.coreStyles_bold = {
    element : "strong",
    overrides : "b"
  };
  config.coreStyles_italic = {
    element : "em",
    overrides : "i"
  };
  config.coreStyles_underline = {
    element : "u"
  };
  config.coreStyles_strike = {
    element : "strike"
  };
  config.coreStyles_subscript = {
    element : "sub"
  };
  config.coreStyles_superscript = {
    element : "sup"
  };
  (function() {
    function refresh(e) {
      setToolbarStates(e);
      handleMixedDirContent(e);
    }
    function setToolbarStates(evt) {
      var editor = evt.editor;
      var path = evt.data.path;
      if (editor.readOnly) {
        return;
      }
      var useComputedState = editor.config.useComputedState;
      var selectedElement;
      useComputedState = useComputedState === undefined || useComputedState;
      if (!useComputedState) {
        selectedElement = getElementForDirection(path.lastElement);
      }
      selectedElement = selectedElement || (path.block || path.blockLimit);
      if (selectedElement.is("body")) {
        var element = editor.getSelection().getRanges()[0].getEnclosedNode();
        if (element) {
          if (element.type == 1) {
            selectedElement = element;
          }
        }
      }
      if (!selectedElement) {
        return;
      }
      var selectionDir = useComputedState ? selectedElement.getComputedStyle("direction") : selectedElement.getStyle("direction") || selectedElement.getAttribute("dir");
      editor.getCommand("bidirtl").setState(selectionDir == "rtl" ? 1 : 2);
      editor.getCommand("bidiltr").setState(selectionDir == "ltr" ? 1 : 2);
    }
    function handleMixedDirContent(evt) {
      var editor = evt.editor;
      var directionNode = evt.data.path.block || evt.data.path.blockLimit;
      editor.fire("contentDirChanged", directionNode ? directionNode.getComputedStyle("direction") : editor.lang.dir);
    }
    function getElementForDirection(node) {
      for (;node && !(node.getName() in deep || node.is("body"));) {
        var fragment = node.getParent();
        if (!fragment) {
          break;
        }
        node = fragment;
      }
      return node;
    }
    function switchDir(element, dir, editor, database) {
      if (element.isReadOnly()) {
        return;
      }
      Node.setMarker(database, element, "bidi_processed", 1);
      var parent = element;
      for (;(parent = parent.getParent()) && !parent.is("body");) {
        if (parent.getCustomData("bidi_processed")) {
          element.removeStyle("direction");
          element.removeAttribute("dir");
          return;
        }
      }
      var useComputedState = "useComputedState" in editor.config ? editor.config.useComputedState : 1;
      var elementDir = useComputedState ? element.getComputedStyle("direction") : element.getStyle("direction") || element.hasAttribute("dir");
      if (elementDir == dir) {
        return;
      }
      element.removeStyle("direction");
      if (useComputedState) {
        element.removeAttribute("dir");
        if (dir != element.getComputedStyle("direction")) {
          element.setAttribute("dir", dir);
        }
      } else {
        element.setAttribute("dir", dir);
      }
      editor.forceNextSelectionCheck();
    }
    function getFullySelected(range, elements, enterMode) {
      var ancestor = range.getCommonAncestor(false, true);
      range = range.clone();
      range.enlarge(enterMode == 2 ? 3 : 2);
      if (range.checkBoundaryOfElement(ancestor, 1) && range.checkBoundaryOfElement(ancestor, 2)) {
        var parent;
        for (;ancestor && (ancestor.type == 1 && ((parent = ancestor.getParent()) && (parent.getChildCount() == 1 && !(ancestor.getName() in elements))));) {
          ancestor = parent;
        }
        return ancestor.type == 1 && (ancestor.getName() in elements && ancestor);
      }
    }
    function bidiCommand(dir) {
      return function(editor) {
        var selection = editor.getSelection();
        var enterMode = editor.config.enterMode;
        var ranges = selection.getRanges();
        if (ranges && ranges.length) {
          var database = {};
          var bookmarks = selection.createBookmarks();
          var rangeIterator = ranges.createIterator();
          var range;
          var i = 0;
          for (;range = rangeIterator.getNextRange(1);) {
            var selectedElement = range.getEnclosedNode();
            if (!selectedElement || selectedElement && !(selectedElement.type == 1 && selectedElement.getName() in attributes)) {
              selectedElement = getFullySelected(range, guardElements, enterMode);
            }
            if (selectedElement) {
              switchDir(selectedElement, dir, editor, database);
            }
            var iterator;
            var activeClassName;
            var walker = new dom.walker(range);
            var start = bookmarks[i].startNode;
            var end = bookmarks[i++].endNode;
            walker.evaluator = function(node) {
              return!!(node.type == 1 && (node.getName() in guardElements && (!(node.getName() == (enterMode == 1 ? "p" : "div") && (node.getParent().type == 1 && node.getParent().getName() == "blockquote")) && (node.getPosition(start) & 2 && (node.getPosition(end) & 4 + 16) == 4))));
            };
            for (;activeClassName = walker.next();) {
              switchDir(activeClassName, dir, editor, database);
            }
            iterator = range.createIterator();
            iterator.enlargeBr = enterMode != 2;
            for (;activeClassName = iterator.getNextParagraph(enterMode == 1 ? "p" : "div");) {
              switchDir(activeClassName, dir, editor, database);
            }
          }
          Node.clearAllMarkers(database);
          editor.forceNextSelectionCheck();
          selection.selectBookmarks(bookmarks);
          editor.focus();
        }
      };
    }
    function isOffline(el) {
      var match = el.getDocument().getBody().getParent();
      for (;el;) {
        if (el.equals(match)) {
          return false;
        }
        el = el.getParent();
      }
      return true;
    }
    function dirChangeNotifier(org) {
      var isAttribute = org == elementProto.setAttribute;
      var isRemoveAttribute = org == elementProto.removeAttribute;
      var isSimple = /\bdirection\s*:\s*(.*?)\s*(:?$|;)/;
      return function(name, qualifier) {
        var block = this;
        if (!block.getDocument().equals(self.document)) {
          var H;
          if ((name == (isAttribute || isRemoveAttribute ? "dir" : "direction") || name == "style" && (isRemoveAttribute || isSimple.test(qualifier))) && !isOffline(block)) {
            H = block.getDirection(1);
            var ret = org.apply(block, arguments);
            if (H != block.getDirection(1)) {
              block.getDocument().fire("dirChanged", block);
              return ret;
            }
          }
        }
        return org.apply(block, arguments);
      };
    }
    var guardElements = {
      table : 1,
      ul : 1,
      ol : 1,
      blockquote : 1,
      div : 1
    };
    var attributes = {};
    var deep = {};
    $.extend(attributes, guardElements, {
      tr : 1,
      p : 1,
      div : 1,
      li : 1
    });
    $.extend(deep, attributes, {
      td : 1
    });
    editor.add("bidi", {
      requires : ["styles", "button"],
      init : function(editor) {
        var addButtonCommand = function(buttonName, buttonLabel, commandName, commandExec) {
          editor.addCommand(commandName, new self.command(editor, {
            exec : commandExec
          }));
          editor.ui.addButton(buttonName, {
            label : buttonLabel,
            command : commandName
          });
        };
        var lang = editor.lang.bidi;
        addButtonCommand("BidiLtr", lang.ltr, "bidiltr", bidiCommand("ltr"));
        addButtonCommand("BidiRtl", lang.rtl, "bidirtl", bidiCommand("rtl"));
        editor.on("selectionChange", refresh);
        editor.on("contentDom", function() {
          editor.document.on("dirChanged", function(evt) {
            editor.fire("dirChanged", {
              node : evt.data,
              dir : evt.data.getDirection(1)
            });
          });
        });
      }
    });
    var elementProto = Node.prototype;
    var methods = ["setStyle", "removeStyle", "setAttribute", "removeAttribute"];
    var i = 0;
    for (;i < methods.length;i++) {
      elementProto[methods[i]] = $.override(elementProto[methods[i]], dirChangeNotifier);
    }
  })();
  (function() {
    function getState(editor, path) {
      var firstBlock = path.block || path.blockLimit;
      if (!firstBlock || firstBlock.getName() == "body") {
        return 2;
      }
      if (firstBlock.getAscendant("blockquote", true)) {
        return 1;
      }
      return 2;
    }
    function onSelectionChange(evt) {
      var editor = evt.editor;
      if (editor.readOnly) {
        return;
      }
      var command = editor.getCommand("blockquote");
      command.state = getState(editor, evt.data.path);
      command.fire("state");
    }
    function noBlockLeft(bqBlock) {
      var i = 0;
      var length = bqBlock.getChildCount();
      var child;
      for (;i < length && (child = bqBlock.getChild(i));i++) {
        if (child.type == 1 && child.isBlockBoundary()) {
          return false;
        }
      }
      return true;
    }
    var commandObject = {
      exec : function(editor) {
        var state = editor.getCommand("blockquote").state;
        var selection = editor.getSelection();
        var range = selection && selection.getRanges(true)[0];
        if (!range) {
          return;
        }
        var bookmarks = selection.createBookmarks();
        if (href) {
          var bookmarkStart = bookmarks[0].startNode;
          var bookmarkEnd = bookmarks[0].endNode;
          var cursor;
          if (bookmarkStart && bookmarkStart.getParent().getName() == "blockquote") {
            cursor = bookmarkStart;
            for (;cursor = cursor.getNext();) {
              if (cursor.type == 1 && cursor.isBlockBoundary()) {
                bookmarkStart.move(cursor, true);
                break;
              }
            }
          }
          if (bookmarkEnd && bookmarkEnd.getParent().getName() == "blockquote") {
            cursor = bookmarkEnd;
            for (;cursor = cursor.getPrevious();) {
              if (cursor.type == 1 && cursor.isBlockBoundary()) {
                bookmarkEnd.move(cursor);
                break;
              }
            }
          }
        }
        var iterator = range.createIterator();
        var vvar;
        iterator.enlargeBr = editor.config.enterMode != 2;
        if (state == 2) {
          var children = [];
          for (;vvar = iterator.getNextParagraph();) {
            children.push(vvar);
          }
          if (children.length < 1) {
            var node = editor.document.createElement(editor.config.enterMode == 1 ? "p" : "div");
            var firstBookmark = bookmarks.shift();
            range.insertNode(node);
            node.append(new dom.text("\ufeff", editor.document));
            range.moveToBookmark(firstBookmark);
            range.selectNodeContents(node);
            range.collapse(true);
            firstBookmark = range.createBookmark();
            children.push(node);
            bookmarks.unshift(firstBookmark);
          }
          var field = children[0].getParent();
          var ql = [];
          var i = 0;
          for (;i < children.length;i++) {
            vvar = children[i];
            field = field.getCommonAncestor(vvar.getParent());
          }
          var denyTags = {
            table : 1,
            tbody : 1,
            tr : 1,
            ol : 1,
            ul : 1
          };
          for (;denyTags[field.getName()];) {
            field = field.getParent();
          }
          var modId = null;
          for (;children.length > 0;) {
            vvar = children.shift();
            for (;!vvar.getParent().equals(field);) {
              vvar = vvar.getParent();
            }
            if (!vvar.equals(modId)) {
              ql.push(vvar);
            }
            modId = vvar;
          }
          for (;ql.length > 0;) {
            vvar = ql.shift();
            if (vvar.getName() == "blockquote") {
              var p = new dom.documentFragment(editor.document);
              for (;vvar.getFirst();) {
                p.append(vvar.getFirst().remove());
                children.push(p.getLast());
              }
              p.replace(vvar);
            } else {
              children.push(vvar);
            }
          }
          var optgroup = editor.document.createElement("blockquote");
          optgroup.insertBefore(children[0]);
          for (;children.length > 0;) {
            vvar = children.shift();
            optgroup.append(vvar);
          }
        } else {
          if (state == 1) {
            var movedNodes = [];
            var database = {};
            for (;vvar = iterator.getNextParagraph();) {
              var webkit = null;
              var element = null;
              for (;vvar.getParent();) {
                if (vvar.getParent().getName() == "blockquote") {
                  webkit = vvar.getParent();
                  element = vvar;
                  break;
                }
                vvar = vvar.getParent();
              }
              if (webkit && (element && !element.getCustomData("blockquote_moveout"))) {
                movedNodes.push(element);
                Node.setMarker(database, element, "blockquote_moveout", true);
              }
            }
            Node.clearAllMarkers(database);
            var qr = [];
            var groups_order = [];
            database = {};
            for (;movedNodes.length > 0;) {
              var rvar = movedNodes.shift();
              optgroup = rvar.getParent();
              if (!rvar.getPrevious()) {
                rvar.remove().insertBefore(optgroup);
              } else {
                if (!rvar.getNext()) {
                  rvar.remove().insertAfter(optgroup);
                } else {
                  rvar.breakParent(rvar.getParent());
                  groups_order.push(rvar.getNext());
                }
              }
              if (!optgroup.getCustomData("blockquote_processed")) {
                groups_order.push(optgroup);
                Node.setMarker(database, optgroup, "blockquote_processed", true);
              }
              qr.push(rvar);
            }
            Node.clearAllMarkers(database);
            i = groups_order.length - 1;
            for (;i >= 0;i--) {
              optgroup = groups_order[i];
              if (noBlockLeft(optgroup)) {
                optgroup.remove();
              }
            }
            if (editor.config.enterMode == 2) {
              var value = true;
              for (;qr.length;) {
                rvar = qr.shift();
                if (rvar.getName() == "div") {
                  p = new dom.documentFragment(editor.document);
                  var attrNames = value && (rvar.getPrevious() && !(rvar.getPrevious().type == 1 && rvar.getPrevious().isBlockBoundary()));
                  if (attrNames) {
                    p.append(editor.document.createElement("br"));
                  }
                  var T = rvar.getNext() && !(rvar.getNext().type == 1 && rvar.getNext().isBlockBoundary());
                  for (;rvar.getFirst();) {
                    rvar.getFirst().remove().appendTo(p);
                  }
                  if (T) {
                    p.append(editor.document.createElement("br"));
                  }
                  p.replace(rvar);
                  value = false;
                }
              }
            }
          }
        }
        selection.selectBookmarks(bookmarks);
        editor.focus();
      }
    };
    editor.add("blockquote", {
      init : function(editor) {
        editor.addCommand("blockquote", commandObject);
        editor.ui.addButton("Blockquote", {
          label : editor.lang.blockquote,
          command : "blockquote"
        });
        editor.on("selectionChange", onSelectionChange);
      },
      requires : ["domiterator"]
    });
  })();
  editor.add("button", {
    beforeInit : function(editor) {
      editor.ui.addHandler("button", options.button.handler);
    }
  });
  self.UI_BUTTON = "button";
  options.button = function(name) {
    $.extend(this, name, {
      title : name.label,
      className : name.className || (name.command && "cke_button_" + name.command || ""),
      click : name.click || function(editor) {
        editor.execCommand(name.command);
      }
    });
    this._ = {};
  };
  options.button.handler = {
    create : function(definition) {
      return new options.button(definition);
    }
  };
  (function() {
    options.button.prototype = {
      render : function(editor, output) {
        var ua = env;
        var id = this._.id = $.getNextId();
        var classes = "";
        var command = this.command;
        var clickFn;
        this._.editor = editor;
        var instance = {
          id : id,
          button : this,
          editor : editor,
          focus : function() {
            var targetNode = self.document.getById(id);
            targetNode.focus();
          },
          execute : function() {
            if (href && env.version < 7) {
              $.setTimeout(function() {
                this.button.click(editor);
              }, 0, this);
            } else {
              this.button.click(editor);
            }
          }
        };
        var extra = $.addFunction(function(ev) {
          if (instance.onkey) {
            ev = new dom.event(ev);
            return instance.onkey(instance, ev.getKeystroke()) !== false;
          }
        });
        var focusFn = $.addFunction(function(ev) {
          var retVal;
          if (instance.onfocus) {
            retVal = instance.onfocus(instance, new dom.event(ev)) !== false;
          }
          if (env.gecko && env.version < 10900) {
            ev.preventBubble();
          }
          return retVal;
        });
        instance.clickFn = clickFn = $.addFunction(instance.execute, instance);
        if (this.modes) {
          var modeStates = {};
          var updateState = function() {
            var mode = editor.mode;
            if (mode) {
              var state = this.modes[mode] ? modeStates[mode] != undefined ? modeStates[mode] : 2 : 0;
              this.setState(editor.readOnly && !this.readOnly ? 0 : state);
            }
          };
          editor.on("beforeModeUnload", function() {
            if (editor.mode && this._.state != 0) {
              modeStates[editor.mode] = this._.state;
            }
          }, this);
          editor.on("mode", updateState, this);
          if (!this.readOnly) {
            editor.on("readOnly", updateState, this);
          }
        } else {
          if (command) {
            command = editor.getCommand(command);
            if (command) {
              command.on("state", function() {
                this.setState(command.state);
              }, this);
              classes += "cke_" + (command.state == 1 ? "on" : command.state == 0 ? "disabled" : "off");
            }
          }
        }
        if (!command) {
          classes += "cke_off";
        }
        if (this.className) {
          classes += " " + this.className;
        }
        output.push('<span class="cke_button' + (this.icon && this.icon.indexOf(".png") == -1 ? " cke_noalphafix" : "") + '">', '<a id="', id, '" class="', classes, '"', ua.gecko && (ua.version >= 10900 && !ua.hc) ? "" : '" href="javascript:void(\'' + (this.title || "").replace("'", "") + "')\"", ' title="', this.title, '" tabindex="-1" hidefocus="true" role="button" aria-labelledby="' + id + '_label"' + (this.hasArrow ? ' aria-haspopup="true"' : ""));
        if (ua.opera || ua.gecko && ua.mac) {
          output.push(' onkeypress="return false;"');
        }
        if (ua.gecko) {
          output.push(' onblur="this.style.cssText = this.style.cssText;"');
        }
        output.push(' onkeydown="return CKEDITOR.tools.callFunction(', extra, ', event);" onfocus="return CKEDITOR.tools.callFunction(', focusFn, ', event);" ' + (href ? 'onclick="return false;" onmouseup' : "onclick") + '="CKEDITOR.tools.callFunction(', clickFn, ', this); return false;"><span class="cke_icon"');
        if (this.icon) {
          var y = (this.iconOffset || 0) * -16;
          output.push(' style="background-image:url(', self.getUrl(this.icon), ");background-position:0 " + y + 'px;"');
        }
        output.push('>&nbsp;</span><span id="', id, '_label" class="cke_label">', this.label, "</span>");
        if (this.hasArrow) {
          output.push('<span class="cke_buttonarrow">' + (env.hc ? "&#9660;" : "&nbsp;") + "</span>");
        }
        output.push("</a>", "</span>");
        if (this.onRender) {
          this.onRender();
        }
        return instance;
      },
      setState : function(state) {
        if (this._.state == state) {
          return false;
        }
        this._.state = state;
        var element = self.document.getById(this._.id);
        if (element) {
          element.setState(state);
          if (state == 0) {
            element.setAttribute("aria-disabled", true);
          } else {
            element.removeAttribute("aria-disabled");
          }
          if (state == 1) {
            element.setAttribute("aria-pressed", true);
          } else {
            element.removeAttribute("aria-pressed");
          }
          return true;
        } else {
          return false;
        }
      }
    };
  })();
  options.prototype.addButton = function(name, opt_attributes) {
    this.add(name, "button", opt_attributes);
  };
  (function() {
    function cancel(val) {
      val.cancel();
    }
    function getClipboardData(evt, mode, callback) {
      var doc = this.document;
      if (doc.getById("cke_pastebin")) {
        return;
      }
      if (mode == "text" && (evt.data && evt.data.$.clipboardData)) {
        var plain = evt.data.$.clipboardData.getData("text/plain");
        if (plain) {
          evt.data.preventDefault();
          callback(plain);
          return;
        }
      }
      var selection = this.getSelection();
      var range = new dom.range(doc);
      var pastebin = new Node(mode == "text" ? "textarea" : env.webkit ? "body" : "div", doc);
      pastebin.setAttribute("id", "cke_pastebin");
      if (env.webkit) {
        pastebin.append(doc.createText("\u00a0"));
      }
      doc.getBody().append(pastebin);
      pastebin.setStyles({
        position : "absolute",
        top : selection.getStartElement().getDocumentPosition().y + "px",
        width : "1px",
        height : "1px",
        overflow : "hidden"
      });
      pastebin.setStyle(this.config.contentsLangDirection == "ltr" ? "left" : "right", "-1000px");
      var bookmarks = selection.createBookmarks();
      this.on("selectionChange", cancel, null, null, 0);
      if (mode == "text") {
        pastebin.$.focus();
      } else {
        range.setStartAt(pastebin, 1);
        range.setEndAt(pastebin, 2);
        range.select(true);
      }
      var editor = this;
      window.setTimeout(function() {
        editor.document.getBody().focus();
        editor.removeListener("selectionChange", cancel);
        if (env.ie7Compat) {
          selection.selectBookmarks(bookmarks);
          pastebin.remove();
        } else {
          pastebin.remove();
          selection.selectBookmarks(bookmarks);
        }
        var bogusSpan;
        pastebin = env.webkit && ((bogusSpan = pastebin.getFirst()) && (bogusSpan.is && bogusSpan.hasClass("Apple-style-span"))) ? bogusSpan : pastebin;
        callback(pastebin["get" + (mode == "text" ? "Value" : "Html")]());
      }, 0);
    }
    function fixCut(editor) {
      if (!href || env.quirks) {
        return;
      }
      var sel = editor.getSelection();
      var optgroup;
      if (sel.getType() == 3 && (optgroup = sel.getSelectedElement())) {
        var range = sel.getRanges()[0];
        var dummy = editor.document.createText("");
        dummy.insertBefore(optgroup);
        range.setStartBefore(dummy);
        range.setEndAfter(optgroup);
        sel.selectRanges([range]);
        setTimeout(function() {
          if (optgroup.getParent()) {
            dummy.remove();
            sel.selectElement(optgroup);
          }
        }, 0);
      }
    }
    function stateFromNamedCommand(command, editor) {
      var entry;
      if (inReadOnly && command in {
        Paste : 1,
        Cut : 1
      }) {
        return 0;
      }
      if (command == "Paste") {
        if (href) {
          u = 1;
        }
        try {
          entry = editor.document.$.queryCommandEnabled(command) || env.webkit;
        } catch (D) {
        }
        u = 0;
      } else {
        var selection = editor.getSelection();
        var ranges = selection && selection.getRanges();
        entry = selection && !(ranges.length == 1 && ranges[0].collapsed);
      }
      return entry ? 2 : 0;
    }
    function setToolbarStates() {
      var editor = this;
      if (editor.mode != "wysiwyg") {
        return;
      }
      var value = stateFromNamedCommand("Paste", editor);
      editor.getCommand("cut").setState(stateFromNamedCommand("Cut", editor));
      editor.getCommand("copy").setState(stateFromNamedCommand("Copy", editor));
      editor.getCommand("paste").setState(value);
      editor.fire("pasteState", value);
    }
    var execIECommand = function(editor, name) {
      var doc = editor.document;
      var emitter = doc.getBody();
      var enabled = false;
      var functionA = function() {
        enabled = true;
      };
      emitter.on(name, functionA);
      (env.version > 7 ? doc.$ : doc.$.selection.createRange()).execCommand(name);
      emitter.removeListener(name, functionA);
      return enabled;
    };
    var handleCursorMove = href ? function(editor, optgroup) {
      return execIECommand(editor, optgroup);
    } : function(editor, command) {
      try {
        return editor.document.$.execCommand(command, false, null);
      } catch (A) {
        return false;
      }
    };
    var cutCopyCmd = function(type) {
      var command = this;
      command.type = type;
      command.canUndo = command.type == "cut";
      command.startDisabled = true;
    };
    cutCopyCmd.prototype = {
      exec : function(editor, jumpToNext) {
        if (this.type == "cut") {
          fixCut(editor);
        }
        var success = handleCursorMove(editor, this.type);
        if (!success) {
          alert(editor.lang.clipboard[this.type + "Error"]);
        }
        return success;
      }
    };
    var pasteCmd = {
      canUndo : false,
      exec : href ? function(editor) {
        editor.focus();
        if (!editor.document.getBody().fire("beforepaste") && !execIECommand(editor, "paste")) {
          editor.fire("pasteDialog");
          return false;
        }
      } : function(editor) {
        try {
          if (!editor.document.getBody().fire("beforepaste") && !editor.document.$.execCommand("Paste", false, null)) {
            throw 0;
          }
        } catch (z) {
          setTimeout(function() {
            editor.fire("pasteDialog");
          }, 0);
          return false;
        }
      }
    };
    var onKey = function(event) {
      if (this.mode != "wysiwyg") {
        return;
      }
      switch(event.data.keyCode) {
        case 1114112 + 86:
        ;
        case 2228224 + 45:
          var evt = this.document.getBody();
          if (env.opera || env.gecko) {
            evt.fire("paste");
          }
          return;
        case 1114112 + 88:
        ;
        case 2228224 + 46:
          var editor = this;
          this.fire("saveSnapshot");
          setTimeout(function() {
            editor.fire("saveSnapshot");
          }, 0);
      }
    };
    var u;
    var inReadOnly;
    editor.add("clipboard", {
      requires : ["dialog", "htmldataprocessor"],
      init : function(editor) {
        function addButtonCommand(buttonName, commandName, command, expectedNumberOfNonCommentArgs) {
          var lang = editor.lang[commandName];
          editor.addCommand(commandName, command);
          editor.ui.addButton(buttonName, {
            label : lang,
            command : commandName
          });
          if (editor.addMenuItems) {
            editor.addMenuItem(commandName, {
              label : lang,
              command : commandName,
              group : "clipboard",
              order : expectedNumberOfNonCommentArgs
            });
          }
        }
        editor.on("paste", function(browserEvent) {
          var data = browserEvent.data;
          if (data.html) {
            editor.insertHtml(data.html);
          } else {
            if (data.text) {
              editor.insertText(data.text);
            }
          }
          setTimeout(function() {
            editor.fire("afterPaste");
          }, 0);
        }, null, null, 1E3);
        editor.on("pasteDialog", function(dataAndEvents) {
          setTimeout(function() {
            editor.openDialog("paste");
          }, 0);
        });
        editor.on("pasteState", function(evt) {
          editor.getCommand("paste").setState(evt.data);
        });
        addButtonCommand("Cut", "cut", new cutCopyCmd("cut"), 1);
        addButtonCommand("Copy", "copy", new cutCopyCmd("copy"), 4);
        addButtonCommand("Paste", "paste", pasteCmd, 8);
        self.dialog.add("paste", self.getUrl(this.path + "dialogs/paste.js"));
        editor.on("key", onKey, editor);
        editor.on("contentDom", function() {
          var body = editor.document.getBody();
          body.on(!href ? "paste" : "beforepaste", function(isXML) {
            if (u) {
              return;
            }
            var evt = isXML.data && isXML.data.$;
            if (href && (evt && !evt.ctrlKey)) {
              return;
            }
            var eventData = {
              mode : "html"
            };
            editor.fire("beforePaste", eventData);
            getClipboardData.call(editor, isXML, eventData.mode, function(data) {
              if (!(data = $.trim(data.replace(/<span[^>]+data-cke-bookmark[^<]*?<\/span>/ig, "")))) {
                return;
              }
              var dataTransfer = {};
              dataTransfer[eventData.mode] = data;
              editor.fire("paste", dataTransfer);
            });
          });
          if (href) {
            body.on("contextmenu", function() {
              u = 1;
              setTimeout(function() {
                u = 0;
              }, 0);
            });
            body.on("paste", function(evt) {
              if (!editor.document.getById("cke_pastebin")) {
                evt.data.preventDefault();
                u = 0;
                pasteCmd.exec(editor);
              }
            });
          }
          body.on("beforecut", function() {
            if (!u) {
              fixCut(editor);
            }
          });
          body.on("mouseup", function() {
            setTimeout(function() {
              setToolbarStates.call(editor);
            }, 0);
          }, editor);
          body.on("keyup", setToolbarStates, editor);
        });
        editor.on("selectionChange", function(ev) {
          inReadOnly = ev.data.selection.getRanges()[0].checkReadOnly();
          setToolbarStates.call(editor);
        });
        if (editor.contextMenu) {
          editor.contextMenu.addListener(function(dataAndEvents, selection) {
            var C = selection.getRanges()[0].checkReadOnly();
            return{
              cut : stateFromNamedCommand("Cut", editor),
              copy : stateFromNamedCommand("Copy", editor),
              paste : stateFromNamedCommand("Paste", editor)
            };
          });
        }
      }
    });
  })();
  editor.add("colorbutton", {
    requires : ["panelbutton", "floatpanel", "styles"],
    init : function(editor) {
      function addButton(optgroup, type, title) {
        var colorBoxId = $.getNextId() + "_colorBox";
        editor.ui.add(optgroup, "panelbutton", {
          label : title,
          title : title,
          className : "cke_button_" + optgroup.toLowerCase(),
          modes : {
            wysiwyg : 1
          },
          panel : {
            css : editor.skin.editor.css,
            attributes : {
              role : "listbox",
              "aria-label" : lang.panelTitle
            }
          },
          onBlock : function(panel, block) {
            block.autoSize = true;
            block.element.addClass("cke_colorblock");
            block.element.setHtml(renderColors(panel, type, colorBoxId));
            block.element.getDocument().getBody().setStyle("overflow", "hidden");
            options.fire("ready", this);
            var keys = block.keys;
            var rtl = editor.lang.dir == "rtl";
            keys[rtl ? 37 : 39] = "next";
            keys[40] = "next";
            keys[9] = "next";
            keys[rtl ? 39 : 37] = "prev";
            keys[38] = "prev";
            keys[2228224 + 9] = "prev";
            keys[32] = "click";
          },
          onOpen : function() {
            var selection = editor.getSelection();
            var block = selection && selection.getStartElement();
            var path = new dom.elementPath(block);
            var color;
            block = path.block || (path.blockLimit || editor.document.getBody());
            do {
              color = block && block.getComputedStyle(type == "back" ? "background-color" : "color") || "transparent";
            } while (type == "back" && (color == "transparent" && (block && (block = block.getParent()))));
            if (!color || color == "transparent") {
              color = "#ffffff";
            }
            this._.panel._.iframe.getFrameDocument().getById(colorBoxId).setStyle("background-color", color);
          }
        });
      }
      function renderColors(panel, type, colorBoxId) {
        var output = [];
        var codeSegments = config.colorButton_colors.split(",");
        var clickFn = $.addFunction(function(lc, isXML) {
          if (lc == "?") {
            var applyColorStyle = arguments.callee;
            var onColorDialogClose = function(evt) {
              this.removeListener("ok", onColorDialogClose);
              this.removeListener("cancel", onColorDialogClose);
              if (evt.name == "ok") {
                applyColorStyle(this.getContentElement("picker", "selectedColor").getValue(), isXML);
              }
            };
            editor.openDialog("colordialog", function() {
              this.on("ok", onColorDialogClose);
              this.on("cancel", onColorDialogClose);
            });
            return;
          }
          editor.focus();
          panel.hide(false);
          editor.fire("saveSnapshot");
          (new self.style(config["colorButton_" + isXML + "Style"], {
            color : "inherit"
          })).remove(editor.document);
          if (lc) {
            var colorStyle = config["colorButton_" + isXML + "Style"];
            colorStyle.childRule = isXML == "back" ? function(element) {
              return isUnstylable(element);
            } : function(element) {
              return!(element.is("a") || element.getElementsByTag("a").count()) || isUnstylable(element);
            };
            (new self.style(colorStyle, {
              color : lc
            })).apply(editor.document);
          }
          editor.fire("saveSnapshot");
        });
        output.push('<a class="cke_colorauto" _cke_focus=1 hidefocus=true title="', lang.auto, '" onclick="CKEDITOR.tools.callFunction(', clickFn, ",null,'", type, "');return false;\" href=\"javascript:void('", lang.auto, '\')" role="option"><table role="presentation" cellspacing=0 cellpadding=0 width="100%"><tr><td><span class="cke_colorbox" id="', colorBoxId, '"></span></td><td colspan=7 align=center>', lang.auto, '</td></tr></table></a><table role="presentation" cellspacing=0 cellpadding=0 width="100%">');
        var i = 0;
        for (;i < codeSegments.length;i++) {
          if (i % 8 === 0) {
            output.push("</tr><tr>");
          }
          var parts = codeSegments[i].split("/");
          var colorName = parts[0];
          var colorCode = parts[1] || colorName;
          if (!parts[1]) {
            colorName = "#" + colorName.replace(/^(.)(.)(.)$/, "$1$1$2$2$3$3");
          }
          var colorLabel = editor.lang.colors[colorCode] || colorCode;
          output.push('<td><a class="cke_colorbox" _cke_focus=1 hidefocus=true title="', colorLabel, '" onclick="CKEDITOR.tools.callFunction(', clickFn, ",'", colorName, "','", type, "'); return false;\" href=\"javascript:void('", colorLabel, '\')" role="option"><span class="cke_colorbox" style="background-color:#', colorCode, '"></span></a></td>');
        }
        if (config.colorButton_enableMore === undefined || config.colorButton_enableMore) {
          output.push('</tr><tr><td colspan=8 align=center><a class="cke_colormore" _cke_focus=1 hidefocus=true title="', lang.more, '" onclick="CKEDITOR.tools.callFunction(', clickFn, ",'?','", type, "');return false;\" href=\"javascript:void('", lang.more, "')\"", ' role="option">', lang.more, "</a></td>");
        }
        output.push("</tr></table>");
        return output.join("");
      }
      function isUnstylable(ele) {
        return ele.getAttribute("contentEditable") == "false" || ele.getAttribute("data-nostyle");
      }
      var config = editor.config;
      var lang = editor.lang.colorButton;
      var p;
      if (!env.hc) {
        addButton("TextColor", "fore", lang.textColorTitle);
        addButton("BGColor", "back", lang.bgColorTitle);
      }
    }
  });
  config.colorButton_colors = "000,800000,8B4513,2F4F4F,008080,000080,4B0082,696969,B22222,A52A2A,DAA520,006400,40E0D0,0000CD,800080,808080,F00,FF8C00,FFD700,008000,0FF,00F,EE82EE,A9A9A9,FFA07A,FFA500,FFFF00,00FF00,AFEEEE,ADD8E6,DDA0DD,D3D3D3,FFF0F5,FAEBD7,FFFFE0,F0FFF0,F0FFFF,F0F8FF,E6E6FA,FFF";
  config.colorButton_foreStyle = {
    element : "span",
    styles : {
      color : "#(color)"
    },
    overrides : [{
      element : "font",
      attributes : {
        color : null
      }
    }]
  };
  config.colorButton_backStyle = {
    element : "span",
    styles : {
      "background-color" : "#(color)"
    }
  };
  editor.colordialog = {
    requires : ["dialog"],
    init : function(editor) {
      editor.addCommand("colordialog", new self.dialogCommand("colordialog"));
      self.dialog.add("colordialog", this.path + "dialogs/colordialog.js");
    }
  };
  editor.add("colordialog", editor.colordialog);
  editor.add("contextmenu", {
    requires : ["menu"],
    onLoad : function() {
      editor.contextMenu = $.createClass({
        base : self.menu,
        $ : function(name) {
          this.base.call(this, name, {
            panel : {
              className : name.skinClass + " cke_contextmenu",
              attributes : {
                "aria-label" : name.lang.contextmenu.options
              }
            }
          });
        },
        proto : {
          addTarget : function(element, nativeContextMenuOnCtrl) {
            if (env.opera && !("oncontextmenu" in document.body)) {
              var node;
              element.on("mousedown", function(evt) {
                evt = evt.data;
                if (evt.$.button != 2) {
                  if (evt.getKeystroke() == 1114112 + 1) {
                    element.fire("contextmenu", evt);
                  }
                  return;
                }
                if (nativeContextMenuOnCtrl && (env.mac ? evt.$.metaKey : evt.$.ctrlKey)) {
                  return;
                }
                var x = evt.getTarget();
                if (!node) {
                  var ownerDoc = x.getDocument();
                  node = ownerDoc.createElement("input");
                  node.$.type = "button";
                  ownerDoc.getBody().append(node);
                }
                node.setAttribute("style", "position:absolute;top:" + (evt.$.clientY - 2) + "px;left:" + (evt.$.clientX - 2) + "px;width:5px;height:5px;opacity:0.01");
              });
              element.on("mouseup", function(evt) {
                if (node) {
                  node.remove();
                  node = undefined;
                  element.fire("contextmenu", evt.data);
                }
              });
            }
            element.on("contextmenu", function(event) {
              var domEvent = event.data;
              if (nativeContextMenuOnCtrl && (env.webkit ? holdCtrlKey : env.mac ? domEvent.$.metaKey : domEvent.$.ctrlKey)) {
                return;
              }
              domEvent.preventDefault();
              var url = domEvent.getTarget().getDocument().getDocumentElement();
              var offsetX = domEvent.$.clientX;
              var offsetY = domEvent.$.clientY;
              $.setTimeout(function() {
                this.open(url, null, offsetX, offsetY);
              }, href ? 200 : 0, this);
            }, this);
            if (env.opera) {
              element.on("keypress", function(event) {
                var domEvent = event.data;
                if (domEvent.$.keyCode === 0) {
                  domEvent.preventDefault();
                }
              });
            }
            if (env.webkit) {
              var holdCtrlKey;
              var onKeyDown = function(evt) {
                holdCtrlKey = env.mac ? evt.data.$.metaKey : evt.data.$.ctrlKey;
              };
              var focus = function() {
                holdCtrlKey = 0;
              };
              element.on("keydown", onKeyDown);
              element.on("keyup", focus);
              element.on("contextmenu", focus);
            }
          },
          open : function(url, recurring, offsetX, offsetY) {
            this.editor.focus();
            url = url || self.document.getDocumentElement();
            this.show(url, recurring, offsetX, offsetY);
          }
        }
      });
    },
    beforeInit : function(self) {
      self.contextMenu = new editor.contextMenu(self);
      self.addCommand("contextMenu", {
        exec : function() {
          self.contextMenu.open(self.document.getBody());
        }
      });
    }
  });
  (function() {
    function setupAdvParams(element) {
      var attrName = this.att;
      var pdataOld = element && (element.hasAttribute(attrName) && element.getAttribute(attrName)) || "";
      if (pdataOld !== undefined) {
        this.setValue(pdataOld);
      }
    }
    function commitAdvParams() {
      var element;
      var i = 0;
      for (;i < arguments.length;i++) {
        if (arguments[i] instanceof Node) {
          element = arguments[i];
          break;
        }
      }
      if (element) {
        var attrName = this.att;
        var value = this.getValue();
        if (value) {
          element.setAttribute(attrName, value);
        } else {
          element.removeAttribute(attrName, value);
        }
      }
    }
    editor.add("dialogadvtab", {
      createAdvancedTab : function(editor, tabConfig) {
        if (!tabConfig) {
          tabConfig = {
            id : 1,
            dir : 1,
            classes : 1,
            styles : 1
          };
        }
        var lang = editor.lang.common;
        var result = {
          id : "advanced",
          label : lang.advancedTab,
          title : lang.advancedTab,
          elements : [{
            type : "vbox",
            padding : 1,
            children : []
          }]
        };
        var contents = [];
        if (tabConfig.id || tabConfig.dir) {
          if (tabConfig.id) {
            contents.push({
              id : "advId",
              att : "id",
              type : "text",
              label : lang.id,
              setup : setupAdvParams,
              commit : commitAdvParams
            });
          }
          if (tabConfig.dir) {
            contents.push({
              id : "advLangDir",
              att : "dir",
              type : "select",
              label : lang.langDir,
              "default" : "",
              style : "width:100%",
              items : [[lang.notSet, ""], [lang.langDirLTR, "ltr"], [lang.langDirRTL, "rtl"]],
              setup : setupAdvParams,
              commit : commitAdvParams
            });
          }
          result.elements[0].children.push({
            type : "hbox",
            widths : ["50%", "50%"],
            children : [].concat(contents)
          });
        }
        if (tabConfig.styles || tabConfig.classes) {
          contents = [];
          if (tabConfig.styles) {
            contents.push({
              id : "advStyles",
              att : "style",
              type : "text",
              label : lang.styles,
              "default" : "",
              validate : self.dialog.validate.inlineStyle(lang.invalidInlineStyle),
              onChange : function() {
              },
              getStyle : function(name, p) {
                var s = this.getValue().match(new RegExp(name + "\\s*:\\s*([^;]*)", "i"));
                return s ? s[1] : p;
              },
              updateStyle : function(name, code) {
                var value = this.getValue();
                if (value) {
                  value = value.replace(new RegExp("\\s*" + name + "s*:[^;]*(?:$|;s*)", "i"), "").replace(/^[;\s]+/, "").replace(/\s+$/, "");
                }
                if (code) {
                  if (value) {
                    if (!/;\s*$/.test(value)) {
                      value += "; ";
                    }
                  }
                  value += name + ": " + code;
                }
                this.setValue(value, 1);
              },
              setup : setupAdvParams,
              commit : commitAdvParams
            });
          }
          if (tabConfig.classes) {
            contents.push({
              type : "hbox",
              widths : ["45%", "55%"],
              children : [{
                id : "advCSSClasses",
                att : "class",
                type : "text",
                label : lang.cssClasses,
                "default" : "",
                setup : setupAdvParams,
                commit : commitAdvParams
              }]
            });
          }
          result.elements[0].children.push({
            type : "hbox",
            widths : ["50%", "50%"],
            children : [].concat(contents)
          });
        }
        return result;
      }
    });
  })();
  (function() {
    editor.add("div", {
      requires : ["editingblock", "dialog", "domiterator", "styles"],
      init : function(editor) {
        var lang = editor.lang.div;
        editor.addCommand("creatediv", new self.dialogCommand("creatediv"));
        editor.addCommand("editdiv", new self.dialogCommand("editdiv"));
        editor.addCommand("removediv", {
          exec : function(editor) {
            function findDiv(node) {
              var path = new dom.elementPath(node);
              var blockLimit = path.blockLimit;
              var div = blockLimit.is("div") && blockLimit;
              if (div && !div.data("cke-div-added")) {
                controls.push(div);
                div.data("cke-div-added");
              }
            }
            var selection = editor.getSelection();
            var codeSegments = selection && selection.getRanges();
            var range;
            var bookmarks = selection.createBookmarks();
            var walker;
            var controls = [];
            var i = 0;
            for (;i < codeSegments.length;i++) {
              range = codeSegments[i];
              if (range.collapsed) {
                findDiv(selection.getStartElement());
              } else {
                walker = new dom.walker(range);
                walker.evaluator = findDiv;
                walker.lastForward();
              }
            }
            i = 0;
            for (;i < controls.length;i++) {
              controls[i].remove(true);
            }
            selection.selectBookmarks(bookmarks);
          }
        });
        editor.ui.addButton("CreateDiv", {
          label : lang.toolbar,
          command : "creatediv"
        });
        if (editor.addMenuItems) {
          editor.addMenuItems({
            editdiv : {
              label : lang.edit,
              command : "editdiv",
              group : "div",
              order : 1
            },
            removediv : {
              label : lang.remove,
              command : "removediv",
              group : "div",
              order : 5
            }
          });
          if (editor.contextMenu) {
            editor.contextMenu.addListener(function(element, dataAndEvents) {
              if (!element || element.isReadOnly()) {
                return null;
              }
              var elementPath = new dom.elementPath(element);
              var blockLimit = elementPath.blockLimit;
              if (blockLimit && blockLimit.getAscendant("div", true)) {
                return{
                  editdiv : 2,
                  removediv : 2
                };
              }
              return null;
            });
          }
        }
        self.dialog.add("creatediv", this.path + "dialogs/div.js");
        self.dialog.add("editdiv", this.path + "dialogs/div.js");
      }
    });
  })();
  (function() {
    var commands = {
      toolbarFocus : {
        editorFocus : false,
        readOnly : 1,
        exec : function(editor) {
          var idBase = editor._.elementsPath.idBase;
          var submenu = self.document.getById(idBase + "0");
          if (submenu) {
            submenu.focus(href || env.air);
          }
        }
      }
    };
    var html = '<span class="cke_empty">&nbsp;</span>';
    editor.add("elementspath", {
      requires : ["selection"],
      init : function(editor) {
        function onClick(elementIndex) {
          editor.focus();
          var element = editor._.elementsPath.list[elementIndex];
          if (element.is("body")) {
            var range = new dom.range(editor.document);
            range.selectNodeContents(element);
            range.select();
          } else {
            editor.getSelection().selectElement(element);
          }
        }
        function empty() {
          if (item) {
            item.setHtml(html);
          }
          delete editor._.elementsPath.list;
        }
        var itemId = "cke_path_" + editor.name;
        var item;
        var getSpaceElement = function() {
          if (!item) {
            item = self.document.getById(itemId);
          }
          return item;
        };
        var idBase = "cke_elementspath_" + $.getNextNumber() + "_";
        editor._.elementsPath = {
          idBase : idBase,
          filters : []
        };
        editor.on("themeSpace", function(event) {
          if (event.data.space == "bottom") {
            event.data.html += '<span id="' + itemId + '_label" class="cke_voice_label">' + editor.lang.elementsPath.eleLabel + "</span>" + '<div id="' + itemId + '" class="cke_path" role="group" aria-labelledby="' + itemId + '_label">' + html + "</div>";
          }
        });
        var onClickHanlder = $.addFunction(onClick);
        var onKeyDownHandler = $.addFunction(function(elementIndex, ev) {
          var idBase = editor._.elementsPath.idBase;
          var submenu;
          ev = new dom.event(ev);
          var rtl = editor.lang.dir == "rtl";
          switch(ev.getKeystroke()) {
            case rtl ? 39 : 37:
            ;
            case 9:
              submenu = self.document.getById(idBase + (elementIndex + 1));
              if (!submenu) {
                submenu = self.document.getById(idBase + "0");
              }
              submenu.focus();
              return false;
            case rtl ? 37 : 39:
            ;
            case 2228224 + 9:
              submenu = self.document.getById(idBase + (elementIndex - 1));
              if (!submenu) {
                submenu = self.document.getById(idBase + (editor._.elementsPath.list.length - 1));
              }
              submenu.focus();
              return false;
            case 27:
              editor.focus();
              return false;
            case 13:
            ;
            case 32:
              onClick(elementIndex);
              return false;
          }
          return true;
        });
        editor.on("selectionChange", function(ev) {
          var ua = env;
          var selection = ev.data.selection;
          var element = selection.getStartElement();
          var c = [];
          var editor = ev.editor;
          var flattened = editor._.elementsPath.list = [];
          var codeSegments = editor._.elementsPath.filters;
          for (;element;) {
            var F = 0;
            var camelKey;
            if (element.data("cke-display-name")) {
              camelKey = element.data("cke-display-name");
            } else {
              if (element.data("cke-real-element-type")) {
                camelKey = element.data("cke-real-element-type");
              } else {
                camelKey = element.getName();
              }
            }
            var i = 0;
            for (;i < codeSegments.length;i++) {
              var elementRect = codeSegments[i](element, camelKey);
              if (elementRect === false) {
                F = 1;
                break;
              }
              camelKey = elementRect || camelKey;
            }
            if (!F) {
              var index = flattened.push(element) - 1;
              var extra = "";
              if (ua.opera || ua.gecko && ua.mac) {
                extra += ' onkeypress="return false;"';
              }
              if (ua.gecko) {
                extra += ' onblur="this.style.cssText = this.style.cssText;"';
              }
              var data = editor.lang.elementsPath.eleTitle.replace(/%1/, camelKey);
              c.unshift('<a id="', idBase, index, '" href="javascript:void(\'', camelKey, '\')" tabindex="-1" title="', data, '"' + (env.gecko && env.version < 10900 ? ' onfocus="event.preventBubble();"' : "") + ' hidefocus="true" ' + ' onkeydown="return CKEDITOR.tools.callFunction(', onKeyDownHandler, ",", index, ', event );"' + extra, ' onclick="CKEDITOR.tools.callFunction(' + onClickHanlder, ",", index, '); return false;"', ' role="button" aria-labelledby="' + idBase + index + '_label">', camelKey, 
              '<span id="', idBase, index, '_label" class="cke_label">' + data + "</span>", "</a>");
            }
            if (camelKey == "body") {
              break;
            }
            element = element.getParent();
          }
          var space = getSpaceElement();
          space.setHtml(c.join("") + html);
          editor.fire("elementsPathUpdate", {
            space : space
          });
        });
        editor.on("readOnly", empty);
        editor.on("contentDomUnload", empty);
        editor.addCommand("elementsPathFocus", commands.toolbarFocus);
      }
    });
  })();
  (function() {
    function shiftEnter(editor) {
      if (editor.mode != "wysiwyg") {
        return false;
      }
      return enter(editor, editor.config.shiftEnterMode, 1);
    }
    function enter(editor, mode, forceMode) {
      forceMode = editor.config.forceEnterMode || forceMode;
      if (editor.mode != "wysiwyg") {
        return false;
      }
      if (!mode) {
        mode = editor.config.enterMode;
      }
      setTimeout(function() {
        editor.fire("saveSnapshot");
        if (mode == 2) {
          enterBr(editor, mode, null, forceMode);
        } else {
          enterBlock(editor, mode, null, forceMode);
        }
        editor.fire("saveSnapshot");
      }, 0);
      return true;
    }
    function getRange(editor) {
      var codeSegments = editor.getSelection().getRanges(true);
      var i = codeSegments.length - 1;
      for (;i > 0;i--) {
        codeSegments[i].deleteContents();
      }
      return codeSegments[0];
    }
    editor.add("enterkey", {
      requires : ["keystrokes", "indent"],
      init : function(editor) {
        editor.addCommand("enter", {
          modes : {
            wysiwyg : 1
          },
          editorFocus : false,
          exec : function(editor) {
            enter(editor);
          }
        });
        editor.addCommand("shiftEnter", {
          modes : {
            wysiwyg : 1
          },
          editorFocus : false,
          exec : function(editor) {
            shiftEnter(editor);
          }
        });
        var keystrokes = editor.keystrokeHandler.keystrokes;
        keystrokes[13] = "enter";
        keystrokes[2228224 + 13] = "shiftEnter";
      }
    });
    editor.enterkey = {
      enterBlock : function(editor, mode, range, forceMode) {
        range = range || getRange(editor);
        if (!range) {
          return;
        }
        var doc = range.document;
        var a = range.checkStartOfBlock();
        var b = range.checkEndOfBlock();
        var path = new dom.elementPath(range.startContainer);
        var block = path.block;
        if (a && b) {
          if (block && (block.is("li") || block.getParent().is("li"))) {
            editor.execCommand("outdent");
            return;
          }
          if (block && block.getParent().is("blockquote")) {
            block.breakParent(block.getParent());
            if (!block.getPrevious().getFirst(dom.walker.invisible(1))) {
              block.getPrevious().remove();
            }
            if (!block.getNext().getFirst(dom.walker.invisible(1))) {
              block.getNext().remove();
            }
            range.moveToElementEditStart(block);
            range.select();
            return;
          }
        } else {
          if (block && block.is("pre")) {
            if (!b) {
              enterBr(editor, mode, range, forceMode);
              return;
            }
          } else {
            if (block && dtd.$captionBlock[block.getName()]) {
              enterBr(editor, mode, range, forceMode);
              return;
            }
          }
        }
        var blockTag = mode == 3 ? "div" : "p";
        var splitInfo = range.splitBlock(blockTag);
        if (!splitInfo) {
          return;
        }
        var previousBlock = splitInfo.previousBlock;
        var nextBlock = splitInfo.nextBlock;
        var isStartOfBlock = splitInfo.wasStartOfBlock;
        var isEndOfBlock = splitInfo.wasEndOfBlock;
        var optgroup;
        if (nextBlock) {
          optgroup = nextBlock.getParent();
          if (optgroup.is("li")) {
            nextBlock.breakParent(optgroup);
            nextBlock.move(nextBlock.getNext(), 1);
          }
        } else {
          if (previousBlock && ((optgroup = previousBlock.getParent()) && optgroup.is("li"))) {
            previousBlock.breakParent(optgroup);
            optgroup = previousBlock.getNext();
            range.moveToElementEditStart(optgroup);
            previousBlock.move(previousBlock.getPrevious());
          }
        }
        if (!isStartOfBlock && !isEndOfBlock) {
          if (nextBlock.is("li") && ((optgroup = nextBlock.getFirst(dom.walker.invisible(true))) && (optgroup.is && optgroup.is("ul", "ol")))) {
            (href ? doc.createText("\u00a0") : doc.createElement("br")).insertBefore(optgroup);
          }
          if (nextBlock) {
            range.moveToElementEditStart(nextBlock);
          }
        } else {
          var newBlock;
          var newBlockDir;
          if (previousBlock) {
            if (previousBlock.is("li") || !(headerTagRegex.test(previousBlock.getName()) || previousBlock.is("pre"))) {
              newBlock = previousBlock.clone();
            }
          } else {
            if (nextBlock) {
              newBlock = nextBlock.clone();
            }
          }
          if (!newBlock) {
            if (optgroup && optgroup.is("li")) {
              newBlock = optgroup;
            } else {
              newBlock = doc.createElement(blockTag);
              if (previousBlock && (newBlockDir = previousBlock.getDirection())) {
                newBlock.setAttribute("dir", newBlockDir);
              }
            }
          } else {
            if (forceMode && !newBlock.is("li")) {
              newBlock.renameNode(blockTag);
            }
          }
          var elementPath = splitInfo.elementPath;
          if (elementPath) {
            var i = 0;
            var valuesLen = elementPath.elements.length;
            for (;i < valuesLen;i++) {
              var element = elementPath.elements[i];
              if (element.equals(elementPath.block) || element.equals(elementPath.blockLimit)) {
                break;
              }
              if (dtd.$removeEmpty[element.getName()]) {
                element = element.clone();
                newBlock.moveChildren(element);
                newBlock.append(element);
              }
            }
          }
          if (!href) {
            newBlock.appendBogus();
          }
          if (!newBlock.getParent()) {
            range.insertNode(newBlock);
          }
          if (newBlock.is("li")) {
            newBlock.removeAttribute("value");
          }
          if (href && (isStartOfBlock && (!isEndOfBlock || !previousBlock.getChildCount()))) {
            range.moveToElementEditStart(isEndOfBlock ? previousBlock : newBlock);
            range.select();
          }
          range.moveToElementEditStart(isStartOfBlock && !isEndOfBlock ? nextBlock : newBlock);
        }
        if (!href) {
          if (nextBlock) {
            var tmpNode = doc.createElement("span");
            tmpNode.setHtml("&nbsp;");
            range.insertNode(tmpNode);
            tmpNode.scrollIntoView();
            range.deleteContents();
          } else {
            newBlock.scrollIntoView();
          }
        }
        range.select();
      },
      enterBr : function(editor, mode, range, forceMode) {
        range = range || getRange(editor);
        if (!range) {
          return;
        }
        var doc = range.document;
        var blockTag = mode == 3 ? "div" : "p";
        var isEndOfBlock = range.checkEndOfBlock();
        var data = new dom.elementPath(editor.getSelection().getStartElement());
        var rvar = data.block;
        var startBlockTag = rvar && data.block.getName();
        var isPre = false;
        if (!forceMode && startBlockTag == "li") {
          enterBlock(editor, mode, range, forceMode);
          return;
        }
        if (!forceMode && (isEndOfBlock && headerTagRegex.test(startBlockTag))) {
          var body;
          var t;
          if (t = rvar.getDirection()) {
            body = doc.createElement("div");
            body.setAttribute("dir", t);
            body.insertAfter(rvar);
            range.setStart(body, 0);
          } else {
            doc.createElement("br").insertAfter(rvar);
            if (env.gecko) {
              doc.createText("").insertAfter(rvar);
            }
            range.setStartAt(rvar.getNext(), href ? 3 : 1);
          }
        } else {
          var optgroup;
          isPre = startBlockTag == "pre";
          if (isPre && !env.gecko) {
            optgroup = doc.createText(href ? "\r" : "\n");
          } else {
            optgroup = doc.createElement("br");
          }
          range.deleteContents();
          range.insertNode(optgroup);
          if (href) {
            range.setStartAt(optgroup, 4);
          } else {
            doc.createText("\ufeff").insertAfter(optgroup);
            if (isEndOfBlock) {
              optgroup.getParent().appendBogus();
            }
            optgroup.getNext().$.nodeValue = "";
            range.setStartAt(optgroup.getNext(), 1);
            var dummy = null;
            if (!env.gecko) {
              dummy = doc.createElement("span");
              dummy.setHtml("&nbsp;");
            } else {
              dummy = doc.createElement("br");
            }
            dummy.insertBefore(optgroup.getNext());
            dummy.scrollIntoView();
            dummy.remove();
          }
        }
        range.collapse(true);
        range.select(isPre);
      }
    };
    var plugin = editor.enterkey;
    var enterBr = plugin.enterBr;
    var enterBlock = plugin.enterBlock;
    var headerTagRegex = /^h[1-6]$/;
  })();
  (function() {
    function parse(qs, reverse) {
      var result = {};
      var regex = [];
      var specialTable = {
        nbsp : "\u00a0",
        shy : "\u00ad",
        gt : ">",
        lt : "<",
        amp : "&",
        apos : "'",
        quot : '"'
      };
      qs = qs.replace(/\b(nbsp|shy|gt|lt|amp|apos|quot)(?:,|$)/g, function(dataAndEvents, entity) {
        var date = reverse ? "&" + entity + ";" : specialTable[entity];
        var value = reverse ? specialTable[entity] : "&" + entity + ";";
        result[date] = value;
        regex.push(date);
        return "";
      });
      if (!reverse && qs) {
        qs = qs.split(",");
        var elem = document.createElement("div");
        var ret;
        elem.innerHTML = "&" + qs.join(";&") + ";";
        ret = elem.innerHTML;
        elem = null;
        var i = 0;
        for (;i < ret.length;i++) {
          var code = ret.charAt(i);
          result[code] = "&" + qs[i] + ";";
          regex.push(code);
        }
      }
      result.regex = regex.join(reverse ? "|" : "");
      return result;
    }
    var htmlbase = "nbsp,gt,lt,amp";
    var copies = "quot,iexcl,cent,pound,curren,yen,brvbar,sect,uml,copy,ordf,laquo,not,shy,reg,macr,deg,plusmn,sup2,sup3,acute,micro,para,middot,cedil,sup1,ordm,raquo,frac14,frac12,frac34,iquest,times,divide,fnof,bull,hellip,prime,Prime,oline,frasl,weierp,image,real,trade,alefsym,larr,uarr,rarr,darr,harr,crarr,lArr,uArr,rArr,dArr,hArr,forall,part,exist,empty,nabla,isin,notin,ni,prod,sum,minus,lowast,radic,prop,infin,ang,and,or,cap,cup,int,there4,sim,cong,asymp,ne,equiv,le,ge,sub,sup,nsub,sube,supe,oplus,otimes,perp,sdot,lceil,rceil,lfloor,rfloor,lang,rang,loz,spades,clubs,hearts,diams,circ,tilde,ensp,emsp,thinsp,zwnj,zwj,lrm,rlm,ndash,mdash,lsquo,rsquo,sbquo,ldquo,rdquo,bdquo,dagger,Dagger,permil,lsaquo,rsaquo,euro";
    var templatePromise = "Agrave,Aacute,Acirc,Atilde,Auml,Aring,AElig,Ccedil,Egrave,Eacute,Ecirc,Euml,Igrave,Iacute,Icirc,Iuml,ETH,Ntilde,Ograve,Oacute,Ocirc,Otilde,Ouml,Oslash,Ugrave,Uacute,Ucirc,Uuml,Yacute,THORN,szlig,agrave,aacute,acirc,atilde,auml,aring,aelig,ccedil,egrave,eacute,ecirc,euml,igrave,iacute,icirc,iuml,eth,ntilde,ograve,oacute,ocirc,otilde,ouml,oslash,ugrave,uacute,ucirc,uuml,yacute,thorn,yuml,OElig,oelig,Scaron,scaron,Yuml";
    var modId = "Alpha,Beta,Gamma,Delta,Epsilon,Zeta,Eta,Theta,Iota,Kappa,Lambda,Mu,Nu,Xi,Omicron,Pi,Rho,Sigma,Tau,Upsilon,Phi,Chi,Psi,Omega,alpha,beta,gamma,delta,epsilon,zeta,eta,theta,iota,kappa,lambda,mu,nu,xi,omicron,pi,rho,sigmaf,sigma,tau,upsilon,phi,chi,psi,omega,thetasym,upsih,piv";
    editor.add("entities", {
      afterInit : function(editor) {
        var config = editor.config;
        var dataProcessor = editor.dataProcessor;
        var htmlFilter = dataProcessor && dataProcessor.htmlFilter;
        if (htmlFilter) {
          var selectedEntities = [];
          if (config.basicEntities !== false) {
            selectedEntities.push(htmlbase);
          }
          if (config.entities) {
            if (selectedEntities.length) {
              selectedEntities.push(copies);
            }
            if (config.entities_latin) {
              selectedEntities.push(templatePromise);
            }
            if (config.entities_greek) {
              selectedEntities.push(modId);
            }
            if (config.entities_additional) {
              selectedEntities.push(config.entities_additional);
            }
          }
          var result = parse(selectedEntities.join(","));
          var optgroup = result.regex ? "[" + result.regex + "]" : "a^";
          delete result.regex;
          if (config.entities && config.entities_processNumerical) {
            optgroup = "[^ -~]|" + optgroup;
          }
          optgroup = new RegExp(optgroup, "g");
          var pdataOld = function(key) {
            return config.entities_processNumerical == "force" || !result[key] ? "&#" + key.charCodeAt(0) + ";" : result[key];
          };
          var url = parse([htmlbase, "shy"].join(","), true);
          var rvar = new RegExp(url.regex, "g");
          var udataCur = function(segment) {
            return url[segment];
          };
          htmlFilter.addRules({
            text : function(name) {
              return name.replace(rvar, udataCur).replace(optgroup, pdataOld);
            }
          });
        }
      }
    });
  })();
  config.basicEntities = true;
  config.entities = true;
  config.entities_latin = true;
  config.entities_greek = true;
  config.entities_additional = "#39";
  (function() {
    function addQueryString(url, params) {
      var tagNameArr = [];
      if (!params) {
        return url;
      } else {
        var key;
        for (key in params) {
          tagNameArr.push(key + "=" + encodeURIComponent(params[key]));
        }
      }
      return url + (url.indexOf("?") != -1 ? "&" : "?") + tagNameArr.join("&");
    }
    function ucFirst(str) {
      str += "";
      var w = str.charAt(0).toUpperCase();
      return w + str.substr(1);
    }
    function browseServer(name) {
      var self = this;
      var dialog = self.getDialog();
      var editor = dialog.getParentEditor();
      editor._.filebrowserSe = self;
      var width = editor.config["filebrowser" + ucFirst(dialog.getName()) + "WindowWidth"] || (editor.config.filebrowserWindowWidth || "80%");
      var height = editor.config["filebrowser" + ucFirst(dialog.getName()) + "WindowHeight"] || (editor.config.filebrowserWindowHeight || "70%");
      var params = self.filebrowser.params || {};
      params.CKEditor = editor.name;
      params.CKEditorFuncNum = editor._.filebrowserFn;
      if (!params.langCode) {
        params.langCode = editor.langCode;
      }
      var url = addQueryString(self.filebrowser.url, params);
      editor.popup(url, width, height, editor.config.filebrowserWindowFeatures || editor.config.fileBrowserWindowFeatures);
    }
    function uploadFile(evt) {
      var self = this;
      var dialog = self.getDialog();
      var editor = dialog.getParentEditor();
      editor._.filebrowserSe = self;
      if (!dialog.getContentElement(self["for"][0], self["for"][1]).getInputElement().$.value) {
        return false;
      }
      if (!dialog.getContentElement(self["for"][0], self["for"][1]).getAction()) {
        return false;
      }
      return true;
    }
    function setupFileElement(editor, fileInput, filebrowser) {
      var params = filebrowser.params || {};
      params.CKEditor = editor.name;
      params.CKEditorFuncNum = editor._.filebrowserFn;
      if (!params.langCode) {
        params.langCode = editor.langCode;
      }
      fileInput.action = addQueryString(filebrowser.url, params);
      fileInput.filebrowser = filebrowser;
    }
    function attachFileBrowser(editor, dialogName, definition, elements) {
      var element;
      var A;
      var key;
      for (key in elements) {
        element = elements[key];
        if (element.type == "hbox" || (element.type == "vbox" || element.type == "fieldset")) {
          attachFileBrowser(editor, dialogName, definition, element.children);
        }
        if (!element.filebrowser) {
          continue;
        }
        if (typeof element.filebrowser == "string") {
          var fb = {
            action : element.type == "fileButton" ? "QuickUpload" : "Browse",
            target : element.filebrowser
          };
          element.filebrowser = fb;
        }
        if (element.filebrowser.action == "Browse") {
          var url = element.filebrowser.url;
          if (url === undefined) {
            url = editor.config["filebrowser" + ucFirst(dialogName) + "BrowseUrl"];
            if (url === undefined) {
              url = editor.config.filebrowserBrowseUrl;
            }
          }
          if (url) {
            element.onClick = browseServer;
            element.filebrowser.url = url;
            element.hidden = false;
          }
        } else {
          if (element.filebrowser.action == "QuickUpload" && element["for"]) {
            url = element.filebrowser.url;
            if (url === undefined) {
              url = editor.config["filebrowser" + ucFirst(dialogName) + "UploadUrl"];
              if (url === undefined) {
                url = editor.config.filebrowserUploadUrl;
              }
            }
            if (url) {
              var onClick = element.onClick;
              element.onClick = function(isXML) {
                var optgroup = isXML.sender;
                if (onClick && onClick.call(optgroup, isXML) === false) {
                  return false;
                }
                return uploadFile.call(optgroup, isXML);
              };
              element.filebrowser.url = url;
              element.hidden = false;
              setupFileElement(editor, definition.getContents(element["for"][0]).get(element["for"][1]), element.filebrowser);
            }
          }
        }
      }
    }
    function updateTargetElement(isXML, sourceElement) {
      var dialog = sourceElement.getDialog();
      var uHostName = sourceElement.filebrowser.target || null;
      if (uHostName) {
        var target = uHostName.split(":");
        var button = dialog.getContentElement(target[0], target[1]);
        if (button) {
          button.setValue(isXML);
          dialog.selectPage(target[0]);
        }
      }
    }
    function isConfigured(definition, tabId, elementId) {
      if (elementId.indexOf(";") !== -1) {
        var codeSegments = elementId.split(";");
        var i = 0;
        for (;i < codeSegments.length;i++) {
          if (isConfigured(definition, tabId, codeSegments[i])) {
            return true;
          }
        }
        return false;
      }
      var elementFileBrowser = definition.getContents(tabId).get(elementId).filebrowser;
      return elementFileBrowser && elementFileBrowser.url;
    }
    function setUrl(isXML, data) {
      var editor = this;
      var dialog = editor._.filebrowserSe.getDialog();
      var targetInput = editor._.filebrowserSe["for"];
      var onSelect = editor._.filebrowserSe.filebrowser.onSelect;
      if (targetInput) {
        dialog.getContentElement(targetInput[0], targetInput[1]).reset();
      }
      if (typeof data == "function" && data.call(editor._.filebrowserSe) === false) {
        return;
      }
      if (onSelect && onSelect.call(editor._.filebrowserSe, isXML, data) === false) {
        return;
      }
      if (typeof data == "string" && data) {
        alert(data);
      }
      if (isXML) {
        updateTargetElement(isXML, editor._.filebrowserSe);
      }
    }
    editor.add("filebrowser", {
      init : function(editor, allBindingsAccessor) {
        editor._.filebrowserFn = $.addFunction(setUrl, editor);
        editor.on("destroy", function() {
          $.removeFunction(this._.filebrowserFn);
        });
      }
    });
    self.on("dialogDefinition", function(evt) {
      var definition = evt.data.definition;
      var element;
      var i;
      for (i in definition.contents) {
        if (element = definition.contents[i]) {
          attachFileBrowser(evt.editor, evt.data.name, definition, element.elements);
          if (element.hidden && element.filebrowser) {
            element.hidden = !isConfigured(definition, element.id, element.filebrowser);
          }
        }
      }
    });
  })();
  editor.add("find", {
    requires : ["dialog"],
    init : function(d) {
      var lang = editor.find;
      d.ui.addButton("Find", {
        label : d.lang.findAndReplace.find,
        command : "find"
      });
      var findCommand = d.addCommand("find", new self.dialogCommand("find"));
      findCommand.canUndo = false;
      findCommand.readOnly = 1;
      d.ui.addButton("Replace", {
        label : d.lang.findAndReplace.replace,
        command : "replace"
      });
      var replaceCommand = d.addCommand("replace", new self.dialogCommand("replace"));
      replaceCommand.canUndo = false;
      self.dialog.add("find", this.path + "dialogs/find.js");
      self.dialog.add("replace", this.path + "dialogs/find.js");
    },
    requires : ["styles"]
  });
  config.find_highlight = {
    element : "span",
    styles : {
      "background-color" : "#004",
      color : "#fff"
    }
  };
  (function() {
    function isFlashEmbed(element) {
      var attributes = element.attributes;
      return attributes.type == "application/x-shockwave-flash" || rchecked.test(attributes.src || "");
    }
    function createFakeElement(editor, realElement) {
      return editor.createFakeParserElement(realElement, "cke_flash", "flash", true);
    }
    var rchecked = /\.swf(?:$|\?)/i;
    editor.add("flash", {
      init : function(editor) {
        editor.addCommand("flash", new self.dialogCommand("flash"));
        editor.ui.addButton("Flash", {
          label : editor.lang.common.flash,
          command : "flash"
        });
        self.dialog.add("flash", this.path + "dialogs/flash.js");
        editor.addCss("img.cke_flash{background-image: url(" + self.getUrl(this.path + "images/placeholder.png") + ");" + "background-position: center center;" + "background-repeat: no-repeat;" + "border: 1px solid #a9a9a9;" + "width: 80px;" + "height: 80px;" + "}");
        if (editor.addMenuItems) {
          editor.addMenuItems({
            flash : {
              label : editor.lang.flash.properties,
              command : "flash",
              group : "flash"
            }
          });
        }
        editor.on("doubleclick", function(evt) {
          var element = evt.data.element;
          if (element.is("img") && element.data("cke-real-element-type") == "flash") {
            evt.data.dialog = "flash";
          }
        });
        if (editor.contextMenu) {
          editor.contextMenu.addListener(function(element, dataAndEvents) {
            if (element && (element.is("img") && (!element.isReadOnly() && element.data("cke-real-element-type") == "flash"))) {
              return{
                flash : 2
              };
            }
          });
        }
      },
      afterInit : function(editor) {
        var dataProcessor = editor.dataProcessor;
        var dataFilter = dataProcessor && dataProcessor.dataFilter;
        if (dataFilter) {
          dataFilter.addRules({
            elements : {
              "cke:object" : function(element) {
                var attributes = element.attributes;
                var u = attributes.classid && String(attributes.classid).toLowerCase();
                if (!u && !isFlashEmbed(element)) {
                  var i = 0;
                  for (;i < element.children.length;i++) {
                    if (element.children[i].name == "cke:embed") {
                      if (!isFlashEmbed(element.children[i])) {
                        return null;
                      }
                      return createFakeElement(editor, element);
                    }
                  }
                  return null;
                }
                return createFakeElement(editor, element);
              },
              "cke:embed" : function(element) {
                if (!isFlashEmbed(element)) {
                  return null;
                }
                return createFakeElement(editor, element);
              }
            }
          }, 5);
        }
      },
      requires : ["fakeobjects"]
    });
  })();
  $.extend(config, {
    flashEmbedTagOnly : false,
    flashAddEmbedTag : true,
    flashConvertOnEdit : false
  });
  (function() {
    function addCombo(editor, comboName, styleType, lang, entries, value, styleDefinition) {
      var config = editor.config;
      var resultItems = entries.split(";");
      var values = [];
      var styles = {};
      var i = 0;
      for (;i < resultItems.length;i++) {
        var result = resultItems[i];
        if (result) {
          result = result.split("/");
          var vars = {};
          var name = resultItems[i] = result[0];
          vars[styleType] = values[i] = result[1] || name;
          styles[name] = new self.style(styleDefinition, vars);
          styles[name]._.definition.name = name;
        } else {
          resultItems.splice(i--, 1);
        }
      }
      editor.ui.addRichCombo(comboName, {
        label : lang.label,
        title : lang.panelTitle,
        className : "cke_" + (styleType == "size" ? "fontSize" : "font"),
        panel : {
          css : editor.skin.editor.css.concat(config.contentsCss),
          multiSelect : false,
          attributes : {
            "aria-label" : lang.panelTitle
          }
        },
        init : function() {
          this.startGroup(lang.panelTitle);
          var i = 0;
          for (;i < resultItems.length;i++) {
            var name = resultItems[i];
            this.add(name, styles[name].buildPreview(), name);
          }
        },
        onClick : function(name) {
          editor.focus();
          editor.fire("saveSnapshot");
          var style = styles[name];
          if (this.getValue() == name) {
            style.remove(editor.document);
          } else {
            style.apply(editor.document);
          }
          editor.fire("saveSnapshot");
        },
        onRender : function() {
          editor.on("selectionChange", function(evt) {
            var url = this.getValue();
            var elementPath = evt.data.path;
            var elements = elementPath.elements;
            var i = 0;
            var element;
            for (;i < elements.length;i++) {
              element = elements[i];
              var prop;
              for (prop in styles) {
                if (styles[prop].checkElementMatch(element, true)) {
                  if (prop != url) {
                    this.setValue(prop);
                  }
                  return;
                }
              }
            }
            this.setValue("", value);
          }, this);
        }
      });
    }
    editor.add("font", {
      requires : ["richcombo", "styles"],
      init : function(editor) {
        var config = editor.config;
        addCombo(editor, "Font", "family", editor.lang.font, config.font_names, config.font_defaultLabel, config.font_style);
        addCombo(editor, "FontSize", "size", editor.lang.fontSize, config.fontSize_sizes, config.fontSize_defaultLabel, config.fontSize_style);
      }
    });
  })();
  config.font_names = "Arial/Arial, Helvetica, sans-serif;Comic Sans MS/Comic Sans MS, cursive;Courier New/Courier New, Courier, monospace;Georgia/Georgia, serif;Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;Tahoma/Tahoma, Geneva, sans-serif;Times New Roman/Times New Roman, Times, serif;Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;Verdana/Verdana, Geneva, sans-serif";
  config.font_defaultLabel = "";
  config.font_style = {
    element : "span",
    styles : {
      "font-family" : "#(family)"
    },
    overrides : [{
      element : "font",
      attributes : {
        face : null
      }
    }]
  };
  config.fontSize_sizes = "8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px";
  config.fontSize_defaultLabel = "";
  config.fontSize_style = {
    element : "span",
    styles : {
      "font-size" : "#(size)"
    },
    overrides : [{
      element : "font",
      attributes : {
        size : null
      }
    }]
  };
  editor.add("format", {
    requires : ["richcombo", "styles"],
    init : function(editor) {
      var config = editor.config;
      var lang = editor.lang.format;
      var codeSegments = config.format_tags.split(";");
      var styles = {};
      var i = 0;
      for (;i < codeSegments.length;i++) {
        var tag = codeSegments[i];
        styles[tag] = new self.style(config["format_" + tag]);
        styles[tag]._.enterMode = editor.config.enterMode;
      }
      editor.ui.addRichCombo("Format", {
        label : lang.label,
        title : lang.panelTitle,
        className : "cke_format",
        panel : {
          css : editor.skin.editor.css.concat(config.contentsCss),
          multiSelect : false,
          attributes : {
            "aria-label" : lang.panelTitle
          }
        },
        init : function() {
          this.startGroup(lang.panelTitle);
          var optgroup;
          for (optgroup in styles) {
            var label = lang["tag_" + optgroup];
            this.add(optgroup, styles[optgroup].buildPreview(label), label);
          }
        },
        onClick : function(name) {
          editor.focus();
          editor.fire("saveSnapshot");
          var style = styles[name];
          var elementPath = new dom.elementPath(editor.getSelection().getStartElement());
          style[style.checkActive(elementPath) ? "remove" : "apply"](editor.document);
          setTimeout(function() {
            editor.fire("saveSnapshot");
          }, 0);
        },
        onRender : function() {
          editor.on("selectionChange", function(evt) {
            var currentTag = this.getValue();
            var elementPath = evt.data.path;
            var tag;
            for (tag in styles) {
              if (styles[tag].checkActive(elementPath)) {
                if (tag != currentTag) {
                  this.setValue(tag, editor.lang.format["tag_" + tag]);
                }
                return;
              }
            }
            this.setValue("");
          }, this);
        }
      });
    }
  });
  config.format_tags = "p;h1;h2;h3;h4;h5;h6;pre;address;div";
  config.format_p = {
    element : "p"
  };
  config.format_div = {
    element : "div"
  };
  config.format_pre = {
    element : "pre"
  };
  config.format_address = {
    element : "address"
  };
  config.format_h1 = {
    element : "h1"
  };
  config.format_h2 = {
    element : "h2"
  };
  config.format_h3 = {
    element : "h3"
  };
  config.format_h4 = {
    element : "h4"
  };
  config.format_h5 = {
    element : "h5"
  };
  config.format_h6 = {
    element : "h6"
  };
  editor.add("forms", {
    requires : ["dialog"],
    init : function(instance) {
      var lang = instance.lang;
      instance.addCss("form{border: 1px dotted #FF0000;padding: 2px;}\n");
      instance.addCss("img.cke_hidden{background-image: url(" + self.getUrl(this.path + "images/hiddenfield.gif") + ");" + "background-position: center center;" + "background-repeat: no-repeat;" + "border: 1px solid #a9a9a9;" + "width: 16px !important;" + "height: 16px !important;" + "}");
      var addButtonCommand = function(buttonName, name, attributes) {
        instance.addCommand(name, new self.dialogCommand(name));
        instance.ui.addButton(buttonName, {
          label : lang.common[buttonName.charAt(0).toLowerCase() + buttonName.slice(1)],
          command : name
        });
        self.dialog.add(name, attributes);
      };
      var dialogPath = this.path + "dialogs/";
      addButtonCommand("Form", "form", dialogPath + "form.js");
      addButtonCommand("Checkbox", "checkbox", dialogPath + "checkbox.js");
      addButtonCommand("Radio", "radio", dialogPath + "radio.js");
      addButtonCommand("TextField", "textfield", dialogPath + "textfield.js");
      addButtonCommand("Textarea", "textarea", dialogPath + "textarea.js");
      addButtonCommand("Select", "select", dialogPath + "select.js");
      addButtonCommand("Button", "button", dialogPath + "button.js");
      addButtonCommand("ImageButton", "imagebutton", editor.getPath("image") + "dialogs/image.js");
      addButtonCommand("HiddenField", "hiddenfield", dialogPath + "hiddenfield.js");
      if (instance.addMenuItems) {
        instance.addMenuItems({
          form : {
            label : lang.form.menu,
            command : "form",
            group : "form"
          },
          checkbox : {
            label : lang.checkboxAndRadio.checkboxTitle,
            command : "checkbox",
            group : "checkbox"
          },
          radio : {
            label : lang.checkboxAndRadio.radioTitle,
            command : "radio",
            group : "radio"
          },
          textfield : {
            label : lang.textfield.title,
            command : "textfield",
            group : "textfield"
          },
          hiddenfield : {
            label : lang.hidden.title,
            command : "hiddenfield",
            group : "hiddenfield"
          },
          imagebutton : {
            label : lang.image.titleButton,
            command : "imagebutton",
            group : "imagebutton"
          },
          button : {
            label : lang.button.title,
            command : "button",
            group : "button"
          },
          select : {
            label : lang.select.title,
            command : "select",
            group : "select"
          },
          textarea : {
            label : lang.textarea.title,
            command : "textarea",
            group : "textarea"
          }
        });
      }
      if (instance.contextMenu) {
        instance.contextMenu.addListener(function(element) {
          if (element && (element.hasAscendant("form", true) && !element.isReadOnly())) {
            return{
              form : 2
            };
          }
        });
        instance.contextMenu.addListener(function(element) {
          if (element && !element.isReadOnly()) {
            var name = element.getName();
            if (name == "select") {
              return{
                select : 2
              };
            }
            if (name == "textarea") {
              return{
                textarea : 2
              };
            }
            if (name == "input") {
              switch(element.getAttribute("type")) {
                case "button":
                ;
                case "submit":
                ;
                case "reset":
                  return{
                    button : 2
                  };
                case "checkbox":
                  return{
                    checkbox : 2
                  };
                case "radio":
                  return{
                    radio : 2
                  };
                case "image":
                  return{
                    imagebutton : 2
                  };
                default:
                  return{
                    textfield : 2
                  };
              }
            }
            if (name == "img" && element.data("cke-real-element-type") == "hiddenfield") {
              return{
                hiddenfield : 2
              };
            }
          }
        });
      }
      instance.on("doubleclick", function(evt) {
        var element = evt.data.element;
        if (element.is("form")) {
          evt.data.dialog = "form";
        } else {
          if (element.is("select")) {
            evt.data.dialog = "select";
          } else {
            if (element.is("textarea")) {
              evt.data.dialog = "textarea";
            } else {
              if (element.is("img") && element.data("cke-real-element-type") == "hiddenfield") {
                evt.data.dialog = "hiddenfield";
              } else {
                if (element.is("input")) {
                  switch(element.getAttribute("type")) {
                    case "button":
                    ;
                    case "submit":
                    ;
                    case "reset":
                      evt.data.dialog = "button";
                      break;
                    case "checkbox":
                      evt.data.dialog = "checkbox";
                      break;
                    case "radio":
                      evt.data.dialog = "radio";
                      break;
                    case "image":
                      evt.data.dialog = "imagebutton";
                      break;
                    default:
                      evt.data.dialog = "textfield";
                      break;
                  }
                }
              }
            }
          }
        }
      });
    },
    afterInit : function(editor) {
      var dataProcessor = editor.dataProcessor;
      var dataFilter = dataProcessor && dataProcessor.htmlFilter;
      var htmlFilter = dataProcessor && dataProcessor.dataFilter;
      if (href) {
        if (dataFilter) {
          dataFilter.addRules({
            elements : {
              input : function(input) {
                var attrs = input.attributes;
                var type = attrs.type;
                if (!type) {
                  attrs.type = "text";
                }
                if (type == "checkbox" || type == "radio") {
                  if (attrs.value == "on") {
                    delete attrs.value;
                  }
                }
              }
            }
          });
        }
      }
      if (htmlFilter) {
        htmlFilter.addRules({
          elements : {
            input : function(element) {
              if (element.attributes.type == "hidden") {
                return editor.createFakeParserElement(element, "cke_hidden", "hiddenfield");
              }
            }
          }
        });
      }
    },
    requires : ["image", "fakeobjects"]
  });
  if (href) {
    Node.prototype.hasAttribute = $.override(Node.prototype.hasAttribute, function(matcherFunction) {
      return function(name) {
        var self = this;
        var quoteNeeded = self.$.attributes.getNamedItem(name);
        if (self.getName() == "input") {
          switch(name) {
            case "class":
              return self.$.className.length > 0;
            case "checked":
              return!!self.$.checked;
            case "value":
              var elementType = self.getAttribute("type");
              return elementType == "checkbox" || elementType == "radio" ? self.$.value != "on" : self.$.value;
          }
        }
        return matcherFunction.apply(self, arguments);
      };
    });
  }
  (function() {
    var horizontalruleCmd = {
      canUndo : false,
      exec : function(editor) {
        var hr = editor.document.createElement("hr");
        editor.insertElement(hr);
      }
    };
    var optgroup = "horizontalrule";
    editor.add(optgroup, {
      init : function(editor) {
        editor.addCommand(optgroup, horizontalruleCmd);
        editor.ui.addButton("HorizontalRule", {
          label : editor.lang.horizontalrule,
          command : optgroup
        });
      }
    });
  })();
  (function() {
    function lastNoneSpaceChild(block) {
      var lastIndex = block.children.length;
      var element = block.children[lastIndex - 1];
      for (;element && (element.type == 3 && !$.trim(element.value));) {
        element = block.children[--lastIndex];
      }
      return element;
    }
    function trimFillers(block, fromSource) {
      var children = block.children;
      var lastChild = lastNoneSpaceChild(block);
      if (lastChild) {
        if ((fromSource || !href) && (lastChild.type == 1 && lastChild.name == "br")) {
          children.pop();
        }
        if (lastChild.type == 3 && tailNbspRegex.test(lastChild.value)) {
          children.pop();
        }
      }
    }
    function blockNeedsExtension(block, fromSource, extendEmptyBlock) {
      if (!fromSource && (!extendEmptyBlock || typeof extendEmptyBlock == "function" && extendEmptyBlock(block) === false)) {
        return false;
      }
      if (fromSource && (href && (document.documentMode > 7 || (block.name in dtd.tr || block.name in dtd.$listItem)))) {
        return false;
      }
      var lastChild = lastNoneSpaceChild(block);
      return!lastChild || lastChild && (lastChild.type == 1 && lastChild.name == "br" || block.name == "form" && lastChild.name == "input");
    }
    function getBlockExtension(isOutput, emptyBlockFiller) {
      return function(block) {
        trimFillers(block, !isOutput);
        if (blockNeedsExtension(block, !isOutput, emptyBlockFiller)) {
          if (isOutput || href) {
            block.add(new self.htmlParser.text("\u00a0"));
          } else {
            block.add(new self.htmlParser.element("br", {}));
          }
        }
      };
    }
    function protectReadOnly(element) {
      var attrs = element.attributes;
      if (attrs.contenteditable != "false") {
        attrs["data-cke-editable"] = attrs.contenteditable ? "true" : 1;
      }
      attrs.contenteditable = "false";
    }
    function unprotectReadyOnly(element) {
      var attrs = element.attributes;
      switch(attrs["data-cke-editable"]) {
        case "true":
          attrs.contenteditable = "true";
          break;
        case "1":
          delete attrs.contenteditable;
          break;
      }
    }
    function protectAttributes(body) {
      return body.replace(rvar, function(deepDataAndEvents, dataAndEvents, attributes) {
        return "<" + dataAndEvents + attributes.replace(optgroup, function(oid, attrName) {
          if (!/^on/.test(attrName) && attributes.indexOf("data-cke-saved-" + attrName) == -1) {
            return " data-cke-saved-" + oid + " data-cke-" + self.rnd + "-" + oid;
          }
          return oid;
        }) + ">";
      });
    }
    function protectElements(html) {
      return html.replace(vvarText, function(sectionName) {
        return "<cke:encoded>" + encodeURIComponent(sectionName) + "</cke:encoded>";
      });
    }
    function unprotectElements(html) {
      return html.replace(vvar, function(dataAndEvents, part) {
        return decodeURIComponent(part);
      });
    }
    function protectSelfClosingElements(html) {
      return html.replace(name, "$1cke:$2");
    }
    function unprotectElementNames(value) {
      return value.replace(elem, "$1$2");
    }
    function protectElementsNames(html) {
      return html.replace(paths, "<cke:$1$2></cke:$1>");
    }
    function protectPreFormatted(html) {
      return html.replace(/(<pre\b[^>]*>)(\r\n|\n)/g, "$1$2$2");
    }
    function protectRealComments(fmt) {
      return fmt.replace(/\x3c!--(?!{cke_protected})[\s\S]+?--\x3e/g, function(sKey) {
        return "\x3c!--" + op + "{C}" + encodeURIComponent(sKey).replace(/--/g, "%2D%2D") + "--\x3e";
      });
    }
    function unprotectRealComments(fmt) {
      return fmt.replace(/\x3c!--\{cke_protected\}\{C\}([\s\S]+?)--\x3e/g, function(dataAndEvents, part) {
        return decodeURIComponent(part);
      });
    }
    function unprotectSource(fmt, editor) {
      var store = editor._.dataStore;
      return fmt.replace(/\x3c!--\{cke_protected\}([\s\S]+?)--\x3e/g, function(dataAndEvents, part) {
        return decodeURIComponent(part);
      }).replace(/\{cke_protected_(\d+)\}/g, function(dataAndEvents, id) {
        return store && store[id] || "";
      });
    }
    function protectSource(options, editor) {
      var args = [];
      var caseSensitive = editor.config.protectedSource;
      var store = editor._.dataStore || (editor._.dataStore = {
        id : 1
      });
      var optgroup = /<\!--\{cke_temp(comment)?\}(\d*?)--\x3e/g;
      var codeSegments = [/<script[\s\S]*?<\/script>/gi, /<noscript[\s\S]*?<\/noscript>/gi].concat(caseSensitive);
      options = options.replace(/\x3c!--[\s\S]*?--\x3e/g, function(arg) {
        return "\x3c!--{cke_tempcomment}" + (args.push(arg) - 1) + "--\x3e";
      });
      var i = 0;
      for (;i < codeSegments.length;i++) {
        options = options.replace(codeSegments[i], function(part) {
          part = part.replace(optgroup, function(dataAndEvents, deepDataAndEvents, desiredNonCommentArgIndex) {
            return args[desiredNonCommentArgIndex];
          });
          return/cke_temp(comment)?/.test(part) ? part : "\x3c!--{cke_temp}" + (args.push(part) - 1) + "--\x3e";
        });
      }
      options = options.replace(optgroup, function(dataAndEvents, state, paramName) {
        return "\x3c!--" + op + (state ? "{C}" : "") + encodeURIComponent(args[paramName]).replace(/--/g, "%2D%2D") + "--\x3e";
      });
      return options.replace(/(['"]).*?\1/g, function(messageFormat) {
        return messageFormat.replace(/\x3c!--\{cke_protected\}([\s\S]+?)--\x3e/g, function(dataAndEvents, data) {
          store[store.id] = decodeURIComponent(data);
          return "{cke_protected_" + store.id++ + "}";
        });
      });
    }
    var tailNbspRegex = /^[\t\r\n ]*(?:&nbsp;|\xa0)$/;
    var op = "{cke_protected}";
    var inst = dtd;
    var tableOrder = ["caption", "colgroup", "col", "thead", "tfoot", "tbody"];
    var blockLikeTags = $.extend({}, inst.$block, inst.$listItem, inst.$tableContent);
    var i;
    for (i in blockLikeTags) {
      if (!("br" in inst[i])) {
        delete blockLikeTags[i];
      }
    }
    delete blockLikeTags.pre;
    var defaultDataFilterRules = {
      elements : {},
      attributeNames : [[/^on/, "data-cke-pa-on"]]
    };
    var defaultDataBlockFilterRules = {
      elements : {}
    };
    for (i in blockLikeTags) {
      defaultDataBlockFilterRules.elements[i] = getBlockExtension();
    }
    var defaultHtmlFilterRules = {
      elementNames : [[/^cke:/, ""], [/^\?xml:namespace$/, ""]],
      attributeNames : [[/^data-cke-(saved|pa)-/, ""], [/^data-cke-.*/, ""], ["hidefocus", ""]],
      elements : {
        $ : function(name) {
          var attribs = name.attributes;
          if (attribs) {
            if (attribs["data-cke-temp"]) {
              return false;
            }
            var attributeNames = ["name", "href", "src"];
            var savedAttributeName;
            var i = 0;
            for (;i < attributeNames.length;i++) {
              savedAttributeName = "data-cke-saved-" + attributeNames[i];
              if (savedAttributeName in attribs) {
                delete attribs[attributeNames[i]];
              }
            }
          }
          return name;
        },
        table : function(container) {
          var children = container.children;
          children.sort(function(b, a) {
            return b.type == 1 && a.type == b.type ? $.indexOf(tableOrder, b.name) > $.indexOf(tableOrder, a.name) ? 1 : -1 : 0;
          });
        },
        embed : function(element) {
          var parent = element.parent;
          if (parent && parent.name == "object") {
            var originalWidth = parent.attributes.width;
            var parentHeight = parent.attributes.height;
            if (originalWidth) {
              element.attributes.width = originalWidth;
            }
            if (parentHeight) {
              element.attributes.height = parentHeight;
            }
          }
        },
        param : function(param) {
          param.children = [];
          param.isEmpty = true;
          return param;
        },
        a : function(element) {
          if (!(element.children.length || (element.attributes.name || element.attributes["data-cke-saved-name"]))) {
            return false;
          }
        },
        span : function(name) {
          if (name.attributes["class"] == "Apple-style-span") {
            delete name.name;
          }
        },
        pre : function(element) {
          if (href) {
            trimFillers(element);
          }
        },
        html : function(name) {
          delete name.attributes.contenteditable;
          delete name.attributes["class"];
        },
        body : function(name) {
          delete name.attributes.spellcheck;
          delete name.attributes.contenteditable;
        },
        style : function(name) {
          var element = name.children[0];
          if (element) {
            if (element.value) {
              element.value = $.trim(element.value);
            }
          }
          if (!name.attributes.type) {
            name.attributes.type = "text/css";
          }
        },
        title : function(name) {
          var textarea = name.children[0];
          if (textarea) {
            textarea.value = name.attributes["data-cke-title"] || "";
          }
        }
      },
      attributes : {
        "class" : function(value, element) {
          return $.ltrim(value.replace(/(?:^|\s+)cke_[^\s]*/g, "")) || false;
        }
      }
    };
    if (href) {
      defaultHtmlFilterRules.attributes.style = function(name, value) {
        return name.replace(/(^|;)([^\:]+)/g, function(m3) {
          return m3.toLowerCase();
        });
      };
    }
    for (i in{
      input : 1,
      textarea : 1
    }) {
      defaultDataFilterRules.elements[i] = protectReadOnly;
      defaultHtmlFilterRules.elements[i] = unprotectReadyOnly;
    }
    var rvar = /<(a|area|img|input)\b([^>]*)>/gi;
    var optgroup = /\b(on\w+|href|src|name)\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|(?:[^ "'>]+))/gi;
    var vvarText = /(?:<style(?=[ >])[^>]*>[\s\S]*<\/style>)|(?:<(:?link|meta|base)[^>]*>)/gi;
    var vvar = /<cke:encoded>([^<]*)<\/cke:encoded>/gi;
    var name = /(<\/?)((?:object|embed|param|html|body|head|title)[^>]*>)/gi;
    var elem = /(<\/?)cke:((?:html|body|head|title)[^>]*>)/gi;
    var paths = /<cke:(param|embed)([^>]*?)\/?>(?!\s*<\/cke:\1)/gi;
    editor.add("htmldataprocessor", {
      requires : ["htmlwriter"],
      init : function(editor) {
        var dataProcessor = editor.dataProcessor = new self.htmlDataProcessor(editor);
        dataProcessor.writer.forceSimpleAmpersand = editor.config.forceSimpleAmpersand;
        dataProcessor.dataFilter.addRules(defaultDataFilterRules);
        dataProcessor.dataFilter.addRules(defaultDataBlockFilterRules);
        dataProcessor.htmlFilter.addRules(defaultHtmlFilterRules);
        var defaultListHtmlFilterRules = {
          elements : {}
        };
        for (i in blockLikeTags) {
          defaultListHtmlFilterRules.elements[i] = getBlockExtension(true, editor.config.fillEmptyBlocks);
        }
        dataProcessor.htmlFilter.addRules(defaultListHtmlFilterRules);
      },
      onLoad : function() {
        if (!("fillEmptyBlocks" in config)) {
          config.fillEmptyBlocks = 1;
        }
      }
    });
    self.htmlDataProcessor = function(editor) {
      var that = this;
      that.editor = editor;
      that.writer = new self.htmlWriter;
      that.dataFilter = new self.htmlParser.filter;
      that.htmlFilter = new self.htmlParser.filter;
    };
    self.htmlDataProcessor.prototype = {
      toHtml : function(data, fixForBody) {
        data = protectSource(data, this.editor);
        data = protectAttributes(data);
        data = protectElements(data);
        data = protectSelfClosingElements(data);
        data = protectElementsNames(data);
        data = protectPreFormatted(data);
        var div = new Node("div");
        div.setHtml("a" + data);
        data = div.getHtml().substr(1);
        data = data.replace(new RegExp(" data-cke-" + self.rnd + "-", "ig"), " ");
        data = unprotectElementNames(data);
        data = unprotectElements(data);
        data = unprotectRealComments(data);
        var fragment = self.htmlParser.fragment.fromHtml(data, fixForBody);
        var writer = new self.htmlParser.basicWriter;
        fragment.writeHtml(writer, this.dataFilter);
        data = writer.getHtml(true);
        data = protectRealComments(data);
        return data;
      },
      toDataFormat : function(html, fixForBody) {
        var writer = this.writer;
        var fragment = self.htmlParser.fragment.fromHtml(html, fixForBody);
        writer.reset();
        fragment.writeHtml(writer, this.htmlFilter);
        var data = writer.getHtml(true);
        data = unprotectRealComments(data);
        data = unprotectSource(data, this.editor);
        return data;
      }
    };
  })();
  (function() {
    editor.add("iframe", {
      requires : ["dialog", "fakeobjects"],
      init : function(editor) {
        var optgroup = "iframe";
        var lang = editor.lang.iframe;
        self.dialog.add(optgroup, this.path + "dialogs/iframe.js");
        editor.addCommand(optgroup, new self.dialogCommand(optgroup));
        editor.addCss("img.cke_iframe{background-image: url(" + self.getUrl(this.path + "images/placeholder.png") + ");" + "background-position: center center;" + "background-repeat: no-repeat;" + "border: 1px solid #a9a9a9;" + "width: 80px;" + "height: 80px;" + "}");
        editor.ui.addButton("Iframe", {
          label : lang.toolbar,
          command : optgroup
        });
        editor.on("doubleclick", function(evt) {
          var element = evt.data.element;
          if (element.is("img") && element.data("cke-real-element-type") == "iframe") {
            evt.data.dialog = "iframe";
          }
        });
        if (editor.addMenuItems) {
          editor.addMenuItems({
            iframe : {
              label : lang.title,
              command : "iframe",
              group : "image"
            }
          });
        }
        if (editor.contextMenu) {
          editor.contextMenu.addListener(function(element, dataAndEvents) {
            if (element && (element.is("img") && element.data("cke-real-element-type") == "iframe")) {
              return{
                iframe : 2
              };
            }
          });
        }
      },
      afterInit : function(editor) {
        var dataProcessor = editor.dataProcessor;
        var dataFilter = dataProcessor && dataProcessor.dataFilter;
        if (dataFilter) {
          dataFilter.addRules({
            elements : {
              iframe : function(name) {
                return editor.createFakeParserElement(name, "cke_iframe", "iframe", true);
              }
            }
          });
        }
      }
    });
  })();
  (function() {
    function getSelectedImage(editor, element) {
      if (!element) {
        var sel = editor.getSelection();
        element = sel.getType() == 3 && sel.getSelectedElement();
      }
      if (element && (element.is("img") && (!element.data("cke-realelement") && !element.isReadOnly()))) {
        return element;
      }
    }
    function getImageAlignment(element) {
      var align = element.getStyle("float");
      if (align == "inherit" || align == "none") {
        align = 0;
      }
      if (!align) {
        align = element.getAttribute("align");
      }
      return align;
    }
    editor.add("image", {
      requires : ["dialog"],
      init : function(editor) {
        var optgroup = "image";
        self.dialog.add(optgroup, this.path + "dialogs/image.js");
        editor.addCommand(optgroup, new self.dialogCommand(optgroup));
        editor.ui.addButton("Image", {
          label : editor.lang.common.image,
          command : optgroup
        });
        editor.on("doubleclick", function(evt) {
          var element = evt.data.element;
          if (element.is("img") && (!element.data("cke-realelement") && !element.isReadOnly())) {
            evt.data.dialog = "image";
          }
        });
        if (editor.addMenuItems) {
          editor.addMenuItems({
            image : {
              label : editor.lang.image.menu,
              command : "image",
              group : "image"
            }
          });
        }
        if (editor.contextMenu) {
          editor.contextMenu.addListener(function(element, dataAndEvents) {
            if (getSelectedImage(editor, element)) {
              return{
                image : 2
              };
            }
          });
        }
      },
      afterInit : function(editor) {
        function setupAlignCommand(value) {
          var command = editor.getCommand("justify" + value);
          if (command) {
            if (value == "left" || value == "right") {
              command.on("exec", function(item) {
                var img = getSelectedImage(editor);
                var align;
                if (img) {
                  align = getImageAlignment(img);
                  if (align == value) {
                    img.removeStyle("float");
                    if (value == getImageAlignment(img)) {
                      img.removeAttribute("align");
                    }
                  } else {
                    img.setStyle("float", value);
                  }
                  item.cancel();
                }
              });
            }
            command.on("refresh", function(item) {
              var img = getSelectedImage(editor);
              var align;
              if (img) {
                align = getImageAlignment(img);
                this.setState(align == value ? 1 : value == "right" || value == "left" ? 2 : 0);
                item.cancel();
              }
            });
          }
        }
        setupAlignCommand("left");
        setupAlignCommand("right");
        setupAlignCommand("center");
        setupAlignCommand("block");
      }
    });
  })();
  config.image_removeLinkByEmptyURL = true;
  (function() {
    function onSelectionChange(evt) {
      var self = this;
      if (evt.editor.readOnly) {
        return null;
      }
      var editor = evt.editor;
      var elementPath = evt.data.path;
      var list = elementPath && elementPath.contains(listNodeNames);
      var firstBlock = elementPath.block || elementPath.blockLimit;
      if (list) {
        return self.setState(2);
      }
      if (!self.useIndentClasses && self.name == "indent") {
        return self.setState(2);
      }
      if (!firstBlock) {
        return self.setState(0);
      }
      if (self.useIndentClasses) {
        var indentClass = firstBlock.$.className.match(self.classNameRegex);
        var indentStep = 0;
        if (indentClass) {
          indentClass = indentClass[1];
          indentStep = self.indentClassMap[indentClass];
        }
        if (self.name == "outdent" && !indentStep || self.name == "indent" && indentStep == editor.config.indentClasses.length) {
          return self.setState(0);
        }
        return self.setState(2);
      } else {
        var num2 = parseInt(firstBlock.getStyle(getIndentCssProperty(firstBlock)), 10);
        if (isNaN(num2)) {
          num2 = 0;
        }
        if (num2 <= 0) {
          return self.setState(0);
        }
        return self.setState(2);
      }
    }
    function indentCommand(editor, name) {
      var self = this;
      self.name = name;
      self.useIndentClasses = editor.config.indentClasses && editor.config.indentClasses.length > 0;
      if (self.useIndentClasses) {
        self.classNameRegex = new RegExp("(?:^|\\s+)(" + editor.config.indentClasses.join("|") + ")(?=$|\\s)");
        self.indentClassMap = {};
        var i = 0;
        for (;i < editor.config.indentClasses.length;i++) {
          self.indentClassMap[editor.config.indentClasses[i]] = i + 1;
        }
      }
      self.startDisabled = name == "outdent";
    }
    function getIndentCssProperty(element, dir) {
      return(dir || element.getComputedStyle("direction")) == "ltr" ? "margin-left" : "margin-right";
    }
    function isListItem(node) {
      return node.type == 1 && node.is("li");
    }
    var listNodeNames = {
      ol : 1,
      ul : 1
    };
    var isNotWhitespaces = dom.walker.whitespaces(true);
    var isNotBookmark = dom.walker.bookmark(false, true);
    indentCommand.prototype = {
      exec : function(str) {
        function indentList(optgroup) {
          var startContainer = range.startContainer;
          var node = range.endContainer;
          for (;startContainer && !startContainer.getParent().equals(optgroup);) {
            startContainer = startContainer.getParent();
          }
          for (;node && !node.getParent().equals(optgroup);) {
            node = node.getParent();
          }
          if (!startContainer || !node) {
            return;
          }
          var block = startContainer;
          var itemsToMove = [];
          var R = false;
          for (;!R;) {
            if (block.equals(node)) {
              R = true;
            }
            itemsToMove.push(block);
            block = block.getNext();
          }
          if (itemsToMove.length < 1) {
            return;
          }
          var codeSegments = optgroup.getParents(true);
          var i = 0;
          for (;i < codeSegments.length;i++) {
            if (codeSegments[i].getName && listNodeNames[codeSegments[i].getName()]) {
              optgroup = codeSegments[i];
              break;
            }
          }
          var indentOffset = self.name == "indent" ? 1 : -1;
          var startItem = itemsToMove[0];
          var lastItem = itemsToMove[itemsToMove.length - 1];
          var listArray = editor.list.listToArray(optgroup, database);
          var baseIndent = listArray[lastItem.getCustomData("listarray_index")].indent;
          i = startItem.getCustomData("listarray_index");
          for (;i <= lastItem.getCustomData("listarray_index");i++) {
            listArray[i].indent += indentOffset;
            if (indentOffset > 0) {
              var listRoot = listArray[i].parent;
              listArray[i].parent = new Node(listRoot.getName(), listRoot.getDocument());
            }
          }
          i = lastItem.getCustomData("listarray_index") + 1;
          for (;i < listArray.length && listArray[i].indent > baseIndent;i++) {
            listArray[i].indent += indentOffset;
          }
          var newList = editor.list.arrayToList(listArray, database, null, str.config.enterMode, optgroup.getDirection());
          if (self.name == "outdent") {
            var rvar;
            if ((rvar = optgroup.getParent()) && rvar.is("li")) {
              var trs = newList.listNode.getChildren();
              var pendingList = [];
              var count = trs.count();
              var child;
              i = count - 1;
              for (;i >= 0;i--) {
                if ((child = trs.getItem(i)) && (child.is && child.is("li"))) {
                  pendingList.push(child);
                }
              }
            }
          }
          if (newList) {
            newList.listNode.replace(optgroup);
          }
          if (pendingList && pendingList.length) {
            i = 0;
            for (;i < pendingList.length;i++) {
              var li = pendingList[i];
              var followingList = li;
              for (;(followingList = followingList.getNext()) && (followingList.is && followingList.getName() in listNodeNames);) {
                if (href && !li.getFirst(function(node) {
                  return isNotWhitespaces(node) && isNotBookmark(node);
                })) {
                  li.append(range.document.createText("\u00a0"));
                }
                li.append(followingList);
              }
              li.insertAfter(rvar);
            }
          }
        }
        function indentBlock() {
          var iterator = range.createIterator();
          var enterMode = str.config.enterMode;
          iterator.enforceRealBlocks = true;
          iterator.enlargeBr = enterMode != 2;
          var activeClassName;
          for (;activeClassName = iterator.getNextParagraph(enterMode == 1 ? "p" : "div");) {
            indentElement(activeClassName);
          }
        }
        function indentElement(element, dir) {
          if (element.getCustomData("indent_processed")) {
            return false;
          }
          if (self.useIndentClasses) {
            var indentClass = element.$.className.match(self.classNameRegex);
            var indentStep = 0;
            if (indentClass) {
              indentClass = indentClass[1];
              indentStep = self.indentClassMap[indentClass];
            }
            if (self.name == "outdent") {
              indentStep--;
            } else {
              indentStep++;
            }
            if (indentStep < 0) {
              return false;
            }
            indentStep = Math.min(indentStep, str.config.indentClasses.length);
            indentStep = Math.max(indentStep, 0);
            element.$.className = $.ltrim(element.$.className.replace(self.classNameRegex, ""));
            if (indentStep > 0) {
              element.addClass(str.config.indentClasses[indentStep - 1]);
            }
          } else {
            var name = getIndentCssProperty(element, dir);
            var currentOffset = parseInt(element.getStyle(name), 10);
            if (isNaN(currentOffset)) {
              currentOffset = 0;
            }
            var INDENT_OFFSET = str.config.indentOffset || 40;
            currentOffset += (self.name == "indent" ? 1 : -1) * INDENT_OFFSET;
            if (currentOffset < 0) {
              return false;
            }
            currentOffset = Math.max(currentOffset, 0);
            currentOffset = Math.ceil(currentOffset / INDENT_OFFSET) * INDENT_OFFSET;
            element.setStyle(name, currentOffset ? currentOffset + (str.config.indentUnit || "px") : "");
            if (element.getAttribute("style") === "") {
              element.removeAttribute("style");
            }
          }
          Node.setMarker(database, element, "indent_processed", 1);
          return true;
        }
        var self = this;
        var database = {};
        var selection = str.getSelection();
        var bookmarks = selection.createBookmarks(1);
        var ranges = selection && selection.getRanges(1);
        var range;
        var iterator = ranges.createIterator();
        for (;range = iterator.getNextRange();) {
          var rangeRoot = range.getCommonAncestor();
          var nearestListBlock = rangeRoot;
          for (;nearestListBlock && !(nearestListBlock.type == 1 && listNodeNames[nearestListBlock.getName()]);) {
            nearestListBlock = nearestListBlock.getParent();
          }
          if (!nearestListBlock) {
            var selectedNode = range.getEnclosedNode();
            if (selectedNode && (selectedNode.type == 1 && selectedNode.getName() in listNodeNames)) {
              range.setStartAt(selectedNode, 1);
              range.setEndAt(selectedNode, 2);
              nearestListBlock = selectedNode;
            }
          }
          if (nearestListBlock && (range.startContainer.type == 1 && range.startContainer.getName() in listNodeNames)) {
            var walker = new dom.walker(range);
            walker.evaluator = isListItem;
            range.startContainer = walker.next();
          }
          if (nearestListBlock && (range.endContainer.type == 1 && range.endContainer.getName() in listNodeNames)) {
            walker = new dom.walker(range);
            walker.evaluator = isListItem;
            range.endContainer = walker.previous();
          }
          if (nearestListBlock) {
            var firstListItem = nearestListBlock.getFirst(isListItem);
            var J = !!firstListItem.getNext(isListItem);
            var from = range.startContainer;
            var L = firstListItem.equals(from) || firstListItem.contains(from);
            if (!(L && ((self.name == "indent" || (self.useIndentClasses || parseInt(nearestListBlock.getStyle(getIndentCssProperty(nearestListBlock)), 10))) && indentElement(nearestListBlock, !J && firstListItem.getDirection())))) {
              indentList(nearestListBlock);
            }
          } else {
            indentBlock();
          }
        }
        Node.clearAllMarkers(database);
        str.forceNextSelectionCheck();
        selection.selectBookmarks(bookmarks);
      }
    };
    editor.add("indent", {
      init : function(editor) {
        var center = editor.addCommand("indent", new indentCommand(editor, "indent"));
        var right = editor.addCommand("outdent", new indentCommand(editor, "outdent"));
        editor.ui.addButton("Indent", {
          label : editor.lang.indent,
          command : "indent"
        });
        editor.ui.addButton("Outdent", {
          label : editor.lang.outdent,
          command : "outdent"
        });
        editor.on("selectionChange", $.bind(onSelectionChange, center));
        editor.on("selectionChange", $.bind(onSelectionChange, right));
        if (env.ie6Compat || env.ie7Compat) {
          editor.addCss("ul,ol{\tmargin-left: 0px;\tpadding-left: 40px;}");
        }
        editor.on("dirChanged", function(e) {
          var range = new dom.range(editor.document);
          range.setStartBefore(e.data.node);
          range.setEndAfter(e.data.node);
          var walker = new dom.walker(range);
          var node;
          for (;node = walker.next();) {
            if (node.type == 1) {
              if (!node.equals(e.data.node) && node.getDirection()) {
                range.setStartAfter(node);
                walker = new dom.walker(range);
                continue;
              }
              var codeSegments = editor.config.indentClasses;
              if (codeSegments) {
                var curr = e.data.dir == "ltr" ? ["_rtl", ""] : ["", "_rtl"];
                var i = 0;
                for (;i < codeSegments.length;i++) {
                  if (node.hasClass(codeSegments[i] + curr[0])) {
                    node.removeClass(codeSegments[i] + curr[0]);
                    node.addClass(codeSegments[i] + curr[1]);
                  }
                }
              }
              var marginLeft = node.getStyle("margin-right");
              var marginRight = node.getStyle("margin-left");
              if (marginLeft) {
                node.setStyle("margin-left", marginLeft);
              } else {
                node.removeStyle("margin-left");
              }
              if (marginRight) {
                node.setStyle("margin-right", marginRight);
              } else {
                node.removeStyle("margin-right");
              }
            }
          }
        });
      },
      requires : ["domiterator", "list"]
    });
  })();
  (function() {
    function getAlignment(element, useComputedState) {
      useComputedState = useComputedState === undefined || useComputedState;
      var align;
      if (useComputedState) {
        align = element.getComputedStyle("text-align");
      } else {
        for (;!element.hasAttribute || !(element.hasAttribute("align") || element.getStyle("text-align"));) {
          var suppressDisabledCheck = element.getParent();
          if (!suppressDisabledCheck) {
            break;
          }
          element = suppressDisabledCheck;
        }
        align = element.getStyle("text-align") || (element.getAttribute("align") || "");
      }
      if (align) {
        align = align.replace(/(?:-(?:moz|webkit)-)?(?:start|auto)/i, "");
      }
      if (!align) {
        if (useComputedState) {
          align = element.getComputedStyle("direction") == "rtl" ? "right" : "left";
        }
      }
      return align;
    }
    function onSelectionChange(evt) {
      if (evt.editor.readOnly) {
        return;
      }
      evt.editor.getCommand(this.name).refresh(evt.data.path);
    }
    function justifyCommand(editor, name, value) {
      var self = this;
      self.editor = editor;
      self.name = name;
      self.value = value;
      var params = editor.config.justifyClasses;
      if (params) {
        switch(value) {
          case "left":
            self.cssClassName = params[0];
            break;
          case "center":
            self.cssClassName = params[1];
            break;
          case "right":
            self.cssClassName = params[2];
            break;
          case "justify":
            self.cssClassName = params[3];
            break;
        }
        self.cssClassRegex = new RegExp("(?:^|\\s+)(?:" + params.join("|") + ")(?=$|\\s)");
      }
    }
    function onDirChanged(e) {
      var editor = e.editor;
      var range = new dom.range(editor.document);
      range.setStartBefore(e.data.node);
      range.setEndAfter(e.data.node);
      var walker = new dom.walker(range);
      var node;
      for (;node = walker.next();) {
        if (node.type == 1) {
          if (!node.equals(e.data.node) && node.getDirection()) {
            range.setStartAfter(node);
            walker = new dom.walker(range);
            continue;
          }
          var classes = editor.config.justifyClasses;
          if (classes) {
            if (node.hasClass(classes[0])) {
              node.removeClass(classes[0]);
              node.addClass(classes[2]);
            } else {
              if (node.hasClass(classes[2])) {
                node.removeClass(classes[2]);
                node.addClass(classes[0]);
              }
            }
          }
          var name = "text-align";
          var value = node.getStyle(name);
          if (value == "left") {
            node.setStyle(name, "right");
          } else {
            if (value == "right") {
              node.setStyle(name, "left");
            }
          }
        }
      }
    }
    justifyCommand.prototype = {
      exec : function(editor) {
        var info = this;
        var selection = editor.getSelection();
        var enterMode = editor.config.enterMode;
        if (!selection) {
          return;
        }
        var bookmarks = selection.createBookmarks();
        var codeSegments = selection.getRanges(true);
        var node = info.cssClassName;
        var iterator;
        var block;
        var useComputedState = editor.config.useComputedState;
        useComputedState = useComputedState === undefined || useComputedState;
        var i = codeSegments.length - 1;
        for (;i >= 0;i--) {
          iterator = codeSegments[i].createIterator();
          iterator.enlargeBr = enterMode != 2;
          for (;block = iterator.getNextParagraph(enterMode == 1 ? "p" : "div");) {
            block.removeAttribute("align");
            block.removeStyle("text-align");
            var p = node && (block.$.className = $.ltrim(block.$.className.replace(info.cssClassRegex, "")));
            var B = info.state == 2 && (!useComputedState || getAlignment(block, true) != info.value);
            if (node) {
              if (B) {
                block.addClass(node);
              } else {
                if (!p) {
                  block.removeAttribute("class");
                }
              }
            } else {
              if (B) {
                block.setStyle("text-align", info.value);
              }
            }
          }
        }
        editor.focus();
        editor.forceNextSelectionCheck();
        selection.selectBookmarks(bookmarks);
      },
      refresh : function(editor) {
        var firstBlock = editor.block || editor.blockLimit;
        this.setState(firstBlock.getName() != "body" && getAlignment(firstBlock, this.editor.config.useComputedState) == this.value ? 1 : 2);
      }
    };
    editor.add("justify", {
      init : function(editor) {
        var left = new justifyCommand(editor, "justifyleft", "left");
        var center = new justifyCommand(editor, "justifycenter", "center");
        var right = new justifyCommand(editor, "justifyright", "right");
        var justify = new justifyCommand(editor, "justifyblock", "justify");
        editor.addCommand("justifyleft", left);
        editor.addCommand("justifycenter", center);
        editor.addCommand("justifyright", right);
        editor.addCommand("justifyblock", justify);
        editor.ui.addButton("JustifyLeft", {
          label : editor.lang.justify.left,
          command : "justifyleft"
        });
        editor.ui.addButton("JustifyCenter", {
          label : editor.lang.justify.center,
          command : "justifycenter"
        });
        editor.ui.addButton("JustifyRight", {
          label : editor.lang.justify.right,
          command : "justifyright"
        });
        editor.ui.addButton("JustifyBlock", {
          label : editor.lang.justify.block,
          command : "justifyblock"
        });
        editor.on("selectionChange", $.bind(onSelectionChange, left));
        editor.on("selectionChange", $.bind(onSelectionChange, right));
        editor.on("selectionChange", $.bind(onSelectionChange, center));
        editor.on("selectionChange", $.bind(onSelectionChange, justify));
        editor.on("dirChanged", onDirChanged);
      },
      requires : ["domiterator"]
    });
  })();
  editor.add("keystrokes", {
    beforeInit : function(editor) {
      editor.keystrokeHandler = new self.keystrokeHandler(editor);
      editor.specialKeys = {};
    },
    init : function(editor) {
      var resultItems = editor.config.keystrokes;
      var codeSegments = editor.config.blockedKeystrokes;
      var keystrokes = editor.keystrokeHandler.keystrokes;
      var blockedKeystrokes = editor.keystrokeHandler.blockedKeystrokes;
      var i = 0;
      for (;i < resultItems.length;i++) {
        keystrokes[resultItems[i][0]] = resultItems[i][1];
      }
      i = 0;
      for (;i < codeSegments.length;i++) {
        blockedKeystrokes[codeSegments[i]] = 1;
      }
    }
  });
  self.keystrokeHandler = function(editor) {
    var cursor = this;
    if (editor.keystrokeHandler) {
      return editor.keystrokeHandler;
    }
    cursor.keystrokes = {};
    cursor.blockedKeystrokes = {};
    cursor._ = {
      editor : editor
    };
    return cursor;
  };
  (function() {
    var cancel;
    var onKeyDown = function(ev) {
      ev = ev.data;
      var keyCombination = ev.getKeystroke();
      var command = this.keystrokes[keyCombination];
      var editor = this._.editor;
      cancel = editor.fire("key", {
        keyCode : keyCombination
      }) === true;
      if (!cancel) {
        if (command) {
          var data = {
            from : "keystrokeHandler"
          };
          cancel = editor.execCommand(command, data) !== false;
        }
        if (!cancel) {
          var handler = editor.specialKeys[keyCombination];
          cancel = handler && handler(editor) === true;
          if (!cancel) {
            cancel = !!this.blockedKeystrokes[keyCombination];
          }
        }
      }
      if (cancel) {
        ev.preventDefault(true);
      }
      return!cancel;
    };
    var handleMouseUp = function(ev) {
      if (cancel) {
        cancel = false;
        ev.data.preventDefault(true);
      }
    };
    self.keystrokeHandler.prototype = {
      attach : function(element) {
        element.on("keydown", onKeyDown, this);
        if (env.opera || env.gecko && env.mac) {
          element.on("keypress", handleMouseUp, this);
        }
      }
    };
  })();
  config.blockedKeystrokes = [1114112 + 66, 1114112 + 73, 1114112 + 85];
  config.keystrokes = [[4456448 + 121, "toolbarFocus"], [4456448 + 122, "elementsPathFocus"], [2228224 + 121, "contextMenu"], [1114112 + 2228224 + 121, "contextMenu"], [1114112 + 90, "undo"], [1114112 + 89, "redo"], [1114112 + 2228224 + 90, "redo"], [1114112 + 76, "link"], [1114112 + 66, "bold"], [1114112 + 73, "italic"], [1114112 + 85, "underline"], [4456448 + (href || env.webkit ? 189 : 109), "toolbarCollapse"], [4456448 + 48, "a11yHelp"]];
  editor.add("link", {
    requires : ["fakeobjects", "dialog"],
    init : function(data) {
      data.addCommand("link", new self.dialogCommand("link"));
      data.addCommand("anchor", new self.dialogCommand("anchor"));
      data.addCommand("unlink", new self.unlinkCommand);
      data.addCommand("removeAnchor", new self.removeAnchorCommand);
      data.ui.addButton("Link", {
        label : data.lang.link.toolbar,
        command : "link"
      });
      data.ui.addButton("Unlink", {
        label : data.lang.unlink,
        command : "unlink"
      });
      data.ui.addButton("Anchor", {
        label : data.lang.anchor.toolbar,
        command : "anchor"
      });
      self.dialog.add("link", this.path + "dialogs/link.js");
      self.dialog.add("anchor", this.path + "dialogs/anchor.js");
      var side = data.lang.dir == "rtl" ? "right" : "left";
      var basicCss = "background:url(" + self.getUrl(this.path + "images/anchor.gif") + ") no-repeat " + side + " center;" + "border:1px dotted #00f;";
      data.addCss("a.cke_anchor,a.cke_anchor_empty" + (href && env.version < 7 ? "" : ",a[name],a[data-cke-saved-name]") + "{" + basicCss + "padding-" + side + ":18px;" + "cursor:auto;" + "}" + (href ? "a.cke_anchor_empty{display:inline-block;}" : "") + "img.cke_anchor" + "{" + basicCss + "width:16px;" + "min-height:15px;" + "height:1.15em;" + "vertical-align:" + (env.opera ? "middle" : "text-bottom") + ";" + "}");
      data.on("selectionChange", function(evt) {
        if (data.readOnly) {
          return;
        }
        var command = data.getCommand("unlink");
        var element = evt.data.path.lastElement && evt.data.path.lastElement.getAscendant("a", true);
        if (element && (element.getName() == "a" && (element.getAttribute("href") && element.getChildCount()))) {
          command.setState(2);
        } else {
          command.setState(0);
        }
      });
      data.on("doubleclick", function(evt) {
        var element = editor.link.getSelectedLink(data) || evt.data.element;
        if (!element.isReadOnly()) {
          if (element.is("a")) {
            evt.data.dialog = element.getAttribute("name") && (!element.getAttribute("href") || !element.getChildCount()) ? "anchor" : "link";
            data.getSelection().selectElement(element);
          } else {
            if (editor.link.tryRestoreFakeAnchor(data, element)) {
              evt.data.dialog = "anchor";
            }
          }
        }
      });
      if (data.addMenuItems) {
        data.addMenuItems({
          anchor : {
            label : data.lang.anchor.menu,
            command : "anchor",
            group : "anchor",
            order : 1
          },
          removeAnchor : {
            label : data.lang.anchor.remove,
            command : "removeAnchor",
            group : "anchor",
            order : 5
          },
          link : {
            label : data.lang.link.menu,
            command : "link",
            group : "link",
            order : 1
          },
          unlink : {
            label : data.lang.unlink,
            command : "unlink",
            group : "link",
            order : 5
          }
        });
      }
      if (data.contextMenu) {
        data.contextMenu.addListener(function(element, dataAndEvents) {
          if (!element || element.isReadOnly()) {
            return null;
          }
          var node = editor.link.tryRestoreFakeAnchor(data, element);
          if (!node && !(node = editor.link.getSelectedLink(data))) {
            return null;
          }
          var menu = {};
          if (node.getAttribute("href") && node.getChildCount()) {
            menu = {
              link : 2,
              unlink : 2
            };
          }
          if (node && node.hasAttribute("name")) {
            menu.anchor = menu.removeAnchor = 2;
          }
          return menu;
        });
      }
    },
    afterInit : function(element) {
      var dataProcessor = element.dataProcessor;
      var dataFilter = dataProcessor && dataProcessor.dataFilter;
      var htmlFilter = dataProcessor && dataProcessor.htmlFilter;
      var eventPath = element._.elementsPath && element._.elementsPath.filters;
      if (dataFilter) {
        dataFilter.addRules({
          elements : {
            a : function(node) {
              var attributes = node.attributes;
              if (!attributes.name) {
                return null;
              }
              var isEmpty = !node.children.length;
              if (editor.link.synAnchorSelector) {
                var ieClass = isEmpty ? "cke_anchor_empty" : "cke_anchor";
                var cls = attributes["class"];
                if (attributes.name && (!cls || cls.indexOf(ieClass) < 0)) {
                  attributes["class"] = (cls || "") + " " + ieClass;
                }
                if (isEmpty && editor.link.emptyAnchorFix) {
                  attributes.contenteditable = "false";
                  attributes["data-cke-editable"] = 1;
                }
              } else {
                if (editor.link.fakeAnchor && isEmpty) {
                  return element.createFakeParserElement(node, "cke_anchor", "anchor");
                }
              }
              return null;
            }
          }
        });
      }
      if (editor.link.emptyAnchorFix && htmlFilter) {
        htmlFilter.addRules({
          elements : {
            a : function(element) {
              delete element.attributes.contenteditable;
            }
          }
        });
      }
      if (eventPath) {
        eventPath.push(function(anchor, el) {
          if (el == "a") {
            if (editor.link.tryRestoreFakeAnchor(element, anchor) || anchor.getAttribute("name") && (!anchor.getAttribute("href") || !anchor.getChildCount())) {
              return "anchor";
            }
          }
        });
      }
    }
  });
  editor.link = {
    getSelectedLink : function(editor) {
      try {
        var sel = editor.getSelection();
        if (sel.getType() == 3) {
          var selectedElement = sel.getSelectedElement();
          if (selectedElement.is("a")) {
            return selectedElement;
          }
        }
        var between = sel.getRanges(true)[0];
        between.shrink(2);
        var root = between.getCommonAncestor();
        return root.getAscendant("a", true);
      } catch (r) {
        return null;
      }
    },
    fakeAnchor : env.opera || env.webkit,
    synAnchorSelector : href,
    emptyAnchorFix : href && env.version < 8,
    tryRestoreFakeAnchor : function(editor, element) {
      if (element && (element.data("cke-real-element-type") && element.data("cke-real-element-type") == "anchor")) {
        var link = editor.restoreRealElement(element);
        if (link.data("cke-saved-name")) {
          return link;
        }
      }
    }
  };
  self.unlinkCommand = function() {
  };
  self.unlinkCommand.prototype = {
    exec : function(editor) {
      var selection = editor.getSelection();
      var bookmarks = selection.createBookmarks();
      var ranges = selection.getRanges();
      var root;
      var element;
      var i = 0;
      for (;i < ranges.length;i++) {
        root = ranges[i].getCommonAncestor(true);
        element = root.getAscendant("a", true);
        if (!element) {
          continue;
        }
        ranges[i].selectNodeContents(element);
      }
      selection.selectRanges(ranges);
      editor.document.$.execCommand("unlink", false, null);
      selection.selectBookmarks(bookmarks);
    },
    startDisabled : true
  };
  self.removeAnchorCommand = function() {
  };
  self.removeAnchorCommand.prototype = {
    exec : function(str) {
      var selection = str.getSelection();
      var bookmarks = selection.createBookmarks();
      var anchor;
      if (selection && ((anchor = selection.getSelectedElement()) && (editor.link.fakeAnchor && !anchor.getChildCount() ? editor.link.tryRestoreFakeAnchor(str, anchor) : anchor.is("a")))) {
        anchor.remove(1);
      } else {
        if (anchor = editor.link.getSelectedLink(str)) {
          if (anchor.hasAttribute("href")) {
            anchor.removeAttributes({
              name : 1,
              "data-cke-saved-name" : 1
            });
            anchor.removeClass("cke_anchor");
          } else {
            anchor.remove(1);
          }
        }
      }
      selection.selectBookmarks(bookmarks);
    }
  };
  $.extend(config, {
    linkShowAdvancedTab : true,
    linkShowTargetTab : true
  });
  (function() {
    function cleanUpDirection(element) {
      var i;
      var parent;
      var last;
      if (i = element.getDirection()) {
        parent = element.getParent();
        for (;parent && !(last = parent.getDirection());) {
          parent = parent.getParent();
        }
        if (i == last) {
          element.removeAttribute("dir");
        }
      }
    }
    function inheirtInlineStyles(parent, el) {
      var target = parent.getAttribute("style");
      if (target) {
        el.setAttribute("style", target.replace(/([^;])$/, "$1;") + (el.getAttribute("style") || ""));
      }
    }
    function onSelectionChange(evt) {
      if (evt.editor.readOnly) {
        return null;
      }
      var self = evt.data.path;
      var match = self.blockLimit;
      var nodes = self.elements;
      var node;
      var i;
      i = 0;
      for (;i < nodes.length && ((node = nodes[i]) && !node.equals(match));i++) {
        if (listNodeNames[nodes[i].getName()]) {
          return this.setState(this.type == nodes[i].getName() ? 1 : 2);
        }
      }
      return this.setState(2);
    }
    function changeListType(module, groupObj, database, listsCreated) {
      var listArray = editor.list.listToArray(groupObj.root, database);
      var selectedListItems = [];
      var i = 0;
      for (;i < groupObj.contents.length;i++) {
        var itemNode = groupObj.contents[i];
        itemNode = itemNode.getAscendant("li", true);
        if (!itemNode || itemNode.getCustomData("list_item_processed")) {
          continue;
        }
        selectedListItems.push(itemNode);
        Node.setMarker(database, itemNode, "list_item_processed", true);
      }
      var root = groupObj.root;
      var doc = root.getDocument();
      var listNode;
      var newListNode;
      i = 0;
      for (;i < selectedListItems.length;i++) {
        var listIndex = selectedListItems[i].getCustomData("listarray_index");
        listNode = listArray[listIndex].parent;
        if (!listNode.is(this.type)) {
          newListNode = doc.createElement(this.type);
          listNode.copyAttributes(newListNode, {
            start : 1,
            type : 1
          });
          newListNode.removeStyle("list-style-type");
          listArray[listIndex].parent = newListNode;
        }
      }
      var newList = editor.list.arrayToList(listArray, database, null, module.config.enterMode);
      var child;
      var length = newList.listNode.getChildCount();
      i = 0;
      for (;i < length && (child = newList.listNode.getChild(i));i++) {
        if (child.getName() == this.type) {
          listsCreated.push(child);
        }
      }
      newList.listNode.replace(groupObj.root);
    }
    function createList(editor, groupObj, local) {
      var contents = groupObj.contents;
      var doc = groupObj.root.getDocument();
      var listContents = [];
      if (contents.length == 1 && contents[0].equals(groupObj.root)) {
        var frag = doc.createElement("div");
        if (contents[0].moveChildren) {
          contents[0].moveChildren(frag);
        }
        contents[0].append(frag);
        contents[0] = frag;
      }
      var name = groupObj.contents[0].getParent();
      var i = 0;
      for (;i < contents.length;i++) {
        name = name.getCommonAncestor(contents[i].getParent());
      }
      var useComputedState = editor.config.useComputedState;
      var style;
      var Y;
      useComputedState = useComputedState === undefined || useComputedState;
      i = 0;
      for (;i < contents.length;i++) {
        var contentNode = contents[i];
        var frame;
        for (;frame = contentNode.getParent();) {
          if (frame.equals(name)) {
            listContents.push(contentNode);
            if (!Y && contentNode.getDirection()) {
              Y = 1;
            }
            var comment = contentNode.getDirection(useComputedState);
            if (style !== null) {
              if (style && style != comment) {
                style = null;
              } else {
                style = comment;
              }
            }
            break;
          }
          contentNode = frame;
        }
      }
      if (listContents.length < 1) {
        return;
      }
      var optgroup = listContents[listContents.length - 1].getNext();
      var container = doc.createElement(this.type);
      local.push(container);
      var contentBlock;
      var element;
      for (;listContents.length;) {
        contentBlock = listContents.shift();
        element = doc.createElement("li");
        if (contentBlock.is("pre") || rhtml.test(contentBlock.getName())) {
          contentBlock.appendTo(element);
        } else {
          contentBlock.copyAttributes(element);
          if (style && contentBlock.getDirection()) {
            element.removeStyle("direction");
            element.removeAttribute("dir");
          }
          contentBlock.moveChildren(element);
          contentBlock.remove();
        }
        element.appendTo(container);
      }
      if (style && Y) {
        container.setAttribute("dir", style);
      }
      if (optgroup) {
        container.insertBefore(optgroup);
      } else {
        container.appendTo(name);
      }
    }
    function removeList(GLOBAL, groupObj, database) {
      function compensateBrs(isStart) {
        if ((boundaryNode = docFragment[isStart ? "getFirst" : "getLast"]()) && (!(boundaryNode.is && boundaryNode.isBlockBoundary()) && ((siblingNode = groupObj.root[isStart ? "getPrevious" : "getNext"](dom.walker.whitespaces(true))) && !(siblingNode.is && siblingNode.isBlockBoundary({
          br : 1
        }))))) {
          GLOBAL.document.createElement("br")[isStart ? "insertBefore" : "insertAfter"](boundaryNode);
        }
      }
      var listArray = editor.list.listToArray(groupObj.root, database);
      var selectedListItems = [];
      var i = 0;
      for (;i < groupObj.contents.length;i++) {
        var itemNode = groupObj.contents[i];
        itemNode = itemNode.getAscendant("li", true);
        if (!itemNode || itemNode.getCustomData("list_item_processed")) {
          continue;
        }
        selectedListItems.push(itemNode);
        Node.setMarker(database, itemNode, "list_item_processed", true);
      }
      var lastListIndex = null;
      i = 0;
      for (;i < selectedListItems.length;i++) {
        var listIndex = selectedListItems[i].getCustomData("listarray_index");
        listArray[listIndex].indent = -1;
        lastListIndex = listIndex;
      }
      i = lastListIndex + 1;
      for (;i < listArray.length;i++) {
        if (listArray[i].indent > listArray[i - 1].indent + 1) {
          var indentOffset = listArray[i - 1].indent + 1 - listArray[i].indent;
          var oldIndent = listArray[i].indent;
          for (;listArray[i] && listArray[i].indent >= oldIndent;) {
            listArray[i].indent += indentOffset;
            i++;
          }
          i--;
        }
      }
      var newList = editor.list.arrayToList(listArray, database, null, GLOBAL.config.enterMode, groupObj.root.getAttribute("dir"));
      var docFragment = newList.listNode;
      var boundaryNode;
      var siblingNode;
      compensateBrs(true);
      compensateBrs();
      docFragment.replace(groupObj.root);
    }
    function listCommand(name, type) {
      this.name = name;
      this.type = type;
    }
    function mergeChildren(from, into, refNode, forward) {
      var child;
      var itemDir;
      for (;child = from[forward ? "getLast" : "getFirst"](elementType);) {
        if ((itemDir = child.getDirection(1)) !== into.getDirection(1)) {
          child.setAttribute("dir", itemDir);
        }
        child.remove();
        if (refNode) {
          child[forward ? "insertBefore" : "insertAfter"](refNode);
        } else {
          into.append(child, forward);
        }
      }
    }
    function mergeListSiblings(listNode) {
      var mergeSibling;
      (mergeSibling = function(rtl) {
        var sibling = listNode[rtl ? "getPrevious" : "getNext"](nonEmpty);
        if (sibling && (sibling.type == 1 && sibling.is(listNode.getName()))) {
          mergeChildren(listNode, sibling, null, !rtl);
          listNode.remove();
          listNode = sibling;
        }
      })();
      mergeSibling(1);
    }
    function indexOfFirstChildElement(element, tagNameList) {
      var child;
      var children = element.children;
      var length = children.length;
      var i = 0;
      for (;i < length;i++) {
        child = children[i];
        if (child.name && child.name in tagNameList) {
          return i;
        }
      }
      return length;
    }
    function getExtendNestedListFilter(isHtmlFilter) {
      return function(listItem) {
        var children = listItem.children;
        var firstNestedListIndex = indexOfFirstChildElement(listItem, that.$list);
        var firstNestedList = children[firstNestedListIndex];
        var nodeBefore = firstNestedList && firstNestedList.previous;
        var tailNbspmatch;
        if (nodeBefore && (nodeBefore.name && nodeBefore.name == "br" || nodeBefore.value && (tailNbspmatch = nodeBefore.value.match(optgroup)))) {
          var fillerNode = nodeBefore;
          if (!(tailNbspmatch && tailNbspmatch.index) && fillerNode == children[0]) {
            children[0] = isHtmlFilter || href ? new self.htmlParser.text("\u00a0") : new self.htmlParser.element("br", {});
          } else {
            if (fillerNode.name == "br") {
              children.splice(firstNestedListIndex - 1, 1);
            } else {
              fillerNode.value = fillerNode.value.replace(optgroup, "");
            }
          }
        }
      };
    }
    function isTextBlock(node) {
      return node.type == 1 && ((node.getName() in dtd.$block || node.getName() in dtd.$listItem) && dtd[node.getName()]["#"]);
    }
    function joinNextLineToCursor(editor, cursor, nextCursor) {
      editor.fire("saveSnapshot");
      nextCursor.enlarge(3);
      var parent = nextCursor.extractContents();
      cursor.trim(false, true);
      var bm = cursor.createBookmark();
      var path = new dom.elementPath(cursor.startContainer);
      var menu = path.lastElement.getAscendant("li", 1);
      var selfObj = path.block.getBogus();
      if (selfObj) {
        selfObj.remove();
      }
      var msg = parent.getLast();
      if (msg && (msg.type == 1 && msg.is("br"))) {
        msg.remove();
      }
      var optgroup = cursor.startContainer.getChild(cursor.startOffset);
      if (optgroup) {
        parent.insertBefore(optgroup);
      } else {
        cursor.startContainer.append(parent);
      }
      var nextPath = new dom.elementPath(nextCursor.startContainer);
      var container = nextCursor.startContainer.getAscendant("li", 1);
      if (container) {
        var sublist = getSubList(container);
        if (sublist) {
          if (menu.contains(container)) {
            mergeChildren(sublist, container.getParent(), container);
            sublist.remove();
          } else {
            menu.append(sublist);
          }
        }
      }
      for (;nextCursor.checkStartOfBlock() && nextCursor.checkEndOfBlock();) {
        nextPath = new dom.elementPath(nextCursor.startContainer);
        var nextBlock = nextPath.block;
        var li;
        if (nextBlock.is("li")) {
          li = nextBlock.getParent();
          if (nextBlock.equals(li.getLast(nonEmpty)) && nextBlock.equals(li.getFirst(nonEmpty))) {
            nextBlock = li;
          }
        }
        nextCursor.moveToPosition(nextBlock, 3);
        nextBlock.remove();
      }
      var walkerRng = nextCursor.clone();
      var selected = editor.document.getBody();
      walkerRng.setEndAt(selected, 2);
      var walker = new dom.walker(walkerRng);
      walker.evaluator = function(node) {
        return nonEmpty(node) && !blockBogus(node);
      };
      var next = walker.next();
      if (next && (next.type == 1 && next.getName() in dtd.$list)) {
        mergeListSiblings(next);
      }
      cursor.moveToBookmark(bm);
      cursor.select();
      editor.selectionChange(1);
      editor.fire("saveSnapshot");
    }
    function getSubList(node) {
      var src = node.getLast(nonEmpty);
      return src && (src.type == 1 && src.getName() in listNodeNames) ? src : null;
    }
    var listNodeNames = {
      ol : 1,
      ul : 1
    };
    var n = /^[\n\r\t ]*$/;
    var whitespaces = dom.walker.whitespaces();
    var bookmarks = dom.walker.bookmark();
    var nonEmpty = function(node) {
      return!(whitespaces(node) || bookmarks(node));
    };
    var blockBogus = dom.walker.bogus();
    editor.list = {
      listToArray : function(parent, database, baseArray, baseIndentLevel, grandparentNode) {
        if (!listNodeNames[parent.getName()]) {
          return[];
        }
        if (!baseIndentLevel) {
          baseIndentLevel = 0;
        }
        if (!baseArray) {
          baseArray = [];
        }
        var recurring = 0;
        var T = parent.getChildCount();
        for (;recurring < T;recurring++) {
          var element = parent.getChild(recurring);
          if (element.type == 1 && element.getName() in dtd.$list) {
            editor.list.listToArray(element, database, baseArray, baseIndentLevel + 1);
          }
          if (element.$.nodeName.toLowerCase() != "li") {
            continue;
          }
          var itemObj = {
            parent : parent,
            indent : baseIndentLevel,
            element : element,
            contents : []
          };
          if (!grandparentNode) {
            itemObj.grandparent = parent.getParent();
            if (itemObj.grandparent && itemObj.grandparent.$.nodeName.toLowerCase() == "li") {
              itemObj.grandparent = itemObj.grandparent.getParent();
            }
          } else {
            itemObj.grandparent = grandparentNode;
          }
          if (database) {
            Node.setMarker(database, element, "listarray_index", baseArray.length);
          }
          baseArray.push(itemObj);
          var i = 0;
          var padLength = element.getChildCount();
          var child;
          for (;i < padLength;i++) {
            child = element.getChild(i);
            if (child.type == 1 && listNodeNames[child.getName()]) {
              editor.list.listToArray(child, database, baseArray, baseIndentLevel + 1, itemObj.grandparent);
            } else {
              itemObj.contents.push(child);
            }
          }
        }
        return baseArray;
      },
      arrayToList : function(listArray, database, baseIndex, paragraphMode, dir) {
        if (!baseIndex) {
          baseIndex = 0;
        }
        if (!listArray || listArray.length < baseIndex + 1) {
          return null;
        }
        var i;
        var doc = listArray[baseIndex].parent.getDocument();
        var retval = new dom.documentFragment(doc);
        var rootNode = null;
        var currentIndex = baseIndex;
        var indentLevel = Math.max(listArray[baseIndex].indent, 0);
        var currentListItem = null;
        var orgDir;
        var block;
        var name = paragraphMode == 1 ? "p" : "div";
        for (;1;) {
          var item = listArray[currentIndex];
          var itemGrandParent = item.grandparent;
          orgDir = item.element.getDirection(1);
          if (item.indent == indentLevel) {
            if (!rootNode || listArray[currentIndex].parent.getName() != rootNode.getName()) {
              rootNode = listArray[currentIndex].parent.clone(false, 1);
              if (dir) {
                rootNode.setAttribute("dir", dir);
              }
              retval.append(rootNode);
            }
            currentListItem = rootNode.append(item.element.clone(0, 1));
            if (orgDir != rootNode.getDirection(1)) {
              currentListItem.setAttribute("dir", orgDir);
            }
            i = 0;
            for (;i < item.contents.length;i++) {
              currentListItem.append(item.contents[i].clone(1, 1));
            }
            currentIndex++;
          } else {
            if (item.indent == Math.max(indentLevel, 0) + 1) {
              var currDir = listArray[currentIndex - 1].element.getDirection(1);
              var listData = editor.list.arrayToList(listArray, null, currentIndex, paragraphMode, currDir != orgDir ? orgDir : null);
              if (!currentListItem.getChildCount() && (href && !(doc.$.documentMode > 7))) {
                currentListItem.append(doc.createText("\u00a0"));
              }
              currentListItem.append(listData.listNode);
              currentIndex = listData.nextIndex;
            } else {
              if (item.indent == -1 && (!baseIndex && itemGrandParent)) {
                if (listNodeNames[itemGrandParent.getName()]) {
                  currentListItem = item.element.clone(false, true);
                  if (orgDir != itemGrandParent.getDirection(1)) {
                    currentListItem.setAttribute("dir", orgDir);
                  }
                } else {
                  currentListItem = new dom.documentFragment(doc);
                }
                var dirLoose = itemGrandParent.getDirection(1) != orgDir;
                var li = item.element;
                var className = li.getAttribute("class");
                var style = li.getAttribute("style");
                var ak = currentListItem.type == 11 && (paragraphMode != 2 || (dirLoose || (style || className)));
                var child;
                var valuesLen = item.contents.length;
                i = 0;
                for (;i < valuesLen;i++) {
                  child = item.contents[i];
                  if (child.type == 1 && child.isBlockBoundary()) {
                    if (dirLoose && !child.getDirection()) {
                      child.setAttribute("dir", orgDir);
                    }
                    inheirtInlineStyles(li, child);
                    if (className) {
                      child.addClass(className);
                    }
                  } else {
                    if (ak) {
                      if (!block) {
                        block = doc.createElement(name);
                        if (dirLoose) {
                          block.setAttribute("dir", orgDir);
                        }
                      }
                      if (style) {
                        block.setAttribute("style", style);
                      }
                      if (className) {
                        block.setAttribute("class", className);
                      }
                      block.append(child.clone(1, 1));
                    }
                  }
                  currentListItem.append(block || child.clone(1, 1));
                }
                if (currentListItem.type == 11 && currentIndex != listArray.length - 1) {
                  var field = currentListItem.getLast();
                  if (field && (field.type == 1 && field.getAttribute("type") == "_moz")) {
                    field.remove();
                  }
                  if (!(field = currentListItem.getLast(nonEmpty) && (field.type == 1 && field.getName() in dtd.$block))) {
                    currentListItem.append(doc.createElement("br"));
                  }
                }
                var currentListItemName = currentListItem.$.nodeName.toLowerCase();
                if (!href && (currentListItemName == "div" || currentListItemName == "p")) {
                  currentListItem.appendBogus();
                }
                retval.append(currentListItem);
                rootNode = null;
                currentIndex++;
              } else {
                return null;
              }
            }
          }
          block = null;
          if (listArray.length <= currentIndex || Math.max(listArray[currentIndex].indent, 0) < indentLevel) {
            break;
          }
        }
        if (database) {
          var currentNode = retval.getFirst();
          var parent = listArray[0].parent;
          for (;currentNode;) {
            if (currentNode.type == 1) {
              Node.clearMarkers(database, currentNode);
              if (currentNode.getName() in dtd.$listItem) {
                cleanUpDirection(currentNode);
              }
            }
            currentNode = currentNode.getNextSourceNode();
          }
        }
        return{
          listNode : retval,
          nextIndex : currentIndex
        };
      }
    };
    var rhtml = /^h[1-6]$/;
    var elementType = dom.walker.nodeType(1);
    listCommand.prototype = {
      exec : function(pdataOld) {
        var optgroup = this;
        var doc = pdataOld.document;
        var config = pdataOld.config;
        var selection = pdataOld.getSelection();
        var ranges = selection && selection.getRanges(true);
        if (!ranges || ranges.length < 1) {
          return;
        }
        if (optgroup.state == 2) {
          var body = doc.getBody();
          if (!body.getFirst(nonEmpty)) {
            if (config.enterMode == 2) {
              body.appendBogus();
            } else {
              ranges[0].fixBlock(1, config.enterMode == 1 ? "p" : "div");
            }
            selection.selectRanges(ranges);
          } else {
            var range = ranges.length == 1 && ranges[0];
            var enclosedNode = range && range.getEnclosedNode();
            if (enclosedNode && (enclosedNode.is && optgroup.type == enclosedNode.getName())) {
              optgroup.setState(1);
            }
          }
        }
        var bookmarks = selection.createBookmarks(true);
        var qr = [];
        var database = {};
        var rangeIterator = ranges.createIterator();
        var index = 0;
        for (;(range = rangeIterator.getNextRange()) && ++index;) {
          var boundaryNodes = range.getBoundaryNodes();
          var startNode = boundaryNodes.startNode;
          var endNode = boundaryNodes.endNode;
          if (startNode.type == 1 && startNode.getName() == "td") {
            range.setStartAt(boundaryNodes.startNode, 1);
          }
          if (endNode.type == 1 && endNode.getName() == "td") {
            range.setEndAt(boundaryNodes.endNode, 2);
          }
          var iterator = range.createIterator();
          var block;
          iterator.forceBrBreak = optgroup.state == 2;
          for (;block = iterator.getNextParagraph();) {
            if (block.getCustomData("list_block")) {
              continue;
            } else {
              Node.setMarker(database, block, "list_block", 1);
            }
            var path = new dom.elementPath(block);
            var pathElements = path.elements;
            var pathElementsCount = pathElements.length;
            var ai = null;
            var aj = 0;
            var blockLimit = path.blockLimit;
            var element;
            var i = pathElementsCount - 1;
            for (;i >= 0 && (element = pathElements[i]);i--) {
              if (listNodeNames[element.getName()] && blockLimit.contains(element)) {
                blockLimit.removeCustomData("list_group_object_" + index);
                var data = element.getCustomData("list_group_object");
                if (data) {
                  data.contents.push(block);
                } else {
                  data = {
                    root : element,
                    contents : [block]
                  };
                  qr.push(data);
                  Node.setMarker(database, element, "list_group_object", data);
                }
                aj = 1;
                break;
              }
            }
            if (aj) {
              continue;
            }
            var root = blockLimit;
            if (root.getCustomData("list_group_object_" + index)) {
              root.getCustomData("list_group_object_" + index).contents.push(block);
            } else {
              data = {
                root : root,
                contents : [block]
              };
              Node.setMarker(database, root, "list_group_object_" + index, data);
              qr.push(data);
            }
          }
        }
        var listsCreated = [];
        for (;qr.length > 0;) {
          data = qr.shift();
          if (optgroup.state == 2) {
            if (listNodeNames[data.root.getName()]) {
              changeListType.call(optgroup, pdataOld, data, database, listsCreated);
            } else {
              createList.call(optgroup, pdataOld, data, listsCreated);
            }
          } else {
            if (optgroup.state == 1 && listNodeNames[data.root.getName()]) {
              removeList.call(optgroup, pdataOld, data, database);
            }
          }
        }
        i = 0;
        for (;i < listsCreated.length;i++) {
          mergeListSiblings(listsCreated[i]);
        }
        Node.clearAllMarkers(database);
        selection.selectBookmarks(bookmarks);
        pdataOld.focus();
      }
    };
    var that = dtd;
    var optgroup = /[\t\r\n ]*(?:&nbsp;|\xa0)$/;
    var defaultListHtmlFilterRules = {
      elements : {}
    };
    var i;
    for (i in that.$listItem) {
      defaultListHtmlFilterRules.elements[i] = getExtendNestedListFilter();
    }
    var defaultDataBlockFilterRules = {
      elements : {}
    };
    for (i in that.$listItem) {
      defaultDataBlockFilterRules.elements[i] = getExtendNestedListFilter(true);
    }
    editor.add("list", {
      init : function(editor) {
        var center = editor.addCommand("numberedlist", new listCommand("numberedlist", "ol"));
        var right = editor.addCommand("bulletedlist", new listCommand("bulletedlist", "ul"));
        editor.ui.addButton("NumberedList", {
          label : editor.lang.numberedlist,
          command : "numberedlist"
        });
        editor.ui.addButton("BulletedList", {
          label : editor.lang.bulletedlist,
          command : "bulletedlist"
        });
        editor.on("selectionChange", $.bind(onSelectionChange, center));
        editor.on("selectionChange", $.bind(onSelectionChange, right));
        editor.on("key", function(ev) {
          var key = ev.data.keyCode;
          if (editor.mode == "wysiwyg" && key in {
            8 : 1,
            46 : 1
          }) {
            var selection = editor.getSelection();
            var range = selection.getRanges()[0];
            if (!range.collapsed) {
              return;
            }
            var bulk = key == 8;
            var selectedNode = editor.document.getBody();
            var walker = new dom.walker(range.clone());
            walker.evaluator = function(node) {
              return nonEmpty(node) && !blockBogus(node);
            };
            var cursor = range.clone();
            if (bulk) {
              var previous;
              var joinWith;
              var path = new dom.elementPath(range.startContainer);
              if ((previous = path.contains(listNodeNames)) && (range.checkBoundaryOfElement(previous, 1) && ((previous = previous.getParent()) && (previous.is("li") && (previous = getSubList(previous)))))) {
                joinWith = previous;
                previous = previous.getPrevious(nonEmpty);
                cursor.moveToPosition(previous && blockBogus(previous) ? previous : joinWith, 3);
              } else {
                walker.range.setStartAt(selectedNode, 1);
                walker.range.setEnd(range.startContainer, range.startOffset);
                previous = walker.previous();
                if (previous && (previous.type == 1 && (previous.getName() in listNodeNames || previous.is("li")))) {
                  if (!previous.is("li")) {
                    walker.range.selectNodeContents(previous);
                    walker.reset();
                    walker.evaluator = isTextBlock;
                    previous = walker.previous();
                  }
                  joinWith = previous;
                  cursor.moveToElementEditEnd(joinWith);
                }
              }
              if (joinWith) {
                joinNextLineToCursor(editor, cursor, range);
                ev.cancel();
              }
            } else {
              var li = range.startContainer.getAscendant("li", 1);
              if (li) {
                walker.range.setEndAt(selectedNode, 2);
                var vvar = li.getLast(nonEmpty);
                var block = vvar && isTextBlock(vvar) ? vvar : li;
                var isAtEnd = 0;
                var next = walker.next();
                if (next && (next.type == 1 && (next.getName() in listNodeNames && next.equals(vvar)))) {
                  isAtEnd = 1;
                  next = walker.next();
                } else {
                  if (range.checkBoundaryOfElement(block, 2)) {
                    isAtEnd = 1;
                  }
                }
                if (isAtEnd && next) {
                  var nextLine = range.clone();
                  nextLine.moveToElementEditStart(next);
                  joinNextLineToCursor(editor, cursor, nextLine);
                  ev.cancel();
                }
              }
            }
            setTimeout(function() {
              editor.selectionChange(1);
            });
          }
        });
      },
      afterInit : function(editor) {
        var dataProcessor = editor.dataProcessor;
        if (dataProcessor) {
          dataProcessor.dataFilter.addRules(defaultListHtmlFilterRules);
          dataProcessor.htmlFilter.addRules(defaultDataBlockFilterRules);
        }
      },
      requires : ["domiterator"]
    });
  })();
  (function() {
    editor.liststyle = {
      requires : ["dialog"],
      init : function(editor) {
        editor.addCommand("numberedListStyle", new self.dialogCommand("numberedListStyle"));
        self.dialog.add("numberedListStyle", this.path + "dialogs/liststyle.js");
        editor.addCommand("bulletedListStyle", new self.dialogCommand("bulletedListStyle"));
        self.dialog.add("bulletedListStyle", this.path + "dialogs/liststyle.js");
        if (editor.addMenuItems) {
          editor.addMenuGroup("list", 108);
          editor.addMenuItems({
            numberedlist : {
              label : editor.lang.list.numberedTitle,
              group : "list",
              command : "numberedListStyle"
            },
            bulletedlist : {
              label : editor.lang.list.bulletedTitle,
              group : "list",
              command : "bulletedListStyle"
            }
          });
        }
        if (editor.contextMenu) {
          editor.contextMenu.addListener(function(element, dataAndEvents) {
            if (!element || element.isReadOnly()) {
              return null;
            }
            for (;element;) {
              var name = element.getName();
              if (name == "ol") {
                return{
                  numberedlist : 2
                };
              } else {
                if (name == "ul") {
                  return{
                    bulletedlist : 2
                  };
                }
              }
              element = element.getParent();
            }
            return null;
          });
        }
      }
    };
    editor.add("liststyle", editor.liststyle);
  })();
  (function() {
    function protectFormStyles(formElement) {
      if (!formElement || (formElement.type != 1 || formElement.getName() != "form")) {
        return[];
      }
      var hijackRecord = [];
      var resultItems = ["style", "className"];
      var i = 0;
      for (;i < resultItems.length;i++) {
        var result = resultItems[i];
        var key = formElement.$.elements.namedItem(result);
        if (key) {
          var node = new Node(key);
          hijackRecord.push([node, node.nextSibling]);
          node.remove();
        }
      }
      return hijackRecord;
    }
    function restoreFormStyles(p, worlds) {
      if (!p || (p.type != 1 || p.getName() != "form")) {
        return;
      }
      if (worlds.length > 0) {
        var i = worlds.length - 1;
        for (;i >= 0;i--) {
          var element = worlds[i][0];
          var optgroup = worlds[i][1];
          if (optgroup) {
            element.insertBefore(optgroup);
          } else {
            element.appendTo(p);
          }
        }
      }
    }
    function saveStyles(element, dataAndEvents) {
      var data = protectFormStyles(element);
      var retval = {};
      var $element = element.$;
      if (!dataAndEvents) {
        retval["class"] = $element.className || "";
        $element.className = "";
      }
      retval.inline = $element.style.cssText || "";
      if (!dataAndEvents) {
        $element.style.cssText = "position: static; overflow: visible";
      }
      restoreFormStyles(data);
      return retval;
    }
    function restoreStyles(element, savedStyles) {
      var data = protectFormStyles(element);
      var $element = element.$;
      if ("class" in savedStyles) {
        $element.className = savedStyles["class"];
      }
      if ("inline" in savedStyles) {
        $element.style.cssText = savedStyles.inline;
      }
      restoreFormStyles(data);
    }
    function refreshCursor(editor) {
      var all = self.instances;
      var i;
      for (i in all) {
        var one = all[i];
        if (one.mode == "wysiwyg" && !one.readOnly) {
          var body = one.document.getBody();
          body.setAttribute("contentEditable", false);
          body.setAttribute("contentEditable", true);
        }
      }
      if (editor.focusManager.hasFocus) {
        editor.toolbox.focus();
        editor.focus();
      }
    }
    function createIframeShim(element) {
      if (!href || env.version > 6) {
        return null;
      }
      var clone = Node.createFromHtml('<iframe frameborder="0" tabindex="-1" src="javascript:void((function(){document.open();' + (env.isCustomDomain() ? "document.domain='" + this.getDocument().$.domain + "';" : "") + "document.close();" + '})())"' + ' style="display:block;position:absolute;z-index:-1;' + "progid:DXImageTransform.Microsoft.Alpha(opacity=0);" + '"></iframe>');
      return element.append(clone, true);
    }
    editor.add("maximize", {
      init : function(editor) {
        function resizeHandler() {
          var viewPaneSize = mainWindow.getViewPaneSize();
          if (shim) {
            shim.setStyles({
              width : viewPaneSize.width + "px",
              height : viewPaneSize.height + "px"
            });
          }
          editor.resize(viewPaneSize.width, viewPaneSize.height, null, true);
        }
        var lang = editor.lang;
        var doc = self.document;
        var mainWindow = doc.getWindow();
        var savedSelection;
        var savedScroll;
        var outerScroll;
        var shim;
        var savedState = 2;
        editor.addCommand("maximize", {
          modes : {
            wysiwyg : !env.iOS,
            source : !env.iOS
          },
          readOnly : 1,
          editorFocus : false,
          exec : function() {
            var container = editor.container.getChild(1);
            var contents = editor.getThemeSpace("contents");
            if (editor.mode == "wysiwyg") {
              var selection = editor.getSelection();
              savedSelection = selection && selection.getRanges();
              savedScroll = mainWindow.getScrollPosition();
            } else {
              var $textarea = editor.textarea.$;
              savedSelection = !href && [$textarea.selectionStart, $textarea.selectionEnd];
              savedScroll = [$textarea.scrollLeft, $textarea.scrollTop];
            }
            if (this.state == 2) {
              mainWindow.on("resize", resizeHandler);
              outerScroll = mainWindow.getScrollPosition();
              var currentNode = editor.container;
              for (;currentNode = currentNode.getParent();) {
                currentNode.setCustomData("maximize_saved_styles", saveStyles(currentNode));
                currentNode.setStyle("z-index", editor.config.baseFloatZIndex - 1);
              }
              contents.setCustomData("maximize_saved_styles", saveStyles(contents, true));
              container.setCustomData("maximize_saved_styles", saveStyles(container, true));
              var styles = {
                overflow : env.webkit ? "" : "hidden",
                width : 0,
                height : 0
              };
              doc.getDocumentElement().setStyles(styles);
              if (!env.gecko) {
                doc.getDocumentElement().setStyle("position", "fixed");
              }
              if (!(env.gecko && env.quirks)) {
                doc.getBody().setStyles(styles);
              }
              if (href) {
                setTimeout(function() {
                  mainWindow.$.scrollTo(0, 0);
                }, 0);
              } else {
                mainWindow.$.scrollTo(0, 0);
              }
              container.setStyle("position", env.gecko && env.quirks ? "fixed" : "absolute");
              container.$.offsetLeft;
              container.setStyles({
                "z-index" : editor.config.baseFloatZIndex - 1,
                left : "0px",
                top : "0px"
              });
              shim = createIframeShim(container);
              container.addClass("cke_maximized");
              resizeHandler();
              var offsetCoordinate = container.getDocumentPosition();
              container.setStyles({
                left : -1 * offsetCoordinate.x + "px",
                top : -1 * offsetCoordinate.y + "px"
              });
              if (env.gecko) {
                refreshCursor(editor);
              }
            } else {
              if (this.state == 1) {
                mainWindow.removeListener("resize", resizeHandler);
                var editorElements = [contents, container];
                var i = 0;
                for (;i < editorElements.length;i++) {
                  restoreStyles(editorElements[i], editorElements[i].getCustomData("maximize_saved_styles"));
                  editorElements[i].removeCustomData("maximize_saved_styles");
                }
                currentNode = editor.container;
                for (;currentNode = currentNode.getParent();) {
                  restoreStyles(currentNode, currentNode.getCustomData("maximize_saved_styles"));
                  currentNode.removeCustomData("maximize_saved_styles");
                }
                if (href) {
                  setTimeout(function() {
                    mainWindow.$.scrollTo(outerScroll.x, outerScroll.y);
                  }, 0);
                } else {
                  mainWindow.$.scrollTo(outerScroll.x, outerScroll.y);
                }
                container.removeClass("cke_maximized");
                if (env.webkit) {
                  container.setStyle("display", "inline");
                  setTimeout(function() {
                    container.setStyle("display", "block");
                  }, 0);
                }
                if (shim) {
                  shim.remove();
                  shim = null;
                }
                editor.fire("resize");
              }
            }
            this.toggleState();
            var button = this.uiItems[0];
            if (button) {
              var label = this.state == 2 ? lang.maximize : lang.minimize;
              var buttonNode = editor.element.getDocument().getById(button._.id);
              buttonNode.getChild(1).setHtml(label);
              buttonNode.setAttribute("title", label);
              buttonNode.setAttribute("href", 'javascript:void("' + label + '");');
            }
            if (editor.mode == "wysiwyg") {
              if (savedSelection) {
                if (env.gecko) {
                  refreshCursor(editor);
                }
                editor.getSelection().selectRanges(savedSelection);
                var element = editor.getSelection().getStartElement();
                if (element) {
                  element.scrollIntoView(true);
                }
              } else {
                mainWindow.$.scrollTo(savedScroll.x, savedScroll.y);
              }
            } else {
              if (savedSelection) {
                $textarea.selectionStart = savedSelection[0];
                $textarea.selectionEnd = savedSelection[1];
              }
              $textarea.scrollLeft = savedScroll[0];
              $textarea.scrollTop = savedScroll[1];
            }
            savedSelection = savedScroll = null;
            savedState = this.state;
          },
          canUndo : false
        });
        editor.ui.addButton("Maximize", {
          label : lang.maximize,
          command : "maximize"
        });
        editor.on("mode", function() {
          var command = editor.getCommand("maximize");
          command.setState(command.state == 0 ? 0 : savedState);
        }, null, null, 100);
      }
    });
  })();
  editor.add("newpage", {
    init : function(editor) {
      editor.addCommand("newpage", {
        modes : {
          wysiwyg : 1,
          source : 1
        },
        exec : function(editor) {
          var cmd = this;
          editor.setData(editor.config.newpage_html || "", function() {
            setTimeout(function() {
              editor.fire("afterCommandExec", {
                name : "newpage",
                command : cmd
              });
              editor.selectionChange();
            }, 200);
          });
          editor.focus();
        },
        async : true
      });
      editor.ui.addButton("NewPage", {
        label : editor.lang.newPage,
        command : "newpage"
      });
    }
  });
  editor.add("pagebreak", {
    init : function(d) {
      d.addCommand("pagebreak", editor.pagebreakCmd);
      d.ui.addButton("PageBreak", {
        label : d.lang.pagebreak,
        command : "pagebreak"
      });
      var interval = ["{", "background: url(" + self.getUrl(this.path + "images/pagebreak.gif") + ") no-repeat center center;", "clear: both;", "width:100%; _width:99.9%;", "border-top: #999999 1px dotted;", "border-bottom: #999999 1px dotted;", "padding:0;", "height: 5px;", "cursor: default;", "}"].join("").replace(/;/g, " !important;");
      d.addCss("div.cke_pagebreak" + interval);
      if (env.opera) {
        d.on("contentDom", function() {
          d.document.on("click", function(ev) {
            var target = ev.data.getTarget();
            if (target.is("div") && target.hasClass("cke_pagebreak")) {
              d.getSelection().selectElement(target);
            }
          });
        });
      }
    },
    afterInit : function(editor) {
      var label = editor.lang.pagebreakAlt;
      var dataProcessor = editor.dataProcessor;
      var dataFilter = dataProcessor && dataProcessor.dataFilter;
      var htmlFilter = dataProcessor && dataProcessor.htmlFilter;
      if (htmlFilter) {
        htmlFilter.addRules({
          attributes : {
            "class" : function(value, element) {
              var className = value.replace("cke_pagebreak", "");
              if (className != value) {
                var optgroup = self.htmlParser.fragment.fromHtml('<span style="display: none;">&nbsp;</span>');
                element.children.length = 0;
                element.add(optgroup);
                var attrs = element.attributes;
                delete attrs["aria-label"];
                delete attrs.contenteditable;
                delete attrs.title;
              }
              return className;
            }
          }
        }, 5);
      }
      if (dataFilter) {
        dataFilter.addRules({
          elements : {
            div : function(name) {
              var attributes = name.attributes;
              var style = attributes && attributes.style;
              var child = style && (name.children.length == 1 && name.children[0]);
              var childStyle = child && (child.name == "span" && child.attributes.style);
              if (childStyle && (/page-break-after\s*:\s*always/i.test(style) && /display\s*:\s*none/i.test(childStyle))) {
                attributes.contenteditable = "false";
                attributes["class"] = "cke_pagebreak";
                attributes["data-cke-display-name"] = "pagebreak";
                attributes["aria-label"] = label;
                attributes.title = label;
                name.children.length = 0;
              }
            }
          }
        });
      }
    },
    requires : ["fakeobjects"]
  });
  editor.pagebreakCmd = {
    exec : function(editor) {
      var label = editor.lang.pagebreakAlt;
      var startNode = Node.createFromHtml('<div style="page-break-after: always;"contenteditable="false" title="' + label + '" ' + 'aria-label="' + label + '" ' + 'data-cke-display-name="pagebreak" ' + 'class="cke_pagebreak">' + "</div>", editor.document);
      var codeSegments = editor.getSelection().getRanges(true);
      editor.fire("saveSnapshot");
      var range;
      var i = codeSegments.length - 1;
      for (;i >= 0;i--) {
        range = codeSegments[i];
        if (i < codeSegments.length - 1) {
          startNode = startNode.clone(true);
        }
        range.splitBlock("p");
        range.insertNode(startNode);
        if (i == codeSegments.length - 1) {
          var node = startNode.getNext();
          range.moveToPosition(startNode, 4);
          if (!node || node.type == 1 && !node.isEditable()) {
            range.fixBlock(true, editor.config.enterMode == 3 ? "div" : "p");
          }
          range.select();
        }
      }
      editor.fire("saveSnapshot");
    }
  };
  (function() {
    function init(options) {
      options.data.mode = "html";
    }
    editor.add("pastefromword", {
      init : function(editor) {
        var forceFromWord = 0;
        var error = function(object) {
          if (object) {
            object.removeListener();
          }
          editor.removeListener("beforePaste", init);
          if (forceFromWord) {
            setTimeout(function() {
              forceFromWord = 0;
            }, 0);
          }
        };
        editor.addCommand("pastefromword", {
          canUndo : false,
          exec : function() {
            forceFromWord = 1;
            editor.on("beforePaste", init);
            if (editor.execCommand("paste", "html") === false) {
              editor.on("dialogShow", function(e) {
                e.removeListener();
                e.data.on("cancel", error);
              });
              editor.on("dialogHide", function(evt) {
                evt.data.removeListener("cancel", error);
              });
            }
            editor.on("afterPaste", error);
          }
        });
        editor.ui.addButton("PasteFromWord", {
          label : editor.lang.pastefromword.toolbar,
          command : "pastefromword"
        });
        editor.on("pasteState", function(evt) {
          editor.getCommand("pastefromword").setState(evt.data);
        });
        editor.on("paste", function(res) {
          var data = res.data;
          var mswordHtml;
          if ((mswordHtml = data.html) && (forceFromWord || /(class=\"?Mso|style=\"[^\"]*\bmso\-|w:WordDocument)/.test(mswordHtml))) {
            var isLazyLoad = this.loadFilterRules(function() {
              if (isLazyLoad) {
                editor.fire("paste", data);
              } else {
                if (!editor.config.pasteFromWordPromptCleanup || (forceFromWord || confirm(editor.lang.pastefromword.confirmCleanup))) {
                  data.html = self.cleanWord(mswordHtml, editor);
                }
              }
            });
            if (isLazyLoad) {
              res.cancel();
            }
          }
        }, this);
      },
      loadFilterRules : function(pn) {
        var len = self.cleanWord;
        if (len) {
          pn();
        } else {
          var url = self.getUrl(config.pasteFromWordCleanupFile || this.path + "filter/default.js");
          self.scriptLoader.load(url, pn, null, true);
        }
        return!len;
      },
      requires : ["clipboard"]
    });
  })();
  (function() {
    var commandObject = {
      exec : function(editor) {
        var ch = $.tryThese(function() {
          var clipboardText = window.clipboardData.getData("Text");
          if (!clipboardText) {
            throw 0;
          }
          return clipboardText;
        });
        if (!ch) {
          editor.openDialog("pastetext");
          return false;
        } else {
          editor.fire("paste", {
            text : ch
          });
        }
        return true;
      }
    };
    editor.add("pastetext", {
      init : function(editor) {
        var optgroup = "pastetext";
        var optGroup = editor.addCommand(optgroup, commandObject);
        editor.ui.addButton("PasteText", {
          label : editor.lang.pasteText.button,
          command : optgroup
        });
        self.dialog.add(optgroup, self.getUrl(this.path + "dialogs/pastetext.js"));
        if (editor.config.forcePasteAsPlainText) {
          editor.on("beforeCommandExec", function(evt) {
            var mode = evt.data.commandData;
            if (evt.data.name == "paste" && mode != "html") {
              editor.execCommand("pastetext");
              evt.cancel();
            }
          }, null, null, 0);
          editor.on("beforePaste", function(evt) {
            evt.data.mode = "text";
          });
        }
        editor.on("pasteState", function(evt) {
          editor.getCommand("pastetext").setState(evt.data);
        });
      },
      requires : ["clipboard"]
    });
  })();
  editor.add("popup");
  $.extend(self.editor.prototype, {
    popup : function(url, width, height, options) {
      width = width || "80%";
      height = height || "70%";
      if (typeof width == "string" && (width.length > 1 && width.substr(width.length - 1, 1) == "%")) {
        width = parseInt(window.screen.width * parseInt(width, 10) / 100, 10);
      }
      if (typeof height == "string" && (height.length > 1 && height.substr(height.length - 1, 1) == "%")) {
        height = parseInt(window.screen.height * parseInt(height, 10) / 100, 10);
      }
      if (width < 640) {
        width = 640;
      }
      if (height < 420) {
        height = 420;
      }
      var top = parseInt((window.screen.height - height) / 2, 10);
      var left = parseInt((window.screen.width - width) / 2, 10);
      options = (options || "location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes") + ",width=" + width + ",height=" + height + ",top=" + top + ",left=" + left;
      var popupWindow = window.open("", null, options, true);
      if (!popupWindow) {
        return false;
      }
      try {
        var excludes = navigator.userAgent.toLowerCase();
        if (excludes.indexOf(" chrome/") == -1) {
          popupWindow.moveTo(left, top);
          popupWindow.resizeTo(width, height);
        }
        popupWindow.focus();
        popupWindow.location.href = url;
      } catch (u) {
        popupWindow = window.open(url, null, options, true);
      }
      return true;
    }
  });
  (function() {
    var path;
    var previewCmd = {
      modes : {
        wysiwyg : 1,
        source : 1
      },
      canUndo : false,
      readOnly : 1,
      exec : function(editor) {
        var sHTML;
        var config = editor.config;
        var baseTag = config.baseHref ? '<base href="' + config.baseHref + '"/>' : "";
        var t = env.isCustomDomain();
        if (config.fullPage) {
          sHTML = editor.getData().replace(/<head>/, "$&" + baseTag).replace(/[^>]*(?=<\/title>)/, "$& &mdash; " + editor.lang.preview);
        } else {
          var u = "<body ";
          var option = editor.document && editor.document.getBody();
          if (option) {
            if (option.getAttribute("id")) {
              u += 'id="' + option.getAttribute("id") + '" ';
            }
            if (option.getAttribute("class")) {
              u += 'class="' + option.getAttribute("class") + '" ';
            }
          }
          u += ">";
          sHTML = editor.config.docType + '<html dir="' + editor.config.contentsLangDirection + '">' + "<head>" + baseTag + "<title>" + editor.lang.preview + "</title>" + $.buildStyleHtml(editor.config.contentsCss) + "</head>" + u + editor.getData() + "</body></html>";
        }
        var w = 640;
        var x = 420;
        var iLeft = 80;
        try {
          var screen = window.screen;
          w = Math.round(screen.width * 0.8);
          x = Math.round(screen.height * 0.7);
          iLeft = Math.round(screen.width * 0.1);
        } catch (D) {
        }
        var url = "";
        if (t) {
          window._cke_htmlToLoad = sHTML;
          url = 'javascript:void( (function(){document.open();document.domain="' + document.domain + '";' + "document.write( window.opener._cke_htmlToLoad );" + "document.close();" + "window.opener._cke_htmlToLoad = null;" + "})() )";
        }
        if (env.gecko) {
          window._cke_htmlToLoad = sHTML;
          url = path + "preview.html";
        }
        var obj = window.open(url, null, "toolbar=yes,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=" + w + ",height=" + x + ",left=" + iLeft);
        if (!t && !env.gecko) {
          var doc = obj.document;
          doc.open();
          doc.write(sHTML);
          doc.close();
          if (env.webkit) {
            setTimeout(function() {
              doc.body.innerHTML += "";
            }, 0);
          }
        }
      }
    };
    var optgroup = "preview";
    editor.add(optgroup, {
      init : function(editor) {
        path = this.path;
        editor.addCommand(optgroup, previewCmd);
        editor.ui.addButton("Preview", {
          label : editor.lang.preview,
          command : optgroup
        });
      }
    });
  })();
  editor.add("print", {
    init : function(self) {
      var name = "print";
      var quoteNeeded = self.addCommand(name, editor.print);
      self.ui.addButton("Print", {
        label : self.lang.print,
        command : name
      });
    }
  });
  editor.print = {
    exec : function(editor) {
      if (env.opera) {
        return;
      } else {
        if (env.gecko) {
          editor.window.$.print();
        } else {
          editor.document.$.execCommand("Print");
        }
      }
    },
    canUndo : false,
    readOnly : 1,
    modes : {
      wysiwyg : !env.opera
    }
  };
  editor.add("removeformat", {
    requires : ["selection"],
    init : function(args) {
      args.addCommand("removeFormat", editor.removeformat.commands.removeformat);
      args.ui.addButton("RemoveFormat", {
        label : args.lang.removeFormat,
        command : "removeFormat"
      });
      args._.removeFormat = {
        filters : []
      };
    }
  });
  editor.removeformat = {
    commands : {
      removeformat : {
        exec : function(str) {
          var rhtml = str._.removeFormatRegex || (str._.removeFormatRegex = new RegExp("^(?:" + str.config.removeFormatTags.replace(/,/g, "|") + ")$", "i"));
          var removeAttributes = str._.removeAttributes || (str._.removeAttributes = str.config.removeFormatAttributes.split(","));
          var filter = editor.removeformat.filter;
          var ranges = str.getSelection().getRanges(1);
          var iterator = ranges.createIterator();
          var self;
          for (;self = iterator.getNextRange();) {
            if (!self.collapsed) {
              self.enlarge(1);
            }
            var bookmark = self.createBookmark();
            var startNode = bookmark.startNode;
            var endNode = bookmark.endNode;
            var currentNode;
            var breakParent = function(node) {
              var path = new dom.elementPath(node);
              var pathElements = path.elements;
              var i = 1;
              var pathElement;
              for (;pathElement = pathElements[i];i++) {
                if (pathElement.equals(path.block) || pathElement.equals(path.blockLimit)) {
                  break;
                }
                if (rhtml.test(pathElement.getName()) && filter(str, pathElement)) {
                  node.breakParent(pathElement);
                }
              }
            };
            breakParent(startNode);
            if (endNode) {
              breakParent(endNode);
              currentNode = startNode.getNextSourceNode(true, 1);
              for (;currentNode;) {
                if (currentNode.equals(endNode)) {
                  break;
                }
                var nextNode = currentNode.getNextSourceNode(false, 1);
                if (!(currentNode.getName() == "img" && currentNode.data("cke-realelement")) && filter(str, currentNode)) {
                  if (rhtml.test(currentNode.getName())) {
                    currentNode.remove(1);
                  } else {
                    currentNode.removeAttributes(removeAttributes);
                    str.fire("removeFormatCleanup", currentNode);
                  }
                }
                currentNode = nextNode;
              }
            }
            self.moveToBookmark(bookmark);
          }
          str.getSelection().selectRanges(ranges);
        }
      }
    },
    filter : function(element, value) {
      var codeSegments = element._.removeFormat.filters;
      var i = 0;
      for (;i < codeSegments.length;i++) {
        if (codeSegments[i](value) === false) {
          return false;
        }
      }
      return true;
    }
  };
  self.editor.prototype.addRemoveFormatFilter = function(spaceName) {
    this._.removeFormat.filters.push(spaceName);
  };
  config.removeFormatTags = "b,big,code,del,dfn,em,font,i,ins,kbd,q,samp,small,span,strike,strong,sub,sup,tt,u,var";
  config.removeFormatAttributes = "class,style,lang,width,height,align,hspace,valign";
  editor.add("resize", {
    init : function(editor) {
      var config = editor.config;
      var resizeDir = editor.element.getDirection(1);
      if (!config.resize_dir) {
        config.resize_dir = "both";
      }
      if (config.resize_maxWidth == undefined) {
        config.resize_maxWidth = 3E3;
      }
      if (config.resize_maxHeight == undefined) {
        config.resize_maxHeight = 3E3;
      }
      if (config.resize_minWidth == undefined) {
        config.resize_minWidth = 750;
      }
      if (config.resize_minHeight == undefined) {
        config.resize_minHeight = 250;
      }
      if (config.resize_enabled !== false) {
        var container = null;
        var origin;
        var startSize;
        var resizeHorizontal = (config.resize_dir == "both" || config.resize_dir == "horizontal") && config.resize_minWidth != config.resize_maxWidth;
        var resizeVertical = (config.resize_dir == "both" || config.resize_dir == "vertical") && config.resize_minHeight != config.resize_maxHeight;
        var mouseMoveHandler = function(evt) {
          var dx = evt.data.$.screenX - origin.x;
          var finish = evt.data.$.screenY - origin.y;
          var width = startSize.width;
          var pdataOld = startSize.height;
          var internalWidth = width + dx * (resizeDir == "rtl" ? -1 : 1);
          var range = pdataOld + finish;
          if (resizeHorizontal) {
            width = Math.max(config.resize_minWidth, Math.min(internalWidth, config.resize_maxWidth));
          }
          if (resizeVertical) {
            pdataOld = Math.max(config.resize_minHeight, Math.min(range, config.resize_maxHeight));
          }
          editor.resize(resizeHorizontal ? width : null, pdataOld);
        };
        var onMouseUp = function(event) {
          self.document.removeListener("mousemove", mouseMoveHandler);
          self.document.removeListener("mouseup", onMouseUp);
          if (editor.document) {
            editor.document.removeListener("mousemove", mouseMoveHandler);
            editor.document.removeListener("mouseup", onMouseUp);
          }
        };
        var keys = $.addFunction(function($event) {
          if (!container) {
            container = editor.getResizable();
          }
          startSize = {
            width : container.$.offsetWidth || 0,
            height : container.$.offsetHeight || 0
          };
          origin = {
            x : $event.screenX,
            y : $event.screenY
          };
          if (config.resize_minWidth > startSize.width) {
            config.resize_minWidth = startSize.width;
          }
          if (config.resize_minHeight > startSize.height) {
            config.resize_minHeight = startSize.height;
          }
          self.document.on("mousemove", mouseMoveHandler);
          self.document.on("mouseup", onMouseUp);
          if (editor.document) {
            editor.document.on("mousemove", mouseMoveHandler);
            editor.document.on("mouseup", onMouseUp);
          }
        });
        editor.on("destroy", function() {
          $.removeFunction(keys);
        });
        editor.on("themeSpace", function(event) {
          if (event.data.space == "bottom") {
            var direction = "";
            if (resizeHorizontal && !resizeVertical) {
              direction = " cke_resizer_horizontal";
            }
            if (!resizeHorizontal && resizeVertical) {
              direction = " cke_resizer_vertical";
            }
            var resizerHtml = '<div class="cke_resizer' + direction + " cke_resizer_" + resizeDir + '"' + ' title="' + $.htmlEncode(editor.lang.resize) + '"' + ' onmousedown="CKEDITOR.tools.callFunction(' + keys + ', event)"' + "></div>";
            if (resizeDir == "ltr" && direction == "ltr") {
              event.data.html += resizerHtml;
            } else {
              event.data.html = resizerHtml + event.data.html;
            }
          }
        }, editor, null, 100);
      }
    }
  });
  (function() {
    var saveCmd = {
      modes : {
        wysiwyg : 1,
        source : 1
      },
      readOnly : 1,
      exec : function(editor) {
        var $form = editor.element.$.form;
        if ($form) {
          try {
            $form.submit();
          } catch (q) {
            if ($form.submit.click) {
              $form.submit.click();
            }
          }
        }
      }
    };
    var optgroup = "save";
    editor.add(optgroup, {
      init : function(editor) {
        var command = editor.addCommand(optgroup, saveCmd);
        command.modes = {
          wysiwyg : !!editor.element.$.form
        };
        editor.ui.addButton("Save", {
          label : editor.lang.save,
          command : optgroup
        });
      }
    });
  })();
  (function() {
    function in_array(needle, haystack) {
      var found = 0;
      var key;
      for (key in haystack) {
        if (haystack[key] == needle) {
          found = 1;
          break;
        }
      }
      return found;
    }
    var optgroup = "scaytcheck";
    var openPage = "";
    var onEngineLoad = function() {
      var data = this;
      var createInstance = function() {
        var config = data.config;
        var oParams = {};
        oParams.srcNodeRef = data.document.getWindow().$.frameElement;
        oParams.assocApp = "CKEDITOR." + self.version + "@" + self.revision;
        oParams.customerid = config.scayt_customerid || "1:WvF0D4-UtPqN1-43nkD4-NKvUm2-daQqk3-LmNiI-z7Ysb4-mwry24-T8YrS3-Q2tpq2";
        oParams.customDictionaryIds = config.scayt_customDictionaryIds || "";
        oParams.userDictionaryName = config.scayt_userDictionaryName || "";
        oParams.sLang = config.scayt_sLang || "en_US";
        oParams.onLoad = function() {
          if (!(href && env.version < 8)) {
            this.addStyle(this.selectorCss(), "padding-bottom: 2px !important;");
          }
          if (data.focusManager.hasFocus && !plugin.isControlRestored(data)) {
            this.focus();
          }
        };
        oParams.onBeforeChange = function() {
          if (plugin.getScayt(data) && !data.checkDirty()) {
            setTimeout(function() {
              data.resetDirty();
            }, 0);
          }
        };
        var scayt_custom_params = window.scayt_custom_params;
        if (typeof scayt_custom_params == "object") {
          var k;
          for (k in scayt_custom_params) {
            oParams[k] = scayt_custom_params[k];
          }
        }
        if (plugin.getControlId(data)) {
          oParams.id = plugin.getControlId(data);
        }
        var scayt_control = new window.scayt(oParams);
        scayt_control.afterMarkupRemove.push(function(node) {
          (new Node(node, scayt_control.document)).mergeSiblings();
        });
        var lastInstance = plugin.instances[data.name];
        if (lastInstance) {
          scayt_control.sLang = lastInstance.sLang;
          scayt_control.option(lastInstance.option());
          scayt_control.paused = lastInstance.paused;
        }
        plugin.instances[data.name] = scayt_control;
        try {
          scayt_control.setDisabled(plugin.isPaused(data) === false);
        } catch (E) {
        }
        data.fire("showScaytState");
      };
      data.on("contentDom", createInstance);
      data.on("contentDomUnload", function() {
        var scripts = self.document.getElementsByTag("script");
        var core_rnotwhite = /^dojoIoScript(\d+)$/i;
        var exclude = /^https?:\/\/svc\.webspellchecker\.net\/spellcheck\/script\/ssrv\.cgi/i;
        var i = 0;
        for (;i < scripts.count();i++) {
          var script = scripts.getItem(i);
          var value = script.getId();
          var path = script.getAttribute("src");
          if (value && (path && (value.match(core_rnotwhite) && path.match(exclude)))) {
            script.remove();
          }
        }
      });
      data.on("beforeCommandExec", function(messageEvent) {
        if ((messageEvent.data.name == "source" || messageEvent.data.name == "newpage") && data.mode == "wysiwyg") {
          var scayt_instance = plugin.getScayt(data);
          if (scayt_instance) {
            plugin.setPaused(data, !scayt_instance.disabled);
            plugin.setControlId(data, scayt_instance.id);
            scayt_instance.destroy(true);
            delete plugin.instances[data.name];
          }
        } else {
          if (messageEvent.data.name == "source" && data.mode == "source") {
            plugin.markControlRestore(data);
          }
        }
      });
      data.on("afterCommandExec", function(messageEvent) {
        if (!plugin.isScaytEnabled(data)) {
          return;
        }
        if (data.mode == "wysiwyg" && (messageEvent.data.name == "undo" || messageEvent.data.name == "redo")) {
          window.setTimeout(function() {
            plugin.getScayt(data).refresh();
          }, 10);
        }
      });
      data.on("destroy", function(ev) {
        var editor = ev.editor;
        var scayt_instance = plugin.getScayt(editor);
        if (!scayt_instance) {
          return;
        }
        delete plugin.instances[editor.name];
        plugin.setControlId(editor, scayt_instance.id);
        scayt_instance.destroy(true);
      });
      data.on("afterSetData", function() {
        if (plugin.isScaytEnabled(data)) {
          window.setTimeout(function() {
            var target = plugin.getScayt(data);
            if (target) {
              target.refresh();
            }
          }, 10);
        }
      });
      data.on("insertElement", function() {
        var target = plugin.getScayt(data);
        if (plugin.isScaytEnabled(data)) {
          if (href) {
            data.getSelection().unlock(true);
          }
          window.setTimeout(function() {
            target.focus();
            target.refresh();
          }, 10);
        }
      }, this, null, 50);
      data.on("insertHtml", function() {
        var target = plugin.getScayt(data);
        if (plugin.isScaytEnabled(data)) {
          if (href) {
            data.getSelection().unlock(true);
          }
          window.setTimeout(function() {
            target.focus();
            target.refresh();
          }, 10);
        }
      }, this, null, 50);
      data.on("scaytDialog", function(ev) {
        ev.data.djConfig = window.djConfig;
        ev.data.scayt_control = plugin.getScayt(data);
        ev.data.tab = openPage;
        ev.data.scayt = window.scayt;
      });
      var dataProcessor = data.dataProcessor;
      var dataFilter = dataProcessor && dataProcessor.htmlFilter;
      if (dataFilter) {
        dataFilter.addRules({
          elements : {
            span : function(name) {
              if (name.attributes["data-scayt_word"] && name.attributes["data-scaytid"]) {
                delete name.name;
                return name;
              }
            }
          }
        });
      }
      var p = editor.undo.Image.prototype;
      p.equals = $.override(p.equals, function(matcherFunction) {
        return function(entry) {
          var self = this;
          var data = self.contents;
          var i = entry.contents;
          var record = plugin.getScayt(self.editor);
          if (record && plugin.isScaytReady(self.editor)) {
            self.contents = record.reset(data) || "";
            entry.contents = record.reset(i) || "";
          }
          var result = matcherFunction.apply(self, arguments);
          self.contents = data;
          entry.contents = i;
          return result;
        };
      });
      if (data.document) {
        createInstance();
      }
    };
    editor.scayt = {
      engineLoaded : false,
      instances : {},
      controlInfo : {},
      setControlInfo : function(editor, iterable) {
        if (editor && (editor.name && typeof this.controlInfo[editor.name] != "object")) {
          this.controlInfo[editor.name] = {};
        }
        var key;
        for (key in iterable) {
          this.controlInfo[editor.name][key] = iterable[key];
        }
      },
      isControlRestored : function(editor) {
        if (editor && (editor.name && this.controlInfo[editor.name])) {
          return this.controlInfo[editor.name].restored;
        }
        return false;
      },
      markControlRestore : function(editor) {
        this.setControlInfo(editor, {
          restored : true
        });
      },
      setControlId : function(editor, id) {
        this.setControlInfo(editor, {
          id : id
        });
      },
      getControlId : function(editor) {
        if (editor && (editor.name && (this.controlInfo[editor.name] && this.controlInfo[editor.name].id))) {
          return this.controlInfo[editor.name].id;
        }
        return null;
      },
      setPaused : function(editor, bool) {
        this.setControlInfo(editor, {
          paused : bool
        });
      },
      isPaused : function(editor) {
        if (editor && (editor.name && this.controlInfo[editor.name])) {
          return this.controlInfo[editor.name].paused;
        }
        return undefined;
      },
      getScayt : function(editor) {
        return this.instances[editor.name];
      },
      isScaytReady : function(editor) {
        return this.engineLoaded === true && ("undefined" !== typeof window.scayt && this.getScayt(editor));
      },
      isScaytEnabled : function(editor) {
        var scayt_instance = this.getScayt(editor);
        return scayt_instance ? scayt_instance.disabled === false : false;
      },
      getUiTabs : function(editor) {
        var uiTabs = [];
        var strings = editor.config.scayt_uiTabs || "1,1,1";
        strings = strings.split(",");
        strings[3] = "1";
        var i = 0;
        for (;i < 4;i++) {
          uiTabs[i] = typeof window.scayt != "undefined" && typeof window.scayt.uiTags != "undefined" ? parseInt(strings[i], 10) && window.scayt.uiTags[i] : parseInt(strings[i], 10);
        }
        return uiTabs;
      },
      loadEngine : function(editor) {
        if (env.gecko && env.version < 10900 || (env.opera || env.air)) {
          return editor.fire("showScaytState");
        }
        if (this.engineLoaded === true) {
          return onEngineLoad.apply(editor);
        } else {
          if (this.engineLoaded == -1) {
            return self.on("scaytReady", function() {
              onEngineLoad.apply(editor);
            });
          }
        }
        self.on("scaytReady", onEngineLoad, editor);
        self.on("scaytReady", function() {
          this.engineLoaded = true;
        }, this, null, 0);
        this.engineLoaded = -1;
        var protocol = document.location.protocol;
        protocol = protocol.search(/https?:/) != -1 ? protocol : "http:";
        var baseUrl = "svc.webspellchecker.net/scayt26/loader__base.js";
        var scaytUrl = editor.config.scayt_srcUrl || protocol + "//" + baseUrl;
        var scaytConfigBaseUrl = plugin.parseUrl(scaytUrl).path + "/";
        if (window.scayt == undefined) {
          self._djScaytConfig = {
            baseUrl : scaytConfigBaseUrl,
            addOnLoad : [function() {
              self.fireOnce("scaytReady");
            }],
            isDebug : false
          };
          self.document.getHead().append(self.document.createElement("script", {
            attributes : {
              type : "text/javascript",
              async : "true",
              src : scaytUrl
            }
          }));
        } else {
          self.fireOnce("scaytReady");
        }
        return null;
      },
      parseUrl : function(data) {
        var match;
        if (data.match && (match = data.match(/(.*)[\/\\](.*?\.\w+)$/))) {
          return{
            path : match[1],
            file : match[2]
          };
        } else {
          return data;
        }
      }
    };
    var plugin = editor.scayt;
    var addButtonCommand = function(editor, buttonName, buttonLabel, commandName, command, menugroup, expectedNumberOfNonCommentArgs) {
      editor.addCommand(commandName, command);
      editor.addMenuItem(commandName, {
        label : buttonLabel,
        command : commandName,
        group : menugroup,
        order : expectedNumberOfNonCommentArgs
      });
    };
    var commandDefinition = {
      preserveState : true,
      editorFocus : false,
      canUndo : false,
      exec : function(editor) {
        if (plugin.isScaytReady(editor)) {
          var isEnabled = plugin.isScaytEnabled(editor);
          this.setState(isEnabled ? 2 : 1);
          var scayt_control = plugin.getScayt(editor);
          scayt_control.focus();
          scayt_control.setDisabled(isEnabled);
        } else {
          if (!editor.config.scayt_autoStartup && plugin.engineLoaded >= 0) {
            this.setState(0);
            plugin.loadEngine(editor);
          }
        }
      }
    };
    editor.add("scayt", {
      requires : ["menubutton"],
      beforeInit : function(editor) {
        var items_order = editor.config.scayt_contextMenuItemsOrder || "suggest|moresuggest|control";
        var items_order_str = "";
        items_order = items_order.split("|");
        if (items_order && items_order.length) {
          var pos = 0;
          for (;pos < items_order.length;pos++) {
            items_order_str += "scayt_" + items_order[pos] + (items_order.length != parseInt(pos, 10) + 1 ? "," : "");
          }
        }
        editor.config.menu_groups = items_order_str + "," + editor.config.menu_groups;
      },
      init : function(editor) {
        var htmlFilter = editor.dataProcessor && editor.dataProcessor.dataFilter;
        var htmlFilterRules = {
          elements : {
            span : function(name) {
              var attrs = name.attributes;
              if (attrs && attrs["data-scaytid"]) {
                delete name.name;
              }
            }
          }
        };
        if (htmlFilter) {
          htmlFilter.addRules(htmlFilterRules);
        }
        var moreSuggestions = {};
        var mainSuggestions = {};
        var command = editor.addCommand(optgroup, commandDefinition);
        self.dialog.add(optgroup, self.getUrl(this.path + "dialogs/options.js"));
        var scayt_instance = plugin.getUiTabs(editor);
        var menuGroup = "scaytButton";
        editor.addMenuGroup(menuGroup);
        var uiMenuItems = {};
        var lang = editor.lang.scayt;
        uiMenuItems.scaytToggle = {
          label : lang.enable,
          command : optgroup,
          group : menuGroup
        };
        if (scayt_instance[0] == 1) {
          uiMenuItems.scaytOptions = {
            label : lang.options,
            group : menuGroup,
            onClick : function() {
              openPage = "options";
              editor.openDialog(optgroup);
            }
          };
        }
        if (scayt_instance[1] == 1) {
          uiMenuItems.scaytLangs = {
            label : lang.langs,
            group : menuGroup,
            onClick : function() {
              openPage = "langs";
              editor.openDialog(optgroup);
            }
          };
        }
        if (scayt_instance[2] == 1) {
          uiMenuItems.scaytDict = {
            label : lang.dictionariesTab,
            group : menuGroup,
            onClick : function() {
              openPage = "dictionaries";
              editor.openDialog(optgroup);
            }
          };
        }
        uiMenuItems.scaytAbout = {
          label : editor.lang.scayt.about,
          group : menuGroup,
          onClick : function() {
            openPage = "about";
            editor.openDialog(optgroup);
          }
        };
        editor.addMenuItems(uiMenuItems);
        editor.ui.add("Scayt", "menubutton", {
          label : lang.title,
          title : env.opera ? lang.opera_title : lang.title,
          className : "cke_button_scayt",
          modes : {
            wysiwyg : 1
          },
          onRender : function() {
            command.on("state", function() {
              this.setState(command.state);
            }, this);
          },
          onMenu : function() {
            var isEnabled = plugin.isScaytEnabled(editor);
            editor.getMenuItem("scaytToggle").label = lang[isEnabled ? "disable" : "enable"];
            var uiTabs = plugin.getUiTabs(editor);
            return{
              scaytToggle : 2,
              scaytOptions : isEnabled && uiTabs[0] ? 2 : 0,
              scaytLangs : isEnabled && uiTabs[1] ? 2 : 0,
              scaytDict : isEnabled && uiTabs[2] ? 2 : 0,
              scaytAbout : isEnabled && uiTabs[3] ? 2 : 0
            };
          }
        });
        if (editor.contextMenu && editor.addMenuItems) {
          editor.contextMenu.addListener(function(dataAndEvents, selection) {
            if (!plugin.isScaytEnabled(editor) || selection.getRanges()[0].checkReadOnly()) {
              return null;
            }
            var scayt_control = plugin.getScayt(editor);
            var node = scayt_control.getScaytNode();
            if (!node) {
              return null;
            }
            var word = scayt_control.getWord(node);
            if (!word) {
              return null;
            }
            var sLang = scayt_control.getLang();
            var commands = {};
            var items_suggestion = window.scayt.getSuggestion(word, sLang);
            if (!items_suggestion || !items_suggestion.length) {
              return null;
            }
            var m;
            for (m in moreSuggestions) {
              delete editor._.menuItems[m];
              delete editor._.commands[m];
            }
            for (m in mainSuggestions) {
              delete editor._.menuItems[m];
              delete editor._.commands[m];
            }
            moreSuggestions = {};
            mainSuggestions = {};
            var moreSuggestionsUnable = editor.config.scayt_moreSuggestions || "on";
            var O = false;
            var maxSuggestions = editor.config.scayt_maxSuggestions;
            if (typeof maxSuggestions != "number") {
              maxSuggestions = 5;
            }
            if (!maxSuggestions) {
              maxSuggestions = items_suggestion.length;
            }
            var contextCommands = editor.config.scayt_contextCommands || "all";
            contextCommands = contextCommands.split("|");
            var i = 0;
            var l = items_suggestion.length;
            for (;i < l;i += 1) {
              var commandName = "scayt_suggestion_" + items_suggestion[i].replace(" ", "_");
              var exec = function(optgroup, isXML) {
                return{
                  exec : function() {
                    scayt_control.replace(optgroup, isXML);
                  }
                };
              }(node, items_suggestion[i]);
              if (i < maxSuggestions) {
                addButtonCommand(editor, "button_" + commandName, items_suggestion[i], commandName, exec, "scayt_suggest", i + 1);
                commands[commandName] = 2;
                mainSuggestions[commandName] = 2;
              } else {
                if (moreSuggestionsUnable == "on") {
                  addButtonCommand(editor, "button_" + commandName, items_suggestion[i], commandName, exec, "scayt_moresuggest", i + 1);
                  moreSuggestions[commandName] = 2;
                  O = true;
                }
              }
            }
            if (O) {
              editor.addMenuItem("scayt_moresuggest", {
                label : lang.moreSuggestions,
                group : "scayt_moresuggest",
                order : 10,
                getItems : function() {
                  return moreSuggestions;
                }
              });
              mainSuggestions.scayt_moresuggest = 2;
            }
            if (in_array("all", contextCommands) || in_array("ignore", contextCommands)) {
              var ignore_all_command = {
                exec : function() {
                  scayt_control.ignore(node);
                }
              };
              addButtonCommand(editor, "ignore", lang.ignore, "scayt_ignore", ignore_all_command, "scayt_control", 1);
              mainSuggestions.scayt_ignore = 2;
            }
            if (in_array("all", contextCommands) || in_array("ignoreall", contextCommands)) {
              var ignore_command = {
                exec : function() {
                  scayt_control.ignoreAll(node);
                }
              };
              addButtonCommand(editor, "ignore_all", lang.ignoreAll, "scayt_ignore_all", ignore_command, "scayt_control", 2);
              mainSuggestions.scayt_ignore_all = 2;
            }
            if (in_array("all", contextCommands) || in_array("add", contextCommands)) {
              var addword_command = {
                exec : function() {
                  window.scayt.addWordToUserDictionary(node);
                }
              };
              addButtonCommand(editor, "add_word", lang.addWord, "scayt_add_word", addword_command, "scayt_control", 3);
              mainSuggestions.scayt_add_word = 2;
            }
            if (scayt_control.fireOnContextMenu) {
              scayt_control.fireOnContextMenu(editor);
            }
            return mainSuggestions;
          });
        }
        var showInitialState = function() {
          editor.removeListener("showScaytState", showInitialState);
          if (!env.opera && !env.air) {
            command.setState(plugin.isScaytEnabled(editor) ? 1 : 2);
          } else {
            command.setState(0);
          }
        };
        editor.on("showScaytState", showInitialState);
        if (env.opera || env.air) {
          editor.on("instanceReady", function() {
            showInitialState();
          });
        }
        if (editor.config.scayt_autoStartup) {
          editor.on("instanceReady", function() {
            plugin.loadEngine(editor);
          });
        }
      },
      afterInit : function(editor) {
        var elementsPathFilters;
        var scaytFilter = function(element) {
          if (element.hasAttribute("data-scaytid")) {
            return false;
          }
        };
        if (editor._.elementsPath && (elementsPathFilters = editor._.elementsPath.filters)) {
          elementsPathFilters.push(scaytFilter);
        }
        if (editor.addRemoveFormatFilter) {
          editor.addRemoveFormatFilter(scaytFilter);
        }
      }
    });
  })();
  editor.add("smiley", {
    requires : ["dialog"],
    init : function(editor) {
      editor.config.smiley_path = editor.config.smiley_path || this.path + "images/";
      editor.addCommand("smiley", new self.dialogCommand("smiley"));
      editor.ui.addButton("Smiley", {
        label : editor.lang.smiley.toolbar,
        command : "smiley"
      });
      self.dialog.add("smiley", this.path + "dialogs/smiley.js");
    }
  });
  config.smiley_images = ["regular_smile.gif", "sad_smile.gif", "wink_smile.gif", "teeth_smile.gif", "confused_smile.gif", "tounge_smile.gif", "embaressed_smile.gif", "omg_smile.gif", "whatchutalkingabout_smile.gif", "angry_smile.gif", "angel_smile.gif", "shades_smile.gif", "devil_smile.gif", "cry_smile.gif", "lightbulb.gif", "thumbs_down.gif", "thumbs_up.gif", "heart.gif", "broken_heart.gif", "kiss.gif", "envelope.gif"];
  config.smiley_descriptions = ["smiley", "sad", "wink", "laugh", "frown", "cheeky", "blush", "surprise", "indecision", "angry", "angel", "cool", "devil", "crying", "enlightened", "no", "yes", "heart", "broken heart", "kiss", "mail"];
  (function() {
    var option = ".%2 p,.%2 div,.%2 pre,.%2 address,.%2 blockquote,.%2 h1,.%2 h2,.%2 h3,.%2 h4,.%2 h5,.%2 h6{background-repeat: no-repeat;background-position: top %3;border: 1px dotted gray;padding-top: 8px;padding-%3: 8px;}.%2 p{%1p.png);}.%2 div{%1div.png);}.%2 pre{%1pre.png);}.%2 address{%1address.png);}.%2 blockquote{%1blockquote.png);}.%2 h1{%1h1.png);}.%2 h2{%1h2.png);}.%2 h3{%1h3.png);}.%2 h4{%1h4.png);}.%2 h5{%1h5.png);}.%2 h6{%1h6.png);}";
    var optgroup = /%1/g;
    var rvar = /%2/g;
    var vvarText = /%3/g;
    var commandDefinition = {
      readOnly : 1,
      preserveState : true,
      editorFocus : false,
      exec : function(editor) {
        this.toggleState();
        this.refresh(editor);
      },
      refresh : function(editor) {
        if (editor.document) {
          var funcName = this.state == 1 ? "addClass" : "removeClass";
          editor.document.getBody()[funcName]("cke_show_blocks");
        }
      }
    };
    editor.add("showblocks", {
      requires : ["wysiwygarea"],
      init : function(editor) {
        var command = editor.addCommand("showblocks", commandDefinition);
        command.canUndo = false;
        if (editor.config.startupOutlineBlocks) {
          command.setState(1);
        }
        editor.addCss(option.replace(optgroup, "background-image: url(" + self.getUrl(this.path) + "images/block_").replace(rvar, "cke_show_blocks ").replace(vvarText, editor.lang.dir == "rtl" ? "right" : "left"));
        editor.ui.addButton("ShowBlocks", {
          label : editor.lang.showBlocks,
          command : "showblocks"
        });
        editor.on("mode", function() {
          if (command.state != 0) {
            command.refresh(editor);
          }
        });
        editor.on("contentDom", function() {
          if (command.state != 0) {
            command.refresh(editor);
          }
        });
      }
    });
  })();
  (function() {
    var name = "cke_show_border";
    var css;
    var out = (env.ie6Compat ? [".%1 table.%2,", ".%1 table.%2 td, .%1 table.%2 th", "{", "border : #d3d3d3 1px dotted", "}"] : [".%1 table.%2,", ".%1 table.%2 > tr > td, .%1 table.%2 > tr > th,", ".%1 table.%2 > tbody > tr > td, .%1 table.%2 > tbody > tr > th,", ".%1 table.%2 > thead > tr > td, .%1 table.%2 > thead > tr > th,", ".%1 table.%2 > tfoot > tr > td, .%1 table.%2 > tfoot > tr > th", "{", "border : #d3d3d3 1px dotted", "}"]).join("");
    css = out.replace(/%2/g, name).replace(/%1/g, "cke_show_borders ");
    var commandDefinition = {
      preserveState : true,
      editorFocus : false,
      readOnly : 1,
      exec : function(editor) {
        this.toggleState();
        this.refresh(editor);
      },
      refresh : function(editor) {
        if (editor.document) {
          var funcName = this.state == 1 ? "addClass" : "removeClass";
          editor.document.getBody()[funcName]("cke_show_borders");
        }
      }
    };
    editor.add("showborders", {
      requires : ["wysiwygarea"],
      modes : {
        wysiwyg : 1
      },
      init : function(editor) {
        var command = editor.addCommand("showborders", commandDefinition);
        command.canUndo = false;
        if (editor.config.startupShowBorders !== false) {
          command.setState(1);
        }
        editor.addCss(css);
        editor.on("mode", function() {
          if (command.state != 0) {
            command.refresh(editor);
          }
        }, null, null, 100);
        editor.on("contentDom", function() {
          if (command.state != 0) {
            command.refresh(editor);
          }
        });
        editor.on("removeFormatCleanup", function(evt) {
          var element = evt.data;
          if (editor.getCommand("showborders").state == 1 && (element.is("table") && (!element.hasAttribute("border") || parseInt(element.getAttribute("border"), 10) <= 0))) {
            element.addClass(name);
          }
        });
      },
      afterInit : function(editor) {
        var dataProcessor = editor.dataProcessor;
        var dataFilter = dataProcessor && dataProcessor.dataFilter;
        var htmlFilter = dataProcessor && dataProcessor.htmlFilter;
        if (dataFilter) {
          dataFilter.addRules({
            elements : {
              table : function(element) {
                var attributes = element.attributes;
                var cls = attributes["class"];
                var border = parseInt(attributes.border, 10);
                if ((!border || border <= 0) && (!cls || cls.indexOf(name) == -1)) {
                  attributes["class"] = (cls || "") + " " + name;
                }
              }
            }
          });
        }
        if (htmlFilter) {
          htmlFilter.addRules({
            elements : {
              table : function(element) {
                var attributes = element.attributes;
                var cls = attributes["class"];
                if (cls) {
                  attributes["class"] = cls.replace(name, "").replace(/\s{2}/, " ").replace(/^\s+|\s+$/, "");
                }
              }
            }
          });
        }
      }
    });
    self.on("dialogDefinition", function(ev) {
      var dialogName = ev.data.name;
      if (dialogName == "table" || dialogName == "tableProperties") {
        var dialogDefinition = ev.data.definition;
        var infoTab = dialogDefinition.getContents("info");
        var borderField = infoTab.get("txtBorder");
        var override = borderField.commit;
        borderField.commit = $.override(override, function(matcherFunction) {
          return function(dataAndEvents, obj) {
            matcherFunction.apply(this, arguments);
            var border = parseInt(this.getValue(), 10);
            obj[!border || border <= 0 ? "addClass" : "removeClass"](name);
          };
        });
        var advTab = dialogDefinition.getContents("advanced");
        var classField = advTab && advTab.get("advCSSClasses");
        if (classField) {
          classField.setup = $.override(classField.setup, function(matcherFunction) {
            return function() {
              matcherFunction.apply(this, arguments);
              this.setValue(this.getValue().replace(/cke_show_border/, ""));
            };
          });
          classField.commit = $.override(classField.commit, function(matcherFunction) {
            return function(dataAndEvents, element) {
              matcherFunction.apply(this, arguments);
              if (!parseInt(element.getAttribute("border"), 10)) {
                element.addClass("cke_show_border");
              }
            };
          });
        }
      }
    });
  })();
  editor.add("sourcearea", {
    requires : ["editingblock"],
    init : function(el) {
      var sourcearea = editor.sourcearea;
      var win = self.document.getWindow();
      el.on("editingBlockReady", function() {
        var textarea;
        var onResize;
        el.addMode("source", {
          load : function(container, options) {
            if (href && env.version < 8) {
              container.setStyle("position", "relative");
            }
            el.textarea = textarea = new Node("textarea");
            textarea.setAttributes({
              dir : "ltr",
              tabIndex : env.webkit ? -1 : el.tabIndex,
              role : "textbox",
              "aria-label" : el.lang.editorTitle.replace("%1", el.name)
            });
            textarea.addClass("cke_source");
            textarea.addClass("cke_enable_context_menu");
            if (el.readOnly) {
              textarea.setAttribute("readOnly", "readonly");
            }
            var styles = {
              width : env.ie7Compat ? "99%" : "100%",
              height : "100%",
              resize : "none",
              outline : "none",
              "text-align" : "left"
            };
            if (href) {
              onResize = function() {
                textarea.hide();
                textarea.setStyle("height", container.$.clientHeight + "px");
                textarea.setStyle("width", container.$.clientWidth + "px");
                textarea.show();
              };
              el.on("resize", onResize);
              win.on("resize", onResize);
              setTimeout(onResize, 0);
            }
            container.setHtml("");
            container.append(textarea);
            textarea.setStyles(styles);
            el.fire("ariaWidget", textarea);
            textarea.on("blur", function() {
              el.focusManager.blur();
            });
            textarea.on("focus", function() {
              el.focusManager.focus();
            });
            el.mayBeDirty = true;
            this.loadData(options);
            var keystrokeHandler = el.keystrokeHandler;
            if (keystrokeHandler) {
              keystrokeHandler.attach(textarea);
            }
            setTimeout(function() {
              el.mode = "source";
              el.fire("mode", {
                previousMode : el._.previousMode
              });
            }, env.gecko || env.webkit ? 100 : 0);
          },
          loadData : function(val) {
            textarea.setValue(val);
            el.fire("dataReady");
          },
          getData : function() {
            return textarea.getValue();
          },
          getSnapshotData : function() {
            return textarea.getValue();
          },
          unload : function(options) {
            textarea.clearCustomData();
            el.textarea = textarea = null;
            if (onResize) {
              el.removeListener("resize", onResize);
              win.removeListener("resize", onResize);
            }
            if (href && env.version < 8) {
              options.removeStyle("position");
            }
          },
          focus : function() {
            textarea.focus();
          }
        });
      });
      el.on("readOnly", function() {
        if (el.mode == "source") {
          if (el.readOnly) {
            el.textarea.setAttribute("readOnly", "readonly");
          } else {
            el.textarea.removeAttribute("readOnly");
          }
        }
      });
      el.addCommand("source", sourcearea.commands.source);
      if (el.ui.addButton) {
        el.ui.addButton("Source", {
          label : el.lang.source,
          command : "source"
        });
      }
      el.on("mode", function() {
        el.getCommand("source").setState(el.mode == "source" ? 1 : 2);
      });
    }
  });
  editor.sourcearea = {
    commands : {
      source : {
        modes : {
          wysiwyg : 1,
          source : 1
        },
        editorFocus : false,
        readOnly : 1,
        exec : function(editor) {
          if (editor.mode == "wysiwyg") {
            editor.fire("saveSnapshot");
          }
          editor.getCommand("source").setState(0);
          editor.setMode(editor.mode == "source" ? "wysiwyg" : "source");
        },
        canUndo : false
      }
    }
  };
  (function() {
    function restoreScript(elem, event) {
      var nodeType = elem.type;
      var type = event.type;
      return nodeType == type ? 0 : nodeType == 3 ? -1 : type == 3 ? 1 : type == 1 ? 1 : -1;
    }
    editor.add("stylescombo", {
      requires : ["richcombo", "styles"],
      init : function(editor) {
        function loadStylesSet(callback) {
          editor.getStylesSet(function(coverage) {
            if (!elements.length) {
              var style;
              var name;
              var line = 0;
              var length = coverage.length;
              for (;line < length;line++) {
                var value = coverage[line];
                name = value.name;
                style = styles[name] = new self.style(value);
                style._name = name;
                style._.enterMode = config.enterMode;
                elements.push(style);
              }
              elements.sort(restoreScript);
            }
            if (callback) {
              callback();
            }
          });
        }
        var config = editor.config;
        var lang = editor.lang.stylesCombo;
        var styles = {};
        var elements = [];
        var combo;
        editor.ui.addRichCombo("Styles", {
          label : lang.label,
          title : lang.panelTitle,
          className : "cke_styles",
          panel : {
            css : editor.skin.editor.css.concat(config.contentsCss),
            multiSelect : true,
            attributes : {
              "aria-label" : lang.panelTitle
            }
          },
          init : function() {
            combo = this;
            loadStylesSet(function() {
              var element;
              var optgroup;
              var lastType;
              var type;
              var _i;
              var _len;
              _i = 0;
              _len = elements.length;
              for (;_i < _len;_i++) {
                element = elements[_i];
                optgroup = element._name;
                type = element.type;
                if (type != lastType) {
                  combo.startGroup(lang["panelTitle" + String(type)]);
                  lastType = type;
                }
                combo.add(optgroup, element.type == 3 ? optgroup : element.buildPreview(), optgroup);
              }
              combo.commit();
            });
          },
          onClick : function(name) {
            editor.focus();
            editor.fire("saveSnapshot");
            var style = styles[name];
            var selection = editor.getSelection();
            var elementPath = new dom.elementPath(selection.getStartElement());
            style[style.checkActive(elementPath) ? "remove" : "apply"](editor.document);
            editor.fire("saveSnapshot");
          },
          onRender : function() {
            editor.on("selectionChange", function(evt) {
              var currentValue = this.getValue();
              var elementPath = evt.data.path;
              var elements = elementPath.elements;
              var i = 0;
              var valuesLen = elements.length;
              var element;
              for (;i < valuesLen;i++) {
                element = elements[i];
                var value;
                for (value in styles) {
                  if (styles[value].checkElementRemovable(element, true)) {
                    if (value != currentValue) {
                      this.setValue(value);
                    }
                    return;
                  }
                }
              }
              this.setValue("");
            }, this);
          },
          onOpen : function() {
            var _this = this;
            if (href || env.webkit) {
              editor.focus();
            }
            var sel = editor.getSelection();
            var element = sel.getSelectedElement();
            var elementPath = new dom.elementPath(element || sel.getStartElement());
            var special = [0, 0, 0, 0];
            _this.showAll();
            _this.unmarkAll();
            var optgroup;
            for (optgroup in styles) {
              var style = styles[optgroup];
              var type = style.type;
              if (style.checkActive(elementPath)) {
                _this.mark(optgroup);
              } else {
                if (type == 3 && !style.checkApplicable(elementPath)) {
                  _this.hideItem(optgroup);
                  special[type]--;
                }
              }
              special[type]++;
            }
            if (!special[1]) {
              _this.hideGroup(lang["panelTitle" + String(1)]);
            }
            if (!special[2]) {
              _this.hideGroup(lang["panelTitle" + String(2)]);
            }
            if (!special[3]) {
              _this.hideGroup(lang["panelTitle" + String(3)]);
            }
          },
          reset : function() {
            if (combo) {
              delete combo._.panel;
              delete combo._.list;
              combo._.committed = 0;
              combo._.items = {};
              combo._.state = 2;
            }
            styles = {};
            elements = [];
            loadStylesSet();
          }
        });
        editor.on("instanceReady", function() {
          loadStylesSet();
        });
      }
    });
  })();
  editor.add("table", {
    requires : ["dialog"],
    init : function(instance) {
      var table = editor.table;
      var lang = instance.lang.table;
      instance.addCommand("table", new self.dialogCommand("table"));
      instance.addCommand("tableProperties", new self.dialogCommand("tableProperties"));
      instance.ui.addButton("Table", {
        label : lang.toolbar,
        command : "table"
      });
      self.dialog.add("table", this.path + "dialogs/table.js");
      self.dialog.add("tableProperties", this.path + "dialogs/table.js");
      if (instance.addMenuItems) {
        instance.addMenuItems({
          table : {
            label : lang.menu,
            command : "tableProperties",
            group : "table",
            order : 5
          },
          tabledelete : {
            label : lang.deleteTable,
            command : "tableDelete",
            group : "table",
            order : 1
          }
        });
      }
      instance.on("doubleclick", function(evt) {
        var el = evt.data.element;
        if (el.is("table")) {
          evt.data.dialog = "tableProperties";
        }
      });
      if (instance.contextMenu) {
        instance.contextMenu.addListener(function(element, dataAndEvents) {
          if (!element || element.isReadOnly()) {
            return null;
          }
          var tableEl = element.hasAscendant("table", 1);
          if (tableEl) {
            return{
              tabledelete : 2,
              table : 2
            };
          }
          return null;
        });
      }
    }
  });
  (function() {
    function getSelectedCells(selection) {
      function moveOutOfCellGuard(node) {
        if (ancestors.length > 0) {
          return;
        }
        if (node.type == 1 && (rhtml.test(node.getName()) && !node.getCustomData("selected_cell"))) {
          Node.setMarker(database, node, "selected_cell", true);
          ancestors.push(node);
        }
      }
      var codeSegments = selection.getRanges();
      var ancestors = [];
      var database = {};
      var i = 0;
      for (;i < codeSegments.length;i++) {
        var range = codeSegments[i];
        if (range.collapsed) {
          var startElement = range.getCommonAncestor();
          var copies = startElement.getAscendant("td", true) || startElement.getAscendant("th", true);
          if (copies) {
            ancestors.push(copies);
          }
        } else {
          var walker = new dom.walker(range);
          var ancestor;
          walker.guard = moveOutOfCellGuard;
          for (;ancestor = walker.next();) {
            var node = ancestor.getAscendant("td") || ancestor.getAscendant("th");
            if (node && !node.getCustomData("selected_cell")) {
              Node.setMarker(database, node, "selected_cell", true);
              ancestors.push(node);
            }
          }
        }
      }
      Node.clearAllMarkers(database);
      return ancestors;
    }
    function getFocusElementAfterDelCells(cellsToDelete) {
      var i = 0;
      var last = cellsToDelete.length - 1;
      var database = {};
      var cell;
      var focusedCell;
      var tr;
      for (;cell = cellsToDelete[i++];) {
        Node.setMarker(database, cell, "delete_cell", true);
      }
      i = 0;
      for (;cell = cellsToDelete[i++];) {
        if ((focusedCell = cell.getPrevious()) && !focusedCell.getCustomData("delete_cell") || (focusedCell = cell.getNext()) && !focusedCell.getCustomData("delete_cell")) {
          Node.clearAllMarkers(database);
          return focusedCell;
        }
      }
      Node.clearAllMarkers(database);
      tr = cellsToDelete[0].getParent();
      if (tr = tr.getPrevious()) {
        return tr.getLast();
      }
      tr = cellsToDelete[last].getParent();
      if (tr = tr.getNext()) {
        return tr.getChild(0);
      }
      return null;
    }
    function insertRow(selection, one) {
      var cells = getSelectedCells(selection);
      var firstCell = cells[0];
      var table = firstCell.getAscendant("table");
      var d = firstCell.getDocument();
      var tr = cells[0].getParent();
      var index = tr.$.rowIndex;
      var lastCell = cells[cells.length - 1];
      var j = lastCell.getParent().$.rowIndex + lastCell.$.rowSpan - 1;
      var t = new Node(table.$.rows[j]);
      var i = one ? index : j;
      var optgroup = one ? tr : t;
      var lines = $.buildTableMap(table);
      var line = lines[i];
      var values = one ? lines[i - 1] : lines[i + 1];
      var numrows = lines[0].length;
      var row = d.createElement("tr");
      var k = 0;
      for (;line[k] && k < numrows;k++) {
        var cell;
        if (line[k].rowSpan > 1 && (values && line[k] == values[k])) {
          cell = line[k];
          cell.rowSpan += 1;
        } else {
          cell = (new Node(line[k])).clone();
          cell.removeAttribute("rowSpan");
          if (!href) {
            cell.appendBogus();
          }
          row.append(cell);
          cell = cell.$;
        }
        k += cell.colSpan - 1;
      }
      if (one) {
        row.insertBefore(optgroup);
      } else {
        row.insertAfter(optgroup);
      }
    }
    function deleteRows(selectionOrRow) {
      if (selectionOrRow instanceof dom.selection) {
        var cells = getSelectedCells(selectionOrRow);
        var firstCell = cells[0];
        var table = firstCell.getAscendant("table");
        var spec = $.buildTableMap(table);
        var tr = cells[0].getParent();
        var startRowIndex = tr.$.rowIndex;
        var lastCell = cells[cells.length - 1];
        var endRowIndex = lastCell.getParent().$.rowIndex + lastCell.$.rowSpan - 1;
        var rowsToDelete = [];
        var i = startRowIndex;
        for (;i <= endRowIndex;i++) {
          var tp = spec[i];
          var row = new Node(table.$.rows[i]);
          var j = 0;
          for (;j < tp.length;j++) {
            var cell = new Node(tp[j]);
            var cellRowIndex = cell.getParent().$.rowIndex;
            if (cell.$.rowSpan == 1) {
              cell.remove();
            } else {
              cell.$.rowSpan -= 1;
              if (cellRowIndex == i) {
                var a = spec[i + 1];
                if (a[j - 1]) {
                  cell.insertAfter(new Node(a[j - 1]));
                } else {
                  (new Node(table.$.rows[i + 1])).append(cell, 1);
                }
              }
            }
            j += cell.$.colSpan - 1;
          }
          rowsToDelete.push(row);
        }
        var rows = table.$.rows;
        var t = new Node(rows[endRowIndex + 1] || ((startRowIndex > 0 ? rows[startRowIndex - 1] : null) || table.$.parentNode));
        i = rowsToDelete.length;
        for (;i >= 0;i--) {
          deleteRows(rowsToDelete[i]);
        }
        return t;
      } else {
        if (selectionOrRow instanceof Node) {
          table = selectionOrRow.getAscendant("table");
          if (table.$.rows.length == 1) {
            table.remove();
          } else {
            selectionOrRow.remove();
          }
        }
      }
      return null;
    }
    function getCellColIndex(cell, isStart) {
      var row = cell.getParent();
      var codeSegments = row.$.cells;
      var colIndex = 0;
      var i = 0;
      for (;i < codeSegments.length;i++) {
        var mapCell = codeSegments[i];
        colIndex += isStart ? 1 : mapCell.colSpan;
        if (mapCell == cell.$) {
          break;
        }
      }
      return colIndex - 1;
    }
    function getColumnsIndices(cells, isStart) {
      var retval = isStart ? Infinity : 0;
      var i = 0;
      for (;i < cells.length;i++) {
        var colIndex = getCellColIndex(cells[i], isStart);
        if (isStart ? colIndex < retval : colIndex > retval) {
          retval = colIndex;
        }
      }
      return retval;
    }
    function insertColumn(selection, insertBefore) {
      var cells = getSelectedCells(selection);
      var firstCell = cells[0];
      var table = firstCell.getAscendant("table");
      var startCol = getColumnsIndices(cells, 1);
      var lastCol = getColumnsIndices(cells);
      var colIndex = insertBefore ? startCol : lastCol;
      var map = $.buildTableMap(table);
      var cloneCol = [];
      var configList = [];
      var len = map.length;
      var i = 0;
      for (;i < len;i++) {
        cloneCol.push(map[i][colIndex]);
        var copies = insertBefore ? map[i][colIndex - 1] : map[i][colIndex + 1];
        if (copies) {
          configList.push(copies);
        }
      }
      i = 0;
      for (;i < len;i++) {
        var optgroup;
        if (cloneCol[i].colSpan > 1 && (configList.length && configList[i] == cloneCol[i])) {
          optgroup = cloneCol[i];
          optgroup.colSpan += 1;
        } else {
          optgroup = (new Node(cloneCol[i])).clone();
          optgroup.removeAttribute("colSpan");
          if (!href) {
            optgroup.appendBogus();
          }
          optgroup[insertBefore ? "insertBefore" : "insertAfter"].call(optgroup, new Node(cloneCol[i]));
          optgroup = optgroup.$;
        }
        i += optgroup.rowSpan - 1;
      }
    }
    function deleteColumns(selectionOrCell) {
      var cells = getSelectedCells(selectionOrCell);
      var firstCell = cells[0];
      var lastCell = cells[cells.length - 1];
      var table = firstCell.getAscendant("table");
      var matches = $.buildTableMap(table);
      var startColIndex;
      var end;
      var empty_rows = [];
      var i = 0;
      var n = matches.length;
      for (;i < n;i++) {
        var j = 0;
        var jl = matches[i].length;
        for (;j < jl;j++) {
          if (matches[i][j] == firstCell.$) {
            startColIndex = j;
          }
          if (matches[i][j] == lastCell.$) {
            end = j;
          }
        }
      }
      i = startColIndex;
      for (;i <= end;i++) {
        j = 0;
        for (;j < matches.length;j++) {
          var a = matches[j];
          var row = new Node(table.$.rows[j]);
          var cell = new Node(a[i]);
          if (cell.$) {
            if (cell.$.colSpan == 1) {
              cell.remove();
            } else {
              cell.$.colSpan -= 1;
            }
            j += cell.$.rowSpan - 1;
            if (!row.$.cells.length) {
              empty_rows.push(row);
            }
          }
        }
      }
      var firstRowCells = table.$.rows[0] && table.$.rows[0].cells;
      var t = new Node(firstRowCells[startColIndex] || (startColIndex ? firstRowCells[startColIndex - 1] : table.$.parentNode));
      if (empty_rows.length == n) {
        table.remove();
      }
      return t;
    }
    function getFocusElementAfterDelCols(cells) {
      var cellIndexList = [];
      var table = cells[0] && cells[0].getAscendant("table");
      var i;
      var length;
      var targetIndex;
      var targetCell;
      i = 0;
      length = cells.length;
      for (;i < length;i++) {
        cellIndexList.push(cells[i].$.cellIndex);
      }
      cellIndexList.sort();
      i = 1;
      length = cellIndexList.length;
      for (;i < length;i++) {
        if (cellIndexList[i] - cellIndexList[i - 1] > 1) {
          targetIndex = cellIndexList[i - 1] + 1;
          break;
        }
      }
      if (!targetIndex) {
        targetIndex = cellIndexList[0] > 0 ? cellIndexList[0] - 1 : cellIndexList[cellIndexList.length - 1] + 1;
      }
      var rows = table.$.rows;
      i = 0;
      length = rows.length;
      for (;i < length;i++) {
        targetCell = rows[i].cells[targetIndex];
        if (targetCell) {
          break;
        }
      }
      return targetCell ? new Node(targetCell) : table.getPrevious();
    }
    function insertCell(selection, dataAndEvents) {
      var startElement = selection.getStartElement();
      var optgroup = startElement.getAscendant("td", 1) || startElement.getAscendant("th", 1);
      if (!optgroup) {
        return;
      }
      var element = optgroup.clone();
      if (!href) {
        element.appendBogus();
      }
      if (dataAndEvents) {
        element.insertBefore(optgroup);
      } else {
        element.insertAfter(optgroup);
      }
    }
    function deleteCells(selectionOrCell) {
      if (selectionOrCell instanceof dom.selection) {
        var cellsToDelete = getSelectedCells(selectionOrCell);
        var selfObj = cellsToDelete[0] && cellsToDelete[0].getAscendant("table");
        var cellToFocus = getFocusElementAfterDelCells(cellsToDelete);
        var i = cellsToDelete.length - 1;
        for (;i >= 0;i--) {
          deleteCells(cellsToDelete[i]);
        }
        if (cellToFocus) {
          placeCursorInCell(cellToFocus, true);
        } else {
          if (selfObj) {
            selfObj.remove();
          }
        }
      } else {
        if (selectionOrCell instanceof Node) {
          var tr = selectionOrCell.getParent();
          if (tr.getChildCount() == 1) {
            tr.remove();
          } else {
            selectionOrCell.remove();
          }
        }
      }
    }
    function trimCell(cell) {
      var selfObj = cell.getBogus();
      if (selfObj) {
        selfObj.remove();
      }
      cell.trim();
    }
    function placeCursorInCell(cell, placeAtEnd) {
      var range = new dom.range(cell.getDocument());
      if (!range["moveToElementEdit" + (placeAtEnd ? "End" : "Start")](cell)) {
        range.selectNodeContents(cell);
        range.collapse(placeAtEnd ? false : true);
      }
      range.select(true);
    }
    function cellInRow(tableMap, rowIndex, cell) {
      var oRow = tableMap[rowIndex];
      if (typeof cell == "undefined") {
        return oRow;
      }
      var c = 0;
      for (;oRow && c < oRow.length;c++) {
        if (cell.is && oRow[c] == cell.$) {
          return c;
        } else {
          if (c == cell) {
            return new Node(oRow[c]);
          }
        }
      }
      return cell.is ? -1 : null;
    }
    function cellInCol(tableMap, colIndex) {
      var oCol = [];
      var r = 0;
      for (;r < tableMap.length;r++) {
        var row = tableMap[r];
        oCol.push(row[colIndex]);
        if (row[colIndex].rowSpan > 1) {
          r += row[colIndex].rowSpan - 1;
        }
      }
      return oCol;
    }
    function mergeCells(selection, mergeDirection, dataAndEvents) {
      var cells = getSelectedCells(selection);
      var t;
      if ((mergeDirection ? cells.length != 1 : cells.length < 2) || (t = selection.getCommonAncestor()) && (t.type == 1 && t.is("table"))) {
        return false;
      }
      var cell;
      var firstCell = cells[0];
      var table = firstCell.getAscendant("table");
      var map = $.buildTableMap(table);
      var mapHeight = map.length;
      var cnl = map[0].length;
      var startRow = firstCell.getParent().$.rowIndex;
      var startColumn = cellInRow(map, startRow, firstCell);
      if (mergeDirection) {
        var targetCell;
        try {
          var rowspan = parseInt(firstCell.getAttribute("rowspan"), 10) || 1;
          var colspan = parseInt(firstCell.getAttribute("colspan"), 10) || 1;
          targetCell = map[mergeDirection == "up" ? startRow - rowspan : mergeDirection == "down" ? startRow + rowspan : startRow][mergeDirection == "left" ? startColumn - colspan : mergeDirection == "right" ? startColumn + colspan : startColumn];
        } catch (an) {
          return false;
        }
        if (!targetCell || firstCell.$ == targetCell) {
          return false;
        }
        cells[mergeDirection == "up" || mergeDirection == "left" ? "unshift" : "push"](new Node(targetCell));
      }
      var doc = firstCell.getDocument();
      var lastRowIndex = startRow;
      var totalRowSpan = 0;
      var totalColSpan = 0;
      var frag = !dataAndEvents && new dom.documentFragment(doc);
      var dimension = 0;
      var i = 0;
      for (;i < cells.length;i++) {
        cell = cells[i];
        var tr = cell.getParent();
        var cellFirstChild = cell.getFirst();
        var colSpan = cell.$.colSpan;
        var rowSpan = cell.$.rowSpan;
        var rowIndex = tr.$.rowIndex;
        var colIndex = cellInRow(map, rowIndex, cell);
        dimension += colSpan * rowSpan;
        totalColSpan = Math.max(totalColSpan, colIndex - startColumn + colSpan);
        totalRowSpan = Math.max(totalRowSpan, rowIndex - startRow + rowSpan);
        if (!dataAndEvents) {
          if (trimCell(cell), cell.getChildren().count()) {
            if (rowIndex != lastRowIndex && (cellFirstChild && !(cellFirstChild.isBlockBoundary && cellFirstChild.isBlockBoundary({
              br : 1
            })))) {
              var last = frag.getLast(dom.walker.whitespaces(true));
              if (last && !(last.is && last.is("br"))) {
                frag.append("br");
              }
            }
            cell.moveChildren(frag);
          }
          if (i) {
            cell.remove();
          } else {
            cell.setHtml("");
          }
        }
        lastRowIndex = rowIndex;
      }
      if (!dataAndEvents) {
        frag.moveChildren(firstCell);
        if (!href) {
          firstCell.appendBogus();
        }
        if (totalColSpan >= cnl) {
          firstCell.removeAttribute("rowSpan");
        } else {
          firstCell.$.rowSpan = totalRowSpan;
        }
        if (totalRowSpan >= mapHeight) {
          firstCell.removeAttribute("colSpan");
        } else {
          firstCell.$.colSpan = totalColSpan;
        }
        var trs = new dom.nodeList(table.$.rows);
        var count = trs.count();
        i = count - 1;
        for (;i >= 0;i--) {
          var tailTr = trs.getItem(i);
          if (!tailTr.$.cells.length) {
            tailTr.remove();
            count++;
            continue;
          }
        }
        return firstCell;
      } else {
        return totalRowSpan * totalColSpan == dimension;
      }
    }
    function verticalSplitCell(selection, dataAndEvents) {
      var cells = getSelectedCells(selection);
      if (cells.length > 1) {
        return false;
      } else {
        if (dataAndEvents) {
          return true;
        }
      }
      var cell = cells[0];
      var optgroup = cell.getParent();
      var table = optgroup.getAscendant("table");
      var map = $.buildTableMap(table);
      var rowIndex = optgroup.$.rowIndex;
      var colIndex = cellInRow(map, rowIndex, cell);
      var rowSpan = cell.$.rowSpan;
      var newCell;
      var newRowSpan;
      var newCellRowSpan;
      var newRowIndex;
      if (rowSpan > 1) {
        newRowSpan = Math.ceil(rowSpan / 2);
        newCellRowSpan = Math.floor(rowSpan / 2);
        newRowIndex = rowIndex + newRowSpan;
        var newCellTr = new Node(table.$.rows[newRowIndex]);
        var newCellRow = cellInRow(map, newRowIndex);
        var candidateCell;
        newCell = cell.clone();
        var c = 0;
        for (;c < newCellRow.length;c++) {
          candidateCell = newCellRow[c];
          if (candidateCell.parentNode == newCellTr.$ && c > colIndex) {
            newCell.insertBefore(new Node(candidateCell));
            break;
          } else {
            candidateCell = null;
          }
        }
        if (!candidateCell) {
          newCellTr.append(newCell, true);
        }
      } else {
        newCellRowSpan = newRowSpan = 1;
        newCellTr = optgroup.clone();
        newCellTr.insertAfter(optgroup);
        newCellTr.append(newCell = cell.clone());
        var cellsInSameRow = cellInRow(map, rowIndex);
        var i = 0;
        for (;i < cellsInSameRow.length;i++) {
          cellsInSameRow[i].rowSpan++;
        }
      }
      if (!href) {
        newCell.appendBogus();
      }
      cell.$.rowSpan = newRowSpan;
      newCell.$.rowSpan = newCellRowSpan;
      if (newRowSpan == 1) {
        cell.removeAttribute("rowSpan");
      }
      if (newCellRowSpan == 1) {
        newCell.removeAttribute("rowSpan");
      }
      return newCell;
    }
    function horizontalSplitCell(selection, dataAndEvents) {
      var cells = getSelectedCells(selection);
      if (cells.length > 1) {
        return false;
      } else {
        if (dataAndEvents) {
          return true;
        }
      }
      var optgroup = cells[0];
      var tr = optgroup.getParent();
      var table = tr.getAscendant("table");
      var map = $.buildTableMap(table);
      var rowIndex = tr.$.rowIndex;
      var colIndex = cellInRow(map, rowIndex, optgroup);
      var colSpan = optgroup.$.colSpan;
      var newCell;
      var newColSpan;
      var newCellColSpan;
      if (colSpan > 1) {
        newColSpan = Math.ceil(colSpan / 2);
        newCellColSpan = Math.floor(colSpan / 2);
      } else {
        newCellColSpan = newColSpan = 1;
        var cellsInSameCol = cellInCol(map, colIndex);
        var i = 0;
        for (;i < cellsInSameCol.length;i++) {
          cellsInSameCol[i].colSpan++;
        }
      }
      newCell = optgroup.clone();
      newCell.insertAfter(optgroup);
      if (!href) {
        newCell.appendBogus();
      }
      optgroup.$.colSpan = newColSpan;
      newCell.$.colSpan = newCellColSpan;
      if (newColSpan == 1) {
        optgroup.removeAttribute("colSpan");
      }
      if (newCellColSpan == 1) {
        newCell.removeAttribute("colSpan");
      }
      return newCell;
    }
    var rhtml = /^(?:td|th)$/;
    var contextMenuTags = {
      thead : 1,
      tbody : 1,
      tfoot : 1,
      td : 1,
      tr : 1,
      th : 1
    };
    editor.tabletools = {
      requires : ["table", "dialog", "contextmenu"],
      init : function(editor) {
        var lang = editor.lang.table;
        editor.addCommand("cellProperties", new self.dialogCommand("cellProperties"));
        self.dialog.add("cellProperties", this.path + "dialogs/tableCell.js");
        editor.addCommand("tableDelete", {
          exec : function(editor) {
            var selection = editor.getSelection();
            var startElement = selection && selection.getStartElement();
            var table = startElement && startElement.getAscendant("table", 1);
            if (!table) {
              return;
            }
            var parent = table.getParent();
            if (parent.getChildCount() == 1 && !parent.is("body", "td", "th")) {
              table = parent;
            }
            var range = new dom.range(editor.document);
            range.moveToPosition(table, 3);
            table.remove();
            range.select();
          }
        });
        editor.addCommand("rowDelete", {
          exec : function(editor) {
            var selection = editor.getSelection();
            placeCursorInCell(deleteRows(selection));
          }
        });
        editor.addCommand("rowInsertBefore", {
          exec : function(editor) {
            var selection = editor.getSelection();
            insertRow(selection, true);
          }
        });
        editor.addCommand("rowInsertAfter", {
          exec : function(editor) {
            var selection = editor.getSelection();
            insertRow(selection);
          }
        });
        editor.addCommand("columnDelete", {
          exec : function(editor) {
            var selection = editor.getSelection();
            var element = deleteColumns(selection);
            if (element) {
              placeCursorInCell(element, true);
            }
          }
        });
        editor.addCommand("columnInsertBefore", {
          exec : function(editor) {
            var selection = editor.getSelection();
            insertColumn(selection, true);
          }
        });
        editor.addCommand("columnInsertAfter", {
          exec : function(editor) {
            var selection = editor.getSelection();
            insertColumn(selection);
          }
        });
        editor.addCommand("cellDelete", {
          exec : function(editor) {
            var selection = editor.getSelection();
            deleteCells(selection);
          }
        });
        editor.addCommand("cellMerge", {
          exec : function(editor) {
            placeCursorInCell(mergeCells(editor.getSelection()), true);
          }
        });
        editor.addCommand("cellMergeRight", {
          exec : function(editor) {
            placeCursorInCell(mergeCells(editor.getSelection(), "right"), true);
          }
        });
        editor.addCommand("cellMergeDown", {
          exec : function(editor) {
            placeCursorInCell(mergeCells(editor.getSelection(), "down"), true);
          }
        });
        editor.addCommand("cellVerticalSplit", {
          exec : function(editor) {
            placeCursorInCell(verticalSplitCell(editor.getSelection()));
          }
        });
        editor.addCommand("cellHorizontalSplit", {
          exec : function(editor) {
            placeCursorInCell(horizontalSplitCell(editor.getSelection()));
          }
        });
        editor.addCommand("cellInsertBefore", {
          exec : function(editor) {
            var selection = editor.getSelection();
            insertCell(selection, true);
          }
        });
        editor.addCommand("cellInsertAfter", {
          exec : function(editor) {
            var selection = editor.getSelection();
            insertCell(selection);
          }
        });
        if (editor.addMenuItems) {
          editor.addMenuItems({
            tablecell : {
              label : lang.cell.menu,
              group : "tablecell",
              order : 1,
              getItems : function() {
                var selection = editor.getSelection();
                var cells = getSelectedCells(selection);
                return{
                  tablecell_insertBefore : 2,
                  tablecell_insertAfter : 2,
                  tablecell_delete : 2,
                  tablecell_merge : mergeCells(selection, null, true) ? 2 : 0,
                  tablecell_merge_right : mergeCells(selection, "right", true) ? 2 : 0,
                  tablecell_merge_down : mergeCells(selection, "down", true) ? 2 : 0,
                  tablecell_split_vertical : verticalSplitCell(selection, true) ? 2 : 0,
                  tablecell_split_horizontal : horizontalSplitCell(selection, true) ? 2 : 0,
                  tablecell_properties : cells.length > 0 ? 2 : 0
                };
              }
            },
            tablecell_insertBefore : {
              label : lang.cell.insertBefore,
              group : "tablecell",
              command : "cellInsertBefore",
              order : 5
            },
            tablecell_insertAfter : {
              label : lang.cell.insertAfter,
              group : "tablecell",
              command : "cellInsertAfter",
              order : 10
            },
            tablecell_delete : {
              label : lang.cell.deleteCell,
              group : "tablecell",
              command : "cellDelete",
              order : 15
            },
            tablecell_merge : {
              label : lang.cell.merge,
              group : "tablecell",
              command : "cellMerge",
              order : 16
            },
            tablecell_merge_right : {
              label : lang.cell.mergeRight,
              group : "tablecell",
              command : "cellMergeRight",
              order : 17
            },
            tablecell_merge_down : {
              label : lang.cell.mergeDown,
              group : "tablecell",
              command : "cellMergeDown",
              order : 18
            },
            tablecell_split_horizontal : {
              label : lang.cell.splitHorizontal,
              group : "tablecell",
              command : "cellHorizontalSplit",
              order : 19
            },
            tablecell_split_vertical : {
              label : lang.cell.splitVertical,
              group : "tablecell",
              command : "cellVerticalSplit",
              order : 20
            },
            tablecell_properties : {
              label : lang.cell.title,
              group : "tablecellproperties",
              command : "cellProperties",
              order : 21
            },
            tablerow : {
              label : lang.row.menu,
              group : "tablerow",
              order : 1,
              getItems : function() {
                return{
                  tablerow_insertBefore : 2,
                  tablerow_insertAfter : 2,
                  tablerow_delete : 2
                };
              }
            },
            tablerow_insertBefore : {
              label : lang.row.insertBefore,
              group : "tablerow",
              command : "rowInsertBefore",
              order : 5
            },
            tablerow_insertAfter : {
              label : lang.row.insertAfter,
              group : "tablerow",
              command : "rowInsertAfter",
              order : 10
            },
            tablerow_delete : {
              label : lang.row.deleteRow,
              group : "tablerow",
              command : "rowDelete",
              order : 15
            },
            tablecolumn : {
              label : lang.column.menu,
              group : "tablecolumn",
              order : 1,
              getItems : function() {
                return{
                  tablecolumn_insertBefore : 2,
                  tablecolumn_insertAfter : 2,
                  tablecolumn_delete : 2
                };
              }
            },
            tablecolumn_insertBefore : {
              label : lang.column.insertBefore,
              group : "tablecolumn",
              command : "columnInsertBefore",
              order : 5
            },
            tablecolumn_insertAfter : {
              label : lang.column.insertAfter,
              group : "tablecolumn",
              command : "columnInsertAfter",
              order : 10
            },
            tablecolumn_delete : {
              label : lang.column.deleteColumn,
              group : "tablecolumn",
              command : "columnDelete",
              order : 15
            }
          });
        }
        if (editor.contextMenu) {
          editor.contextMenu.addListener(function(element, dataAndEvents) {
            if (!element || element.isReadOnly()) {
              return null;
            }
            for (;element;) {
              if (element.getName() in contextMenuTags) {
                return{
                  tablecell : 2,
                  tablerow : 2,
                  tablecolumn : 2
                };
              }
              element = element.getParent();
            }
            return null;
          });
        }
      },
      getSelectedCells : getSelectedCells
    };
    editor.add("tabletools", editor.tabletools);
  })();
  $.buildTableMap = function(table) {
    var codeSegments = table.$.rows;
    var r = -1;
    var aMap = [];
    var i = 0;
    for (;i < codeSegments.length;i++) {
      r++;
      if (!aMap[r]) {
        aMap[r] = [];
      }
      var c = -1;
      var j = 0;
      for (;j < codeSegments[i].cells.length;j++) {
        var oCell = codeSegments[i].cells[j];
        c++;
        for (;aMap[r][c];) {
          c++;
        }
        var iColSpan = isNaN(oCell.colSpan) ? 1 : oCell.colSpan;
        var iRowSpan = isNaN(oCell.rowSpan) ? 1 : oCell.rowSpan;
        var rs = 0;
        for (;rs < iRowSpan;rs++) {
          if (!aMap[r + rs]) {
            aMap[r + rs] = [];
          }
          var cs = 0;
          for (;cs < iColSpan;cs++) {
            aMap[r + rs][c + cs] = codeSegments[i].cells[j];
          }
        }
        c += iColSpan - 1;
      }
    }
    return aMap;
  };
  editor.add("specialchar", {
    requires : ["dialog"],
    availableLangs : {
      cs : 1,
      cy : 1,
      de : 1,
      el : 1,
      en : 1,
      eo : 1,
      et : 1,
      fa : 1,
      fi : 1,
      fr : 1,
      he : 1,
      hr : 1,
      it : 1,
      nb : 1,
      nl : 1,
      no : 1,
      "pt-br" : 1,
      tr : 1,
      ug : 1,
      "zh-cn" : 1
    },
    init : function(editor) {
      var optgroup = "specialchar";
      var plugin = this;
      self.dialog.add(optgroup, this.path + "dialogs/specialchar.js");
      editor.addCommand(optgroup, {
        exec : function() {
          var langCode = editor.langCode;
          langCode = plugin.availableLangs[langCode] ? langCode : "en";
          self.scriptLoader.load(self.getUrl(plugin.path + "lang/" + langCode + ".js"), function() {
            $.extend(editor.lang.specialChar, plugin.langEntries[langCode]);
            editor.openDialog(optgroup);
          });
        },
        modes : {
          wysiwyg : 1
        },
        canUndo : false
      });
      editor.ui.addButton("SpecialChar", {
        label : editor.lang.specialChar.toolbar,
        command : optgroup
      });
    }
  });
  config.specialChars = ["!", "&quot;", "#", "$", "%", "&amp;", "'", "(", ")", "*", "+", "-", ".", "/", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", ":", ";", "&lt;", "=", "&gt;", "?", "@", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "[", "]", "^", "_", "`", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "{", "|", "}", "~", "&euro;", 
  "&lsquo;", "&rsquo;", "&ldquo;", "&rdquo;", "&ndash;", "&mdash;", "&iexcl;", "&cent;", "&pound;", "&curren;", "&yen;", "&brvbar;", "&sect;", "&uml;", "&copy;", "&ordf;", "&laquo;", "&not;", "&reg;", "&macr;", "&deg;", "&sup2;", "&sup3;", "&acute;", "&micro;", "&para;", "&middot;", "&cedil;", "&sup1;", "&ordm;", "&raquo;", "&frac14;", "&frac12;", "&frac34;", "&iquest;", "&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Auml;", "&Aring;", "&AElig;", "&Ccedil;", "&Egrave;", "&Eacute;", "&Ecirc;", "&Euml;", 
  "&Igrave;", "&Iacute;", "&Icirc;", "&Iuml;", "&ETH;", "&Ntilde;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ouml;", "&times;", "&Oslash;", "&Ugrave;", "&Uacute;", "&Ucirc;", "&Uuml;", "&Yacute;", "&THORN;", "&szlig;", "&agrave;", "&aacute;", "&acirc;", "&atilde;", "&auml;", "&aring;", "&aelig;", "&ccedil;", "&egrave;", "&eacute;", "&ecirc;", "&euml;", "&igrave;", "&iacute;", "&icirc;", "&iuml;", "&eth;", "&ntilde;", "&ograve;", "&oacute;", "&ocirc;", "&otilde;", "&ouml;", "&divide;", "&oslash;", 
  "&ugrave;", "&uacute;", "&ucirc;", "&uuml;", "&yacute;", "&thorn;", "&yuml;", "&OElig;", "&oelig;", "&#372;", "&#374", "&#373", "&#375;", "&sbquo;", "&#8219;", "&bdquo;", "&hellip;", "&trade;", "&#9658;", "&bull;", "&rarr;", "&rArr;", "&hArr;", "&diams;", "&asymp;"];
  (function() {
    function selectNextCellCommand(backward) {
      return{
        editorFocus : false,
        canUndo : false,
        modes : {
          wysiwyg : 1
        },
        exec : function(editor) {
          if (editor.focusManager.hasFocus) {
            var sel = editor.getSelection();
            var startElement = sel.getCommonAncestor();
            var cell;
            if (cell = startElement.getAscendant("td", true) || startElement.getAscendant("th", true)) {
              var range = new dom.range(editor.document);
              var node = $.tryThese(function() {
                var row = cell.getParent();
                var next = row.$.cells[cell.$.cellIndex + (backward ? -1 : 1)];
                next.parentNode.parentNode;
                return next;
              }, function() {
                var tr = cell.getParent();
                var table = tr.getAscendant("table");
                var nextRow = table.$.rows[tr.$.rowIndex + (backward ? -1 : 1)];
                return nextRow.cells[backward ? nextRow.cells.length - 1 : 0];
              });
              if (!(node || backward)) {
                var table = cell.getAscendant("table").$;
                var a = cell.getParent().$.cells;
                var root = new Node(table.insertRow(-1), editor.document);
                var i = 0;
                var aLength = a.length;
                for (;i < aLength;i++) {
                  var newCell = root.append((new Node(a[i], editor.document)).clone(false, false));
                  if (!href) {
                    newCell.appendBogus();
                  }
                }
                range.moveToElementEditStart(root);
              } else {
                if (node) {
                  node = new Node(node);
                  range.moveToElementEditStart(node);
                  if (!(range.checkStartOfBlock() && range.checkEndOfBlock())) {
                    range.selectNodeContents(node);
                  }
                } else {
                  return true;
                }
              }
              range.select(true);
              return true;
            }
          }
          return false;
        }
      };
    }
    var meta = {
      editorFocus : false,
      modes : {
        wysiwyg : 1,
        source : 1
      }
    };
    var blurBackCommand = {
      exec : function(editor) {
        editor.container.focusNext(true, editor.tabIndex);
      }
    };
    var blurCommand = {
      exec : function(editor) {
        editor.container.focusPrevious(true, editor.tabIndex);
      }
    };
    editor.add("tab", {
      requires : ["keystrokes"],
      init : function(editor) {
        var r = editor.config.enableTabKeyTools !== false;
        var s = editor.config.tabSpaces || 0;
        var tabText = "";
        for (;s--;) {
          tabText += "\u00a0";
        }
        if (tabText) {
          editor.on("key", function(ev) {
            if (ev.data.keyCode == 9) {
              editor.insertHtml(tabText);
              ev.cancel();
            }
          });
        }
        if (r) {
          editor.on("key", function(ev) {
            if (ev.data.keyCode == 9 && editor.execCommand("selectNextCell") || ev.data.keyCode == 2228224 + 9 && editor.execCommand("selectPreviousCell")) {
              ev.cancel();
            }
          });
        }
        if (env.webkit || env.gecko) {
          editor.on("key", function(ev) {
            var keyCode = ev.data.keyCode;
            if (keyCode == 9 && !tabText) {
              ev.cancel();
              editor.execCommand("blur");
            }
            if (keyCode == 2228224 + 9) {
              editor.execCommand("blurBack");
              ev.cancel();
            }
          });
        }
        editor.addCommand("blur", $.extend(blurBackCommand, meta));
        editor.addCommand("blurBack", $.extend(blurCommand, meta));
        editor.addCommand("selectNextCell", selectNextCellCommand());
        editor.addCommand("selectPreviousCell", selectNextCellCommand(true));
      }
    });
  })();
  Node.prototype.focusNext = function(recurring, indexToUse) {
    var node = this;
    var len = node.$;
    var curTabIndex = indexToUse === undefined ? node.getTabIndex() : indexToUse;
    var passedCurrent;
    var checkStart;
    var last;
    var electedTabIndex;
    var next;
    var elementTabIndex;
    if (curTabIndex <= 0) {
      next = node.getNextSourceNode(recurring, 1);
      for (;next;) {
        if (next.isVisible() && next.getTabIndex() === 0) {
          last = next;
          break;
        }
        next = next.getNextSourceNode(false, 1);
      }
    } else {
      next = node.getDocument().getBody().getFirst();
      for (;next = next.getNextSourceNode(false, 1);) {
        if (!passedCurrent) {
          if (!checkStart && next.equals(node)) {
            checkStart = true;
            if (recurring) {
              if (!(next = next.getNextSourceNode(true, 1))) {
                break;
              }
              passedCurrent = 1;
            }
          } else {
            if (checkStart && !node.contains(next)) {
              passedCurrent = 1;
            }
          }
        }
        if (!next.isVisible() || (elementTabIndex = next.getTabIndex()) < 0) {
          continue;
        }
        if (passedCurrent && elementTabIndex == curTabIndex) {
          last = next;
          break;
        }
        if (elementTabIndex > curTabIndex && (!last || (!electedTabIndex || elementTabIndex < electedTabIndex))) {
          last = next;
          electedTabIndex = elementTabIndex;
        } else {
          if (!last && elementTabIndex === 0) {
            last = next;
            electedTabIndex = elementTabIndex;
          }
        }
      }
    }
    if (last) {
      last.focus();
    }
  };
  Node.prototype.focusPrevious = function(dataAndEvents, indexToUse) {
    var root = this;
    var $ = root.$;
    var curTabIndex = indexToUse === undefined ? root.getTabIndex() : indexToUse;
    var passedCurrent;
    var length;
    var elected;
    var electedTabIndex = 0;
    var elementTabIndex;
    var element = root.getDocument().getBody().getLast();
    for (;element = element.getPreviousSourceNode(false, 1);) {
      if (!passedCurrent) {
        if (!length && element.equals(root)) {
          length = true;
          if (dataAndEvents) {
            if (!(element = element.getPreviousSourceNode(true, 1))) {
              break;
            }
            passedCurrent = 1;
          }
        } else {
          if (length && !root.contains(element)) {
            passedCurrent = 1;
          }
        }
      }
      if (!element.isVisible() || (elementTabIndex = element.getTabIndex()) < 0) {
        continue;
      }
      if (curTabIndex <= 0) {
        if (passedCurrent && elementTabIndex === 0) {
          elected = element;
          break;
        }
        if (elementTabIndex > electedTabIndex) {
          elected = element;
          electedTabIndex = elementTabIndex;
        }
      } else {
        if (passedCurrent && elementTabIndex == curTabIndex) {
          elected = element;
          break;
        }
        if (elementTabIndex < curTabIndex && (!elected || elementTabIndex > electedTabIndex)) {
          elected = element;
          electedTabIndex = elementTabIndex;
        }
      }
    }
    if (elected) {
      elected.focus();
    }
  };
  (function() {
    editor.add("templates", {
      requires : ["dialog"],
      init : function(editor) {
        self.dialog.add("templates", self.getUrl(this.path + "dialogs/templates.js"));
        editor.addCommand("templates", new self.dialogCommand("templates"));
        editor.ui.addButton("Templates", {
          label : editor.lang.templates.button,
          command : "templates"
        });
      }
    });
    var benchmarks = {};
    var loadedTemplatesFiles = {};
    self.addTemplates = function(name, ref) {
      benchmarks[name] = ref;
    };
    self.getTemplates = function(name) {
      return benchmarks[name];
    };
    self.loadTemplates = function(templateFiles, action) {
      var url = [];
      var i = 0;
      var valuesLen = templateFiles.length;
      for (;i < valuesLen;i++) {
        if (!loadedTemplatesFiles[templateFiles[i]]) {
          url.push(templateFiles[i]);
          loadedTemplatesFiles[templateFiles[i]] = 1;
        }
      }
      if (url.length) {
        self.scriptLoader.load(url, action);
      } else {
        setTimeout(action, 0);
      }
    };
  })();
  config.templates_files = [self.getUrl("plugins/templates/templates/default.js")];
  config.templates_replaceContent = true;
  (function() {
    var toolbox = function() {
      this.toolbars = [];
      this.focusCommandExecuted = false;
    };
    toolbox.prototype.focus = function() {
      var t = 0;
      var toolbar;
      for (;toolbar = this.toolbars[t++];) {
        var i = 0;
        var submenu;
        for (;submenu = toolbar.items[i++];) {
          if (submenu.focus) {
            submenu.focus();
            return;
          }
        }
      }
    };
    var commands = {
      toolbarFocus : {
        modes : {
          wysiwyg : 1,
          source : 1
        },
        readOnly : 1,
        exec : function(editor) {
          if (editor.toolbox) {
            editor.toolbox.focusCommandExecuted = true;
            if (href || env.air) {
              setTimeout(function() {
                editor.toolbox.focus();
              }, 100);
            } else {
              editor.toolbox.focus();
            }
          }
        }
      }
    };
    editor.add("toolbar", {
      requires : ["button"],
      init : function(editor) {
        var endFlag;
        var itemKeystroke = function(item, keystroke) {
          var next;
          var toolbar;
          var rtl = editor.lang.dir == "rtl";
          var toolbarGroupCycling = editor.config.toolbarGroupCycling;
          toolbarGroupCycling = toolbarGroupCycling === undefined || toolbarGroupCycling;
          switch(keystroke) {
            case 9:
            ;
            case 2228224 + 9:
              for (;!toolbar || !toolbar.items.length;) {
                toolbar = keystroke == 9 ? (toolbar ? toolbar.next : item.toolbar.next) || editor.toolbox.toolbars[0] : (toolbar ? toolbar.previous : item.toolbar.previous) || editor.toolbox.toolbars[editor.toolbox.toolbars.length - 1];
                if (toolbar.items.length) {
                  item = toolbar.items[endFlag ? toolbar.items.length - 1 : 0];
                  for (;item && !item.focus;) {
                    item = endFlag ? item.previous : item.next;
                    if (!item) {
                      toolbar = 0;
                    }
                  }
                }
              }
              if (item) {
                item.focus();
              }
              return false;
            case rtl ? 37 : 39:
            ;
            case 40:
              next = item;
              do {
                next = next.next;
                if (!next && toolbarGroupCycling) {
                  next = item.toolbar.items[0];
                }
              } while (next && !next.focus);
              if (next) {
                next.focus();
              } else {
                itemKeystroke(item, 9);
              }
              return false;
            case rtl ? 39 : 37:
            ;
            case 38:
              next = item;
              do {
                next = next.previous;
                if (!next && toolbarGroupCycling) {
                  next = item.toolbar.items[item.toolbar.items.length - 1];
                }
              } while (next && !next.focus);
              if (next) {
                next.focus();
              } else {
                endFlag = 1;
                itemKeystroke(item, 2228224 + 9);
                endFlag = 0;
              }
              return false;
            case 27:
              editor.focus();
              return false;
            case 13:
            ;
            case 32:
              item.execute();
              return false;
          }
          return true;
        };
        editor.on("themeSpace", function(event) {
          if (event.data.space == editor.config.toolbarLocation) {
            editor.toolbox = new toolbox;
            var labelId = $.getNextId();
            var output = ['<div class="cke_toolbox" role="group" aria-labelledby="', labelId, '" onmousedown="return false;"'];
            var expanded = editor.config.toolbarStartupExpanded !== false;
            var v;
            output.push(expanded ? ">" : ' style="display:none">');
            output.push('<span id="', labelId, '" class="cke_voice_label">', editor.lang.toolbars, "</span>");
            var toolbars = editor.toolbox.toolbars;
            var toolbar = editor.config.toolbar instanceof Array ? editor.config.toolbar : editor.config["toolbar_" + editor.config.toolbar];
            var r = 0;
            for (;r < toolbar.length;r++) {
              var toolbarId;
              var toolbarObj = 0;
              var toolbarName;
              var row = toolbar[r];
              var codeSegments;
              if (!row) {
                continue;
              }
              if (v) {
                output.push("</div>");
                v = 0;
              }
              if (row === "/") {
                output.push('<div class="cke_break"></div>');
                continue;
              }
              codeSegments = row.items || row;
              var i = 0;
              for (;i < codeSegments.length;i++) {
                var item;
                var definition = codeSegments[i];
                var H;
                item = editor.ui.create(definition);
                if (item) {
                  H = item.canGroup !== false;
                  if (!toolbarObj) {
                    toolbarId = $.getNextId();
                    toolbarObj = {
                      id : toolbarId,
                      items : []
                    };
                    toolbarName = row.name && (editor.lang.toolbarGroups[row.name] || row.name);
                    output.push('<span id="', toolbarId, '" class="cke_toolbar"', toolbarName ? ' aria-labelledby="' + toolbarId + '_label"' : "", ' role="toolbar">');
                    if (toolbarName) {
                      output.push('<span id="', toolbarId, '_label" class="cke_voice_label">', toolbarName, "</span>");
                    }
                    output.push('<span class="cke_toolbar_start"></span>');
                    var index = toolbars.push(toolbarObj) - 1;
                    if (index > 0) {
                      toolbarObj.previous = toolbars[index - 1];
                      toolbarObj.previous.next = toolbarObj;
                    }
                  }
                  if (H) {
                    if (!v) {
                      output.push('<span class="cke_toolgroup" role="presentation">');
                      v = 1;
                    }
                  } else {
                    if (v) {
                      output.push("</span>");
                      v = 0;
                    }
                  }
                  var itemObj = item.render(editor, output);
                  index = toolbarObj.items.push(itemObj) - 1;
                  if (index > 0) {
                    itemObj.previous = toolbarObj.items[index - 1];
                    itemObj.previous.next = itemObj;
                  }
                  itemObj.toolbar = toolbarObj;
                  itemObj.onkey = itemKeystroke;
                  itemObj.onfocus = function() {
                    if (!editor.toolbox.focusCommandExecuted) {
                      editor.focus();
                    }
                  };
                }
              }
              if (v) {
                output.push("</span>");
                v = 0;
              }
              if (toolbarObj) {
                output.push('<span class="cke_toolbar_end"></span></span>');
              }
            }
            output.push("</div>");
            if (editor.config.toolbarCanCollapse) {
              var keys = $.addFunction(function() {
                editor.execCommand("toolbarCollapse");
              });
              editor.on("destroy", function() {
                $.removeFunction(keys);
              });
              var itemId = $.getNextId();
              editor.addCommand("toolbarCollapse", {
                readOnly : 1,
                exec : function(editor) {
                  var collapser = self.document.getById(itemId);
                  var tab = collapser.getPrevious();
                  var contents = editor.getThemeSpace("contents");
                  var toolboxContainer = tab.getParent();
                  var contentHeight = parseInt(contents.$.style.height, 10);
                  var previousHeight = toolboxContainer.$.offsetHeight;
                  var collapsed = !tab.isVisible();
                  if (!collapsed) {
                    tab.hide();
                    collapser.addClass("cke_toolbox_collapser_min");
                    collapser.setAttribute("title", editor.lang.toolbarExpand);
                  } else {
                    tab.show();
                    collapser.removeClass("cke_toolbox_collapser_min");
                    collapser.setAttribute("title", editor.lang.toolbarCollapse);
                  }
                  collapser.getFirst().setText(collapsed ? "\u25b2" : "\u25c0");
                  var dy = toolboxContainer.$.offsetHeight - previousHeight;
                  contents.setStyle("height", contentHeight - dy + "px");
                  editor.fire("resize");
                },
                modes : {
                  wysiwyg : 1,
                  source : 1
                }
              });
              output.push('<a title="' + (expanded ? editor.lang.toolbarCollapse : editor.lang.toolbarExpand) + '" id="' + itemId + '" tabIndex="-1" class="cke_toolbox_collapser');
              if (!expanded) {
                output.push(" cke_toolbox_collapser_min");
              }
              output.push('" onclick="CKEDITOR.tools.callFunction(' + keys + ')">', "<span>&#9650;</span>", "</a>");
            }
            event.data.html += output.join("");
          }
        });
        editor.on("destroy", function() {
          var toolbars;
          var index = 0;
          var i;
          var codeSegments;
          var instance;
          toolbars = this.toolbox.toolbars;
          for (;index < toolbars.length;index++) {
            codeSegments = toolbars[index].items;
            i = 0;
            for (;i < codeSegments.length;i++) {
              instance = codeSegments[i];
              if (instance.clickFn) {
                $.removeFunction(instance.clickFn);
              }
              if (instance.keyDownFn) {
                $.removeFunction(instance.keyDownFn);
              }
            }
          }
        });
        editor.addCommand("toolbarFocus", commands.toolbarFocus);
        editor.ui.add("-", self.UI_SEPARATOR, {});
        editor.ui.addHandler(self.UI_SEPARATOR, {
          create : function() {
            return{
              render : function(editor, output) {
                output.push('<span class="cke_separator" role="separator"></span>');
                return{};
              }
            };
          }
        });
      }
    });
  })();
  self.UI_SEPARATOR = "separator";
  config.toolbarLocation = "top";
  config.toolbar_Basic = [["Bold", "Italic", "-", "NumberedList", "BulletedList", "-", "Link", "Unlink", "-", "About"]];
  config.toolbar_Full = [{
    name : "document",
    items : ["Source", "-", "Save", "NewPage", "DocProps", "Preview", "Print", "-", "Templates"]
  }, {
    name : "clipboard",
    items : ["Cut", "Copy", "Paste", "PasteText", "PasteFromWord", "-", "Undo", "Redo"]
  }, {
    name : "editing",
    items : ["Find", "Replace", "-", "SelectAll", "-", "SpellChecker", "Scayt"]
  }, {
    name : "forms",
    items : ["Form", "Checkbox", "Radio", "TextField", "Textarea", "Select", "Button", "ImageButton", "HiddenField"]
  }, "/", {
    name : "basicstyles",
    items : ["Bold", "Italic", "Underline", "Strike", "Subscript", "Superscript", "-", "RemoveFormat"]
  }, {
    name : "paragraph",
    items : ["NumberedList", "BulletedList", "-", "Outdent", "Indent", "-", "Blockquote", "CreateDiv", "-", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock", "-", "BidiLtr", "BidiRtl"]
  }, {
    name : "links",
    items : ["Link", "Unlink", "Anchor"]
  }, {
    name : "insert",
    items : ["Image", "Flash", "Table", "HorizontalRule", "Smiley", "SpecialChar", "PageBreak", "Iframe"]
  }, "/", {
    name : "styles",
    items : ["Styles", "Format", "Font", "FontSize"]
  }, {
    name : "colors",
    items : ["TextColor", "BGColor"]
  }, {
    name : "tools",
    items : ["Maximize", "ShowBlocks", "-", "About"]
  }];
  config.toolbar = "Full";
  config.toolbarCanCollapse = true;
  (function() {
    function UndoManager(editor) {
      this.editor = editor;
      this.reset();
    }
    editor.add("undo", {
      requires : ["selection", "wysiwygarea"],
      init : function(editor) {
        function recordCommand(event) {
          if (undoManager.enabled && event.data.command.canUndo !== false) {
            undoManager.save();
          }
        }
        var undoManager = new UndoManager(editor);
        var undoCommand = editor.addCommand("undo", {
          exec : function() {
            if (undoManager.undo()) {
              editor.selectionChange();
              this.fire("afterUndo");
            }
          },
          state : 0,
          canUndo : false
        });
        var redoCommand = editor.addCommand("redo", {
          exec : function() {
            if (undoManager.redo()) {
              editor.selectionChange();
              this.fire("afterRedo");
            }
          },
          state : 0,
          canUndo : false
        });
        undoManager.onChange = function() {
          undoCommand.setState(undoManager.undoable() ? 2 : 0);
          redoCommand.setState(undoManager.redoable() ? 2 : 0);
        };
        editor.on("beforeCommandExec", recordCommand);
        editor.on("afterCommandExec", recordCommand);
        editor.on("saveSnapshot", function(evt) {
          undoManager.save(evt.data && evt.data.contentOnly);
        });
        editor.on("contentDom", function() {
          editor.document.on("keydown", function(optgroup) {
            if (!optgroup.data.$.ctrlKey && !optgroup.data.$.metaKey) {
              undoManager.type(optgroup);
            }
          });
        });
        editor.on("beforeModeUnload", function() {
          if (editor.mode == "wysiwyg") {
            undoManager.save(true);
          }
        });
        editor.on("mode", function() {
          undoManager.enabled = editor.readOnly ? false : editor.mode == "wysiwyg";
          undoManager.onChange();
        });
        editor.ui.addButton("Undo", {
          label : editor.lang.undo,
          command : "undo"
        });
        editor.ui.addButton("Redo", {
          label : editor.lang.redo,
          command : "redo"
        });
        editor.resetUndo = function() {
          undoManager.reset();
          editor.fire("saveSnapshot");
        };
        editor.on("updateSnapshot", function() {
          if (undoManager.currentImage) {
            undoManager.update();
          }
        });
      }
    });
    editor.undo = {};
    var Image = editor.undo.Image = function(editor) {
      this.editor = editor;
      editor.fire("beforeUndoImage");
      var contents = editor.getSnapshot();
      var selection = contents && editor.getSelection();
      if (href) {
        if (contents) {
          contents = contents.replace(/\s+data-cke-expando=".*?"/g, "");
        }
      }
      this.contents = contents;
      this.bookmarks = selection && selection.createBookmarks2(true);
      editor.fire("afterUndoImage");
    };
    var optgroup = /\b(?:href|src|name)="[^"]*?"/gi;
    Image.prototype = {
      equals : function(name, keepData) {
        var requestUrl = this.contents;
        var list = name.contents;
        if (href && (env.ie7Compat || env.ie6Compat)) {
          requestUrl = requestUrl.replace(optgroup, "");
          list = list.replace(optgroup, "");
        }
        if (requestUrl != list) {
          return false;
        }
        if (keepData) {
          return true;
        }
        var bookmarksA = this.bookmarks;
        var bookmarksB = name.bookmarks;
        if (bookmarksA || bookmarksB) {
          if (!bookmarksA || (!bookmarksB || bookmarksA.length != bookmarksB.length)) {
            return false;
          }
          var i = 0;
          for (;i < bookmarksA.length;i++) {
            var bookmarkA = bookmarksA[i];
            var bookmarkB = bookmarksB[i];
            if (bookmarkA.startOffset != bookmarkB.startOffset || (bookmarkA.endOffset != bookmarkB.endOffset || (!$.arrayCompare(bookmarkA.start, bookmarkB.start) || !$.arrayCompare(bookmarkA.end, bookmarkB.end)))) {
              return false;
            }
          }
        }
        return true;
      }
    };
    var editingKeyCodes = {
      8 : 1,
      46 : 1
    };
    var modifierKeyCodes = {
      16 : 1,
      17 : 1,
      18 : 1
    };
    var navigationKeyCodes = {
      37 : 1,
      38 : 1,
      39 : 1,
      40 : 1
    };
    UndoManager.prototype = {
      type : function(name) {
        var keystroke = name && name.data.getKey();
        var isModifierKey = keystroke in modifierKeyCodes;
        var isEditingKey = keystroke in editingKeyCodes;
        var wasEditingKey = this.lastKeystroke in editingKeyCodes;
        var sameAsLastEditingKey = isEditingKey && keystroke == this.lastKeystroke;
        var isReset = keystroke in navigationKeyCodes;
        var wasReset = this.lastKeystroke in navigationKeyCodes;
        var isContent = !isEditingKey && !isReset;
        var modifierSnapshot = isEditingKey && !sameAsLastEditingKey;
        var startedTyping = !(isModifierKey || this.typing) || isContent && (wasEditingKey || wasReset);
        if (startedTyping || modifierSnapshot) {
          var pdataOld = new Image(this.editor);
          var beforeTypeCount = this.snapshots.length;
          $.setTimeout(function() {
            var self = this;
            var currentSnapshot = self.editor.getSnapshot();
            if (href) {
              currentSnapshot = currentSnapshot.replace(/\s+data-cke-expando=".*?"/g, "");
            }
            if (pdataOld.contents != currentSnapshot && beforeTypeCount == self.snapshots.length) {
              self.typing = true;
              if (!self.save(false, pdataOld, false)) {
                self.snapshots.splice(self.index + 1, self.snapshots.length - self.index - 1);
              }
              self.hasUndo = true;
              self.hasRedo = false;
              self.typesCount = 1;
              self.modifiersCount = 1;
              self.onChange();
            }
          }, 0, this);
        }
        this.lastKeystroke = keystroke;
        if (isEditingKey) {
          this.typesCount = 0;
          this.modifiersCount++;
          if (this.modifiersCount > 25) {
            this.save(false, null, false);
            this.modifiersCount = 1;
          }
        } else {
          if (!isReset) {
            this.modifiersCount = 0;
            this.typesCount++;
            if (this.typesCount > 25) {
              this.save(false, null, false);
              this.typesCount = 1;
            }
          }
        }
      },
      reset : function() {
        var self = this;
        self.lastKeystroke = 0;
        self.snapshots = [];
        self.index = -1;
        self.limit = self.editor.config.undoStackSize || 20;
        self.currentImage = null;
        self.hasUndo = false;
        self.hasRedo = false;
        self.resetType();
      },
      resetType : function() {
        var self = this;
        self.typing = false;
        delete self.lastKeystroke;
        self.typesCount = 0;
        self.modifiersCount = 0;
      },
      fireChange : function() {
        var me = this;
        me.hasUndo = !!me.getNextImage(true);
        me.hasRedo = !!me.getNextImage(false);
        me.resetType();
        me.onChange();
      },
      save : function(name, value, data) {
        var self = this;
        var a = self.snapshots;
        if (!value) {
          value = new Image(self.editor);
        }
        if (value.contents === false) {
          return false;
        }
        if (self.currentImage && value.equals(self.currentImage, name)) {
          return false;
        }
        a.splice(self.index + 1, a.length - self.index - 1);
        if (a.length == self.limit) {
          a.shift();
        }
        self.index = a.push(value) - 1;
        self.currentImage = value;
        if (data !== false) {
          self.fireChange();
        }
        return true;
      },
      restoreImage : function(image) {
        var options = this;
        var editor = options.editor;
        var sel;
        if (image.bookmarks) {
          editor.focus();
          sel = editor.getSelection();
        }
        options.editor.loadSnapshot(image.contents);
        if (image.bookmarks) {
          sel.selectBookmarks(image.bookmarks);
        } else {
          if (href) {
            var $range = options.editor.document.getBody().$.createTextRange();
            $range.collapse(true);
            $range.select();
          }
        }
        options.index = image.index;
        options.update();
        options.fireChange();
      },
      getNextImage : function(recurring) {
        var self = this;
        var codeSegments = self.snapshots;
        var test = self.currentImage;
        var match;
        var i;
        if (test) {
          if (recurring) {
            i = self.index - 1;
            for (;i >= 0;i--) {
              match = codeSegments[i];
              if (!test.equals(match, true)) {
                match.index = i;
                return match;
              }
            }
          } else {
            i = self.index + 1;
            for (;i < codeSegments.length;i++) {
              match = codeSegments[i];
              if (!test.equals(match, true)) {
                match.index = i;
                return match;
              }
            }
          }
        }
        return null;
      },
      redoable : function() {
        return this.enabled && this.hasRedo;
      },
      undoable : function() {
        return this.enabled && this.hasUndo;
      },
      undo : function() {
        var s = this;
        if (s.undoable()) {
          s.save(true);
          var rSlash = s.getNextImage(true);
          if (rSlash) {
            return s.restoreImage(rSlash), true;
          }
        }
        return false;
      },
      redo : function() {
        var s = this;
        if (s.redoable()) {
          s.save(true);
          if (s.redoable()) {
            var rSlash = s.getNextImage(false);
            if (rSlash) {
              return s.restoreImage(rSlash), true;
            }
          }
        }
        return false;
      },
      update : function() {
        var self = this;
        self.snapshots.splice(self.index, 1, self.currentImage = new Image(self.editor));
      }
    };
  })();
  (function() {
    function nonEditable(element) {
      return element.isBlockBoundary() && dtd.$empty[element.getName()];
    }
    function onInsert(insertFunc) {
      return function(evt) {
        if (this.mode == "wysiwyg") {
          this.focus();
          var selection = this.getSelection();
          var selIsLocked = selection.isLocked;
          if (selIsLocked) {
            selection.unlock();
          }
          this.fire("saveSnapshot");
          insertFunc.call(this, evt.data);
          if (selIsLocked) {
            this.getSelection().lock();
          }
          $.setTimeout(function() {
            this.fire("saveSnapshot");
          }, 0, this);
        }
      };
    }
    function doInsertHtml(data) {
      var editor = this;
      if (editor.dataProcessor) {
        data = editor.dataProcessor.toHtml(data);
      }
      if (!data) {
        return;
      }
      var selection = editor.getSelection();
      var range = selection.getRanges()[0];
      if (range.checkReadOnly()) {
        return;
      }
      if (env.opera) {
        var o = new dom.elementPath(range.startContainer);
        if (o.block) {
          var nodes = self.htmlParser.fragment.fromHtml(data, false).children;
          var i = 0;
          var len = nodes.length;
          for (;i < len;i++) {
            if (nodes[i]._.isBlockLike) {
              range.splitBlock(editor.enterMode == 3 ? "div" : "p");
              range.insertNode(range.document.createText(""));
              range.select();
              break;
            }
          }
        }
      }
      if (href) {
        var $sel = selection.getNative();
        if ($sel.type == "Control") {
          $sel.clear();
        } else {
          if (selection.getType() == 2) {
            range = selection.getRanges()[0];
            var endContainer = range && range.endContainer;
            if (endContainer && (endContainer.type == 1 && (endContainer.getAttribute("contenteditable") == "false" && range.checkBoundaryOfElement(endContainer, 2)))) {
              range.setEndAfter(range.endContainer);
              range.deleteContents();
            }
          }
        }
        $sel.createRange().pasteHTML(data);
      } else {
        editor.document.$.execCommand("inserthtml", false, data);
      }
      if (env.webkit) {
        selection = editor.getSelection();
        selection.scrollIntoView();
      }
    }
    function doInsertText(text) {
      var selection = this.getSelection();
      var p = selection.getStartElement().hasAscendant("pre", true) ? 2 : this.config.enterMode;
      var nullify = p == 2;
      var pdataOld = $.htmlEncode(text.replace(/\r\n|\r/g, "\n"));
      pdataOld = pdataOld.replace(/^[ \t]+|[ \t]+$/g, function(newlines, dataAndEvents, deepDataAndEvents) {
        if (newlines.length == 1) {
          return "&nbsp;";
        } else {
          if (!dataAndEvents) {
            return $.repeat("&nbsp;", newlines.length - 1) + " ";
          } else {
            return " " + $.repeat("&nbsp;", newlines.length - 1);
          }
        }
      });
      pdataOld = pdataOld.replace(/[ \t]{2,}/g, function(newlines) {
        return $.repeat("&nbsp;", newlines.length - 1) + " ";
      });
      var paragraphTag = p == 1 ? "p" : "div";
      if (!nullify) {
        pdataOld = pdataOld.replace(/(\n{2})([\s\S]*?)(?:$|\1)/g, function(deepDataAndEvents, ignoreMethodDoesntExist, dataAndEvents) {
          return "<" + paragraphTag + ">" + dataAndEvents + "</" + paragraphTag + ">";
        });
      }
      pdataOld = pdataOld.replace(/\n/g, "<br>");
      if (!(nullify || href)) {
        pdataOld = pdataOld.replace(new RegExp("<br>(?=</" + paragraphTag + ">)"), function(indexes) {
          return $.repeat(indexes, 2);
        });
      }
      if (env.gecko || env.webkit) {
        var $document = new dom.elementPath(selection.getStartElement());
        var tmp_arr = [];
        var i = 0;
        for (;i < $document.elements.length;i++) {
          var name = $document.elements[i].getName();
          if (name in dtd.$inline) {
            tmp_arr.unshift($document.elements[i].getOuterHtml().match(/^<.*?>/));
          } else {
            if (name in dtd.$block) {
              break;
            }
          }
        }
        pdataOld = tmp_arr.join("") + pdataOld;
      }
      doInsertHtml.call(this, pdataOld);
    }
    function doInsertElement(element) {
      var selection = this.getSelection();
      var codeSegments = selection.getRanges();
      var elementName = element.getName();
      var isBlock = dtd.$block[elementName];
      var selIsLocked = selection.isLocked;
      if (selIsLocked) {
        selection.unlock();
      }
      var range;
      var fragment;
      var node;
      var N;
      var i = codeSegments.length - 1;
      for (;i >= 0;i--) {
        range = codeSegments[i];
        if (!range.checkReadOnly()) {
          range.deleteContents(1);
          fragment = !i && element || element.clone(1);
          var current;
          var tmpDtd;
          if (isBlock) {
            for (;(current = range.getCommonAncestor(0, 1)) && ((tmpDtd = dtd[current.getName()]) && !(tmpDtd && tmpDtd[elementName]));) {
              if (current.getName() in dtd.span) {
                range.splitElement(current);
              } else {
                if (range.checkStartOfBlock() && range.checkEndOfBlock()) {
                  range.setStartBefore(current);
                  range.collapse(true);
                  current.remove();
                } else {
                  range.splitBlock();
                }
              }
            }
          }
          range.insertNode(fragment);
          if (!node) {
            node = fragment;
          }
        }
      }
      if (node) {
        range.moveToPosition(node, 4);
        if (isBlock) {
          var next = node.getNext(notEmpty);
          var name = next && (next.type == 1 && next.getName());
          if (name && dtd.$block[name]) {
            if (dtd[name]["#"]) {
              range.moveToElementEditStart(next);
            } else {
              range.moveToElementEditEnd(node);
            }
          } else {
            if (!next) {
              next = range.fixBlock(true, this.config.enterMode == 3 ? "div" : "p");
              range.moveToElementEditStart(next);
            }
          }
        }
      }
      selection.selectRanges([range]);
      if (selIsLocked) {
        this.getSelection().lock();
      }
    }
    function restoreDirty(editor) {
      if (!editor.checkDirty()) {
        setTimeout(function() {
          editor.resetDirty();
        }, 0);
      }
    }
    function isNotEmpty(node) {
      return isNotWhitespace(node) && isNotBookmark(node);
    }
    function isNbsp(node) {
      return node.type == 3 && $.trim(node.getText()).match(/^(?:&nbsp;|\xa0)$/);
    }
    function restoreSelection(selection) {
      if (selection.isLocked) {
        selection.unlock();
        setTimeout(function() {
          selection.lock();
        }, 0);
      }
    }
    function isBlankParagraph(block) {
      return block.getOuterHtml().match(optgroup);
    }
    function activateEditing(editor) {
      var win = editor.window;
      var doc = editor.document;
      var currentNode = editor.document.getBody();
      var elem = currentNode.getFirst();
      var J = currentNode.getChildren().count();
      if (!J || J == 1 && (elem.type == 1 && elem.hasAttribute("_moz_editor_bogus_node"))) {
        restoreDirty(editor);
        var hostDocument = editor.element.getDocument();
        var hostDocumentElement = hostDocument.getDocumentElement();
        var scrollTop = hostDocumentElement.$.scrollTop;
        var scrollLeft = hostDocumentElement.$.scrollLeft;
        var keyEventSimulate = doc.$.createEvent("KeyEvents");
        keyEventSimulate.initKeyEvent("keypress", true, true, win.$, false, false, false, false, 0, 32);
        doc.$.dispatchEvent(keyEventSimulate);
        if (scrollTop != hostDocumentElement.$.scrollTop || scrollLeft != hostDocumentElement.$.scrollLeft) {
          hostDocument.getWindow().$.scrollTo(scrollLeft, scrollTop);
        }
        if (J) {
          currentNode.getFirst().remove();
        }
        doc.getBody().appendBogus();
        var range = new dom.range(doc);
        range.setStartAt(currentNode, 1);
        range.select();
      }
    }
    function onSelectionChangeFixBody(evt) {
      var editor = evt.editor;
      var path = evt.data.path;
      var blockLimit = path.blockLimit;
      var selection = evt.data.selection;
      var range = selection.getRanges()[0];
      var fragment = editor.document.getBody();
      var enterMode = editor.config.enterMode;
      if (env.gecko) {
        activateEditing(editor);
        var pathBlock = path.block || path.blockLimit;
        var lastNode = pathBlock && pathBlock.getLast(isNotEmpty);
        if (pathBlock && (pathBlock.isBlockBoundary() && (!(lastNode && (lastNode.type == 1 && lastNode.isBlockBoundary())) && (!pathBlock.is("pre") && !pathBlock.getBogus())))) {
          pathBlock.appendBogus();
        }
      }
      if (editor.config.autoParagraph !== false && (enterMode != 2 && (range.collapsed && (blockLimit.getName() == "body" && !path.block)))) {
        var fixedBlock = range.fixBlock(true, editor.config.enterMode == 3 ? "div" : "p");
        if (href) {
          var first = fixedBlock.getFirst(isNotEmpty);
          if (first) {
            if (isNbsp(first)) {
              first.remove();
            }
          }
        }
        if (isBlankParagraph(fixedBlock)) {
          var element = fixedBlock.getNext(isNotWhitespace);
          if (element && (element.type == 1 && !nonEditable(element))) {
            range.moveToElementEditStart(element);
            fixedBlock.remove();
          } else {
            element = fixedBlock.getPrevious(isNotWhitespace);
            if (element && (element.type == 1 && !nonEditable(element))) {
              range.moveToElementEditEnd(element);
              fixedBlock.remove();
            }
          }
        }
        range.select();
        evt.cancel();
      }
      var testRange = new dom.range(editor.document);
      testRange.moveToElementEditEnd(editor.document.getBody());
      var testPath = new dom.elementPath(testRange.startContainer);
      if (!testPath.blockLimit.is("body")) {
        var node;
        if (enterMode != 2) {
          node = fragment.append(editor.document.createElement(enterMode == 1 ? "p" : "div"));
        } else {
          node = fragment;
        }
        if (!href) {
          node.appendBogus();
        }
      }
    }
    var optgroup = /(^|<body\b[^>]*>)\s*<(p|div|address|h\d|center|pre)[^>]*>\s*(?:<br[^>]*>|&nbsp;|\u00A0|&#160;)?\s*(:?<\/\2>)?\s*(?=$|<\/body>)/gi;
    var notWhitespaceEval = dom.walker.whitespaces(true);
    var notBogus = dom.walker.bogus(true);
    var notEmpty = function(node) {
      return notWhitespaceEval(node) && notBogus(node);
    };
    var isNotWhitespace = dom.walker.whitespaces(true);
    var isNotBookmark = dom.walker.bookmark(false, true);
    isNotWhitespace = dom.walker.whitespaces(true);
    editor.add("wysiwygarea", {
      requires : ["editingblock"],
      init : function(editor) {
        var fixForBody = editor.config.enterMode != 2 && editor.config.autoParagraph !== false ? editor.config.enterMode == 3 ? "div" : "p" : false;
        var frameLabel = editor.lang.editorTitle.replace("%1", editor.name);
        var frameDesc = editor.lang.editorHelp;
        if (href) {
          frameLabel += ", " + frameDesc;
        }
        var win = self.document.getWindow();
        var contentDomReadyHandler;
        editor.on("editingBlockReady", function() {
          function contentDomReady(domWindow) {
            if (!Q) {
              return;
            }
            Q = 0;
            editor.fire("ariaWidget", iframe);
            var domDocument = domWindow.document;
            var body = domDocument.body;
            var tabPage = domDocument.getElementById("cke_actscrpt");
            if (tabPage) {
              tabPage.parentNode.removeChild(tabPage);
            }
            body.spellcheck = !editor.config.disableNativeSpellChecker;
            var editable = !editor.readOnly;
            if (href) {
              body.hideFocus = true;
              body.disabled = true;
              body.contentEditable = editable;
              body.removeAttribute("disabled");
            } else {
              setTimeout(function() {
                if (env.gecko && env.version >= 10900 || env.opera) {
                  domDocument.$.body.contentEditable = editable;
                } else {
                  if (env.webkit) {
                    domDocument.$.body.parentNode.contentEditable = editable;
                  } else {
                    domDocument.$.designMode = editable ? "off" : "on";
                  }
                }
              }, 0);
            }
            if (editable) {
              if (env.gecko) {
                $.setTimeout(activateEditing, 0, null, editor);
              }
            }
            domWindow = editor.window = new dom.window(domWindow);
            domDocument = editor.document = new doc(domDocument);
            if (editable) {
              domDocument.on("dblclick", function(ev) {
                var dropArea = ev.data.getTarget();
                var data = {
                  element : dropArea,
                  dialog : ""
                };
                editor.fire("doubleclick", data);
                if (data.dialog) {
                  editor.openDialog(data.dialog);
                }
              });
            }
            if (href) {
              domDocument.on("click", function(evt) {
                var elem = evt.data.getTarget();
                if (elem.is("input")) {
                  var type = elem.getAttribute("type");
                  if (type == "submit" || type == "reset") {
                    evt.data.preventDefault();
                  }
                }
              });
            }
            if (!(href || env.opera)) {
              domDocument.on("mousedown", function(ev) {
                var control = ev.data.getTarget();
                if (control.is("img", "hr", "input", "textarea", "select")) {
                  editor.getSelection().selectElement(control);
                }
              });
            }
            if (env.gecko) {
              domDocument.on("mouseup", function(evt) {
                if (evt.data.$.button == 2) {
                  var target = evt.data.getTarget();
                  if (!target.getOuterHtml().replace(optgroup, "")) {
                    var range = new dom.range(domDocument);
                    range.moveToElementEditStart(target);
                    range.select(true);
                  }
                }
              });
            }
            domDocument.on("click", function(evt) {
              evt = evt.data;
              if (evt.getTarget().is("a") && evt.$.button != 2) {
                evt.preventDefault();
              }
            });
            if (env.webkit) {
              domDocument.on("mousedown", function() {
                ad = 1;
              });
              domDocument.on("click", function(evt) {
                if (evt.data.getTarget().is("input", "select")) {
                  evt.data.preventDefault();
                }
              });
              domDocument.on("mouseup", function(evt) {
                if (evt.data.getTarget().is("input", "textarea")) {
                  evt.data.preventDefault();
                }
              });
            }
            var focusTarget = href ? iframe : domWindow;
            focusTarget.on("blur", function() {
              editor.focusManager.blur();
            });
            var ad;
            focusTarget.on("focus", function() {
              var doc = editor.document;
              if (env.gecko || env.opera) {
                doc.getBody().focus();
              } else {
                if (env.webkit) {
                  if (!ad) {
                    editor.document.getDocumentElement().focus();
                    ad = 1;
                  }
                }
              }
              editor.focusManager.focus();
            });
            var keystrokeHandler = editor.keystrokeHandler;
            keystrokeHandler.blockedKeystrokes[8] = !editable;
            keystrokeHandler.attach(domDocument);
            domDocument.getDocumentElement().addClass(domDocument.$.compatMode);
            if (editable) {
              domDocument.on("keydown", function(evt) {
                var keyCode = evt.data.getKeystroke();
                if (keyCode in {
                  8 : 1,
                  46 : 1
                }) {
                  var selection = editor.getSelection();
                  var startNode = selection.getSelectedElement();
                  var range = selection.getRanges()[0];
                  var path = new dom.elementPath(range.startContainer);
                  var block;
                  var parent;
                  var next;
                  var rtl = keyCode == 8;
                  if (startNode) {
                    editor.fire("saveSnapshot");
                    range.moveToPosition(startNode, 3);
                    startNode.remove();
                    range.select();
                    editor.fire("saveSnapshot");
                    evt.data.preventDefault();
                  } else {
                    if ((block = path.block) && (range[rtl ? "checkStartOfBlock" : "checkEndOfBlock"]() && ((next = block[rtl ? "getPrevious" : "getNext"](notWhitespaceEval)) && next.is("table")))) {
                      editor.fire("saveSnapshot");
                      if (range[rtl ? "checkEndOfBlock" : "checkStartOfBlock"]()) {
                        block.remove();
                      }
                      range["moveToElementEdit" + (rtl ? "End" : "Start")](next);
                      range.select();
                      editor.fire("saveSnapshot");
                      evt.data.preventDefault();
                    } else {
                      if (path.blockLimit.is("td") && ((parent = path.blockLimit.getAscendant("table")) && (range.checkBoundaryOfElement(parent, rtl ? 1 : 2) && (next = parent[rtl ? "getPrevious" : "getNext"](notWhitespaceEval))))) {
                        editor.fire("saveSnapshot");
                        range["moveToElementEdit" + (rtl ? "End" : "Start")](next);
                        if (range.checkStartOfBlock() && range.checkEndOfBlock()) {
                          next.remove();
                        } else {
                          range.select();
                        }
                        editor.fire("saveSnapshot");
                        evt.data.preventDefault();
                      }
                    }
                  }
                }
                if (keyCode == 33 || keyCode == 34) {
                  if (env.gecko) {
                    var body = domDocument.getBody();
                    if (domWindow.$.innerHeight > body.$.offsetHeight) {
                      range = new dom.range(domDocument);
                      range[keyCode == 33 ? "moveToElementEditStart" : "moveToElementEditEnd"](body);
                      range.select();
                      evt.data.preventDefault();
                    }
                  }
                }
              });
            }
            if (href && domDocument.$.compatMode == "CSS1Compat") {
              var af = {
                33 : 1,
                34 : 1
              };
              domDocument.on("keydown", function(evt) {
                if (evt.data.getKeystroke() in af) {
                  setTimeout(function() {
                    editor.getSelection().scrollIntoView();
                  }, 0);
                }
              });
            }
            if (href && editor.config.enterMode != 1) {
              domDocument.on("selectionchange", function() {
                var body = domDocument.getBody();
                var sel = editor.getSelection();
                var range = sel && sel.getRanges()[0];
                if (range && (body.getHtml().match(/^<p>&nbsp;<\/p>$/i) && range.startContainer.equals(body))) {
                  setTimeout(function() {
                    range = editor.getSelection().getRanges()[0];
                    if (!range.startContainer.equals("body")) {
                      body.getFirst().remove(1);
                      range.moveToElementEditEnd(body);
                      range.select(1);
                    }
                  }, 0);
                }
              });
            }
            if (editor.contextMenu) {
              editor.contextMenu.addTarget(domDocument, editor.config.browserContextMenuOnCtrl !== false);
            }
            setTimeout(function() {
              editor.fire("contentDom");
              if (R) {
                editor.mode = "wysiwyg";
                editor.fire("mode", {
                  previousMode : editor._.previousMode
                });
                R = false;
              }
              O = false;
              if (isPendingFocus) {
                editor.focus();
                isPendingFocus = false;
              }
              setTimeout(function() {
                editor.fire("dataReady");
              }, 0);
              try {
                editor.document.$.execCommand("2D-position", false, true);
              } catch (ag) {
              }
              try {
                editor.document.$.execCommand("enableInlineTableEditing", false, !editor.config.disableNativeTableHandles);
              } catch (ah) {
              }
              if (editor.config.disableObjectResizing) {
                try {
                  editor.document.$.execCommand("enableObjectResizing", false, false);
                } catch (ai) {
                  editor.document.getBody().on(href ? "resizestart" : "resize", function(evt) {
                    evt.data.preventDefault();
                  });
                }
              }
              if (href) {
                setTimeout(function() {
                  if (editor.document) {
                    var $body = editor.document.$.body;
                    $body.runtimeStyle.marginBottom = "0px";
                    $body.runtimeStyle.marginBottom = "";
                  }
                }, 1E3);
              }
            }, 0);
          }
          var mainElement;
          var iframe;
          var O;
          var isPendingFocus;
          var Q;
          var R;
          var onResize;
          var charset = env.isCustomDomain();
          var createIFrame = function(data) {
            if (iframe) {
              iframe.remove();
            }
            var encodedValue = "document.open();" + (charset ? 'document.domain="' + document.domain + '";' : "") + "document.close();";
            encodedValue = env.air ? "javascript:void(0)" : href ? "javascript:void(function(){" + encodeURIComponent(encodedValue) + "}())" : "";
            var Z = $.getNextId();
            iframe = Node.createFromHtml('<iframe style="width:100%;height:100%" frameBorder="0" aria-describedby="' + Z + '"' + ' title="' + frameLabel + '"' + ' src="' + encodedValue + '"' + ' tabIndex="' + (env.webkit ? -1 : editor.tabIndex) + '"' + ' allowTransparency="true"' + "></iframe>");
            if (document.location.protocol == "chrome:") {
              self.event.useCapture = true;
            }
            iframe.on("load", function(e) {
              Q = 1;
              e.removeListener();
              var gridStore = iframe.getFrameDocument();
              gridStore.write(data);
              if (env.air) {
                contentDomReady(gridStore.getWindow().$);
              }
            });
            if (document.location.protocol == "chrome:") {
              self.event.useCapture = false;
            }
            mainElement.append(Node.createFromHtml('<span id="' + Z + '" class="cke_voice_label">' + frameDesc + "</span>"));
            mainElement.append(iframe);
            if (env.webkit) {
              onResize = function() {
                mainElement.setStyle("width", "100%");
                iframe.hide();
                iframe.setSize("width", mainElement.getSize("width"));
                mainElement.removeStyle("width");
                iframe.show();
              };
              win.on("resize", onResize);
            }
          };
          contentDomReadyHandler = $.addFunction(contentDomReady);
          var chunk = '<script id="cke_actscrpt" type="text/javascript" data-cke-temp="1">' + (charset ? 'document.domain="' + document.domain + '";' : "") + "window.parent.CKEDITOR.tools.callFunction( " + contentDomReadyHandler + ", window );" + "\x3c/script>";
          editor.addMode("wysiwyg", {
            load : function(obj, options, name) {
              mainElement = obj;
              if (href && env.quirks) {
                obj.setStyle("position", "relative");
              }
              editor.mayBeDirty = true;
              R = true;
              if (name) {
                this.loadSnapshotData(options);
              } else {
                this.loadData(options);
              }
            },
            loadData : function(data) {
              O = true;
              editor._.dataStore = {
                id : 1
              };
              var config = editor.config;
              var fullPage = config.fullPage;
              var docType = config.docType;
              var headExtra = '<style type="text/css" data-cke-temp="1">' + editor._.styles.join("\n") + "</style>";
              if (!fullPage) {
                headExtra = $.buildStyleHtml(editor.config.contentsCss) + headExtra;
              }
              var baseTag = config.baseHref ? '<base href="' + config.baseHref + '" data-cke-temp="1" />' : "";
              if (fullPage) {
                data = data.replace(/<!DOCTYPE[^>]*>/i, function(match) {
                  editor.docType = docType = match;
                  return "";
                }).replace(/<\?xml\s[^\?]*\?>/i, function(match) {
                  editor.xmlDeclaration = match;
                  return "";
                });
              }
              if (editor.dataProcessor) {
                data = editor.dataProcessor.toHtml(data, fixForBody);
              }
              if (fullPage) {
                if (!/<body[\s|>]/.test(data)) {
                  data = "<body>" + data;
                }
                if (!/<html[\s|>]/.test(data)) {
                  data = "<html>" + data + "</html>";
                }
                if (!/<head[\s|>]/.test(data)) {
                  data = data.replace(/<html[^>]*>/, "$&<head><title></title></head>");
                } else {
                  if (!/<title[\s|>]/.test(data)) {
                    data = data.replace(/<head[^>]*>/, "$&<title></title>");
                  }
                }
                if (baseTag) {
                  data = data.replace(/<head>/, "$&" + baseTag);
                }
                data = data.replace(/<\/head\s*>/, headExtra + "$&");
                data = docType + data;
              } else {
                data = config.docType + '<html dir="' + config.contentsLangDirection + '"' + ' lang="' + (config.contentsLanguage || editor.langCode) + '">' + "<head>" + "<title>" + frameLabel + "</title>" + baseTag + headExtra + "</head>" + "<body" + (config.bodyId ? ' id="' + config.bodyId + '"' : "") + (config.bodyClass ? ' class="' + config.bodyClass + '"' : "") + ">" + data + "</html>";
              }
              if (env.gecko) {
                data = data.replace(/<br \/>(?=\s*<\/(:?html|body)>)/, '$&<br type="_moz" />');
              }
              data += chunk;
              this.onDispose();
              createIFrame(data);
            },
            getData : function() {
              var config = editor.config;
              var fullPage = config.fullPage;
              var docType = fullPage && editor.docType;
              var xmlDeclaration = fullPage && editor.xmlDeclaration;
              var doc = iframe.getFrameDocument();
              var data = fullPage ? doc.getDocumentElement().getOuterHtml() : doc.getBody().getHtml();
              if (env.gecko) {
                data = data.replace(/<br>(?=\s*(:?$|<\/body>))/, "");
              }
              if (editor.dataProcessor) {
                data = editor.dataProcessor.toDataFormat(data, fixForBody);
              }
              if (config.ignoreEmptyParagraph) {
                data = data.replace(optgroup, function(dataAndEvents, lookback) {
                  return lookback;
                });
              }
              if (xmlDeclaration) {
                data = xmlDeclaration + "\n" + data;
              }
              if (docType) {
                data = docType + "\n" + data;
              }
              return data;
            },
            getSnapshotData : function() {
              return iframe.getFrameDocument().getBody().getHtml();
            },
            loadSnapshotData : function(data) {
              iframe.getFrameDocument().getBody().setHtml(data);
            },
            onDispose : function() {
              if (!editor.document) {
                return;
              }
              editor.document.getDocumentElement().clearCustomData();
              editor.document.getBody().clearCustomData();
              editor.window.clearCustomData();
              editor.document.clearCustomData();
              iframe.clearCustomData();
              iframe.remove();
            },
            unload : function(fn) {
              this.onDispose();
              if (onResize) {
                win.removeListener("resize", onResize);
              }
              editor.window = editor.document = iframe = mainElement = isPendingFocus = null;
              editor.fire("contentDomUnload");
            },
            focus : function() {
              var win = editor.window;
              if (O) {
                isPendingFocus = true;
              } else {
                if (win) {
                  var sel = editor.getSelection();
                  var ieSel = sel && sel.getNative();
                  if (ieSel && ieSel.type == "Control") {
                    return;
                  }
                  if (env.air) {
                    setTimeout(function() {
                      win.focus();
                    }, 0);
                  } else {
                    win.focus();
                  }
                  editor.selectionChange();
                }
              }
            }
          });
          editor.on("insertHtml", onInsert(doInsertHtml), null, null, 20);
          editor.on("insertElement", onInsert(doInsertElement), null, null, 20);
          editor.on("insertText", onInsert(doInsertText), null, null, 20);
          editor.on("selectionChange", function(isXML) {
            if (editor.readOnly) {
              return;
            }
            var sel = editor.getSelection();
            if (sel && !sel.isLocked) {
              var Z = editor.checkDirty();
              editor.fire("saveSnapshot", {
                contentOnly : 1
              });
              onSelectionChangeFixBody.call(this, isXML);
              editor.fire("updateSnapshot");
              if (!Z) {
                editor.resetDirty();
              }
            }
          }, null, null, 1);
        });
        editor.on("contentDom", function() {
          var title = editor.document.getElementsByTag("title").getItem(0);
          title.data("cke-title", editor.document.$.title);
          if (href) {
            editor.document.$.title = frameLabel;
          }
        });
        editor.on("readOnly", function() {
          if (editor.mode == "wysiwyg") {
            var store = editor.getMode();
            store.loadData(store.getData());
          }
        });
        if (self.document.$.documentMode >= 8) {
          editor.addCss("html.CSS1Compat [contenteditable=false]{ min-height:0 !important;}");
          var tagNameArr = [];
          var tag;
          for (tag in dtd.$removeEmpty) {
            tagNameArr.push("html.CSS1Compat " + tag + "[contenteditable=false]");
          }
          editor.addCss(tagNameArr.join(",") + "{ display:inline-block;}");
        } else {
          if (env.gecko) {
            editor.addCss("html { height: 100% !important; }");
            editor.addCss("img:-moz-broken { -moz-force-broken-image-icon : 1;\tmin-width : 24px; min-height : 24px; }");
          } else {
            if (href && (env.version < 8 && editor.config.contentsLangDirection == "ltr")) {
              editor.addCss("body{margin-right:0;}");
            }
          }
        }
        editor.addCss("html {\t_overflow-y: scroll; cursor: text;\t*cursor:auto;}");
        editor.addCss("img, input, textarea { cursor: default;}");
        editor.on("insertElement", function(evt) {
          var element = evt.data;
          if (element.type == 1 && (element.is("input") || element.is("textarea"))) {
            var readonly = element.getAttribute("contenteditable") == "false";
            if (!readonly) {
              element.data("cke-editable", element.hasAttribute("contenteditable") ? "true" : "1");
              element.setAttribute("contenteditable", false);
            }
          }
        });
      }
    });
    if (env.gecko) {
      (function() {
        var body = document.body;
        if (!body) {
          window.addEventListener("load", arguments.callee, false);
        } else {
          var currentHandler = body.getAttribute("onpageshow");
          body.setAttribute("onpageshow", (currentHandler ? currentHandler + ";" : "") + "event.persisted && (function(){" + "var allInstances = CKEDITOR.instances, editor, doc;" + "for ( var i in allInstances )" + "{" + "\teditor = allInstances[ i ];" + "\tdoc = editor.document;" + "\tif ( doc )" + "\t{" + '\t\tdoc.$.designMode = "off";' + '\t\tdoc.$.designMode = "on";' + "\t}" + "}" + "})();");
        }
      })();
    }
  })();
  config.disableObjectResizing = false;
  config.disableNativeTableHandles = true;
  config.disableNativeSpellChecker = true;
  config.ignoreEmptyParagraph = true;
  editor.add("wsc", {
    requires : ["dialog"],
    init : function(editor) {
      var optgroup = "checkspell";
      var command = editor.addCommand(optgroup, new self.dialogCommand(optgroup));
      command.modes = {
        wysiwyg : !env.opera && (!env.air && document.domain == window.location.hostname)
      };
      editor.ui.addButton("SpellChecker", {
        label : editor.lang.spellCheck.toolbar,
        command : optgroup
      });
      self.dialog.add(optgroup, this.path + "dialogs/wsc.js");
    }
  });
  config.wsc_customerId = config.wsc_customerId || "1:ua3xw1-2XyGJ3-GWruD3-6OFNT1-oXcuB1-nR6Bp4-hgQHc-EcYng3-sdRXG3-NOfFk";
  config.wsc_customLoaderScript = config.wsc_customLoaderScript || null;
  self.DIALOG_RESIZE_NONE = 0;
  self.DIALOG_RESIZE_WIDTH = 1;
  self.DIALOG_RESIZE_HEIGHT = 2;
  self.DIALOG_RESIZE_BOTH = 3;
  (function() {
    function isTabVisible(tabId) {
      return!!this._.tabs[tabId][0].$.offsetHeight;
    }
    function getPreviousVisibleTab() {
      var optgroup = this;
      var id = optgroup._.currentTabId;
      var length = optgroup._.tabIdList.length;
      var end = $.indexOf(optgroup._.tabIdList, id) + length;
      var i = end - 1;
      for (;i > end - length;i--) {
        if (isTabVisible.call(optgroup, optgroup._.tabIdList[i % length])) {
          return optgroup._.tabIdList[i % length];
        }
      }
      return null;
    }
    function getNextVisibleTab() {
      var optgroup = this;
      var id = optgroup._.currentTabId;
      var length = optgroup._.tabIdList.length;
      var index = $.indexOf(optgroup._.tabIdList, id);
      var i = index + 1;
      for (;i < index + length;i++) {
        if (isTabVisible.call(optgroup, optgroup._.tabIdList[i % length])) {
          return optgroup._.tabIdList[i % length];
        }
      }
      return null;
    }
    function clearOrRecoverTextInputValue(container, dataAndEvents) {
      var inputs = container.$.getElementsByTagName("input");
      var i = 0;
      var len = inputs.length;
      for (;i < len;i++) {
        var item = new Node(inputs[i]);
        if (item.getAttribute("type").toLowerCase() == "text") {
          if (dataAndEvents) {
            item.setAttribute("value", item.getCustomData("fake_value") || "");
            item.removeCustomData("fake_value");
          } else {
            item.setCustomData("fake_value", item.getAttribute("value"));
            item.setAttribute("value", "");
          }
        }
      }
    }
    function handleFieldValidated(isValid, msg) {
      var $this = this;
      var input = $this.getInputElement();
      if (input) {
        if (isValid) {
          input.removeAttribute("aria-invalid");
        } else {
          input.setAttribute("aria-invalid", true);
        }
      }
      if (!isValid) {
        if ($this.select) {
          $this.select();
        } else {
          $this.focus();
        }
      }
      if (msg) {
        alert(msg);
      }
      $this.fire("validated", {
        valid : isValid,
        msg : msg
      });
    }
    function resetField() {
      var input = this.getInputElement();
      if (input) {
        input.removeAttribute("aria-invalid");
      }
    }
    function Focusable(dialog, element, index) {
      this.element = element;
      this.focusIndex = index;
      this.tabIndex = 0;
      this.isFocusable = function() {
        return!element.getAttribute("disabled") && element.isVisible();
      };
      this.focus = function() {
        dialog._.currentFocusIndex = this.focusIndex;
        this.element.focus();
      };
      element.on("keydown", function(evt) {
        if (evt.data.getKeystroke() in {
          32 : 1,
          13 : 1
        }) {
          this.fire("click");
        }
      });
      element.on("focus", function() {
        this.fire("mouseover");
      });
      element.on("blur", function() {
        this.fire("mouseout");
      });
    }
    function contentObject(dialog, common) {
      this._ = {
        dialog : dialog
      };
      $.extend(this, common);
    }
    function initDragAndDrop(dialog) {
      function mouseMoveHandler(evt) {
        var innerSize = dialog.getSize();
        var parentSize = self.document.getWindow().getViewPaneSize();
        var x = evt.data.$.screenX;
        var y = evt.data.$.screenY;
        var dx = x - lastCoords.x;
        var dy = y - lastCoords.y;
        var realX;
        var realY;
        lastCoords = {
          x : x,
          y : y
        };
        abstractDialogCoords.x += dx;
        abstractDialogCoords.y += dy;
        if (abstractDialogCoords.x + margins[3] < magnetDistance) {
          realX = -margins[3];
        } else {
          if (abstractDialogCoords.x - margins[1] > parentSize.width - innerSize.width - magnetDistance) {
            realX = parentSize.width - innerSize.width + (editor.lang.dir == "rtl" ? 0 : margins[1]);
          } else {
            realX = abstractDialogCoords.x;
          }
        }
        if (abstractDialogCoords.y + margins[0] < magnetDistance) {
          realY = -margins[0];
        } else {
          if (abstractDialogCoords.y - margins[2] > parentSize.height - innerSize.height - magnetDistance) {
            realY = parentSize.height - innerSize.height + margins[2];
          } else {
            realY = abstractDialogCoords.y;
          }
        }
        dialog.move(realX, realY, 1);
        evt.data.preventDefault();
      }
      function mouseUpHandler(evt) {
        self.document.removeListener("mousemove", mouseMoveHandler);
        self.document.removeListener("mouseup", mouseUpHandler);
        if (env.ie6Compat) {
          var coverDoc = currentCover.getChild(0).getFrameDocument();
          coverDoc.removeListener("mousemove", mouseMoveHandler);
          coverDoc.removeListener("mouseup", mouseUpHandler);
        }
      }
      var lastCoords = null;
      var abstractDialogCoords = null;
      var T = dialog.getElement().getFirst();
      var editor = dialog.getParentEditor();
      var magnetDistance = editor.config.dialog_magnetDistance;
      var margins = editor.skin.margins || [0, 0, 0, 0];
      if (typeof magnetDistance == "undefined") {
        magnetDistance = 20;
      }
      dialog.parts.title.on("mousedown", function(evt) {
        lastCoords = {
          x : evt.data.$.screenX,
          y : evt.data.$.screenY
        };
        self.document.on("mousemove", mouseMoveHandler);
        self.document.on("mouseup", mouseUpHandler);
        abstractDialogCoords = dialog.getPosition();
        if (env.ie6Compat) {
          var coverDoc = currentCover.getChild(0).getFrameDocument();
          coverDoc.on("mousemove", mouseMoveHandler);
          coverDoc.on("mouseup", mouseUpHandler);
        }
        evt.data.preventDefault();
      }, dialog);
    }
    function initResizeHandles(dialog) {
      function mouseMoveHandler(evt) {
        var rtl = editor.lang.dir == "rtl";
        var af = (evt.data.$.screenX - origin.x) * (rtl ? -1 : 1);
        var ag = evt.data.$.screenY - origin.y;
        var optgroup = startSize.width;
        var pdataOld = startSize.height;
        var internalWidth = optgroup + af * (dialog._.moved ? 1 : 2);
        var height = pdataOld + ag * (dialog._.moved ? 1 : 2);
        var element = dialog._.element.getFirst();
        var right = rtl && element.getComputedStyle("right");
        var position = dialog.getPosition();
        if (position.y + height > viewSize.height) {
          height = viewSize.height - position.y;
        }
        if ((rtl ? right : position.x) + internalWidth > viewSize.width) {
          internalWidth = viewSize.width - (rtl ? right : position.x);
        }
        if (resizable == 1 || resizable == 3) {
          optgroup = Math.max(def.minWidth || 0, internalWidth - wrapperWidth);
        }
        if (resizable == 2 || resizable == 3) {
          pdataOld = Math.max(def.minHeight || 0, height - delta);
        }
        dialog.resize(optgroup, pdataOld);
        if (!dialog._.moved) {
          dialog.layout();
        }
        evt.data.preventDefault();
      }
      function mouseUpHandler() {
        self.document.removeListener("mouseup", mouseUpHandler);
        self.document.removeListener("mousemove", mouseMoveHandler);
        if (child) {
          child.remove();
          child = null;
        }
        if (env.ie6Compat) {
          var coverDoc = currentCover.getChild(0).getFrameDocument();
          coverDoc.removeListener("mouseup", mouseUpHandler);
          coverDoc.removeListener("mousemove", mouseMoveHandler);
        }
      }
      var def = dialog.definition;
      var resizable = def.resizable;
      if (resizable == 0) {
        return;
      }
      var editor = dialog.getParentEditor();
      var wrapperWidth;
      var delta;
      var viewSize;
      var origin;
      var startSize;
      var child;
      var keys = $.addFunction(function($event) {
        startSize = dialog.getSize();
        var node = dialog.parts.contents;
        var cnl = node.$.getElementsByTagName("iframe").length;
        if (cnl) {
          child = Node.createFromHtml('<div class="cke_dialog_resize_cover" style="height: 100%; position: absolute; width: 100%;"></div>');
          node.append(child);
        }
        delta = startSize.height - dialog.parts.contents.getSize("height", !(env.gecko || (env.opera || href && env.quirks)));
        wrapperWidth = startSize.width - dialog.parts.contents.getSize("width", 1);
        origin = {
          x : $event.screenX,
          y : $event.screenY
        };
        viewSize = self.document.getWindow().getViewPaneSize();
        self.document.on("mousemove", mouseMoveHandler);
        self.document.on("mouseup", mouseUpHandler);
        if (env.ie6Compat) {
          var coverDoc = currentCover.getChild(0).getFrameDocument();
          coverDoc.on("mousemove", mouseMoveHandler);
          coverDoc.on("mouseup", mouseUpHandler);
        }
        if ($event.preventDefault) {
          $event.preventDefault();
        }
      });
      dialog.on("load", function() {
        var optsData = "";
        if (resizable == 1) {
          optsData = " cke_resizer_horizontal";
        } else {
          if (resizable == 2) {
            optsData = " cke_resizer_vertical";
          }
        }
        var pair = Node.createFromHtml('<div class="cke_resizer' + optsData + " cke_resizer_" + editor.lang.dir + '"' + ' title="' + $.htmlEncode(editor.lang.resize) + '"' + ' onmousedown="CKEDITOR.tools.callFunction(' + keys + ', event )"></div>');
        dialog.parts.footer.append(pair, 1);
      });
      editor.on("destroy", function() {
        $.removeFunction(keys);
      });
    }
    function cancel(evt) {
      evt.data.preventDefault(1);
    }
    function showCover(editor) {
      var win = self.document.getWindow();
      var config = editor.config;
      var backgroundColorStyle = config.dialog_backgroundCoverColor || "white";
      var backgroundCoverOpacity = config.dialog_backgroundCoverOpacity;
      var baseFloatZIndex = config.baseFloatZIndex;
      var coverKey = $.genKey(backgroundColorStyle, backgroundCoverOpacity, baseFloatZIndex);
      var coverElement = covers[coverKey];
      if (!coverElement) {
        var tagNameArr = ['<div tabIndex="-1" style="position: ', env.ie6Compat ? "absolute" : "fixed", "; z-index: ", baseFloatZIndex, "; top: 0px; left: 0px; ", !env.ie6Compat ? "background-color: " + backgroundColorStyle : "", '" class="cke_dialog_background_cover">'];
        if (env.ie6Compat) {
          var charset = env.isCustomDomain();
          var aa = "<html><body style=\\'background-color:" + backgroundColorStyle + ";\\'></body></html>";
          tagNameArr.push('<iframe hidefocus="true" frameborder="0" id="cke_dialog_background_iframe" src="javascript:');
          tagNameArr.push("void((function(){document.open();" + (charset ? "document.domain='" + document.domain + "';" : "") + "document.write( '" + aa + "' );" + "document.close();" + "})())");
          tagNameArr.push('" style="position:absolute;left:0;top:0;width:100%;height: 100%;progid:DXImageTransform.Microsoft.Alpha(opacity=0)"></iframe>');
        }
        tagNameArr.push("</div>");
        coverElement = Node.createFromHtml(tagNameArr.join(""));
        coverElement.setOpacity(backgroundCoverOpacity != undefined ? backgroundCoverOpacity : 0.5);
        coverElement.on("keydown", cancel);
        coverElement.on("keypress", cancel);
        coverElement.on("keyup", cancel);
        coverElement.appendTo(self.document.getBody());
        covers[coverKey] = coverElement;
      } else {
        coverElement.show();
      }
      currentCover = coverElement;
      var resizeFunc = function() {
        var size = win.getViewPaneSize();
        coverElement.setStyles({
          width : size.width + "px",
          height : size.height + "px"
        });
      };
      var scrollFunc = function() {
        var pos = win.getScrollPosition();
        var cursor = self.dialog._.currentTop;
        coverElement.setStyles({
          left : pos.x + "px",
          top : pos.y + "px"
        });
        if (cursor) {
          do {
            var dialogPos = cursor.getPosition();
            cursor.move(dialogPos.x, dialogPos.y);
          } while (cursor = cursor._.parentDialog);
        }
      };
      resizeCover = resizeFunc;
      win.on("resize", resizeFunc);
      resizeFunc();
      if (!(env.mac && env.webkit)) {
        coverElement.focus();
      }
      if (env.ie6Compat) {
        var myScrollHandler = function() {
          scrollFunc();
          arguments.callee.prevScrollHandler.apply(this, arguments);
        };
        win.$.setTimeout(function() {
          myScrollHandler.prevScrollHandler = window.onscroll || function() {
          };
          window.onscroll = myScrollHandler;
        }, 0);
        scrollFunc();
      }
    }
    function hideCover() {
      if (!currentCover) {
        return;
      }
      var win = self.document.getWindow();
      currentCover.hide();
      win.removeListener("resize", resizeCover);
      if (env.ie6Compat) {
        win.$.setTimeout(function() {
          var prevScrollHandler = window.onscroll && window.onscroll.prevScrollHandler;
          window.onscroll = prevScrollHandler || null;
        }, 0);
      }
      resizeCover = null;
    }
    function removeNode() {
      var coverId;
      for (coverId in covers) {
        covers[coverId].remove();
      }
      covers = {};
    }
    var cssLength = $.cssLength;
    self.dialog = function(name, value) {
      function setupFocus() {
        var focusList = optgroup._.focusList;
        focusList.sort(function(a, b) {
          if (a.tabIndex != b.tabIndex) {
            return b.tabIndex - a.tabIndex;
          } else {
            return a.focusIndex - b.focusIndex;
          }
        });
        var valuesLen = focusList.length;
        var i = 0;
        for (;i < valuesLen;i++) {
          focusList[i].focusIndex = i;
        }
      }
      function changeFocus(offset) {
        var focusList = optgroup._.focusList;
        offset = offset || 0;
        if (focusList.length < 1) {
          return;
        }
        var current = optgroup._.currentFocusIndex;
        try {
          focusList[current].getInputElement().$.blur();
        } catch (av) {
        }
        var startIndex = (current + offset + focusList.length) % focusList.length;
        var currentIndex = startIndex;
        for (;offset && !focusList[currentIndex].isFocusable();) {
          currentIndex = (currentIndex + offset + focusList.length) % focusList.length;
          if (currentIndex == startIndex) {
            break;
          }
        }
        focusList[currentIndex].focus();
        if (focusList[currentIndex].type == "text") {
          focusList[currentIndex].select();
        }
      }
      function keydownHandler(evt) {
        var dialog = this;
        if (optgroup != self.dialog._.currentTop) {
          return;
        }
        var keystroke = evt.data.getKeystroke();
        var rtl = name.lang.dir == "rtl";
        var button;
        stack = memory = 0;
        if (keystroke == 9 || keystroke == 2228224 + 9) {
          var shiftPressed = keystroke == 2228224 + 9;
          if (optgroup._.tabBarMode) {
            var nextId = shiftPressed ? getPreviousVisibleTab.call(optgroup) : getNextVisibleTab.call(optgroup);
            optgroup.selectPage(nextId);
            optgroup._.tabs[nextId][0].focus();
          } else {
            changeFocus(shiftPressed ? -1 : 1);
          }
          stack = 1;
        } else {
          if (keystroke == 4456448 + 121 && (!optgroup._.tabBarMode && optgroup.getPageCount() > 1)) {
            optgroup._.tabBarMode = true;
            optgroup._.tabs[optgroup._.currentTabId][0].focus();
            stack = 1;
          } else {
            if ((keystroke == 37 || keystroke == 39) && optgroup._.tabBarMode) {
              nextId = keystroke == (rtl ? 39 : 37) ? getPreviousVisibleTab.call(optgroup) : getNextVisibleTab.call(optgroup);
              optgroup.selectPage(nextId);
              optgroup._.tabs[nextId][0].focus();
              stack = 1;
            } else {
              if ((keystroke == 13 || keystroke == 32) && optgroup._.tabBarMode) {
                dialog.selectPage(dialog._.currentTabId);
                dialog._.tabBarMode = false;
                dialog._.currentFocusIndex = -1;
                changeFocus(1);
                stack = 1;
              } else {
                if (keystroke == 13) {
                  var target = evt.data.getTarget();
                  if (!target.is("a", "button", "select") && (!target.is("input") || target.$.type != "button")) {
                    button = dialog.getButton("ok");
                    if (button) {
                      $.setTimeout(button.click, 0, button);
                    }
                    stack = 1;
                  }
                  memory = 1;
                } else {
                  if (keystroke == 27) {
                    button = dialog.getButton("cancel");
                    if (button) {
                      $.setTimeout(button.click, 0, button);
                    } else {
                      if (dialog.fire("cancel", {
                        hide : true
                      }).hide !== false) {
                        dialog.hide();
                      }
                    }
                    memory = 1;
                  } else {
                    return;
                  }
                }
              }
            }
          }
        }
        keypressHandler(evt);
      }
      function keypressHandler(evt) {
        if (stack) {
          evt.data.preventDefault(1);
        } else {
          if (memory) {
            evt.data.stopPropagation();
          }
        }
      }
      var definition = self.dialog._.dialogDefinitions[value];
      var defaultDefinition = $.clone(defaultDialogDefinition);
      var buttonsOrder = name.config.dialog_buttonsOrder || "OS";
      var dir = name.lang.dir;
      var tabsToRemove = {};
      var i;
      var stack;
      var memory;
      if (buttonsOrder == "OS" && env.mac || (buttonsOrder == "rtl" && dir == "ltr" || buttonsOrder == "ltr" && dir == "rtl")) {
        defaultDefinition.buttons.reverse();
      }
      definition = $.extend(definition(name), defaultDefinition);
      definition = $.clone(definition);
      definition = new definitionObject(this, definition);
      var doc = self.document;
      var themeBuilt = name.theme.buildDialog(name);
      this._ = {
        editor : name,
        element : themeBuilt.element,
        name : value,
        contentSize : {
          width : 0,
          height : 0
        },
        size : {
          width : 0,
          height : 0
        },
        contents : {},
        buttons : {},
        accessKeyMap : {},
        tabs : {},
        tabIdList : [],
        currentTabId : null,
        currentTabIndex : null,
        pageCount : 0,
        lastTab : null,
        tabBarMode : false,
        focusList : [],
        currentFocusIndex : 0,
        hasFocus : false
      };
      this.parts = themeBuilt.parts;
      $.setTimeout(function() {
        name.fire("ariaWidget", this.parts.contents);
      }, 0, this);
      var startStyles = {
        position : env.ie6Compat ? "absolute" : "fixed",
        top : 0,
        visibility : "hidden"
      };
      startStyles[dir == "rtl" ? "right" : "left"] = 0;
      this.parts.dialog.setStyles(startStyles);
      self.event.call(this);
      this.definition = definition = self.fire("dialogDefinition", {
        name : value,
        definition : definition
      }, name).definition;
      if (!("removeDialogTabs" in name._) && name.config.removeDialogTabs) {
        var codeSegments = name.config.removeDialogTabs.split(";");
        i = 0;
        for (;i < codeSegments.length;i++) {
          var parts = codeSegments[i].split(":");
          if (parts.length == 2) {
            var removeDialogName = parts[0];
            if (!tabsToRemove[removeDialogName]) {
              tabsToRemove[removeDialogName] = [];
            }
            tabsToRemove[removeDialogName].push(parts[1]);
          }
        }
        name._.removeDialogTabs = tabsToRemove;
      }
      if (name._.removeDialogTabs && (tabsToRemove = name._.removeDialogTabs[value])) {
        i = 0;
        for (;i < tabsToRemove.length;i++) {
          definition.removeContents(tabsToRemove[i]);
        }
      }
      if (definition.onLoad) {
        this.on("load", definition.onLoad);
      }
      if (definition.onShow) {
        this.on("show", definition.onShow);
      }
      if (definition.onHide) {
        this.on("hide", definition.onHide);
      }
      if (definition.onOk) {
        this.on("ok", function(isXML) {
          name.fire("saveSnapshot");
          setTimeout(function() {
            name.fire("saveSnapshot");
          }, 0);
          if (definition.onOk.call(this, isXML) === false) {
            isXML.data.hide = false;
          }
        });
      }
      if (definition.onCancel) {
        this.on("cancel", function(isXML) {
          if (definition.onCancel.call(this, isXML) === false) {
            isXML.data.hide = false;
          }
        });
      }
      var optgroup = this;
      var iterContents = function(func) {
        var contents = optgroup._.contents;
        var as = false;
        var i;
        for (i in contents) {
          var j;
          for (j in contents[i]) {
            as = func.call(this, contents[i][j]);
            if (as) {
              return;
            }
          }
        }
      };
      this.on("ok", function(evt) {
        iterContents(function(optgroup) {
          if (optgroup.validate) {
            var retval = optgroup.validate(this);
            var invalid = typeof retval == "string" || retval === false;
            if (invalid) {
              evt.data.hide = false;
              evt.stop();
            }
            handleFieldValidated.call(optgroup, !invalid, typeof retval == "string" ? retval : undefined);
            return invalid;
          }
        });
      }, this, null, 0);
      this.on("cancel", function(evt) {
        iterContents(function(item) {
          if (item.isChanged()) {
            if (!confirm(name.lang.common.confirmCancel)) {
              evt.data.hide = false;
            }
            return true;
          }
        });
      }, this, null, 0);
      this.parts.close.on("click", function(evt) {
        if (this.fire("cancel", {
          hide : true
        }).hide !== false) {
          this.hide();
        }
        evt.data.preventDefault();
      }, this);
      this.changeFocus = changeFocus;
      var dialogElement = this._.element;
      this.on("show", function() {
        dialogElement.on("keydown", keydownHandler, this);
        if (env.opera || env.gecko) {
          dialogElement.on("keypress", keypressHandler, this);
        }
      });
      this.on("hide", function() {
        dialogElement.removeListener("keydown", keydownHandler);
        if (env.opera || env.gecko) {
          dialogElement.removeListener("keypress", keypressHandler);
        }
        iterContents(function(item) {
          resetField.apply(item);
        });
      });
      this.on("iframeAdded", function(evt) {
        var dialogElement = new doc(evt.data.iframe.$.contentWindow.document);
        dialogElement.on("keydown", keydownHandler, this, null, 0);
      });
      this.on("show", function() {
        var rvar = this;
        setupFocus();
        if (name.config.dialog_startupFocusTab && optgroup._.pageCount > 1) {
          optgroup._.tabBarMode = true;
          optgroup._.tabs[optgroup._.currentTabId][0].focus();
        } else {
          if (!rvar._.hasFocus) {
            rvar._.currentFocusIndex = -1;
            if (definition.onFocus) {
              var submenu = definition.onFocus.call(rvar);
              if (submenu) {
                submenu.focus();
              }
            } else {
              changeFocus(1);
            }
            if (rvar._.editor.mode == "wysiwyg" && href) {
              var $selection = name.document.$.selection;
              var range = $selection.createRange();
              if (range) {
                if (range.parentElement && range.parentElement().ownerDocument == name.document.$ || range.item && range.item(0).ownerDocument == name.document.$) {
                  var $myRange = document.body.createTextRange();
                  $myRange.moveToElementText(rvar.getElement().getFirst().$);
                  $myRange.collapse(true);
                  $myRange.select();
                }
              }
            }
          }
        }
      }, this, null, 4294967295);
      if (env.ie6Compat) {
        this.on("load", function(dataAndEvents) {
          var element = this.getElement();
          var dummy = element.getFirst();
          dummy.remove();
          dummy.appendTo(element);
        }, this);
      }
      initDragAndDrop(this);
      initResizeHandles(this);
      (new dom.text(definition.title, self.document)).appendTo(this.parts.title);
      i = 0;
      for (;i < definition.contents.length;i++) {
        var page = definition.contents[i];
        if (page) {
          this.addPage(page);
        }
      }
      this.parts.tabs.on("click", function(evt) {
        var me = this;
        var target = evt.data.getTarget();
        if (target.hasClass("cke_dialog_tab")) {
          var id = target.$.id;
          me.selectPage(id.substring(4, id.lastIndexOf("_")));
          if (me._.tabBarMode) {
            me._.tabBarMode = false;
            me._.currentFocusIndex = -1;
            changeFocus(1);
          }
          evt.data.preventDefault();
        }
      }, this);
      var buttonsHtml = [];
      var resultItems = self.dialog._.uiElementBuilders.hbox.build(this, {
        type : "hbox",
        className : "cke_dialog_footer_buttons",
        widths : [],
        children : definition.buttons
      }, buttonsHtml).getChild();
      this.parts.footer.setHtml(buttonsHtml.join(""));
      i = 0;
      for (;i < resultItems.length;i++) {
        this._.buttons[resultItems[i].id] = resultItems[i];
      }
    };
    self.dialog.prototype = {
      destroy : function() {
        this.hide();
        this._.element.remove();
      },
      resize : function() {
        return function(width, height) {
          var editor = this;
          if (editor._.contentSize && (editor._.contentSize.width == width && editor._.contentSize.height == height)) {
            return;
          }
          self.dialog.fire("resize", {
            dialog : editor,
            skin : editor._.editor.skinName,
            width : width,
            height : height
          }, editor._.editor);
          editor.fire("resize", {
            skin : editor._.editor.skinName,
            width : width,
            height : height
          }, editor._.editor);
          if (editor._.editor.lang.dir == "rtl" && editor._.position) {
            editor._.position.x = self.document.getWindow().getViewPaneSize().width - editor._.contentSize.width - parseInt(editor._.element.getFirst().getStyle("right"), 10);
          }
          editor._.contentSize = {
            width : width,
            height : height
          };
        };
      }(),
      getSize : function() {
        var container = this._.element.getFirst();
        return{
          width : container.$.offsetWidth || 0,
          height : container.$.offsetHeight || 0
        };
      },
      move : function() {
        var isFixed;
        return function(x, y, dataAndEvents) {
          var dialog = this;
          var element = dialog._.element.getFirst();
          var rtl = dialog._.editor.lang.dir == "rtl";
          if (isFixed === undefined) {
            isFixed = element.getComputedStyle("position") == "fixed";
          }
          if (isFixed && (dialog._.position && (dialog._.position.x == x && dialog._.position.y == y))) {
            return;
          }
          dialog._.position = {
            x : x,
            y : y
          };
          if (!isFixed) {
            var scrollPosition = self.document.getWindow().getScrollPosition();
            x += scrollPosition.x;
            y += scrollPosition.y;
          }
          if (rtl) {
            var innerSize = dialog.getSize();
            var parentSize = self.document.getWindow().getViewPaneSize();
            x = parentSize.width - innerSize.width - x;
          }
          var styles = {
            top : (y > 0 ? y : 0) + "px"
          };
          styles[rtl ? "right" : "left"] = (x > 0 ? x : 0) + "px";
          element.setStyles(styles);
          if (dataAndEvents) {
            dialog._.moved = 1;
          }
        };
      }(),
      getPosition : function() {
        return $.extend({}, this._.position);
      },
      show : function() {
        var element = this._.element;
        var definition = this.definition;
        if (!(element.getParent() && element.getParent().equals(self.document.getBody()))) {
          element.appendTo(self.document.getBody());
        } else {
          element.setStyle("display", "block");
        }
        if (env.gecko && env.version < 10900) {
          var dialogElement = this.parts.dialog;
          dialogElement.setStyle("position", "absolute");
          setTimeout(function() {
            dialogElement.setStyle("position", "fixed");
          }, 0);
        }
        this.resize(this._.contentSize && this._.contentSize.width || (definition.width || definition.minWidth), this._.contentSize && this._.contentSize.height || (definition.height || definition.minHeight));
        this.reset();
        this.selectPage(this.definition.contents[0].id);
        if (self.dialog._.currentZIndex === null) {
          self.dialog._.currentZIndex = this._.editor.config.baseFloatZIndex;
        }
        this._.element.getFirst().setStyle("z-index", self.dialog._.currentZIndex += 10);
        if (self.dialog._.currentTop === null) {
          self.dialog._.currentTop = this;
          this._.parentDialog = null;
          showCover(this._.editor);
        } else {
          this._.parentDialog = self.dialog._.currentTop;
          var layout = this._.parentDialog.getElement().getFirst();
          layout.$.style.zIndex -= Math.floor(this._.editor.config.baseFloatZIndex / 2);
          self.dialog._.currentTop = this;
        }
        element.on("keydown", accessKeyDownHandler);
        element.on(env.opera ? "keypress" : "keyup", accessKeyUpHandler);
        this._.hasFocus = false;
        $.setTimeout(function() {
          this.layout();
          this.parts.dialog.setStyle("visibility", "");
          this.fireOnce("load", {});
          options.fire("ready", this);
          this.fire("show", {});
          this._.editor.fire("dialogShow", this);
          this.foreach(function(contentObj) {
            if (contentObj.setInitValue) {
              contentObj.setInitValue();
            }
          });
        }, 100, this);
      },
      layout : function() {
        var dialog = this;
        var viewPaneSize = self.document.getWindow().getViewPaneSize();
        var dialogSize = dialog.getSize();
        dialog.move(dialog._.moved ? dialog._.position.x : (viewPaneSize.width - dialogSize.width) / 2, dialog._.moved ? dialog._.position.y : (viewPaneSize.height - dialogSize.height) / 2);
      },
      foreach : function(fn) {
        var optgroup = this;
        var i;
        for (i in optgroup._.contents) {
          var key;
          for (key in optgroup._.contents[i]) {
            fn.call(optgroup, optgroup._.contents[i][key]);
          }
        }
        return optgroup;
      },
      reset : function() {
        var fn = function(record) {
          if (record.reset) {
            record.reset(1);
          }
        };
        return function() {
          this.foreach(fn);
          return this;
        };
      }(),
      setupContent : function() {
        var args = arguments;
        this.foreach(function(child) {
          if (child.setup) {
            child.setup.apply(child, args);
          }
        });
      },
      commitContent : function() {
        var args = arguments;
        this.foreach(function(widget) {
          if (href && this._.currentFocusIndex == widget.focusIndex) {
            widget.getInputElement().$.blur();
          }
          if (widget.commit) {
            widget.commit.apply(widget, args);
          }
        });
      },
      hide : function() {
        if (!this.parts.dialog.isVisible()) {
          return;
        }
        this.fire("hide", {});
        this._.editor.fire("dialogHide", this);
        this.selectPage(this._.tabIdList[0]);
        var element = this._.element;
        element.setStyle("display", "none");
        this.parts.dialog.setStyle("visibility", "hidden");
        unregisterAccessKey(this);
        for (;self.dialog._.currentTop != this;) {
          self.dialog._.currentTop.hide();
        }
        if (!this._.parentDialog) {
          hideCover();
        } else {
          var el = this._.parentDialog.getElement().getFirst();
          el.setStyle("z-index", parseInt(el.$.style.zIndex, 10) + Math.floor(this._.editor.config.baseFloatZIndex / 2));
        }
        self.dialog._.currentTop = this._.parentDialog;
        if (!this._.parentDialog) {
          self.dialog._.currentZIndex = null;
          element.removeListener("keydown", accessKeyDownHandler);
          element.removeListener(env.opera ? "keypress" : "keyup", accessKeyUpHandler);
          var editor = this._.editor;
          editor.focus();
          if (editor.mode == "wysiwyg" && href) {
            var selection = editor.getSelection();
            if (selection) {
              selection.unlock(true);
            }
          }
        } else {
          self.dialog._.currentZIndex -= 10;
        }
        delete this._.parentDialog;
        this.foreach(function(contentObj) {
          if (contentObj.resetInitValue) {
            contentObj.resetInitValue();
          }
        });
      },
      addPage : function(contents) {
        var dialog = this;
        var childHtml = [];
        var time = contents.label ? ' title="' + $.htmlEncode(contents.label) + '"' : "";
        var elements = contents.elements;
        var innerDialog = self.dialog._.uiElementBuilders.vbox.build(dialog, {
          type : "vbox",
          className : "cke_dialog_page_contents",
          children : contents.elements,
          expand : !!contents.expand,
          padding : contents.padding,
          style : contents.style || "width: 100%;height:100%"
        }, childHtml);
        var page = Node.createFromHtml(childHtml.join(""));
        page.setAttribute("role", "tabpanel");
        var o = env;
        var tabId = "cke_" + contents.id + "_" + $.getNextNumber();
        var line = Node.createFromHtml(['<a class="cke_dialog_tab"', dialog._.pageCount > 0 ? " cke_last" : "cke_first", time, !!contents.hidden ? ' style="display:none"' : "", ' id="', tabId, '"', o.gecko && (o.version >= 10900 && !o.hc) ? "" : ' href="javascript:void(0)"', ' tabIndex="-1"', ' hidefocus="true"', ' role="tab">', contents.label, "</a>"].join(""));
        page.setAttribute("aria-labelledby", tabId);
        dialog._.tabs[contents.id] = [line, page];
        dialog._.tabIdList.push(contents.id);
        if (!contents.hidden) {
          dialog._.pageCount++;
        }
        dialog._.lastTab = line;
        dialog.updateStyle();
        var contentMap = dialog._.contents[contents.id] = {};
        var cursor;
        var scripts = innerDialog.getChild();
        for (;cursor = scripts.shift();) {
          contentMap[cursor.id] = cursor;
          if (typeof cursor.getChild == "function") {
            scripts.push.apply(scripts, cursor.getChild());
          }
        }
        page.setAttribute("name", contents.id);
        page.appendTo(dialog.parts.contents);
        line.unselectable();
        dialog.parts.tabs.append(line);
        if (contents.accessKey) {
          registerAccessKey(dialog, dialog, "CTRL+" + contents.accessKey, tabAccessKeyDown, tabAccessKeyUp);
          dialog._.accessKeyMap["CTRL+" + contents.accessKey] = contents.id;
        }
      },
      selectPage : function(id) {
        if (this._.currentTabId == id) {
          return;
        }
        if (this.fire("selectPage", {
          page : id,
          currentPage : this._.currentTabId
        }) === true) {
          return;
        }
        var i;
        for (i in this._.tabs) {
          var tab = this._.tabs[i][0];
          var page = this._.tabs[i][1];
          if (i != id) {
            tab.removeClass("cke_dialog_tab_selected");
            page.hide();
          }
          page.setAttribute("aria-hidden", i != id);
        }
        var selected = this._.tabs[id];
        selected[0].addClass("cke_dialog_tab_selected");
        if (env.ie6Compat || env.ie7Compat) {
          clearOrRecoverTextInputValue(selected[1]);
          selected[1].show();
          setTimeout(function() {
            clearOrRecoverTextInputValue(selected[1], 1);
          }, 0);
        } else {
          selected[1].show();
        }
        this._.currentTabId = id;
        this._.currentTabIndex = $.indexOf(this._.tabIdList, id);
      },
      updateStyle : function() {
        this.parts.dialog[(this._.pageCount === 1 ? "add" : "remove") + "Class"]("cke_single_page");
      },
      hidePage : function(id) {
        var optgroup = this;
        var me = optgroup._.tabs[id] && optgroup._.tabs[id][0];
        if (!me || (optgroup._.pageCount == 1 || !me.isVisible())) {
          return;
        } else {
          if (id == optgroup._.currentTabId) {
            optgroup.selectPage(getPreviousVisibleTab.call(optgroup));
          }
        }
        me.hide();
        optgroup._.pageCount--;
        optgroup.updateStyle();
      },
      showPage : function(index) {
        var me = this;
        var activeItem = me._.tabs[index] && me._.tabs[index][0];
        if (!activeItem) {
          return;
        }
        activeItem.show();
        me._.pageCount++;
        me.updateStyle();
      },
      getElement : function() {
        return this._.element;
      },
      getName : function() {
        return this._.name;
      },
      getContentElement : function(pageId, elementId) {
        var page = this._.contents[pageId];
        return page && page[elementId];
      },
      getValueOf : function(pageId, elementId) {
        return this.getContentElement(pageId, elementId).getValue();
      },
      setValueOf : function(pageId, elementId, isXML) {
        return this.getContentElement(pageId, elementId).setValue(isXML);
      },
      getButton : function(id) {
        return this._.buttons[id];
      },
      click : function(id) {
        return this._.buttons[id].click();
      },
      disableButton : function(id) {
        return this._.buttons[id].disable();
      },
      enableButton : function(id) {
        return this._.buttons[id].enable();
      },
      getPageCount : function() {
        return this._.pageCount;
      },
      getParentEditor : function() {
        return this._.editor;
      },
      getSelectedElement : function() {
        return this.getParentEditor().getSelection().getSelectedElement();
      },
      addFocusable : function(element, index) {
        var dialog = this;
        if (typeof index == "undefined") {
          index = dialog._.focusList.length;
          dialog._.focusList.push(new Focusable(dialog, element, index));
        } else {
          dialog._.focusList.splice(index, 0, new Focusable(dialog, element, index));
          var i = index + 1;
          for (;i < dialog._.focusList.length;i++) {
            dialog._.focusList[i].focusIndex++;
          }
        }
      }
    };
    $.extend(self.dialog, {
      add : function(name, opt_attributes) {
        if (!this._.dialogDefinitions[name] || typeof opt_attributes == "function") {
          this._.dialogDefinitions[name] = opt_attributes;
        }
      },
      exists : function(name) {
        return!!this._.dialogDefinitions[name];
      },
      getCurrent : function() {
        return self.dialog._.currentTop;
      },
      okButton : function() {
        var retval = function(editor, override) {
          override = override || {};
          return $.extend({
            id : "ok",
            type : "button",
            label : editor.lang.common.ok,
            "class" : "cke_dialog_ui_button_ok",
            onClick : function(name) {
              var dialog = name.data.dialog;
              if (dialog.fire("ok", {
                hide : true
              }).hide !== false) {
                dialog.hide();
              }
            }
          }, override, true);
        };
        retval.type = "button";
        retval.override = function(override) {
          return $.extend(function(editor) {
            return retval(editor, override);
          }, {
            type : "button"
          }, true);
        };
        return retval;
      }(),
      cancelButton : function() {
        var retval = function(editor, override) {
          override = override || {};
          return $.extend({
            id : "cancel",
            type : "button",
            label : editor.lang.common.cancel,
            "class" : "cke_dialog_ui_button_cancel",
            onClick : function(name) {
              var dialog = name.data.dialog;
              if (dialog.fire("cancel", {
                hide : true
              }).hide !== false) {
                dialog.hide();
              }
            }
          }, override, true);
        };
        retval.type = "button";
        retval.override = function(override) {
          return $.extend(function(editor) {
            return retval(editor, override);
          }, {
            type : "button"
          }, true);
        };
        return retval;
      }(),
      addUIElement : function(name, element) {
        this._.uiElementBuilders[name] = element;
      }
    });
    self.dialog._ = {
      uiElementBuilders : {},
      dialogDefinitions : {},
      currentTop : null,
      currentZIndex : null
    };
    self.event.implementOn(self.dialog);
    self.event.implementOn(self.dialog.prototype, true);
    var defaultDialogDefinition = {
      resizable : 3,
      minWidth : 600,
      minHeight : 400,
      buttons : [self.dialog.okButton, self.dialog.cancelButton]
    };
    var getById = function(array, id, recurse) {
      var _i = 0;
      var item;
      for (;item = array[_i];_i++) {
        if (item.id == id) {
          return item;
        }
        if (recurse && item[recurse]) {
          var retval = getById(item[recurse], id, recurse);
          if (retval) {
            return retval;
          }
        }
      }
      return null;
    };
    var addById = function(array, newItem, opt_attributes, recurse, dataAndEvents) {
      if (opt_attributes) {
        var i = 0;
        var item;
        for (;item = array[i];i++) {
          if (item.id == opt_attributes) {
            array.splice(i, 0, newItem);
            return newItem;
          }
          if (recurse && item[recurse]) {
            var retval = addById(item[recurse], newItem, opt_attributes, recurse, true);
            if (retval) {
              return retval;
            }
          }
        }
        if (dataAndEvents) {
          return null;
        }
      }
      array.push(newItem);
      return newItem;
    };
    var removeById = function(array, id, recurse) {
      var i = 0;
      var item;
      for (;item = array[i];i++) {
        if (item.id == id) {
          return array.splice(i, 1);
        }
        if (recurse && item[recurse]) {
          var retval = removeById(item[recurse], id, recurse);
          if (retval) {
            return retval;
          }
        }
      }
      return null;
    };
    var definitionObject = function(dialog, entry) {
      this.dialog = dialog;
      var contents = entry.contents;
      var i = 0;
      var content;
      for (;content = contents[i];i++) {
        contents[i] = content && new contentObject(dialog, content);
      }
      $.extend(this, entry);
    };
    definitionObject.prototype = {
      getContents : function(id) {
        return getById(this.contents, id);
      },
      getButton : function(id) {
        return getById(this.buttons, id);
      },
      addContents : function(contentDefinition, opt_attributes) {
        return addById(this.contents, contentDefinition, opt_attributes);
      },
      addButton : function(name, opt_attributes) {
        return addById(this.buttons, name, opt_attributes);
      },
      removeContents : function(id) {
        removeById(this.contents, id);
      },
      removeButton : function(id) {
        removeById(this.buttons, id);
      }
    };
    contentObject.prototype = {
      get : function(id) {
        return getById(this.elements, id, "children");
      },
      add : function(name, opt_attributes) {
        return addById(this.elements, name, opt_attributes, "children");
      },
      remove : function(name) {
        removeById(this.elements, name, "children");
      }
    };
    var resizeCover;
    var covers = {};
    var currentCover;
    var accessKeyProcessors = {};
    var accessKeyDownHandler = function(evt) {
      var ctrl = evt.data.$.ctrlKey || evt.data.$.metaKey;
      var alt = evt.data.$.altKey;
      var shift = evt.data.$.shiftKey;
      var key = String.fromCharCode(evt.data.$.keyCode);
      var keyProcessor = accessKeyProcessors[(ctrl ? "CTRL+" : "") + (alt ? "ALT+" : "") + (shift ? "SHIFT+" : "") + key];
      if (!keyProcessor || !keyProcessor.length) {
        return;
      }
      keyProcessor = keyProcessor[keyProcessor.length - 1];
      if (keyProcessor.keydown) {
        keyProcessor.keydown.call(keyProcessor.uiElement, keyProcessor.dialog, keyProcessor.key);
      }
      evt.data.preventDefault();
    };
    var accessKeyUpHandler = function(evt) {
      var ctrl = evt.data.$.ctrlKey || evt.data.$.metaKey;
      var alt = evt.data.$.altKey;
      var shift = evt.data.$.shiftKey;
      var key = String.fromCharCode(evt.data.$.keyCode);
      var keyProcessor = accessKeyProcessors[(ctrl ? "CTRL+" : "") + (alt ? "ALT+" : "") + (shift ? "SHIFT+" : "") + key];
      if (!keyProcessor || !keyProcessor.length) {
        return;
      }
      keyProcessor = keyProcessor[keyProcessor.length - 1];
      if (keyProcessor.keyup) {
        keyProcessor.keyup.call(keyProcessor.uiElement, keyProcessor.dialog, keyProcessor.key);
        evt.data.preventDefault();
      }
    };
    var registerAccessKey = function(uiElement, dialog, key, downFunc, upFunc) {
      var procList = accessKeyProcessors[key] || (accessKeyProcessors[key] = []);
      procList.push({
        uiElement : uiElement,
        dialog : dialog,
        key : key,
        keyup : upFunc || uiElement.accessKeyUp,
        keydown : downFunc || uiElement.accessKeyDown
      });
    };
    var unregisterAccessKey = function(obj) {
      var i;
      for (i in accessKeyProcessors) {
        var list = accessKeyProcessors[i];
        var j = list.length - 1;
        for (;j >= 0;j--) {
          if (list[j].dialog == obj || list[j].uiElement == obj) {
            list.splice(j, 1);
          }
        }
        if (list.length === 0) {
          delete accessKeyProcessors[i];
        }
      }
    };
    var tabAccessKeyUp = function(dialog, key) {
      if (dialog._.accessKeyMap[key]) {
        dialog.selectPage(dialog._.accessKeyMap[key]);
      }
    };
    var tabAccessKeyDown = function(key, dialog) {
    };
    (function() {
      options.dialog = {
        uiElement : function(pdataOld, optgroup, htmlList, nodeNameArg, attributesArg, stylesArg, contentsArg) {
          if (arguments.length < 4) {
            return;
          }
          var tagName = (nodeNameArg.call ? nodeNameArg(optgroup) : nodeNameArg) || "div";
          var tagNameArr = ["<", tagName, " "];
          var styles = (attributesArg && attributesArg.call ? attributesArg(optgroup) : attributesArg) || {};
          var attributes = (stylesArg && stylesArg.call ? stylesArg(optgroup) : stylesArg) || {};
          var sign = (contentsArg && contentsArg.call ? contentsArg.call(this, pdataOld, optgroup) : contentsArg) || "";
          var domId = this.domId = attributes.id || $.getNextId() + "_uiElement";
          var id = this.id = optgroup.id;
          var i;
          attributes.id = domId;
          var classes = {};
          if (optgroup.type) {
            classes["cke_dialog_ui_" + optgroup.type] = 1;
          }
          if (optgroup.className) {
            classes[optgroup.className] = 1;
          }
          if (optgroup.disabled) {
            classes.cke_disabled = 1;
          }
          var codeSegments = attributes["class"] && attributes["class"].split ? attributes["class"].split(" ") : [];
          i = 0;
          for (;i < codeSegments.length;i++) {
            if (codeSegments[i]) {
              classes[codeSegments[i]] = 1;
            }
          }
          var counter = [];
          for (i in classes) {
            counter.push(i);
          }
          attributes["class"] = counter.join(" ");
          if (optgroup.title) {
            attributes.title = optgroup.title;
          }
          var styleStr = (optgroup.style || "").split(";");
          if (optgroup.align) {
            var align = optgroup.align;
            styles["margin-left"] = align == "left" ? 0 : "auto";
            styles["margin-right"] = align == "right" ? 0 : "auto";
          }
          for (i in styles) {
            styleStr.push(i + ":" + styles[i]);
          }
          if (optgroup.hidden) {
            styleStr.push("display:none");
          }
          i = styleStr.length - 1;
          for (;i >= 0;i--) {
            if (styleStr[i] === "") {
              styleStr.splice(i, 1);
            }
          }
          if (styleStr.length > 0) {
            attributes.style = (attributes.style ? attributes.style + "; " : "") + styleStr.join("; ");
          }
          for (i in attributes) {
            tagNameArr.push(i + '="' + $.htmlEncode(attributes[i]) + '" ');
          }
          tagNameArr.push(">", sign, "</", tagName, ">");
          htmlList.push(tagNameArr.join(""));
          (this._ || (this._ = {})).dialog = pdataOld;
          if (typeof optgroup.isChanged == "boolean") {
            this.isChanged = function() {
              return optgroup.isChanged;
            };
          }
          if (typeof optgroup.isChanged == "function") {
            this.isChanged = optgroup.isChanged;
          }
          if (typeof optgroup.setValue == "function") {
            this.setValue = $.override(this.setValue, function(next_callback) {
              return function(isXML) {
                next_callback.call(this, optgroup.setValue.call(this, isXML));
              };
            });
          }
          if (typeof optgroup.getValue == "function") {
            this.getValue = $.override(this.getValue, function(next_callback) {
              return function() {
                return optgroup.getValue.call(this, next_callback.call(this));
              };
            });
          }
          self.event.implementOn(this);
          this.registerEvents(optgroup);
          if (this.accessKeyUp && (this.accessKeyDown && optgroup.accessKey)) {
            registerAccessKey(this, pdataOld, "CTRL+" + optgroup.accessKey);
          }
          var me = this;
          pdataOld.on("load", function() {
            var input = me.getInputElement();
            if (input) {
              var focusClass = me.type in {
                checkbox : 1,
                ratio : 1
              } && (href && env.version < 8) ? "cke_dialog_ui_focused" : "";
              input.on("focus", function() {
                pdataOld._.tabBarMode = false;
                pdataOld._.hasFocus = true;
                me.fire("focus");
                if (focusClass) {
                  this.addClass(focusClass);
                }
              });
              input.on("blur", function() {
                me.fire("blur");
                if (focusClass) {
                  this.removeClass(focusClass);
                }
              });
            }
          });
          if (this.keyboardFocusable) {
            this.tabIndex = optgroup.tabIndex || 0;
            this.focusIndex = pdataOld._.focusList.push(this) - 1;
            this.on("focus", function() {
              pdataOld._.currentFocusIndex = me.focusIndex;
            });
          }
          $.extend(this, optgroup);
        },
        hbox : function(isXML, childObjList, childHtmlList, o, elementDefinition) {
          if (arguments.length < 4) {
            return;
          }
          if (!this._) {
            this._ = {};
          }
          var children = this._.children = childObjList;
          var widths = elementDefinition && elementDefinition.widths || null;
          var udataCur = elementDefinition && elementDefinition.height || null;
          var t = {};
          var i;
          var innerHTML = function() {
            var html = ['<tbody><tr class="cke_dialog_ui_hbox">'];
            i = 0;
            for (;i < childHtmlList.length;i++) {
              var className = "cke_dialog_ui_hbox_child";
              var leaks = [];
              if (i === 0) {
                className = "cke_dialog_ui_hbox_first";
              }
              if (i == childHtmlList.length - 1) {
                className = "cke_dialog_ui_hbox_last";
              }
              html.push('<td class="', className, '" role="presentation" ');
              if (widths) {
                if (widths[i]) {
                  leaks.push("width:" + cssLength(widths[i]));
                }
              } else {
                leaks.push("width:" + Math.floor(100 / childHtmlList.length) + "%");
              }
              if (udataCur) {
                leaks.push("height:" + cssLength(udataCur));
              }
              if (elementDefinition && elementDefinition.padding != undefined) {
                leaks.push("padding:" + cssLength(elementDefinition.padding));
              }
              if (href && (env.quirks && children[i].align)) {
                leaks.push("text-align:" + children[i].align);
              }
              if (leaks.length > 0) {
                html.push('style="' + leaks.join("; ") + '" ');
              }
              html.push(">", childHtmlList[i], "</td>");
            }
            html.push("</tr></tbody>");
            return html.join("");
          };
          var attribs = {
            role : "presentation"
          };
          if (elementDefinition) {
            if (elementDefinition.align) {
              attribs.align = elementDefinition.align;
            }
          }
          options.dialog.uiElement.call(this, isXML, elementDefinition || {
            type : "hbox"
          }, o, "table", t, attribs, innerHTML);
        },
        vbox : function(isXML, childObjList, childHtmlList, o, elementDefinition) {
          if (arguments.length < 3) {
            return;
          }
          if (!this._) {
            this._ = {};
          }
          var children = this._.children = childObjList;
          var width = elementDefinition && elementDefinition.width || null;
          var widths = elementDefinition && elementDefinition.heights || null;
          var innerHTML = function() {
            var html = ['<table role="presentation" cellspacing="0" border="0" '];
            html.push('style="');
            if (elementDefinition && elementDefinition.expand) {
              html.push("height:100%;");
            }
            html.push("width:" + cssLength(width || "100%"), ";");
            html.push('"');
            html.push('align="', $.htmlEncode(elementDefinition && elementDefinition.align || (isXML.getParentEditor().lang.dir == "ltr" ? "left" : "right")), '" ');
            html.push("><tbody>");
            var i = 0;
            for (;i < childHtmlList.length;i++) {
              var leaks = [];
              html.push('<tr><td role="presentation" ');
              if (width) {
                leaks.push("width:" + cssLength(width || "100%"));
              }
              if (widths) {
                leaks.push("height:" + cssLength(widths[i]));
              } else {
                if (elementDefinition && elementDefinition.expand) {
                  leaks.push("height:" + Math.floor(100 / childHtmlList.length) + "%");
                }
              }
              if (elementDefinition && elementDefinition.padding != undefined) {
                leaks.push("padding:" + cssLength(elementDefinition.padding));
              }
              if (href && (env.quirks && children[i].align)) {
                leaks.push("text-align:" + children[i].align);
              }
              if (leaks.length > 0) {
                html.push('style="', leaks.join("; "), '" ');
              }
              html.push(' class="cke_dialog_ui_vbox_child">', childHtmlList[i], "</td></tr>");
            }
            html.push("</tbody></table>");
            return html.join("");
          };
          options.dialog.uiElement.call(this, isXML, elementDefinition || {
            type : "vbox"
          }, o, "div", null, {
            role : "presentation"
          }, innerHTML);
        }
      };
    })();
    options.dialog.uiElement.prototype = {
      getElement : function() {
        return self.document.getById(this.domId);
      },
      getInputElement : function() {
        return this.getElement();
      },
      getDialog : function() {
        return this._.dialog;
      },
      setValue : function(value, aValue) {
        this.getInputElement().setValue(value);
        if (!aValue) {
          this.fire("change", {
            value : value
          });
        }
        return this;
      },
      getValue : function() {
        return this.getInputElement().getValue();
      },
      isChanged : function() {
        return false;
      },
      selectParentTab : function() {
        var me = this;
        var successCallback = me.getInputElement();
        var win = successCallback;
        var tabId;
        for (;(win = win.getParent()) && win.$.className.search("cke_dialog_page_contents") == -1;) {
        }
        if (!win) {
          return me;
        }
        tabId = win.getAttribute("name");
        if (me._.dialog._.currentTabId != tabId) {
          me._.dialog.selectPage(tabId);
        }
        return me;
      },
      focus : function() {
        this.selectParentTab().getInputElement().focus();
        return this;
      },
      registerEvents : function(definition) {
        var delegateEventSplitter = /^on([A-Z]\w+)/;
        var match;
        var registerDomEvent = function(uiElement, dialog, eventName, func) {
          dialog.on("load", function() {
            uiElement.getInputElement().on(eventName, func, uiElement);
          });
        };
        var key;
        for (key in definition) {
          if (!(match = key.match(delegateEventSplitter))) {
            continue;
          }
          if (this.eventProcessors[key]) {
            this.eventProcessors[key].call(this, this._.dialog, definition[key]);
          } else {
            registerDomEvent(this, this._.dialog, match[1].toLowerCase(), definition[key]);
          }
        }
        return this;
      },
      eventProcessors : {
        onLoad : function(dialog, func) {
          dialog.on("load", func, this);
        },
        onShow : function(dialog, func) {
          dialog.on("show", func, this);
        },
        onHide : function(e, handler) {
          e.on("hide", handler, this);
        }
      },
      accessKeyDown : function(key, dataAndEvents) {
        this.focus();
      },
      accessKeyUp : function(key, dataAndEvents) {
      },
      disable : function() {
        var element = this.getElement();
        var input = this.getInputElement();
        input.setAttribute("disabled", "true");
        element.addClass("cke_disabled");
      },
      enable : function() {
        var element = this.getElement();
        var input = this.getInputElement();
        input.removeAttribute("disabled");
        element.removeClass("cke_disabled");
      },
      isEnabled : function() {
        return!this.getElement().hasClass("cke_disabled");
      },
      isVisible : function() {
        return this.getInputElement().isVisible();
      },
      isFocusable : function() {
        if (!this.isEnabled() || !this.isVisible()) {
          return false;
        }
        return true;
      }
    };
    options.dialog.hbox.prototype = $.extend(new options.dialog.uiElement, {
      getChild : function(recurring) {
        var el = this;
        if (arguments.length < 1) {
          return el._.children.concat();
        }
        if (!recurring.splice) {
          recurring = [recurring];
        }
        if (recurring.length < 2) {
          return el._.children[recurring[0]];
        } else {
          return el._.children[recurring[0]] && el._.children[recurring[0]].getChild ? el._.children[recurring[0]].getChild(recurring.slice(1, recurring.length)) : null;
        }
      }
    }, true);
    options.dialog.vbox.prototype = new options.dialog.hbox;
    (function() {
      var activeClassName = {
        build : function(dialog, elementDefinition, output) {
          var children = elementDefinition.children;
          var child;
          var childHtmlList = [];
          var childObjList = [];
          var i = 0;
          for (;i < children.length && (child = children[i]);i++) {
            var childHtml = [];
            childHtmlList.push(childHtml);
            childObjList.push(self.dialog._.uiElementBuilders[child.type].build(dialog, child, childHtml));
          }
          return new options.dialog[elementDefinition.type](dialog, childObjList, childHtmlList, output, elementDefinition);
        }
      };
      self.dialog.addUIElement("hbox", activeClassName);
      self.dialog.addUIElement("vbox", activeClassName);
    })();
    self.dialogCommand = function(dialogName) {
      this.dialogName = dialogName;
    };
    self.dialogCommand.prototype = {
      exec : function(editor) {
        if (env.opera) {
          $.setTimeout(function() {
            editor.openDialog(this.dialogName);
          }, 0, this);
        } else {
          editor.openDialog(this.dialogName);
        }
      },
      canUndo : false,
      editorFocus : href || env.webkit
    };
    (function() {
      var rclass = /^([a]|[^a])+$/;
      var r20 = /^\d*$/;
      var rreturn = /^\d*(?:\.\d+)?$/;
      var infore = /^(((\d*(\.\d+))|(\d*))(px|\%)?)?$/;
      var rchecked = /^(((\d*(\.\d+))|(\d*))(px|em|ex|in|cm|mm|pt|pc|\%)?)?$/i;
      var rhtml = /^(\s*[\w-]+\s*:\s*[^:;]+(?:;|$))*$/;
      self.VALIDATE_OR = 1;
      self.VALIDATE_AND = 2;
      self.dialog.validate = {
        functions : function() {
          var args = arguments;
          return function() {
            var value = this && this.getValue ? this.getValue() : args[0];
            var msg = undefined;
            var option = 2;
            var functions = [];
            var i;
            i = 0;
            for (;i < args.length;i++) {
              if (typeof args[i] == "function") {
                functions.push(args[i]);
              } else {
                break;
              }
            }
            if (i < args.length && typeof args[i] == "string") {
              msg = args[i];
              i++;
            }
            if (i < args.length && typeof args[i] == "number") {
              option = args[i];
            }
            var passed = option == 2 ? true : false;
            i = 0;
            for (;i < functions.length;i++) {
              if (option == 2) {
                passed = passed && functions[i](value);
              } else {
                passed = passed || functions[i](value);
              }
            }
            return!passed ? msg : true;
          };
        },
        regex : function(regex, msgString) {
          return function() {
            var part = this && this.getValue ? this.getValue() : arguments[0];
            return!regex.test(part) ? msgString : true;
          };
        },
        notEmpty : function(msg) {
          return this.regex(rclass, msg);
        },
        integer : function(msg) {
          return this.regex(r20, msg);
        },
        number : function(msg) {
          return this.regex(rreturn, msg);
        },
        cssLength : function(value) {
          return this.functions(function(msg) {
            return rchecked.test($.trim(msg));
          }, value);
        },
        htmlLength : function(msg) {
          return this.functions(function(msg) {
            return infore.test($.trim(msg));
          }, msg);
        },
        inlineStyle : function(msg) {
          return this.functions(function(msg) {
            return rhtml.test($.trim(msg));
          }, msg);
        },
        equals : function(name, keepData) {
          return this.functions(function(type) {
            return type == name;
          }, keepData);
        },
        notEqual : function(expected, msg) {
          return this.functions(function(actual) {
            return actual != expected;
          }, msg);
        }
      };
      self.on("instanceDestroyed", function(evt) {
        if ($.isEmpty(self.instances)) {
          var currentTopDialog;
          for (;currentTopDialog = self.dialog._.currentTop;) {
            currentTopDialog.hide();
          }
          removeNode();
        }
        var dialogs = evt.editor._.storedDialogs;
        var name;
        for (name in dialogs) {
          dialogs[name].destroy();
        }
      });
    })();
    $.extend(self.editor.prototype, {
      openDialog : function(name, callback) {
        function load(params) {
          var original = self.dialog._.dialogDefinitions[name];
          var skin = me.skin.dialog;
          if (!skin._isLoaded || loadDefinition && typeof params == "undefined") {
            return;
          }
          if (typeof original != "function") {
            self.dialog._.dialogDefinitions[name] = "failed";
          }
          me.openDialog(name, callback);
        }
        if (this.mode == "wysiwyg" && href) {
          var selection = this.getSelection();
          if (selection) {
            selection.lock();
          }
        }
        var data = self.dialog._.dialogDefinitions[name];
        var dialogSkin = this.skin.dialog;
        if (self.dialog._.currentTop === null) {
          showCover(this);
        }
        if (typeof data == "function" && dialogSkin._isLoaded) {
          var menuItems = this._.storedDialogs || (this._.storedDialogs = {});
          var optgroup = menuItems[name] || (menuItems[name] = new self.dialog(this, name));
          if (callback) {
            callback.call(optgroup, optgroup);
          }
          optgroup.show();
          return optgroup;
        } else {
          if (data == "failed") {
            hideCover();
            throw new Error('[CKEDITOR.dialog.openDialog] Dialog "' + name + '" failed when loading definition.');
          }
        }
        var me = this;
        if (typeof data == "string") {
          var loadDefinition = 1;
          self.scriptLoader.load(self.getUrl(data), load, null, 0, 1);
        }
        self.skins.load(this, "dialog", load);
        return null;
      }
    });
  })();
  editor.add("dialog", {
    requires : ["dialogui"]
  });
  editor.add("styles", {
    requires : ["selection"],
    init : function(editor) {
      editor.on("contentDom", function() {
        editor.document.setCustomData("cke_includeReadonly", !editor.config.disableReadonlyStyling);
      });
    }
  });
  self.editor.prototype.attachStyleStateChange = function(style, callback) {
    var styleStateChangeCallbacks = this._.styleStateChangeCallbacks;
    if (!styleStateChangeCallbacks) {
      styleStateChangeCallbacks = this._.styleStateChangeCallbacks = [];
      this.on("selectionChange", function(evt) {
        var i = 0;
        for (;i < styleStateChangeCallbacks.length;i++) {
          var callback = styleStateChangeCallbacks[i];
          var pdataOld = callback.style.checkActive(evt.data.path) ? 1 : 2;
          callback.fn.call(this, pdataOld);
        }
      });
    }
    styleStateChangeCallbacks.push({
      style : style,
      fn : callback
    });
  };
  self.STYLE_BLOCK = 1;
  self.STYLE_INLINE = 2;
  self.STYLE_OBJECT = 3;
  (function() {
    function getUnstylableParent(element) {
      var unstylable;
      var V;
      for (;element = element.getParent();) {
        if (element.getName() == "body") {
          break;
        }
        if (element.getAttribute("data-nostyle")) {
          unstylable = element;
        } else {
          if (!V) {
            var contentEditable = element.getAttribute("contentEditable");
            if (contentEditable == "false") {
              unstylable = element;
            } else {
              if (contentEditable == "true") {
                V = 1;
              }
            }
          }
        }
      }
      return unstylable;
    }
    function applyInlineStyle(range) {
      var style = this;
      var doc = range.document;
      if (range.collapsed) {
        var startNode = getElement(style, doc);
        range.insertNode(startNode);
        range.moveToPosition(startNode, 2);
        return;
      }
      var elementName = style.element;
      var def = style._.definition;
      var isUnknownElement;
      var ignoreReadonly = def.ignoreReadonly;
      var includeReadonly = ignoreReadonly || def.includeReadonly;
      if (includeReadonly == undefined) {
        includeReadonly = doc.getCustomData("cke_includeReadonly");
      }
      var unclonables = dtd[elementName] || (isUnknownElement = true, dtd.span);
      range.enlarge(1, 1);
      range.trim();
      var bookmark = range.createBookmark();
      var firstNode = bookmark.startNode;
      var endNode = bookmark.endNode;
      var currentNode = firstNode;
      var styleRange;
      if (!ignoreReadonly) {
        var firstUnstylable = getUnstylableParent(firstNode);
        var node = getUnstylableParent(endNode);
        if (firstUnstylable) {
          currentNode = firstUnstylable.getNextSourceNode(true);
        }
        if (node) {
          endNode = node;
        }
      }
      if (currentNode.getPosition(endNode) == 2) {
        currentNode = 0;
      }
      for (;currentNode;) {
        var applyStyle = false;
        if (currentNode.equals(endNode)) {
          currentNode = null;
          applyStyle = true;
        } else {
          var nodeType = currentNode.type;
          var nodeName = nodeType == 1 ? currentNode.getName() : null;
          var nodeIsReadonly = nodeName && currentNode.getAttribute("contentEditable") == "false";
          var nodeIsNoStyle = nodeName && currentNode.getAttribute("data-nostyle");
          if (nodeName && currentNode.data("cke-bookmark")) {
            currentNode = currentNode.getNextSourceNode(true);
            continue;
          }
          if (!nodeName || unclonables[nodeName] && (!nodeIsNoStyle && ((!nodeIsReadonly || includeReadonly) && ((currentNode.getPosition(endNode) | 4 | 0 | 8) == 4 + 0 + 8 && (!def.childRule || def.childRule(currentNode)))))) {
            var currentParent = currentNode.getParent();
            if (currentParent && (((currentParent.getDtd() || dtd.span)[elementName] || isUnknownElement) && (!def.parentRule || def.parentRule(currentParent)))) {
              if (!styleRange && (!nodeName || (!dtd.$removeEmpty[nodeName] || (currentNode.getPosition(endNode) | 4 | 0 | 8) == 4 + 0 + 8))) {
                styleRange = new dom.range(doc);
                styleRange.setStartBefore(currentNode);
              }
              if (nodeType == 3 || (nodeIsReadonly || nodeType == 1 && !currentNode.getChildCount())) {
                var includedNode = currentNode;
                var parentNode;
                for (;(applyStyle = !includedNode.getNext(evaluator)) && ((parentNode = includedNode.getParent(), unclonables[parentNode.getName()]) && ((parentNode.getPosition(firstNode) | 2 | 0 | 8) == 2 + 0 + 8 && (!def.childRule || def.childRule(parentNode))));) {
                  includedNode = parentNode;
                }
                styleRange.setEndAfter(includedNode);
              }
            } else {
              applyStyle = true;
            }
          } else {
            applyStyle = true;
          }
          currentNode = currentNode.getNextSourceNode(nodeIsNoStyle || nodeIsReadonly);
        }
        if (applyStyle && (styleRange && !styleRange.collapsed)) {
          var styleNode = getElement(style, doc);
          var as = styleNode.hasAttributes();
          var parent = styleRange.getCommonAncestor();
          var removeList = {
            styles : {},
            attrs : {},
            blockedStyles : {},
            blockedAttrs : {}
          };
          var attName;
          var styleName;
          var value;
          for (;styleNode && parent;) {
            if (parent.getName() == elementName) {
              for (attName in def.attributes) {
                if (removeList.blockedAttrs[attName] || !(value = parent.getAttribute(styleName))) {
                  continue;
                }
                if (styleNode.getAttribute(attName) == value) {
                  removeList.attrs[attName] = 1;
                } else {
                  removeList.blockedAttrs[attName] = 1;
                }
              }
              for (styleName in def.styles) {
                if (removeList.blockedStyles[styleName] || !(value = parent.getStyle(styleName))) {
                  continue;
                }
                if (styleNode.getStyle(styleName) == value) {
                  removeList.styles[styleName] = 1;
                } else {
                  removeList.blockedStyles[styleName] = 1;
                }
              }
            }
            parent = parent.getParent();
          }
          for (attName in removeList.attrs) {
            styleNode.removeAttribute(attName);
          }
          for (styleName in removeList.styles) {
            styleNode.removeStyle(styleName);
          }
          if (as && !styleNode.hasAttributes()) {
            styleNode = null;
          }
          if (styleNode) {
            styleRange.extractContents().appendTo(styleNode);
            removeFromInsideElement(style, styleNode);
            styleRange.insertNode(styleNode);
            styleNode.mergeSiblings();
            if (!href) {
              styleNode.$.normalize();
            }
          } else {
            styleNode = new Node("span");
            styleRange.extractContents().appendTo(styleNode);
            styleRange.insertNode(styleNode);
            removeFromInsideElement(style, styleNode);
            styleNode.remove(true);
          }
          styleRange = null;
        }
      }
      range.moveToBookmark(bookmark);
      range.shrink(2);
    }
    function removeInlineStyle(range) {
      range.enlarge(1, 1);
      var bookmark = range.createBookmark();
      var startNode = bookmark.startNode;
      if (range.collapsed) {
        var startPath = new dom.elementPath(startNode.getParent());
        var match;
        var i = 0;
        var element;
        for (;i < startPath.elements.length && (element = startPath.elements[i]);i++) {
          if (element == startPath.block || element == startPath.blockLimit) {
            break;
          }
          if (this.checkElementRemovable(element)) {
            var isStart;
            if (range.collapsed && (range.checkBoundaryOfElement(element, 2) || (isStart = range.checkBoundaryOfElement(element, 1)))) {
              match = element;
              match.match = isStart ? "start" : "end";
            } else {
              element.mergeSiblings();
              if (element.getName() == this.element) {
                removeFromElement(this, element);
              } else {
                removeOverrides(element, getOverrides(this)[element.getName()]);
              }
            }
          }
        }
        if (match) {
          var child = startNode;
          i = 0;
          for (;true;i++) {
            var node = startPath.elements[i];
            if (node.equals(match)) {
              break;
            } else {
              if (node.match) {
                continue;
              } else {
                node = node.clone();
              }
            }
            node.append(child);
            child = node;
          }
          child[match.match == "start" ? "insertBefore" : "insertAfter"](match);
        }
      } else {
        var endNode = bookmark.endNode;
        var matchesSelector = this;
        var breakNodes = function() {
          var startPath = new dom.elementPath(startNode.getParent());
          var endPath = new dom.elementPath(endNode.getParent());
          var breakStart = null;
          var breakEnd = null;
          var i = 0;
          for (;i < startPath.elements.length;i++) {
            var element = startPath.elements[i];
            if (element == startPath.block || element == startPath.blockLimit) {
              break;
            }
            if (matchesSelector.checkElementRemovable(element)) {
              breakStart = element;
            }
          }
          i = 0;
          for (;i < endPath.elements.length;i++) {
            element = endPath.elements[i];
            if (element == endPath.block || element == endPath.blockLimit) {
              break;
            }
            if (matchesSelector.checkElementRemovable(element)) {
              breakEnd = element;
            }
          }
          if (breakEnd) {
            endNode.breakParent(breakEnd);
          }
          if (breakStart) {
            startNode.breakParent(breakStart);
          }
        };
        breakNodes();
        var currentNode = startNode;
        for (;!currentNode.equals(endNode);) {
          var nextNode = currentNode.getNextSourceNode();
          if (currentNode.type == 1 && this.checkElementRemovable(currentNode)) {
            if (currentNode.getName() == this.element) {
              removeFromElement(this, currentNode);
            } else {
              removeOverrides(currentNode, getOverrides(this)[currentNode.getName()]);
            }
            if (nextNode.type == 1 && nextNode.contains(startNode)) {
              breakNodes();
              nextNode = startNode.getNext();
            }
          }
          currentNode = nextNode;
        }
      }
      range.moveToBookmark(bookmark);
    }
    function applyObjectStyle(range) {
      var root = range.getCommonAncestor(true, true);
      var element = root.getAscendant(this.element, true);
      if (element) {
        if (!element.isReadOnly()) {
          setupElement(element, this);
        }
      }
    }
    function removeObjectStyle(range) {
      var root = range.getCommonAncestor(true, true);
      var element = root.getAscendant(this.element, true);
      if (!element) {
        return;
      }
      var style = this;
      var def = style._.definition;
      var attributes = def.attributes;
      if (attributes) {
        var att;
        for (att in attributes) {
          element.removeAttribute(att, attributes[att]);
        }
      }
      if (def.styles) {
        var i;
        for (i in def.styles) {
          if (!def.styles.hasOwnProperty(i)) {
            continue;
          }
          element.removeStyle(i);
        }
      }
    }
    function applyBlockStyle(range) {
      var bookmark = range.createBookmark(true);
      var iterator = range.createIterator();
      iterator.enforceRealBlocks = true;
      if (this._.enterMode) {
        iterator.enlargeBr = this._.enterMode != 2;
      }
      var block;
      var doc = range.document;
      var Y;
      for (;block = iterator.getNextParagraph();) {
        if (!block.isReadOnly()) {
          var newBlock = getElement(this, doc, block);
          replaceBlock(block, newBlock);
        }
      }
      range.moveToBookmark(bookmark);
    }
    function removeBlockStyle(range) {
      var style = this;
      var bookmark = range.createBookmark(1);
      var iterator = range.createIterator();
      iterator.enforceRealBlocks = true;
      iterator.enlargeBr = style._.enterMode != 2;
      var element;
      for (;element = iterator.getNextParagraph();) {
        if (style.checkElementRemovable(element)) {
          if (element.is("pre")) {
            var newBlock = style._.enterMode == 2 ? null : range.document.createElement(style._.enterMode == 1 ? "p" : "div");
            if (newBlock) {
              element.copyAttributes(newBlock);
            }
            replaceBlock(element, newBlock);
          } else {
            removeFromElement(style, element, 1);
          }
        }
      }
      range.moveToBookmark(bookmark);
    }
    function replaceBlock(optgroup, newBlock) {
      var removeBlock = !newBlock;
      if (removeBlock) {
        newBlock = optgroup.getDocument().createElement("div");
        optgroup.copyAttributes(newBlock);
      }
      var newBlockIsPre = newBlock && newBlock.is("pre");
      var blockIsPre = optgroup.is("pre");
      var isToPre = newBlockIsPre && !blockIsPre;
      var isFromPre = !newBlockIsPre && blockIsPre;
      if (isToPre) {
        newBlock = toPre(optgroup, newBlock);
      } else {
        if (isFromPre) {
          newBlock = fromPres(removeBlock ? [optgroup.getHtml()] : splitIntoPres(optgroup), newBlock);
        } else {
          optgroup.moveChildren(newBlock);
        }
      }
      newBlock.replace(optgroup);
      if (newBlockIsPre) {
        mergePre(newBlock);
      } else {
        if (removeBlock) {
          removeNoAttribsElement(newBlock);
        }
      }
    }
    function mergePre(preBlock) {
      var previousBlock;
      if (!((previousBlock = preBlock.getPrevious(nonWhitespaces)) && (previousBlock.is && previousBlock.is("pre")))) {
        return;
      }
      var errStr = replace(previousBlock.getHtml(), /\n$/, "") + "\n\n" + replace(preBlock.getHtml(), /^\n/, "");
      if (href) {
        preBlock.$.outerHTML = "<pre>" + errStr + "</pre>";
      } else {
        preBlock.setHtml(errStr);
      }
      previousBlock.remove();
    }
    function splitIntoPres(preBlock) {
      var duoBrRegex = /(\S\s*)\n(?:\s|(<span[^>]+data-cke-bookmark.*?\/span>))*\n(?!$)/gi;
      var V = preBlock.getName();
      var splitedHtml = replace(preBlock.getOuterHtml(), duoBrRegex, function(dataAndEvents, otag, ctag) {
        return otag + "</pre>" + ctag + "<pre>";
      });
      var assigns = [];
      splitedHtml.replace(/<pre\b.*?>([\s\S]*?)<\/pre>/gi, function(dataAndEvents, vvar) {
        assigns.push(vvar);
      });
      return assigns;
    }
    function replace(str, optgroup, isXML) {
      var front = "";
      var tag = "";
      str = str.replace(/(^<span[^>]+data-cke-bookmark.*?\/span>)|(<span[^>]+data-cke-bookmark.*?\/span>$)/gi, function(deepDataAndEvents, dataAndEvents, _tag) {
        if (dataAndEvents) {
          front = dataAndEvents;
        }
        if (_tag) {
          tag = _tag;
        }
        return "";
      });
      return front + str.replace(optgroup, isXML) + tag;
    }
    function fromPres(preHtmls, newBlock) {
      var body;
      if (preHtmls.length > 1) {
        body = new dom.documentFragment(newBlock.getDocument());
      }
      var i = 0;
      for (;i < preHtmls.length;i++) {
        var blockHtml = preHtmls[i];
        blockHtml = blockHtml.replace(/(\r\n|\r)/g, "\n");
        blockHtml = replace(blockHtml, /^[ \t]*\n/, "");
        blockHtml = replace(blockHtml, /\n$/, "");
        blockHtml = replace(blockHtml, /^[ \t]+|[ \t]+$/g, function(newlines, dataAndEvents, deepDataAndEvents) {
          if (newlines.length == 1) {
            return "&nbsp;";
          } else {
            if (!dataAndEvents) {
              return $.repeat("&nbsp;", newlines.length - 1) + " ";
            } else {
              return " " + $.repeat("&nbsp;", newlines.length - 1);
            }
          }
        });
        blockHtml = blockHtml.replace(/\n/g, "<br>");
        blockHtml = blockHtml.replace(/[ \t]{2,}/g, function(newlines) {
          return $.repeat("&nbsp;", newlines.length - 1) + " ";
        });
        if (body) {
          var container = newBlock.clone();
          container.setHtml(blockHtml);
          body.append(container);
        } else {
          newBlock.setHtml(blockHtml);
        }
      }
      return body || newBlock;
    }
    function toPre(block, newBlock) {
      var selfObj = block.getBogus();
      if (selfObj) {
        selfObj.remove();
      }
      var preHtml = block.getHtml();
      preHtml = replace(preHtml, /(?:^[ \t\n\r]+)|(?:[ \t\n\r]+$)/g, "");
      preHtml = preHtml.replace(/[ \t\r\n]*(<br[^>]*>)[ \t\r\n]*/gi, "$1");
      preHtml = preHtml.replace(/([ \t\n\r]+|&nbsp;)/g, " ");
      preHtml = preHtml.replace(/<br\b[^>]*>/gi, "\n");
      if (href) {
        var temp = block.getDocument().createElement("div");
        temp.append(newBlock);
        newBlock.$.outerHTML = "<pre>" + preHtml + "</pre>";
        newBlock.copyAttributes(temp.getFirst());
        newBlock = temp.getFirst().remove();
      } else {
        newBlock.setHtml(preHtml);
      }
      return newBlock;
    }
    function removeFromElement(style, element) {
      var def = style._.definition;
      var attributes = def.attributes;
      var styles = def.styles;
      var overrides = getOverrides(style)[element.getName()];
      var removeEmpty = $.isEmpty(attributes) && $.isEmpty(styles);
      var attName;
      for (attName in attributes) {
        if ((attName == "class" || style._.definition.fullMatch) && element.getAttribute(attName) != normalizeProperty(attName, attributes[attName])) {
          continue;
        }
        removeEmpty = element.hasAttribute(attName);
        element.removeAttribute(attName);
      }
      var styleName;
      for (styleName in styles) {
        if (style._.definition.fullMatch && element.getStyle(styleName) != normalizeProperty(styleName, styles[styleName], true)) {
          continue;
        }
        removeEmpty = removeEmpty || !!element.getStyle(styleName);
        element.removeStyle(styleName);
      }
      removeOverrides(element, overrides, blockElements[element.getName()]);
      if (removeEmpty) {
        if (!dtd.$block[element.getName()] || style._.enterMode == 2 && !element.hasAttributes()) {
          removeNoAttribsElement(element);
        } else {
          element.renameNode(style._.enterMode == 1 ? "p" : "div");
        }
      }
    }
    function removeFromInsideElement(style, element) {
      var def = style._.definition;
      var attribs = def.attributes;
      var styles = def.styles;
      var overrides = getOverrides(style);
      var innerElements = element.getElementsByTag(style.element);
      var i = innerElements.count();
      for (;--i >= 0;) {
        removeFromElement(style, innerElements.getItem(i));
      }
      var overrideElement;
      for (overrideElement in overrides) {
        if (overrideElement != style.element) {
          innerElements = element.getElementsByTag(overrideElement);
          i = innerElements.count() - 1;
          for (;i >= 0;i--) {
            var innerElement = innerElements.getItem(i);
            removeOverrides(innerElement, overrides[overrideElement]);
          }
        }
      }
    }
    function removeOverrides(element, overrides, dontRemove) {
      var codeSegments = overrides && overrides.attributes;
      if (codeSegments) {
        var i = 0;
        for (;i < codeSegments.length;i++) {
          var attName = codeSegments[i][0];
          var actualAttrValue;
          if (actualAttrValue = element.getAttribute(attName)) {
            var attValue = codeSegments[i][1];
            if (attValue === null || (attValue.test && attValue.test(actualAttrValue) || typeof attValue == "string" && actualAttrValue == attValue)) {
              element.removeAttribute(attName);
            }
          }
        }
      }
      if (!dontRemove) {
        removeNoAttribsElement(element);
      }
    }
    function removeNoAttribsElement(element) {
      if (!element.hasAttributes()) {
        if (dtd.$block[element.getName()]) {
          var next = element.getPrevious(nonWhitespaces);
          var previous = element.getNext(nonWhitespaces);
          if (next && (next.type == 3 || !next.isBlockBoundary({
            br : 1
          }))) {
            element.append("br", 1);
          }
          if (previous && (previous.type == 3 || !previous.isBlockBoundary({
            br : 1
          }))) {
            element.append("br");
          }
          element.remove(true);
        } else {
          var block = element.getFirst();
          var node = element.getLast();
          element.remove(true);
          if (block) {
            if (block.type == 1) {
              block.mergeSiblings();
            }
            if (node && (!block.equals(node) && node.type == 1)) {
              node.mergeSiblings();
            }
          }
        }
      }
    }
    function getElement(style, targetDocument, element) {
      var el;
      var def = style._.definition;
      var elementName = style.element;
      if (elementName == "*") {
        elementName = "span";
      }
      el = new Node(elementName, targetDocument);
      if (element) {
        element.copyAttributes(el);
      }
      el = setupElement(el, style);
      if (targetDocument.getCustomData("doc_processing_style") && el.hasAttribute("id")) {
        el.removeAttribute("id");
      } else {
        targetDocument.setCustomData("doc_processing_style", 1);
      }
      return el;
    }
    function setupElement(el, style) {
      var def = style._.definition;
      var attrs = def.attributes;
      var styles = self.style.getStyleText(def);
      if (attrs) {
        var attr;
        for (attr in attrs) {
          el.setAttribute(attr, attrs[attr]);
        }
      }
      if (styles) {
        el.setAttribute("style", styles);
      }
      return el;
    }
    function replaceVariables(map, buf) {
      var letter;
      for (letter in map) {
        map[letter] = map[letter].replace(optgroup, function(dataAndEvents, off) {
          return buf[off];
        });
      }
    }
    function getAttributesForComparison(styleDefinition) {
      var attribs = styleDefinition._AC;
      if (attribs) {
        return attribs;
      }
      attribs = {};
      var length = 0;
      var attrs = styleDefinition.attributes;
      if (attrs) {
        var attr;
        for (attr in attrs) {
          length++;
          attribs[attr] = attrs[attr];
        }
      }
      var value = self.style.getStyleText(styleDefinition);
      if (value) {
        if (!attribs.style) {
          length++;
        }
        attribs.style = value;
      }
      attribs._length = length;
      return styleDefinition._AC = attribs;
    }
    function getOverrides(style) {
      if (style._.overrides) {
        return style._.overrides;
      }
      var overrides = style._.overrides = {};
      var definition = style._.definition.overrides;
      if (definition) {
        if (!$.isArray(definition)) {
          definition = [definition];
        }
        var i = 0;
        for (;i < definition.length;i++) {
          var override = definition[i];
          var elementName;
          var elem;
          var attrs;
          if (typeof override == "string") {
            elementName = override.toLowerCase();
          } else {
            elementName = override.element ? override.element.toLowerCase() : style.element;
            attrs = override.attributes;
          }
          elem = overrides[elementName] || (overrides[elementName] = {});
          if (attrs) {
            var eventPath = elem.attributes = elem.attributes || [];
            var attr;
            for (attr in attrs) {
              eventPath.push([attr.toLowerCase(), attrs[attr]]);
            }
          }
        }
      }
      return overrides;
    }
    function normalizeProperty(name, value, isStyle) {
      var temp = new Node("span");
      temp[isStyle ? "setStyle" : "setAttribute"](name, value);
      return temp[isStyle ? "getStyle" : "getAttribute"](name);
    }
    function normalizeCssText(unparsedCssText, recurring) {
      var styleText;
      if (recurring !== false) {
        var temp = new Node("span");
        temp.setAttribute("style", unparsedCssText);
        styleText = temp.getAttribute("style") || "";
      } else {
        styleText = unparsedCssText;
      }
      styleText = styleText.replace(/(font-family:)(.*?)(?=;|$)/, function(deepDataAndEvents, dataAndEvents, pair) {
        var attrList = pair.split(",");
        var i = 0;
        for (;i < attrList.length;i++) {
          attrList[i] = $.trim(attrList[i].replace(/["']/g, ""));
        }
        return dataAndEvents + attrList.join(",");
      });
      return styleText.replace(/\s*([;:])\s*/, "$1").replace(/([^\s;])$/, "$1;").replace(/,\s+/g, ",").replace(/\"/g, "").toLowerCase();
    }
    function parseStyleText(styleText) {
      var myAt = {};
      styleText.replace(/&quot;/g, '"').replace(/\s*([^ :;]+)\s*:\s*([^;]+)\s*(?=;|$)/g, function(dataAndEvents, i, offsetPosition) {
        myAt[i] = offsetPosition;
      });
      return myAt;
    }
    function compareCssText(source, target) {
      if (typeof source == "string") {
        source = parseStyleText(source);
      }
      if (typeof target == "string") {
        target = parseStyleText(target);
      }
      var name;
      for (name in source) {
        if (!(name in target && (target[name] == source[name] || (source[name] == "inherit" || target[name] == "inherit")))) {
          return false;
        }
      }
      return true;
    }
    function applyStyle(doc, remove) {
      var selection = doc.getSelection();
      var bookmarks = selection.createBookmarks(1);
      var ranges = selection.getRanges();
      var func = remove ? this.removeFromRange : this.applyToRange;
      var pdataOld;
      var iterator = ranges.createIterator();
      for (;pdataOld = iterator.getNextRange();) {
        func.call(this, pdataOld);
      }
      if (bookmarks.length == 1 && bookmarks[0].collapsed) {
        selection.selectRanges(ranges);
        doc.getById(bookmarks[0].startNode).remove();
      } else {
        selection.selectBookmarks(bookmarks);
      }
      doc.removeCustomData("doc_processing_style");
    }
    var blockElements = {
      address : 1,
      div : 1,
      h1 : 1,
      h2 : 1,
      h3 : 1,
      h4 : 1,
      h5 : 1,
      h6 : 1,
      p : 1,
      pre : 1,
      section : 1,
      header : 1,
      footer : 1,
      nav : 1,
      article : 1,
      aside : 1,
      figure : 1,
      dialog : 1,
      hgroup : 1,
      time : 1,
      meter : 1,
      menu : 1,
      command : 1,
      keygen : 1,
      output : 1,
      progress : 1,
      details : 1,
      datagrid : 1,
      datalist : 1
    };
    var objectElements = {
      a : 1,
      embed : 1,
      hr : 1,
      img : 1,
      li : 1,
      object : 1,
      ol : 1,
      table : 1,
      td : 1,
      tr : 1,
      th : 1,
      ul : 1,
      dl : 1,
      dt : 1,
      dd : 1,
      form : 1,
      audio : 1,
      video : 1
    };
    var rvar = /\s*(?:;\s*|$)/;
    var optgroup = /#\((.+?)\)/g;
    var evaluator = dom.walker.bookmark(0, 1);
    var nonWhitespaces = dom.walker.whitespaces(1);
    self.style = function(name, value) {
      var definition = this;
      if (value) {
        name = $.clone(name);
        replaceVariables(name.attributes, value);
        replaceVariables(name.styles, value);
      }
      var element = definition.element = name.element ? typeof name.element == "string" ? name.element.toLowerCase() : name.element : "*";
      definition.type = blockElements[element] ? 1 : objectElements[element] ? 3 : 2;
      if (typeof definition.element == "object") {
        definition.type = 3;
      }
      definition._ = {
        definition : name
      };
    };
    self.style.prototype = {
      apply : function(object) {
        applyStyle.call(this, object, false);
      },
      remove : function(name) {
        applyStyle.call(this, name, true);
      },
      applyToRange : function(isXML) {
        var optgroup = this;
        return(optgroup.applyToRange = optgroup.type == 2 ? applyInlineStyle : optgroup.type == 1 ? applyBlockStyle : optgroup.type == 3 ? applyObjectStyle : null).call(optgroup, isXML);
      },
      removeFromRange : function(isXML) {
        var optgroup = this;
        return(optgroup.removeFromRange = optgroup.type == 2 ? removeInlineStyle : optgroup.type == 1 ? removeBlockStyle : optgroup.type == 3 ? removeObjectStyle : null).call(optgroup, isXML);
      },
      applyToObject : function(element) {
        setupElement(element, this);
      },
      checkActive : function(elementPath) {
        var self = this;
        switch(self.type) {
          case 1:
            return self.checkElementRemovable(elementPath.block || elementPath.blockLimit, true);
          case 3:
          ;
          case 2:
            var elements = elementPath.elements;
            var i = 0;
            var element;
            for (;i < elements.length;i++) {
              element = elements[i];
              if (self.type == 2 && (element == elementPath.block || element == elementPath.blockLimit)) {
                continue;
              }
              if (self.type == 3) {
                var name = element.getName();
                if (!(typeof self.element == "string" ? name == self.element : name in self.element)) {
                  continue;
                }
              }
              if (self.checkElementRemovable(element, true)) {
                return true;
              }
            }
          ;
        }
        return false;
      },
      checkApplicable : function(elementPath) {
        switch(this.type) {
          case 2:
          ;
          case 1:
            break;
          case 3:
            return elementPath.lastElement.getAscendant(this.element, true);
        }
        return true;
      },
      checkElementMatch : function(element, deepDataAndEvents) {
        var self = this;
        var def = self._.definition;
        if (!element || !def.ignoreReadonly && element.isReadOnly()) {
          return false;
        }
        var attribs;
        var name = element.getName();
        if (typeof self.element == "string" ? name == self.element : name in self.element) {
          if (!deepDataAndEvents && !element.hasAttributes()) {
            return true;
          }
          attribs = getAttributesForComparison(def);
          if (attribs._length) {
            var attName;
            for (attName in attribs) {
              if (attName == "_length") {
                continue;
              }
              var elementAttr = element.getAttribute(attName) || "";
              if (attName == "style" ? compareCssText(attribs[attName], normalizeCssText(elementAttr, false)) : attribs[attName] == elementAttr) {
                if (!deepDataAndEvents) {
                  return true;
                }
              } else {
                if (deepDataAndEvents) {
                  return false;
                }
              }
            }
            if (deepDataAndEvents) {
              return true;
            }
          } else {
            return true;
          }
        }
        return false;
      },
      checkElementRemovable : function(element, deepDataAndEvents) {
        if (this.checkElementMatch(element, deepDataAndEvents)) {
          return true;
        }
        var docFragment = getOverrides(this)[element.getName()];
        if (docFragment) {
          var attrList;
          var a;
          if (!(attrList = docFragment.attributes)) {
            return true;
          }
          var i = 0;
          for (;i < attrList.length;i++) {
            a = attrList[i][0];
            var actual = element.getAttribute(a);
            if (actual) {
              var expected = attrList[i][1];
              if (expected === null || (typeof expected == "string" && actual == expected || expected.test(actual))) {
                return true;
              }
            }
          }
        }
        return false;
      },
      buildPreview : function(label) {
        var styleDefinition = this._.definition;
        var html = [];
        var elementName = styleDefinition.element;
        if (elementName == "bdo") {
          elementName = "span";
        }
        html = ["<", elementName];
        var attribs = styleDefinition.attributes;
        if (attribs) {
          var att;
          for (att in attribs) {
            html.push(" ", att, '="', attribs[att], '"');
          }
        }
        var cssStyle = self.style.getStyleText(styleDefinition);
        if (cssStyle) {
          html.push(' style="', cssStyle, '"');
        }
        html.push(">", label || styleDefinition.name, "</", elementName, ">");
        return html.join("");
      }
    };
    self.style.getStyleText = function(styleDefinition) {
      var stylesDef = styleDefinition._ST;
      if (stylesDef) {
        return stylesDef;
      }
      stylesDef = styleDefinition.styles;
      var stylesText = styleDefinition.attributes && styleDefinition.attributes.style || "";
      var optsData = "";
      if (stylesText.length) {
        stylesText = stylesText.replace(rvar, ";");
      }
      var style;
      for (style in stylesDef) {
        var styleVal = stylesDef[style];
        var buf = (style + ":" + styleVal).replace(rvar, ";");
        if (styleVal == "inherit") {
          optsData += buf;
        } else {
          stylesText += buf;
        }
      }
      if (stylesText.length) {
        stylesText = normalizeCssText(stylesText);
      }
      stylesText += optsData;
      return styleDefinition._ST = stylesText;
    };
  })();
  self.styleCommand = function(style) {
    this.style = style;
  };
  self.styleCommand.prototype.exec = function(editor) {
    var d = this;
    editor.focus();
    var optgroup = editor.document;
    if (optgroup) {
      if (d.state == 2) {
        d.style.apply(optgroup);
      } else {
        if (d.state == 1) {
          d.style.remove(optgroup);
        }
      }
    }
    return!!optgroup;
  };
  self.stylesSet = new self.resourceManager("", "stylesSet");
  self.addStylesSet = $.bind(self.stylesSet.add, self.stylesSet);
  self.loadStylesSet = function(url, deepDataAndEvents, pending) {
    self.stylesSet.addExternal(url, deepDataAndEvents, "");
    self.stylesSet.load(url, pending);
  };
  self.editor.prototype.getStylesSet = function(callback) {
    if (!this._.stylesDefinitions) {
      var me = this;
      var configStyleSet = me.config.stylesCombo_stylesSet || (me.config.stylesSet || "default");
      if (configStyleSet instanceof Array) {
        me._.stylesDefinitions = configStyleSet;
        callback(configStyleSet);
        return;
      }
      var args = configStyleSet.split(":");
      var url = args[0];
      var pageY = args[1];
      var path = editor.registered.styles.path;
      self.stylesSet.addExternal(url, pageY ? args.slice(1).join(":") : path + "styles/" + url + ".js", "");
      self.stylesSet.load(url, function(loadedImages) {
        me._.stylesDefinitions = loadedImages[url];
        callback(me._.stylesDefinitions);
      });
    } else {
      callback(this._.stylesDefinitions);
    }
  };
  editor.add("domiterator");
  (function() {
    function iterator(value) {
      var self = this;
      if (arguments.length < 1) {
        return;
      }
      self.range = value;
      self.forceBrBreak = 0;
      self.enlargeBr = 1;
      self.enforceRealBlocks = 0;
      if (!self._) {
        self._ = {};
      }
    }
    function getNextSourceNode(node, recurring, lastNode) {
      var next = node.getNextSourceNode(recurring, null, lastNode);
      for (;!bookmarkGuard(next);) {
        next = next.getNextSourceNode(recurring, null, lastNode);
      }
      return next;
    }
    var rhtml = /^[\r\n\t ]+$/;
    var bookmarkGuard = dom.walker.bookmark(false, true);
    var whitespacesGuard = dom.walker.whitespaces(true);
    var skipGuard = function(node) {
      return bookmarkGuard(node) && whitespacesGuard(node);
    };
    iterator.prototype = {
      getNextParagraph : function(blockTag) {
        var self = this;
        var block;
        var range;
        var isLast;
        var isDead;
        var stack;
        var memory;
        if (!self._.started) {
          range = self.range.clone();
          range.shrink(1, true);
          isDead = range.endContainer.hasAscendant("pre", true) || range.startContainer.hasAscendant("pre", true);
          range.enlarge(self.forceBrBreak && !isDead || !self.enlargeBr ? 3 : 2);
          if (!range.collapsed) {
            var walker = new dom.walker(range.clone());
            var ignoreBookmarkTextEvaluator = dom.walker.bookmark(true, true);
            walker.evaluator = ignoreBookmarkTextEvaluator;
            self._.nextNode = walker.next();
            walker = new dom.walker(range.clone());
            walker.evaluator = ignoreBookmarkTextEvaluator;
            var optgroup = walker.previous();
            self._.lastNode = optgroup.getNextSourceNode(true);
            if (self._.lastNode && (self._.lastNode.type == 3 && (!$.trim(self._.lastNode.getText()) && self._.lastNode.getParent().isBlockBoundary()))) {
              var testRange = new dom.range(range.document);
              testRange.moveToPosition(self._.lastNode, 4);
              if (testRange.checkEndOfBlock()) {
                var path = new dom.elementPath(testRange.endContainer);
                var lastBlock = path.block || path.blockLimit;
                self._.lastNode = lastBlock.getNextSourceNode(true);
              }
            }
            if (!self._.lastNode) {
              self._.lastNode = self._.docEndMarker = range.document.createText("");
              self._.lastNode.insertAfter(optgroup);
            }
            range = null;
          }
          self._.started = 1;
        }
        var currentNode = self._.nextNode;
        optgroup = self._.lastNode;
        self._.nextNode = null;
        for (;currentNode;) {
          var closeRange = 0;
          var parentPre = currentNode.hasAscendant("pre");
          var includeNode = currentNode.type != 1;
          var recurring = 0;
          if (!includeNode) {
            var nodeName = currentNode.getName();
            if (currentNode.isBlockBoundary(self.forceBrBreak && (!parentPre && {
              br : 1
            }))) {
              if (nodeName == "br") {
                includeNode = 1;
              } else {
                if (!range && (!currentNode.getChildCount() && nodeName != "hr")) {
                  block = currentNode;
                  isLast = currentNode.equals(optgroup);
                  break;
                }
              }
              if (range) {
                range.setEndAt(currentNode, 3);
                if (nodeName != "br") {
                  self._.nextNode = currentNode;
                }
              }
              closeRange = 1;
            } else {
              if (currentNode.getFirst()) {
                if (!range) {
                  range = new dom.range(self.range.document);
                  range.setStartAt(currentNode, 3);
                }
                currentNode = currentNode.getFirst();
                continue;
              }
              includeNode = 1;
            }
          } else {
            if (currentNode.type == 3) {
              if (rhtml.test(currentNode.getText())) {
                includeNode = 0;
              }
            }
          }
          if (includeNode && !range) {
            range = new dom.range(self.range.document);
            range.setStartAt(currentNode, 3);
          }
          isLast = (!closeRange || includeNode) && currentNode.equals(optgroup);
          if (range && !closeRange) {
            for (;!currentNode.getNext(skipGuard) && !isLast;) {
              var parentNode = currentNode.getParent();
              if (parentNode.isBlockBoundary(self.forceBrBreak && (!parentPre && {
                br : 1
              }))) {
                closeRange = 1;
                includeNode = 0;
                isLast = isLast || parentNode.equals(optgroup);
                range.setEndAt(parentNode, 2);
                break;
              }
              currentNode = parentNode;
              includeNode = 1;
              isLast = currentNode.equals(optgroup);
              recurring = 1;
            }
          }
          if (includeNode) {
            range.setEndAt(currentNode, 4);
          }
          currentNode = getNextSourceNode(currentNode, recurring, optgroup);
          isLast = !currentNode;
          if (isLast || closeRange && range) {
            break;
          }
        }
        if (!block) {
          if (!range) {
            if (self._.docEndMarker) {
              self._.docEndMarker.remove();
            }
            self._.nextNode = null;
            return null;
          }
          var startPath = new dom.elementPath(range.startContainer);
          var startBlockLimit = startPath.blockLimit;
          var checkLimits = {
            div : 1,
            th : 1,
            td : 1
          };
          block = startPath.block;
          if (!block && (!self.enforceRealBlocks && (checkLimits[startBlockLimit.getName()] && (range.checkStartOfBlock() && range.checkEndOfBlock())))) {
            block = startBlockLimit;
          } else {
            if (!block || self.enforceRealBlocks && block.getName() == "li") {
              block = self.range.document.createElement(blockTag || "p");
              range.extractContents().appendTo(block);
              block.trim();
              range.insertNode(block);
              stack = memory = true;
            } else {
              if (block.getName() != "li") {
                if (!range.checkStartOfBlock() || !range.checkEndOfBlock()) {
                  block = block.clone(false);
                  range.extractContents().appendTo(block);
                  block.trim();
                  var splitInfo = range.splitBlock();
                  stack = !splitInfo.wasStartOfBlock;
                  memory = !splitInfo.wasEndOfBlock;
                  range.insertNode(block);
                }
              } else {
                if (!isLast) {
                  self._.nextNode = block.equals(optgroup) ? null : getNextSourceNode(range.getBoundaryNodes().endNode, 1, optgroup);
                }
              }
            }
          }
        }
        if (stack) {
          var previousSibling = block.getPrevious();
          if (previousSibling && previousSibling.type == 1) {
            if (previousSibling.getName() == "br") {
              previousSibling.remove();
            } else {
              if (previousSibling.getLast() && previousSibling.getLast().$.nodeName.toLowerCase() == "br") {
                previousSibling.getLast().remove();
              }
            }
          }
        }
        if (memory) {
          var lastChild = block.getLast();
          if (lastChild && (lastChild.type == 1 && lastChild.getName() == "br")) {
            if (href || (lastChild.getPrevious(bookmarkGuard) || lastChild.getNext(bookmarkGuard))) {
              lastChild.remove();
            }
          }
        }
        if (!self._.nextNode) {
          self._.nextNode = isLast || (block.equals(optgroup) || !optgroup) ? null : getNextSourceNode(block, 1, optgroup);
        }
        return block;
      }
    };
    dom.range.prototype.createIterator = function() {
      return new iterator(this);
    };
  })();
  editor.add("panelbutton", {
    requires : ["button"],
    onLoad : function() {
      function clickFn(editor) {
        var self = this;
        var _ = self._;
        if (_.state == 0) {
          return;
        }
        self.createPanel(editor);
        if (_.on) {
          _.panel.hide();
          return;
        }
        _.panel.showBlock(self._.id, self.document.getById(self._.id), 4);
      }
      options.panelButton = $.createClass({
        base : options.button,
        $ : function(name) {
          var me = this;
          var panelDefinition = name.panel;
          delete name.panel;
          me.base(name);
          me.document = panelDefinition && (panelDefinition.parent && panelDefinition.parent.getDocument()) || self.document;
          panelDefinition.block = {
            attributes : panelDefinition.attributes
          };
          me.hasArrow = true;
          me.click = clickFn;
          me._ = {
            panelDefinition : panelDefinition
          };
        },
        statics : {
          handler : {
            create : function(definition) {
              return new options.panelButton(definition);
            }
          }
        },
        proto : {
          createPanel : function(editor) {
            var _ = this._;
            if (_.panel) {
              return;
            }
            var panelDefinition = this._.panelDefinition || {};
            var block = this._.panelDefinition.block;
            var panelParentElement = panelDefinition.parent || self.document.getBody();
            var panel = this._.panel = new options.floatPanel(editor, panelParentElement, panelDefinition);
            var waitsForFunc = panel.addBlock(_.id, block);
            var me = this;
            panel.onShow = function() {
              if (me.className) {
                this.element.getFirst().addClass(me.className + "_panel");
              }
              me.setState(1);
              _.on = 1;
              if (me.onOpen) {
                me.onOpen();
              }
            };
            panel.onHide = function(preventOnClose) {
              if (me.className) {
                this.element.getFirst().removeClass(me.className + "_panel");
              }
              me.setState(me.modes && me.modes[editor.mode] ? 2 : 0);
              _.on = 0;
              if (!preventOnClose && me.onClose) {
                me.onClose();
              }
            };
            panel.onEscape = function() {
              panel.hide();
              me.document.getById(_.id).focus();
            };
            if (this.onBlock) {
              this.onBlock(panel, waitsForFunc);
            }
            waitsForFunc.onHide = function() {
              _.on = 0;
              me.setState(2);
            };
          }
        }
      });
    },
    beforeInit : function(editor) {
      editor.ui.addHandler("panelbutton", options.panelButton.handler);
    }
  });
  self.UI_PANELBUTTON = "panelbutton";
  editor.add("floatpanel", {
    requires : ["panel"]
  });
  (function() {
    function getPanel(editor, doc, parentElement, definition, level) {
      var key = $.genKey(doc.getUniqueId(), parentElement.getUniqueId(), editor.skinName, editor.lang.dir, editor.uiColor || "", definition.css || "", level || "");
      var panel = panels[key];
      if (!panel) {
        panel = panels[key] = new options.panel(doc, definition);
        panel.element = parentElement.append(Node.createFromHtml(panel.renderHtml(editor), doc));
        panel.element.setStyles({
          display : "none",
          position : "absolute"
        });
      }
      return panel;
    }
    var panels = {};
    var n = false;
    options.floatPanel = $.createClass({
      $ : function(name, value, data, label) {
        data.forceIFrame = 1;
        var doc = value.getDocument();
        var panel = getPanel(name, doc, value, data, label || 0);
        var element = panel.element;
        var iframe = element.getFirst().getFirst();
        element.disableContextMenu();
        this.element = element;
        this._ = {
          editor : name,
          panel : panel,
          parentElement : value,
          definition : data,
          document : doc,
          iframe : iframe,
          children : [],
          dir : name.lang.dir
        };
        name.on("mode", function() {
          this.hide();
        }, this);
      },
      proto : {
        addBlock : function(name, block) {
          return this._.panel.addBlock(name, block);
        },
        addListBlock : function(name, deepDataAndEvents) {
          return this._.panel.addListBlock(name, deepDataAndEvents);
        },
        getBlock : function(name) {
          return this._.panel.getBlock(name);
        },
        showBlock : function(name, offsetParent, corner, offsetX, offsetY) {
          var panel = this._.panel;
          var block = panel.showBlock(name);
          this.allowBlur(false);
          n = 1;
          this._.returnFocus = this._.editor.focusManager.hasFocus ? this._.editor : new Node(self.document.$.activeElement);
          var element = this.element;
          var iframe = this._.iframe;
          var definition = this._.definition;
          var position = offsetParent.getDocumentPosition(element.getDocument());
          var rtl = this._.dir == "rtl";
          var left = position.x + (offsetX || 0);
          var top = position.y + (offsetY || 0);
          if (rtl && (corner == 1 || corner == 4)) {
            left += offsetParent.$.offsetWidth;
          } else {
            if (!rtl && (corner == 2 || corner == 3)) {
              left += offsetParent.$.offsetWidth - 1;
            }
          }
          if (corner == 3 || corner == 4) {
            top += offsetParent.$.offsetHeight - 1;
          }
          this._.panel._.offsetParentId = offsetParent.getId();
          element.setStyles({
            top : top + "px",
            left : 0,
            display : ""
          });
          element.setOpacity(0);
          element.getFirst().removeStyle("width");
          if (!this._.blurSet) {
            var focused = href ? iframe : new dom.window(iframe.$.contentWindow);
            self.event.useCapture = true;
            focused.on("blur", function(ev) {
              var panel = this;
              if (!panel.allowBlur()) {
                return;
              }
              var target = ev.data.getTarget();
              if (target.getName && target.getName() != "iframe") {
                return;
              }
              if (panel.visible && (!panel._.activeChild && !n)) {
                delete panel._.returnFocus;
                panel.hide();
              }
            }, this);
            focused.on("focus", function() {
              this._.focused = true;
              this.hideChild();
              this.allowBlur(true);
            }, this);
            self.event.useCapture = false;
            this._.blurSet = 1;
          }
          panel.onEscape = $.bind(function(opt_e) {
            if (this.onEscape && this.onEscape(opt_e) === false) {
              return false;
            }
          }, this);
          $.setTimeout(function() {
            var panelLoad = $.bind(function() {
              var target = element.getFirst();
              if (block.autoSize) {
                var widthNode = block.element.$;
                if (env.gecko || env.opera) {
                  widthNode = widthNode.parentNode;
                }
                if (href) {
                  widthNode = widthNode.document.body;
                }
                var width = widthNode.scrollWidth;
                if (href && (env.quirks && width > 0)) {
                  width += (target.$.offsetWidth || 0) - (target.$.clientWidth || 0) + 3;
                }
                width += 4;
                target.setStyle("width", width + "px");
                block.element.addClass("cke_frameLoaded");
                var height = block.element.$.scrollHeight;
                if (href && (env.quirks && height > 0)) {
                  height += (target.$.offsetHeight || 0) - (target.$.clientHeight || 0) + 3;
                }
                target.setStyle("height", height + "px");
                panel._.currentBlock.element.setStyle("display", "none").removeStyle("display");
              } else {
                target.removeStyle("height");
              }
              if (rtl) {
                left -= element.$.offsetWidth;
              }
              element.setStyle("left", left + "px");
              var panelElement = panel.element;
              var win = panelElement.getWindow();
              var rect = element.$.getBoundingClientRect();
              var viewportSize = win.getViewPaneSize();
              var rectWidth = rect.width || rect.right - rect.left;
              var rectHeight = rect.height || rect.bottom - rect.top;
              var spaceAfter = rtl ? rect.right : viewportSize.width - rect.left;
              var spaceBefore = rtl ? viewportSize.width - rect.right : rect.left;
              if (rtl) {
                if (spaceAfter < rectWidth) {
                  if (spaceBefore > rectWidth) {
                    left += rectWidth;
                  } else {
                    if (viewportSize.width > rectWidth) {
                      left -= rect.left;
                    } else {
                      left = left - rect.right + viewportSize.width;
                    }
                  }
                }
              } else {
                if (spaceAfter < rectWidth) {
                  if (spaceBefore > rectWidth) {
                    left -= rectWidth;
                  } else {
                    if (viewportSize.width > rectWidth) {
                      left = left - rect.right + viewportSize.width;
                    } else {
                      left -= rect.left;
                    }
                  }
                }
              }
              var spaceBelow = viewportSize.height - rect.top;
              var spaceAbove = rect.top;
              if (spaceBelow < rectHeight) {
                if (spaceAbove > rectHeight) {
                  top -= rectHeight;
                } else {
                  if (viewportSize.height > rectHeight) {
                    top = top - rect.bottom + viewportSize.height;
                  } else {
                    top -= rect.top;
                  }
                }
              }
              if (href) {
                var offsetParent = new Node(element.$.offsetParent);
                var scrollParent = offsetParent;
                if (scrollParent.getName() == "html") {
                  scrollParent = scrollParent.getDocument().getBody();
                }
                if (scrollParent.getComputedStyle("direction") == "rtl") {
                  if (env.ie8Compat) {
                    left -= element.getDocument().getDocumentElement().$.scrollLeft * 2;
                  } else {
                    left -= offsetParent.$.scrollWidth - offsetParent.$.clientWidth;
                  }
                }
              }
              var innerElement = element.getFirst();
              var activePanel;
              if (activePanel = innerElement.getCustomData("activePanel")) {
                if (activePanel.onHide) {
                  activePanel.onHide.call(this, 1);
                }
              }
              innerElement.setCustomData("activePanel", this);
              element.setStyles({
                top : top + "px",
                left : left + "px"
              });
              element.setOpacity(1);
            }, this);
            if (panel.isLoaded) {
              panelLoad();
            } else {
              panel.onLoad = panelLoad;
            }
            $.setTimeout(function() {
              iframe.$.contentWindow.focus();
              this.allowBlur(true);
            }, 0, this);
          }, env.air ? 200 : 0, this);
          this.visible = 1;
          if (this.onShow) {
            this.onShow.call(this);
          }
          n = 0;
        },
        hide : function(returnFocus) {
          var optgroup = this;
          if (optgroup.visible && (!optgroup.onHide || optgroup.onHide.call(optgroup) !== true)) {
            optgroup.hideChild();
            if (env.gecko) {
              optgroup._.iframe.getFrameDocument().$.activeElement.blur();
            }
            optgroup.element.setStyle("display", "none");
            optgroup.visible = 0;
            optgroup.element.getFirst().removeCustomData("activePanel");
            var focusReturn = returnFocus !== false && optgroup._.returnFocus;
            if (focusReturn) {
              if (env.webkit && focusReturn.type) {
                focusReturn.getWindow().$.focus();
              }
              focusReturn.focus();
            }
          }
        },
        allowBlur : function(allow) {
          var panel = this._.panel;
          if (allow != undefined) {
            panel.allowBlur = allow;
          }
          return panel.allowBlur;
        },
        showAsChild : function(panel, blockName, offsetParent, corner, offsetX, offsetY) {
          if (this._.activeChild == panel && panel._.panel._.offsetParentId == offsetParent.getId()) {
            return;
          }
          this.hideChild();
          panel.onHide = $.bind(function() {
            $.setTimeout(function() {
              if (!this._.focused) {
                this.hide();
              }
            }, 0, this);
          }, this);
          this._.activeChild = panel;
          this._.focused = false;
          panel.showBlock(blockName, offsetParent, corner, offsetX, offsetY);
          if (env.ie7Compat || env.ie8 && env.ie6Compat) {
            setTimeout(function() {
              panel.element.getChild(0).$.style.cssText += "";
            }, 100);
          }
        },
        hideChild : function() {
          var activeChild = this._.activeChild;
          if (activeChild) {
            delete activeChild.onHide;
            delete activeChild._.returnFocus;
            delete this._.activeChild;
            activeChild.hide();
          }
        }
      }
    });
    self.on("instanceDestroyed", function() {
      var p = $.isEmpty(self.instances);
      var i;
      for (i in panels) {
        var panel = panels[i];
        if (p) {
          panel.destroy();
        } else {
          panel.element.hide();
        }
      }
      if (p) {
        panels = {};
      }
    });
  })();
  editor.add("menu", {
    beforeInit : function(editor) {
      var codeSegments = editor.config.menu_groups.split(",");
      var groupsOrder = editor._.menuGroups = {};
      var old = editor._.menuItems = {};
      var i = 0;
      for (;i < codeSegments.length;i++) {
        groupsOrder[codeSegments[i]] = i + 1;
      }
      editor.addMenuGroup = function(name, order) {
        groupsOrder[name] = order || 100;
      };
      editor.addMenuItem = function(name, definition) {
        if (groupsOrder[definition.group]) {
          old[name] = new self.menuItem(this, name, definition);
        }
      };
      editor.addMenuItems = function(opt_attributes) {
        var itemName;
        for (itemName in opt_attributes) {
          this.addMenuItem(itemName, opt_attributes[itemName]);
        }
      };
      editor.getMenuItem = function(name) {
        return old[name];
      };
      editor.removeMenuItem = function(name) {
        delete old[name];
      };
    },
    requires : ["floatpanel"]
  });
  (function() {
    function sortItems(items) {
      items.sort(function(itemA, itemB) {
        if (itemA.group < itemB.group) {
          return-1;
        } else {
          if (itemA.group > itemB.group) {
            return 1;
          }
        }
        return itemA.order < itemB.order ? -1 : itemA.order > itemB.order ? 1 : 0;
      });
    }
    self.menu = $.createClass({
      $ : function(name, value) {
        var self = this;
        value = self._.definition = value || {};
        self.id = $.getNextId();
        self.editor = name;
        self.items = [];
        self._.listeners = [];
        self._.level = value.level || 1;
        var panelDefinition = $.extend({}, value.panel, {
          css : name.skin.editor.css,
          level : self._.level - 1,
          block : {}
        });
        var attrs = panelDefinition.block.attributes = panelDefinition.attributes || {};
        if (!attrs.role) {
          attrs.role = "menu";
        }
        self._.panelDefinition = panelDefinition;
      },
      _ : {
        onShow : function() {
          var self = this;
          var selection = self.editor.getSelection();
          if (href) {
            if (selection) {
              selection.lock();
            }
          }
          var entry = selection && selection.getStartElement();
          var codeSegments = self._.listeners;
          var q = [];
          self.removeAll();
          var i = 0;
          for (;i < codeSegments.length;i++) {
            var subItemDefs = codeSegments[i](entry, selection);
            if (subItemDefs) {
              var subItemName;
              for (subItemName in subItemDefs) {
                var optgroup = self.editor.getMenuItem(subItemName);
                if (optgroup && (!optgroup.command || self.editor.getCommand(optgroup.command).state)) {
                  optgroup.state = subItemDefs[subItemName];
                  self.add(optgroup);
                }
              }
            }
          }
        },
        onClick : function(item) {
          this.hide(false);
          if (item.onClick) {
            item.onClick();
          } else {
            if (item.command) {
              this.editor.execCommand(item.command);
            }
          }
        },
        onEscape : function(var_args) {
          var parent = this.parent;
          if (parent) {
            parent._.panel.hideChild();
            var parentBlock = parent._.panel._.panel._.currentBlock;
            var index = parentBlock._.focusIndex;
            parentBlock._.markItem(index);
          } else {
            if (var_args == 27) {
              this.hide();
            }
          }
          return false;
        },
        onHide : function() {
          var self = this;
          if (href && !self.parent) {
            var selection = self.editor.getSelection();
            if (selection) {
              selection.unlock(true);
            }
          }
          if (self.onHide) {
            self.onHide();
          }
        },
        showSubMenu : function(index) {
          var item = this;
          var menu = item._.subMenu;
          var suite = item.items[index];
          var subItemDefs = suite.getItems && suite.getItems();
          if (!subItemDefs) {
            item._.panel.hideChild();
            return;
          }
          var parentBlock = item._.panel.getBlock(item.id);
          parentBlock._.focusIndex = index;
          if (menu) {
            menu.removeAll();
          } else {
            menu = item._.subMenu = new self.menu(item.editor, $.extend({}, item._.definition, {
              level : item._.level + 1
            }, true));
            menu.parent = item;
            menu._.onClick = $.bind(item._.onClick, item);
          }
          var subItemName;
          for (subItemName in subItemDefs) {
            var optgroup = item.editor.getMenuItem(subItemName);
            if (optgroup) {
              optgroup.state = subItemDefs[subItemName];
              menu.add(optgroup);
            }
          }
          var offsetParent = item._.panel.getBlock(item.id).element.getDocument().getById(item.id + String(index));
          menu.show(offsetParent, 2);
        }
      },
      proto : {
        add : function(name) {
          if (!name.order) {
            name.order = this.items.length;
          }
          this.items.push(name);
        },
        removeAll : function() {
          this.items = [];
        },
        show : function(offsetParent, corner, offsetX, offsetY) {
          if (!this.parent) {
            this._.onShow();
            if (!this.items.length) {
              return;
            }
          }
          corner = corner || (this.editor.lang.dir == "rtl" ? 2 : 1);
          var items = this.items;
          var editor = this.editor;
          var panel = this._.panel;
          var element = this._.element;
          if (!panel) {
            panel = this._.panel = new options.floatPanel(this.editor, self.document.getBody(), this._.panelDefinition, this._.level);
            panel.onEscape = $.bind(function(keystroke) {
              if (this._.onEscape(keystroke) === false) {
                return false;
              }
            }, this);
            panel.onHide = $.bind(function() {
              if (this._.onHide) {
                this._.onHide();
              }
            }, this);
            var block = panel.addBlock(this.id, this._.panelDefinition.block);
            block.autoSize = true;
            var keys = block.keys;
            keys[40] = "next";
            keys[9] = "next";
            keys[38] = "prev";
            keys[2228224 + 9] = "prev";
            keys[editor.lang.dir == "rtl" ? 37 : 39] = href ? "mouseup" : "click";
            keys[32] = href ? "mouseup" : "click";
            if (href) {
              keys[13] = "mouseup";
            }
            element = this._.element = block.element;
            element.addClass(editor.skinClass);
            var elementDoc = element.getDocument();
            elementDoc.getBody().setStyle("overflow", "hidden");
            elementDoc.getElementsByTag("html").getItem(0).setStyle("overflow", "hidden");
            this._.itemOverFn = $.addFunction(function(index) {
              var self = this;
              clearTimeout(self._.showSubTimeout);
              self._.showSubTimeout = $.setTimeout(self._.showSubMenu, editor.config.menu_subMenuDelay || 400, self, [index]);
            }, this);
            this._.itemOutFn = $.addFunction(function(dataAndEvents) {
              clearTimeout(this._.showSubTimeout);
            }, this);
            this._.itemClickFn = $.addFunction(function(index) {
              var self = this;
              var rvar = self.items[index];
              if (rvar.state == 0) {
                self.hide();
                return;
              }
              if (rvar.getItems) {
                self._.showSubMenu(index);
              } else {
                self._.onClick(rvar);
              }
            }, this);
          }
          sortItems(items);
          var chromeRoot = editor.container.getChild(1);
          var failureMessage = chromeRoot.hasClass("cke_mixed_dir_content") ? " cke_mixed_dir_content" : "";
          var output = ['<div class="cke_menu' + failureMessage + '" role="presentation">'];
          var length = items.length;
          var lastGroup = length && items[0].group;
          var i = 0;
          for (;i < length;i++) {
            var item = items[i];
            if (lastGroup != item.group) {
              output.push('<div class="cke_menuseparator" role="separator"></div>');
              lastGroup = item.group;
            }
            item.render(this, i, output);
          }
          output.push("</div>");
          element.setHtml(output.join(""));
          options.fire("ready", this);
          if (this.parent) {
            this.parent._.panel.showAsChild(panel, this.id, offsetParent, corner, offsetX, offsetY);
          } else {
            panel.showBlock(this.id, offsetParent, corner, offsetX, offsetY);
          }
          editor.fire("menuShow", [panel]);
        },
        addListener : function(listener) {
          this._.listeners.push(listener);
        },
        hide : function(returnFocus) {
          var self = this;
          if (self._.onHide) {
            self._.onHide();
          }
          if (self._.panel) {
            self._.panel.hide(returnFocus);
          }
        }
      }
    });
    self.menuItem = $.createClass({
      $ : function(name, value, data) {
        var $scope = this;
        $.extend($scope, data, {
          order : 0,
          className : "cke_button_" + value
        });
        $scope.group = name._.menuGroups[$scope.group];
        $scope.editor = name;
        $scope.name = value;
      },
      proto : {
        render : function(menu, index, output) {
          var node = this;
          var extra = menu.id + String(index);
          var state = typeof node.state == "undefined" ? 2 : node.state;
          var clickFn = " cke_" + (state == 1 ? "on" : state == 0 ? "disabled" : "off");
          var content = node.label;
          if (node.className) {
            clickFn += " " + node.className;
          }
          var attrs = node.getItems;
          output.push('<span class="cke_menuitem' + (node.icon && node.icon.indexOf(".png") == -1 ? " cke_noalphafix" : "") + '">' + '<a id="', extra, '" class="', clickFn, '" href="javascript:void(\'', (node.label || "").replace("'", ""), '\')" title="', node.label, '" tabindex="-1"_cke_focus=1 hidefocus="true" role="menuitem"' + (attrs ? 'aria-haspopup="true"' : "") + (state == 0 ? 'aria-disabled="true"' : "") + (state == 1 ? 'aria-pressed="true"' : ""));
          if (env.opera || env.gecko && env.mac) {
            output.push(' onkeypress="return false;"');
          }
          if (env.gecko) {
            output.push(' onblur="this.style.cssText = this.style.cssText;"');
          }
          var v = (node.iconOffset || 0) * -16;
          output.push(' onmouseover="CKEDITOR.tools.callFunction(', menu._.itemOverFn, ",", index, ');" onmouseout="CKEDITOR.tools.callFunction(', menu._.itemOutFn, ",", index, ');" ' + (href ? 'onclick="return false;" onmouseup' : "onclick") + '="CKEDITOR.tools.callFunction(', menu._.itemClickFn, ",", index, '); return false;"><span class="cke_icon_wrapper"><span class="cke_icon"' + (node.icon ? ' style="background-image:url(' + self.getUrl(node.icon) + ");background-position:0 " + v + 'px;"' : 
          "") + "></span></span>" + '<span class="cke_label">');
          if (attrs) {
            output.push('<span class="cke_menuarrow">', "<span>&#", node.editor.lang.dir == "rtl" ? "9668" : "9658", ";</span>", "</span>");
          }
          output.push(content, "</span></a></span>");
        }
      }
    });
  })();
  config.menu_groups = "clipboard,form,tablecell,tablecellproperties,tablerow,tablecolumn,table,anchor,link,image,flash,checkbox,radio,textfield,hiddenfield,imagebutton,button,select,textarea,div";
  (function() {
    var isHandlingData;
    editor.add("editingblock", {
      init : function(editor) {
        if (!editor.config.editingBlock) {
          return;
        }
        editor.on("themeSpace", function(event) {
          if (event.data.space == "contents") {
            event.data.html += "<br>";
          }
        });
        editor.on("themeLoaded", function() {
          editor.fireOnce("editingBlockReady");
        });
        editor.on("uiReady", function() {
          editor.setMode(editor.config.startupMode);
        });
        editor.on("afterSetData", function() {
          if (!isHandlingData) {
            var setData = function() {
              isHandlingData = true;
              editor.getMode().loadData(editor.getData());
              isHandlingData = false;
            };
            if (editor.mode) {
              setData();
            } else {
              editor.on("mode", function() {
                if (editor.mode) {
                  setData();
                  editor.removeListener("mode", arguments.callee);
                }
              });
            }
          }
        });
        editor.on("beforeGetData", function() {
          if (!isHandlingData && editor.mode) {
            isHandlingData = true;
            editor.setData(editor.getMode().getData(), null, 1);
            isHandlingData = false;
          }
        });
        editor.on("getSnapshot", function(messageEvent) {
          if (editor.mode) {
            messageEvent.data = editor.getMode().getSnapshotData();
          }
        });
        editor.on("loadSnapshot", function(event) {
          if (editor.mode) {
            editor.getMode().loadSnapshotData(event.data);
          }
        });
        editor.on("mode", function(e) {
          e.removeListener();
          if (env.webkit) {
            editor.container.on("focus", function() {
              editor.focus();
            });
          }
          if (editor.config.startupFocus) {
            editor.focus();
          }
          setTimeout(function() {
            editor.fireOnce("instanceReady");
            self.fire("instanceReady", null, editor);
          }, 0);
        });
        editor.on("destroy", function() {
          var editor = this;
          if (editor.mode) {
            editor._.modes[editor.mode].unload(editor.getThemeSpace("contents"));
          }
        });
      }
    });
    self.editor.prototype.mode = "";
    self.editor.prototype.addMode = function(name, mode) {
      mode.name = name;
      (this._.modes || (this._.modes = {}))[name] = mode;
    };
    self.editor.prototype.setMode = function(mode) {
      this.fire("beforeSetMode", {
        newMode : mode
      });
      var data;
      var url = this.getThemeSpace("contents");
      var isDirty = this.checkDirty();
      if (this.mode) {
        if (mode == this.mode) {
          return;
        }
        this._.previousMode = this.mode;
        this.fire("beforeModeUnload");
        var currentMode = this.getMode();
        data = currentMode.getData();
        currentMode.unload(url);
        this.mode = "";
      }
      url.setHtml("");
      var modeEditor = this.getMode(mode);
      if (!modeEditor) {
        throw'[CKEDITOR.editor.setMode] Unknown mode "' + mode + '".';
      }
      if (!isDirty) {
        this.on("mode", function() {
          this.resetDirty();
          this.removeListener("mode", arguments.callee);
        });
      }
      modeEditor.load(url, typeof data != "string" ? this.getData() : data);
    };
    self.editor.prototype.getMode = function(mode) {
      return this._.modes && this._.modes[mode || this.mode];
    };
    self.editor.prototype.focus = function() {
      this.forceNextSelectionCheck();
      var mode = this.getMode();
      if (mode) {
        mode.focus();
      }
    };
  })();
  config.startupMode = "wysiwyg";
  config.editingBlock = true;
  (function() {
    function checkSelectionChange() {
      var self = this;
      try {
        var sel = self.getSelection();
        if (!sel || !sel.document.getWindow().$) {
          return;
        }
        var firstElement = sel.getStartElement();
        var currentPath = new dom.elementPath(firstElement);
        if (!currentPath.compare(self._.selectionPreviousPath)) {
          self._.selectionPreviousPath = currentPath;
          self.fire("selectionChange", {
            selection : sel,
            path : currentPath,
            element : firstElement
          });
        }
      } catch (D) {
      }
    }
    function checkSelectionChangeTimeout() {
      o = true;
      if (pos) {
        return;
      }
      handler.call(this);
      pos = $.setTimeout(handler, 200, this);
    }
    function handler() {
      pos = null;
      if (o) {
        $.setTimeout(checkSelectionChange, 0, this);
        o = false;
      }
    }
    function rangeRequiresFix(range) {
      function find(field) {
        return field && (field.type == 1 && field.getName() in dtd.$removeEmpty);
      }
      function setContent(element) {
        var node = range.document.getBody();
        return!element.is("body") && node.getChildCount() == 1;
      }
      var element = range.startContainer;
      var recurring = range.startOffset;
      if (element.type == 3) {
        return false;
      }
      return!$.trim(element.getHtml()) ? find(element) || setContent(element) : find(element.getChild(recurring - 1)) || find(element.getChild(recurring));
    }
    function createFillingChar(doc) {
      removeFillingChar(doc);
      var fillingChar = doc.createText("\u200b");
      doc.setCustomData("cke-fillingChar", fillingChar);
      return fillingChar;
    }
    function getFillingChar(doc) {
      return doc && doc.getCustomData("cke-fillingChar");
    }
    function checkFillingChar(doc) {
      var fillingChar = doc && getFillingChar(doc);
      if (fillingChar) {
        if (fillingChar.getCustomData("ready")) {
          removeFillingChar(doc);
        } else {
          fillingChar.setCustomData("ready", 1);
        }
      }
    }
    function removeFillingChar(doc) {
      var fillingChar = doc && doc.removeCustomData("cke-fillingChar");
      if (fillingChar) {
        var bm;
        var sel = doc.getSelection().getNative();
        var range = sel && (sel.type != "None" && sel.getRangeAt(0));
        if (fillingChar.getLength() > 1 && (range && range.intersectsNode(fillingChar.$))) {
          bm = [sel.anchorOffset, sel.focusOffset];
          var E = sel.anchorNode == fillingChar.$ && sel.anchorOffset > 0;
          var F = sel.focusNode == fillingChar.$ && sel.focusOffset > 0;
          if (E) {
            bm[0]--;
          }
          if (F) {
            bm[1]--;
          }
          if (isReversedSelection(sel)) {
            bm.unshift(bm.pop());
          }
        }
        fillingChar.setText(fillingChar.getText().replace(/\u200B/g, ""));
        if (bm) {
          var rng = sel.getRangeAt(0);
          rng.setStart(rng.startContainer, bm[0]);
          rng.setEnd(rng.startContainer, bm[1]);
          sel.removeAllRanges();
          sel.addRange(rng);
        }
      }
    }
    function isReversedSelection(sel) {
      if (!sel.isCollapsed) {
        var range = sel.getRangeAt(0);
        range.setStart(sel.anchorNode, sel.anchorOffset);
        range.setEnd(sel.focusNode, sel.focusOffset);
        return range.collapsed;
      }
    }
    var pos;
    var o;
    var selectAllCmd = {
      modes : {
        wysiwyg : 1,
        source : 1
      },
      readOnly : href || env.webkit,
      exec : function(editor) {
        switch(editor.mode) {
          case "wysiwyg":
            editor.document.$.execCommand("SelectAll", false, null);
            editor.forceNextSelectionCheck();
            editor.selectionChange();
            break;
          case "source":
            var textarea = editor.textarea.$;
            if (href) {
              textarea.createTextRange().execCommand("SelectAll");
            } else {
              textarea.selectionStart = 0;
              textarea.selectionEnd = textarea.value.length;
            }
            textarea.focus();
        }
      },
      canUndo : false
    };
    editor.add("selection", {
      init : function(optgroup) {
        if (env.webkit) {
          optgroup.on("selectionChange", function() {
            checkFillingChar(optgroup.document);
          });
          optgroup.on("beforeSetMode", function() {
            removeFillingChar(optgroup.document);
          });
          var retryNote;
          var B;
          var beforeData = function() {
            var doc = optgroup.document;
            var fillingChar = getFillingChar(doc);
            if (fillingChar) {
              var sel = doc.$.defaultView.getSelection();
              if (sel.type == "Caret" && sel.anchorNode == fillingChar.$) {
                B = 1;
              }
              retryNote = fillingChar.getText();
              fillingChar.setText(retryNote.replace(/\u200B/g, ""));
            }
          };
          var afterData = function() {
            var doc = optgroup.document;
            var fillingChar = getFillingChar(doc);
            if (fillingChar) {
              fillingChar.setText(retryNote);
              if (B) {
                doc.$.defaultView.getSelection().setPosition(fillingChar.$, fillingChar.getLength());
                B = 0;
              }
            }
          };
          optgroup.on("beforeUndoImage", beforeData);
          optgroup.on("afterUndoImage", afterData);
          optgroup.on("beforeGetData", beforeData, null, null, 0);
          optgroup.on("getData", afterData);
        }
        optgroup.on("contentDom", function() {
          var doc = optgroup.document;
          var body = doc.getBody();
          var html = doc.getDocumentElement();
          if (href) {
            var savedRange;
            var I;
            var restoreEnabled = 1;
            body.on("focusin", function(evt) {
              if (evt.data.$.srcElement.nodeName != "BODY") {
                return;
              }
              var lockedSelection = doc.getCustomData("cke_locked_selection");
              if (lockedSelection) {
                lockedSelection.unlock(1);
                lockedSelection.lock();
              } else {
                if (savedRange && restoreEnabled) {
                  try {
                    savedRange.select();
                  } catch (Q) {
                  }
                  savedRange = null;
                }
              }
            });
            body.on("focus", function() {
              I = 1;
              saveSelection();
            });
            body.on("beforedeactivate", function(evt) {
              if (evt.data.$.toElement) {
                return;
              }
              I = 0;
              restoreEnabled = 1;
            });
            if (href) {
              optgroup.on("blur", function() {
                try {
                  doc.$.selection.empty();
                } catch (O) {
                }
              });
            }
            html.on("mousedown", function() {
              restoreEnabled = 0;
            });
            html.on("mouseup", function() {
              restoreEnabled = 1;
            });
            var scroll;
            body.on("mousedown", function(evt) {
              if (evt.data.$.button == 2) {
                var sel = optgroup.document.$.selection;
                if (sel.type == "None") {
                  scroll = optgroup.window.getScrollPosition();
                }
              }
              callback();
            });
            body.on("mouseup", function(evt) {
              if (evt.data.$.button == 2 && scroll) {
                optgroup.document.$.documentElement.scrollLeft = scroll.x;
                optgroup.document.$.documentElement.scrollTop = scroll.y;
              }
              scroll = null;
              I = 1;
              setTimeout(function() {
                saveSelection(true);
              }, 0);
            });
            body.on("keydown", callback);
            body.on("keyup", function() {
              I = 1;
              saveSelection();
            });
            if ((env.ie7Compat || env.ie6Compat) && doc.$.compatMode != "BackCompat") {
              var moveRangeToPoint = function(range, x, y) {
                try {
                  range.moveToPoint(x, y);
                } catch (R) {
                }
              };
              html.on("mousedown", function(evt) {
                function onHover(evt) {
                  evt = evt.data.$;
                  if (textRng) {
                    var rngEnd = body.$.createTextRange();
                    moveRangeToPoint(rngEnd, evt.x, evt.y);
                    textRng.setEndPoint(textRng.compareEndPoints("StartToStart", rngEnd) < 0 ? "EndToEnd" : "StartToStart", rngEnd);
                    textRng.select();
                  }
                }
                evt = evt.data.$;
                if (evt.y < html.$.clientHeight && (evt.y > body.$.offsetTop + body.$.clientHeight && evt.x < html.$.clientWidth)) {
                  var textRng = body.$.createTextRange();
                  moveRangeToPoint(textRng, evt.x, evt.y);
                  html.on("mousemove", onHover);
                  html.on("mouseup", function(e) {
                    html.removeListener("mousemove", onHover);
                    e.removeListener();
                    textRng.select();
                  });
                }
              });
            }
            if (env.ie8) {
              html.on("mouseup", function(ev) {
                if (ev.data.getTarget().getName() == "html") {
                  var sel = self.document.$.selection;
                  var range = sel.createRange();
                  if (sel.type != "None" && range.parentElement().ownerDocument == doc.$) {
                    range.select();
                  }
                }
              });
            }
            doc.on("selectionchange", saveSelection);
            var callback = function() {
              I = 0;
            };
            var saveSelection = function(testIt) {
              if (I) {
                var doc = optgroup.document;
                var sel = optgroup.getSelection();
                var nativeSel = sel && sel.getNative();
                if (testIt && (nativeSel && nativeSel.type == "None")) {
                  if (!doc.$.queryCommandEnabled("InsertImage")) {
                    $.setTimeout(saveSelection, 50, this, true);
                    return;
                  }
                }
                var parentTag;
                if (nativeSel && (nativeSel.type && (nativeSel.type != "Control" && ((parentTag = nativeSel.createRange()) && ((parentTag = parentTag.parentElement()) && ((parentTag = parentTag.nodeName) && parentTag.toLowerCase() in {
                  input : 1,
                  textarea : 1
                })))))) {
                  return;
                }
                savedRange = nativeSel && sel.getRanges()[0];
                checkSelectionChangeTimeout.call(optgroup);
              }
            };
          } else {
            doc.on("mouseup", checkSelectionChangeTimeout, optgroup);
            doc.on("keyup", checkSelectionChangeTimeout, optgroup);
            doc.on("selectionchange", checkSelectionChangeTimeout, optgroup);
          }
          if (env.webkit) {
            doc.on("keydown", function(evt) {
              var P = evt.data.getKey();
              switch(P) {
                case 13:
                ;
                case 33:
                ;
                case 34:
                ;
                case 35:
                ;
                case 36:
                ;
                case 37:
                ;
                case 39:
                ;
                case 8:
                ;
                case 45:
                ;
                case 46:
                  removeFillingChar(optgroup.document);
              }
            }, null, null, 10);
          }
        });
        optgroup.on("contentDomUnload", optgroup.forceNextSelectionCheck, optgroup);
        optgroup.addCommand("selectAll", selectAllCmd);
        optgroup.ui.addButton("SelectAll", {
          label : optgroup.lang.selectAll,
          command : "selectAll"
        });
        optgroup.selectionChange = function(checkNow) {
          (checkNow ? checkSelectionChange : checkSelectionChangeTimeout).call(this);
        };
        if (env.ie9Compat) {
          optgroup.on("destroy", function() {
            var self = optgroup.getSelection();
            if (self) {
              self.getNative().clear();
            }
          }, null, null, 9);
        }
      }
    });
    self.editor.prototype.getSelection = function() {
      return this.document && this.document.getSelection();
    };
    self.editor.prototype.forceNextSelectionCheck = function() {
      delete this._.selectionPreviousPath;
    };
    doc.prototype.getSelection = function() {
      var sel = new dom.selection(this);
      return!sel || sel.isInvalid ? null : sel;
    };
    self.SELECTION_NONE = 1;
    self.SELECTION_TEXT = 2;
    self.SELECTION_ELEMENT = 3;
    dom.selection = function(doc) {
      var self = this;
      var lockedSelection = doc.getCustomData("cke_locked_selection");
      if (lockedSelection) {
        return lockedSelection;
      }
      self.document = doc;
      self.isLocked = 0;
      self._ = {
        cache : {}
      };
      if (href) {
        try {
          var range = self.getNative().createRange();
          if (!range || (range.item && range.item(0).ownerDocument != self.document.$ || range.parentElement && range.parentElement().ownerDocument != self.document.$)) {
            throw 0;
          }
        } catch (D) {
          self.isInvalid = true;
        }
      }
      return self;
    };
    var styleObjectElements = {
      img : 1,
      hr : 1,
      li : 1,
      table : 1,
      tr : 1,
      td : 1,
      th : 1,
      embed : 1,
      object : 1,
      ol : 1,
      ul : 1,
      a : 1,
      input : 1,
      form : 1,
      select : 1,
      textarea : 1,
      button : 1,
      fieldset : 1,
      thead : 1,
      tfoot : 1
    };
    dom.selection.prototype = {
      getNative : href ? function() {
        return this._.cache.nativeSel || (this._.cache.nativeSel = this.document.$.selection);
      } : function() {
        return this._.cache.nativeSel || (this._.cache.nativeSel = this.document.getWindow().$.getSelection());
      },
      getType : href ? function() {
        var cache = this._.cache;
        if (cache.type) {
          return cache.type;
        }
        var type = 1;
        try {
          var sel = this.getNative();
          var ieType = sel.type;
          if (ieType == "Text") {
            type = 2;
          }
          if (ieType == "Control") {
            type = 3;
          }
          if (sel.createRange().parentElement) {
            type = 2;
          }
        } catch (D) {
        }
        return cache.type = type;
      } : function() {
        var cache = this._.cache;
        if (cache.type) {
          return cache.type;
        }
        var type = 2;
        var sel = this.getNative();
        if (!sel) {
          type = 1;
        } else {
          if (sel.rangeCount == 1) {
            var range = sel.getRangeAt(0);
            var startContainer = range.startContainer;
            if (startContainer == range.endContainer && (startContainer.nodeType == 1 && (range.endOffset - range.startOffset == 1 && styleObjectElements[startContainer.childNodes[range.startOffset].nodeName.toLowerCase()]))) {
              type = 3;
            }
          }
        }
        return cache.type = type;
      },
      getRanges : function() {
        var action = href ? function() {
          function getNodeIndex(node) {
            return(new dom.node(node)).getIndex();
          }
          var getBoundaryInformation = function(range, start) {
            range = range.duplicate();
            range.collapse(start);
            var parent = range.parentElement();
            var doc = parent.ownerDocument;
            if (!parent.hasChildNodes()) {
              return{
                container : parent,
                offset : 0
              };
            }
            var siblings = parent.children;
            var child;
            var sibling;
            var testRange = range.duplicate();
            var low = 0;
            var high = siblings.length - 1;
            var index = -1;
            var position;
            var distance;
            var container;
            for (;low <= high;) {
              index = Math.floor((low + high) / 2);
              child = siblings[index];
              testRange.moveToElementText(child);
              position = testRange.compareEndPoints("StartToStart", range);
              if (position > 0) {
                high = index - 1;
              } else {
                if (position < 0) {
                  low = index + 1;
                } else {
                  if (env.ie9Compat && child.tagName == "BR") {
                    var sel = doc.defaultView.getSelection();
                    return{
                      container : sel[start ? "anchorNode" : "focusNode"],
                      offset : sel[start ? "anchorOffset" : "focusOffset"]
                    };
                  } else {
                    return{
                      container : parent,
                      offset : getNodeIndex(child)
                    };
                  }
                }
              }
            }
            if (index == -1 || index == siblings.length - 1 && position < 0) {
              testRange.moveToElementText(parent);
              testRange.setEndPoint("StartToStart", range);
              distance = testRange.text.replace(/(\r\n|\r)/g, "\n").length;
              siblings = parent.childNodes;
              if (!distance) {
                child = siblings[siblings.length - 1];
                if (child.nodeType != 3) {
                  return{
                    container : parent,
                    offset : siblings.length
                  };
                } else {
                  return{
                    container : child,
                    offset : child.nodeValue.length
                  };
                }
              }
              var i = siblings.length;
              for (;distance > 0 && i > 0;) {
                sibling = siblings[--i];
                if (sibling.nodeType == 3) {
                  container = sibling;
                  distance -= sibling.nodeValue.length;
                }
              }
              return{
                container : container,
                offset : -distance
              };
            } else {
              testRange.collapse(position > 0 ? true : false);
              testRange.setEndPoint(position > 0 ? "StartToStart" : "EndToStart", range);
              distance = testRange.text.replace(/(\r\n|\r)/g, "\n").length;
              if (!distance) {
                return{
                  container : parent,
                  offset : getNodeIndex(child) + (position > 0 ? 0 : 1)
                };
              }
              for (;distance > 0;) {
                try {
                  sibling = child[position > 0 ? "previousSibling" : "nextSibling"];
                  if (sibling.nodeType == 3) {
                    distance -= sibling.nodeValue.length;
                    container = sibling;
                  }
                  child = sibling;
                } catch (S) {
                  return{
                    container : parent,
                    offset : getNodeIndex(child)
                  };
                }
              }
              return{
                container : container,
                offset : position > 0 ? -distance : container.nodeValue.length + distance
              };
            }
          };
          return function() {
            var self = this;
            var sel = self.getNative();
            var nativeRange = sel && sel.createRange();
            var E = self.getType();
            var range;
            if (!sel) {
              return[];
            }
            if (E == 2) {
              range = new dom.range(self.document);
              var boundaryInfo = getBoundaryInformation(nativeRange, true);
              range.setStart(new dom.node(boundaryInfo.container), boundaryInfo.offset);
              boundaryInfo = getBoundaryInformation(nativeRange);
              range.setEnd(new dom.node(boundaryInfo.container), boundaryInfo.offset);
              if (range.endContainer.getPosition(range.startContainer) & 4 && range.endOffset <= range.startContainer.getIndex()) {
                range.collapse();
              }
              return[range];
            } else {
              if (E == 3) {
                var retval = [];
                var i = 0;
                for (;i < nativeRange.length;i++) {
                  var element = nativeRange.item(i);
                  var parentElement = element.parentNode;
                  var j = 0;
                  range = new dom.range(self.document);
                  for (;j < parentElement.childNodes.length && parentElement.childNodes[j] != element;j++) {
                  }
                  range.setStart(new dom.node(parentElement), j);
                  range.setEnd(new dom.node(parentElement), j + 1);
                  retval.push(range);
                }
                return retval;
              }
            }
            return[];
          };
        }() : function() {
          var retval = [];
          var range;
          var doc = this.document;
          var sel = this.getNative();
          if (!sel) {
            return retval;
          }
          if (!sel.rangeCount) {
            range = new dom.range(doc);
            range.moveToElementEditStart(doc.getBody());
            retval.push(range);
          }
          var i = 0;
          for (;i < sel.rangeCount;i++) {
            var nativeRange = sel.getRangeAt(i);
            range = new dom.range(doc);
            range.setStart(new dom.node(nativeRange.startContainer), nativeRange.startOffset);
            range.setEnd(new dom.node(nativeRange.endContainer), nativeRange.endOffset);
            retval.push(range);
          }
          return retval;
        };
        return function(force) {
          var cache = this._.cache;
          if (cache.ranges && !force) {
            return cache.ranges;
          } else {
            if (!cache.ranges) {
              cache.ranges = new dom.rangeList(action.call(this));
            }
          }
          if (force) {
            var ranges = cache.ranges;
            var i = 0;
            for (;i < ranges.length;i++) {
              var range = ranges[i];
              var ancestor = range.getCommonAncestor();
              if (ancestor.isReadOnly()) {
                ranges.splice(i, 1);
              }
              if (range.collapsed) {
                continue;
              }
              if (range.startContainer.isReadOnly()) {
                var current = range.startContainer;
                for (;current;) {
                  if (current.is("body") || !current.isReadOnly()) {
                    break;
                  }
                  if (current.type == 1 && current.getAttribute("contentEditable") == "false") {
                    range.setStartAfter(current);
                  }
                  current = current.getParent();
                }
              }
              var startContainer = range.startContainer;
              var endContainer = range.endContainer;
              var startOffset = range.startOffset;
              var endOffset = range.endOffset;
              var walkerRange = range.clone();
              if (startContainer && startContainer.type == 3) {
                if (startOffset >= startContainer.getLength()) {
                  walkerRange.setStartAfter(startContainer);
                } else {
                  walkerRange.setStartBefore(startContainer);
                }
              }
              if (endContainer && endContainer.type == 3) {
                if (!endOffset) {
                  walkerRange.setEndBefore(endContainer);
                } else {
                  walkerRange.setEndAfter(endContainer);
                }
              }
              var walker = new dom.walker(walkerRange);
              walker.evaluator = function(node) {
                if (node.type == 1 && node.isReadOnly()) {
                  var newRange = range.clone();
                  range.setEndBefore(node);
                  if (range.collapsed) {
                    ranges.splice(i--, 1);
                  }
                  if (!(node.getPosition(walkerRange.endContainer) & 16)) {
                    newRange.setStartAfter(node);
                    if (!newRange.collapsed) {
                      ranges.splice(i + 1, 0, newRange);
                    }
                  }
                  return true;
                }
                return false;
              };
              walker.next();
            }
          }
          return cache.ranges;
        };
      }(),
      getStartElement : function() {
        var selection = this;
        var cache = selection._.cache;
        if (cache.startElement !== undefined) {
          return cache.startElement;
        }
        var node;
        var B = selection.getNative();
        switch(selection.getType()) {
          case 3:
            return selection.getSelectedElement();
          case 2:
            var range = selection.getRanges()[0];
            if (range) {
              if (!range.collapsed) {
                range.optimize();
                for (;1;) {
                  var startContainer = range.startContainer;
                  var startOffset = range.startOffset;
                  if (startOffset == (startContainer.getChildCount ? startContainer.getChildCount() : startContainer.getLength()) && !startContainer.isBlockBoundary()) {
                    range.setStartAfter(startContainer);
                  } else {
                    break;
                  }
                }
                node = range.startContainer;
                if (node.type != 1) {
                  return node.getParent();
                }
                node = node.getChild(range.startOffset);
                if (!node || node.type != 1) {
                  node = range.startContainer;
                } else {
                  var elem = node.getFirst();
                  for (;elem && elem.type == 1;) {
                    node = elem;
                    elem = elem.getFirst();
                  }
                }
              } else {
                node = range.startContainer;
                if (node.type != 1) {
                  node = node.getParent();
                }
              }
              node = node.$;
            }
          ;
        }
        return cache.startElement = node ? new Node(node) : null;
      },
      getSelectedElement : function() {
        var cache = this._.cache;
        if (cache.selectedElement !== undefined) {
          return cache.selectedElement;
        }
        var self = this;
        var node = $.tryThese(function() {
          return self.getNative().createRange().item(0);
        }, function() {
          var root;
          var retval;
          var range = self.getRanges()[0];
          var ancestor = range.getCommonAncestor(1, 1);
          var tags = {
            table : 1,
            ul : 1,
            ol : 1,
            dl : 1
          };
          var t;
          for (t in tags) {
            if (root = ancestor.getAscendant(t, 1)) {
              break;
            }
          }
          if (root) {
            var testRange = new dom.range(this.document);
            testRange.setStartAt(root, 1);
            testRange.setEnd(range.startContainer, range.startOffset);
            var enlargeables = $.extend(tags, dtd.$listItem, dtd.$tableContent);
            var walker = new dom.walker(testRange);
            var guard = function(walker, isEnd) {
              return function(node, isWalkOut) {
                if (node.type == 3 && (!$.trim(node.getText()) || node.getParent().data("cke-bookmark"))) {
                  return true;
                }
                var tag;
                if (node.type == 1) {
                  tag = node.getName();
                  if (tag == "br" && (isEnd && node.equals(node.getParent().getBogus()))) {
                    return true;
                  }
                  if (isWalkOut && tag in enlargeables || tag in dtd.$removeEmpty) {
                    return true;
                  }
                }
                walker.halted = 1;
                return false;
              };
            };
            walker.guard = guard(walker);
            if (walker.checkBackward() && !walker.halted) {
              walker = new dom.walker(testRange);
              testRange.setStart(range.endContainer, range.endOffset);
              testRange.setEndAt(root, 2);
              walker.guard = guard(walker, 1);
              if (walker.checkForward() && !walker.halted) {
                retval = root.$;
              }
            }
          }
          if (!retval) {
            throw 0;
          }
          return retval;
        }, function() {
          var range = self.getRanges()[0];
          var enclosed;
          var selected;
          var F = 2;
          for (;F && !((enclosed = range.getEnclosedNode()) && (enclosed.type == 1 && (styleObjectElements[enclosed.getName()] && (selected = enclosed))));F--) {
            range.shrink(1);
          }
          return selected.$;
        });
        return cache.selectedElement = node ? new Node(node) : null;
      },
      getSelectedText : function() {
        var cache = this._.cache;
        if (cache.selectedText !== undefined) {
          return cache.selectedText;
        }
        var text = "";
        var nativeSel = this.getNative();
        if (this.getType() == 2) {
          text = href ? nativeSel.createRange().text : nativeSel.toString();
        }
        return cache.selectedText = text;
      },
      lock : function() {
        var selection = this;
        selection.getRanges();
        selection.getStartElement();
        selection.getSelectedElement();
        selection.getSelectedText();
        selection._.cache.nativeSel = {};
        selection.isLocked = 1;
        selection.document.setCustomData("cke_locked_selection", selection);
      },
      unlock : function(dataAndEvents) {
        var sel = this;
        var doc = sel.document;
        var lockedSelection = doc.getCustomData("cke_locked_selection");
        if (lockedSelection) {
          doc.setCustomData("cke_locked_selection", null);
          if (dataAndEvents) {
            var control = lockedSelection.getSelectedElement();
            var ranges = !control && lockedSelection.getRanges();
            sel.isLocked = 0;
            sel.reset();
            if (control) {
              sel.selectElement(control);
            } else {
              sel.selectRanges(ranges);
            }
          }
        }
        if (!lockedSelection || !dataAndEvents) {
          sel.isLocked = 0;
          sel.reset();
        }
      },
      reset : function() {
        this._.cache = {};
      },
      selectElement : function(element) {
        var that = this;
        if (that.isLocked) {
          var range = new dom.range(that.document);
          range.setStartBefore(element);
          range.setEndAfter(element);
          that._.cache.selectedElement = element;
          that._.cache.startElement = element;
          that._.cache.ranges = new dom.rangeList(range);
          that._.cache.type = 3;
          return;
        }
        range = new dom.range(element.getDocument());
        range.setStartBefore(element);
        range.setEndAfter(element);
        range.select();
        that.document.fire("selectionchange");
        that.reset();
      },
      selectRanges : function(ranges) {
        var self = this;
        if (self.isLocked) {
          self._.cache.selectedElement = null;
          self._.cache.startElement = ranges[0] && ranges[0].getTouchedStartNode();
          self._.cache.ranges = new dom.rangeList(ranges);
          self._.cache.type = 2;
          return;
        }
        if (href) {
          if (ranges.length > 1) {
            var last = ranges[ranges.length - 1];
            ranges[0].setEnd(last.endContainer, last.endOffset);
            ranges.length = 1;
          }
          if (ranges[0]) {
            ranges[0].select();
          }
          self.reset();
        } else {
          var selection = self.getNative();
          if (!selection) {
            return;
          }
          if (ranges.length) {
            selection.removeAllRanges();
            if (env.webkit) {
              removeFillingChar(self.document);
            }
          }
          var i = 0;
          for (;i < ranges.length;i++) {
            if (i < ranges.length - 1) {
              var left = ranges[i];
              var right = ranges[i + 1];
              var between = left.clone();
              between.setStart(left.endContainer, left.endOffset);
              between.setEnd(right.startContainer, right.startOffset);
              if (!between.collapsed) {
                between.shrink(1, true);
                var ancestor = between.getCommonAncestor();
                var parent = between.getEnclosedNode();
                if (ancestor.isReadOnly() || parent && parent.isReadOnly()) {
                  right.setStart(left.startContainer, left.startOffset);
                  ranges.splice(i--, 1);
                  continue;
                }
              }
            }
            var range = ranges[i];
            var nativeRange = self.document.$.createRange();
            var startContainer = range.startContainer;
            if (range.collapsed && ((env.opera || env.gecko && env.version < 10900) && (startContainer.type == 1 && !startContainer.getChildCount()))) {
              startContainer.appendText("");
            }
            if (range.collapsed && (env.webkit && rangeRequiresFix(range))) {
              var startNode = createFillingChar(self.document);
              range.insertNode(startNode);
              var sibling = startNode.getNext();
              if (sibling && (!startNode.getPrevious() && (sibling.type == 1 && sibling.getName() == "br"))) {
                removeFillingChar(self.document);
                range.moveToPosition(sibling, 3);
              } else {
                range.moveToPosition(startNode, 4);
              }
            }
            nativeRange.setStart(range.startContainer.$, range.startOffset);
            try {
              nativeRange.setEnd(range.endContainer.$, range.endOffset);
            } catch (dstUri) {
              if (dstUri.toString().indexOf("NS_ERROR_ILLEGAL_VALUE") >= 0) {
                range.collapse(1);
                nativeRange.setEnd(range.endContainer.$, range.endOffset);
              } else {
                throw dstUri;
              }
            }
            selection.addRange(nativeRange);
          }
          self.document.fire("selectionchange");
          self.reset();
        }
      },
      createBookmarks : function(dataAndEvents) {
        return this.getRanges().createBookmarks(dataAndEvents);
      },
      createBookmarks2 : function(deepDataAndEvents) {
        return this.getRanges().createBookmarks2(deepDataAndEvents);
      },
      selectBookmarks : function(bookmarks) {
        var ranges = [];
        var i = 0;
        for (;i < bookmarks.length;i++) {
          var range = new dom.range(this.document);
          range.moveToBookmark(bookmarks[i]);
          ranges.push(range);
        }
        this.selectRanges(ranges);
        return this;
      },
      getCommonAncestor : function() {
        var ranges = this.getRanges();
        var start = ranges[0].startContainer;
        var end = ranges[ranges.length - 1].endContainer;
        return start.getCommonAncestor(end);
      },
      scrollIntoView : function() {
        var start = this.getStartElement();
        start.scrollIntoView();
      }
    };
  })();
  (function() {
    var evaluator = dom.walker.whitespaces(true);
    var typePattern = /\ufeff|\u00a0/;
    var nonCells = {
      table : 1,
      tbody : 1,
      tr : 1
    };
    dom.range.prototype.select = href ? function(dataAndEvents) {
      var self = this;
      var collapsed = self.collapsed;
      var r;
      var startNode;
      var ieRange;
      var selected = self.getEnclosedNode();
      if (selected) {
        try {
          ieRange = self.document.$.body.createControlRange();
          ieRange.addElement(selected.$);
          ieRange.select();
          return;
        } catch (B) {
        }
      }
      if (self.startContainer.type == 1 && self.startContainer.getName() in nonCells || self.endContainer.type == 1 && self.endContainer.getName() in nonCells) {
        self.shrink(1, true);
      }
      var bookmark = self.createBookmark();
      var optgroup = bookmark.startNode;
      var endNode;
      if (!collapsed) {
        endNode = bookmark.endNode;
      }
      ieRange = self.document.$.body.createTextRange();
      ieRange.moveToElementText(optgroup.$);
      ieRange.moveStart("character", 1);
      if (endNode) {
        var ieRangeEnd = self.document.$.body.createTextRange();
        ieRangeEnd.moveToElementText(endNode.$);
        ieRange.setEndPoint("EndToEnd", ieRangeEnd);
        ieRange.moveEnd("character", -1);
      } else {
        var range = optgroup.getNext(evaluator);
        r = !(range && (range.getText && range.getText().match(typePattern))) && (dataAndEvents || (!optgroup.hasPrevious() || optgroup.getPrevious().is && optgroup.getPrevious().is("br")));
        startNode = self.document.createElement("span");
        startNode.setHtml("&#65279;");
        startNode.insertBefore(optgroup);
        if (r) {
          self.document.createText("\ufeff").insertBefore(optgroup);
        }
      }
      self.setStartBefore(optgroup);
      optgroup.remove();
      if (collapsed) {
        if (r) {
          ieRange.moveStart("character", -1);
          ieRange.select();
          self.document.$.selection.clear();
        } else {
          ieRange.select();
        }
        self.moveToPosition(startNode, 3);
        startNode.remove();
      } else {
        self.setEndBefore(endNode);
        endNode.remove();
        ieRange.select();
      }
      self.document.fire("selectionchange");
    } : function() {
      this.document.getSelection().selectRanges([this]);
    };
  })();
  (function() {
    function replaceCssLength(nextLine, x) {
      var widthMatch = multi.exec(nextLine);
      var xy = multi.exec(x);
      if (widthMatch) {
        if (!widthMatch[2] && xy[2] == "px") {
          return xy[1];
        }
        if (widthMatch[2] == "px" && !xy[2]) {
          return xy[1] + "px";
        }
      }
      return x;
    }
    var cssStyle = self.htmlParser.cssStyle;
    var cssLength = $.cssLength;
    var multi = /^((?:\d*(?:\.\d+))|(?:\d+))(.*)?$/i;
    var htmlFilterRules = {
      elements : {
        $ : function(name) {
          var attributes = name.attributes;
          var realHtml = attributes && attributes["data-cke-realelement"];
          var realFragment = realHtml && new self.htmlParser.fragment.fromHtml(decodeURIComponent(realHtml));
          var realElement = realFragment && realFragment.children[0];
          if (realElement && name.attributes["data-cke-resizable"]) {
            var styles = (new cssStyle(name)).rules;
            var realAttrs = realElement.attributes;
            var width = styles.width;
            var height = styles.height;
            if (width) {
              realAttrs.width = replaceCssLength(realAttrs.width, width);
            }
            if (height) {
              realAttrs.height = replaceCssLength(realAttrs.height, height);
            }
          }
          return realElement;
        }
      }
    };
    editor.add("fakeobjects", {
      requires : ["htmlwriter"],
      afterInit : function(editor) {
        var dataProcessor = editor.dataProcessor;
        var htmlFilter = dataProcessor && dataProcessor.htmlFilter;
        if (htmlFilter) {
          htmlFilter.addRules(htmlFilterRules);
        }
      }
    });
    self.editor.prototype.createFakeElement = function(realElement, className, realElementType, isResizable) {
      var lang = this.lang.fakeobjects;
      var label = lang[realElementType] || lang.unknown;
      var attributes = {
        "class" : className,
        "data-cke-realelement" : encodeURIComponent(realElement.getOuterHtml()),
        "data-cke-real-node-type" : realElement.type,
        alt : label,
        title : label,
        align : realElement.getAttribute("align") || ""
      };
      if (!env.hc) {
        attributes.src = self.getUrl("images/spacer.gif");
      }
      if (realElementType) {
        attributes["data-cke-real-element-type"] = realElementType;
      }
      if (isResizable) {
        attributes["data-cke-resizable"] = isResizable;
        var fakeStyle = new cssStyle;
        var width = realElement.getAttribute("width");
        var height = realElement.getAttribute("height");
        if (width) {
          fakeStyle.rules.width = cssLength(width);
        }
        if (height) {
          fakeStyle.rules.height = cssLength(height);
        }
        fakeStyle.populate(attributes);
      }
      return this.document.createElement("img", {
        attributes : attributes
      });
    };
    self.editor.prototype.createFakeParserElement = function(realElement, className, realElementType, dataAndEvents) {
      var lang = this.lang.fakeobjects;
      var label = lang[realElementType] || lang.unknown;
      var encodedValue;
      var writer = new self.htmlParser.basicWriter;
      realElement.writeHtml(writer);
      encodedValue = writer.getHtml();
      var attributes = {
        "class" : className,
        "data-cke-realelement" : encodeURIComponent(encodedValue),
        "data-cke-real-node-type" : realElement.type,
        alt : label,
        title : label,
        align : realElement.attributes.align || ""
      };
      if (!env.hc) {
        attributes.src = self.getUrl("images/spacer.gif");
      }
      if (realElementType) {
        attributes["data-cke-real-element-type"] = realElementType;
      }
      if (dataAndEvents) {
        attributes["data-cke-resizable"] = dataAndEvents;
        var realAttrs = realElement.attributes;
        var fakeStyle = new cssStyle;
        var width = realAttrs.width;
        var height = realAttrs.height;
        if (width != undefined) {
          fakeStyle.rules.width = cssLength(width);
        }
        if (height != undefined) {
          fakeStyle.rules.height = cssLength(height);
        }
        fakeStyle.populate(attributes);
      }
      return new self.htmlParser.element("img", attributes);
    };
    self.editor.prototype.restoreRealElement = function(fakeElement) {
      if (fakeElement.data("cke-real-node-type") != 1) {
        return null;
      }
      var element = Node.createFromHtml(decodeURIComponent(fakeElement.data("cke-realelement")), this.document);
      if (fakeElement.data("cke-resizable")) {
        var width = fakeElement.getStyle("width");
        var height = fakeElement.getStyle("height");
        if (width) {
          element.setAttribute("width", replaceCssLength(element.getAttribute("width"), width));
        }
        if (height) {
          element.setAttribute("height", replaceCssLength(element.getAttribute("height"), height));
        }
      }
      return element;
    };
  })();
  editor.add("richcombo", {
    requires : ["floatpanel", "listblock", "button"],
    beforeInit : function(editor) {
      editor.ui.addHandler("richcombo", options.richCombo.handler);
    }
  });
  self.UI_RICHCOMBO = "richcombo";
  options.richCombo = $.createClass({
    $ : function(name) {
      var that = this;
      $.extend(that, name, {
        title : name.label,
        modes : {
          wysiwyg : 1
        }
      });
      var panelDefinition = that.panel || {};
      delete that.panel;
      that.id = $.getNextNumber();
      that.document = panelDefinition && (panelDefinition.parent && panelDefinition.parent.getDocument()) || self.document;
      panelDefinition.className = (panelDefinition.className || "") + " cke_rcombopanel";
      panelDefinition.block = {
        multiSelect : panelDefinition.multiSelect,
        attributes : panelDefinition.attributes
      };
      that._ = {
        panelDefinition : panelDefinition,
        items : {},
        state : 2
      };
    },
    statics : {
      handler : {
        create : function(definition) {
          return new options.richCombo(definition);
        }
      }
    },
    proto : {
      renderHtml : function(editor) {
        var output = [];
        this.render(editor, output);
        return output.join("");
      },
      render : function(editor, output) {
        function updateState() {
          var me = this;
          var e = me.modes[editor.mode] ? 2 : 0;
          me.setState(editor.readOnly && !me.readOnly ? 0 : e);
          me.setValue("");
        }
        var o = env;
        var id = "cke_" + this.id;
        var clickFn = $.addFunction(function(el) {
          var combo = this;
          var _ = combo._;
          if (_.state == 0) {
            return;
          }
          combo.createPanel(editor);
          if (_.on) {
            _.panel.hide();
            return;
          }
          combo.commit();
          var optgroup = combo.getValue();
          if (optgroup) {
            _.list.mark(optgroup);
          } else {
            _.list.unmarkAll();
          }
          _.panel.showBlock(combo.id, new Node(el), 4);
        }, this);
        var instance = {
          id : id,
          combo : this,
          focus : function() {
            var submenu = self.document.getById(id).getChild(1);
            submenu.focus();
          },
          clickFn : clickFn
        };
        editor.on("mode", updateState, this);
        if (!this.readOnly) {
          editor.on("readOnly", updateState, this);
        }
        var keyDownFn = $.addFunction(function(ev, dataName) {
          ev = new dom.event(ev);
          var keystroke = ev.getKeystroke();
          switch(keystroke) {
            case 13:
            ;
            case 32:
            ;
            case 40:
              $.callFunction(clickFn, dataName);
              break;
            default:
              instance.onkey(instance, keystroke);
          }
          ev.preventDefault();
        });
        var focusFn = $.addFunction(function() {
          if (instance.onfocus) {
            instance.onfocus();
          }
        });
        instance.keyDownFn = keyDownFn;
        output.push('<span class="cke_rcombo" role="presentation">', "<span id=", id);
        if (this.className) {
          output.push(' class="', this.className, ' cke_off"');
        }
        output.push(' role="presentation">', '<span id="' + id + '_label" class=cke_label>', this.label, "</span>", '<a hidefocus=true title="', this.title, '" tabindex="-1"', o.gecko && (o.version >= 10900 && !o.hc) ? "" : " href=\"javascript:void('" + this.label + "')\"", ' role="button" aria-labelledby="', id, '_label" aria-describedby="', id, '_text" aria-haspopup="true"');
        if (env.opera || env.gecko && env.mac) {
          output.push(' onkeypress="return false;"');
        }
        if (env.gecko) {
          output.push(' onblur="this.style.cssText = this.style.cssText;"');
        }
        output.push(' onkeydown="CKEDITOR.tools.callFunction( ', keyDownFn, ', event, this );" onfocus="return CKEDITOR.tools.callFunction(', focusFn, ', event);" ' + (href ? 'onclick="return false;" onmouseup' : "onclick") + '="CKEDITOR.tools.callFunction(', clickFn, ', this); return false;"><span><span id="' + id + '_text" class="cke_text cke_inline_label">' + this.label + "</span>" + "</span>" + "<span class=cke_openbutton><span class=cke_icon>" + (env.hc ? "&#9660;" : env.air ? "&nbsp;" : "") + 
        "</span></span>" + "</a>" + "</span>" + "</span>");
        if (this.onRender) {
          this.onRender();
        }
        return instance;
      },
      createPanel : function(editor) {
        if (this._.panel) {
          return;
        }
        var panelDefinition = this._.panelDefinition;
        var deepDataAndEvents = this._.panelDefinition.block;
        var panelParentElement = panelDefinition.parent || self.document.getBody();
        var panel = new options.floatPanel(editor, panelParentElement, panelDefinition);
        var list = panel.addListBlock(this.id, deepDataAndEvents);
        var optgroup = this;
        panel.onShow = function() {
          if (optgroup.className) {
            this.element.getFirst().addClass(optgroup.className + "_panel");
          }
          optgroup.setState(1);
          list.focus(!optgroup.multiSelect && optgroup.getValue());
          optgroup._.on = 1;
          if (optgroup.onOpen) {
            optgroup.onOpen();
          }
        };
        panel.onHide = function(preventOnClose) {
          if (optgroup.className) {
            this.element.getFirst().removeClass(optgroup.className + "_panel");
          }
          optgroup.setState(optgroup.modes && optgroup.modes[editor.mode] ? 2 : 0);
          optgroup._.on = 0;
          if (!preventOnClose && optgroup.onClose) {
            optgroup.onClose();
          }
        };
        panel.onEscape = function() {
          panel.hide();
        };
        list.onClick = function(pdataOld, k) {
          optgroup.document.getWindow().focus();
          if (optgroup.onClick) {
            optgroup.onClick.call(optgroup, pdataOld, k);
          }
          if (k) {
            optgroup.setValue(pdataOld, optgroup._.items[pdataOld]);
          } else {
            optgroup.setValue("");
          }
          panel.hide(false);
        };
        this._.panel = panel;
        this._.list = list;
        panel.getBlock(this.id).onHide = function() {
          optgroup._.on = 0;
          optgroup.setState(2);
        };
        if (this.init) {
          this.init();
        }
      },
      setValue : function(value, text) {
        var me = this;
        me._.value = value;
        var textElement = me.document.getById("cke_" + me.id + "_text");
        if (textElement) {
          if (!(value || text)) {
            text = me.label;
            textElement.addClass("cke_inline_label");
          } else {
            textElement.removeClass("cke_inline_label");
          }
          textElement.setHtml(typeof text != "undefined" ? text : value);
        }
      },
      getValue : function() {
        return this._.value || "";
      },
      unmarkAll : function() {
        this._.list.unmarkAll();
      },
      mark : function(name) {
        this._.list.mark(name);
      },
      hideItem : function(name) {
        this._.list.hideItem(name);
      },
      hideGroup : function(groupTitle) {
        this._.list.hideGroup(groupTitle);
      },
      showAll : function() {
        this._.list.showAll();
      },
      add : function(name, opt_attributes, type) {
        this._.items[name] = type || name;
        this._.list.add(name, opt_attributes, type);
      },
      startGroup : function(title) {
        this._.list.startGroup(title);
      },
      commit : function() {
        var attributes = this;
        if (!attributes._.committed) {
          attributes._.list.commit();
          attributes._.committed = 1;
          options.fire("ready", attributes);
        }
        attributes._.committed = 1;
      },
      setState : function(state) {
        var me = this;
        if (me._.state == state) {
          return;
        }
        me.document.getById("cke_" + me.id).setState(state);
        me._.state = state;
      }
    }
  });
  options.prototype.addRichCombo = function(optgroup, name) {
    this.add(optgroup, "richcombo", name);
  };
  editor.add("htmlwriter");
  self.htmlWriter = $.createClass({
    base : self.htmlParser.basicWriter,
    $ : function() {
      var self = this;
      self.base();
      self.indentationChars = "\t";
      self.selfClosingEnd = " />";
      self.lineBreakChars = "\n";
      self.forceSimpleAmpersand = 0;
      self.sortAttributes = 1;
      self._.indent = 0;
      self._.indentation = "";
      self._.inPre = 0;
      self._.rules = {};
      var options = dtd;
      var e;
      for (e in $.extend({}, options.$nonBodyContent, options.$block, options.$listItem, options.$tableContent)) {
        self.setRules(e, {
          indent : 1,
          breakBeforeOpen : 1,
          breakAfterOpen : 1,
          breakBeforeClose : !options[e]["#"],
          breakAfterClose : 1
        });
      }
      self.setRules("br", {
        breakAfterOpen : 1
      });
      self.setRules("title", {
        indent : 0,
        breakAfterOpen : 0
      });
      self.setRules("style", {
        indent : 0,
        breakBeforeClose : 1
      });
      self.setRules("pre", {
        indent : 0
      });
    },
    proto : {
      openTag : function(tagName, opt_attributes) {
        var self = this;
        var rules = self._.rules[tagName];
        if (self._.indent) {
          self.indentation();
        } else {
          if (rules && rules.breakBeforeOpen) {
            self.lineBreak();
            self.indentation();
          }
        }
        self._.output.push("<", tagName);
      },
      openTagClose : function(tagName, isSelfClose) {
        var self = this;
        var rules = self._.rules[tagName];
        if (isSelfClose) {
          self._.output.push(self.selfClosingEnd);
        } else {
          self._.output.push(">");
          if (rules && rules.indent) {
            self._.indentation += self.indentationChars;
          }
        }
        if (rules && rules.breakAfterOpen) {
          self.lineBreak();
        }
        if (tagName == "pre") {
          self._.inPre = 1;
        }
      },
      attribute : function(attName, attValue) {
        if (typeof attValue == "string") {
          if (this.forceSimpleAmpersand) {
            attValue = attValue.replace(/&amp;/g, "&");
          }
          attValue = $.htmlEncodeAttr(attValue);
        }
        this._.output.push(" ", attName, '="', attValue, '"');
      },
      closeTag : function(tagName) {
        var self = this;
        var rules = self._.rules[tagName];
        if (rules && rules.indent) {
          self._.indentation = self._.indentation.substr(self.indentationChars.length);
        }
        if (self._.indent) {
          self.indentation();
        } else {
          if (rules && rules.breakBeforeClose) {
            self.lineBreak();
            self.indentation();
          }
        }
        self._.output.push("</", tagName, ">");
        if (tagName == "pre") {
          self._.inPre = 0;
        }
        if (rules && rules.breakAfterClose) {
          self.lineBreak();
        }
      },
      text : function(name) {
        var self = this;
        if (self._.indent) {
          self.indentation();
          if (!self._.inPre) {
            name = $.ltrim(name);
          }
        }
        self._.output.push(name);
      },
      comment : function(comment) {
        if (this._.indent) {
          this.indentation();
        }
        this._.output.push("\x3c!--", comment, "--\x3e");
      },
      lineBreak : function() {
        var self = this;
        if (!self._.inPre && self._.output.length > 0) {
          self._.output.push(self.lineBreakChars);
        }
        self._.indent = 1;
      },
      indentation : function() {
        var self = this;
        if (!self._.inPre) {
          self._.output.push(self._.indentation);
        }
        self._.indent = 0;
      },
      setRules : function(tagName, opt_attributes) {
        var attributes = this._.rules[tagName];
        if (attributes) {
          $.extend(attributes, opt_attributes, true);
        } else {
          this._.rules[tagName] = opt_attributes;
        }
      }
    }
  });
  editor.add("menubutton", {
    requires : ["button", "menu"],
    beforeInit : function(editor) {
      editor.ui.addHandler("menubutton", options.menuButton.handler);
    }
  });
  self.UI_MENUBUTTON = "menubutton";
  (function() {
    var clickFn = function(editor) {
      var _ = this._;
      if (_.state === 0) {
        return;
      }
      _.previousState = _.state;
      var menu = _.menu;
      if (!menu) {
        menu = _.menu = new self.menu(editor, {
          panel : {
            className : editor.skinClass + " cke_contextmenu",
            attributes : {
              "aria-label" : editor.lang.common.options
            }
          }
        });
        menu.onHide = $.bind(function() {
          this.setState(this.modes && this.modes[editor.mode] ? _.previousState : 0);
        }, this);
        if (this.onMenu) {
          menu.addListener(this.onMenu);
        }
      }
      if (_.on) {
        menu.hide();
        return;
      }
      this.setState(1);
      menu.show(self.document.getById(this._.id), 4);
    };
    options.menuButton = $.createClass({
      base : options.button,
      $ : function(name) {
        var panel = name.panel;
        delete name.panel;
        this.base(name);
        this.hasArrow = true;
        this.click = clickFn;
      },
      statics : {
        handler : {
          create : function(definition) {
            return new options.menuButton(definition);
          }
        }
      }
    });
  })();
  editor.add("dialogui");
  (function() {
    var initPrivateObject = function(elementDefinition) {
      var self = this;
      if (!self._) {
        self._ = {};
      }
      self._["default"] = self._.initValue = elementDefinition["default"] || "";
      self._.required = elementDefinition.required || false;
      var callbackArgs = [self._];
      var i = 1;
      for (;i < arguments.length;i++) {
        callbackArgs.push(arguments[i]);
      }
      callbackArgs.push(true);
      $.extend.apply($, callbackArgs);
      return self._;
    };
    var activeClassName = {
      build : function(dialog, elementDefinition, output) {
        return new options.dialog.textInput(dialog, elementDefinition, output);
      }
    };
    var containerBuilder = {
      build : function(dialog, elementDefinition, output) {
        return new options.dialog[elementDefinition.type](dialog, elementDefinition, output);
      }
    };
    var textBuilder = {
      build : function(dialog, elementDefinition, output) {
        var children = elementDefinition.children;
        var child;
        var childHtmlList = [];
        var childObjList = [];
        var i = 0;
        for (;i < children.length && (child = children[i]);i++) {
          var childHtml = [];
          childHtmlList.push(childHtml);
          childObjList.push(self.dialog._.uiElementBuilders[child.type].build(dialog, child, childHtml));
        }
        return new options.dialog[elementDefinition.type](dialog, childObjList, childHtmlList, output, elementDefinition);
      }
    };
    var commonPrototype = {
      isChanged : function() {
        return this.getValue() != this.getInitValue();
      },
      reset : function(value) {
        this.setValue(this.getInitValue(), value);
      },
      setInitValue : function() {
        this._.initValue = this.getValue();
      },
      resetInitValue : function() {
        this._.initValue = this._["default"];
      },
      getInitValue : function() {
        return this._.initValue;
      }
    };
    var commonEventProcessors = $.extend({}, options.dialog.uiElement.prototype.eventProcessors, {
      onChange : function(dialog, callback) {
        if (!this._.domOnChangeRegistered) {
          dialog.on("load", function() {
            this.getInputElement().on("change", function() {
              if (!dialog.parts.dialog.isVisible()) {
                return;
              }
              this.fire("change", {
                value : this.getValue()
              });
            }, this);
          }, this);
          this._.domOnChangeRegistered = true;
        }
        this.on("change", callback);
      }
    }, true);
    var numbers = /^on([A-Z]\w+)/;
    var cleanInnerDefinition = function(def) {
      var i;
      for (i in def) {
        if (numbers.test(i) || (i == "title" || i == "type")) {
          delete def[i];
        }
      }
      return def;
    };
    $.extend(options.dialog, {
      labeledElement : function(pdataOld, pdataCur, o, next_callback) {
        if (arguments.length < 4) {
          return;
        }
        var _ = initPrivateObject.call(this, pdataCur);
        _.labelId = $.getNextId() + "_label";
        var z = this._.children = [];
        var innerHTML = function() {
          var html = [];
          var failureMessage = pdataCur.required ? " cke_required" : "";
          if (pdataCur.labelLayout != "horizontal") {
            html.push('<label class="cke_dialog_ui_labeled_label' + failureMessage + '" ', ' id="' + _.labelId + '"', _.inputId ? ' for="' + _.inputId + '"' : "", (pdataCur.labelStyle ? ' style="' + pdataCur.labelStyle + '"' : "") + ">", pdataCur.label, "</label>", '<div class="cke_dialog_ui_labeled_content"' + (pdataCur.controlStyle ? ' style="' + pdataCur.controlStyle + '"' : "") + ' role="presentation">', next_callback.call(this, pdataOld, pdataCur), "</div>");
          } else {
            var hboxDefinition = {
              type : "hbox",
              widths : pdataCur.widths,
              padding : 0,
              children : [{
                type : "html",
                html : '<label class="cke_dialog_ui_labeled_label' + failureMessage + '"' + ' id="' + _.labelId + '"' + ' for="' + _.inputId + '"' + (pdataCur.labelStyle ? ' style="' + pdataCur.labelStyle + '"' : "") + ">" + $.htmlEncode(pdataCur.label) + "</span>"
              }, {
                type : "html",
                html : '<span class="cke_dialog_ui_labeled_content"' + (pdataCur.controlStyle ? ' style="' + pdataCur.controlStyle + '"' : "") + ">" + next_callback.call(this, pdataOld, pdataCur) + "</span>"
              }]
            };
            self.dialog._.uiElementBuilders.hbox.build(pdataOld, hboxDefinition, html);
          }
          return html.join("");
        };
        options.dialog.uiElement.call(this, pdataOld, pdataCur, o, "div", null, {
          role : "presentation"
        }, innerHTML);
      },
      textInput : function(isXML, pdataCur, o) {
        if (arguments.length < 3) {
          return;
        }
        initPrivateObject.call(this, pdataCur);
        var pageId = this._.inputId = $.getNextId() + "_textInput";
        var attributes = {
          "class" : "cke_dialog_ui_input_" + pdataCur.type,
          id : pageId,
          type : pdataCur.type
        };
        var z;
        if (pdataCur.validate) {
          this.validate = pdataCur.validate;
        }
        if (pdataCur.maxLength) {
          attributes.maxlength = pdataCur.maxLength;
        }
        if (pdataCur.size) {
          attributes.size = pdataCur.size;
        }
        if (pdataCur.inputStyle) {
          attributes.style = pdataCur.inputStyle;
        }
        var innerHTML = function() {
          var tagNameArr = ['<div class="cke_dialog_ui_input_', pdataCur.type, '" role="presentation"'];
          if (pdataCur.width) {
            tagNameArr.push('style="width:' + pdataCur.width + '" ');
          }
          tagNameArr.push("><input ");
          attributes["aria-labelledby"] = this._.labelId;
          if (this._.required) {
            attributes["aria-required"] = this._.required;
          }
          var attr;
          for (attr in attributes) {
            tagNameArr.push(attr + '="' + attributes[attr] + '" ');
          }
          tagNameArr.push(" /></div>");
          return tagNameArr.join("");
        };
        options.dialog.labeledElement.call(this, isXML, pdataCur, o, innerHTML);
      },
      textarea : function(name, value, data) {
        if (arguments.length < 3) {
          return;
        }
        initPrivateObject.call(this, value);
        var me = this;
        var tagName = this._.inputId = $.getNextId() + "_textarea";
        var attributes = {};
        if (value.validate) {
          this.validate = value.validate;
        }
        attributes.rows = value.rows || 5;
        attributes.cols = value.cols || 20;
        if (typeof value.inputStyle != "undefined") {
          attributes.style = value.inputStyle;
        }
        var innerHTML = function() {
          attributes["aria-labelledby"] = this._.labelId;
          if (this._.required) {
            attributes["aria-required"] = this._.required;
          }
          var tagNameArr = ['<div class="cke_dialog_ui_input_textarea" role="presentation"><textarea class="cke_dialog_ui_input_textarea" id="', tagName, '" '];
          var i;
          for (i in attributes) {
            tagNameArr.push(i + '="' + $.htmlEncode(attributes[i]) + '" ');
          }
          tagNameArr.push(">", $.htmlEncode(me._["default"]), "</textarea></div>");
          return tagNameArr.join("");
        };
        options.dialog.labeledElement.call(this, name, value, data, innerHTML);
      },
      checkbox : function(isXML, pdataOld, obj) {
        if (arguments.length < 3) {
          return;
        }
        var _ = initPrivateObject.call(this, pdataOld, {
          "default" : !!pdataOld["default"]
        });
        if (pdataOld.validate) {
          this.validate = pdataOld.validate;
        }
        var innerHTML = function() {
          var myDefinition = $.extend({}, pdataOld, {
            id : pdataOld.id ? pdataOld.id + "_checkbox" : $.getNextId() + "_checkbox"
          }, true);
          var html = [];
          var labelId = $.getNextId() + "_label";
          var attributes = {
            "class" : "cke_dialog_ui_checkbox_input",
            type : "checkbox",
            "aria-labelledby" : labelId
          };
          cleanInnerDefinition(myDefinition);
          if (pdataOld["default"]) {
            attributes.checked = "checked";
          }
          if (typeof myDefinition.inputStyle != "undefined") {
            myDefinition.style = myDefinition.inputStyle;
          }
          _.checkbox = new options.dialog.uiElement(isXML, myDefinition, html, "input", null, attributes);
          html.push(' <label id="', labelId, '" for="', attributes.id, '"' + (pdataOld.labelStyle ? ' style="' + pdataOld.labelStyle + '"' : "") + ">", $.htmlEncode(pdataOld.label), "</label>");
          return html.join("");
        };
        options.dialog.uiElement.call(this, isXML, pdataOld, obj, "span", null, null, innerHTML);
      },
      radio : function(isXML, pdataOld, obj) {
        if (arguments.length < 3) {
          return;
        }
        initPrivateObject.call(this, pdataOld);
        if (!this._["default"]) {
          this._["default"] = this._.initValue = pdataOld.items[0][1];
        }
        if (pdataOld.validate) {
          this.validate = pdataOld.valdiate;
        }
        var children = [];
        var me = this;
        var innerHTML = function() {
          var inputHtmlList = [];
          var html = [];
          var commonAttributes = {
            "class" : "cke_dialog_ui_radio_item",
            "aria-labelledby" : this._.labelId
          };
          var errorName = pdataOld.id ? pdataOld.id + "_radio" : $.getNextId() + "_radio";
          var i = 0;
          for (;i < pdataOld.items.length;i++) {
            var item = pdataOld.items[i];
            var MSG_CLOSURE_CUSTOM_COLOR_BUTTON = item[2] !== undefined ? item[2] : item[0];
            var value = item[1] !== undefined ? item[1] : item[0];
            var inputId = $.getNextId() + "_radio_input";
            var labelId = inputId + "_label";
            var inputDefinition = $.extend({}, pdataOld, {
              id : inputId,
              title : null,
              type : null
            }, true);
            var labelDefinition = $.extend({}, inputDefinition, {
              title : MSG_CLOSURE_CUSTOM_COLOR_BUTTON
            }, true);
            var inputAttributes = {
              type : "radio",
              "class" : "cke_dialog_ui_radio_input",
              name : errorName,
              value : value,
              "aria-labelledby" : labelId
            };
            var inputHtml = [];
            if (me._["default"] == value) {
              inputAttributes.checked = "checked";
            }
            cleanInnerDefinition(inputDefinition);
            cleanInnerDefinition(labelDefinition);
            if (typeof inputDefinition.inputStyle != "undefined") {
              inputDefinition.style = inputDefinition.inputStyle;
            }
            children.push(new options.dialog.uiElement(isXML, inputDefinition, inputHtml, "input", null, inputAttributes));
            inputHtml.push(" ");
            new options.dialog.uiElement(isXML, labelDefinition, inputHtml, "label", null, {
              id : labelId,
              "for" : inputAttributes.id
            }, item[0]);
            inputHtmlList.push(inputHtml.join(""));
          }
          new options.dialog.hbox(isXML, children, inputHtmlList, html);
          return html.join("");
        };
        options.dialog.labeledElement.call(this, isXML, pdataOld, obj, innerHTML);
        this._.children = children;
      },
      button : function(name, value, data) {
        if (!arguments.length) {
          return;
        }
        if (typeof value == "function") {
          value = value(name.getParentEditor());
        }
        initPrivateObject.call(this, value, {
          disabled : value.disabled || false
        });
        self.event.implementOn(this);
        var me = this;
        name.on("load", function(dataAndEvents) {
          var element = this.getElement();
          (function() {
            element.on("click", function(evt) {
              me.fire("click", {
                dialog : me.getDialog()
              });
              evt.data.preventDefault();
            });
            element.on("keydown", function(evt) {
              if (evt.data.getKeystroke() in {
                32 : 1
              }) {
                me.click();
                evt.data.preventDefault();
              }
            });
          })();
          element.unselectable();
        }, this);
        var pdataCur = $.extend({}, value);
        delete pdataCur.style;
        var labelId = $.getNextId() + "_label";
        options.dialog.uiElement.call(this, name, pdataCur, data, "a", null, {
          style : value.style,
          href : "javascript:void(0)",
          title : value.label,
          hidefocus : "true",
          "class" : value["class"],
          role : "button",
          "aria-labelledby" : labelId
        }, '<span id="' + labelId + '" class="cke_dialog_ui_button">' + $.htmlEncode(value.label) + "</span>");
      },
      select : function(pdataOld, pdataCur, obj) {
        if (arguments.length < 3) {
          return;
        }
        var _ = initPrivateObject.call(this, pdataCur);
        if (pdataCur.validate) {
          this.validate = pdataCur.validate;
        }
        _.inputId = $.getNextId() + "_select";
        var innerHTML = function() {
          var myDefinition = $.extend({}, pdataCur, {
            id : pdataCur.id ? pdataCur.id + "_select" : $.getNextId() + "_select"
          }, true);
          var html = [];
          var tagNameArr = [];
          var attributes = {
            id : _.inputId,
            "class" : "cke_dialog_ui_input_select",
            "aria-labelledby" : this._.labelId
          };
          if (pdataCur.size != undefined) {
            attributes.size = pdataCur.size;
          }
          if (pdataCur.multiple != undefined) {
            attributes.multiple = pdataCur.multiple;
          }
          cleanInnerDefinition(myDefinition);
          var i = 0;
          var item;
          for (;i < pdataCur.items.length && (item = pdataCur.items[i]);i++) {
            tagNameArr.push('<option value="', $.htmlEncode(item[1] !== undefined ? item[1] : item[0]).replace(/"/g, "&quot;"), '" /> ', $.htmlEncode(item[0]));
          }
          if (typeof myDefinition.inputStyle != "undefined") {
            myDefinition.style = myDefinition.inputStyle;
          }
          _.select = new options.dialog.uiElement(pdataOld, myDefinition, html, "select", null, attributes, tagNameArr.join(""));
          return html.join("");
        };
        options.dialog.labeledElement.call(this, pdataOld, pdataCur, obj, innerHTML);
      },
      file : function(isXML, pdataCur, o) {
        if (arguments.length < 3) {
          return;
        }
        if (pdataCur["default"] === undefined) {
          pdataCur["default"] = "";
        }
        var _ = $.extend(initPrivateObject.call(this, pdataCur), {
          definition : pdataCur,
          buttons : []
        });
        if (pdataCur.validate) {
          this.validate = pdataCur.validate;
        }
        var innerHTML = function() {
          _.frameId = $.getNextId() + "_fileInput";
          var arrayLike = env.isCustomDomain();
          var tagNameArr = ['<iframe frameborder="0" allowtransparency="0" class="cke_dialog_ui_input_file" role="presentation" id="', _.frameId, '" title="', pdataCur.label, '" src="javascript:void('];
          tagNameArr.push(arrayLike ? "(function(){document.open();document.domain='" + document.domain + "';" + "document.close();" + "})()" : "0");
          tagNameArr.push(')"></iframe>');
          return tagNameArr.join("");
        };
        isXML.on("load", function() {
          var logger2sibling1 = self.document.getById(_.frameId);
          var contentDiv = logger2sibling1.getParent();
          contentDiv.addClass("cke_dialog_ui_input_file");
        });
        options.dialog.labeledElement.call(this, isXML, pdataCur, o, innerHTML);
      },
      fileButton : function(isXML, camelKey, o) {
        if (arguments.length < 3) {
          return;
        }
        var data = initPrivateObject.call(this, camelKey);
        var copies = this;
        if (camelKey.validate) {
          this.validate = camelKey.validate;
        }
        var msgs = $.extend({}, camelKey);
        var onClick = msgs.onClick;
        msgs.className = (msgs.className ? msgs.className + " " : "") + "cke_dialog_ui_button";
        msgs.onClick = function(pdataOld) {
          var targetInput = camelKey["for"];
          if (!onClick || onClick.call(this, pdataOld) !== false) {
            isXML.getContentElement(targetInput[0], targetInput[1]).submit();
            this.disable();
          }
        };
        isXML.on("load", function() {
          isXML.getContentElement(camelKey["for"][0], camelKey["for"][1])._.buttons.push(copies);
        });
        options.dialog.button.call(this, isXML, msgs, o);
      },
      html : function() {
        var delegateEventSplitter = /^\s*<[\w:]+\s+([^>]*)?>/;
        var value = /^(\s*<[\w:]+(?:\s+[^>]*)?)((?:.|\r|\n)+)$/;
        var rsingleTag = /\/$/;
        return function(isXML, msgs, htmlList) {
          if (arguments.length < 3) {
            return;
          }
          var o = [];
          var key;
          var l = msgs.html;
          var segmentMatch;
          var match;
          if (l.charAt(0) != "<") {
            l = "<span>" + l + "</span>";
          }
          var focus = msgs.focus;
          if (focus) {
            var oldFocus = this.focus;
            this.focus = function() {
              oldFocus.call(this);
              if (typeof focus == "function") {
                focus.call(this);
              }
              this.fire("focus");
            };
            if (msgs.isFocusable) {
              var oldIsFocusable = this.isFocusable;
              this.isFocusable = oldIsFocusable;
            }
            this.keyboardFocusable = true;
          }
          options.dialog.uiElement.call(this, isXML, msgs, o, "span", null, null, "");
          key = o.join("");
          segmentMatch = key.match(delegateEventSplitter);
          match = l.match(value) || ["", "", ""];
          if (rsingleTag.test(match[1])) {
            match[1] = match[1].slice(0, -1);
            match[2] = "/" + match[2];
          }
          htmlList.push([match[1], " ", segmentMatch[1] || "", match[2]].join(""));
        };
      }(),
      fieldset : function(isXML, childObjList, childHtmlList, o, msgs) {
        var l = msgs.label;
        var innerHTML = function() {
          var html = [];
          if (l) {
            html.push("<legend" + (msgs.labelStyle ? ' style="' + msgs.labelStyle + '"' : "") + ">" + l + "</legend>");
          }
          var i = 0;
          for (;i < childHtmlList.length;i++) {
            html.push(childHtmlList[i]);
          }
          return html.join("");
        };
        this._ = {
          children : childObjList
        };
        options.dialog.uiElement.call(this, isXML, msgs, o, "fieldset", null, null, innerHTML);
      }
    }, true);
    options.dialog.html.prototype = new options.dialog.uiElement;
    options.dialog.labeledElement.prototype = $.extend(new options.dialog.uiElement, {
      setLabel : function(label) {
        var container = self.document.getById(this._.labelId);
        if (container.getChildCount() < 1) {
          (new dom.text(label, self.document)).appendTo(container);
        } else {
          container.getChild(0).$.nodeValue = label;
        }
        return this;
      },
      getLabel : function() {
        var node = self.document.getById(this._.labelId);
        if (!node || node.getChildCount() < 1) {
          return "";
        } else {
          return node.getChild(0).getText();
        }
      },
      eventProcessors : commonEventProcessors
    }, true);
    options.dialog.button.prototype = $.extend(new options.dialog.uiElement, {
      click : function() {
        var me = this;
        if (!me._.disabled) {
          return me.fire("click", {
            dialog : me._.dialog
          });
        }
        me.getElement().$.blur();
        return false;
      },
      enable : function() {
        this._.disabled = false;
        var element = this.getElement();
        if (element) {
          element.removeClass("cke_disabled");
        }
      },
      disable : function() {
        this._.disabled = true;
        this.getElement().addClass("cke_disabled");
      },
      isVisible : function() {
        return this.getElement().getFirst().isVisible();
      },
      isEnabled : function() {
        return!this._.disabled;
      },
      eventProcessors : $.extend({}, options.dialog.uiElement.prototype.eventProcessors, {
        onClick : function(name, matcherFunction) {
          this.on("click", function() {
            this.getElement().focus();
            matcherFunction.apply(this, arguments);
          });
        }
      }, true),
      accessKeyUp : function() {
        this.click();
      },
      accessKeyDown : function() {
        this.focus();
      },
      keyboardFocusable : true
    }, true);
    options.dialog.textInput.prototype = $.extend(new options.dialog.labeledElement, {
      getInputElement : function() {
        return self.document.getById(this._.inputId);
      },
      focus : function() {
        var me = this.selectParentTab();
        setTimeout(function() {
          var el = me.getInputElement();
          if (el) {
            el.$.focus();
          }
        }, 0);
      },
      select : function() {
        var me = this.selectParentTab();
        setTimeout(function() {
          var element = me.getInputElement();
          if (element) {
            element.$.focus();
            element.$.select();
          }
        }, 0);
      },
      accessKeyUp : function() {
        this.select();
      },
      setValue : function(value) {
        if (!value) {
          value = "";
        }
        return options.dialog.uiElement.prototype.setValue.apply(this, arguments);
      },
      keyboardFocusable : true
    }, commonPrototype, true);
    options.dialog.textarea.prototype = new options.dialog.textInput;
    options.dialog.select.prototype = $.extend(new options.dialog.labeledElement, {
      getInputElement : function() {
        return this._.select.getElement();
      },
      add : function(name, opt_attributes, attributes) {
        var option = new Node("option", this.getDialog().getParentEditor().document);
        var selectElement = this.getInputElement().$;
        option.$.text = name;
        option.$.value = opt_attributes === undefined || opt_attributes === null ? name : opt_attributes;
        if (attributes === undefined || attributes === null) {
          if (href) {
            selectElement.add(option.$);
          } else {
            selectElement.add(option.$, null);
          }
        } else {
          selectElement.add(option.$, attributes);
        }
        return this;
      },
      remove : function(name) {
        var selectElement = this.getInputElement().$;
        selectElement.remove(name);
        return this;
      },
      clear : function() {
        var selectElement = this.getInputElement().$;
        for (;selectElement.length > 0;) {
          selectElement.remove(0);
        }
        return this;
      },
      keyboardFocusable : true
    }, commonPrototype, true);
    options.dialog.checkbox.prototype = $.extend(new options.dialog.uiElement, {
      getInputElement : function() {
        return this._.checkbox.getElement();
      },
      setValue : function(value, aValue) {
        this.getInputElement().$.checked = value;
        if (!aValue) {
          this.fire("change", {
            value : value
          });
        }
      },
      getValue : function() {
        return this.getInputElement().$.checked;
      },
      accessKeyUp : function() {
        this.setValue(!this.getValue());
      },
      eventProcessors : {
        onChange : function(dialog, callback) {
          if (!href) {
            return commonEventProcessors.onChange.apply(this, arguments);
          } else {
            dialog.on("load", function() {
              var element = this._.checkbox.getElement();
              element.on("propertychange", function(evt) {
                evt = evt.data.$;
                if (evt.propertyName == "checked") {
                  this.fire("change", {
                    value : element.$.checked
                  });
                }
              }, this);
            }, this);
            this.on("change", callback);
          }
          return null;
        }
      },
      keyboardFocusable : true
    }, commonPrototype, true);
    options.dialog.radio.prototype = $.extend(new options.dialog.uiElement, {
      setValue : function(value, aValue) {
        var items = this._.children;
        var item;
        var i = 0;
        for (;i < items.length && (item = items[i]);i++) {
          item.getElement().$.checked = item.getValue() == value;
        }
        if (!aValue) {
          this.fire("change", {
            value : value
          });
        }
      },
      getValue : function() {
        var children = this._.children;
        var i = 0;
        for (;i < children.length;i++) {
          if (children[i].getElement().$.checked) {
            return children[i].getValue();
          }
        }
        return null;
      },
      accessKeyUp : function() {
        var children = this._.children;
        var i;
        i = 0;
        for (;i < children.length;i++) {
          if (children[i].getElement().$.checked) {
            children[i].getElement().focus();
            return;
          }
        }
        children[0].getElement().focus();
      },
      eventProcessors : {
        onChange : function(dialog, callback) {
          if (!href) {
            return commonEventProcessors.onChange.apply(this, arguments);
          } else {
            dialog.on("load", function() {
              var children = this._.children;
              var me = this;
              var i = 0;
              for (;i < children.length;i++) {
                var element = children[i].getElement();
                element.on("propertychange", function(evt) {
                  evt = evt.data.$;
                  if (evt.propertyName == "checked" && this.$.checked) {
                    me.fire("change", {
                      value : this.getAttribute("value")
                    });
                  }
                });
              }
            }, this);
            this.on("change", callback);
          }
          return null;
        }
      },
      keyboardFocusable : true
    }, commonPrototype, true);
    options.dialog.file.prototype = $.extend(new options.dialog.labeledElement, commonPrototype, {
      getInputElement : function() {
        var frameDocument = self.document.getById(this._.frameId).getFrameDocument();
        return frameDocument.$.forms.length > 0 ? new Node(frameDocument.$.forms[0].elements[0]) : this.getElement();
      },
      submit : function() {
        this.getInputElement().getParent().$.submit();
        return this;
      },
      getAction : function() {
        return this.getInputElement().getParent().$.action;
      },
      registerEvents : function(definition) {
        var delegateEventSplitter = /^on([A-Z]\w+)/;
        var match;
        var registerDomEvent = function(uiElement, dialog, eventName, func) {
          uiElement.on("formLoaded", function() {
            uiElement.getInputElement().on(eventName, func, uiElement);
          });
        };
        var key;
        for (key in definition) {
          if (!(match = key.match(delegateEventSplitter))) {
            continue;
          }
          if (this.eventProcessors[key]) {
            this.eventProcessors[key].call(this, this._.dialog, definition[key]);
          } else {
            registerDomEvent(this, this._.dialog, match[1].toLowerCase(), definition[key]);
          }
        }
        return this;
      },
      reset : function() {
        function generateFormField() {
          frameDocument.$.open();
          if (env.isCustomDomain()) {
            frameDocument.$.domain = document.domain;
          }
          var size = "";
          if (elementDefinition.size) {
            size = elementDefinition.size - (href ? 7 : 0);
          }
          var inputId = _.frameId + "_input";
          frameDocument.$.write(['<html dir="' + langDir + '" lang="' + langCode + '"><head><title></title></head><body style="margin: 0; overflow: hidden; background: transparent;">', '<form enctype="multipart/form-data" method="POST" dir="' + langDir + '" lang="' + langCode + '" action="', $.htmlEncode(elementDefinition.action), '">', '<label id="', _.labelId, '" for="', inputId, '" style="display:none">', $.htmlEncode(elementDefinition.label), "</label>", '<input id="', inputId, '" aria-labelledby="', 
          _.labelId, '" type="file" name="', $.htmlEncode(elementDefinition.id || "cke_upload"), '" size="', $.htmlEncode(size > 0 ? size : ""), '" />', "</form>", "</body></html>", "<script>window.parent.CKEDITOR.tools.callFunction(" + callNumber + ");", "window.onbeforeunload = function() {window.parent.CKEDITOR.tools.callFunction(" + unloadNumber + ")}\x3c/script>"].join(""));
          frameDocument.$.close();
          var i = 0;
          for (;i < buttons.length;i++) {
            buttons[i].enable();
          }
        }
        var _ = this._;
        var frameElement = self.document.getById(_.frameId);
        var frameDocument = frameElement.getFrameDocument();
        var elementDefinition = _.definition;
        var buttons = _.buttons;
        var callNumber = this.formLoadedNumber;
        var unloadNumber = this.formUnloadNumber;
        var langDir = _.dialog._.editor.lang.dir;
        var langCode = _.dialog._.editor.langCode;
        if (!callNumber) {
          callNumber = this.formLoadedNumber = $.addFunction(function() {
            this.fire("formLoaded");
          }, this);
          unloadNumber = this.formUnloadNumber = $.addFunction(function() {
            this.getInputElement().clearCustomData();
          }, this);
          this.getDialog()._.editor.on("destroy", function() {
            $.removeFunction(callNumber);
            $.removeFunction(unloadNumber);
          });
        }
        if (env.gecko) {
          setTimeout(generateFormField, 500);
        } else {
          generateFormField();
        }
      },
      getValue : function() {
        return this.getInputElement().$.value || "";
      },
      setInitValue : function() {
        this._.initValue = "";
      },
      eventProcessors : {
        onChange : function(thumb, callback) {
          if (!this._.domOnChangeRegistered) {
            this.on("formLoaded", function() {
              this.getInputElement().on("change", function() {
                this.fire("change", {
                  value : this.getValue()
                });
              }, this);
            }, this);
            this._.domOnChangeRegistered = true;
          }
          this.on("change", callback);
        }
      },
      keyboardFocusable : true
    }, true);
    options.dialog.fileButton.prototype = new options.dialog.button;
    options.dialog.fieldset.prototype = $.clone(options.dialog.hbox.prototype);
    self.dialog.addUIElement("text", activeClassName);
    self.dialog.addUIElement("password", activeClassName);
    self.dialog.addUIElement("textarea", containerBuilder);
    self.dialog.addUIElement("checkbox", containerBuilder);
    self.dialog.addUIElement("radio", containerBuilder);
    self.dialog.addUIElement("button", containerBuilder);
    self.dialog.addUIElement("select", containerBuilder);
    self.dialog.addUIElement("file", containerBuilder);
    self.dialog.addUIElement("fileButton", containerBuilder);
    self.dialog.addUIElement("html", containerBuilder);
    self.dialog.addUIElement("fieldset", textBuilder);
  })();
  editor.add("panel", {
    beforeInit : function(editor) {
      editor.ui.addHandler("panel", options.panel.handler);
    }
  });
  self.UI_PANEL = "panel";
  options.panel = function(name, value) {
    var that = this;
    if (value) {
      $.extend(that, value);
    }
    $.extend(that, {
      className : "",
      css : []
    });
    that.id = $.getNextId();
    that.document = name;
    that._ = {
      blocks : {}
    };
  };
  options.panel.handler = {
    create : function(definition) {
      return new options.panel(definition);
    }
  };
  options.panel.prototype = {
    renderHtml : function(editor) {
      var output = [];
      this.render(editor, output);
      return output.join("");
    },
    render : function(editor, output) {
      var node = this;
      var id = node.id;
      output.push('<div class="', editor.skinClass, '" lang="', editor.langCode, '" role="presentation" style="display:none;z-index:' + (editor.config.baseFloatZIndex + 1) + '">' + "<div" + " id=", id, " dir=", editor.lang.dir, ' role="presentation" class="cke_panel cke_', editor.lang.dir);
      if (node.className) {
        output.push(" ", node.className);
      }
      output.push('">');
      if (node.forceIFrame || node.css.length) {
        output.push('<iframe id="', id, '_frame" frameborder="0" role="application" src="javascript:void(');
        output.push(env.isCustomDomain() ? "(function(){document.open();document.domain='" + document.domain + "';" + "document.close();" + "})()" : "0");
        output.push(')"></iframe>');
      }
      output.push("</div></div>");
      return id;
    },
    getHolderElement : function() {
      var holder = this._.holder;
      if (!holder) {
        if (this.forceIFrame || this.css.length) {
          var iframe = this.document.getById(this.id + "_frame");
          var parentDiv = iframe.getParent();
          var baseDir = parentDiv.getAttribute("dir");
          var classes = parentDiv.getParent().getAttribute("class");
          var langCode = parentDiv.getParent().getAttribute("lang");
          var doc = iframe.getFrameDocument();
          if (env.iOS) {
            parentDiv.setStyles({
              overflow : "scroll",
              "-webkit-overflow-scrolling" : "touch"
            });
          }
          var optgroup = $.addFunction($.bind(function(dataAndEvents) {
            this.isLoaded = true;
            if (this.onLoad) {
              this.onLoad();
            }
          }, this));
          var html = '<!DOCTYPE html><html dir="' + baseDir + '" class="' + classes + '_container" lang="' + langCode + '">' + "<head>" + "<style>." + classes + "_container{visibility:hidden}</style>" + $.buildStyleHtml(this.css) + "</head>" + '<body class="cke_' + baseDir + " cke_panel_frame " + env.cssClass + '" style="margin:0;padding:0"' + ' onload="( window.CKEDITOR || window.parent.CKEDITOR ).tools.callFunction(' + optgroup + ');"></body>' + "</html>";
          doc.write(html);
          var win = doc.getWindow();
          win.$.CKEDITOR = self;
          doc.on("key" + (env.opera ? "press" : "down"), function(evt) {
            var self = this;
            var keyCode = evt.data.getKeystroke();
            var dir = self.document.getById(self.id).getAttribute("dir");
            if (self._.onKeyDown && self._.onKeyDown(keyCode) === false) {
              evt.data.preventDefault();
              return;
            }
            if (keyCode == 27 || keyCode == (dir == "rtl" ? 39 : 37)) {
              if (self.onEscape && self.onEscape(keyCode) === false) {
                evt.data.preventDefault();
              }
            }
          }, this);
          holder = doc.getBody();
          holder.unselectable();
          if (env.air) {
            $.callFunction(optgroup);
          }
        } else {
          holder = this.document.getById(this.id);
        }
        this._.holder = holder;
      }
      return holder;
    },
    addBlock : function(name, block) {
      var panel = this;
      block = panel._.blocks[name] = block instanceof options.panel.block ? block : new options.panel.block(panel.getHolderElement(), block);
      if (!panel._.currentBlock) {
        panel.showBlock(name);
      }
      return block;
    },
    getBlock : function(name) {
      return this._.blocks[name];
    },
    showBlock : function(name) {
      var panel = this;
      var blocks = panel._.blocks;
      var block = blocks[name];
      var current = panel._.currentBlock;
      var holder = !panel.forceIFrame || href ? panel._.holder : panel.document.getById(panel.id + "_frame");
      if (current) {
        holder.removeAttributes(current.attributes);
        current.hide();
      }
      panel._.currentBlock = block;
      holder.setAttributes(block.attributes);
      self.fire("ariaWidget", holder);
      block._.focusIndex = -1;
      panel._.onKeyDown = block.onKeyDown && $.bind(block.onKeyDown, block);
      block.show();
      return block;
    },
    destroy : function() {
      if (this.element) {
        this.element.remove();
      }
    }
  };
  options.panel.block = $.createClass({
    $ : function(name, value) {
      var self = this;
      self.element = name.append(name.getDocument().createElement("div", {
        attributes : {
          tabIndex : -1,
          "class" : "cke_panel_block",
          role : "presentation"
        },
        styles : {
          display : "none"
        }
      }));
      if (value) {
        $.extend(self, value);
      }
      if (!self.attributes.title) {
        self.attributes.title = self.attributes["aria-label"];
      }
      self.keys = {};
      self._.focusIndex = -1;
      self.element.disableContextMenu();
    },
    _ : {
      markItem : function(index) {
        var block = this;
        if (index == -1) {
          return;
        }
        var links = block.element.getElementsByTag("a");
        var context = links.getItem(block._.focusIndex = index);
        if (env.webkit || env.opera) {
          context.getDocument().getWindow().focus();
        }
        context.focus();
        if (block.onMark) {
          block.onMark(context);
        }
      }
    },
    proto : {
      show : function() {
        this.element.setStyle("display", "");
      },
      hide : function() {
        var optgroup = this;
        if (!optgroup.onHide || optgroup.onHide.call(optgroup) !== true) {
          optgroup.element.setStyle("display", "none");
        }
      },
      onKeyDown : function(keyCode) {
        var block = this;
        var keyAction = block.keys[keyCode];
        switch(keyAction) {
          case "next":
            var index = block._.focusIndex;
            var links = block.element.getElementsByTag("a");
            var link;
            for (;link = links.getItem(++index);) {
              if (link.getAttribute("_cke_focus") && link.$.offsetWidth) {
                block._.focusIndex = index;
                link.focus();
                break;
              }
            }
            return false;
          case "prev":
            index = block._.focusIndex;
            links = block.element.getElementsByTag("a");
            for (;index > 0 && (link = links.getItem(--index));) {
              if (link.getAttribute("_cke_focus") && link.$.offsetWidth) {
                block._.focusIndex = index;
                link.focus();
                break;
              }
            }
            return false;
          case "click":
          ;
          case "mouseup":
            index = block._.focusIndex;
            link = index >= 0 && block.element.getElementsByTag("a").getItem(index);
            if (link) {
              if (link.$[keyAction]) {
                link.$[keyAction]();
              } else {
                link.$["on" + keyAction]();
              }
            }
            return false;
        }
        return true;
      }
    }
  });
  editor.add("listblock", {
    requires : ["panel"],
    onLoad : function() {
      options.panel.prototype.addListBlock = function(name, deepDataAndEvents) {
        return this.addBlock(name, new options.listBlock(this.getHolderElement(), deepDataAndEvents));
      };
      options.listBlock = $.createClass({
        base : options.panel.block,
        $ : function(name, value) {
          var me = this;
          value = value || {};
          var attribs = value.attributes || (value.attributes = {});
          if (me.multiSelect = !!value.multiSelect) {
            attribs["aria-multiselectable"] = true;
          }
          if (!attribs.role) {
            attribs.role = "listbox";
          }
          me.base.apply(me, arguments);
          var keys = me.keys;
          keys[40] = "next";
          keys[9] = "next";
          keys[38] = "prev";
          keys[2228224 + 9] = "prev";
          keys[32] = href ? "mouseup" : "click";
          if (href) {
            keys[13] = "mouseup";
          }
          me._.pendingHtml = [];
          me._.items = {};
          me._.groups = {};
        },
        _ : {
          close : function() {
            if (this._.started) {
              this._.pendingHtml.push("</ul>");
              delete this._.started;
            }
          },
          getClick : function() {
            if (!this._.click) {
              this._.click = $.addFunction(function(optgroup) {
                var self = this;
                var e = true;
                if (self.multiSelect) {
                  e = self.toggle(optgroup);
                } else {
                  self.mark(optgroup);
                }
                if (self.onClick) {
                  self.onClick(optgroup, e);
                }
              }, this);
            }
            return this._.click;
          }
        },
        proto : {
          add : function(name, opt_attributes, type) {
            var me = this;
            var pendingHtml = me._.pendingHtml;
            var id = $.getNextId();
            if (!me._.started) {
              pendingHtml.push('<ul role="presentation" class=cke_panel_list>');
              me._.started = 1;
              me._.size = me._.size || 0;
            }
            me._.items[name] = id;
            pendingHtml.push("<li id=", id, ' class=cke_panel_listItem role=presentation><a id="', id, '_option" _cke_focus=1 hidefocus=true title="', type || name, '" href="javascript:void(\'', name, "')\" " + (href ? 'onclick="return false;" onmouseup' : "onclick") + '="CKEDITOR.tools.callFunction(', me._.getClick(), ",'", name, "'); return false;\"", ' role="option">', opt_attributes || name, "</a></li>");
          },
          startGroup : function(title) {
            this._.close();
            var updateLine = $.getNextId();
            this._.groups[title] = updateLine;
            this._.pendingHtml.push('<h1 role="presentation" id=', updateLine, " class=cke_panel_grouptitle>", title, "</h1>");
          },
          commit : function() {
            var that = this;
            that._.close();
            that.element.appendHtml(that._.pendingHtml.join(""));
            delete that._.size;
            that._.pendingHtml = [];
          },
          toggle : function(optgroup) {
            var isMarked = this.isMarked(optgroup);
            if (isMarked) {
              this.unmark(optgroup);
            } else {
              this.mark(optgroup);
            }
            return!isMarked;
          },
          hideGroup : function(groupTitle) {
            var group = this.element.getDocument().getById(this._.groups[groupTitle]);
            var list = group && group.getNext();
            if (group) {
              group.setStyle("display", "none");
              if (list && list.getName() == "ul") {
                list.setStyle("display", "none");
              }
            }
          },
          hideItem : function(name) {
            this.element.getDocument().getById(this._.items[name]).setStyle("display", "none");
          },
          showAll : function() {
            var items = this._.items;
            var groups = this._.groups;
            var doc = this.element.getDocument();
            var value;
            for (value in items) {
              doc.getById(items[value]).setStyle("display", "");
            }
            var title;
            for (title in groups) {
              var group = doc.getById(groups[title]);
              var list = group.getNext();
              group.setStyle("display", "");
              if (list && list.getName() == "ul") {
                list.setStyle("display", "");
              }
            }
          },
          mark : function(name) {
            var editor = this;
            if (!editor.multiSelect) {
              editor.unmarkAll();
            }
            var itemId = editor._.items[name];
            var item = editor.element.getDocument().getById(itemId);
            item.addClass("cke_selected");
            editor.element.getDocument().getById(itemId + "_option").setAttribute("aria-selected", true);
            if (editor.onMark) {
              editor.onMark(item);
            }
          },
          unmark : function(value) {
            var editor = this;
            var doc = editor.element.getDocument();
            var itemId = editor._.items[value];
            var item = doc.getById(itemId);
            item.removeClass("cke_selected");
            doc.getById(itemId + "_option").removeAttribute("aria-selected");
            if (editor.onUnmark) {
              editor.onUnmark(item);
            }
          },
          unmarkAll : function() {
            var editor = this;
            var map = editor._.items;
            var doc = editor.element.getDocument();
            var letter;
            for (letter in map) {
              var itemId = map[letter];
              doc.getById(itemId).removeClass("cke_selected");
              doc.getById(itemId + "_option").removeAttribute("aria-selected");
            }
            if (editor.onUnmark) {
              editor.onUnmark();
            }
          },
          isMarked : function(value) {
            return this.element.getDocument().getById(this._.items[value]).hasClass("cke_selected");
          },
          focus : function(value) {
            this._.focusIndex = -1;
            if (value) {
              var name = this.element.getDocument().getById(this._.items[value]).getFirst();
              var links = this.element.getElementsByTag("a");
              var frame;
              var i = -1;
              for (;frame = links.getItem(++i);) {
                if (frame.equals(name)) {
                  this._.focusIndex = i;
                  break;
                }
              }
              setTimeout(function() {
                name.focus();
              }, 0);
            }
          }
        }
      });
    }
  });
  self.themes.add("default", function() {
    function checkSharedSpace(editor, spaceName) {
      var container;
      var element;
      element = editor.config.sharedSpaces;
      element = element && element[spaceName];
      element = element && self.document.getById(element);
      if (element) {
        var html = '<span class="cke_shared " dir="' + editor.lang.dir + '"' + ">" + '<span class="' + editor.skinClass + " " + editor.id + " cke_editor_" + editor.name + '">' + '<span class="' + env.cssClass + '">' + '<span class="cke_wrapper cke_' + editor.lang.dir + '">' + '<span class="cke_editor">' + '<div class="cke_' + spaceName + '">' + "</div></span></span></span></span></span>";
        var node = element.append(Node.createFromHtml(html, element.getDocument()));
        if (element.getCustomData("cke_hasshared")) {
          node.hide();
        } else {
          element.setCustomData("cke_hasshared", 1);
        }
        container = node.getChild([0, 0, 0, 0]);
        if (!editor.sharedSpaces) {
          editor.sharedSpaces = {};
        }
        editor.sharedSpaces[spaceName] = container;
        editor.on("focus", function() {
          var i = 0;
          var sibling;
          var trs = element.getChildren();
          for (;sibling = trs.getItem(i);i++) {
            if (sibling.type == 1 && (!sibling.equals(node) && sibling.hasClass("cke_shared"))) {
              sibling.hide();
            }
          }
          node.show();
        });
        editor.on("destroy", function() {
          node.remove();
        });
      }
      return container;
    }
    var hiddenSkins = {};
    return{
      build : function(editor, elementDefinition) {
        var name = editor.name;
        var optgroup = editor.element;
        var elementMode = editor.elementMode;
        if (!optgroup || elementMode == 0) {
          return;
        }
        if (elementMode == 1) {
          optgroup.hide();
        }
        var topHtml = editor.fire("themeSpace", {
          space : "top",
          html : ""
        }).html;
        var s = editor.fire("themeSpace", {
          space : "contents",
          html : ""
        }).html;
        var bottomHtml = editor.fireOnce("themeSpace", {
          space : "bottom",
          html : ""
        }).html;
        var y = s && editor.config.height;
        var x = editor.config.tabIndex || (editor.element.getAttribute("tabindex") || 0);
        if (!s) {
          y = "auto";
        } else {
          if (!isNaN(y)) {
            y += "px";
          }
        }
        var charset = "";
        var width = editor.config.width;
        if (width) {
          if (!isNaN(width)) {
            width += "px";
          }
          charset += "width: " + width + ";";
        }
        var sharedTop = topHtml && checkSharedSpace(editor, "top");
        var sharedBottoms = checkSharedSpace(editor, "bottom");
        if (sharedTop) {
          sharedTop.setHtml(topHtml);
          topHtml = "";
        }
        if (sharedBottoms) {
          sharedBottoms.setHtml(bottomHtml);
          bottomHtml = "";
        }
        var expires = "<style>." + editor.skinClass + "{visibility:hidden;}</style>";
        if (hiddenSkins[editor.skinClass]) {
          expires = "";
        } else {
          hiddenSkins[editor.skinClass] = 1;
        }
        var element = Node.createFromHtml(['<span id="cke_', name, '" class="', editor.skinClass, " ", editor.id, " cke_editor_", name, '" dir="', editor.lang.dir, '" title="', env.gecko ? " " : "", '" lang="', editor.langCode, '"' + (env.webkit ? ' tabindex="' + x + '"' : "") + ' role="application"' + ' aria-labelledby="cke_', name, '_arialbl"' + (charset ? ' style="' + charset + '"' : "") + ">" + '<span id="cke_', name, '_arialbl" class="cke_voice_label">' + editor.lang.editor + "</span>" + '<span class="', 
        env.cssClass, '" role="presentation"><span class="cke_wrapper cke_', editor.lang.dir, '" role="presentation"><table class="cke_editor" border="0" cellspacing="0" cellpadding="0" role="presentation"><tbody><tr', topHtml ? "" : ' style="display:none"', ' role="presentation"><td id="cke_top_', name, '" class="cke_top" role="presentation">', topHtml, "</td></tr><tr", s ? "" : ' style="display:none"', ' role="presentation"><td id="cke_contents_', name, '" class="cke_contents" style="height:', 
        y, '" role="presentation">', s, "</td></tr><tr", bottomHtml ? "" : ' style="display:none"', ' role="presentation"><td id="cke_bottom_', name, '" class="cke_bottom" role="presentation">', bottomHtml, "</td></tr></tbody></table>" + expires + "</span>" + "</span>" + "</span>"].join(""));
        element.getChild([1, 0, 0, 0, 0]).unselectable();
        element.getChild([1, 0, 0, 0, 2]).unselectable();
        if (elementMode == 1) {
          element.insertAfter(optgroup);
        } else {
          optgroup.append(element);
        }
        editor.container = element;
        element.disableContextMenu();
        editor.on("contentDirChanged", function(evt) {
          var func = (editor.lang.dir != evt.data ? "add" : "remove") + "Class";
          element.getChild(1)[func]("cke_mixed_dir_content");
          var toolbarSpace = this.sharedSpaces && this.sharedSpaces[this.config.toolbarLocation];
          if (toolbarSpace) {
            toolbarSpace.getParent().getParent()[func]("cke_mixed_dir_content");
          }
        });
        editor.fireOnce("themeLoaded");
        editor.fireOnce("uiReady");
      },
      buildDialog : function(editor) {
        var baseIdNumber = $.getNextNumber();
        var target = Node.createFromHtml(['<div class="', editor.id, "_dialog cke_editor_", editor.name.replace(".", "\\."), "_dialog cke_skin_", editor.skinName, '" dir="', editor.lang.dir, '" lang="', editor.langCode, '" role="dialog" aria-labelledby="%title#"><table class="cke_dialog', " " + env.cssClass, " cke_", editor.lang.dir, '" style="position:absolute" role="presentation"><tr><td role="presentation"><div class="%body" role="presentation"><div id="%title#" class="%title" role="presentation"></div><a id="%close_button#" class="%close_button" href="javascript:void(0)" title="' + 
        editor.lang.common.close + '" role="button"><span class="cke_label">X</span></a>' + '<div id="%tabs#" class="%tabs" role="tablist"></div>' + '<table class="%contents" role="presentation">' + "<tr>" + '<td id="%contents#" class="%contents" role="presentation"></td>' + "</tr>" + "<tr>" + '<td id="%footer#" class="%footer" role="presentation"></td>' + "</tr>" + "</table>" + "</div>" + '<div id="%tl#" class="%tl"></div>' + '<div id="%tc#" class="%tc"></div>' + '<div id="%tr#" class="%tr"></div>' + 
        '<div id="%ml#" class="%ml"></div>' + '<div id="%mr#" class="%mr"></div>' + '<div id="%bl#" class="%bl"></div>' + '<div id="%bc#" class="%bc"></div>' + '<div id="%br#" class="%br"></div>' + "</td></tr>" + "</table>", href ? "" : "<style>.cke_dialog{visibility:hidden;}</style>", "</div>"].join("").replace(/#/g, "_" + baseIdNumber).replace(/%/g, "cke_dialog_"));
        var body = target.getChild([0, 0, 0, 0, 0]);
        var title = body.getChild(0);
        var close = body.getChild(1);
        if (href && !env.ie6Compat) {
          var charset = env.isCustomDomain();
          var v = "javascript:void(function(){" + encodeURIComponent("document.open();" + (charset ? 'document.domain="' + document.domain + '";' : "") + "document.close();") + "}())";
          var clone = Node.createFromHtml('<iframe frameBorder="0" class="cke_iframe_shim" src="' + v + '"' + ' tabIndex="-1"' + "></iframe>");
          clone.appendTo(body.getParent());
        }
        title.unselectable();
        close.unselectable();
        return{
          element : target,
          parts : {
            dialog : target.getChild(0),
            title : title,
            close : close,
            tabs : body.getChild(2),
            contents : body.getChild([3, 0, 0, 0]),
            footer : body.getChild([3, 0, 1, 0])
          }
        };
      },
      destroy : function(self) {
        var container = self.container;
        var iframe = self.element;
        if (container) {
          container.clearCustomData();
          container.remove();
        }
        if (iframe) {
          iframe.clearCustomData();
          if (self.elementMode == 1) {
            iframe.show();
          }
          delete self.element;
        }
      }
    };
  }());
  self.editor.prototype.getThemeSpace = function(spaceName) {
    var spacePrefix = "cke_" + spaceName;
    var space = this._[spacePrefix] || (this._[spacePrefix] = self.document.getById(spacePrefix + "_" + this.name));
    return space;
  };
  self.editor.prototype.resize = function(name, value, data, label) {
    var me = this;
    var container = me.container;
    var contents = self.document.getById("cke_contents_" + me.name);
    var marginDiv = env.webkit && (me.document && me.document.getWindow().$.frameElement);
    var outer = label ? container.getChild(1) : container;
    outer.setSize("width", name, true);
    if (marginDiv) {
      marginDiv.style.width = "1%";
    }
    var delta = data ? 0 : (outer.$.offsetHeight || 0) - (contents.$.clientHeight || 0);
    contents.setStyle("height", Math.max(value - delta, 0) + "px");
    if (marginDiv) {
      marginDiv.style.width = "100%";
    }
    me.fire("resize");
  };
  self.editor.prototype.getResizable = function(forContents) {
    return forContents ? self.document.getById("cke_contents_" + this.name) : this.container;
  };
})();