'use strict';
/* global varriable */
var totalPrice      = 0;
var isMapCallOnce   = false;
var countryList     = '';
var themeList       = '';
var filters         = {};
var monthArray      = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
var monthStringToNumber = {
  'Jan'     : '1',
  'Feb'     : '2',
  'Mar'     : '3',
  'Apr'     : '4',
  'May'     : '5',
  'Jun'     : '6',
  'Jul'     : '7',
  'Aug'     : '8',
  'Sep'     : '9',
  'Oct'     : '10',
  'Nov'     : '11',
  'Dec'     : '12'
};
// var isPriceOrDurationChange = false;
var isPriceChange           = false;
var isDurationChange        = false;

var customPopUp = {
  from : {
    month :0,
    year  :presentYear
  },
  to : {
    month:0,
    year :0
  }
};
var isFirtTimeLoad = true;
var isMobileView = (window.innerWidth < 568)?true:false;
/* global varriable */

/* global common functions */

function getTourIdByPageId(pageId){
  let tourId = 0;
  jQuery.each(pageTourArray,function(ind,val) {
    if(val.pageId == pageId){
      tourId = val.tourId;
    }
  });
  return parseInt(tourId);
}

function getPageIdByTourId(tourId){
  let pageId = 0;
  jQuery.each(pageTourArray,function(ind,val) {
    if(val.tourId == tourId){
      pageId = val.pageId;
    }
  });
  return parseInt(pageId);
}

function getSlugByPageId(pageId){
  let slug = '';
  jQuery.each(pageTourArray,function(ind,val) {
    if(val.pageId == pageId){
      slug = val.slug;
    }
  });
  return slug;
}

function getSlugByTourId(tourId){
  let slug = '';
  jQuery.each(pageTourArray,function(ind,val) {
    if(val.tourId == tourId){
      slug = val.slug;
    }
  });
  return slug;
}

function updateAnualCalendarFlag(tourId){
  let flag = false;
  jQuery.each(pageTourArray,function(ind,val) {
    if(val.tourId == tourId){
      flag = val.isAnnualCalendar;
    }
  });
  return flag;
}

/* global common functions */

/* Inititate common varriable */

jQuery( function() {
  // jQuery('#exampleModalr66').remove();
  jQuery('.Tour-dates > h5').html('Please select a date');
  jQuery('.price-per-person > h6').html('');
  jQuery('.price-per-person > label').text('Total Price');

  jQuery.when(
		getDataList('language'),
		getDataList('theme'),
		getDataList('tourType'),
		getDataList('countries'),
		getDataList('physicalRating')
  ).then(getCustomHeaderPluginData);

  checkFavouriteIsActiveOnTourPageOnly();

  getTourDetail();
  updateFavPageData();
  getTourFilterPluginData();

  if(getLocalStorageData('favArray').length > 0){
    updateFavHtml(getLocalStorageData('favArray'));
  }else{
    updateFavHtml([]);
  }
  //cron();

  // work only for tour pages

  if(jQuery( "#datepicker-2" ).length > 0){
    tourObject.tourId = getTourIdByPageId(tourObject.pageId);
    tourObject.isAnnualCalendar = updateAnualCalendarFlag(tourObject.tourId);

    jQuery('#menu1').append('<div class="search-loader-outer"><div class="search-loader"></div></div>');
    if(tourObject.isAnnualCalendar){
      console.log('Annual calendar');
      getCalendarPrice();

    }else{
      console.log('Month calendar');
      // initiate calendar
      jQuery( "#datepicker-2" ).datepicker({
        firstDay: 1,
        dayNamesMin: [ "SUN","MON", "TUE", "WED", "THU", "FRI", "SAT"],
        minDate : new Date(),
        dateFormat: 'yy-mm-dd',
        onSelect: function(date, inst){
          inst.inline       = false;
          let dateArry      = date.split('-');
          calendarDay       = parseInt(dateArry[2]);
          if(isClickOnSelectedDate(calendarDay)){
            calendarDay = 0;
            getCalendarPrice();
            return false;
          }
          updateTourInterval(date,totalTourDay);


          setCalendarPrice(lastResult,lastPrefix,calendarDay);

          jQuery(".bg-color-bt").removeClass('disabled-link');
          if(jQuery('.ui-datepicker-prev').hasClass('ui-state-disabled')){
            jQuery('.ui-datepicker-prev').css('display','none');
          }

        },
        onChangeMonthYear: function (year,month,datepicker) {
          calendarDay   = 0;          
          calendarMonth = parseInt(month);
          calendarYear  = parseInt(year);
          getCalendarPrice();          
        }
      });

    }
    initiateReadMoreReadLess();
    whereYouCanStaySlider();

    let urlData     = new URL(window.location.href);

    let paramPerson = getLocalStorageData('person') == [] ? 1 : getLocalStorageData('person');
    getLowestPrice(tourObject.tourId,paramPerson,2,1).then(function(res){
      if(res.status){
        jQuery('.price-text > p > span ').html(lastPrefix + formatNumber(res.data));
      }else{
        jQuery('.price-text > p > span ').html(lastPrefix + '0');
      }
    });

    youMayAlsoLikeSlider();
    // work only for tour pages
    setTimeout(function() {
      youMayAlsoLikeLink(paramPerson);
    }, 3000);


  }

  //paginationSetup();


});

/* scrolling events */
// work on scrolling.
window.onscroll = function() {
  let windowOffset = window.pageYOffset;
  if (windowOffset > headerOffsetTop) {
    headerElem.addClass("sticky");
  } else {
    headerElem.removeClass("sticky");
  }
};

/* ---------scrolling events end ---------------*/


/* click events */

//for manipulating tabs on product page
jQuery('#myHeader .nav-tabs li a').click(function(e){
  e.preventDefault();
  e.stopImmediatePropagation();
  jQuery(this).tab('show');
  let tabId = jQuery(this).attr('href');
  if(jQuery('#myHeader').hasClass('sticky')){
    jQuery("html, body").animate({ scrollTop: headerOffsetTop }, 1000);
  }
  if(tabId == '#menu1'){

    jQuery('.widget-contact-part #text-2').css('display','none');
  }else{
    jQuery('.widget-contact-part #text-2').css('display','block');
  }
  if(tabId=='#menu4')
    initiateMap();
});


jQuery('.mg-listsz').click(function(){
  var el = jQuery(this);
  jQuery('#tourCityModal').modal('show');
  openCityImageModal(el);
});

// read more and read less
jQuery(document).on('click','.readInstance',function(){
  if(jQuery(this).attr('data-show') == 1){
    jQuery(this).text(readSetting.moretext);
    jQuery(this).closest('.day-bottom-box').find('div[id^=more]').css('display','none');
    jQuery(this).attr('data-show',0);
  }else{
    jQuery(this).text(readSetting.lesstext);
    jQuery(this).attr('data-show',1);
    jQuery(this).closest('.day-bottom-box').find('div[id^=more]').css('display','block');
  }
});

jQuery(document).on('click','.ui-datepicker-title',function(){

  let localCalendarDate = jQuery( "#datepicker-2" ).val();
  let datePieces = localCalendarDate.split('-');
  let month = parseInt(calendarMonth) > 0 ? parseInt(calendarMonth) : datePieces[1];
  let day   = datePieces[2];
  let year  = parseInt(calendarYear) > 0 ? parseInt(calendarYear) : datePieces[0];

  if(presentYear == year){
    jQuery('.year-month>.pull-left').addClass('disable');
    updateCustomCalendar(month,year,presentMonth);
  }else{
    jQuery('.year-month>.pull-left').removeClass('disable');
    updateCustomCalendar(month,year);
  }
  jQuery('.month_ul > li').each(function(){
    let this$ = jQuery(this);
    let month = parseInt(this$.attr('data-value'));
    let currentCalendarDate = new Date(year, month - 1, 1, 0, 0, 0);
    let currentDate = new Date();
    if (tourObject.departures && tourObject.departures.length) {
      var isMonthAvailable = false;
      for (var i = 0; i <= tourObject.departures.length - 1; i++) {
        let departure = tourObject.departures[i];
        let startDepartureDate = new Date(departure.startDate);        
        startDepartureDate.setHours(0);
        startDepartureDate.setMinutes(0);
        startDepartureDate.setSeconds(0);
        let endDepartureDate = new Date(departure.endDate);       
        endDepartureDate.setHours(0);
        endDepartureDate.setMinutes(0);
        endDepartureDate.setSeconds(0);
        if (currentCalendarDate.getMonth() >= currentDate.getMonth() 
          && currentCalendarDate.getFullYear() >= currentDate.getFullYear() 
          && currentCalendarDate >= startDepartureDate && currentCalendarDate <= endDepartureDate) {
            isMonthAvailable = true;    
            break;
          };
      }
      if (!isMonthAvailable)
        this$.addClass('disabled');
    }    
    else if (month > tourObject.lastMonth) {
      this$.addClass('disabled');
    }
    // if(parseInt(jQuery(this).attr('data-value')) > tourObject.lastMonth){
    //   jQuery(this).addClass('disabled');
    // }
  })
  if(calendarYear == tourObject.lastYear){
    jQuery('.pull-right').addClass('disable');
  }
  // show Modal
  jQuery('#monthYearModal').modal('show');
});

jQuery(document).on('click','.pull-left',function(e){
  e.preventDefault();
  jQuery('.year-month>.pull-right').removeClass('disable');
  getCalendarPrice();
  let presentMonth  = new Date().getMonth()+1;
  let presentYear   = new Date().getFullYear();
  let year          = parseInt(jQuery(this).siblings('span').text());
  year              = year-1;
  if(year < presentYear){
    year = presentYear;
  }
  if(year == presentYear ){
    updateCustomCalendar(presentMonth,year,presentMonth);
    jQuery(this).addClass('disable');
    return false;
  }


  jQuery('.year-month>span').text(year);
});

jQuery(document).on('click','.pull-right',function(e){
  e.preventDefault();
  let year = parseInt(jQuery(this).siblings('span').text());
  if(year < tourObject.lastYear){
    year = year+1;
    getCalendarPrice();
    updateCustomCalendar(0,year);
    jQuery('.year-month>span').text(year);
    jQuery('.year-month>.pull-left').removeClass('disable');
  }
  if(year == tourObject.lastYear){
    jQuery(this).addClass('disable');
    jQuery('.month_ul > li').each(function(){
      if(parseInt(jQuery(this).attr('data-value')) > tourObject.lastMonth){
        jQuery(this).addClass('disabled');
      }
    })
  }
});

jQuery(document).on('click','.month_ul > li',function(e){
  e.preventDefault();
  if(calendarMonth == parseInt(jQuery(this).attr('data-value')) &&  calendarYear  == parseInt(jQuery('.year-month > span').text())){
    jQuery('#monthYearModal').modal('hide');
    return false;
  }
  jQuery(this).addClass('active');
  calendarMonth = 0;
  calendarYear = 0;
  calendarMonth = parseInt(jQuery(this).attr('data-value'));
  calendarYear  = parseInt(jQuery('.year-month > span').text());
  var localMonth = calendarMonth-1;
  jQuery('#datepicker-2').datepicker("setDate", new Date(calendarYear,localMonth,1));
  jQuery('#monthYearModal').modal('hide');
});
jQuery(document).on('click','.bt-box > a',function(e){
  e.preventDefault();
  jQuery("html, body").animate({ scrollTop: jQuery('#myHeader').offset().top }, 1000);
  jQuery('.nav-tabs a[href="#menu1"]').tab('show');
});
jQuery(document).on('click','.bg-color-bt',function(e){
  e.preventDefault();
  if(jQuery(this).hasClass('disabled-link')){
    jQuery('#dateNotSelect').modal('show');
  }else{
    openTourUrl();
  }
});

jQuery(document).on('click','.tour-enquiry > .container > .row > .col-md-6 >.col-md-6 > a',function(e){
  if(!(jQuery(this).hasClass('disabled-link'))){
    jQuery('#tourEnquiryModal').modal('show');
  }
});

jQuery(document).on('click','.tour-enquiry > .container > .row > .col-md-6 >.col-md-6 > a',function(e){
  if(!(jQuery(this).hasClass('bg-color-bt'))){
    jQuery('#tourEnquiryFormModal').modal('show');
    console.log(jQuery('.prodect-details-titel h4').html());
    jQuery("input[name=tourEnquiryTourName]").val(jQuery('.prodect-details-titel h4').html());
  }
});


// mouse on slider leave
// jQuery(document).on('mouseup','.ui-slider-handle ',function(){
//   isPriceOrDurationChange = true;
//   applyFilter();
// });

jQuery(document).on('mouseup','#durationRangeSlider .ui-slider-handle ',function(){
  isDurationChange = true;
  applyFilter();
});

jQuery(document).on('mouseup','#priceRangeSlider .ui-slider-handle ',function(){
  isPriceChange    = true;
  applyFilter();
});



/* ---------click events ---------------*/

/* function definations */



//maginfy city image in modal
function openCityImageModal(elem){
  let html       = elem.siblings('.carousel-inner').html();
  let indicators = elem.siblings('.carousel-indicators').children().clone();

  jQuery.each(indicators,function() {
    jQuery(this).attr('data-target','#tourCityModalSlide');
  });

  jQuery('#tourCityModalSlide > .carousel-indicators').html(indicators);
  jQuery('#tourCityModalSlide > .carousel-inner').html(html);

  //jQuery('#tourCityModalSlide').carousel();

}
//update popup calendar
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
function checkFavouriteIsActiveOnTourPageOnly(){
  if(jQuery('.price-text > .like-box > a:first').length > 0){
    let tourId = parseInt(getTourIdByPageId(pageId))
    let favArray = getLocalStorageData('favArray');
    if(favArray.length > 0){
      if(favArray.indexOf(tourId) > -1)
        jQuery('.price-text > .like-box > a:first').addClass('active');
    }
  }
}
function initiateReadMoreReadLess(){


  jQuery('button[id^="myBtn"]').each(function() {
    let parent     = jQuery(this).closest('.day-bottom-box');
    if(parent.find('div[id^=more]').length > 0){
      jQuery(this).replaceWith(readSetting.btnHtml);
    }else{
      jQuery(this).replaceWith('');
    }
  });
}

function changeHtml(res){

  var languageOption = '';
  var currencyOption = '';
  var personOption   = '';
  var childOption    = '';
  let paramPerson    = getLocalStorageData('person') == [] ? 2 : getLocalStorageData('person');

  if(res.language.length > 0){
    jQuery.each(res.language, function( ind, val ) {

      if(val.id==1){
        languageOption +='<option value="'+val.id+'" selected>'+val.name+'</option>';
      }else{
        languageOption +='<option value="'+val.id+'" >'+val.name+'</option>';
      }
    });
  }

  if(res.currency.length > 0){
    jQuery.each(res.currency, function( ind, val ) {
      let prefix = (val.cHTMLcode);
      if(val.id==2){
        currencyOption +='<option value="'+val.id+'" selected>'+prefix+' - '+val.name+'</option>';
      }else{
        currencyOption +='<option value="'+val.id+'" >'+prefix+' - '+val.name+'</option>';
      }
    });
  }

  for (var i = 1; i <= 12; i++) {
    if(i==paramPerson){
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
      '<div class="select-box" onchange="getCalendarPrice()">'+
      '<select name="numberofadults" >'
      +personOption+
      '</select>'+
      '</div>'+
      '</div>'+
      '<div class="number-of-travellers col-md-3" >'+
      '<label>Tour guide language:</label>'+
      '<div class="select-box" onchange="getCalendarPrice()">'+
      '<select name="language" >'
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

function createAnnualCalendar(res){
  let monthList       = [];
  let monthRow        = {};
  let monthColoumn    = '';
  let tableRow        = [[],[],[],[],[],[],[],[],[],[],[],[]];
  let endYear         = new Date();
  let totalRow        = 0;
  let personCount     = jQuery('select[name="numberofadults"]').val();
  for (var i = 0 ; i < monthArray.length; i++) {
    monthColoumn += '<th>'+monthArray[i].toUpperCase()+'</th>';
  }

  if(res.status){
    const result        = res.data.result;
    endYear             = (res.endingDate != null ) ? new Date(res.endingDate).getFullYear():presentYear;



    jQuery.each(res.data.result, function( i, val ) {
      let m = new Date(i).getMonth()+1;
      if(monthList.indexOf(m)== -1){
        monthList.push(m);
        monthRow[m] = [];
        let pricePerPerson = formatNumber(Math.round(val.price/personCount));
        monthRow[m].push({date:i,price:val.price,pricePerPerson:pricePerPerson,class:val.class});
      }else{
        let pricePerPerson = formatNumber(Math.round(val.price/personCount));
        monthRow[m].push({date:i,price:val.price,pricePerPerson:pricePerPerson,class:val.class});
      }
    });




    jQuery.each(monthRow, function( i, val ) {
      if(val.length > totalRow)
        totalRow = val.length;
    });
  }else{

  }
  let annualHtml =
      `
    <div class="table-box">
      <div class="container">

        <div class="calender-top">
          <a href="javascript:void(0)" onclick="changeYearInAnnualCalendar('prev')" class="`+((presentYear >= calendarYear) ? 'hidden' :'' )+`"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
          <div class="calender-title"> <span class="calender-year">`+calendarYear+`</span> </div>
          <a href="javascript:void(0)" onclick="changeYearInAnnualCalendar('next')" class="`+((endYear <= calendarYear) ? 'hidden' :'' )+`"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
        </div>
        <table class="annual-calender-table">
           <thead>
              <tr>
                 `+monthColoumn+`
              </tr>
           </thead>
           <tbody>
              `+createAnuualCalendarRows(totalRow,monthRow,res.prefix,res.totalTourDays)+`
           </tbody>
        </table>
        <div class="bottom-calender">

          <div class="row">
            <div class="col-md-4">
               <div class="Tour-dates">
                  <label>Tour dates:</label>
                  <h5></h5>
               </div>
            </div>
            <div class="col-md-4">
               <div class="price-per-person">
                  <label>Total Price</label>
                  <h3>£-</h3>
                  
               </div>
            </div>
            <div class="col-md-4">
               <div class="price-per-color">
                  <ul>
                     <li>
                        <span></span> <label>from</label><br>
                        <h5><i class="fa fa-spinner"></i></h5>
                        <p>per person</p>
                     </li>
                     <li>
                        <span style="background:rgb(237, 147, 29) ;"></span> <label>from</label><br>
                        <h5><i class="fa fa-spinner"></i></h5>
                        <p>per person</p>
                     </li>
                     <li>
                        <span style="background:rgb(205, 7, 30);"></span> <label>from</label><br>
                        <h5><i class="fa fa-spinner"></i></h5>
                        <p>per person</p>
                     </li>
                  </ul>
               </div>
            </div>
          </div>
        <div>

      </div>
    </div>
    `;

  let parent  = jQuery( "#menu1 >.date-box >.container " );
  parent.empty();
  parent.html(annualHtml);
  setFunctionalComponentOfCalendar(res);
  jQuery(".search-loader").hide();
  jQuery(".search-loader-outer").hide();
  if(res.prefix != null)
    jQuery('.price-per-person > h3').html(res.prefix+'-');
}

function createAnuualCalendarRows(totalRow,monthRow,prefix,totalTourDay){
  let tr = '';
  if(totalRow == 0){
    return tr;
  }
  for (var i = 0; i < totalRow; i++) {
    tr += '<tr>';
    if(monthRow[1] != null){
      tr += (monthRow[1][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[1][i].class}','${prefix}','${monthRow[1][i].price}','${monthRow[1][i].date}','${totalTourDay}')" class="${monthRow[1][i].class} ${((new Date() > new Date(monthRow[1][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[1][i].date).getDate()} <p> ${prefix} ${monthRow[1][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;
    }else{
      tr +='<td class="border-none"></td>'
    }
    if(monthRow[2] != null){

      tr += (monthRow[2][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[2][i].class}','${prefix}','${monthRow[2][i].price}','${monthRow[2][i].date}','${totalTourDay}')" class="${monthRow[2][i].class} ${((new Date() > new Date(monthRow[2][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[2][i].date).getDate()} <p> ${prefix} ${monthRow[2][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;

    }else{
      tr +='<td class="border-none"></td>'
    }
    if(monthRow[3] != null){

      tr += (monthRow[3][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[3][i].class}','${prefix}','${monthRow[3][i].price}','${monthRow[3][i].date}','${totalTourDay}')" class="${monthRow[3][i].class} ${((new Date() > new Date(monthRow[3][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[3][i].date).getDate()} <p> ${prefix} ${monthRow[3][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;

    }else{
      tr +='<td class="border-none"></td>'
    }
    if(monthRow[4] != null){
      tr += (monthRow[4][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[4][i].class}','${prefix}','${monthRow[4][i].price}','${monthRow[4][i].date}','${totalTourDay}')" class="${monthRow[4][i].class} ${((new Date() > new Date(monthRow[4][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[4][i].date).getDate()} <p> ${prefix} ${monthRow[4][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;

    }else{
      tr +='<td class="border-none"></td>'
    }
    if(monthRow[5] != null){
      tr += (monthRow[5][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[5][i].class}','${prefix}','${monthRow[5][i].price}','${monthRow[5][i].date}','${totalTourDay}')" class="${monthRow[5][i].class} ${((new Date() > new Date(monthRow[5][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[5][i].date).getDate()} <p> ${prefix} ${monthRow[5][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;

    }else{
      tr +='<td class="border-none"></td>'
    }
    if(monthRow[6] != null){
      tr += (monthRow[6][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[6][i].class}','${prefix}','${monthRow[6][i].price}','${monthRow[6][i].date}','${totalTourDay}')" class="${monthRow[6][i].class} ${((new Date() > new Date(monthRow[6][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[6][i].date).getDate()} <p> ${prefix} ${monthRow[6][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;

    }else{
      tr +='<td class="border-none"></td>'
    }
    if(monthRow[7] != null){
      tr += (monthRow[7][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[7][i].class}','${prefix}','${monthRow[7][i].price}','${monthRow[7][i].date}','${totalTourDay}')" class="${monthRow[7][i].class} ${((new Date() > new Date(monthRow[7][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[7][i].date).getDate()} <p> ${prefix} ${monthRow[7][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;

    }else{
      tr +='<td class="border-none"></td>'
    }
    if(monthRow[8] != null){
      tr += (monthRow[8][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[8][i].class}','${prefix}','${monthRow[8][i].price}','${monthRow[8][i].date}','${totalTourDay}')" class="${monthRow[8][i].class} ${((new Date() > new Date(monthRow[8][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[8][i].date).getDate()} <p> ${prefix} ${monthRow[8][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;

    }else{
      tr +='<td class="border-none"></td>'
    }
    if(monthRow[9] != null){
      tr += (monthRow[9][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[9][i].class}','${prefix}','${monthRow[9][i].price}','${monthRow[9][i].date}','${totalTourDay}')" class="${monthRow[9][i].class} ${((new Date() > new Date(monthRow[9][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[9][i].date).getDate()} <p> ${prefix} ${monthRow[9][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;

    }else{
      tr +='<td class="border-none"></td>'
    }
    if(monthRow[10] != null){
      tr += (monthRow[10][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[10][i].class}','${prefix}','${monthRow[10][i].price}','${monthRow[10][i].date}','${totalTourDay}')" class="${monthRow[10][i].class} ${((new Date() > new Date(monthRow[10][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[10][i].date).getDate()} <p> ${prefix} ${monthRow[10][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;

    }else{
      tr +='<td class="border-none"></td>'
    }
    if(monthRow[11] != null){
      tr += (monthRow[11][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[11][i].class}','${prefix}','${monthRow[11][i].price}','${monthRow[11][i].date}','${totalTourDay}')" class="${monthRow[11][i].class} ${((new Date() > new Date(monthRow[11][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[11][i].date).getDate()} <p> ${prefix} ${monthRow[11][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;

    }else{
      tr +='<td class="border-none"></td>'
    }
    if(monthRow[12] != null){
      tr += (monthRow[12][i] != null ) ? `<td onclick="setAnnualCalendarDate(this,'${monthRow[12][i].class}','${prefix}','${monthRow[12][i].price}','${monthRow[12][i].date}','${totalTourDay}')" class="${monthRow[12][i].class} ${((new Date() > new Date(monthRow[12][i].date)) ? ' disabled':'') } "> ${new Date(monthRow[12][i].date).getDate()} <p> ${prefix} ${monthRow[12][i].pricePerPerson} </p></td>`:`<td class="border-none"></td>`;
    }else{
      tr +='<td class="border-none"></td>'
    }
    tr += '</tr>';

  }
  return tr;
}

function changeYearInAnnualCalendar(type){
  if(type=='prev'){
    calendarYear--;
  }else{
    calendarYear++;
  }
  getAnnualCalendarPrice();

}
function setAnnualCalendarDate(elem,className,prefix,price,selectedDate,totalTourDay){
  calendarDay = new Date(selectedDate).getDate();
  calendarMonth = new Date(selectedDate).getMonth()+1;
  jQuery('.annual-calender-table td').removeClass('selected');
  elem.classList.add('selected');
  totalPrice = formatNumber(price);
  jQuery('.price-per-person').removeClass('green-border').removeClass('yellow-border').removeClass('red-border');
  jQuery('.price-per-person').addClass(className);
  jQuery('.price-per-person > h3').html(prefix + formatNumber(price));
  jQuery('.price-per-person > h6').html('');
  jQuery(".bg-color-bt").removeClass('disabled-link');


  updateTourInterval(selectedDate,totalTourDay);


}
function updateTourInterval(tourDayStart,totalTourDay){
  totalTourDay = parseInt(totalTourDay);
  if(totalTourDay > 0){
    let startDate = new Date(tourDayStart);
    let endDate   = new Date(startDate.setDate(startDate.getDate() + totalTourDay));
    let startDateDay    = new Date(tourDayStart).getDate();
    let startDateMonth  = new Date(tourDayStart).getMonth();
    let startDateYear  = new Date(tourDayStart).getFullYear();
    let endDateDay      = endDate.getDate();
    let endDateMonth    = endDate.getMonth();
    let endDateYear     = endDate.getFullYear();
    if(startDateYear == endDateYear){
      jQuery('.Tour-dates > h5').html(startDateDay+getOrdinalNum(startDateDay)+' '+monthsArray[startDateMonth]+' - '+endDateDay+getOrdinalNum(endDateDay)+' '+ monthsArray[endDateMonth]+' '+endDateYear);
    }else{
      jQuery('.Tour-dates > h5').html(startDateDay+getOrdinalNum(startDateDay)+' '+monthsArray[startDateMonth]+' '+startDateYear+' - '+endDateDay+getOrdinalNum(endDateDay)+' '+ monthsArray[endDateMonth]+' '+endDateYear);
    }
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

function getCalendarPrice(){
  jQuery( ".bg-color-bt").addClass('disabled-link');

  jQuery(".search-loader").show();
  jQuery(".search-loader-outer").show();
  if(calendarDay == 0){
    jQuery('.Tour-dates > h5').html('Please select a date');
    jQuery('.price-per-person > h6').html('');
  }

  if(tourObject.isAnnualCalendar){
    getAnnualCalendarPrice();
    return false;
  }

  let today = presentYear+'-'+presentMonth+'-'+presentDay.getDate();

  let calendarApiData = {
    tourId   :tourObject.tourId,
    pageId   :tourObject.pageId,
    month    :calendarMonth,
    year     :calendarYear,
    today    :today,
    person   :jQuery('select[name="numberofadults"]').val(),
    child    :jQuery('select[name="numberofchild"]').val(),
    lng      :jQuery('select[name="language"]').val(),
    currency :jQuery('select[name="currency"]').val(),
    action   :'getTourCost'
  };
  tourObject.language = calendarApiData.lng;
  tourObject.currency = calendarApiData.currency;
  tourObject.person   = calendarApiData.person;

  localStorage.setItem('person',calendarApiData.person);

  getLowestPrice(tourObject.tourId,calendarApiData.person,2,1).then(function(res){
    if(res.status){
      jQuery('.price-text > p > span ').html(lastPrefix + formatNumber(res.data));
    }else{
      jQuery('.price-text > p > span ').html(lastPrefix + '0');
    }
  });

  youMayAlsoLikeLink(calendarApiData.person);

  jQuery.ajax({
    url: '/custom-code/api/index.php',
    type: 'GET',
    dataType: "json",
    data: calendarApiData
  }).done(function(data){
    if(data.endingDate != undefined && data.endingDate != null && data.endingDate != ''){
      tourObject.lastMonth = new Date(data.endingDate).getMonth()+1;
      tourObject.lastYear  = new Date(data.endingDate).getFullYear();
    }else{
      tourObject.lastMonth = calendarMonth;
      tourObject.lastYear  = calendarYear;
    }
    if(data.status){
      /* updating varriables*/
      totalTourDay        = parseInt(data.totalTourDays);
      lastResult          = data.data.result;
      lastPrefix          = data.prefix;
      tourObject.currCode = data.prefix;
      tourObject.departures = data.departures;


      /* updating varriables*/
      //set calendar price

      if(calendarDay > 0){
        setCalendarPrice(data.data.result,data.prefix,calendarDay);
      }else{
        setCalendarPrice(data.data.result,data.prefix,null);
        jQuery('.price-per-person > h3').html(data.prefix+'-');
      }

      //set values in other parts of page
      setFunctionalComponentOfCalendar(data);





      if(data.beginning != undefined && data.beginning != null && data.beginning != '' && calendarMonth == new Date(data.beginning).getMonth()+1){
        jQuery('.ui-datepicker-header > .ui-datepicker-prev').addClass('ui-state-disabled').addClass('disabled');
      }
     
      if(data.beginning != undefined && data.beginning != null && data.beginning != '' && calendarYear == (new Date(data.beginning).getFullYear()-1)){
        jQuery('.pull-left').addClass('disabled');
      }
     
      //hide back event only in calendar
      if(jQuery('.ui-datepicker-prev').hasClass('ui-state-disabled')){
        jQuery('.ui-datepicker-prev').css('display','none');
      }

    
      if(calendarMonth == (new Date(data.endingDate).getMonth()+1) && calendarYear == new Date(data.endingDate).getFullYear()){       
        jQuery('.ui-datepicker-header > .ui-datepicker-next').addClass('ui-state-disabled').addClass('disabled');        
        jQuery('.ui-datepicker-next').css('display','none');

      }

    }else{      
      if(calendarMonth == (new Date(data.endingDate).getMonth()+1) && calendarYear == new Date(data.endingDate).getFullYear()){
        jQuery('.ui-datepicker-header > .ui-datepicker-prev').addClass('ui-state-disabled').addClass('disabled');
        jQuery('.ui-datepicker-header > .ui-datepicker-next').addClass('ui-state-disabled').addClass('disabled');
        jQuery('.pull-left').addClass('disabled');
      }
      if (data.firstAvailableDepartureDate)
      {
        let firstAvailableDepartureDate = new Date(data.firstAvailableDepartureDate);
        jQuery( "#datepicker-2" ).datepicker("option", "minDate", firstAvailableDepartureDate);          
      }      
    }

    jQuery(".search-loader").hide();
    jQuery(".search-loader-outer").hide();
  });
}

function setFunctionalComponentOfCalendar(data){
  if(data.status == 0){
    return false;
  }
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

}
function getAnnualCalendarPrice(){
  jQuery(".search-loader").show();
  jQuery(".search-loader-outer").show();
  let today     = presentYear+'-'+presentMonth+'-'+presentDay;

  let calendarApiData = {
    tourId   :tourObject.tourId,
    pageId   :tourObject.pageId,
    month    :calendarMonth,
    year     :calendarYear,
    today    :today,
    person   :jQuery('select[name="numberofadults"]').val(),
    child    :jQuery('select[name="numberofchild"]').val(),
    lng      :jQuery('select[name="language"]').val(),
    currency :jQuery('select[name="currency"]').val(),
    lowest   : true,
    action   :'getTourYearlyCost'
  };
  tourObject.language = calendarApiData.lng;
  tourObject.currency = calendarApiData.currency;
  tourObject.person   = calendarApiData.person;


  jQuery.ajax({
    url: '/custom-code/api/index.php',
    type: 'GET',
    dataType: "json",
    data: calendarApiData
  }).done(function(data){
    console.log(data);
    createAnnualCalendar(data);
  });
}

function setCalendarPrice(response,prefix,selectedDate=null){
  jQuery( "#datepicker-2" ).datepicker('refresh');
  jQuery(".ui-datepicker-calendar TBODY td a").each(function(){
    let elem      = jQuery(this);
    let parentElem= elem.closest('td');
    let index     = elem.text();
    let personCount = jQuery('select[name="numberofadults"]').val();

    if(selectedDate != null){
      if(index == selectedDate){
        parentElem.addClass('selected');
        totalPrice = formatNumber(response[index].price);
        jQuery('.price-per-person').removeClass('green-border').removeClass('yellow-border').removeClass('red-border');
        jQuery('.price-per-person').addClass(response[index].class);
        // let pricePerPerson = Math.round(response[index].price/jQuery('select[name="numberofadults"]').val());
        jQuery('.price-per-person > h3').html(prefix + formatNumber(response[index].price));
        jQuery('.price-per-person > h6').html('');
      }
    }
    if( response[index]!= undefined && response[index] !== null && response[index]!='' ){
      parentElem.addClass(response[index].class);
      parentElem.append('<p>'+prefix+' '+formatNumber(Math.round(response[index].price/personCount))+'</p>');
    }else{
      parentElem.replaceWith('<td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">'+index+'</span></td>');
    }

  });
}

function isClickOnSelectedDate(selectedDay){
  let flag = false;
  jQuery(".ui-datepicker-calendar TBODY td a").each(function(){
    if(jQuery(this).text() == selectedDay){
      if(jQuery(this).closest('td').hasClass('selected')){
        flag = true;
      }
    }
  });
  return flag;
}

function getCurrencyAndLanguageList(){
  if(selectedTourId != undefined && selectedTourId != null && selectedTourId != 'null'){

    jQuery.ajax({
      url: '/custom-code/api.php?all=true&tourId='+selectedTourId,
      type: 'GET',
      dataType: "json"
    }).done(function(res){
      if(res.status){
        changeHtml(res.data);
        if(pageId != '' && pageId != undefined && pageId != null)
          getCalendarPrice();
      }
    });
  }
}

function initiateMap(){
  if(isMapCallOnce){
    return true;
  }
  jQuery.ajax({
    url: '/custom-code/api.php?tourId='+selectedTourId,
    type: 'GET',
    dataType: "json"
  }).done(function(res){
    if(res.status){
      isMapCallOnce = true
      initMap(res.data);
    }
  });

}

window.initMap = function(cityData) {

  if(cityData.origin.cName!= '' && cityData.origin.cName!= null  && cityData.origin.cName!= undefined && cityData.destination.location!= '' && cityData.destination.location!= null  && cityData.destination.location!= undefined && cityData.origin.cName!= cityData.destination.location){
    jQuery('#productdetailsgooglemap').prev('div').html('<p>See how far your journey will take you with our useful map feature.Travelling from A to B, you can learn more about the route you will be taking and get your bearings before you leave. What’s more, you can even find new and exciting destinations to explore along the way.<p>Your tour will start in (A) '+cityData.origin.cName+' and end in (B) '+cityData.destination.location+' <p>');
  }else{
    jQuery('#productdetailsgooglemap').prev('div').html( '<div style="clear:both"></div>');
  }

  const directionsService = new google.maps.DirectionsService();
  const directionsRenderer = new google.maps.DirectionsRenderer();
  const map = new google.maps.Map(document.getElementById("productdetailsgooglemap"), {
    zoom: 12,
    center: { lat: 0, lng: 0 },
    mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
      position: google.maps.ControlPosition.TOP_CENTER,
    },
    zoomControl: true,
    zoomControlOptions: {
      position: google.maps.ControlPosition.LEFT_CENTER,
    },
    scaleControl: true,
    streetViewControl: true,
    streetViewControlOptions: {
      position: google.maps.ControlPosition.LEFT_TOP,
    },
    fullscreenControl: true,
  });

  //for marker remove
  directionsRenderer.setMap(map);
  directionsRenderer.setOptions({ suppressMarkers: true });
  //

  calculateAndDisplayRoute(directionsService, directionsRenderer,cityData,map);

}

function calculateAndDisplayRoute(directionsService, directionsRenderer,cityData,map) {
  const infoWindow = new google.maps.InfoWindow();
  let waypoint = [];
  jQuery.each(cityData.waypoint, function( ind, val ) {
    waypoint.push({location:new google.maps.LatLng(val.lat,val.lng),stopover:true});
  });
  directionsService
      .route({
        origin: new google.maps.LatLng(cityData.origin.lat,cityData.origin.lng),
        destination: new google.maps.LatLng(cityData.destination.lat,cityData.destination.lng),
        waypoints: waypoint,
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.IMPERIAL
      })
      .then((response) => {
        directionsRenderer.setDirections(response);

        let oMarker = new google.maps.Marker({
          position: new google.maps.LatLng(cityData.origin.lat,cityData.origin.lng),
          label:'A',
          map: map,
          title: cityData.origin.cName
        });

        google.maps.event.addListener(oMarker, "click", function(evt) {
          infoWindow.setContent(this.get('title'));
          infoWindow.open(map,this);
        });

        jQuery.each(cityData.waypoint, function( ind, val ) {
          let wMarker = new google.maps.Marker({
            position: new google.maps.LatLng(val.lat,val.lng),
            map: map,
            title: val.location
          });
          google.maps.event.addListener(wMarker, "click", function(evt) {
            infoWindow.setContent(this.get('title'));
            infoWindow.open(map,this);
          });
        });
        let dMarker = new google.maps.Marker({
          position: new google.maps.LatLng(cityData.destination.lat,cityData.destination.lng),
          label:'B',
          map: map,
          title: cityData.destination.location
        });
        google.maps.event.addListener(dMarker, "click", function(evt) {
          infoWindow.setContent(this.get('title'));
          infoWindow.open(map,this);
        });




      })
      .catch((e) => {
        console.log(e);
      });
}



function getTourDetail(){
  jQuery.ajax({
    url: '/custom-code/api.php?pageId='+pageId,
    type: 'GET',
    dataType: "json"
  }).done(function(res){
    if(res.status){
      selectedTourId    = res.data.tourId;
      selectedTourName  = res.data.tourName;
      getCurrencyAndLanguageList();

    }
  });
}

function whereYouCanStaySlider() {
  let html12  = jQuery('.stye.net-bardy').find('.carousel.slide.show-mobile .carousel-inner');
  let sliderId = jQuery('.stye.net-bardy').find('.carousel.slide.show-mobile').attr('id');

  jQuery( ".stye.net-bardy .carousel.slide.show-mobile .carousel-indicators" ).remove();

  jQuery('<ol class="carousel-indicators"></ol>').appendTo('.stye.net-bardy .carousel.slide.show-mobile');

  if(html12.length > 0){
    for(var i=0 ; i< html12[0].childElementCount ; i++) {
      jQuery('<li data-target="#'+sliderId+'" data-slide-to="'+i+'"></li>').appendTo('.stye.net-bardy .carousel.slide.show-mobile .carousel-indicators');
    }
  }
  jQuery('.stye.net-bardy .carousel.slide.show-mobile .carousel-indicators > li').first().addClass('active');

  let sliderhtml = jQuery('.stye.net-bardy').find('.carousel.slide.show-desktop .carousel-inner');
  sliderhtml.find('.carousel-slider__post-header a' ).attr('href','javascript:void(0)');
  html12.find('.carousel-slider__post-header a' ).attr('href','javascript:void(0)');
}

function youMayAlsoLikeSlider() {
  let html12  = jQuery('.last-slider-bg.net-bardy').find('.carousel.slide.show-mobile .carousel-inner');

  let sliderId = jQuery('.last-slider-bg.net-bardy').find('.carousel.slide.show-mobile').attr('id');

  jQuery( ".last-slider-bg.net-bardy .carousel.slide.show-mobile .carousel-indicators" ).remove();

  jQuery('<ol class="carousel-indicators"></ol>').appendTo('.last-slider-bg.net-bardy .carousel.slide.show-mobile');

  if(html12.length > 0){
    for(var i=0 ; i< html12[0].childElementCount ; i++) {
      jQuery('<li data-target="#'+sliderId+'" data-slide-to="'+i+'"></li>').appendTo('.last-slider-bg.net-bardy .carousel.slide.show-mobile .carousel-indicators');
    }
  }

  jQuery('.last-slider-bg.net-bardy .carousel.slide.show-mobile .carousel-indicators > li').first().addClass('active');

  let favArray = getLocalStorageData('favArray');

  if(favArray.length > 0){
    jQuery('.last-slider-bg').find('.like-box').each(function(){
      let elemBox     = jQuery(this).closest('.carousel-slider__post');
      let tempTourId  = parseInt(elemBox.find('input').val());

      if(favArray.indexOf(tempTourId) > -1){
        jQuery(this).children('a:first').addClass('active');
      }
      jQuery(this).children('a:first').attr('data-page','tourPage');

    })
  }else{
    jQuery('.last-slider-bg').find('.like-box').each(function(){
      jQuery(this).children('a:first').attr('data-page','tourPage')
    });
  }


}

function openTourUrl(){
  let personCount = jQuery('select[name="numberofadults"]').val();
  let lng         = jQuery('select[name="language"]').val();
  let icon        = jQuery.parseHTML(lastPrefix);
  let currencyId = jQuery('select[name="currency"]').val();
    
  let url = location.origin + '/tours/tour-request?pax='+personCount+'&lang='+lng+'&ddate='+calendarDay+' '+ monthArray[calendarMonth-1]+' '+calendarYear+'&tname='+selectedTourName+'&tid='+selectedTourId+'&price='+icon[0].data+totalPrice+'&cur='+currencyId;

  window.open(url, '_blank');
}
// search page js
jQuery(document).on('click','div.tour-tags label',function(){
  jQuery(this).toggleClass("active");
  applyFilter();
});



function getDataList(type){
  return jQuery.ajax({
    url: '/custom-code/api/index.php?action='+type,
    type: 'GET',
    dataType: "json"
  }).done(function(res){
    if(res.status){
      filterHtml(res.data,type);
    }
  });
}

function filterHtml(res,type){

  var languageOption       = '';
  var themeOption          = '';
  var countriesOption      = '';
  var tourTagsOption       = '';
  var cityOption           = '';
  var physicalRatingOption = '';

  var homeThemeOption      = '';
  var homeCountriesOption  = '';
  var tourTypeOption       = '';

  var searchParams = new URLSearchParams(window.location.search);
  jQuery("div#collapseOnedat").addClass('in');
  if(searchParams.get('fromToDateInput') != undefined && searchParams.get('fromToDateInput') != null && searchParams.get('fromToDateInput') != ''){
    let inputDate = searchParams.get('fromToDateInput');
    jQuery("input[name=fromToDateInput]").val(inputDate);

    let inputDateArray     = inputDate.split(" - ");
    let fromArray          = inputDateArray[0].split(" ");
    let toArray            = inputDateArray[1].split(" ");
    customPopUp.from.month = parseInt(monthStringToNumber[fromArray[0]]);
    customPopUp.from.year  = parseInt(fromArray[1]);
    customPopUp.to.month   = parseInt(monthStringToNumber[toArray[0]]);
    customPopUp.to.year    = parseInt(toArray[1]);

  }else{
    //jQuery("input[name=fromToDateInput]").val('');
  }

  switch (type) {
    case 'language':
      if(res.length > 0){
        jQuery.each(res, function( ind, val ) {
          if(val.languageID_Admin == 1){
            languageOption +='<option value="'+val.languageID_Admin +'" selected="selected">'+val.lName+'</option>';
          }else{
            languageOption +='<option value="'+val.languageID_Admin +'" >'+val.lName+'</option>';
          }
        });
      }
      var languageHtml = '<select class="lop-ol" name="language" onchange="applyFilter()">'
          +languageOption+
          '</select>';
      jQuery("div#collapseLanguage select").html('');
      jQuery("div#collapseLanguage select").html(languageHtml);
      break;
    case 'theme':
      if(res.length > 0){
        jQuery("div#collapseTheme").addClass('in');
        themeList = res
        themeOption +='<option value="0" >All Themes</option>';
        jQuery.each(res, function( ind, val ) {
          if(searchParams.get('my-theme') != undefined && searchParams.get('my-theme') != null && searchParams.get('my-theme') != '' && searchParams.get('my-theme') == val.themeID_Admin){
            themeOption +='<option value="'+val.themeID_Admin+'" selected="selected">'+val.tName+'</option>';
          }else{
            themeOption +='<option value="'+val.themeID_Admin+'">'+val.tName+'</option>';
          }
        });

        homeThemeOption +='<div> <h4>Select a tour theme...</h4> </div>';
        jQuery.each(res, function( ind, val ) {
          homeThemeOption +='<li>'+
              '<label class="radio-btn">'+
              '<input type="checkbox" class="radio" value="'+val.themeID_Admin+'" name="fooby[1][]">'+val.tName+'</label>'+
              '</li>';
        });
      }

      jQuery("div#my-theme ul").html('');
      jQuery("div#my-theme ul").html(homeThemeOption);

      var themeHtml = '<select class="lop-ol" name="theme" onchange="applyFilter()">'
          +themeOption+
          '</select>';

      jQuery("div#collapseTheme select").html('');
      jQuery("div#collapseTheme select").html(themeHtml);
      break;
    case 'countries':

      if(res.length > 0){
        jQuery("div#collapseCountry").addClass('in');

        countryList = res ;

        jQuery.each(countryList, function( ind, val ) {
          if(searchParams.get('my-cities') != undefined && searchParams.get('my-cities') != null && searchParams.get('my-cities') != ''){
            let country = searchParams.get('my-cities').split(",");
            if(jQuery.inArray(val.countryID_Admin, country) !== -1){
              homeCountriesOption +='<li>'+
                  '<label class="radio-btn">'+
                  '<input type="checkbox" value="'+val.countryID_Admin+'" checked>'+val.cName+'</label>'+
                  '</li>';
            }else{
              homeCountriesOption +='<li>'+
                  '<label class="radio-btn">'+
                  '<input type="checkbox" value="'+val.countryID_Admin+'">'+val.cName+'</label>'+
                  '</li>';
            }
          }else{
            homeCountriesOption +='<li>'+
                '<label class="radio-btn">'+
                '<input type="checkbox" value="'+val.countryID_Admin+'">'+val.cName+'</label>'+
                '</li>';
          }
        });

        var  countriesHtml ='<div class="searchpageddl"><div class="dropdown cq-dropdown" data-name="country" id="my-cities" >'+
            '<button class="btn btn-info btn-sm dropdown-toggle my-deop" type="button" id="btndropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">All countries'+
            '<span class="caret"></span>' +
            '</button>'+
            '<span onclick="resetCities();" id="btnReset1" class="close-on-mysite">X</span>'+
            '<ul class="dropdown-menu" aria-labelledby="btndropdown" id="homeCountry">'+
            '<div>'+
            '<h4>Tours visiting these countries… </h4>'+
            '<p>Select up to 3 destinations</p>'+
            '</div>'+
            homeCountriesOption +
            '</ul>'+
            '</div></div>'
      }

      jQuery("div#collapseCountry div").html('');
      jQuery("div#collapseCountry div").html(countriesHtml);
      jQuery('.cq-dropdown').dropdownCheckboxes() ;


      break;
    case 'tourTags':
      if(res.length > 0){
        jQuery.each(res, function( ind, val ) {
          if((filters.tourTags).indexOf( parseInt(val.id)) == -1){
            tourTagsOption +='<label data-id="'+val.id+'">'+val.tTag+'</label>';
          }else{
            tourTagsOption +='<label data-id="'+val.id+'" class="active">'+val.tTag+'</label>';
          }
        });
      }

      jQuery("div.tour-tags").html('');
      jQuery("div.tour-tags").html(tourTagsOption);
      break;
    case 'city':
      if(res != null && res.length > 0){
        jQuery.each(res, function( ind, val ) {
          cityOption +='<li>'+
              '<div class="checkbox">'+
              '<label>'+
              '<input type="checkbox" value="'+val.cityID+'" name="cities[]" onchange="applyFilter()">'+
              '<p>'+val.cName+' </p>'+
              '</label>'+
              '</div>'+
              '</li>'
        });
      }
      var cityHtml = '<ul>'
          +cityOption+
          '</ul>';

      jQuery("div#collapseCities ul").html('');
      jQuery("div#collapseCities ul").html(cityHtml);
      break;
    case 'physicalRating':
      if(res != null && res.length > 0){

        physicalRatingOption +='<li>'+
            '<div class="checkbox">'+
            '<label>'+
            '<input type="checkbox" value="0" name="rating[]" checked>'+
            '<p>All ratings</p>'+
            '</label>'+
            '</div>'+
            '</li>' ;
        jQuery.each(res, function( ind, val ) {
          physicalRatingOption +=
              '<li>'+
              '<div class="checkbox">'+
              '<label>'+
              '<input type="checkbox" value="'+val.statusID_Admin+'" name="rating[]" checked>'+
              '<p>'+val.sName+' </p>'+
              '</label>'+
              '</div>'+
              '</li>'
        });
      }
      var physicalRatingHtml = '<ul>'
          +physicalRatingOption+
          '</ul>';

      jQuery("div#collapseRating ul").html('');
      jQuery("div#collapseRating ul").html(physicalRatingHtml);
      break;
    case 'tourType':
      if(res.length > 0){
        tourTypeOption +='<option value="0" >All types</option>';
        jQuery.each(res, function( ind, val ) {
          tourTypeOption +='<option value="'+val.statusID_Admin +'" >'+val.sName+'</option>';
        });
      }
      var tourTypeHtml = '<select class="lop-ol" name="tourType" onchange="applyFilter()">'
          +tourTypeOption+
          '</select>';
      jQuery("div#collapseTourType select").html('');
      jQuery("div#collapseTourType select").html(tourTypeHtml);
      break;

    default:
      break;
  }
}

jQuery('#city-list').addClass("hide");

function changeCountry(){
  setTimeout(function(){
    if (jQuery('input[name="country"]').val() != '' && jQuery('input[name="country"]').val() != undefined && jQuery('input[name="country"]').val() != null) {
      let idArray = JSON.parse(jQuery('input[name="country"]').val());
      jQuery.ajax({
        url: '/custom-code/api/index.php?action=getCitiesByCountryId&id='+idArray,
        type: 'GET',
        dataType: "json"
      }).done(function(res){
        if(res.status){
          if(res.data.length > 0){
            jQuery('#city-list').removeClass("hide");
            filterHtml(res.data,'city');
          }
        }
      });
    }

    applyFilter();

  }, 300);
}

function applyFilterCount(filters){
  let countHtml = '';
  jQuery.ajax({
    url: '/custom-code/api/index.php?action=getTourCountFilter',
    type: 'POST',
    dataType: "json",
    data:filters
  }).done(function(res){
    if(res.status){
      if(res.data > 0){
        countHtml = res.data+' Results Found';
      }else{
        countHtml = 'No Result Found';
      }
      jQuery(".result-count").html(countHtml);
    }

    paginationSetup(parseInt(res.data),parseInt(jQuery('select[name="tourLimit"]').val()),filters.pageNo);

  });
  jQuery(".result-count").html(countHtml);
}

function applyFilter(pageNo=1){
  if(window.location.pathname == '/tours/search-tour'){
    jQuery('#search-data').html('');
    jQuery('.search-loader').show();
    let citiesId = [];
    let ratingId = [];
    let tagsId   = [];


    if(jQuery('input[name="cities[]"]:checked').length > 0){

      jQuery('input[name="cities[]"]').each(function(){
        if(jQuery(this).is(':checked')){
          citiesId.push(parseInt(jQuery(this).val()));
        }
      });
    }

    if(jQuery('input[name="rating[]"]:checked').length > 0){

      jQuery('input[name="rating[]"]').each(function(){
        if(jQuery(this).is(':checked')){
          ratingId.push(parseInt(jQuery(this).val()));
        }
      });
      if(jQuery.inArray(0, ratingId) !== -1){
        ratingId = [];
        ratingId.push(0);
      }
    }

    jQuery('div.tour-tags label').each(function() {
      if(jQuery(this).hasClass('active')){
        tagsId.push(parseInt(jQuery(this).attr('data-id')));
      }
    });



    filters  = {

      person         : jQuery('select[name="nop"]').val(),
      country        : jQuery('input[name="country"]').val() ? JSON.parse(jQuery('input[name="country"]').val()) : [],
      theme          : jQuery('select[name="theme"]').val(),
      language       : jQuery('select[name="language"]').val(),
      tourType       : jQuery('select[name="tourType"]').val(),
      currency       : 2,
      startDate      : customPopUp.from,
      endDate        : customPopUp.to,
      minDay         : 0,
      maxDay         : 0,
      minPrice       : 0,
      maxPrice       : 0,
      ranking        : ratingId,
      cities         : citiesId,
      tourTags       : tagsId,
      limit          : isMobileView == true ? 10000 : jQuery('select[name="tourLimit"]').val(),
      pageNo         : pageNo,
      sort           : jQuery('select[name="sortby"]').val(),
      offset         : 0
    };
    if(isPriceChange){
      filters.minPrice = jQuery("input[name=price-min]").val();
      filters.maxPrice = jQuery("input[name=price-max]").val();
    }
    if(isDurationChange){
      filters.minDay = jQuery("input[name=duration-min]").val();
      filters.maxDay = jQuery("input[name=duration-max]").val();
    }

    localStorage.setItem('person',filters.person);

    jQuery.ajax({
      url: '/custom-code/api/index.php?action=getTourFilter',
      type: 'POST',
      dataType: "json",
      data:filters
    }).done(function(res){
      if(res.status){
        applyFilterCount(filters);


        if(res.tags != null && res.tags.length > 0){
          filterHtml(res.tags,'tourTags');
        }else{
          filterHtml([],'tourTags');

        }

        updateSlider({
          minDay    : res.minDay,
          maxDay    : res.maxDay,
          minPrice  : res.minPrice,
          maxPrice  : res.maxPrice
        });

        updateSearchTourHtml(res.data);
        jQuery('.search-loader').hide();
        // isDurationChange = false;
        // isPriceChange    = false;

      }else{
        filterHtml([],'tourTags');
        jQuery('.search-loader').hide();
      }
    });
  }
}

jQuery(document).on('click','#applyFilter',function(e){
  e.preventDefault();
  applyFilter();
});

function resetFilter(){
  window.location.href =  window.location.origin+window.location.pathname+window.location.search;
}

function updateSearchTourHtml(data) {
  let searchHtml = '';
  let favArrayId = [];

  favArrayId = getLocalStorageData('favArray')


  if(data != undefined && data != null && data != 'null' && data.length > 0){

    jQuery.each(data, function( ind, val ) {

      let slug        = getSlugByPageId(val.pageId);
      let favClass    = (favArrayId.indexOf(parseInt(val.tourID_Admin)) > -1) ? 'active':'';

      let bannerHtml = '';
      if(val.bTitle != undefined && val.bTitle != null && val.bTitle != ''){
        bannerHtml = '<span style="background: #'+val.bBackGroundColour+'; color: #'+val.bForeGroundColour+';">'+val.bTitle+'</span>';
      }
      searchHtml +='<div class="col-md-6 col-sm-6">'
          +'<div class="carousel-slider__post">'
          +'<div class="carousel-slider__post-content">'
          +'<div class="carousel-slider__post-header">'
          +'<div class="top-box">'
          +bannerHtml
          +'<div class="like-box">'
          +'<a href="javascript:void(0)" data-page="search-page" class="'+favClass+'"><i class="fa fa-heart-o" aria-hidden="true"></i></a>'
          +'<a href="javascript:void(0)" onclick="shareTour(\''+slug+'\')"><i class="fa fa-share-alt" aria-hidden="true"></i></a>'
          +'</div>'

          +'</div>'
          +'<div>'
          +'<input type="hidden" name="tourAdminId[]" class="tourOrignalId" value="'+val.tourID_Admin+'">'
          +'<a href="'+slug+'" target="_self" class="carousel-slider__post-image owl-lazy" style="background-image: url(/wp-content/uploads/2021/05/'+val.tBannerImage+');"></a>'
          +'<a class="carousel-slider__post-title" href="'+slug+'" target="_self">'
          +'<h2>'+val.tName+'</h2>'
          +'</a>'
          +'<div class="address-box">'+updateCountryFlag(val.flags)
          +'<p>'+val.countries+' </p>'
          +'</div>'
          +'</div>'
          +'</div>'
          +'<div class="carousel-slider__post-excerpt">'+val.tBannerDescription+'</div>'
          +'<div class="bt-box-banner centerbox"><a href="'+slug+'" rel="noopener" target="_self">Learn more</a></div>'
          +'<div class="carousel_footer">'
          +'<p>from <span>£'+formatNumber(val.price)+'</span> per person</p>'
          +'</div>'
          +'</div>'
          +'</div>'
          +'</div>';

      if((ind%2) !== 0){
        searchHtml +='<div class="clearfix"></div>';
      }
    });
  }else{
    searchHtml +='<div class="no-result">'
        +'<p>No tours found that match your criteria</p>'
        +'</div>';
  }

  jQuery("#search-data").html(searchHtml);
}

function updateCountryFlag(flags){
  let flagHtml = '<img src="'+base_url+'/wp-content/uploads/2021/10/20.png">';

  if(flags!= undefined && flags!= null && flags != ''){
    flagHtml = '';
    let flagArray = flags.split(' / ');
    jQuery(flagArray).each(function(ind,val){
      flagHtml +=  '<img src="'+base_url+'/wp-content/uploads/2021/05/'+val+'">';
    });
  }
  return flagHtml;
}

function updateSlider(res){

  if(jQuery( "#durationRangeSlider" ).length || jQuery( "#priceRangeSlider" ).length){

    res.minDay    = parseInt(res.minDay);
    res.maxDay    = parseInt(res.maxDay);
    res.minPrice  = parseInt(res.minPrice);
    res.maxPrice  = parseInt(res.maxPrice);
    let selectedMinDay    = parseInt(jQuery("input[name=duration-min]").val());
    let selectedMaxDay    = parseInt(jQuery("input[name=duration-max]").val());
    let selectedMinPrice  = parseInt(jQuery("input[name=price-min]").val());
    let selectedMaxPrice  = parseInt(jQuery("input[name=price-max]").val());

    if(isFirtTimeLoad){
      selectedMinDay    = res.minDay;
      selectedMaxDay    = res.maxDay;
      selectedMinPrice  = res.minPrice;
      selectedMaxPrice  = res.maxPrice;

    }

    isFirtTimeLoad =false;

    if(selectedMinDay < res.minDay){
      res.minDay = selectedMinDay;
    }

    if(selectedMaxDay > res.maxDay){
      res.maxDay = selectedMaxDay;
    }

    if(selectedMinPrice < res.minPrice){
      res.minPrice = selectedMinPrice;
    }

    if(selectedMaxPrice > res.maxPrice){
      res.maxPrice = selectedMaxPrice;
    }

    if(isPriceChange){
      jQuery("input[name=price-min]").val(selectedMinPrice).attr('min',res.minPrice).attr('max',res.maxPrice);
      jQuery("input[name=price-max]").val(selectedMaxPrice).attr('min',res.minPrice).attr('max',res.maxPrice);
    }else{
      jQuery("input[name=price-min]").val(res.minPrice).attr('min',res.minPrice).attr('max',res.maxPrice);
      jQuery("input[name=price-max]").val(res.maxPrice).attr('min',res.minPrice).attr('max',res.maxPrice);
    }

    if(isDurationChange){
      jQuery("input[name=duration-min]").val(selectedMinDay).attr('min',res.minDay).attr('max',res.maxDay);
      jQuery("input[name=duration-max]").val(selectedMaxDay).attr('min',res.minDay).attr('max',res.maxDay);
    }else{
      jQuery("input[name=duration-min]").val(res.minDay).attr('min',res.minDay).attr('max',res.maxDay);
      jQuery("input[name=duration-max]").val(res.maxDay).attr('min',res.minDay).attr('max',res.maxDay);
    }

    // setTimeout(function() {
    jQuery( "#durationRangeSlider" ).rangeslider('refresh');
    jQuery( "#priceRangeSlider" ).rangeslider('refresh');
    // }, 300);
  }
}

function youMayAlsoLikeLink(paramPerson){
  if(window.location.pathname != '/tours/search-tour'){

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
        //subEle.html(lastPrefix);
        // getLowestTourPrice(getPageIdByTourId(tourId),tourId,subEle);
        getLowestPrice(tourId,paramPerson,2,1,false).then(function(res){
          if(res.status){

            subEle.html(lastPrefix + formatNumber(res.data));
          }
        });
      }
    });
  }

}

function getLowestTourPrice(pageId,tourId,subEle){

  let today     = presentYear+'-'+presentMonth+'-'+presentDay;
  let perPersonPrice = 0;

  jQuery.ajax({
    url: '/custom-code/api/index.php',
    type: 'GET',
    dataType: "json",
    data: {
      pageId   :pageId,
      month    :calendarMonth,
      today    :today,
      person   :1,
      child    :0,
      tourId   :tourId,
      lowest   :true,
      action   :'getTourCost',
      async    :false,
      cache    :false
    }
  }).done(function(data){
    if(data.status){
      perPersonPrice = data.data.groupOneArray[0];
      let icon = '';
      if(lastPrefix != undefined && lastPrefix != null && lastPrefix != ''){
        icon = lastPrefix;
      }else{
        icon = data.prefix;
      }
      subEle.html(icon + formatNumber(perPersonPrice));
    }
  });
}

function cron(){
  jQuery.ajax({
    url: '/custom-code/api/index.php?action=getAllTourIdPageId',
    type: 'GET',
    dataType: "json"
  }).done(function(res){
    if(res.status){
    }
  });
}



jQuery(document).on('click','.like-box > a',function(e){
  e.preventDefault();

  let elem    = jQuery(this);
  let elemBox = null;
  if(elem.attr('data-page')!= undefined && elem.attr('data-page')!= '' && elem.attr('data-page')!= null){
    elemBox = elem.closest('.carousel-slider__post');
  }
  //for tour page only
  if(elemBox == null){
    let tempTourId = parseInt(getTourIdByPageId(pageId));
    let favArray = getLocalStorageData('favArray');
    if(jQuery(this).hasClass('active')){
      const index = favArray.indexOf(tempTourId);
      if (index !== -1) {
        favArray.splice(index, 1);
      }
      localStorage.setItem('favArray', JSON.stringify(favArray));
      jQuery(this).removeClass('active');
    }else{

      if(favArray.indexOf(tempTourId) == -1){
        favArray.push(tempTourId);
        localStorage.setItem('favArray', JSON.stringify(favArray));
      }
      jQuery(this).addClass('active');


    }

    jQuery(".tour-favourites div p span").html('('+getLocalStorageData('favArray').length+')');
    return false;
  }


  // for rest of the page
  let tempTourId  = elemBox.find('input').val();

  if(tempTourId != undefined && tempTourId != null && tempTourId != ''){
    if(jQuery(this).hasClass('active')){
      updateFav(tempTourId,'remove',elemBox);
    }else{
      updateFav(tempTourId,'add',elemBox);
    }
  }else{
    console.log('page if not present');
  }

})

function updateFav(id,action = 'add',elemBox=null){
  id                = parseInt(id);
  let favArray      = getLocalStorageData('favArray');

  if(favArray.length > 0){
    switch (action) {
      case 'add':
        if(favArray.indexOf(id) == -1){
          favArray.push(id);
        }
        localStorage.setItem('favArray', JSON.stringify(favArray));
        updateFavHtml(favArray,id,elemBox);
        break;
      case 'remove':
        const index = favArray.indexOf(id);
        if (index !== -1) {
          favArray.splice(index, 1);
        }
        updateFavHtml(favArray,id,elemBox);
        localStorage.setItem('favArray', JSON.stringify(favArray));
        break;
    }
  }else{
    favArray.push(id);
    localStorage.setItem('favArray', JSON.stringify(favArray));
    updateFavHtml(favArray,id,elemBox);
  }

}

function updateFavHtml(favArray,customId = null,elemBox=null) {
  //empty counter
  jQuery(".tour-favourites div p span").html('');
  jQuery(".price-text .like-box a").attr('href','javascript:void(0)');

  if(elemBox == null){
    //jQuery(".carousel-slider__post-header .top-box .like-box a").attr('href','javascript:void(0)');
    //jQuery(".price-text .like-box a").removeClass('active');
  }

  jQuery('.tour-favourites div p').css('cursor','pointer');


  if(favArray.length > 0){
    //update fav counter
    jQuery(".tour-favourites div p span").html('('+favArray.length+')');
    let index = favArray.indexOf(customId);

    if(elemBox == null){


    }else{

      if (index > -1 ) {
        elemBox.find('.like-box > a:first').addClass('active');
      }else{
        elemBox.find('.like-box > a:first').removeClass('active');
      }

    }

  }
}

function updateFavPageData(){
  let favHtml     = '';
  let slug        = '';
  let favArray    = getLocalStorageData('favArray');
  if(favArray.length > 0){

    jQuery.ajax({
      url: '/custom-code/api/index.php?action=getFavPageDataByTourId',
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
        //youMayAlsoLikeLink();
      }else{
        favHtml ='<div class="no-fav"><p>No Favourite</p></div>';
        jQuery(".fav-inner .item").html(favHtml);
      }
    });
  }else{
    favHtml ='<div class="no-fav"><p>No Favourite</p></div>';
    jQuery(".fav-inner .item").html(favHtml);
  }


}

jQuery('.tour-favourites div p').first().click(function(e){
  e.preventDefault();
  updateFavPageData();
  window.open(base_url+'/tours/favorite-list', '_self');
});

// plugin js
function getCustomHeaderPluginData(){
	
  jQuery('.custom-header-container').each(function() {
    var id = jQuery(this).attr('id');
    jQuery.ajax({
      url: '/custom-code/api/index.php?action=getCustomeHeaderFilterOption',
      type: 'GET',
      dataType: "json",
      data: {id : id }
    }).done(function(res){
      var genratedHTML = genrateCustomHeaderHTML(res.data);
      jQuery('#'+id).append(genratedHTML);
      jQuery('.cq-dropdown').dropdownCheckboxes();
    });
  });
}

function genrateCustomHeaderHTML(res){
  if(countryList.length > 0){
    var contryOption = '';
    var countryIdArr = res.country_id.split(',');
    jQuery.each(countryList , function( i, val ) {
      var selectedCountry = (jQuery.inArray(val.countryID, countryIdArr) !== -1) ?  'checked' : '';
      contryOption +='<li>'+
          '<label class="radio-btn">'+
          '<input type="checkbox" value="'+val.countryID_Admin+'" '+selectedCountry+'>'+
          val.cName+
          '</label>'+
          '</li>'
    });
  }

  if(themeList.length > 0){

    var themeOption   = '';
    var selectedTheme = 'All themes';
    //var themeIdArr = res.theme_id.split(',');
    themeOption +='<li>'+
        '<label class="radio-btn">'+
        '<input type="radio" class="radio updateThemeSelect" data-theme="All themes" name="my-theme" value="0"> All themes'+
        '</label>'+
        '</li>'

    jQuery.each(themeList, function( i, val ) {
      let isChecked = '';
      if(parseInt(val.themeID) == parseInt(res.theme_id)) {
        selectedTheme = val.tName;
        isChecked     = 'checked';
      }

      themeOption +='<li>'+
          '<label class="radio-btn">'+
          '<input type="radio" class="radio updateThemeSelect" data-theme="'+val.tName+'" name="my-theme" value="'+val.themeID_Admin+'"  '+isChecked+'>'+
          val.tName +
          '</label>'+
          '</li>'
    });
  }
  var personOption = '';
  for (var i = 1; i <= 12; i++) {
    let isChecked = (res.num_of_passenger === i) ? 'checked':'';
    if(i == 1){
      personOption += '<li >'+
          '<label class="radio-btn">'+
          '<input type="radio" class="radio updatePassengerSelect" value="'+i+'" name="my-passengers" '+isChecked+' >'+i+' Passenger'
      '</label>'+
      '</li>';
    }else{
      personOption += '<li >'+
          '<label class="radio-btn">'+
          '<input type="radio" class="radio updatePassengerSelect" value="'+i+'" name="my-passengers" '+isChecked+' >'+i+' Passengers'
      '</label>'+
      '</li>';
    }

  }

  var html ='<div class="search-in-banner">'+
      '<form class="custom-header-form" action="search-tour">'+
      '<div class="col-md-1"></div>';

  if(res.passenger > 0 )
  {
    let paramPerson = getLocalStorageData('person') == [] ? 0 : getLocalStorageData('person');
    let npm = paramPerson > 0 ? paramPerson : res.num_of_passenger;
    if(npm > 1){
      npm = npm+' Passengers';
    }else{
      npm = npm+' Passenger';
    }
    html += '<div class="dropdown col-md-2" id="my-passengers">'+
        '<button class="btn btn-info btn-sm dropdown-toggle my-deop passenger-btn" type="button" id="btndropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'+ npm +
        '<span class="caret"></span>'+
        '</button>'+
        '<span onclick="resetPassengers();" id="btnReset2" class="close-on-mysite">X</span> '+
        '<ul class="dropdown-menu no-check-box" aria-labelledby="btndropdown2">'+
        '<div>'+
        '<h4>How many passengers?</h4>'+
        '</div>'+
        personOption +
        '</ul>'+
        '</div>';
  }
  if(res.country > 0 )
  {
    html +='<div class="dropdown cq-dropdown col-md-2" data-name="my-cities" id="my-cities" >'+
        '<button class="btn btn-info btn-sm dropdown-toggle my-deop" type="button" id="btndropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">All countries'+
        '<span class="caret"></span>' +
        '</button>'+
        '<span onclick="resetCities();" id="btnReset1" class="close-on-mysite">X</span>'+
        '<ul class="dropdown-menu" aria-labelledby="btndropdown" id="homeCountry">'+
        '<div>'+
        '<h4>Tours visiting these countries… </h4>'+
        '<p>Select up to 3 destinations</p>'+
        '</div>'+
        contryOption +
        '</ul>'+
        '</div>'
  }
  if(res.theme > 0 ){
    html +='<div class="dropdown col-md-3" data-name="my-theme" id="my-theme">'+
        '<button class="btn btn-info btn-sm dropdown-toggle my-deop" type="button" id="btndropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'+
        selectedTheme +
        '<span class="caret"></span>'+
        '</button>'+
        '<span onclick="resetTheme();" id="btnReset" class="close-on-mysite">X</span> '+
        '<ul class="dropdown-menu no-check-box" aria-labelledby="btndropdown2" id="hometheme">'+
        '<div> <h4>Select a tour theme...</h4> </div>'+
        themeOption +
        '</ul>'+
        '</div>'
  }
  if(res.date > 0 ){
    let inputDate = '';
    if(res.date_from !=undefined && res.date_from!= null && res.date_from !='0000-00-00' && res.date_to !=undefined && res.date_to!= null && res.date_to !='0000-00-00'){
      let fromDateArray =  (res.date_from).split("-");
      let toDateArray   =  (res.date_to).split("-");
      let fromMonth =monthArray[parseInt(fromDateArray[1])-1];
      let toMonth =monthArray[parseInt(toDateArray[1])-1];
      inputDate = fromMonth+' '+fromDateArray[0]+' - '+toMonth+' '+toDateArray[0];
    }

    html += '<div class="col-md-2" id="datepicker-div">'+
        '<input type="text" name="fromToDateInput" placeholder="All dates" data-toggle="modal" data-target="#exampleModal" id="fromToDateModal" value="'+inputDate+'">'+
        '<span onclick="resetDate();" id="dateReset" class="close-on-mysite">X</span> '+
        '</div>'
  }

  html += '<div class="col-md-2">'+
      '<input type="submit" value="Search">'+
      '</div>'+
      '</form>'+
      '</div>';
  return html ;
}

jQuery(document).on('click','.updatePassengerSelect',function(){
  let html = jQuery(this).val()+ '<span class="caret"></span>';
  jQuery(this).closest('.dropdown ').find('button').html(html);
});
jQuery(document).on('click','.updateThemeSelect',function(){
  let html = jQuery(this).attr('data-theme')+ '<span class="caret"></span>';
  jQuery(this).closest('.dropdown').find('button').html(html);
});

// plugin js

// from date to date modal code start

jQuery(document).on('click','#fromToDateModal',function(e){
  let parentOffset = jQuery(this).parent().offset();
  jQuery('.fromTourInterval').removeClass('active');
  jQuery('.toTourInterval').removeClass('active');
  jQuery('.year-div .pull-left').removeClass('disable');
  jQuery('.year-div > span.yearNumber').text(customPopUp.from.year);
  jQuery('.monthList li').removeClass('active');
  // jQuery("input[name=fromToDateInput]").val('');
  updateFromAndToCalendar('from');
});

jQuery(document).on('click','.monthList li',function(e){
  e.preventDefault();
  jQuery('.monthList li').removeClass('active');
  if(!(jQuery(this).hasClass('disabled'))){
    if(jQuery('.fromTourInterval').hasClass('active')){
      customPopUp.from.month = jQuery(this).attr('data-value');
      customPopUp.from.year  = parseInt(jQuery('.year-div > span.yearNumber').text());
      customPopUp.to.month   = 0;
      jQuery('.monthList li').each(function() {
        if(jQuery(this).attr('data-value') == customPopUp.from.month ) {
          jQuery(this).addClass('active');
        }
      });
      // toDate();
      jQuery('.fromTourInterval').removeClass('active');
      jQuery('.year-div .pull-left').addClass('disable');
      customPopUp.to.year = customPopUp.from.year;
      updateFromAndToCalendar('to');
    }else{
      customPopUp.to.month = jQuery(this).attr('data-value');
      customPopUp.to.year  = parseInt(jQuery('.year-div > span.yearNumber').text());
      //applyFilter();
      jQuery('.monthList li').each(function() {
        jQuery(this).removeClass('active');

        if(jQuery(this).attr('data-value') == customPopUp.to.month ) {
          jQuery(this).addClass('active');
        }
      });
      let inputDate = monthArray[(customPopUp.from.month)-1]+' '+customPopUp.from.year+' - '+monthArray[(customPopUp.to.month)-1]+' '+customPopUp.to.year;
      if(window.location.pathname == '/tours/search-tour'){
        applyFilter();
      }
      jQuery("input[name=fromToDateInput]").val(inputDate);
      jQuery("#dateReset").css("display", "block");
      jQuery('#exampleModal').modal('hide');
    }
  }
});

jQuery(document).on('click','.toTourInterval',function(e){
  e.preventDefault();
  if(customPopUp.from.month==0){
    alert('Please select from month');
    return false;
  }
  jQuery('.fromTourInterval').removeClass('active');
  jQuery('.monthList li').removeClass('active').removeClass('disabled');
  if(customPopUp.to.year > 0){
    jQuery('.year-div>span.yearNumber').text(customPopUp.to.year);
  }
  updateFromAndToCalendar('to');
});


jQuery(document).on('click','.fromTourInterval',function(e){
  e.preventDefault();
  jQuery('.toTourInterval').removeClass('active');
  jQuery('.fromTourInterval').addClass('active');
  if(customPopUp.to.year > 0){
    jQuery('.year-div>span.yearNumber').text(customPopUp.from.year);
  }
  updateFromAndToCalendar('from');
});

jQuery(document).on('click','.year-div .pull-left',function(e){
  e.preventDefault();
  let year          = parseInt(jQuery(this).siblings('span').text())-1;
  let checkActive   = jQuery('.fromTourInterval').hasClass('active') ? 'from':'to';
  jQuery('.monthList li').removeClass('active').removeClass('disabled');
  if(checkActive == 'from'){
    if(year <= presentYear){
      year = presentYear;
      jQuery(this).addClass('disable');
    }
    jQuery('.year-div > span.yearNumber').text(year);
    updateFromAndToCalendar();
  }else{
    if(year <= customPopUp.from.year){
      year = customPopUp.from.year;
      jQuery(this).addClass('disable');
    }
    jQuery('.year-div > span.yearNumber').text(year);
    updateFromAndToCalendar('to');
  }
});

jQuery(document).on('click','.year-div .pull-right',function(e){
  e.preventDefault();
  let year          = parseInt(jQuery(this).siblings('span').text()) + 1;
  let checkActive   = jQuery('.fromTourInterval').hasClass('active') ? 'from':'to';

  if(checkActive == 'from'){

    if(year <= presentYear){
      year = presentYear;
      jQuery('.year-div .pull-left').addClass('disable');
    }
    jQuery('.year-div > span.yearNumber').text(year);
    updateFromAndToCalendar();
  }else{
    jQuery('.year-div > span.yearNumber').text(year);
    updateFromAndToCalendar('to');
  }



});

//only set html  according to from and to date
function updateFromAndToCalendar(type = 'from'){
  let year = parseInt(jQuery('.year-div>span.yearNumber').text());
  jQuery('.monthList li').removeClass('active').removeClass('disabled').removeClass('selected-fromMonth');
  jQuery('.year-div .pull-left').removeClass('disable');

  switch(type){
    case 'from':
      // jQuery('.monthList li').removeClass('active').removeClass('disabled');
      jQuery('.toTourInterval').removeClass('active');
      jQuery('.fromTourInterval').addClass('active');
      if(year == presentYear){
        jQuery('.year-div>.pull-left').addClass('disable');
        jQuery('.monthList li').each(function() {
          if(jQuery(this).attr('data-value') < presentMonth ) {
            jQuery(this).addClass('disabled');
          }
          if(jQuery(this).attr('data-value') == customPopUp.from.month && year == customPopUp.from.year) {
            jQuery(this).addClass('active');
          }
        });
      }else{
        if(year == customPopUp.from.year){
          jQuery('.monthList li').each(function() {
            if(jQuery(this).attr('data-value') == customPopUp.from.month ) {
              jQuery(this).addClass('active');
            }
          });
        }

      }
      break;
    case 'to':
      //jQuery('.year-div .pull-left').removeClass('disable');
      // jQuery('.monthList li').removeClass('active').removeClass('disabled').removeClass('selected-fromMonth');
      jQuery('.fromTourInterval').removeClass('active');
      jQuery('.toTourInterval').addClass('active');
      if(customPopUp.to.year == customPopUp.from.year){
        if(year != customPopUp.to.year){
          return false;
        }
        jQuery('.year-div .pull-left').addClass('disable');
        jQuery('.monthList li').each(function() {
          if(jQuery(this).attr('data-value') < customPopUp.from.month ) {
            jQuery(this).addClass('disabled');
          }
          if(jQuery(this).attr('data-value') == customPopUp.to.month ) {
            jQuery(this).addClass('active');
          }
          if(jQuery(this).attr('data-value') == customPopUp.from.month && year == customPopUp.from.year) {
            jQuery(this).addClass('selected-fromMonth');
          }

        });
      }else{
        if(year == customPopUp.to.year){
          jQuery('.monthList li').each(function() {
            if(jQuery(this).attr('data-value') == customPopUp.to.month ) {
              jQuery(this).addClass('active');
            }
            if(jQuery(this).attr('data-value') == customPopUp.from.month && year == customPopUp.from.year) {
              jQuery(this).addClass('selected-fromMonth');
            }
          });
        }
      }

      break;
  }

}





// from date to date modal code end


//custom header form submit
jQuery(document).on('submit',"form.custom-header-form",function(e) {
  //e.preventDefault();
  let pluginForm = jQuery(this).serializeArray();
  jQuery(pluginForm).each(function(ind,val) {
    if(val.value){
      if(val.name == 'my-passengers'){
        jQuery("input[name=my-passengers]").val(JSON.parse(val.value))  ;
      }else if(val.name == 'my-cities'){
        jQuery("input[name=my-cities]").val(JSON.parse(val.value))  ;
      }else if(val.name == 'my-theme'){
        jQuery("input[name=my-theme]").val(JSON.parse(val.value))  ;
      }else{
        jQuery("input[name=fromToDateInput]").val(JSON.parse(val.value))  ;
      }
    }

  });
  jQuery(this).submit();

});

function arrowChange(){
  let sort = jQuery('select[name="sortby"]').val();
  let img  = '';
  if(sort == 'desc'){
    img = base_url+'/wp-content/uploads/2021/10/up.png';
    jQuery('.sortByIcon').attr('src',img);
  }else{
    img = base_url+'/wp-content/uploads/2021/10/down.png';
    jQuery('.sortByIcon').attr('src',img);
  }
}
// custom header form submit end

async function getLowestPrice($tour_id,$person,$currency_id,$language_id){
  return await jQuery.ajax({
    url: '/custom-code/api/index.php',
    type: 'GET',
    dataType: "json",
    data: {
      tour_id       : $tour_id,
      person        : $person,
      currency_id   : $currency_id,
      language_id   : $language_id,
      action        : 'getLowestPrice'
    }
  }).done(function(data){
    return (data.status) ? data.data : 0;
  });
}



// tour filter plugin
function getTourFilterPluginData(){

  jQuery('.custom-tour-container').each(function() {
    var id = jQuery(this).attr('data-id');
    let paramPerson = getLocalStorageData('person') == [] ? 1 : getLocalStorageData('person');

    jQuery.ajax({
      url: '/custom-code/api/index.php?action=getTourFilterPluginOption',
      type: 'POST',
      dataType: "json",
      data: {id : id, person:paramPerson }
    }).done(function(res){

      console.log(res.data);

      var genratedHTML = genrateTourFilterPluginHTML(res.data);
      let htmlId = 'tour-filter-plugin-'+id;
      jQuery('#'+htmlId).append(genratedHTML);

      jQuery('.slider-html').slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        asNavFor: '.slider-for',
        dots: true,
        arrows: true,
        focusOnSelect: true,
        responsive: [{
          breakpoint: 768,
          settings: {
            slidesToShow: 2
          }
        }, {
          breakpoint: 520,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }]
      });

      jQuery('a[data-slide]').click(function(e) {
        e.preventDefault();
        var slideno = jQuery(this).data('slide');
        jQuery('.slider-html').slick('slickGoTo', slideno - 1);
      });

    });
  });
}

function sliderChange(type,attribute){
  if(type=='duration'){
    if(attribute == 'min'){

      if(parseInt(jQuery("input[name=duration-min]").val()) == 1 || parseInt(jQuery("input[name=duration-min]").val()) == 0){
        jQuery('.price-simbol.left-symbol').html('Day');
      }else{
        jQuery('.price-simbol.left-symbol').html('Days');
      }
      if(jQuery("input[name=duration-min]").val() == jQuery("input[name=duration-min]").attr('min')){
        applyFilter();
      }
    }else{
      if(parseInt(jQuery("input[name=duration-max]").val()) == 1 || parseInt(jQuery("input[name=duration-max]").val()) == 0){
        jQuery('.price-simbol.right-symbol').html('Day');
      }else{
        jQuery('.price-simbol.right-symbol').html('Days');
      }
      if(jQuery("input[name=duration-max]").val() == jQuery("input[name=duration-max]").attr('max')){
        applyFilter();
      }
    }
  }else{
    if(attribute == 'min'){
      if(jQuery("input[name=price-min]").val() == jQuery("input[name=price-min]").attr('min')){
        applyFilter();
      }
    }else{
      if(jQuery("input[name=price-max]").val() == jQuery("input[name=price-max]").attr('max')){
        applyFilter();
      }
    }
  }
}

function durationMaxChange(){
}

jQuery(document).on('change','input[name=my-passengers]',function(){
  let pax = 0;
  let pluginForm = jQuery("form.custom-header-form").serializeArray();

  jQuery(pluginForm).each(function(ind,val) {
    if(val.value){
      if(val.name == 'my-passengers'){
        pax = parseInt(val.value);
      }
    }
  });

  if(pax > 1){
    pax = pax+' Passengers';
    jQuery('.passenger-btn').html(pax);
  }else{
    pax = pax+' Passenger';
    jQuery('.passenger-btn').html(pax);
  }
});

function genrateTourFilterPluginHTML(res){
  var item = '';
  var favArrayId = getLocalStorageData('favArray');
  var sliderHtml = '';

  if(res!='' && res!= null && res!= undefined && res.length > 0){
    jQuery.each(res , function( i, val ) {

      let slug = getSlugByTourId(val.tourID_Admin);
      let favClass    = (favArrayId.indexOf(parseInt(val.tourID_Admin)) > -1) ? 'active':'';
      let countryArray = [];
      if(val.countries != null){
        countryArray = val.countries.split(' || ');
      }
      let country      = val.is_country_visible == 1 ?  countryArray[0]||[] : '';
      let flag         = val.is_flag_visible == 1 ? updateCountryFlag(countryArray[1]) : '';
      let description  = val.is_description_visible == 1 ? ((val.tBannerDescription!='' && val.tBannerDescription!= null && val.tBannerDescription!= undefined) ? val.tBannerDescription : '') : '';
      let heading      = val.is_heading_visible == 1 ? ((val.tName!='' && val.tName!= null && val.tName!= undefined) ? val.tName : '') : '';
      let bannerImage  = (val.tBannerImage!='' && val.tBannerImage!= null && val.tBannerImage!= undefined) ? val.tBannerImage : '285x335.png' ;
      let price        = (val.price!='' && val.price!= null && val.price!= undefined && val.price > 0) ? formatNumber(val.price) : 0;

      let bannerHtml = '';
      if(val.bTitle != undefined && val.bTitle != null && val.bTitle != '' && val.is_label_visible == 1){
        bannerHtml = '<span style="background: #'+val.bBackGroundColour+'; color: #'+val.bForeGroundColour+';">'+val.bTitle+'</span>';
      }

      item +='<div class="item">'+
          '<div class="carousel-slider__post">'+
          '<div class="carousel-slider__post-content">'+
          '<div class="carousel-slider__post-header">'+
          '<div class="top-box">'+
          bannerHtml+
          '<div class="like-box">';

      if(val.is_wishlist_icon_visible == 1){
        item += '<a href="javascript:void(0)" data-page="tourPage" class="'+favClass+'"><i class="fa fa-heart-o" aria-hidden="true"></i></a>';
      }

      if(val.is_share_icon_visible == 1){
        item += '<a href="javascript:void(0)" onclick="shareTour('+slug+')"><i class="fa fa-share-alt" aria-hidden="true"></i></a>';
      }

      item +='</div>'+
          '</div>'+
          '<div>'+
          '<input type="hidden" name="tourAdminId[]" class="tourOrignalId" value="'+val.tourID_Admin+'">'+
          '<a href="'+slug+'" class="carousel-slider__post-image owl-lazy" style="background-image: url(/wp-content/uploads/2021/05/'+bannerImage+');"></a>'+
          '<a class="carousel-slider__post-title tourid25" href="'+slug+'">'+
          '<h2>'+heading+'</h2>'+
          '</a>'+
          '<div class="address-box">'+ flag +
          '<p><b>'+country+'</b></p>'+
          '</div>'+
          '</div>'+
          '</div>'+
          '<div class="carousel-slider__post-excerpt">'+description+'</div>';

      if(val.is_learn_more_visible == 1){
        item +='<div class="bt-box-banner centerbox">'+
            '<a href="'+slug+'" rel="noopener">Learn more</a>'+
            '</div>';
      }

      if(val.is_price_visible == 1){
        item +='<div class="carousel_footer">'+
            '<p>from <span>£'+price+'</span> per person</p>'+
            '</div>';
      }

      item +='</div>'+
          '</div>'+
          '</div>';
    });

    sliderHtml ='<div id="myCarousel1" class="carousel slider slider-html plugin-slider">'+
        item+
        '</div>';
  }else{
    sliderHtml = '<div class="tout-blank"><p>No Result Found</p></div>';
  }
  return sliderHtml ;
}

function paginationSetup(totalItem,showLimit,page){

  if(totalItem > 0){
    jQuery("#pagination").css("display", "block");
    if(jQuery('#pagination').length > 0){

      jQuery('#pagination').pagination({
        items: totalItem,
        itemsOnPage: showLimit,
        currentPage: page,
        onPageClick: function (noofele) {
          jQuery("html, body").animate({ scrollTop: 0 }, "slow");
          applyFilter(noofele);
          jQuery(".wrapper .item").hide()
              .slice(showLimit*(noofele-1),
                  showLimit+ showLimit* (noofele - 1)).show();
        }
      });
    }
  }else{
    jQuery("#pagination").css("display", "none");
  }
}

function resetDate() {
  jQuery("input[name='fromToDateInput']").val("");
  jQuery("#dateReset").css("display", "none");
  customPopUp = {
    from : {
      month :0,
      year  :presentYear
    },
    to : {
      month:0,
      year :0
    }
  };
  if(window.location.pathname == "/tours/search-tour"){
    applyFilter();
  }
}

//tour filter plugin


//featured plugin 

getFeaturedPluginData();

function getFeaturedPluginData(){

  jQuery('.featured-tour-container').each(function() {
    var id = jQuery(this).attr('data-id');
    let paramPerson = 1;
    //let paramPerson = getLocalStorageData('person') == [] ? 1 : getLocalStorageData('person');

    jQuery.ajax({
      url: '/custom-code/api/index.php?action=getFeaturedPluginData',
      type: 'POST',
      dataType: "json",
      data: {id : id, person:paramPerson }
    }).done(function(res){
      var genratedHTML = genrateFeaturedPluginHTML(res.data);
      let htmlId = 'featured-plugin-'+id;
      jQuery('#'+htmlId).append(genratedHTML);
    });
  });
}

function genrateFeaturedPluginHTML(res){
  var item = '';
  var favArrayId = getLocalStorageData('favArray');
  var html = '';
  if(res!='' && res!= null && res!= undefined ){
    let slug = getSlugByTourId(res.tourID_Admin);
    let favClass    = (favArrayId.indexOf(parseInt(res.tourID_Admin)) > -1) ? 'active':'';
    let countryArray = [];
    if(res.countries != null){
      countryArray = res.countries.split(' || ');
    }
    let country      = (countryArray[0]!='' && countryArray[0]!= null && countryArray[0]!= undefined) ? countryArray[0]||[] : '';
    let flag         = (countryArray[1]!='' && countryArray[1]!= null && countryArray[1]!= undefined) ? updateCountryFlag(countryArray[1]) : '';

    let description  = (res.tBannerDescription!='' && res.tBannerDescription!= null && res.tBannerDescription!= undefined) ? res.tBannerDescription : '';
    let heading      = (res.tName!='' && res.tName!= null && res.tName!= undefined) ? res.tName : '';
    let bannerImage  = (res.tBannerImage!='' && res.tBannerImage!= null && res.tBannerImage!= undefined) ? '/wp-content/uploads/2021/05/'+res.tBannerImage : '/wp-content/uploads/2021/11/580x250.png';
    let price        = (res.price!='' && res.price!= null && res.price!= undefined && res.price > 0) ? formatNumber(res.price) : 0;

    let bannerHtml = '';

    if(res.bTitle != undefined && res.bTitle != null && res.bTitle != '' && res.is_label_visible == 1){
      bannerHtml = '<span style="background: #'+res.bBackGroundColour+'; color: #'+res.bForeGroundColour+';">'+val.bTitle+'</span>';
    }


    html +='<div class="popular-main-box">'+
        '<div class="carousel-slider__post">'+
        '<div class="popular-img-box">'+
        bannerHtml+
        '<div class="like-box">'+
        '<a href="javascript:void(0)" data-page="tourPage" class="'+favClass+'"><i class="fa fa-heart-o" aria-hidden="true"></i></a>'+
        '<a href="javascript:void(0)" onclick="shareTour('+slug+')"><i class="fa fa-share-alt" aria-hidden="true"></i></a>'+
        '</div>'+
        '<input type="hidden" name="tourAdminId[]" class="tourOrignalId" value="'+res.tourID_Admin+'">';

    if(res.is_display_banner == 1){
      html += '<img src="'+base_url+bannerImage+'">';
    }

    html +=  '</div></div>'+
        '<div class="popular-text">'+
        '<h4><a href="'+slug+'">'+res.tName+'</h4></a>'+
        '<div class="flg-box">'+
        flag+
        '</div>'+
        '<div class="flg-box">'+
        country+
        '</div>'+
        '<p>'+description+'</p>'+
        '<div class="price-box flg-box">'+
        '<p>from <span> £'+price+'</span> per person</p>'+
        '<a href="'+slug+'" rel="noopener" target="_self">Learn more</a>'+
        '</div>'+
        '</div>'+
        '</div>';
  }else{
    html = '<div class="tout-blank"><p>No Result Found</p></div>';
  }
  return html ;
}

//featured plugin 

// theme plugin

//getThemePluginData();

function getThemePluginData(){

  jQuery('.theme-card-container').each(function() {
    var id = jQuery(this).attr('data-id');

    jQuery.ajax({
      url: '/custom-code/api/index.php?action=getThemePluginData',
      type: 'POST',
      dataType: "json",
      data: {id : id}
    }).done(function(res){
      var genratedHTML = genrateThemePluginHTML(res.data);
      let htmlId = 'theme-card-plugin-'+id;
      jQuery('#'+htmlId).append(genratedHTML);

      jQuery('.theme-html').slick({
        slidesToShow: 6,
        slidesToScroll: 6,
        asNavFor: '.slider-for',
        dots: true,
        arrows: true,
        focusOnSelect: true,
        responsive: [{
          breakpoint: 768,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4
          }
        }, {
          breakpoint: 520,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        }]
      });

      jQuery('a[data-slide]').click(function(e) {
        e.preventDefault();
        var slideno = jQuery(this).data('slide');
        jQuery('.theme-html').slick('slickGoTo', slideno - 1);
      });
    });
  });
}

// function genrateThemePluginHTML(res){
//   var item = '';
//   var sliderHtml = '';

//   if(res!='' && res!= null && res!= undefined && res.length > 0){
//     jQuery.each(res , function( i, val ) {
//       item +='<div class="info slick-slide slick-cloned" data-slick-index="-5" aria-hidden="true" tabindex="-1" style="width: 170px;">'+
//                 '<a href="javascript:void(0)" tabindex="-1"><span>'+val.tName+'</span></a>'+
//               '</div>';
//     });

//     sliderHtml ='<div id="myCarousel1" class="carousel slider slider-html plugin-slider">'+
//                 item+
//           '</div>';
//   }else{
//     sliderHtml = '<div class="tout-blank"><p>No Result Found</p></div>';
//   }
//   return sliderHtml ;
// }

// theme plugin


/* ---------funcation definations end ---------------*/