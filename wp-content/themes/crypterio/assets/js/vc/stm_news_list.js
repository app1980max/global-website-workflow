(function($){
    $(document).ready(function(){
       $('body').on('click', '.stm_news_list__more', function(e){
           e.preventDefault();
           var total = $(this).attr('data-total');
           var per_page = $(this).attr('data-per_page');
           var offset = $(this).attr('data-offset');
           var loop = $(this).attr('data-loop');


           $.ajax({
               url: ajaxurl,
               dataType: 'json',
               context: this,
               data: {
                   per_page: per_page,
                   total: total,
                   loop : loop,
                   offset: offset,
                   action: 'crypterio_load_stm_news_list',
                   security: window.wp_data.crypterio_load_stm_news_list
               },
               beforeSend: function () {
                   $(this).addClass('loading');
               },
               complete: function (data) {
                   var dt = data.responseJSON;
                   var $items = dt.content;


                   $($items).insertAfter($(this));
                   $(this).remove();

                   $('.stm_news_list .stm_news_list__single').each(function(){
                       var image = $(this).find('.stm_news_list__image').find('img');
                       var image_src = image.attr('data-src');
                       var image_srcset = image.attr('data-srcset');
                       image.attr('src', image_src);
                       image.attr('srcset', image_srcset);
                   });

               }
           });

       })
    });
})(jQuery);