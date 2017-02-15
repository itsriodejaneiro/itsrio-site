let Vue = require('vue');

import { map, filter } from 'lodash';

(function($) {
    $.fn.hasScrollBar = function() {
        try {
            return this.get(0).scrollHeight > this.innerHeight();
        } catch (e){
            return '';
        }
    }
})(jQuery);

Vue.prototype.filters = {
    filterBy(list, value) {
        return list.filter(function(item) {
            return item.indexOf(value) > -1;
        });
    },
    findBy(list, value) {
        return list.filter(function(item) {
            return item == value
        });
    },
    reverse(value) {
        return value.split('').reverse().join('');
    },
    limit(i, max) {
        return i <= max;
    }
}

Vue.component('its-search', {
    data() {
        return {
            title: '',
            ctp: [],
            info_areapesquisa: [],
            cat: [],
            list_cats: [],
            advanced: false
        };
    },
    watch: {
        ctp() {
            var _this = this;
            if (this.ctp.indexOf('projetos_ctp') > -1 || this.ctp.indexOf('publicacoes_ctp') > -1)
                $('#info_areapesquisa').removeClass('hide');
            else
                $('#info_areapesquisa').addClass('hide');

            $('#cat-filter').customScrollbar({  skin: "default-skin" });
        }
    },
    methods: {
        cleanFilters() {
            this.ctp = [];
            this.info_areapesquisa = [];
            this.cat = [];
        }
    }
});

Vue.component('its-aulas', {
    data() {
        return {
            aulas
        };
    }
});

Vue.component('its-map', {
    data() {
        return {
            markers,
            selectedMarker: false
        }
    },
    methods: {
        openMarker(marker, obj) {
            this.selectedMarker = marker;
            var el = $('.map-info');
            $('.map-info-carousel-item').eq(0).addClass('active');
            var elOffset = el.offset().top;
            var elHeight = el.height();
            var windowHeight = $(window).height();
            var offset;
            if (elHeight < windowHeight)
                offset = elOffset - ((windowHeight / 2) - (elHeight / 2));
            else
                offset = elOffset;
            $('html, body').animate({ scrollTop: offset }, 300);

            setInterval(function(){
                $('.map-info .next').unbind('click');
                $('.map-info .next').click(function() {
                    var prev = $('.map-info-carousel-item.active');
                    if (prev.next('.map-info-carousel-item').length == 0)
                        $('.map-info-carousel-item').eq(0).addClass('active');
                    else
                        prev.next('.map-info-carousel-item').addClass('active');
                    prev.removeClass('active');
                });

                $('.map-info .previous').unbind('click');
                $('.map-info .previous').click(function() {
                    var cur = $('.map-info-carousel-item.active');
                    if (cur.prev('.map-info-carousel-item').length == 0)
                        $('.map-info-carousel-item').last().addClass('active');
                    else
                        cur.prev('.map-info-carousel-item').addClass('active');
                    cur.removeClass('active');
                });
            },1000);
        },
        closeMarker() {
            this.selectedMarker = 'false';
            jQuery('.markers').attr('src', '/wp-content/themes/its-rio/functions/components/map/map-pin.svg');
        }
    },
    mounted() {
        jQuery('.markers').click(function() {
            jQuery('.markers').attr('src', "/wp-content/themes/its-rio/functions/components/map/map-pin.svg");
            jQuery(this).attr('src', "/wp-content/themes/its-rio/functions/components/map/map-pin-active.svg");
        });
    }
});

Vue.component('its-comunicados', {
    data() {
        return {
            comunicados
        };
    }
});

Vue.component('its-pessoas', {
    data() {
        return {
            pessoas,
            titleIsRendered : false,
        };
    },
    methods: {
        openPessoa(pessoa, ip) {
            if (pessoas.pessoaActive == "" || pessoas.pessoaActive.ID != pessoa.ID) {
                pessoas.pessoaActive = pessoa;
                setTimeout(function(){
                    $('html, body').animate({
                        scrollTop: $('.pessoa-info.active .pessoa-info-content').offset().top - 130
                    }, 300);
                }, 300);
            } else {
                pessoas.pessoaActive = "";
                setTimeout(function() {
                    jQuery('#pessoa_' + ip + '_' + pessoa.ID).removeAttr('checked');
                }, 100);
            }
        },
        openPessoaCat(pessoa, ip, pessoa_) {
            if (pessoa_.pessoaActive == "" || pessoa_.pessoaActive.ID != pessoa.ID) {
                pessoa_.pessoaActive = pessoa;

                console.log('#pessoa_' + ip.replace(' ','_') + '_' + pessoa.ID);
                $('html, body').animate({
                    scrollTop: jQuery('#pessoa_' + ip.replace(' ','_') + '_' + pessoa.ID).parents('.component-tabs-tab').find('.pessoa-info .pessoa-info-content').offset().top - 130
                }, 300);
            } else {
                pessoa_.pessoaActive = "";
                setTimeout(function() {
                    jQuery('#pessoa_' + ip.replace(' ','_') + '_' + pessoa.ID).removeAttr('checked');
                }, 100);
            }
        }
    }
});

Vue.component('its-informacoes', {
    data() {
        return typeof aulas != 'undefined' ? {
            informacoes,
            aulas
        } : {
            informacoes
        };
    }
});

new Vue({
    el: '#content_all',
    data: site_data,
    mounted() {
        $ = jQuery;

        $('.home-cover').css('height', $(window).height() + 'px');

        $('.related-post .large-4:gt(2)').hide();

        setTimeout(function() {
            if (location.hash == '#comunicados')
                $('.comunicados h2 > a').trigger('click');
            if (location.hash == '#equipe') {
                var target = $('.equipe');
                $('html, body').animate({ scrollTop: target.offset().top - 100 }, 300);
            }

            if (location.hash == '#onde-estivemos') {
                var target = $('.map');
                $('html, body').animate({ scrollTop: target.offset().top - 100 }, 300);
            }

            // if (['#direitos-e-tecnologia','#repensando-inovacao','#democracia-e-tecnologia','#educacao'].indexOf(location.hash) > -1) {
            //     jQuery('.area-pesquisa .slider')
            //     .eq(['#direitos-e-tecnologia','#repensando-inovacao','#democracia-e-tecnologia','#educacao'].indexOf(location.hash))
            //     .trigger('click');
            // }

             //FAZ COM QUE TODOS OS CARDS TENHAM A MESMA ALTURA E AUMENTA A ALTURA DA IMAGEM COM O EXCEDENTE 
            if($('.list-item-wrapper').length > -1 && $(window).width() > 640){
                var maxHeight = -1;

                $('.list-item').each(function() {
                    maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
                });

                $('.list-item').each(function() {
                    var excedingHeight = (maxHeight - $(this).height());
                    $(this).find('.img').css('height', 220 + excedingHeight);
                    $(this).find('.color-hover').css('height', 220 + excedingHeight);
                    $(this).height(maxHeight);
                });
            }
        }, 1000);

        $('.comunicados h2 > a').click(function() {
            if ($(this).text().indexOf("ver") > -1) {
                $('.content-area:not(.comunicados)').hide();
                $(this).text('voltar para institucional');
                $('.related-post .large-4').show();
                $('html, body').animate({ scrollTop: 0 }, 300);

                if ($('.list-item-wrapper').length > -1 && $(window).width() > 640) {
                    var maxHeight = -1;

                    $('.list-item-wrapper .large-4').each(function () {
                        maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
                    });

                    $('.list-item-wrapper .large-4').each(function () {
                        var excedingHeight = maxHeight - $(this).height();
                        $(this).find('.img').css('height', 220 + excedingHeight);
                        $(this).find('.img').css('overflow', 'hidden');
                        $(this).css('height', 220 + excedingHeight);
                        $(this).height(maxHeight);
                    });
                }
            } else {
                $('.content-area').show();
                $('.related-post .large-4:gt(2)').hide();
                $(this).text('ver todos');
            }
        });

        var menu = $('.header-single-menu');
        var top = (typeof menu.position() != "undefined") ? menu.position().top : 0;
        $(window).scroll(function() {
            var i = 0;
            $('.content-area[id*="tab"]').each(function(){
                this.id = 'tab_'+i; 
                i++;
            });
            
            var menu_fix = 0;// mobileAndTabletcheck() ? 0 : 100;
            if (typeof menu.position() != "undefined") {
                //Fixa o menu interno no menu global ao dar scroll
                if ($(this).scrollTop() >= top)
                    menu.addClass('fixed');
                else
                    menu.removeClass('fixed');

                var scrollPos = $(document).scrollTop() + menu_fix;
                $('.single-menu a').each(function() {
                    var currLink = $(this);
                    var refElement = $(currLink.attr("href"));
                    try{
                        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                            $('.single-menu ul li a').removeClass("active");
                            currLink.addClass("active");
                            site_data.single_menu_active = currLink.parent().index();
                        } else
                        currLink.removeClass("active");
                    }catch(e){}
                });
            }
        });

        //Adiciona a classe de active ao post type correspondente no menu global.
        $("a[href*='"+post_type+"'],a[href*='"+lang+"/"+post_type+"']").parent().addClass('current-menu-item');

        //Smooth scroll
        $('a[href*="#"]:not([href="#"]), .single-menu ul li ').click(function() {
            var el = $(this).is('a') ? this : $(this).find('a')[0];

            if (location.pathname.replace(/^\//, '') == el.pathname.replace(/^\//, '') && location.hostname == el.hostname) {
                var target = $(el.hash);
                target = target.length ? target : $('[name=' + el.hash.slice(1) + ']');
                if (target.length) {
                    $('.single-menu ul li a').removeClass('active');
                    $(el).addClass('active');

                    $('html, body').animate({
                        scrollTop: target.offset().top - 65
                    }, 300);
                    return false;
                }
            }
        });

        if (mobileAndTabletcheck()) {
            var redes = $('footer .social-icons').html();
            var trending = $('footer .social-content .tags ul').html();
            $('.menu-mobile-footer .redes').html(redes);
            $('.menu-mobile-footer .trending').html('<h3>#trending tags</h3><ul>' + trending + '</ul>');

            // Remove o mapas do menu para mobile
            if($('.map').length > 0){
                var mapIndex = parseInt($('.map')[0].id.replace('tab_', ''));
                site_data.its_tabs.splice(mapIndex, 1);
                setTimeout(() => { $('.map').remove(); }, 100); 
            }

            if($('.component-social-medias').length > 0){
                var socialMediasIndex = parseInt($('.component-social-medias')[0].id.replace('tab_', ''));
                site_data.its_tabs.splice(socialMediasIndex - 1, 1);
                setTimeout(() => { $('.component-social-medias').remove(); }, 100 );
            }

            var i = 0;
            $('.content-area[id*="tab"]').each(function(){
                this.id = 'tab_'+i; 
                i++;
            });
        }

        var menu_nav = $('.menu-nav');

        if (menu_nav.hasScrollBar()) {
            menu_nav.addClass('scrollable');
            menu_nav.scroll(function() {
                if ($('.menu-nav > div').height() + 123 == $(window).height() - 40 + menu_nav.scrollTop())
                    menu_nav.addClass('scrollable-bottom');
                else
                    menu_nav.removeClass('scrollable-bottom');
            });
        }

        
    },
    methods: {
        changeSingleMenu(i) {
            this.single_menu_active = i;
            $('.single-menu').removeClass('active');
        }
    }
});

function mobileAndTabletcheck() {
    var check = false;
    (function(a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);

    if (!check && $(window).width() < 770)
        check = true;

    return check;
}