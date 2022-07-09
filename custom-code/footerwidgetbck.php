<?php
   /**
    * Displays the footer widget area.
    *
    * @package WordPress
    * @subpackage Twenty_Twenty_One
    * @since Twenty Twenty-One 1.0
    */
   
   if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
<div class="modal fade" id="exampleModalr1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <?php echo do_shortcode('[contact-form-7 id="2562" title="Call Back"]') ?>
         </div>
      </div>
   </div>
</div>
<aside class="widget-contact-part">
   <div class="container">
      <?php dynamic_sidebar( 'sidebar-1' ); ?>
   </div>
</aside>
<!-- .widget-area -->
<aside class="widget-footer">
   <div class="container">
      <?php dynamic_sidebar( 'sidebar-2' ); ?>
   </div>
</aside>
<!-- .widget-area -->
<aside class="widget-footer-last">
   <div class="container">
      <?php dynamic_sidebar( 'sidebar-3' ); ?>
   </div>
</aside>
<!-- .widget-area -->


<!-- calendar modal -->
    
   <div class="modal fade" id="monthYearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            
            <div class="modal-body"> 
               <div class="year-month">
                  <a href="#" class="pull-left"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                  <span>2021</span>
                  <a href="#" class="pull-right"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
               </div>
             
               <ul class="month_ul">
                  <li data-value="01">Jan</li>
                  <li data-value="02">Feb</li>
                  <li data-value="03">Mar</li>
                  <li data-value="04">Apr</li>
                  <li data-value="05">May</li>
                  <li data-value="06">Jun</li>
                  <li data-value="07">Jul</li>
                  <li data-value="08">Aug</li>
                  <li data-value="09">Sep</li>
                  <li data-value="10">Oct</li>
                  <li data-value="11">Nov</li>
                  <li data-value="12">Dec</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
               
<!-- ./calendar modal -->

<!-- slider modal -->
<div class="modal" id="tourCityModal" role="dialog">
  <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button class="close" type="button" data-dismiss="modal">×</button>
      <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body">
      <div id="tourCityModalSlide" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner"></div>
        <p class="slideIcon"></p>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
   </div>
  </div>
</div>
<!-- / slider modal -->
<!-- -------slider-for-products------- -->
<script src="https://selima9.sg-host.com/wp-content/themes/twenty-twenty-one-child/assets/js/bootstrap.min.js"></script>

<!-- -------products page top bar stiky------- -->
<script>
   jQuery(function(){
      

      /* when clicking a thumbnail */
      jQuery('.mg-listsz').click(function(){
      
        let html = jQuery(this).siblings('.carousel-inner').html();
        let html1 = jQuery(this).siblings('.slideIcon').html();
        html1+='<a class="carousel-control left" href="#tourCityModalSlide"  data-slide="prev"><i class="fa fa-angle-left"></i></a>'+
            '<a class="carousel-control right" href="#tourCityModalSlide" data-slide="next"><i class="fa fa-angle-right"></i></a>';

        jQuery('#tourCityModalSlide > .carousel-inner').html(html); // show the modal
        jQuery('#tourCityModalSlide > .slideIcon').html(html1); // show the modal  
         
        jQuery('#tourCityModal').modal('show'); // show the modal
        jQuery('#tourCityModalSlide').carousel(); // slide carousel to selected
         
      });
   })

</script>

<script>
  var headerElem          = jQuery("#myHeader");
  var headerOffsetTop     = headerElem.offset().top;
  var lastResult          = [];
  var lastPrefix          = '';
  var monthsArray         = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  var totalTourDay        = 0;

  window.onscroll = function() {
    let windowOffset      = window.pageYOffset;
    if (windowOffset > headerOffsetTop) {
      headerElem.addClass("sticky");
    } else {
      headerElem.removeClass("sticky");
    }
  };
   
  jQuery('#myHeader .nav-tabs li a').click(function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    jQuery(this).tab('show');
  });

  jQuery(document).on('click','.ui-datepicker-title',function(){
  
    let currentDate = jQuery( "#datepicker-2" ).val();
    let datePieces = currentDate.split('-');
    let month = parseInt(jQuery('input[name="selectedMonth"]').val()) > 0 ? parseInt(jQuery('input[name="selectedMonth"]').val()) : datePieces[1] ;
    let day   = datePieces[2];
    let year  = parseInt(jQuery('input[name="selectedYear"]').val()) > 0 ? parseInt(jQuery('input[name="selectedYear"]').val()) : datePieces[0];
     
    let presentYear  = new Date().getFullYear();
    let presentMonth = new Date().getMonth()+1;
    
    if(presentYear == year){
      jQuery('.year-month>.pull-left').addClass('disable');
      updateCustomCalendar(month,year,presentMonth);
    }else{
      updateCustomCalendar(month,year);
    }
    // show Modal
    jQuery('#monthYearModal').modal('show');
  });  

  jQuery(document).on('click','.pull-left',function(e){
    e.preventDefault();
    let presentMonth  = new Date().getMonth()+1;
    let presentYear   = new Date().getFullYear();
    let year          = parseInt(jQuery(this).siblings('span').text());
    year              = year-1;
    if(year == presentYear ){
      updateCustomCalendar(presentMonth,year,presentMonth);
      jQuery(this).addClass('disable');
      return false;
    } 
    if(year <= presentYear){
      year = presentYear;
    }  
    jQuery('.year-month>span').text(year);
  });
   
  jQuery(document).on('click','.pull-right',function(e){
    e.preventDefault();
    let year = parseInt(jQuery(this).siblings('span').text());
    year = year+1;
    updateCustomCalendar(0,year);
    jQuery('.year-month>span').text(year);
    jQuery('.year-month>.pull-left').removeClass('disable');
  }); 

  jQuery(document).on('click','.month_ul > li',function(e){
    e.preventDefault();
    jQuery(this).addClass('active');
    let month = parseInt(jQuery(this).attr('data-value'));
    jQuery('input[name="selectedMonth"]').val(month);
    let year  = parseInt(jQuery('.year-month > span').text());
    jQuery('input[name="selectedYear"]').val(year);
    
    month     = month - 1;
  
    jQuery('#datepicker-2').datepicker("setDate", new Date(year,month,01) );
    // show Modal
    //getCalendarPrice();
    jQuery('#monthYearModal').modal('hide');
  }); 
  function updateCustomCalendar(month,year,presentMonth=0){
    jQuery('.month_ul li').each(function() {
      jQuery(this).removeClass('active').removeClass('disabled');
      if(presentMonth > 0){
        if(jQuery(this).attr('data-value') < presentMonth ) {
          jQuery(this).addClass('disabled');
        }
      }

      if(jQuery(this).attr('data-value') == month ) {
        jQuery(this).addClass('active');
      }
      
    });
    
    jQuery('.year-month>span').text(year);
  } 
   
</script>
<!-- -----------calendra-details-page---------- -->
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<!-- Javascript -->
<script>
  //gaurav code start
  function initiateReadMoreReadLess(){
    const readSetting = {
      showChar      : 300,  
      ellipsestext  : "...",
      moretext      : "Read more",
      lesstext      : "Read less",
      btnHtml       : '<button class="readInstance" data-show="0">Read More</button>'
    };

    jQuery('button[id^="myBtn"]').each(function() {
      let parentP     = jQuery(this).closest('p');
      let contentP    = jQuery(this).closest('.col-md-9');
      if(parentP.siblings('div[id^=more]').length > 0){
        jQuery(this).replaceWith(readSetting.btnHtml);
      }else{
        jQuery(this).replaceWith('');
      }
     
    });
 
    jQuery(document).on('click','.readInstance',function(){
      let flag = jQuery(this).attr('data-show');
      if(flag == 1){
        jQuery(this).text(readSetting.moretext);
        jQuery(this).closest('p').siblings('div[id^=more]').css('display','none');
        jQuery(this).attr('data-show',0);
      }else{
        jQuery(this).text(readSetting.lesstext);
        jQuery(this).attr('data-show',1);
        jQuery(this).closest('p').siblings('div[id^=more]').css('display','block');
      }     
    });

  }
   
  function initiateTabs(){
    jQuery('.nav-tabs > li > a').each(function() {
      let tabId = jQuery(this).attr('href');
      jQuery(this).attr('data-tab-id',tabId);
      jQuery(this).addClass('tabOpen');
      jQuery(this).attr('href','javascript:void(0)');
    });
  }
  
   
  var languageData = [];
  var currencyData = [];
  function activateDate() {
    jQuery( "#datepicker-13" ).datepicker();
    jQuery( "#datepicker-13" ).datepicker("show");
  }
   
  jQuery( function() {
    jQuery('#exampleModalr66').remove();
    jQuery('.Tour-dates > h5').html('Please Select Date');
    jQuery('.price-per-person > h6').html('');
   //setup read more and read less
   initiateReadMoreReadLess();
   //initiateTabs();
    var dateFormat = "mm/dd/yy",
      from = jQuery( "#from" )
      .datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
    })
    .on( "change", function() {
      to.datepicker( "option", "minDate", getDate( this ) );
    }),
    to = jQuery( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3
    })
    .on( "change", function() {
      from.datepicker( "option", "maxDate", getDate( this ) );
    });

   function getDate( element ) {
     var date;
     try {
       date = jQuery.datepicker.parseDate( dateFormat, element.value );
     } catch( error ) {
       date = null;
     }

     return date;
   }
  });

  let pageId = "<?php  echo get_queried_object_id(); ?>";
   
   
  jQuery(function() {
    jQuery( "#datepicker-2" ).datepicker({
      firstDay: 1,
      dayNamesMin: [ "SUN","MON", "TUE", "WED", "THU", "FRI", "SAT"],
      minDate : new Date(),
      dateFormat: 'yy-mm-dd',
      onSelect: function(date, inst){
        inst.inline = false;
        updateTourInterval(date,totalTourDay);
        let dateArry      = date.split('-');
        let selectedDate  = parseInt(dateArry[2]);
        setCalendarPrice(lastResult,lastPrefix,selectedDate);
        jQuery( ".bg-color-bt").removeClass('disabled-link');
        if(jQuery('.ui-datepicker-prev').hasClass('ui-state-disabled')){
          jQuery('.ui-datepicker-prev').css('display','none');
        }


        
      },
      onChangeMonthYear: function (year,month,datepicker) {
        //datepicker.inline = true;
        jQuery('input[name="selectedMonth"]').val(month);
        jQuery('input[name="selectedYear"]').val(year);
        
        getCalendarPrice();
      }
    });
    getCurrencyAndLanguageList();
    

  });
  setTimeout(function () {
    if(pageId != '' && pageId != undefined && pageId != null)
    getCalendarPrice();
  },3000);
   
  function getCalendarPrice(){
    jQuery( ".bg-color-bt").addClass('disabled-link');
    let month = new Date().getMonth();
    if(jQuery('input[name="selectedMonth"]').val() != undefined){
      month = jQuery('input[name="selectedMonth"]').val();
    }
    let dateObj   = new Date();
    let dateMonth = dateObj.getMonth() + 1; //months from 1-12
    let dateDay   = dateObj.getDate();
    let dateYear  = dateObj.getFullYear();
    let today     = dateYear+'-'+dateMonth+'-'+dateDay;
    
    jQuery.ajax({
      url: '../custom-code/index.php',
      type: 'GET',
      dataType: "json",
      data: {
       pageId:pageId,
       month : month,
       today:today,
       person:jQuery('select[name="numberofadults"]').val(),
       child:jQuery('select[name="numberofchild"]').val(),
       lng:jQuery('select[name="language"]').val(),
       currency:jQuery('select[name="currency"]').val(),
      }
    }).done(function(data){
      if(data.status){
        totalTourDay = parseInt(data.totalTourDays);
        //set calendar price
        setCalendarPrice(data.data.result,data.prefix,null);
        jQuery('.price-per-person > h3').html(data.prefix+'-');
        //set values in other parts of page
        let groupList = ['groupOneArray','groupTwoArray','groupThreeArray'];
        let perPersonPrice = 0;
        jQuery('.price-per-color > ul >li ').each(function(key,val){
          if(data.data[groupList[key]].length > 0){
            jQuery(this).show();
            let calculate = data.data[groupList[key]][0] / jQuery('select[name="numberofadults"]').val();
            calculate = Math.round(calculate);
            if(key==0) { perPersonPrice = calculate;}
            jQuery(this).children('h5').html(data.prefix + formatNumber(calculate));
          }else{
            jQuery(this).hide();
          }
          
        });
        jQuery('.price-text > p > span ').html(data.prefix + formatNumber(perPersonPrice));

        //hide back event only in calendar
        if(jQuery('.ui-datepicker-prev').hasClass('ui-state-disabled')){
          jQuery('.ui-datepicker-prev').css('display','none');
        }

      }      
    });
  }
   
  function setCalendarPrice(response,prefix,selectedDate=null){
    lastResult    = response;
    lastPrefix    = prefix;
    
    jQuery( "#datepicker-2" ).datepicker('refresh');
  
    jQuery(".ui-datepicker-calendar TBODY td a").each(function(){
      let elem      = jQuery(this);
      let parentElem= elem.closest('td');
      let index     = elem.text();
      
      if(selectedDate != null){
       
        if(index == selectedDate){
      
          parentElem.addClass('selected');
          let personCount = jQuery('select[name="numberofadults"]').val();
          
          jQuery('.price-per-person').removeClass('green-border').removeClass('yellow-border').removeClass('red-border');
          jQuery('.price-per-person').addClass(response[index].class);
          let pricePerPerson = Math.round(response[index].price/jQuery('select[name="numberofadults"]').val());
          jQuery('.price-per-person > h3').html(prefix + formatNumber(pricePerPerson));
          jQuery('.price-per-person > h6').html('');
          // jQuery('.Tour-dates > h5').html('5th August – 15th August 2021');
          
        }
      }
      if( response[index]!= undefined && response[index] !== null && response[index]!='' ){
        
        parentElem.addClass(response[index].class);
        parentElem.append('<p>'+prefix+' '+formatNumber(response[index].price)+'</p>');
       
      }else{
        parentElem.replaceWith('<td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">'+index+'</span></td>');
        //parentElem.addClass('grey-border');
      }
      
    });

    
   
  }
   
  function getCurrencyAndLanguageList(){
    jQuery.ajax({
      url: '../custom-code/api.php?all=true',
      type: 'GET',
      dataType: "json"
    }).done(function(res){
      if(res.status){
        changeHtml(res.data);
      }
    });
  }
   
  function changeHtml(res){
     
    var languageOption = '';
    var currencyOption = '';
    var personOption   = '';
    var childOption    = '';
    if(res.language.length > 0){
      jQuery.each(res.language, function( ind, val ) {
        languageOption +='<option value="'+val.id+'" >'+val.name+'</option>';
      });
    }
 
    if(res.currency.length > 0){
      jQuery.each(res.currency, function( ind, val ) {
        let prefix = (val.cHTMLcode);
        if(val.id==2){
          currencyOption +='<option value="'+val.id+'" selected>'+prefix+' - '+val.name+'</option>';
        }else{
          currencyOption +='<option value="'+val.id+'" >'+prefix+' - '+val.name+'</option>';;
        }
      });
    }
 
    for (var i = 1; i <= 12; i++) {
      if(i==2){
        personOption +='<option value="'+i+'" selected>'+i+'</option>';
      }else{
        personOption +='<option value="'+i+'">'+i+'</option>';
      }
    }
   
     
    var html = 
    '<div class="filter">'+
     '<div class="row">'+
       '<div class="number-of-travellers col-md-3">'+
         '<label>Number of Passengers:</label>'+
         '<input type="hidden" name="selectedMonth" value="0"/>'+
         '<input type="hidden" name="selectedYear" value="0"/>'+
         '<div class="select-box">'+
           '<select name="numberofadults" onchange="getCalendarPrice()">'
             +personOption+
           '</select>'+
         '</div>'+
       '</div>'+
       '<div class="number-of-travellers col-md-3" >'+
         '<label>Tour guide language:</label>'+
         '<div class="select-box">'+
           '<select name="language" onchange="getCalendarPrice()">'
             +languageOption+
           '</select>'+
         '</div>'+
       '</div>'+
       '<div class="number-of-travellers col-md-2"><label>Currency</label>'+
         '<div class="select-box">'+
           '<select name="currency" onchange="getCalendarPrice()">'
             +currencyOption+
           '</select>'+
         '</div>'+
       '</div>'+
     '</div>'+
    '</div>';
     jQuery("div.filter").html('');
     jQuery("div.filter").html(html);
  }
  function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
  }

  function updateTourInterval(tourDayStart,totalTourDay){
    
    if(totalTourDay > 0){
      let startDate = new Date(tourDayStart);
      let endDate   = new Date(startDate.setDate(startDate.getDate() + totalTourDay)); 
      let startDateDay    = new Date(tourDayStart).getDate();
      let startDateMonth  = new Date(tourDayStart).getMonth();
      let endDateDay      = endDate.getDate();
      let endDateMonth    = endDate.getMonth();
      let endDateYear     = endDate.getFullYear();
     
      jQuery('.Tour-dates > h5').html(startDateDay+getOrdinalNum(startDateDay)+' '+monthsArray[startDateMonth]+' - '+endDateDay+getOrdinalNum(endDateDay)+' '+ monthsArray[endDateMonth]+' '+endDateYear);
    }
    
  }
  function getOrdinalNum(d) {
    if (d > 3 && d < 21) return 'th';
    switch (d % 10) {
      case 1:  return "st";
      case 2:  return "nd";
      case 3:  return "rd";
      default: return "th";
    }
  }
   
  //gaurav code end
  jQuery(function(){
    jQuery('.cq-dropdown').dropdownCheckboxes();
  });
    
  function resetCities() {
    jQuery("#my-cities button").html("All cities");
    jQuery("#my-cities button").append('<span class="caret"></span>');
    //jQuery('#my-cities').closest("input:checkbox").removeAttr('checked');
    jQuery("input:checkbox").removeAttr('checked');
       jQuery("input[name='my-cities']").val("");
    jQuery("#btnReset1").css("display", "none");
  }
  function resetTheme() {
    jQuery("#my-theme button").html("All themes");
    jQuery("#my-theme button").append('<span class="caret"></span>');
       jQuery("input[name='my-theme']").val("");
    jQuery("#btnReset").css("display", "none");
  }
     
  jQuery(document).on('click','.bt-box > a',function(e){
    e.preventDefault();
    jQuery("html, body").animate({ scrollTop: jQuery('#myHeader').offset().top }, 1000);
    jQuery('.nav-tabs a[href="#menu1"]').tab('show');
  });

  jQuery(document).on('click','.green-border',function(){
    jQuery(this).addClass('green-border-selected')
  });
  jQuery(document).on('click','.red-border',function(){
    jQuery(this).addClass('red-border-selected')
  });
  jQuery(document).on('click','.yellow-border',function(){
    jQuery(this).addClass('yellow-border-selected')
  });
 
   
   
</script>
<script src="https://www.jquery-az.com/jquery/js/dropdownCheckboxes/dropdownCheckboxes.min.js"></script>
<!-- -------check-box-select-one-home-page----------- -->
<script type="text/javascript">
   // the selector will match all input controls of type :checkbox
   // and attach a click event handler 
   jQuery("input:checkbox").on('click', function() {
     // in the handler, 'this' refers to the box clicked on
     var box = jQuery(this);
     if (box.is(":checked")) {
       // the name of the box is retrieved using the .attr() method
       // as it is assumed and expected to be immutable
       var group = "input:checkbox[name='" + box.attr("name") + "']";
       // the checked state of the group/box on the other hand will change
       // and the current value is retrieved using .prop() method
       jQuery(group).prop("checked", false);
       box.prop("checked", true);
     } else {
       box.prop("checked", false);
     }
   
     setTimeout(function(){ 
       var value = jQuery("input[name='my-cities']").val();
       if ( value.length > 2 ){
         jQuery("#btnReset1").css("display", "block");  
       }else{
        jQuery("#btnReset1").css("display", "none");
       }
   
       var value1 = jQuery("input[name='my-theme']").val();
       if ( value1.length > 2 ){
         jQuery("#btnReset").css("display", "block"); 
       }else{
        jQuery("#btnReset").css("display", "none");
       }
     }, 300); 
             
   });
    
    //code for video by Gaurav copy from https://codepen.io/JacobLett/pen/xqpEYE
   jQuery(document).ready(function() {
   // Gets the video src from the data-src on each button
   var $videoSrc;  
   jQuery('.video-btn').click(function() {
       $videoSrc = jQuery(this).data( "src" );
   });
   console.log($videoSrc); 
     
   // when the modal is opened autoplay it  
   jQuery('#myModal').on('shown.bs.modal', function (e) {
       
   // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
   jQuery("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" ); 
   }) 
   // stop playing the youtube video when I close the modal
   jQuery('#myModal').on('hide.bs.modal', function (e) {
       // a poor man's stop video
      jQuery("#video").attr('src',$videoSrc); 
   }) 
   // document ready  
   });
   
   
   
</script>
<?php endif; ?>