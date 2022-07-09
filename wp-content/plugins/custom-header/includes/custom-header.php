<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
	.ms-options-wrap > .ms-options > ul input[type="checkbox"] {
	    top: 16px !important;
	    left: 5px !important;
	}
	.dataTables_wrapper .dataTables_length select {
	    width: 60px !important;
	}
</style>
<?php global $wpdb;
$country_res = $wpdb->get_results( "SELECT cName,countryID FROM tblCountries where `cName` != '' order by cName asc ", OBJECT );
$theme_res = $wpdb->get_results( "SELECT tName,themeID FROM tblThemes where `tName` != '' order by tName asc", OBJECT );
	 ?>
<div class="container">
	<form id="filter-option-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" >			

	<table class="table">
	    <thead>
	      <tr>
	      	<th>Publish</th>
	        <th>Search Option</th>
	        <th>Setting</th>
	      </tr>
	    </thead>
	    <tbody>
	    	<tr>
	      	<td></td>
	        <td>Title</td>
	        <td>
	        	<input class="form-control" type="text" name="title" value="" placeholder="Enter Title">
	        </td>
	      </tr>
	      <tr>
	      	<td>
	      		<input class="form-check-input" id="passenger" type="checkbox" name="passenger">
	      	</td>
	        <td>Passenger</td>
	        <td>
	        	<input class="form-control" type="number" name="num_of_passenger" max="12" min="0" value="0" >
	        </td>
	      </tr>
	      <tr>
	      	<td>
	      		<input class="form-check-input" type="checkbox" name="country">
	      	</td>
	        <td>Countries</td>
	        <td>
	        	<select class="form-check-input multiselect" multiple name="country_id[]">
	        		<?php if (!empty($country_res)) {
	        		foreach ($country_res as $key => $value) { ?>
	        		 	<option value="<?php echo $value->countryID; ?>"><?php echo $value->cName; ?></option>
	        		<?php } 
	        		} ?>
	        	</select>
	        </td>
	      </tr>
	      <tr>
	      	<td>
	      		<input class="form-check-input" type="checkbox" name="theme" >
	      	</td>
	        <td>Themes</td>
	        <td>
	        	<select class="form-control" name="theme_id" style=" max-width: 100%;">
	        		<option value="">Themes</option>
	        		<?php if (!empty($theme_res)) {
	        		foreach ($theme_res as $key => $value) { ?>
	        		 	<option value="<?php echo $value->themeID; ?>"><?php echo $value->tName; ?></option>
	        		<?php } 
	        		} ?>
	        	</select>
	        </td>
	      </tr>
	      <tr>
	      	<td>
	      		<input class="form-check-input" type="checkbox" name="date" >
	      	</td>
	        <td>All Date</td>
	        <td>
	        	<label for="from">from:</label>
			    <input type="text" id="from" name="date_from" placeholder="mm/dd/yyyy">
			    <label for="to">to:</label>
			    <input type="text" id="to" name="date_to" placeholder="mm/dd/yyyy">
	        </td>
	      </tr>
	      <tr>
	      		<td colspan="3">
	      			<div class="alert alert-danger" style="display: none;" id="error" role="alert">
	      			</div>
	      		</td>
	      </tr>
	      <?php if (!empty($_GET['chid'])) {
	      	$chid = $_GET['chid']; ?>
	      	<tr>
	      		<td colspan="3">
	      			<div class="alert alert-success" id="copyText" role="alert">
	      			<?php echo htmlspecialchars("<div class='custom-header-container' id='$chid'></div>");?> &nbsp;
	      			<a href="javascript:void(0)" onclick="CopyToClipboard('copyText')"> <i class="fa fa-copy"></i></a>
	      		</div>
	      		</td>
	      </tr>
	      <?php } ?>
	      
	    </tbody>
	</table>
	<input type="hidden" name="max_country_filter" value="3">
	<input type="hidden" name="id" value="">
	<input type="hidden" name="action" value="ch_search_option_form">
	<input type="submit" name="" value="Submit" class="btn btn-primary" id="submit">
	<input type="button" name="" value="Reset" class="btn btn-default"  onclick="this.form.reset();">
	
	</form>
	<hr>
	<?php if ( filter_input( INPUT_GET, 'message' ) === 'updated' ) : 
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
    	<?php $allFilters = $wpdb->get_results( "SELECT id,title FROM tblsearch_option  ", OBJECT );
    	if (!empty($allFilters)) {
    		foreach ($allFilters as $key => $value) { ?>
    			<tr>
		        <td><?php echo $key+1; ?></td>
		        <td><?php echo $value->title; ?></td>
		        <td>
		        	<div id="copyText<?php echo $value->id;?>"><?php echo htmlspecialchars("<div class='custom-header-container' id='".$value->id."'></div>");?>
		        		<a href="javascript:void(0)" onclick="CopyToClipboard('copyText<?php echo $value->id;?>')"> <i class="fa fa-copy"></i></a>
		        	</div>
		        </td>
		        <td>
		        	<form action="<?php echo admin_url('admin-post.php'); ?>" method="POST">
					      <input type="hidden" name="action" value="filter_delete_event">
					      <input type="hidden" name="id" value="<?php echo $value->id; ?> ">
					      <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <button onclick="edit('<?php echo $value->id ; ?>')" class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
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
<script type="text/javascript">
	//multiselect
jQuery('.multiselect').multiselect({
    columns: 1,
    placeholder: 'Select',
    search: true,
    numberDisplayed:9
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
