<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<script src='<?php echo url("/")."/public/web/js/jquery.min.js" ?>'></script>
</head>
<body>


<?php 

		if(isset($data))
		{
?>


			<script>
						setTimeout(function(){
												window.postMessage('<?php print_r($data);?>', '*');
											},1000);
						window.addEventListener("message", function(event)  {
																				logMessage(event.data);
																			}, false);

						function logMessage(message) {}
						
			</script>

<?php 
		}
		else
		{
?>

			<div style="
														position: absolute;
														top: 50%;
														left: 50%;
														margin-top: -50px;
														margin-left: -50px;
														width: 100px;
														height: 100px;
													"
													 align="center" >
											 Loading ...
			 </div>
											  
				<form id="myform" name="myform" method="post" action="https://sandbox.interswitchng.com/collections/w/pay">
										<input id="entity_id" 			name="entity_id" type="hidden"  />
										<input id="txn_ref" 			name="txn_ref" type="hidden"  />
										<input id="product_id" 			name="product_id" type="hidden"  />
										<input id="pay_item_id" 		name="pay_item_id" type="hidden"  />
										<input id="amount" 				name="amount" type="hidden"  />
										<input id="currency" 			name="currency" type="hidden"  />
										<input id="site_redirect_url" 	name="site_redirect_url" type="hidden" />
										<input id="cust_id" 			name="cust_id" type="hidden" />
										<input id="site_name" 			name="site_name" type="hidden" />
										<input id="cust_name" 			name="cust_name" type="hidden"  />
										<input id="hash" 				name="hash" type="hidden"  />
										{{ csrf_field() }}
										
				</form>	

				<script type="text/javascript">
					$(document).ready(function()
					{
						document.addEventListener("message", function (event) 
						{
							logMessage(event.data);
							
						}, false);
						
						function logMessage(message)
						{
						//	alert(message);
							//var message = '{"txn_ref":"abc1231515392131079","amount":"100","cust_name":"Mehran"}'; 
						
							
							var data = JSON.parse(message);
							
							var txt_ref = data['txn_ref']; 
							var amount = data['amount']; 
							var cust_name = data['cust_name']; 
							
						
							$.ajax ({
											url: "{{route('process_payment')}}",
											type: 'get',
											data:   
												{
													txt_ref: txt_ref,
													amount: amount,
													cust_name: cust_name
												},
											dataType: 'json' ,
											success: function (data)
											{
											
												
												$("#txn_ref").val(data['txn_ref']);
												$("#entity_id").val(data['entity_id']);
												$("#product_id").val(data['product_id']);
												$("#pay_item_id").val(data['pay_item_id']);
												$("#amount").val(data['amount']);
												$("#currency").val(data['currency']);
												$("#site_redirect_url").val(data['site_redirect_url']);
												$("#cust_id").val(data['cust_id']);
												$("#site_name").val(data['site_name']);
												$("#cust_name").val(data['cust_name']);
												$("#hash").val(data['hash']);
												$( "#myform" ).submit();
																				
											}

									});
									
							
									
						}
						//logMessage('');

					});
					
				</script>
				
<?php 
		}
?>

</body>
</html>

