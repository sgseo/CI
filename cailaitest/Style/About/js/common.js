$(function(){
    //招聘信息下拉
    $(document).on('click','#slideShow .job-more',function(){
        var $this=$(this),$thisP=$this.parent(),$thisPNext=$thisP.next();
        $('#slideShow .job-more').removeClass('current');
        $('#slideShow .job-info').slideUp(200);
        if($thisPNext.is(':hidden')){
            $thisPNext.stop().slideDown(200);
            $this.addClass('current');
        }else{
            $thisPNext.stop().slideUp(200);
            $this.removeClass('current');
        }
    });
    //下拉菜单
    $(document).on('mouseenter','.nav-top-list .hasmore',function(){
        var $this=$(this),lr_menu=$this.find('.lr_menu');
        t_delay= setTimeout(function(){
            lr_menu.fadeIn("fast");
        },100);
    });
    $(document).on('mouseleave','.nav-top-list .hasmore',function(){
        var $this=$(this),lr_menu=$this.find('.lr_menu');
        clearTimeout(t_delay);
        lr_menu.fadeOut("fast");
    });
//结尾
})();
