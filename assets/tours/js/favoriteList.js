jQuery( function() {
  updateFavPageData();
});

  function updateFavPageData(){
    let favHtml = ''; 
    let slug = '';
    let favArray ='';
    if(localStorage.getItem('favArray')!= undefined && localStorage.getItem('favArray')!= null && localStorage.getItem('favArray')!= ''){
      favArray = JSON.parse(localStorage.getItem('favArray'));
      //update fav counter
      jQuery(".tour-favourites div p span").html('('+favArray.length+')');
      if(favArray.length > 0){
        jQuery('.fav-inner .item').html('');
        jQuery('.search-loader').show();
        jQuery.ajax({
          url: '../custom-code/api/index.php?action=getFavPageDataByTourId',
          type: 'GET',
          dataType: "json",
          data: {
           id   : favArray.toString()
          }
        }).done(function(res){
          if(res.status){ 
            jQuery.each(res.data, function( ind, val ) {
              slug = getSlugByTourId(val.tourID_Admin);
              let favClass    = (favArray.indexOf(parseInt(val.tourID_Admin)) > -1) ? 'active':'';

              favHtml +='<div class="col-md-4">'
                         +'<div class="carousel-slider__post">'
                            +'<div class="carousel-slider__post-content">'
                               +'<div class="carousel-slider__post-header">'
                                  +'<div class="top-box">'
                                     +'<div class="like-box">'
                                        +'<a href="javascript:void(0)" data-page="favorite-page" class="'+favClass+'">'
                                            +'<i class="fa fa-heart-o" aria-hidden="true"></i>'
                                          +'</a>'
                                          +'<a href="javascript:void(0)" onclick="shareTour('+slug+')">'
                                            +'<i class="fa fa-share-alt" aria-hidden="true"></i>'
                                          +'</a>'
                                     +'</div>'
                                  +'</div>'
                                  +'<div>'
                                     +'<input type="hidden" name="tourAdminId[]" class="tourOrignalId" value="'+val.tourID_Admin+'">'
                                      +' <a href="'+slug+'" target="_self" class="carousel-slider__post-image owl-lazy" style="background-image: url(/wp-content/uploads/2021/05/'+val.tBannerImage+');"></a>'

                                     +'<a class="carousel-slider__post-title tourid25" href="'+slug+'" target="_self">'
                                        +'<h2>'+val.tName+'</h2>'
                                     +'</a>'
                                     // +'<div class="address-box">'
                                     //    +'<img class=" ls-is-cached lazyloaded" src="/wp-content/uploads/2021/05/icons8-russian-federation-50.png" data-src="/wp-content/uploads/2021/05/icons8-russian-federation-50.png">'
                                     //    +'<noscript><img class="lazyload" src="/wp-content/uploads/2021/05/icons8-russian-federation-50.png"/></noscript>'
                                     //    +'<p><b>Russia</b></p>'
                                     // +'</div>'
                                  +'</div>'
                               +'</div>'
                               +'<div class="carousel-slider__post-excerpt">'+val.tBannerDescription+'</div>'
                               +'<div class="bt-box-banner centerbox">'
                                  +'<a href="'+slug+'" rel="noopener" target="_self">Learn more</a>'            
                               +'</div>'
                               +'<div class="carousel_footer">'
                                  +'<p>from <span></span> per person</p>'
                                +'</div>'
                            +'</div>'
                         +'</div>'
                      +'</div>';
            });
            jQuery(".fav-inner .item").html(favHtml); 
            jQuery('.search-loader').hide();
            upatePriceOnFavourtiteTours();   
          }else{
            favHtml ='<div class="no-fav"><p>You have not selected any tours as favorites.</p></div>';
            jQuery(".fav-inner .item").html(favHtml); 
          }
        });
      }else{
        favHtml ='<div class="no-fav"><p>You have not selected any tours as favorites.</p></div>';
        jQuery(".fav-inner .item").html(favHtml); 
      }
    }else{
      favHtml ='<div class="no-fav"><p>You have not selected any tours as favorites.</p></div>';
      jQuery(".fav-inner .item").html(favHtml); 
    }
            
  }

  setTimeout(function () {
    jQuery(document).on('click','.like-box > a',function(e){
      e.preventDefault();
      updateFavPageData();
    }); 
  },800);
  

  jQuery('.tour-favourites div p').first().click(function(e){
    e.preventDefault();
    updateFavPageData();
    window.open(base_url+'/favorite-list/', '_blank');
  });

  function upatePriceOnFavourtiteTours(){
    let urlData     = new URL(window.location.href);
    
    let paramPerson = (urlData.searchParams.get("person")!=null) ? urlData.searchParams.get("person") : 2;

    jQuery('div > input[name^="tourAdminId"]').each(function(ind,val) {
      let elem        = jQuery(this);
      let tourId      = elem.val();
      let anchors     = jQuery(this).closest('.carousel-slider__post').find('a');
      let slug        = getSlugByTourId(tourId);
      jQuery.each(anchors,function(){
        if(jQuery(this).attr('href')!== 'javascript:void(0)'){
          jQuery(this).attr('href',slug);
        }
      })

      let btn = jQuery(this).closest('.carousel-slider__post').find('.bt-box-banner a');
      jQuery.each(btn,function(){
        elem.siblings('a').attr('href',slug);
        jQuery(this).attr('href',slug);
      })

      if(tourId){
        let subEle      =   elem.closest('.carousel-slider__post-header').siblings('.carousel_footer').find('span');
        let person      = getLocalStorageData('person') == [] ? 1 : getLocalStorageData('person');

        //subEle.html(lastPrefix + formatNumber(person));
        //subEle.html(lastPrefix);
        // getLowestTourPrice(getPageIdByTourId(tourId),tourId,subEle);
        getLowestPrice(tourId,paramPerson,person,1,false).then(function(res){
          if(res.status){          
            subEle.html(lastPrefix + formatNumber(res.data));
          }
        });
      }
    });  
  }