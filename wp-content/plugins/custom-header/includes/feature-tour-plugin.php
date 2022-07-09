<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php global $wpdb;
$toursData = $wpdb->get_results( "SELECT tName,tourID_Admin FROM tbltours where tName != '' and  tStatus in (1,62) order by tName asc ", OBJECT );

if (isset($_GET['eid'])) {
	$eid = $_GET['eid'];
  $tourCardData = $wpdb->get_row("SELECT * FROM tblfeaturetourplugin WHERE id='$eid'");
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
	      	<td class="select-btn"><input class="form-control" id="title" type="text" name="title" value="<?php echo !empty($tourCardData->title) ? $tourCardData->title : ''; ?>"></td>
	      </tr>
	      <tr>
	      	<td>Tour</td>
	        <td class="select-btn">
	        	<select class="form-control"  name="tour_id[]" >
	        		<?php if (!empty($toursData)) {
	        		foreach ($toursData as $key => $value) { ?>
	        		 	<option value="<?php echo $value->tourID_Admin; ?>" <?php echo (!empty($tourIdArray) && in_array($value->tourID_Admin, $tourIdArray)) ? 'selected' : '' ;?>  ><?php echo $value->tName; ?></option>
	        		<?php } 
	        		} ?>
	        	</select>
	        </td>
	      </tr>
	      <tr>
	      	<td>
	      		Display banner
	      	</td>
	      	<td>
	      		<input class="form-check-input" id="is_display_banner" type="checkbox" name="is_display_banner" <?php echo (!empty($tourCardData->is_display_banner) || empty($tourCardData)) ? 'checked' : ''; ?>>  
	      	</td>
	      </tr>
	      
	      
	      <?php if (!empty($_GET['tid'])) {
	      	$tid = $_GET['tid']; ?>
	      	<tr>
	      		<td colspan="3">
	      			<div class="alert alert-success" id="copyText" role="alert">
	      			<?php echo htmlspecialchars("<div class='featured-tour-container' data-id='$tid' id='featured-plugin-".$tid."'></div>");?> &nbsp;
	      			<a href="javascript:void(0)" onclick="CopyToClipboard('copyText')"> <i class="fa fa-copy"></i></a>
	      		</div>
	      		</td>
	      </tr>
	      <?php } ?>	    
	</table>
	<input type="hidden" name="id" value="<?php echo (!empty($tourCardData)) ? $tourCardData->id : '' ?>">
	<input type="hidden" name="action" value="<?php echo (!empty($tourCardData)) ? 'feature_tour_plugin_update_form' : 'feature_tour_plugin_submit_form' ?>">
	<input type="submit" name="" value="<?php echo (!empty($tourCardData)) ? 'Update' : 'Submit' ?>" class="btn btn-primary" >
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
    	<?php $allFilters = $wpdb->get_results( "SELECT * FROM tblfeaturetourplugin  ", OBJECT );
    	if (!empty($allFilters)) {
    		foreach ($allFilters as $key => $value) { ?>
    			<tr>
		        <td><?php echo $key+1; ?></td>
		        <td><?php echo $value->title ; ?></td>
		        <td>
		        	<div id="copyText<?php echo $value->id;?>"><?php echo htmlspecialchars("<div class='featured-tour-container' data-id='".$value->id."' id='featured-plugin-".$value->id."'></div>");?>
		        		<a href="javascript:void(0)" onclick="CopyToClipboard('copyText<?php echo $value->id;?>')"> <i class="fa fa-copy"></i></a>
		        	</div>
		        </td>
		        <td>
		        	<form action="<?php echo admin_url('admin-post.php'); ?>" method="POST">
					      <input type="hidden" name="action" value="feature_tour_plugin_delete">
					      <input type="hidden" name="id" value="<?php echo $value->id; ?> ">
					      <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo admin_url('admin.php?page=feature-tour-plugin&eid='.$value->id) ?>" class="btn btn-success btn-sm rounded-0" ><i class="fa fa-edit"></i></a>
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
