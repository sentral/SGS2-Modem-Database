			$(document).ready(function() {
				// setup forms
				var optionsMain = {
					target:			'#content',
					beforeSubmit:	validateMain,
					success:		afterPost
				};
				
				$('#query-main').ajaxForm(optionsMain);
				$('#query_db').button().click(function() {
						$('#query-main').ajaxSubmit(optionsMain);
					});
				$('#add_db').button().click(function() {
						loadContent("add_db.php");
					});
				
				function validateMain(formData, jqForm, options) {
					// formData is an array; here we use $.param to convert it to a string to display it 
					// but the form plugin does this for you automatically when it submits the data 
					//var queryString = $.param(formData); 

					// jqForm is a jQuery object encapsulating the form element.  To access the 
					// DOM element for the form do this: 
					// var formElement = jqForm[0]; 

					//alert('About to submit: \n\n' + queryString);
					
					var valid = true;

					// here we could return false to prevent the form from being submitted; 
					// returning anything other than false will allow the form submit to continue 
					return valid; 
				}
				
				// post-submit callback 
				function afterPost(responseText, statusText, xhr, $form)  { 
					// for normal html responses, the first argument to the success callback 
					// is the XMLHttpRequest object's responseText property 

					// if the ajaxSubmit method was passed an Options Object with the dataType 
					// property set to 'xml' then the first argument to the success callback 
					// is the XMLHttpRequest object's responseXML property 

					// if the ajaxSubmit method was passed an Options Object with the dataType 
					// property set to 'json' then the first argument to the success callback 
					// is the json data object returned by the server 

					//alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
					//  '\n\nThe output div should have already been updated with the responseText.');
				}
				
				//function handleMainSelects() {
				//	if ($("#mainform select[name=mainselect] option:selected").val() == "NULL") {
				//		$("#mainform select[name=timeselect]").removeAttr('selected');
				//	}
				//	else {
				//		$("#mainform").submit();
				//		$("#graph_out").dialog('open');
				//	}
				//}
				
				// jQuery ui combobox widgets
				//$("#analysis").combobox({
				//	selected: function(event, ui) {
				//					handleMainSelects();
				//				}
				//});
				//$('#analysis_d > input.ui-autocomplete-input').css('width', '200px');
				//$("#timerange").combobox({
				//	selected: function(event, ui) {
				//					handleMainSelects();
				//				}
				//});

				function loadContent(toLoad) {
					//alert("loadContent()");
					//$.ajax({
					//	url: toLoad,
					//	async: false,
					//	success: function(data) {
					//		alert(data);
							// detach the menu click event
					//		$("#content").html(data);
					//	}
					//});
					$('#content').load(toLoad, function(response, status, xhr) {
						if (status == "error") {
							$("#content").html("An error occured: " + xhr.status + " - " + xhr.statusText);
						}
					});
					//$('#content').dialog('open');
				}
			});
