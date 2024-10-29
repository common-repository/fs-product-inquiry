/*
* Show inquiry form
*/
function showInquiryForm(product_id){
	jQuery('input[name=_fs_product_id]').val(product_id);
	jQuery.ajax({
		url:ajax_obj.ajaxurl,
		type:'POST',
		data:{'action': 'fspi_get_inquiry_attribute','product_id':product_id},
		success:function(response){
			jQuery('.fspi_add_attributes_fields').html(response);
			jQuery('.fspi-loader-'+product_id).hide();
			jQuery('#fspi-model').modal('show'); 
		}
	});
}

function fspiCK(product_id){
	jQuery('.fspi-loader-'+product_id).show();
	jQuery.ajax({
		url:ajax_obj.ajaxurl,
		type:'POST',
		data:{'action': 'fspi_ck_loopul'},
		success:function(response){
			if(response==true){
				showInquiryForm(product_id);
			}else{
				jQuery('.fspi-loader-'+product_id).hide();
				alert('Your licence key is not valid. Please activate valid licence key.');
			}
		}
	});
}



function resetSearchProduct(){
	jQuery('#inputSearch').val('');
	jQuery('#productSearchForm').submit();
}