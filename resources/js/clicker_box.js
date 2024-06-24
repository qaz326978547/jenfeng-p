// JavaScript Document

(function($){
	$.fn.clicker_box = function(OPTION){
		var CK = jQuery.extend({
			ACTIVE: "active", 
			ATR: "class", 
			TARGET: false, 
			RANGE: [false,false], 

			//---------------
			OBJ: false,
			WIDTH: false,
		}, OPTION);
		
		var THIS = $(this);

		function log(OUTPUT){
			try{
				console.log(OUTPUT);
			}catch(e){
				alert(OUTPUT);
			}
		}

		// 
		function range(){
			CK.WIDTH = $(window).width();
			if(CK.RANGE[1] === false || CK.RANGE[0] <= CK.WIDTH && CK.RANGE[1] >= CK.WIDTH){
				return true;
			}else{
				return false;
			}
		}

		// 
		function attrType(){
			return (CK.ATR == 'class')?true:false;
		}

		//
		function target(OBJ){
			CK.OBJ = (CK.TARGET === false)?OBJ:$(CK.TARGET);
		}

		function classIn(){
			CK.OBJ.addClass(CK.ACTIVE);
		}

		function classOut(){
			CK.OBJ.removeClass(CK.ACTIVE);
		}
		
		function togIn(){
			CK.OBJ.attr(CK.ATR,CK.ACTIVE);
		}

		function togOut(){
			CK.OBJ.removeAttr(CK.ATR,CK.ACTIVE);
		}

		//  
		function toggle(){
			THIS.on("click",function(E){
				if(range()){
					E.preventDefault();

					target($(this));
					var ATTR = CK.OBJ.attr(CK.ATR);

					if(typeof(ATTR) != "undefined" && ATTR.search(CK.ACTIVE) >= 0){
						(attrType())?classOut():togOut();
					}else{
						(attrType())?classIn():togIn();
					}
				}
			});
		}

		toggle();
	};
})(jQuery);


		$(function(){

			$(".collapse-button").clicker_box({
				ACTIVE: "active", 
				ATR: "class", 
				TARGET: '.navbar-collapse', 
				RANGE: [false,996], 
			});

			jQuery(".collapse-button").clicker_box({
				ACTIVE: "spread-out", 
				ATR: "class",
				TARGET: false, 
				RANGE: [false,996], 
			});

			$(".subNav").prev("a.menu").clicker_box({
				ACTIVE: "active", 
				ATR: "class",
				TARGET: false, 
				RANGE: [false,1024], 
			});
			$("nav > ul > li.mainShow").prev("a").clicker_box({
				ACTIVE: "active", 
				ATR: "class", 
				TARGET: false, 
				RANGE: [false,1024],
			});
			
			$(".submenu-title").clicker_box({
				ACTIVE: "active",
				ATR: "class",
				TARGET: false,
				RANGE: [false,1024], 
			});
			
			$(".menu_head .css_arrow_down").clicker_box({
				ACTIVE: "active", 
				ATR: "class", 
				TARGET: false, 
				RANGE: [false,1920], 
			});

			$(".css_arrow_down").clicker_box({
				ACTIVE: "active",
				ATR: "class",
				TARGET: false,
				RANGE: [false,1920], 
			});
		
		});
		


