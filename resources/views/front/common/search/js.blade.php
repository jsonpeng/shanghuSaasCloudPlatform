
$(function(){

    document.querySelector('body').onscroll = function(e) { 
        if(($(window).scrollTop()>($('#searchBar').offset().top+$('#searchBar').outerHeight()))||(($(window).scrollTop()+$(window).height())<$('#searchBar').offset().top)){
            cancelSearch(); 
        }    
    };

    function searchProduct() {
        $searchInput = $('#searchInput');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'/ajax/product_search?query='+$searchInput.val(),
            type:'get',
            success:function(data){
                if(data.data.length){
                    // 编译模板函数
                    var tempFn = doT.template( $('#template-search').html() );

                    // 使用模板函数生成HTML文本
                    var resultHTML = tempFn(data.data);

                    // 否则，直接替换list中的内容
                    $('#searchResult').html(resultHTML);

                    $('#searchResult').show();

                }
            }
        });
        
    }
    var submit = _.debounce(searchProduct, 500);

    var $searchBar = $('#searchBar'),
        $searchResult = $('#searchResult'),
        $searchText = $('#searchText'),
        $searchInput = $('#searchInput'),
        $searchClear = $('#searchClear'),
        $searchCancel = $('#searchCancel');

    function hideSearchResult(){
        $searchResult.hide();
        $searchInput.val('');
    }
    function cancelSearch(){
        hideSearchResult();
        $searchBar.removeClass('weui-search-bar_focusing');
        $searchText.show();
    }

    $searchText.on('click', function(){
        $searchBar.addClass('weui-search-bar_focusing');
        $searchInput.focus();
    });
    $searchInput
        .on('blur', function () {
            if(!this.value.length) cancelSearch();
        })
        .on('input', function(){
            // if(this.value.length) {
            //     $searchResult.show();
            // } else {
            //     $searchResult.hide();
            // }
        })
    ;
    $searchClear.on('click', function(){
        hideSearchResult();
        $searchInput.focus();
    });
    $searchCancel.on('click', function(){
        cancelSearch();
        $searchInput.blur();
    });

    $searchInput.on('input',submit);  
});
