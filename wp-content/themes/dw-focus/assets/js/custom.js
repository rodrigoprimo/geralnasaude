/*
	Masked Input plugin for jQuery
	Copyright (c) 2007-2011 Josh Bush (digitalbush.com)
	Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license) 
	Version: 1.3
*/
(function(a){var b=(a.browser.msie?"paste":"input")+".mask",c=window.orientation!=undefined;a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},dataName:"rawMaskFn"},a.fn.extend({caret:function(a,b){if(this.length!=0){if(typeof a=="number"){b=typeof b=="number"?b:a;return this.each(function(){if(this.setSelectionRange)this.setSelectionRange(a,b);else if(this.createTextRange){var c=this.createTextRange();c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select()}})}if(this[0].setSelectionRange)a=this[0].selectionStart,b=this[0].selectionEnd;else if(document.selection&&document.selection.createRange){var c=document.selection.createRange();a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length}return{begin:a,end:b}}},unmask:function(){return this.trigger("unmask")},mask:function(d,e){if(!d&&this.length>0){var f=a(this[0]);return f.data(a.mask.dataName)()}e=a.extend({placeholder:"_",completed:null},e);var g=a.mask.definitions,h=[],i=d.length,j=null,k=d.length;a.each(d.split(""),function(a,b){b=="?"?(k--,i=a):g[b]?(h.push(new RegExp(g[b])),j==null&&(j=h.length-1)):h.push(null)});return this.trigger("unmask").each(function(){function v(a){var b=f.val(),c=-1;for(var d=0,g=0;d<k;d++)if(h[d]){l[d]=e.placeholder;while(g++<b.length){var m=b.charAt(g-1);if(h[d].test(m)){l[d]=m,c=d;break}}if(g>b.length)break}else l[d]==b.charAt(g)&&d!=i&&(g++,c=d);if(!a&&c+1<i)f.val(""),t(0,k);else if(a||c+1>=i)u(),a||f.val(f.val().substring(0,c+1));return i?d:j}function u(){return f.val(l.join("")).val()}function t(a,b){for(var c=a;c<b&&c<k;c++)h[c]&&(l[c]=e.placeholder)}function s(a){var b=a.which,c=f.caret();if(a.ctrlKey||a.altKey||a.metaKey||b<32)return!0;if(b){c.end-c.begin!=0&&(t(c.begin,c.end),p(c.begin,c.end-1));var d=n(c.begin-1);if(d<k){var g=String.fromCharCode(b);if(h[d].test(g)){q(d),l[d]=g,u();var i=n(d);f.caret(i),e.completed&&i>=k&&e.completed.call(f)}}return!1}}function r(a){var b=a.which;if(b==8||b==46||c&&b==127){var d=f.caret(),e=d.begin,g=d.end;g-e==0&&(e=b!=46?o(e):g=n(e-1),g=b==46?n(g):g),t(e,g),p(e,g-1);return!1}if(b==27){f.val(m),f.caret(0,v());return!1}}function q(a){for(var b=a,c=e.placeholder;b<k;b++)if(h[b]){var d=n(b),f=l[b];l[b]=c;if(d<k&&h[d].test(f))c=f;else break}}function p(a,b){if(!(a<0)){for(var c=a,d=n(b);c<k;c++)if(h[c]){if(d<k&&h[c].test(l[d]))l[c]=l[d],l[d]=e.placeholder;else break;d=n(d)}u(),f.caret(Math.max(j,a))}}function o(a){while(--a>=0&&!h[a]);return a}function n(a){while(++a<=k&&!h[a]);return a}var f=a(this),l=a.map(d.split(""),function(a,b){if(a!="?")return g[a]?e.placeholder:a}),m=f.val();f.data(a.mask.dataName,function(){return a.map(l,function(a,b){return h[b]&&a!=e.placeholder?a:null}).join("")}),f.attr("readonly")||f.one("unmask",function(){f.unbind(".mask").removeData(a.mask.dataName)}).bind("focus.mask",function(){m=f.val();var b=v();u();var c=function(){b==d.length?f.caret(0,b):f.caret(b)};(a.browser.msie?c:function(){setTimeout(c,0)})()}).bind("blur.mask",function(){v(),f.val()!=m&&f.change()}).bind("keydown.mask",r).bind("keypress.mask",s).bind(b,function(){setTimeout(function(){f.caret(v(!0))},0)}),v()})}})})(jQuery)

jQuery(function($) {


	// GNS
	$(document).ready(function() {
//		$('input#nome').before('<span class="help-block">Escreva com bastante atenção para aprendermos bem!</span>');
//		$('input#apelido').before('<span class="help-block">Se você tem mais de um nome ou prefere o apelido, conte para a gente!</span>');
//		$('select#nascimento-dy').before('<span class="help-block">Atenção, você não nasceu em 2013!</span>');
		$('.option-field.date .simplr-clr').hide();
		
//		$('input#mae').before('<span class="help-block">Para o caso de alguém ter nomes iguais, a gente diferencia colocando o nome da mãe também.<span>');
//		$('input#escola_professor').before('<span class="help-block">Diga o nome e que aula ele dá.</span>');
//		$('textarea#anjo').before('<span class="help-block">Conte para nós o nome e qual a sua relação com essa pessoa.</span>');
//		$('input#celular').before('<span class="help-block">11 9-xxxx-xxxx</span>');

		$('#simplr-form input[type=checkbox]').attr('checked',false);

		// correspondente
//		$('label[for="educador_ubs"]').after("<span class='help-block'>Aqui estão listadas as UBS do projeto piloto. Se você for professor, pode clicar em 'Outro' e especificar a escola onde trabalha.</span>");
//		$('label[for="educador_ubs_period"]').after("<span class='help-block'>Caso você seja professor, qual a periodicidade das atividades extracurriculares que faz com os alunos de sua escola?</span>");


		//tel val
//		$('input#celular').mask('(99) 9-9999-9999');	
		
		// appends
		$('.my-profile #item-meta').append('<a href="/wp-admin/post-new.php" class="btn btn-primary">Nova postagem</a><br/><br/><a class="btn btn-primary" href="/wp-admin/profile.php#description">Editar bio</a>');
		$('#secondary .widget.latest-news .widget-title').html('Popular');

		$('.bbp-username label').html('E-mail:');

		//hide
		$('#habla_middle_div').next("div").hide();

		//registro hide username e copy email
		$('.page-id-1172 input[name=username], .page-id-1172 label[for=username]').hide();
		$('.page-id-1172 input[name=email_confirm]').blur(function(){
			$('.page-id-1172 input[name=username]').val($('.page-id-1172 input[name=email_confirm]').val());
		});
		
	});

    // Accordion
    $('.accordion').on('show', function (e) {
    $(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('active');
    });
    $('.accordion').on('hide', function (e) {
    $(this).find('.accordion-toggle').not($(e.target)).removeClass('active');
    }); 

    //Slide init
    $('.carousel').on('slid',function(e){
        var t = $(this);
        var index = t.find('.item.active').index(),
            navs = [ t.closest('.news-slider').find('.carousel-nav ul'),
                      t.find('.carousel-nav ul') ];

        for( var key in navs ){
          if( navs[key].length > 0 ){
              navs[key].find('li').each(function(){
                  $(this).removeClass('active');
              });
              navs[key].find('li').eq(index).addClass('active');
          }
        }

        if( t.closest('.news-slider').length > 0 ) {
            var slider = t.closest('.news-slider');
            slider.find('.other-entry li').each(function(){
                $(this).removeClass('active');
            });
            slider.find('.other-entry li').eq(index).addClass('active');
        }
    });
    // Slide controls
    $('.news-slider .other-entry li').on('click',function(e){
        e.preventDefault();
        var t = $(this);
        t.closest('.news-slider').find('.carousel').carousel( t.find('a').data('slice') );
    });
    // Fix slide entry-header
    var slideHeight = $('.news-slider').height();
    $('.news-slider .hentry').css('height',slideHeight + 30);
    

    //Init carousel control nav
    $('.carousel').each(function(){
        var t = $(this),
            nav = [ t.find('.carousel-nav ul'),
                    t.closest('.news-slider').find('.carousel-nav ul') ];

        for( var key in nav ){
          if( nav[key].length > 0 ) {
            t.find('.carousel-inner .item').each(function(i,j){
                var clss = (i==0)?'active':'';
                nav[key].append('<li class="'+clss+'"><a href="#'+i+'">'+i+'</a></li> ');
            });
          }
        }
    });

    //Bind event for carousel nav control
    $('.carousel').each(function(){
        var t = $(this),
            nav = [ t, t.closest('.news-slider') ];
        for( var key in nav ) {
            if( nav[key].length > 0 ) {
                nav[key].find('.carousel-nav ul').delegate('li','click',function(e){
                    e.preventDefault();
                    var idx = t.find('.carousel-nav ul li').index($(this));
                    t.carousel(idx);
                });
            }
            nav[key].find('.carousel-nav ul').delegate('li','click',function(e){
                e.preventDefault();
                var idx = nav[key].find('.carousel-nav ul li').index($(this));
                t.carousel(idx);
            });
        }
        
    });


    //Init twitter boostrap tabs
    //With ul list
    $('.news-tab .nav-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    //With select box
    $('.nav-tabs-by-select').change(function (e) {
        e.preventDefault();
        var target =  $(this).val();
        $('.news-tab .nav-tabs a[href="'+target+'"]').tab('show');
    });

    $('#primary .content-inner').infinitescroll({
      loading: {
        finished: undefined,
        finishedMsg: "",
        msgText: "",
        speed: 0,
        img: 'http://i.imgur.com/qWbgI.gif'
      },
      navSelector  : "div.navigation-inner",            
      nextSelector : "div.navigation-inner a",    
      itemSelector : "#primary .content-inner .hentry",
      donetext : "test",
      errorCallback: function(){
        $('div.navigation-inner').addClass('end');
        $('div.navigation a').addClass('disabled').text('No More News');
      }
    }, function(newElements, data, url){
      $('div.navigation-inner').css( 'display', 'block');
      var i = $(this).find('.post').length;
      i -= newElements.length - 1;
      for( var key in newElements ) {
        $( newElements[key] ).removeClass('first');
        if( i % 3 == 0 ) {
          $( newElements[key] ).addClass('first');
        }
        i++;
      }

    });
    $(window).unbind('.infscr');
    $('div.navigation-inner a').click(function(){
      $('#primary .content-inner').infinitescroll('retrieve');
      return false;
    });


    // Scroll to top button
     var scrollTimeout;
    
    $('a.scroll-top').click(function(){
        $('html,body').animate({scrollTop:0},500);
        return false;
    });

    $(window).scroll(function(){
        clearTimeout(scrollTimeout);
        if($(window).scrollTop()>400){
            scrollTimeout = setTimeout(function(){$('a.scroll-top:hidden').fadeIn()},100);
        }
        else{
            scrollTimeout = setTimeout(function(){$('a.scroll-top:visible').fadeOut()},100);    
    }
    });

    // Set cookie 
    function setCookie(c_name,value,exdays) {
        var exdate=new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
        document.cookie=c_name + "=" + c_value;
    }

    // Get cookie
    function getCookie(c_name) {
        var i,x,y,ARRcookies=document.cookie.split(";");
        for (i=0;i<ARRcookies.length;i++) {
            x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
            y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
            x=x.replace(/^\s+|\s+$/g,"");
            if (x==c_name) {
                return unescape(y);
            }
        }
    }

    $('.post-layout a').click(function(e){
        e.preventDefault();
        if($(this).hasClass('active')) return
        $this = $(this);
        var layout = $this.attr('class');
        setCookie("cat_listing",$.trim(layout.split('-')[1]),365);
            $('.content-inner').fadeOut(function(){
                $('.content-inner').attr('class','content-inner').addClass($this.attr("class")).fadeIn();
            });
        $('.post-layout a').removeClass('active');
        $(this).addClass('active');
    });

     $('.footer-toggle').click(function(e){
        e.preventDefault();
        var footer_toggle = getCookie('footer_toggle');
        if( footer_toggle == null || footer_toggle != 'collapsed' ) {
            setCookie('footer_toggle','collapsed');
        } else {
            setCookie('footer_toggle','expanded');
        }
        $(this).toggleClass('collapsed');
        $('#sidebar-footer').stop().slideToggle();

     });

    // Headlines flash
    var headline_count;
    var headline_interval;
    var old_headline = 0;
    var current_headline = 0;

    headline_count = $(".headlines li").size();

    current_headline = headline_count;
    var timmer = $('.headlines').data('interval');
    
    if(timmer){
          headline_interval = setInterval(headline_rotate,timmer); //time in milliseconds
          $('.headlines').hover(function() {
            clearInterval(headline_interval);
          }, function() {
            headline_interval = setInterval(headline_rotate,timmer); //time in milliseconds
            headline_rotate();
          });
    }

    function headline_rotate() {
        current_headline--;

        if(current_headline == 0 ){
            $(".headlines li:first").animate({marginTop:"0px"},"slow");
            current_headline = headline_count;
            return false;
        }

       $(".headlines li:first").animate({marginTop:((current_headline-headline_count)*20)+"px"},"slow");
       
     }
     

     var change_category_tab = function(obj,catid){
         var widget = obj.closest('.news-category');
         widget.find('.tab_title').removeClass('active');
         obj.addClass('active');

         widget.find('.row-fluid.active').hide().removeClass('active').end()
           .find('.cat-'+catid).fadeIn('slow').addClass('active');
     }
    /**
    * Categories widget tabs
    */
    $('.news-category a.tab_title').click(function(e){
        if($(this).hasClass('active')) return;
        e.preventDefault();
        var catid= $(this).data('catid');
        change_category_tab( $(this),catid );
    });
    // Categories widget tabs in mobile devices
    $('.child-category-select').on('change',function(e){
        var catid = $(this).val();
        change_category_tab( $(this),catid );
    });

    // Mega menu scriptd
    $('.nav .sub-menu > li').hover(function(){
        var menuid= this.id.split('-')[2];
        var mparent = $(this).closest('.sub-mega-wrap')
        mparent.find('.sub-menu > li').removeClass('active');
        $(this).addClass('active');
        mparent.find('.subcat > div').removeClass('active');
        mparent.find('#mn-latest-'+menuid).addClass('active');
    });

    $('.nav .sub-menu-collapse').on('click',function(event){
        var submenu = $(this).closest('li').find('.sub-mega-wrap');

        if( submenu.length <= 0 ) {
            submenu = $(this).closest('li').find('.sub-menu');
        }
        submenu.toggleClass('active');

    });

    $(document).ready(function($) {
        // Check cookie for footer collapse and auto hide footer 
        var footer_toggle = getCookie('footer_toggle');
        if( footer_toggle != null && footer_toggle == 'collapsed' ) {
            $('#sidebar-footer').stop().hide();
        }

        // Slide gallery on handheld device
        $('.carousel .item').each(function(){
            disableDraggingFor( this );
        });
        $('.carousel').on('swipeleft',function(event){
            var t = $(this);
            $(this).carousel('next');
        });
        $('.carousel').on('swiperight',function(event){
            var t = $(this);
            $(this).carousel('prev');
        });//End swipe 

        if( 'ontouchstart' in document.documentElement ) {
          var clickable = null;
          $('.nav .menu-item').each(function(){
            var $this = $(this);

            if( $this.find('ul.sub-menu').length > 0 ) {
              $this.find('a:first').unbind('click').bind('touchstart',function(event){
                if( clickable != this ) {
                    clickable = this;
                    event.preventDefault();
                    var submenu = $this.find('.sub-mega-wrap');

                    if( submenu.length <= 0 ) {
                        submenu = $this.find('.sub-menu');
                    }
                    submenu.toggleClass('active');
                  return false;
                } else {
                    clickable = null;
                }
              });
            }
          });
        }

        //Submenu auto align
        $('.nav .menu-item').on('hover',function(event){
            var t = $(this),
                submenu = t.find('.sub-mega-wrap');
            if( submenu.length > 0 ) {
                var offset = submenu.offset(),
                    w = submenu.width();
                if( offset.left + w > $(window).width() ) {
                    t.addClass('sub-menu-left');
                } else {
                    t.removeClass('sub-menu-left');
                }
            }
        });// End submenu auto align

        function disableDraggingFor(element) {
          // this works for FireFox and WebKit in future according to http://help.dottoro.com/lhqsqbtn.php
          element.draggable = false;
          // this works for older web layout engines
          element.onmousedown = function(event) {
            event.preventDefault();
            return false;
          };
        }

    });
});

(function($) {

    /**
     * Spoofs placeholders in browsers that don't support them (eg Firefox 3)
     * 
     * Copyright 2011 Dan Bentley
     * Licensed under the Apache License 2.0
     *
     * Author: Dan Bentley [github.com/danbentley]
     */

    // Return if native support is available.
    if ("placeholder" in document.createElement("input")) return;

    $(document).ready(function(){
        $(':input[placeholder]').not(':password').each(function() {
            setupPlaceholder($(this));
        });

        $(':password[placeholder]').each(function() {
            setupPasswords($(this));
        });
       
        $('form').submit(function(e) {
            clearPlaceholdersBeforeSubmit($(this));
        });
    });

    function setupPlaceholder(input) {

        var placeholderText = input.attr('placeholder');

        setPlaceholderOrFlagChanged(input, placeholderText);
        input.focus(function(e) {
            if (input.data('changed') === true) return;
            if (input.val() === placeholderText) input.val('');
        }).blur(function(e) {
            if (input.val() === '') input.val(placeholderText); 
        }).change(function(e) {
            input.data('changed', input.val() !== '');
        });
    }

    function setPlaceholderOrFlagChanged(input, text) {
        (input.val() === '') ? input.val(text) : input.data('changed', true);
    }

    function setupPasswords(input) {
        var passwordPlaceholder = createPasswordPlaceholder(input);
        input.after(passwordPlaceholder);

        (input.val() === '') ? input.hide() : passwordPlaceholder.hide();

        $(input).blur(function(e) {
            if (input.val() !== '') return;
            input.hide();
            passwordPlaceholder.show();
        });
            
        $(passwordPlaceholder).focus(function(e) {
            input.show().focus();
            passwordPlaceholder.hide();
        });
    }

    function createPasswordPlaceholder(input) {
        return $('<input>').attr({
            placeholder: input.attr('placeholder'),
            value: input.attr('placeholder'),
            id: input.attr('id'),
            readonly: true
        }).addClass(input.attr('class'));
    }

    function clearPlaceholdersBeforeSubmit(form) {
        form.find(':input[placeholder]').each(function() {
            if ($(this).data('changed') === true) return;
            if ($(this).val() === $(this).attr('placeholder')) $(this).val('');
        });
    }


})(jQuery);
