/**
 * Jquery Validation Configuration for the form
 */

$(document).ready(function() {

	if($("input[type=radio][name='student_type']:checked").val() == "Other"){
		$("#div_other").show();
	}
	else
	{
		$("#div_other").hide();
	}



    /**
     * Question: Are you a local or international student?
     * When field selected: Other
	 * Field required: Other
	 */
	if($("input[name='student_type']").change(function() {
		if($(this).val() == "Other") {
			$("#div_other").show("slow").focus();
			// $("#other").prop("required",true);
		}
		else {
			$("#div_other").hide("slow").focus();
			// $("#other").prop("required",false);
            $("#other").prop("value","");
		}
	}));



	/** validate form */
	$("#standard").validate({
		rules: {
			full_name: {
				required: true,
				minlength: 3
			},
			email: {
				required: true,
				email: true
			},
			comments: {
				required: true
			},
			student_type: {
				required: true
			},
			other:{
				required:{
					depends:function(element){
						return $("input[type=radio][name='student_type']:checked").val() == "Other";
					}
				}
			},
			'student_interest[]': {
				required: true
			},
			'faculty[]': {
				required: true
			},
			campus: {
				required: true
			},
			file_to_upload:{
				required:true
			}
		},
		errorElement: "label",

		errorPlacement: function (error, element) {
		    if (element.attr("type") == "radio") {
		        error.insertAfter( element.closest('div').find('label.error'));
		    } else if (element.attr("type") == "checkbox") {
		        error.insertAfter( element.closest('div').find('label.error'));
		    }
		    else {
		        error.insertAfter( element );
		    }
		},

		  success: function(label) {
		    label.text("")
		  },


		messages: {

		/** Leave blank to use default messages for all fields
		 *	otherwise set them individually
		 */
			/*
			full_name: {
				required: "This field is required"
			},
			email: {
				required: "This field is required"
			},
			comments: {
				required: "This field is required"
			},
			student_type: {
				required: "This field is required"
			},
			other: {
				required: "This field is required"
			},
			'student_interest[]': {
				required:"This field is requied"
			},
			'faculty[]': {
				required: "This field is required"
			},
			campus: {
				required: "This field is required"
			}
			file_to_upload:{
				required:"This field is required"
			}
		 */
		}
	});

});
