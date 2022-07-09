<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php global $wpdb;
$toursData = $wpdb->get_results( "SELECT tName,tourID_Admin FROM tbltours where tName != '' and  tStatus in (1,62) order by tName asc ", OBJECT );
$themeData = $wpdb->get_results( "SELECT tName,themeID_Admin as themeID FROM tblthemes where tName != ''  ", OBJECT );





if (isset($_GET['eid'])) {
	$eid = $_GET['eid'];
  $tourCardData = $wpdb->get_row("SELECT * FROM tbltourcardplugin WHERE id='$eid'");
  $tourIdArray = (!empty($tourCardData->tour_id)) ? explode(',', $tourCardData->tour_id) : [];
}



	 ?>
<style type="text/css">
.form-check-input {
    position: relative;
}
td.select-btn > div.ms-options-wrap > button{
	white-space: nowrap;
    width: 950px;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ms-options-wrap > .ms-options > ul input[type="checkbox"] {
    left: 4px !important;
    top: 16px !important;
}
form#filter-option-form {
    margin-top: 30px;
}
.dataTables_wrapper .dataTables_length select {
    width: 60px !important;
}
</style>
<div class="container">
	<form id="filter-option-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" >			

	<table class="table table-bordered ">
	    	<tr>
	      	<td>Title</td>
	        <td colspan="3">
	        	<input  class="form-control" type="text" name="heading" value="<?php echo (!empty($tourCardData->heading)) ? $tourCardData->heading : ''; ?>" placeholder="Enter Title">
	        </td>
	      </tr>
	      <tr>
	      	<td>Select</td>
	        <td colspan="3" class="select-btn">
	        	<input type="radio" name="type" value="tour" <?php echo (empty($tourCardData) || (!empty($tourCardData) && $tourCardData->type=='tour')) ? 'checked' : '' ?>  > Tours
	        	<input type="radio" name="type" value="theme" <?php echo (!empty($tourCardData) && $tourCardData->type=='theme') ? 'checked' : '' ?>> Theme
	        </td>
	      </tr>
	      <tr id="tourRow">
	      	<td>Tour</td>
	        <td colspan="3" class="select-btn">
	        	<select class="form-check-input " multiple name="tour_id[]" id="ddlMultiselect">
	        		<?php if (!empty($toursData)) {
	        		foreach ($toursData as $key => $value) { ?>
	        		 	<option value="<?php echo $value->tourID_Admin; ?>" <?php echo (!empty($tourIdArray) && in_array($value->tourID_Admin, $tourIdArray)) ? 'selected' : '' ;?>  ><?php echo $value->tName; ?></option>
	        		<?php } 
	        		} ?>
	        	</select>
	        </td>
	      </tr>
	      <tr id="themeRow">
	      	<td>Theme</td>
	        <td colspan="3" class="select-btn">
	        	<select class="form-control "  name="theme_id" id="theme_id">
	        		<option value="">Select Theme</option>
	        		<?php if (!empty($themeData)) {
	        		foreach ($themeData as $key => $value) { ?>
	        		 	<option value="<?php echo $value->themeID; ?>" <?php echo (!empty($tourCardData) && $tourCardData->theme_id == $value->themeID) ? 'selected' : '' ;?>  ><?php echo $value->tName; ?></option>
	        		<?php } 
	        		} ?>
	        	</select>
	        </td>
	      </tr>
	      <!-- <tr>
	      	<td>No Of Person</td>
	        
	        <td colspan="3"><input type="number" name="num_of_passenger" class="form-control" placeholder="No Of Person" min="1" max="12" value="<?php echo (!empty($tourCardData->num_of_passenger)) ? $tourCardData->num_of_passenger : 1; ?>" > </td>
	        
	      </tr> -->
	      <tr>
	      	<td>
	      		<input class="form-check-input" id="is_heading_visible" type="checkbox" name="is_heading_visible" <?php echo (!empty($tourCardData->is_heading_visible) || empty($tourCardData)) ? 'checked' : ''; ?>> Show Heading
	      	</td>
	      	<td>
	      		<input class="form-check-input" id="is_label_visible" type="checkbox" name="is_label_visible" <?php echo (!empty($tourCardData->is_label_visible) || empty($tourCardData)) ? 'checked' : ''; ?>> Show Label
	      	</td>
	      	<td>
	      		<input class="form-check-input" id="is_share_icon_visible" type="checkbox" name="is_share_icon_visible" <?php echo (!empty($tourCardData->is_share_icon_visible) || empty($tourCardData)) ? 'checked' : ''; ?>> Show Share Icon
	      	</td>
	      	<td>
	      		<input class="form-check-input" id="is_wishlist_icon_visible" type="checkbox" name="is_wishlist_icon_visible" <?php echo (!empty($tourCardData->is_wishlist_icon_visible) || empty($tourCardData)) ? 'checked' : ''; ?>> Show Add To Wishlist
	      	</td>
 
	      </tr>
	      <tr>
	      	<td>
	      		<!-- <input class="form-check-input" id="is_image_visible" type="checkbox" name="is_image_visible" <?php echo (!empty($tourCardData->is_image_visible) || empty($tourCardData)) ? 'checked' : ''; ?>> Show Image -->
	      		<input class="form-check-input" id="is_learn_more_visible" type="checkbox" name="is_learn_more_visible" <?php echo (!empty($tourCardData->is_learn_more_visible) || empty($tourCardData)) ? 'checked' : ''; ?>> Show Learn More
	      	</td>
	      	<td>
	      		<input class="form-check-input" id="is_flag_visible" type="checkbox" name="is_flag_visible" <?php echo (!empty($tourCardData->is_flag_visible) || empty($tourCardData)) ? 'checked' : ''; ?>> Show Flag
	      	</td>
	      	<td>
	      		<input class="form-check-input" id="is_country_visible" type="checkbox" name="is_country_visible" <?php echo (!empty($tourCardData->is_country_visible) || empty($tourCardData)) ? 'checked' : ''; ?>> Show Country
	      	</td>
	      	<td>
	      		<input class="form-check-input" id="is_description_visible" type="checkbox" name="is_description_visible" <?php echo (!empty($tourCardData->is_description_visible) || empty($tourCardData)) ? 'checked' : ''; ?>> Show Description
	      	</td>	
	      </tr>
	      <tr>
	      	<td>
	      		<input class="form-check-input" id="is_price_visible" type="checkbox" name="is_price_visible" <?php echo (!empty($tourCardData->is_price_visible) || empty($tourCardData)) ? 'checked' : ''; ?>> Show Price
	      	</td>
	      	<td>
	      		
	      		<!-- <input class="form-check-input" id="is_carousel" type="checkbox" name="is_carousel" <?php echo (!empty($tourCardData->is_carousel) || empty($tourCardData)) ? 'checked' : ''; ?>> <label>Carousel</label> -->
	      	</td>
	      	<td></td>
	      	<td></td>
	      </tr>
	      
	      
	      <?php if (!empty($_GET['tid'])) {
	      	$tid = $_GET['tid']; ?>
	      	<tr>
	      		<td colspan="3">
	      			<div class="alert alert-success" id="copyText" role="alert">
	      			<?php echo htmlspecialchars("<div class='custom-tour-containe' data-id='$tid' id='tour-filter-plugin-".$tid."'></div>");?> &nbsp;
	      			<a href="javascript:void(0)" onclick="CopyToClipboard('copyText')"> <i class="fa fa-copy"></i></a>
	      		</div>
	      		</td>
	      </tr>
	      <?php } ?>	    
	</table>
	<input type="hidden" name="id" value="<?php echo (!empty($tourCardData)) ? $tourCardData->id : '' ?>">
	<input type="hidden" name="action" value="<?php echo (!empty($tourCardData)) ? 'tourcard_update_form' : 'tourcard_submit_form' ?>">
	<input type="submit" name="" value="<?php echo (!empty($tourCardData)) ? 'Update' : 'Submit' ?>" class="btn btn-primary" id="submit">
	<!-- <input type="button" name="" value="Reset" class="btn btn-default"  onclick="this.form.reset();"> -->
	
	</form>
	<hr>
	<?php if ( filter_input( INPUT_GET, 'message' ) === 'created' ) : 
    echo '<div class="alert alert-success" role="alert">Created Successfully</div>';
    elseif ( filter_input( INPUT_GET, 'message' ) === 'updated' ) : 
    	echo '<div class="alert alert-success" role="alert">Updated Successfully</div>';
    elseif ( filter_input( INPUT_GET, 'message' ) === 'deleted' ) : 
    	echo '<div class="alert alert-success" role="alert">Deleted Successfully</div>';
	endif ?>
	

	<table class="table table-bordered" id="myTable">
    <thead>
      <tr>
        <th>No.</th>
        <th>Title</th>
        <th>Container</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    	<?php $allFilters = $wpdb->get_results( "SELECT id,heading FROM tbltourcardplugin  ", OBJECT );
    	if (!empty($allFilters)) {
    		foreach ($allFilters as $key => $value) { ?>
    			<tr>
		        <td><?php echo $key+1; ?></td>
		        <td><?php echo $value->heading; ?></td>
		        <td>
		        	<div id="copyText<?php echo $value->id;?>"><?php echo htmlspecialchars("<div class='custom-tour-container' data-id='".$value->id."' id='tour-filter-plugin-".$value->id."'></div>");?>
		        		<a href="javascript:void(0)" onclick="CopyToClipboard('copyText<?php echo $value->id;?>')"> <i class="fa fa-copy"></i></a>
		        	</div>
		        </td>
		        <td>
		        	<form action="<?php echo admin_url('admin-post.php'); ?>" method="POST">
					      <input type="hidden" name="action" value="tour_card_delete">
					      <input type="hidden" name="id" value="<?php echo $value->id; ?> ">
					      <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo admin_url('admin.php?page=tour-carousel&eid='.$value->id) ?>" class="btn btn-success btn-sm rounded-0" ><i class="fa fa-edit"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button type="submit" class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                    </li>
                </ul>
					    </form>

					  </td>
		      </tr>
    	<?php	}
    	 } ?>
    </tbody>
  </table>
</div>
<?php 
if (!empty($tourCardData)) {
	if ($tourCardData->type == 'tour') {
		echo "<script>$('#themeRow').hide();
			$('#tourRow').show();
			</script>";
	}
	else{
		echo "<script>$('#themeRow').show();
			$('#tourRow').hide();
			</script>";
	}
}
else{
	echo "<script>$('#themeRow').hide();
			$('#tourRow').show();
			</script>";
}

?>
<script type="text/javascript">
	//multiselect
	jQuery('#ddlMultiselect').multiselect({
	    columns: 1,
	    placeholder: 'Select Tour',
	    search: true,
	    numberDisplayed:3
	});
	
	$('input[name="type"]').change(function(e) {
	  	var inputType = $(this).val();
	  	if (inputType=='tour') {
			$('#tourRow').show();
			$('#themeRow').hide();
		}
		else{
			$('#tourRow').hide();
			$('#themeRow').show();
		}
	});

$('#ddlMultiselect').change(function(e) {
    var selected = $(e.target).val();
    console.log(selected);
    if (selected!='' && selected!= null && selected.length > 0) {
    	$('#theme_id').val('');

    }
});

jQuery('#theme_id').change(function(e) {
    var selected = jQuery(e.target).val();
    console.log(selected);
    if (selected > 0) {
		jQuery("#ddlMultiselect").multiselect( 'reload' );

    }
}); 

//datepiker
jQuery(function() {
    jQuery( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        jQuery( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    jQuery( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        jQuery( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });

// form submit validation
jQuery(document).ready( function () {
	jQuery("#submit").click(function(e){
		if(jQuery('.form-check-input:checked').size() <= 0 ) {
			e.preventDefault();
			jQuery('#error').show().html("<p>Please select filter option</p>");
			return false;
		}	
		jQuery('#error').hide();
		jQuery('form#filter-option-form').submit();
	});
	//datatable
	jQuery('#myTable').DataTable();
});

//copy to clipboard
function CopyToClipboard(id){
    var r = document.createRange();
    r.selectNode(document.getElementById(id));
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(r);
    try {
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
        alert('copied text' );
    } catch (err) {
        console.log('Unable to copy!');
    }
}

function edit(id) {
  jQuery.ajax({
    url: '<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>', 
    type: 'POST',
    dataType: "json",
    data:{
      action: 'getFilterDataById',
      id: id
    },
    success: function( data ){
    	jQuery("html, body").animate({ scrollTop: 0 }, "slow");
    	jQuery('input[name=title]').val(data.data.title);
    	if (data.data.passenger > 0) {
    		jQuery('input[name=passenger]').prop('checked',true);
    		jQuery('input[name=num_of_passenger]').val(data.data.num_of_passenger);
    	}
    	if (data.data.country > 0) {
    		jQuery('input[name=country]').prop('checked',true);
    		var country_id = data.data.country_id
    		jQuery.each(country_id.split(","), function(i,e){
				    jQuery(".multiselect").find("option[value="+e+"]").prop("selected", "selected");
				});
				jQuery(".multiselect").multiselect('reload');
    	}
    	if (data.data.theme > 0) {
    		jQuery('input[name=theme]').prop('checked',true);
    		jQuery('select[name=theme_id]').val(data.data.theme_id);
    	}
    	if (data.data.date > 0) {
    		jQuery('input[name=date]').prop('checked',true);
    		jQuery('input[name=date_from]').val(data.data.date_from);
    		jQuery('input[name=date_to]').val(data.data.date_to);
    	}
    	jQuery('input[name=action]').val('ch_search_option_edit_form');
    	jQuery('input[name=id]').val(data.data.id);
    	jQuery('#submit').val('Update');
    	
      //Do something with the result from server
      console.log( data );
    }
  });
}
jQuery('#reset').click(function(){
      jQuery('#filter-option-form').reset();
});
</script>
