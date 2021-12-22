jQuery(function($){

    const filter_options = document.querySelectorAll('[data-title]');
    filter_options.forEach(function(option){
        option.addEventListener('click', function(item){
            const title_text = item.target.dataset.title;

            filter_options.forEach(function(item){
                item.classList.remove('active-item');
            })
            
            item.target.classList.add('active-item');
            document.querySelector('.filter-wrapper').style.marginTop = '-70px';
            
            const target = document.querySelector(`[data-target="${title_text}"]`);
            const filter_target = document.querySelectorAll('[data-target]');

            filter_target.forEach(function(t_item){
                t_item.classList.remove('show_cat_tag');
            })

            target.classList.add('show_cat_tag');
        })
    });

    let allItems = [];
    document.querySelectorAll('.post .content .excerpt_title').forEach(function(item){
        allItems.push(item.offsetHeight)
    });

    const PostTitle = Math.max(...allItems);

    const title = document.querySelectorAll('.post .content .excerpt_title')
    title.forEach(function(item){
        item.style.height = PostTitle + 'px';
    });

    // Ajax.....
    let terms = [];
    let isTag = false;
    $('[data-title="topic"]').click(function(){
        $('#post_topic').slideDown();
        $('#post_type').slideUp();
    })
    $('[data-title="type"]').click(function(){
        $('#post_type').slideDown();
        $('#post_topic').slideUp();
    })  
    $('[data-title="topic"], [data-title="type"]').on('click', function(){
        terms = [];
    })
    $('.display-cats .cat-tag span, .display-cats .cat-tag .close-icon, .filter-items .filter-options .clear-filter').on('click', function(){
        var term = $(this).parent().attr('data-id');
        var ppp = $(this).parent().attr('data-ppp');
        var tag = $(this).parent().attr('data-tag');
        $(this).parent().addClass('active_filter');
        $('.clear-filter').show();

        if(this.localName === 'span'){
            if(term !== undefined){
                terms.unshift(term);
                isTag = false;
            }
            if(tag !== undefined){
                terms.unshift(tag);
                isTag = true;
            }

        }
        let uniqueTerms = [...new Set(terms)];
        const termItem = term ? term : tag;
        const fileterTerms = uniqueTerms.filter(item => item !== termItem);

        let f_terms = terms;
        if(this.localName === 'i'){
            this.parentElement.classList.remove('active_filter')
            f_terms = fileterTerms;
            terms = f_terms;
            if($('.active_filter').length === 0) $('.clear-filter').hide();
        }else if(this.localName === 'h2'){
            $('.clear-filter').hide();
            $('.cat-tag ').each(function(){
                $(this).removeClass('active_filter');
            })
            f_terms = null;
            terms = [];
        }
        
        $.ajax({
            url: ajax_obj.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: {
                action: 'pp_post_action',
                terms: f_terms,
                ppp: ppp,
                tag: isTag
            },
            beforeSend: function (resp) {
                $('#filterable-posts').html(ajax_obj.preloader);
            },
            success: function (resp) {
                $('#filterable-posts').html(resp);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    })
  
});