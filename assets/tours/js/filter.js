

jQuery(document).on('click','input[name^="rating"]',function(e){
	if(jQuery(this).val()==0){
		jQuery('input[name^="rating"]').prop('checked',jQuery(this).is(':checked'));
	}else{
		jQuery('input[name^="rating"]:first').prop('checked',checkAllRatingSelected());	   	
	}
    applyFilter();
});

function checkAllRatingSelected(){
	let allChecked = true;
	jQuery('input[name^="rating"]').each(function(ind,val){
    	if(!jQuery(this).is(':checked') && ind != 0){
    		allChecked = false;
    	}
    });
    return allChecked;
}