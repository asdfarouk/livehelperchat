<?php include(erLhcoreClassDesign::designtpl('lhchat/getstatus/is_online_help.tpl.php')); ?>

<?php

// Perhaps user does not want to show live help when it's offline
if ( !($isOnlineHelp == false && $hide_offline == 'true') ) : ?>

/*! Cookies.js - 0.4.0; Copyright (c) 2014, Scott Hamper; http://www.opensource.org/licenses/MIT */
(function(e){"use strict";var b=function(a,d,c){return 1===arguments.length?b.get(a):b.set(a,d,c)};b._document=document;b._navigator=navigator;b.defaults={path:"/"};b.get=function(a){b._cachedDocumentCookie!==b._document.cookie&&b._renewCache();return b._cache[a]};b.set=function(a,d,c){c=b._getExtendedOptions(c);c.expires=b._getExpiresDate(d===e?-1:c.expires);b._document.cookie=b._generateCookieString(a,d,c);return b};b.expire=function(a,d){return b.set(a,e,d)};b._getExtendedOptions=function(a){return{path:a&& a.path||b.defaults.path,domain:a&&a.domain||b.defaults.domain,expires:a&&a.expires||b.defaults.expires,secure:a&&a.secure!==e?a.secure:b.defaults.secure}};b._isValidDate=function(a){return"[object Date]"===Object.prototype.toString.call(a)&&!isNaN(a.getTime())};b._getExpiresDate=function(a,d){d=d||new Date;switch(typeof a){case "number":a=new Date(d.getTime()+1E3*a);break;case "string":a=new Date(a)}if(a&&!b._isValidDate(a))throw Error("`expires` parameter cannot be converted to a valid Date instance"); return a};b._generateCookieString=function(a,b,c){a=a.replace(/[^#$&+\^`|]/g,encodeURIComponent);a=a.replace(/\(/g,"%28").replace(/\)/g,"%29");b=(b+"").replace(/[^!#$&-+\--:<-\[\]-~]/g,encodeURIComponent);c=c||{};a=a+"="+b+(c.path?";path="+c.path:"");a+=c.domain?";domain="+c.domain:"";a+=c.expires?";expires="+c.expires.toUTCString():"";return a+=c.secure?";secure":""};b._getCookieObjectFromString=function(a){var d={};a=a?a.split("; "):[];for(var c=0;c<a.length;c++){var f=b._getKeyValuePairFromCookieString(a[c]); d[f.key]===e&&(d[f.key]=f.value)}return d};b._getKeyValuePairFromCookieString=function(a){var b=a.indexOf("="),b=0>b?a.length:b;try {return{key:decodeURIComponent(a.substr(0,b)),value:decodeURIComponent(a.substr(b+1))}} catch(e) {return{key:a.substr(0,b),value:a.substr(b+1)}}};b._renewCache=function(){b._cache=b._getCookieObjectFromString(b._document.cookie);b._cachedDocumentCookie=b._document.cookie};b._areEnabled=function(){var a="1"===b.set("cookies_lhc.js",1).get("cookies_lhc.js");b.expire("cookies_lhc.js");return a};b.enabled=b._areEnabled();window.lhc_Cookies=b})();

var lh_inst_page  = {
	JSON : {
            parse: window.JSON && (window.JSON.parse || window.JSON.decode) || String.prototype.evalJSON && function(str){return String(str).evalJSON();} || $.parseJSON || $.evalJSON,
            stringify:  Object.toJSON || window.JSON && (window.JSON.stringify || window.JSON.encode) || $.toJSON
    },
	cookieData : {},

    hide : function() {
        var th = document.getElementsByTagName('head')[0];
        var s = document.createElement('script');
        s.setAttribute('type','text/javascript');
        s.setAttribute('src','<?php echo erLhcoreClassModelChatConfig::fetch('explicit_http_mode')->current_value?>//<?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::baseurl('chat/chatwidgetclosed')?>');
        th.appendChild(s);
    },

    parseOptions : function() {
		argumentsQuery = new Array();

		if (typeof LHCChatOptionsPage != 'undefined') {
	    	if (typeof LHCChatOptionsPage.attr != 'undefined') {
	    		if (LHCChatOptionsPage.attr.length > 0){
					for (var index in LHCChatOptionsPage.attr) {
						argumentsQuery.push('name[]='+encodeURIComponent(LHCChatOptionsPage.attr[index].name)+'&value[]='+encodeURIComponent(LHCChatOptionsPage.attr[index].value)+'&type[]='+encodeURIComponent(LHCChatOptionsPage.attr[index].type)+'&size[]='+encodeURIComponent(LHCChatOptionsPage.attr[index].size)+'&req[]='+(typeof LHCChatOptionsPage.attr[index].req != 'undefined' && LHCChatOptionsPage.attr[index].req == true ? 't' : 'f')+'&sh[]='+((typeof LHCChatOptionsPage.attr[index].show != 'undefined' && (LHCChatOptionsPage.attr[index].show == 'on' || LHCChatOptionsPage.attr[index].show == 'off')) ? LHCChatOptionsPage.attr[index].show : 'b'));
					};
	    		};
	    	};

	    	if (typeof LHCChatOptionsPage.attr_prefill != 'undefined') {
	    		if (LHCChatOptionsPage.attr_prefill.length > 0){
					for (var index in LHCChatOptionsPage.attr_prefill) {
						argumentsQuery.push('prefill['+LHCChatOptionsPage.attr_prefill[index].name+']='+encodeURIComponent(LHCChatOptionsPage.attr_prefill[index].value));
						if (typeof LHCChatOptionsPage.attr_prefill[index].hidden != 'undefined'){
							argumentsQuery.push('hattr[]='+encodeURIComponent(LHCChatOptionsPage.attr_prefill[index].name));
						};
					};
	    		};
	    	};

	    	if (argumentsQuery.length > 0) {
	    		return '&'+argumentsQuery.join('&');
	    	};
    	};

    	return '';
    },

    getAppendCookieArguments : function() {
		    var hashAppend = this.cookieData.hash ? '/(hash)/'+this.cookieData.hash : '';
		    var hashResume = this.cookieData.hash_resume ? '/(hash_resume)/'+this.cookieData.hash_resume : '';
		    var soundOption = this.cookieData.s ? '/(sound)/'+this.cookieData.s : '';
		    return hashAppend+hashResume+soundOption;
    },

	addCookieAttribute : function(attr, value){
    	if (!this.cookieData[attr] || this.cookieData[attr] != value){
	    	this.cookieData[attr] = value;
	    	this.storeSesCookie();
    	}
    },

    showStartWindow : function() {
		 var locationCurrent = encodeURIComponent(window.location.href.substring(window.location.protocol.length));
         this.initial_iframe_url = "<?php echo erLhcoreClassModelChatConfig::fetch('explicit_http_mode')->current_value?>//<?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::baseurl('chat/chatwidget')?><?php $leaveamessage == true ? print '/(leaveamessage)/true' : ''?><?php $department !== false ? print '/(department)/'.$department : ''?><?php $theme !== false ? print '/(theme)/'.$theme : ''?><?php $operator !== false ? print '/(operator)/'.$operator : ''?><?php $priority !== false ? print '/(priority)/'.$priority : ''?><?php $uarguments !== false ? print '/(ua)/'.$uarguments : ''?>/(mode)/embed"+this.getAppendCookieArguments()+'?URLReferer='+locationCurrent+this.parseOptions();

         this.iframe_html = '<iframe id="fdbk_iframe_page" allowTransparency="true" scrolling="no" class="loading" frameborder="0" ' +
                       ( this.initial_iframe_url != '' ? ' src="'    + this.initial_iframe_url + '"' : '' ) +
                       ' width="100%"' +
                       ' height="340"' +
                       ' style="width: 100%; height: 340px;"></iframe>';

		  document.getElementById('lhc_status_container_page').innerHTML = this.iframe_html;
    },

	storeSesCookie : function(){
    	if (sessionStorage) {
    		sessionStorage.setItem('lhc_ses',this.JSON.stringify(this.cookieData));
    	} else {
	    	lhc_Cookies('lhc_ses',this.JSON.stringify(this.cookieData));
	    }
    },

    initSessionStorage : function(){
    	if (sessionStorage && sessionStorage.getItem('lhc_ses')) {
    		this.cookieData = this.JSON.parse(sessionStorage.getItem('lhc_ses'));
    	} else {
	    	var cookieData = lhc_Cookies('lhc_ses');
			if ( typeof cookieData === "string" && cookieData ) {
				this.cookieData = this.JSON.parse(cookieData);
			}
		}
    },

	removeCookieAttr : function(attr){
    	if (this.cookieData[attr]) {
    		delete this.cookieData[attr];
    		this.storeSesCookie();
    	}
    },

    hide : function() {
        var th = document.getElementsByTagName('head')[0];
        var s = document.createElement('script');
        s.setAttribute('type','text/javascript');
        s.setAttribute('src','<?php echo erLhcoreClassModelChatConfig::fetch('explicit_http_mode')->current_value?>//<?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::baseurl('chat/chatwidgetclosed')?>'+this.getAppendCookieArguments());
        th.appendChild(s);
        this.removeCookieAttr('hash');
        this.showStartWindow();
    },
    
	genericCallback : function(name){
    	if (typeof LHCChatOptionsPage != 'undefined' && typeof LHCChatOptionsPage.callback != 'undefined' && typeof LHCChatOptionsPage.callback[name] != 'undefined') {
    		LHCChatOptionsPage.callback[name](this);    	
    	}
    },
    
    handleMessage : function(e) {   	
    	var action = e.data.split(':')[0];
    	if (action == 'lhc_sizing_chat_page') {
    		var height = e.data.split(':')[1];
    		var elementObject = document.getElementById('fdbk_iframe_page');
    		elementObject.height = height;
    		elementObject.style.height = height+'px';
    	} else if (action == 'lhc_ch') {
    		var parts = e.data.split(':');
    		if (parts[1] != '' && parts[2] != '') {
    			lh_inst_page.addCookieAttribute(parts[1],parts[2]);
    		};
    	} else if (action == 'lh_callback') {
    		var functionName = e.data.split(':')[1];
    		lh_inst_page.genericCallback(functionName);    	
    	} else if (action == 'lhc_close') {
    		lh_inst_page.hide();
    	}
    }
};

lh_inst_page.initSessionStorage();

if ( window.attachEvent ) {
	// IE
	window.attachEvent("onmessage", lh_inst_page.handleMessage);
};

if ( document.attachEvent ) {
	// IE
	document.attachEvent("onmessage", lh_inst_page.handleMessage);
};

if ( window.addEventListener ){
	// FF
	window.addEventListener("message", lh_inst_page.handleMessage, false);
};

lh_inst_page.showStartWindow();

<?php endif;
exit;?>