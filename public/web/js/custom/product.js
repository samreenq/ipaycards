/*!
 * Product 1.0.1
 * Today Today
 *
 * Released under the Cubix Inc
 * 
 */
 
	/* 
		$('#signup').bind('click', function() {
			$('input:text[required]').parent().show();
		});
	
	*/
	$('.signupmodal').modal('hide');
	$('.pVerfymodal').modal('hide');
	$('.siginmodal').modal('hide');
	$(".open_siginmodal").on("click", function (e) 
	{	
		$('.signupmodal').modal('hide');
		$('.siginmodal').modal('show');
	});
	
	$(".open_sigupmodal").on("click", function (e) 
	{	
		$('.siginmodal').modal('hide');
		$('.signupmodal').modal('show');
	});
	
	$(".open_chgPassmodal").on("click", function (e) 
	{	
		$('.siginmodal').modal('hide');
		$('.chgPassmodal').modal('show');
	});
	
	$(".open_forPassmodal").on("click", function (e) 
	{	
		$('.siginmodal').modal('hide');
		$('.forPassmodal').modal('show');
	});
		
	
	$(".nextBtn5").on("click", function (e) 
		{	
			
				allNextBtn = $('.nextBtn1');
				allNextBtn.click(function () 
				{
                    var curStep = $(this).closest(".setup-content"),
                        curStepBtn = curStep.attr("id"),
                        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                        curInputs = curStep.find("input[type='text'],input[type='email'],input[type='password'],input[type='url']"),
                        isValid = true;

                    $(".fluid-label").removeClass("has-error");
					
                    for (var i = 0; i < curInputs.length; i++) {
                        if (!curInputs[i].validity.valid) {
                            isValid = false;
                            $(curInputs[i]).closest(".fluid-label").addClass("has-error");
                        }
                    }

                    if (isValid)
					{
						
							signinUrl = $('#url1').val();
							email = $('#email').val();
							password2 = $('#password2').val();
							$.ajax ({		
									url: signinUrl,
									data:{
												email		   : email,
												password	   : password2,
												entity_type_id : 11
										 },
									type: 'get',
									dataType: 'json',
									success: function(data)
									{		
										if(data['error']==1) 
										{
											$(".signupError").addClass('alert alert-danger');
											$(".signupError").css("color", "red");
											$(".signupError").css("background-color",'#f8d7da');
											$(".signupError").css("border-color",'#f5c6cb');
											$(".signupError").empty().append(data['message']);
											
											
										}
										else 
										{
											
											$(".signupError").empty().append('');
											$(".signupError").css("", "");
											$(".signupError").removeClass('alert alert-danger');
											nextStepWizard.removeAttr('disabled').trigger('click');
										}
															
									}
							});
						
                       
					}
					else 
					{
						
					}
					
					$('#nav-close').on('click', function (e) {
						e.preventDefault();
						$('body').removeClass('nav-expanded');
					});
			
                });
		}); 
	
	
	
	if(typeof(localStorage.products)!=="undefined")
	{
		var products = JSON.parse(localStorage.products);
		if(products.length>=1)
		{		
			
			$(".check_out").css({ 'background-color': "#139CB4" });
			$(".check_out").css({ 'display': "block" });
		}
		else
		{
			$(".check_out").css({ 'background-color': "#8080808f" });
			$(".check_out").css({ 'display': "none" });
		}
	
	}
	else
	{
		$(".check_out").css({ 'background-color': "#8080808f" });
		$(".check_out").css({ 'display': "none" });
	}
	
	function deliverytime(getAllTimeSlotsUrl)
	{
			var myDate = new Date($('.day').val());
			var Day = myDate.getDay();
			//var final_date = myDate.getDay()+"-"+(myDate.getMonth()+1)+"-"+myDate.getFullYear();
			$.ajax ({		
						url: getAllTimeSlotsUrl,
						data:{
									day		: Day 
							 },
						type: 'get',
						dataType: 'text',
						success: function(data)
						{		
							$(".time").empty().append(data);
						}
					});
	}
	
	function termAndCondition(termAndConditionUrl)
	{
			$("#LoadingTermAndConditionImage").show();
			$.ajax ({		
						url: termAndConditionUrl,
						type: 'get',
						dataType: 'text',
						success: function(data)
						{		
							$("#LoadingTermAndConditionImage").hide();	
							$("#termAndCondition").empty().append(data); 	
						}
					});
	}
	
	function frequentAskedQuestions(faqUrl)
	{
			$("#LoadingFrequentAskedQuestionsImage").show();
			$.ajax ({		
						url: faqUrl,
						type: 'get',
						dataType: 'text',
						success: function(data)
						{		
							$("#LoadingFrequentAskedQuestionsImage").hide();					
							$("#frequentAskedQuestions").empty().append(data); 	
						}
					});
	}
	
	function popularCategories(Request_url)
	{
			$("#LoadingPopularCategoriesImage").show();
			$.ajax ({		
						url: Request_url,
						type: 'get',
						dataType: 'text',
						success: function(data)
						{		
							$("#LoadingPopularCategoriesImage").hide();					
							$(".popularCategories").empty().append(data); 	
						}
					});
	}
		
	
	function todayTodayEssentials(Entity_type_id,Featured_type,Request_url1,Product_detail_url,Request_url2,Request_url3,Request_url4)
	{
			$("#LoadingtodayTodayEssentialsImage").show();
			$.ajax ({		
						url: Request_url1,
						type: 'get',
						data:{
										entity_type_id		: 	Entity_type_id 		,
										product_detail_url	:	Product_detail_url	,
										featured_type		:	Featured_type		
							 },
						dataType: 'text',
						success: function(data)
						{		
									$("#LoadingtodayTodayEssentialsImage").hide();					
									$(".todayTodayEssentials").empty().append(data); 	
									add_to_wishlist(Request_url2);
									
									// Add Cart Btn Animation
									$('.addtocart').on('click',function(){
										$(this).hide();
										//var abc = $(this).parent().find('.pro-inc-wrap').toggle( "slide");
										var element  = $(this).parent('.product-detail');
										var ele_id = $(element).attr('id');
										$('#'+ele_id).find('.pro-inc-wrap').toggle( "slide");

									});

									
									
									//Inc Dec Button----------------
									$(".incr-btn55").on("click", function (e) {
                                        var $button = $(this);
                                        var oldValue = $button.parent().find('.quantity').val();

                                        if((oldValue <= 4 && $button.data('action') == "increase") || $button.data('action') == "decrease") {

                                        var entity_id = $button.parent().find('.entity_id').val();
                                        var product_code = $button.parent().find('.product_code').val();
                                        var title = $button.parent().find('.title').val();
                                        var thumb = $button.parent().find('.thumb').val();
                                        var price = $button.parent().find('.price').val();
                                        var item_type = $button.parent().find('.item_type').val();
                                        /*var	weight 		 		= $button.parent().find('.weight').val();
                                        var	unit_option  		= $button.parent().find('.unit_option').val();
                                        var	unit_value 	 		= $button.parent().find('.unit_value').val();*/

                                        $button.parent().find('.incr-btn5[data-action="decrease"]').removeClass('inactive');
                                        if (oldValue == "0") {
                                            //	var oldValue = parseFloat(oldValue) + 1;
                                            //var newVal	= oldValue;
                                        }
                                        if ($button.data('action') == "increase") {
                                            var newVal = parseFloat(oldValue) + 1;
                                        }
                                        if ($button.data('action') == "decrease") {
                                            // Don't allow decrementing below 1
                                            if (oldValue > 1) {
                                                var newVal = parseFloat(oldValue) - 1;
                                            } else {
                                                newVal = 1;
                                                $button.addClass('inactive');

                                                $button.parent().parent().hide();
                                                $button.parent().parent().parent().find('.addtocart').show();
                                                deleteCartProduct(product_code, Request_url3, Request_url4, Request_url2);
                                            }
                                        }


                                        $button.parent().find('.quantity').val(newVal);
                                        product_quantity = newVal;

                                        if (product_quantity > 1) {
                                            if (typeof(localStorage.products) == "undefined") {
                                                var string = '[{"entity_id":' + entity_id + ',"product_code":"' + product_code + '","title":"' + title + '","thumb":"' + thumb + '","price":"' + price + '","item_type":"' + item_type + '","product_quantity":' + parseInt(product_quantity) + '}]';
                                                localStorage.products = string;
                                                console.log('sam', localStorage.products);
                                            }

                                            if (typeof(localStorage.products) !== "undefined") {
                                                var products = JSON.parse(localStorage.products);
                                                var products1 = [];
                                                n = 0;
                                                for (var i = 0; i < products.length; i++) {
                                                    if (product_code === products[i].product_code) {
                                                        //products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity);
                                                        products[i].product_quantity = parseInt(product_quantity);
                                                        n = 0;
                                                        break;
                                                    }
                                                    else {
                                                        n = 1;
                                                    }
                                                }
                                                if (n == 1) {
                                                    var len = products1.length;
                                                    var string = {
                                                        "entity_id": entity_id,
                                                        "product_code": product_code,
                                                        "title": title,
                                                        "thumb": thumb,
                                                        "price": price,
                                                        "item_type": item_type,
                                                        /*"weight":weight,
                                                        "unit_option":unit_option,
                                                        "unit_value":unit_value,*/
                                                        "product_quantity": parseInt(product_quantity)
                                                    };
                                                    products.push(string);
                                                }
                                                localStorage.setItem("products", JSON.stringify(products));
                                                total(Request_url4);
                                            }
                                        }
                                        load_cart(Request_url3, Request_url4);
                                        e.preventDefault();
                                    	}
									});	
									
									
									//Inc Dec Button----------------
									$(".addtocart").on("click", function (e) 
									{
										var $button = $(this);
										var oldValue = $button.parent().find('.quantity').val();
									
										var entity_id 			= $button.parent().find('.entity_id').val();
										var product_code 		= $button.parent().find('.product_code').val();
										 
										var	title 		 		= $button.parent().find('.title').val();
										var	thumb 		 		= $button.parent().find('.thumb').val();
										var	price   		= $button.parent().find('.price').val();
                                        var	item_type   		= $button.parent().find('.item_type').val();
									/*	var	weight 		 		= $button.parent().find('.weight').val();
										var	unit_option  		= $button.parent().find('.unit_option').val();
										var	unit_value 	 		= $button.parent().find('.unit_value').val();*/
										
										$button.parent().find('.incr-btn5[data-action="decrease"]').removeClass('inactive');
										if(oldValue=="0") 
										{
											//var oldValue = parseFloat(oldValue) + 1;
										//	var newVal	= oldValue;
										}
										if ($button.data('action') == "increase") {
											var newVal = parseFloat(oldValue) + 1;
										}
										if ($button.data('action') == "decrease") 
										{
											// Don't allow decrementing below 1
											if (oldValue > 1) {
												var newVal = parseFloat(oldValue) - 1;
											} else {
												newVal = 1;
												$button.addClass('inactive');
												$('.pro-inc-wrap').hide();
												$('.addtocart').show();
												deleteCartProduct(product_code,Request_url3,Request_url4,Request_url2);
											}
										}
										
										
										if(oldValue=="1") 
										{
											 oldValue = parseFloat(oldValue);
											var newVal	= oldValue;
										}
									
										//$button.parent().find('.quantity').val(newVal);
										product_quantity  = newVal;
										
										if(product_quantity==1)
										{
											if(typeof(localStorage.products)=="undefined")
											{
												var string =  '[{"entity_id":'+entity_id+',"product_code":"'+product_code+'","title":"'+title+'","thumb":"'+thumb+'","item_type":"'+item_type+'","price":"'+price+'","product_quantity":'+parseInt(product_quantity)+'}]';
												localStorage.products =string;
                                                console.log('sam',localStorage.products);
											}
					
											if(typeof(localStorage.products)!=="undefined")
											{
												var products = JSON.parse(localStorage.products);
												var products1 = [];
												n = 0 ; 
												for (var i = 0; i <products.length; i++) 
												{
													if(product_code === products[i].product_code)
													{  
													   //products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity); 
													   products[i].product_quantity  =  parseInt(product_quantity); 
													   n=0;
													   break;  
													}
													else 
													{
														n=1;
													}  
												}
												if ( n==1 )
												{
													var len = products1.length;
													var string = {
																	"entity_id":entity_id,
																	"product_code":product_code ,
																	"title":title,
																	"thumb":thumb,
																	"price":price,
                                                        "item_type":item_type,
																	/*"weight":weight,
																	"unit_option":unit_option,
																	"unit_value":unit_value,*/
																	"product_quantity":parseInt(product_quantity)
																 };
													products.push(string);
												}
												localStorage.setItem("products", JSON.stringify(products));
												total(Request_url4);				
											}	
										}											
										load_cart(Request_url3,Request_url4);
										e.preventDefault();
									});	
									
									
						}
					});
	}

	function topCategoryProducts(Entity_type_id,Featured_type,Request_url1,Product_detail_url,Request_url2,Request_url3,Request_url4)
	{
		$("#LoadingtopCategoriesImage").show();
		$.ajax ({
			url: Request_url1,
			type: 'get',
			data:{
				entity_type_id		: 	Entity_type_id 		,
				product_detail_url	:	Product_detail_url	,
				featured_type		:	Featured_type
			},
			dataType: 'text',
			success: function(data)
			{
				$("#LoadingtopCategoriesImage").hide();
				$(".topCategories").empty().append(data);
				add_to_wishlist(Request_url2);

				// Add Cart Btn Animation
				$('.addtocart').click(function(){
					$(this).hide();
					var abc = $(this).parent().find('.pro-inc-wrap').toggle( "slide");
				});


				//Inc Dec Button----------------
				$(".incr-btn5").on("click", function (e) {
                    var $button = $(this);
                    var oldValue = $button.parent().find('.quantity').val();

                   // alert(oldValue);
                    if((oldValue <= 4 && $button.data('action') == "increase") || $button.data('action') == "decrease") {

                    var entity_id = $button.parent().find('.entity_id').val();
                    var product_code = $button.parent().find('.product_code').val();
                    var title = $button.parent().find('.title').val();
                    var thumb = $button.parent().find('.thumb').val();
                    var price = $button.parent().find('.price').val();
                    /*var	weight 		 		= $button.parent().find('.weight').val();
                    var	unit_option  		= $button.parent().find('.unit_option').val();
                    var	unit_value 	 		= $button.parent().find('.unit_value').val();*/
                    var item_type = $button.parent().find('.item_type').val();

                    $button.parent().find('.incr-btn5[data-action="decrease"]').removeClass('inactive');
                    if (oldValue == "0") {
                        //	var oldValue = parseFloat(oldValue) + 1;
                        //var newVal	= oldValue;
                    }
                    if ($button.data('action') == "increase") {
                        var newVal = parseFloat(oldValue) + 1;
                    }

                    if ($button.data('action') == "decrease") {
                        // Don't allow decrementing below 1
                        if (oldValue > 1) {
                            var newVal = parseFloat(oldValue) - 1;
                        } else {
                            newVal = 1;
                            $button.addClass('inactive');

                            $button.parent().parent().hide();
                            $button.parent().parent().parent().find('.addtocart').show();
                            deleteCartProduct(product_code, Request_url3, Request_url4, Request_url2);
                        }
                    }


                    $button.parent().find('.quantity').val(newVal);
                    product_quantity = newVal;

                    if (product_quantity > 1) {
                        if (typeof(localStorage.products) == "undefined") {
                            var string = '[{"entity_id":' + entity_id + ',"product_code":"' + product_code + '","title":"' + title + '","thumb":"' + thumb + '","price":"' + price + '","item_type":"' + item_type + '","product_quantity":' + parseInt(product_quantity) + '}]';
                            localStorage["products"] = string;
                            console.log('sam', localStorage.products);
                        }

                        if (typeof(localStorage.products) !== "undefined") {
                            var products = JSON.parse(localStorage.products);
                            var products1 = [];
                            n = 0;
                            for (var i = 0; i < products.length; i++) {
                                if (product_code === products[i].product_code) {
                                    //products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity);
                                    products[i].product_quantity = parseInt(product_quantity);
                                    n = 0;
                                    break;
                                }
                                else {
                                    n = 1;
                                }
                            }
                            if (n == 1) {
                                var len = products1.length;
                                var string = {
                                    "entity_id": entity_id,
                                    "product_code": product_code,
                                    "title": title,
                                    "thumb": thumb,
                                    "price": price,
                                    "item_type": item_type,
                                    /*"weight":weight,
                                    "unit_option":unit_option,
                                    "unit_value":unit_value,*/
                                    "product_quantity": parseInt(product_quantity)
                                };
                                products.push(string);
                            }
                            localStorage.setItem("products", JSON.stringify(products));
                            total(Request_url4);
                        }
                    }
                    load_cart(Request_url3, Request_url4);
                    e.preventDefault();
                }
				});


				//Inc Dec Button----------------
				$(".addtocart").on("click", function (e)
				{
					var $button = $(this);
					var oldValue = $button.parent().find('.quantity').val();

					var entity_id 			= $button.parent().find('.entity_id').val();
					var product_code 		= $button.parent().find('.product_code').val();

					var	title 		 		= $button.parent().find('.title').val();
					var	thumb 		 		= $button.parent().find('.thumb').val();
					var	price   		= $button.parent().find('.price').val();
                    var	item_type   		= $button.parent().find('.item_type').val();
					/*var	weight 		 		= $button.parent().find('.weight').val();
					var	unit_option  		= $button.parent().find('.unit_option').val();
					var	unit_value 	 		= $button.parent().find('.unit_value').val();*/

					$button.parent().find('.incr-btn5[data-action="decrease"]').removeClass('inactive');
					if(oldValue=="0")
					{
						//var oldValue = parseFloat(oldValue) + 1;
						//	var newVal	= oldValue;
					}
					if ($button.data('action') == "increase") {
						var newVal = parseFloat(oldValue) + 1;
					}
					if ($button.data('action') == "decrease")
					{
						// Don't allow decrementing below 1
						if (oldValue > 1) {
							var newVal = parseFloat(oldValue) - 1;
						} else {
							newVal = 1;
							$button.addClass('inactive');
							$('.pro-inc-wrap').hide();
							$('.addtocart').show();
							deleteCartProduct(product_code,Request_url3,Request_url4,Request_url2);
						}
					}


					if(oldValue=="1")
					{
						oldValue = parseFloat(oldValue);
						var newVal	= oldValue;
					}

					//$button.parent().find('.quantity').val(newVal);
					product_quantity  = newVal;

					if(product_quantity==1)
					{
						if(typeof(localStorage.products)=="undefined")
						{
							var string =  '[{"entity_id":'+entity_id+',"product_code":"'+product_code+'","title":"'+title+'","thumb":"'+thumb+'","price":"'+price+'","item_type":"'+item_type+'","product_quantity":'+parseInt(product_quantity)+'}]';
							localStorage["products"] =string;
						}

						if(typeof(localStorage.products)!=="undefined")
						{
							var products = JSON.parse(localStorage.products);
							var products1 = [];
							n = 0 ;
							for (var i = 0; i <products.length; i++)
							{
								if(product_code === products[i].product_code)
								{
									//products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity);
									products[i].product_quantity  =  parseInt(product_quantity);
									n=0;
									break;
								}
								else
								{
									n=1;
								}
							}
							if ( n==1 )
							{
								var len = products1.length;
								var string = {
									"entity_id":entity_id,
									"product_code":product_code ,
									"title":title,
									"thumb":thumb,
									"price":price,
									"item_type" : item_type,
									/*"weight":weight,
									"unit_option":unit_option,
									"unit_value":unit_value,*/
									"product_quantity":parseInt(product_quantity)
								};
								products.push(string);
							}
							localStorage.setItem("products", JSON.stringify(products));
							total(Request_url4);
						}
					}
					load_cart(Request_url3,Request_url4);
					e.preventDefault();
				});


			}
		});
	}
function newsAndPeakSeasons(Entity_type_id,Featured_type,Request_url1,Request_url2,Request_url3,Request_url4,Product_detail_url,Request_url5)
{
    $("#LoadingnewsAndPeakSeasonsImage").show();
    $.ajax ({
        url: Request_url1,
        type: 'get',
        data:{
            entity_type_id		: 	Entity_type_id 		,
            product_detail_url	:	Product_detail_url	,
            featured_type		:	Featured_type
        },
        dataType: 'text',
        success: function(data)
        {
            $("#LoadingnewsAndPeakSeasonsImage").hide();
            $(".newsAndPeakSeasons").empty().append(data);
          //  add_to_wishlist(Request_url2);


            addCartProcess(Request_url2,Request_url3,Request_url4,Request_url5);

            // Add Cart Btn Animation

            $(".panel").on("click", function(e){
                var $_target =  $(e.currentTarget);
                var $_panelBody = $_target.find(".collapse");
                if($_panelBody){
                    $_panelBody.collapse('toggle')
                }
            });


            /*
            // Add Cart Btn Animation
            $('.addtocart').click(function(){
                $(this).hide();
                var abc = $(this).parent().find('.pro-inc-wrap').toggle( "slide");
            });
            */
            //Inc Dec Button----------------
           /* $(".incr-btn4").on("click", function (e)
            {

                var $button = $(this);
                var oldValue = $button.parent().find('.quantity').val();

                var entity_id 			= $button.parent().find('.entity_id').val();
                var product_code 		= $button.parent().find('.product_code').val();
                var	title 		 		= $button.parent().find('.title').val();
                var	thumb 		 		= $button.parent().find('.thumb').val();
                var	price   		= $button.parent().find('.price').val();
                var	item_type   		= $button.parent().find('.item_type').val();
                /!*var	weight 		 		= $button.parent().find('.weight').val();
                var	unit_option  		= $button.parent().find('.unit_option').val();
                var	unit_value 	 		= $button.parent().find('.unit_value').val();*!/

                $button.parent().find('.incr-btn4[data-action="decrease"]').removeClass('inactive');

                if ($button.data('action') == "increase") {
                    var newVal = parseFloat(oldValue) + 1;
                }
                if ($button.data('action') == "decrease")
                {
                    // Don't allow decrementing below 1
                    if (oldValue > 1) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 1;
                        $button.addClass('inactive');
                        //	$('.pro-inc-wrap')
                        $button.parent().parent().hide();
                        //$('.addtocart').
                        //	console.log($button.parent().parent().parent());
                        $button.parent().parent().parent().find('.addtocart').show();
                        deleteCartProduct(product_code,Request_url3,Request_url4,Request_url2);
                    }
                }

                if(oldValue=="0")
                {
                    // oldValue = parseFloat(oldValue) + 1;
                    //var newVal	= oldValue;
                }

                $button.parent().find('.quantity').val(newVal);
                product_quantity  = newVal;

                if(product_quantity>1)
                {
                    if(typeof(localStorage.products)=="undefined")
                    {
                        var string =  '[{"entity_id":'+entity_id+',"product_code":"'+product_code+'","title":"'+title+'","thumb":"'+thumb+'","price":"'+price+'","item_type":"'+item_type+'","product_quantity":'+parseInt(product_quantity)+'}]';
                        localStorage["products"] =string;
                    }

                    if(typeof(localStorage.products)!=="undefined")
                    {
                        var products = JSON.parse(localStorage.products);
                        var products1 = [];
                        n = 0 ;
                        for (var i = 0; i <products.length; i++)
                        {
                            if(product_code === products[i].product_code)
                            {
                                //products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity);
                                products[i].product_quantity  =  parseInt(product_quantity);
                                n=0;
                                break;
                            }
                            else
                            {
                                n=1;
                            }
                        }
                        if ( n==1 )
                        {
                            var len = products1.length;
                            var string = {
                                "entity_id":entity_id,
                                "product_code":product_code ,
                                "title":title,
                                "thumb":thumb,
                                "price":price,
								"item_type" : item_type,
                               /!* "weight":weight,
                                "unit_option":unit_option,
                                "unit_value":unit_value,*!/
                                "product_quantity":parseInt(product_quantity)
                            };
                            products.push(string);
                        }
                        localStorage.setItem("products", JSON.stringify(products));
                        total(Request_url4);
                    }
                }
                load_cart(Request_url3,Request_url4);
                e.preventDefault();
            });*/

            //Inc Dec Button----------------
            /*$(".addtocart").on("click", function (e)
            {

                var $button = $(this);
                var oldValue = $button.parent().find('.quantity').val();

                var entity_id 			= $button.parent().find('.entity_id').val();
                var product_code 		= $button.parent().find('.product_code').val();
                var	title 		 		= $button.parent().find('.title').val();
                var	thumb 		 		= $button.parent().find('.thumb').val();
                var	price   			= $button.parent().find('.price').val();
                var	item_type   		= $button.parent().find('.item_type').val();
               /!* var	weight 		 		= $button.parent().find('.weight').val();
                var	unit_option  		= $button.parent().find('.unit_option').val();
                var	unit_value 	 		= $button.parent().find('.unit_value').val();*!/

                $button.parent().find('.incr-btn4[data-action="decrease"]').removeClass('inactive');

                if ($button.data('action') == "increase") {
                    var newVal = parseFloat(oldValue) + 1;
                }
                if ($button.data('action') == "decrease")
                {
                    // Don't allow decrementing below 1
                    if (oldValue > 1) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 1;
                        $button.addClass('inactive');
                        $('.pro-inc-wrap').hide();
                        $('.addtocart').show();
                        deleteCartProduct(product_code,Request_url3,Request_url4,Request_url2);
                    }
                }

                if(oldValue=="1")
                {
                    oldValue = parseFloat(oldValue);
                    var newVal	= oldValue;
                }

                //$button.parent().find('.quantity').val(newVal);
                product_quantity  = newVal;

                if(product_quantity==1)
                {
                    if(typeof(localStorage.products)=="undefined")
                    {
                        var string =  '[{"entity_id":'+entity_id+',"product_code":"'+product_code+'","title":"'+title+'","thumb":"'+thumb+'","price":"'+price+'","item_type":"'+item_type+'","product_quantity":'+parseInt(product_quantity)+'}]';
                        localStorage["products"] =string;
                    }

                    if(typeof(localStorage.products)!=="undefined")
                    {
                        var products = JSON.parse(localStorage.products);
                        var products1 = [];
                        n = 0 ;
                        for (var i = 0; i <products.length; i++)
                        {
                            if(product_code === products[i].product_code)
                            {
                                //products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity);
                                products[i].product_quantity  =  parseInt(product_quantity);
                                n=0;
                                break;
                            }
                            else
                            {
                                n=1;
                            }
                        }
                        if ( n==1 )
                        {
                            var len = products1.length;
                            var string = {
                                "entity_id":entity_id,
                                "product_code":product_code ,
                                "title":title,
                                "thumb":thumb,
                                "price":price,
								"item_type" : item_type,
                                /!*"weight":weight,
                                "unit_option":unit_option,
                                "unit_value":unit_value,*!/
                                "product_quantity":parseInt(product_quantity)
                            };
                            products.push(string);
                        }
                        localStorage.setItem("products", JSON.stringify(products));
                        console.log(products);
                        total(Request_url4);
                    }
                }
                load_cart(Request_url3,Request_url4);
                e.preventDefault();

            });*/
            $(".page_showcase").css({ 'display': "block" });
        }


    });
}
	function brandProducts(Request_url1,Product_detail_url)
	{
			$("#LoadingbrandListImage").show();
			$.ajax ({
						url: Request_url1,
						type: 'get',
						data:{
										product_detail_url	:	Product_detail_url	,
							 },
						dataType: 'text',
						success: function(data)
						{
							$("#LoadingbrandListImage").hide();
							$(".brandList").empty().append(data);
							$(".page_showcase").css({ 'display': "block" });
						}


			});
	}

	function signin(Request_url)
	{
		$(".signIn").on("click", function (e)
		{	
		
							$.ajax ({
										
										url: Request_url,
										type: 'get',
										data:   {
													login_id	:	$('#login_id').val(),
													password	:	$('#password').val(), 
													url			:	'',
													cart_item    : localStorage.products,
												},
										dataType: 'json',
										success: function(data)
										{		

											if( data['error'] === 1 ) 
											{
												$(".signinError").addClass('alert alert-danger');
												$(".signinError").empty().append(data['message']);
											}
											else
											{
												if(data.data.total > 0){
													//console.log(JSON.stringify(data.data.products));
													var cart_product = [];

													$.each(data.data.products,function(k,v){
                                                        //console.log(v);
														var string = v;
                                                        string.product_quantity = parseInt(v.product_quantity)
                                                        cart_product.push(string);

													});

													//console.log(cart_product);
                                                    localStorage.setItem("products", JSON.stringify(cart_product));
												}
												else{
                                                    localStorage.removeItem('products');
												}
												window.location = $('#url').val();
											}
										}
									});
					
					
			
		});
	}
	
/*	function signup(Request_url1,Request_url2)
	{
				
		$("#signup").on("click", function (e) 
		{

			$.ajax
			({
				
				url: Request_url1,
				type: 'post',
				data:{
						email						:	$('#email').val()						,
						password					:	$('#password2').val()					, 
						first_name					:	$('#first_name').val()					, 
						last_name 					:	$('#last_name').val()					, 
						mobile_no					:	$('#mobile_no').val()					, 
						refer_friend_code_applied	:	$('#refer_friend_code_applied').val()	,
						_token						:   crsf_token,
                    	term_condition				: $('#term_condition').val(),
						url							:	''
					},
				dataType: 'json',
				success: function(data)
				{		
					if( data['error'] == 1 )
					{
						$(".signupError").addClass('alert alert-danger');
						//$("#error_msg_phone_verification").css("color", "red");
						$(".signupError").empty().append(data['message']);

					}
					else
					{
                        var phone_number   =  $('#mobile_no').val();
                        $(".phone_number").empty().append(phone_number);
                        $("#phone_number").val(phone_number);
                        $('.signupmodal').modal('hide');
                        $('.pVerfymodal').modal('toggle');
                        $("#entity_id").val(data['entity_id']);
                        $(".phone_verfication").on("click", function (e)
                        {
                            var code = $('#tel1').val()+$('#tel2').val()+$('#tel3').val()+$('#tel4').val();
                            if($('#tel1').val()=='' || $('#tel2').val()=='' || $('#tel3').val()=='' || $('#tel4').val()=='')
                            {
                                $("#error_msg_phone_verification").addClass('alert alert-danger');
                                //$("#error_msg_phone_verification").css("color", "red");
                                //$("#error_msg_phone_verification").css("background-color",'#f8d7da');
                                //$("#error_msg_phone_verification").css("border-color",'#f5c6cb');
                                $("#error_msg_phone_verification").empty().append('Please enter verification code!');

                            }
                            else
                            {
                                $.ajax
                                ({
                                    url: Request_url2,
                                    type: 'get',
                                    data:   {
                                        mobile_no			:	$('#mobile_no').val()	,
                                        verification_token	:	data['auth']['verification_token']	,
                                        verification_mode	:	'signup',
                                        entity_type_id		:	11,
                                        authy_code			:	code
                                    },
                                    dataType: 'json',
                                    success: function(data)
                                    {

                                        if( data['error'] == 1 )
                                        {
                                            $("#error_msg_phone_verification").addClass('alert alert-danger');
                                            //$("#error_msg_phone_verification").css("color", "red");
                                            $("#error_msg_phone_verification").empty().append(data['message']);
                                            //$('.signupmodal').modal('hide');
                                            //$('.pVerfymodal').modal('hide');
                                        }
                                        else
                                        {

                                            $("#error_msg_phone_verification").addClass('alert alert-success');
                                            //	$("#error_msg_phone_verification").css("color", "white");
                                            $("#error_msg_phone_verification").empty().append(data['message']);

                                            //$('.signupmodal').modal('hide');
                                           // $('.siginmodal').modal('hide');
                                            $('.pVerfymodal').modal('hide');
                                           // setTimeout(function() {/!*do something special*!/}, 2000);
                                            window.location = $('#url').val();
                                        }
                                    }
                                });
                            }
                        });
					}
				}
			});
		});
	}*/
	
	function resendCode(ResendCodeUrl)
	{

	}
	
	function discount(Request_url1,Request_url2)
	{
			$(".calculateDiscount").on("click", function (e) 
			{	
					if(typeof(localStorage.products)!=="undefined")
					{
							var coupon_code = $('#coupon_code').val(); 
								$.ajax ({
											
											url: Request_url1,
											type: 'get',
											data:   {
														data		: 	JSON.parse(localStorage.products) ,
														coupon_code : 	coupon_code
													},
											dataType: 'json',
											success: function(data)
											{	
												
									
												if(data['message'] ===undefined ) 
												{
														discount_amount = data['discount_amount'];
														$(".discount_amount").empty().append("$ "+ discount_amount);		
													
														if(typeof(localStorage.coupon_code)!="undefined")
														{
															localStorage.removeItem("coupon_code");
															localStorage["coupon_code"] =data['coupon_id'];
															localStorage.setItem("coupon_code", data['coupon_id']);
														}
														else
														{
															localStorage["coupon_code"] =data['coupon_id'];
															localStorage.setItem("coupon_code", data['coupon_id']);
														}
														
														$.ajax ({
													
																	url: Request_url2,
																	type: 'get',
																	data:   {
																				data		: 	JSON.parse(localStorage.products) ,
																				discount	:	discount_amount
																			},
																	dataType: 'json',
																	success: function(data)
																	{	
																		
																			$(".orderNotification").empty().append(data['total_cart_products']); 
																			
																			$(".subtotal").empty().append(data['currency']+" "+data['subtotal']);
	
																			$(".discount").empty().append("");
																			$(".discount").addClass('alert alert-danger');
																		    $(".discount").toggleClass('alert alert-danger'); 
																			
																			$(".discount_amount").empty().append(data['currency']+" "+data['discount_amount']);
																			//$(".delivery_charge").empty().append(data['currency']+" "+data['delivery_charge']);
																			$(".customer_wallet").empty().append(data['currency']+" "+data['customer_wallet']); 	
																			//$(".calculated_loyalty_points").empty().append(data['calculated_loyalty_points']+" Points");
																			$(".paid_amount").empty().append(data['currency']+" "+data['paid_amount']);
																	}
																});
															
												}
												else
												{
												    $(".discount").addClass('alert alert-danger');
													$(".discount").empty().append(data['message']);
													$(".discount_amount").empty().append('$ 0.00');
													
													total(Request_url2);													
												}
											}
										});
						
						
					}
			});
	}
 
	function recipe_list(Entity_type_id,Product_type,Entity_id,Request_url,Product_detail_url)
	{
			
				$("#LoadingImageRecipes").show();
				$.ajax ({
							
							url: Request_url,
							type: 'get',
							data:   {
										entity_type_id		: 	Entity_type_id 		,
										product_detail_url	:	Product_detail_url	,
										product_type		:	Product_type	,	
										entity_id			:	Entity_id
										
									},
							dataType: 'text',
							success: function(data)
							{		
									$("#recipes").append(data);
									$("#LoadingImageRecipes").hide();
							}
								
						});

	}
	
	function recipe_all_list(Entity_type_id,Product_type,Entity_id,Request_url,Product_detail_url,Chef_ids_tags,Searchable_tags,Recipe_serving_tags,Low_price,High_price,Offset,Limit)
	{
		
				$("#LoadingImageRecipes").show();
				$.ajax ({
							
							url: Request_url,
							type: 'get',
							data:   {
										entity_type_id		: 	Entity_type_id 		,
										product_detail_url	:	Product_detail_url	,
										product_type		:	Product_type	,	
										entity_id			:	Entity_id,
										chef_ids_tags		:	Chef_ids_tags,
										searchable_tags		:	Searchable_tags,
										recipe_serving_tags	:	Recipe_serving_tags,
										low_price			:	Low_price,
										high_price			:	High_price,
										offset 				:   Offset, 
										limit 				:   Limit
									},
							dataType: 'json',
							success: function(data)
							{		
								$("#recipes").empty().append(data['recipe']);
								$('#pagination').pagination('updateItems', data['items']);
								$("#LoadingImageRecipes").hide();
                                if(data['items'] > 0){
                                    $(".page_showcase").css({ 'display': "block" });
                                }
								
								
				 
							}
								
						});
					

		
	}
 
	function product_list1(Request_url1,Request_url2,Request_url3,Request_url4,Entity_type_id,Category_id,Request_url,Product_detail_url,Request_url5,Product_form,Searchable_tags,Low_price,High_price,Offset,Limit)
	{
					
				$("#LoadingImageProducts").show();
				$("#LoadingImageSearchProducts").show();

				console.log(Request_url);
				$.ajax ({
							
							url: Request_url,
							type: 'get',
							data:   {
										entity_type_id		: 	Entity_type_id 		,
										product_detail_url	:	Product_detail_url	,
										category_id			:	Category_id			,
										category_form		:	Product_form		,
										searchable_tags		:	Searchable_tags		,
										low_price			:	Low_price			,
										high_price			:	High_price			,
										offset				:	Offset				,
										limit				:	Limit
									},
							dataType: 'json',
							success: function(data)
							{
                                if(data['items'] > 0){
                                    $(".page_showcase").css({ 'display': "block" });
                                }
									$("#products").empty().append(data['products']);
									$("#LoadingImageProducts").hide();
									$("#LoadingImageSearchProducts").hide();
									$('#pagination').pagination('updateItems', data['items']);

                                addCartProcess(Request_url2,Request_url3,Request_url4,Request_url5)
									
								
							}
			            });
		
	}
	
	function product_list2(Request_url1,Request_url2,Request_url3,Request_url4,Entity_type_id,Category_id,Request_url,Product_detail_url,Request_url5,Product_form,Searchable_tags,Low_price,High_price,brand_id,Offset,Limit)
	{
				$("#LoadingImageProducts").show();
				$("#LoadingImageSearchProducts").show();

				$.ajax ({
							
							url: Request_url,
							type: 'get',
							data:   {
										entity_type_id		: 	Entity_type_id 		,
										product_detail_url	:	Product_detail_url	,
										category_id			:	Category_id			,
										category_form		:	Product_form		,
										searchable_tags		:	Searchable_tags		,
										low_price			:	Low_price			,
										high_price			:	High_price			,
                                		brand_id			:	brand_id			,
										offset				:	Offset				,
										limit				:	Limit
									},
							dataType: 'json',
							success: function(data)
							{
								if(data['items'] > 0){
                                    $(".page_showcase").css({ 'display': "block" });
								}

									$("#products").empty().append(data['products']);
									$("#LoadingImageProducts").hide();
									$("#LoadingImageSearchProducts").hide();
									$('#pagination').pagination('updateItems', data['items']);

                                addCartProcess(Request_url2,Request_url3,Request_url4,Request_url5);
									
								
							}
			            });
		
	}
	function promoted_product_list(Entity_type_id,Product_promotion_id,Request_url,Request_url2,Request_url3,Request_url4,Product_detail_url,Request_url5,Offset,Limit)
	{
				$("#LoadingImageProducts").show();
				$.ajax ({
							
							url: Request_url,
							type: 'get',
							data:   {
										entity_type_id				: 	Entity_type_id 		 ,
										product_detail_url			:	Product_detail_url	 ,
										product_promotion_id		:	Product_promotion_id ,
										offset						:	Offset				 ,
										limit						:	Limit
									},
							dataType: 'json',
							success: function(data)
							{		
								
									$("#products").empty().append(data['products']);
									$("#LoadingImageProducts").hide();
									$('#pagination').pagination('updateItems', data['items']);
                                	addCartProcess(Request_url2,Request_url3,Request_url4,Request_url5);
									
							}	
						});
	}
	
	function feature_product_list(Entity_type_id,Featured_type,Request_url,Request_url2,Request_url3,Request_url4,Product_detail_url,Request_url5,Perishable,Offset,Limit)
	{
				$("#LoadingImageProducts").show();
				$.ajax ({
							
							url: Request_url,
							type: 'get',
							data:   {
										entity_type_id				: 	Entity_type_id 		 ,
										product_detail_url			:	Product_detail_url	 ,
										featured_type				:	Featured_type 		 ,
										perishable					:	Perishable			 ,
										offset						:	Offset				 ,
										limit						:	Limit
									},
							dataType: 'json',
							success: function(data)
							{
                                if(data['items'] > 0){
                                    $(".page_showcase").css({ 'display': "block" });
                                }
									$("#products").empty().append(data['products']);
									$("#LoadingImageProducts").hide();
									$('#pagination').pagination('updateItems', data['items']);

                                addCartProcess(Request_url2,Request_url3,Request_url4,Request_url5)
									
							}	
						});
	}


function brand_product_list(Entity_type_id,brand_id,Request_url,Request_url2,Request_url3,Request_url4,Product_detail_url,Request_url5,Offset,Limit)
{
    $("#LoadingImageProducts").show();
    $.ajax ({

        url: Request_url,
        type: 'get',
        data:   {
            entity_type_id				: 	Entity_type_id 		 ,
            product_detail_url			:	Product_detail_url	 ,
            brand_id					:	brand_id 		 ,
            offset						:	Offset				 ,
            limit						:	Limit
        },
        dataType: 'json',
        success: function(data)
        {
            if(data['items'] > 0){
                $(".page_showcase").css({ 'display': "block" });
            }
            $("#products").empty().append(data['products']);
            $("#LoadingImageProducts").hide();
            $('#pagination').pagination('updateItems', data['items']);

            addCartProcess(Request_url2,Request_url3,Request_url4,Request_url5)

        }
    });
}
	
	function order_history_list(Entity_type_id,Order_history_url,Order_detail_url,Order_review_url,Offset,Limit)
	{
				$("#LoadingImageOrders").show();
				$.ajax ({
							
							url: Order_history_url,
							type: 'get',
							data:   {
										entity_type_id				: 	Entity_type_id 		 ,
										offset						:	Offset				 ,
										limit						:	Limit
									},
							dataType: 'json',
							success: function(data)
							{
                                if(data['items'] > 0){
                                    $(".page_showcase").css({ 'display': "block" });
                                }
									$(".orderHistory").empty().append(data['order']);
									$("#LoadingImageOrders").hide();
									$('#pagination').pagination('updateItems', data['items']);
									getOrderDetail(Order_detail_url);
									getOrderReview(Order_review_url);
							}	
						});
	}
	
	function wallet_history_list(Entity_type_id,Wallet_history_url,Offset,Limit)
	{
				//alert(Offset); 
				$("#LoadingImageWallet").show();
				$.ajax ({
							
							url: Wallet_history_url,
							type: 'get',
							data:   {
										entity_type_id				: 	Entity_type_id 		 ,
										offset						:	Offset				 ,
										limit						:	Limit
									},
							dataType: 'json',
							success: function(data)
							{
                                if(data['items'] > 0){
                                    $(".page_showcase").css({ 'display': "block" });
                                }

								$("#WalletHistory").empty().append(data['wallet']);
								$("#LoadingImageWallet").hide();
								$('#pagination').pagination('updateItems', data['items']);
								$('#current_balance').text(data['customer_balance']);
							}	
						});				

	}
	
	function add_to_wishlist(Request_url1)
	{
			$(".wishlist").on("click", function (e) 
									{	
									
										var $button = $(this);
										//var wishlist_entity_id  = $button.parent().find('.wishlist_entity_id').val();
										var wishlist_entity_id  = $button.parent().find('.entity_id').val();
										var entity_id  = $button.parent().find('.entity_id').val();
										var product_code  = $button.parent().find('.product_code').val(); 
										var title  = $button.parent().find('.title').val(); 
										var thumb  = $button.parent().find('.thumb').val(); 
										var price  = $button.parent().find('.price').val();
                                        var	item_type   		= $button.parent().find('.item_type').val();
									/*	var weight  = $button.parent().find('.weight').val();
										var unit_option  = $button.parent().find('.unit_option').val(); 
										var unit_value  = $button.parent().find('.unit_value').val(); */
										
										
										
										
										$.ajax ({
													url: Request_url1,
													type: 'get',
													data:   {
																product_id			: 	entity_id 
															},
													dataType: 'json',
													success: function(data)
													{		
														
														
														if(typeof(localStorage.wishlist)=="undefined")
														{
															
															
															
															var string = '[{"wishlist_entity_id":'+data[0]["wishlist_entity_id"]+',"entity_id":'+data[0]["entity_id"]+',"product_code":"'+data[0]["product_code"]+'","title":"'+data[0]["title"]+'","thumb":"'+data[0]["thumb"]+'","price":"'+data[0]["price"]+'"}]';
														 
															localStorage["wishlist"] =string;
															var wishlist =  JSON.parse(localStorage.wishlist);
															console.log(wishlist); 
															
															for (var i = 1; i <data.length; i++) 
														    {
																
																var entity_id = data[i]['entity_id'];
																var wishlist_entity_id = data[i]['wishlist_entity_id'];
																var product_code =data[i]['product_code'];
																var title =data[i]['title'];
																var thumb = data[i]['thumb'];
																var price = data[i]['price'];
																var item_type = data[i]['item_type']
																/*var weight = data[i]['weight'];
																var unit_option = data[i]['unit_option'];
																var unit_value = data[i]['unit_value'];*/
														
																var string = {
																				"wishlist_entity_id":wishlist_entity_id,
																				"entity_id":entity_id,
																				"product_code":product_code ,
																				"title":title,
																				"thumb":thumb,
																				"price":price,
																				"item_type" : item_type,
																				/*"weight":weight,
																				"unit_option":unit_option,
																				"unit_value":unit_value,*/
																			 };
																wishlist.push(string);
															
															}
															localStorage.setItem("wishlist", JSON.stringify(wishlist)); 
															
														}
														else
														{
															
															
															localStorage.removeItem("wishlist");
															var string = '[{"wishlist_entity_id":'+data[0]["wishlist_entity_id"]+',"entity_id":'+data[0]["entity_id"]+',"product_code":"'+data[0]["product_code"]+'","title":"'+data[0]["title"]+'","thumb":"'+data[0]["thumb"]+'","price":"'+data[0]["price"]+'"}]';
															
															localStorage["wishlist"] =string;
															var wishlist =  JSON.parse(localStorage.wishlist);
															console.log(wishlist); 
															 
															for (var i = 1; i <data.length; i++) 
														    {
																var wishlist_entity_id = data[i]['wishlist_entity_id'];
																var entity_id = data[i]['entity_id'];
																var product_code =data[i]['product_code'];
																var title =data[i]['title'];
																var thumb = data[i]['thumb'];
																var price = data[i]['price'];
                                                                var item_type = data[i]['item_type']
																/*var weight = data[i]['weight'];
																var unit_option = data[i]['unit_option'];
																var unit_value = data[i]['unit_value'];*/
														
																var string = {
																				"wishlist_entity_id":wishlist_entity_id,
																				"entity_id":entity_id,
																				"product_code":product_code ,
																				"title":title,
																				"thumb":thumb,
																				"price":price,
                                                                    			"item_type" : item_type,
																				/*"weight":weight,
																				"unit_option":unit_option,
																				"unit_value":unit_value,*/
																			 };
																wishlist.push(string);
															
															}
															localStorage.setItem("wishlist", JSON.stringify(wishlist)); 
														}
																
														load_wishlist(Request_url1);
														
														
														
													}
														
												});
										
										
										
										
										
										
										/*
										
										
										
										if(typeof(localStorage.wishlist)=="undefined")
										{
											var string =  '[{"product_code":"'+product_code+'","title":"'+title+'","thumb":"'+thumb+'","price":"'+price+'","weight":"'+weight+'","unit_option":"'+unit_option+'","unit_value":"'+unit_value+'"}]';
											localStorage["wishlist"] =string;
										}
										
										if(typeof(localStorage.wishlist)!=="undefined")
										{
											var wishlist = JSON.parse(localStorage.wishlist);
											n = 0 ; 
											for (var i = 0; i <wishlist.length; i++) 
											{
												if(product_code === wishlist[i].product_code)
												{  
													n=0;
												   break;  
												}
												else 
												{
													n=1;
												}  
											}
											if ( n==1 )
											{
												
												var string = {
																"entity_id":entity_id,
																"product_code":product_code ,
																"title":title,
																"thumb":thumb,
																"price":price,
																"weight":weight,
																"unit_option":unit_option,
																"unit_value":unit_value
															 };
												

												wishlist.push(string);
											}
											localStorage.setItem("wishlist", JSON.stringify(wishlist));
													
											
										}
										
										load_wishlist(Request_url1);
										
										
										
										
										
										
										*/
										
										
										
										
									});
			
	}
	
	function product_list_by_title(Entity_type_id,Title,Request_url,Request_url2,Request_url3,Request_url4,Product_detail_url,Request_url5,offset,limit)
	{

				$("#LoadingImageProducts").show();
				$.ajax ({
							
							url: Request_url,
							type: 'get',
							data:   {
										entity_type_id		: 	Entity_type_id 		,
										product_detail_url	:	Product_detail_url	,
										title				:	Title,
                                        offset				:	offset				 ,
                                        limit				:	limit

									},
							dataType: 'json',
							success: function(data)
							{		
								//$("#products").append(data);
								$("#LoadingImageProducts").hide();
                                $("#products").empty().append(data['products']);
                                $('#pagination').pagination('updateItems', data['items']);
                                $("#LoadingImageRecipes").hide();
                                if(data['items'] > 0){
                                    $(".page_showcase").css({ 'display': "block" });
                                }

                                addCartProcess(Request_url2,Request_url3,Request_url4,Request_url5)
							}
								
						});
					
							
				

		
	}
	
	function product_categories(Request_url1,Request_url2,Request_url3,Request_url4,Category_id)
	{
				$("#LoadingImageCategories").show();
				
				$.ajax ({
							
							url: Request_url1,
							data:{
										category_id :Category_id
							},
								
							type: 'get',
							dataType: 'text',
							success: function(data)
							{		
						
									$(".categories").append(data);
									$("#LoadingImageCategories").hide();
									
									$(".panel").on("click", function(e){
										  var $_target =  $(e.currentTarget);
										  var $_panelBody = $_target.find(".collapse");
										  if($_panelBody){
											$_panelBody.collapse('toggle')
										  }
									});
									
									// Add Cart Btn Animation
									$('.addtocart').click(function(){
										$(this).hide();
										var abc = $(this).parent().find('.pro-inc-wrap').toggle( "slide");
										
										
									});
									
									
	/*								
									//Inc Dec Button----------------
									$(".incr-btn3 ").on("click", function (e) 
									{
										var $button = $(this);
										var oldValue = $button.parent().find('.quantity').val();
									
										var entity_id 			= $button.parent().find('.entity_id').val();
										var product_code 		= $button.parent().find('.product_code').val();
										var	title 		 		= $button.parent().find('.title').val();
										var	thumb 		 		= $button.parent().find('.thumb').val();
										var	price   		= $button.parent().find('.price').val();
										var	weight 		 		= $button.parent().find('.weight').val();
										var	unit_option  		= $button.parent().find('.unit_option').val();
										var	unit_value 	 		= $button.parent().find('.unit_value').val();
										
										$button.parent().find('.incr-btn3[data-action="decrease"]').removeClass('inactive');
										
										if ($button.data('action') == "increase") {
											var newVal = parseFloat(oldValue) + 1;
										} 
										if ($button.data('action') == "decrease") 
										{
											// Don't allow decrementing below 1
											if (oldValue > 1) {
												var newVal = parseFloat(oldValue) - 1;
											} else {
												newVal = 1;
												$button.addClass('inactive');
												$('.pro-inc-wrap').hide();
												$('.addtocart').show();
												deleteCartProduct(product_code,Request_url3,Request_url4,Request_url2);
											}
										}
										
										
										$button.parent().find('.quantity').val(newVal);
										product_quantity  = newVal;
											
										if(product_quantity>=1)
										{
											if(typeof(localStorage.products)=="undefined")
											{
												var string =  '[{"entity_id":'+entity_id+',"product_code":"'+product_code+'","title":"'+title+'","thumb":"'+thumb+'","price":"'+price+'","weight":"'+weight+'","unit_option":"'+unit_option+'","unit_value":"'+unit_value+'","product_quantity":'+parseInt(product_quantity)+'}]';
												localStorage["products"] =string;
											}
					
											if(typeof(localStorage.products)!=="undefined")
											{
												var products = JSON.parse(localStorage.products);
												var products1 = [];
												n = 0 ; 
												for (var i = 0; i <products.length; i++) 
												{
													if(product_code === products[i].product_code)
													{  
													   //products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity); 
													   products[i].product_quantity  =  parseInt(product_quantity); 
													   n=0;
													   break;  
													}
													else 
													{
														n=1;
													}  
												}
												if ( n==1 )
												{
													var len = products1.length;
													var string = {
																	"entity_id":entity_id,
																	"product_code":product_code ,
																	"title":title,
																	"thumb":thumb,
																	"price":price,
																	"weight":weight,
																	"unit_option":unit_option,
																	"unit_value":unit_value,
																	"product_quantity":parseInt(product_quantity)
																 };
													products.push(string);
												}
												localStorage.setItem("products", JSON.stringify(products));
												total(Request_url2);				
											}	
										}											
										load_cart(Request_url3,Request_url2);
										e.preventDefault();
									});	




*/
									
									//Inc Dec Button----------------
									$(".incr-btn3").on("click", function (e) 
									{
										var $button = $(this);
										var oldValue = $button.parent().find('.quantity').val();
									
										var entity_id 			= $button.parent().find('.entity_id').val();
										var product_code 		= $button.parent().find('.product_code').val();
										var	title 		 		= $button.parent().find('.title').val();
										var	thumb 		 		= $button.parent().find('.thumb').val();
										var	price   		= $button.parent().find('.price').val();
                                        var	item_type   		= $button.parent().find('.item_type').val();
										/*var	weight 		 		= $button.parent().find('.weight').val();
										var	unit_option  		= $button.parent().find('.unit_option').val();
										var	unit_value 	 		= $button.parent().find('.unit_value').val();*/
										
										$button.parent().find('.incr-btn3[data-action="decrease"]').removeClass('inactive');
									
										if(oldValue=="0") 
										{
										//	var oldValue = parseFloat(oldValue) + 1;
											//var newVal	= oldValue;
										}
										if ($button.data('action') == "increase") {
											var newVal = parseFloat(oldValue) + 1;
										}
										if ($button.data('action') == "decrease") 
										{
											// Don't allow decrementing below 1
											if (oldValue > 1) {
												var newVal = parseFloat(oldValue) - 1;
											} else {
												newVal = 1;
												$button.addClass('inactive');
												//$('.pro-inc-wrap').hide();
												//$('.addtocart').show();
												$button.parent().parent().hide();
												$button.parent().parent().parent().find('.addtocart').show();
												deleteCartProduct(product_code,Request_url3,Request_url4,Request_url2);
											}
										}
										
										
										$button.parent().find('.quantity').val(newVal);
										product_quantity  = newVal;
											
										if(product_quantity>1)
										{
											if(typeof(localStorage.products)=="undefined")
											{
												var string =  '[{"entity_id":'+entity_id+',"product_code":"'+product_code+'","title":"'+title+'","thumb":"'+thumb+'","item_type":"'+item_type+'","price":"'+price+'","product_quantity":'+parseInt(product_quantity)+'}]';
												localStorage["products"] =string;
											}
					
											if(typeof(localStorage.products)!=="undefined")
											{
												var products = JSON.parse(localStorage.products);
												var products1 = [];
												n = 0 ; 
												for (var i = 0; i <products.length; i++) 
												{
													if(product_code === products[i].product_code)
													{  
													   //products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity); 
													   products[i].product_quantity  =  parseInt(product_quantity); 
													   n=0;
													   break;  
													}
													else 
													{
														n=1;
													}  
												}
												if ( n==1 )
												{
													var len = products1.length;
													var string = {
																	"entity_id":entity_id,
																	"product_code":product_code ,
																	"title":title,
																	"thumb":thumb,
																	"price":price,
                                                        			"item_type":item_type,
																	/*"weight":weight,
																	"unit_option":unit_option,
																	"unit_value":unit_value,*/
																	"product_quantity":parseInt(product_quantity)
																 };
													products.push(string);
												}
												localStorage.setItem("products", JSON.stringify(products));
												total(Request_url2);				
											}	
										}											
										load_cart(Request_url3,Request_url2);
										e.preventDefault();
									});	
									
									
									//Inc Dec Button----------------
									$(".addtocart").on("click", function (e) 
									{
										var $button = $(this);
										var oldValue = $button.parent().find('.quantity').val();
									
									
										var entity_id 			= $button.parent().find('.entity_id').val();
										var product_code 		= $button.parent().find('.product_code').val();
										var	title 		 		= $button.parent().find('.title').val();
										var	thumb 		 		= $button.parent().find('.thumb').val();
										var	price   		= $button.parent().find('.price').val();
                                        var	item_type   		= $button.parent().find('.item_type').val();
										/*var	weight 		 		= $button.parent().find('.weight').val();
										var	unit_option  		= $button.parent().find('.unit_option').val();
										var	unit_value 	 		= $button.parent().find('.unit_value').val();*/
										
										$button.parent().find('.incr-btn3[data-action="decrease"]').removeClass('inactive');
								
										if(oldValue=="0") 
										{
											//var oldValue = parseFloat(oldValue) + 1;
										//	var newVal	= oldValue;
										}
										if ($button.data('action') == "increase") {
											var newVal = parseFloat(oldValue) + 1;
										}
										if ($button.data('action') == "decrease") 
										{
											// Don't allow decrementing below 1
											if (oldValue > 1) {
												var newVal = parseFloat(oldValue) - 1;
											} else {
												newVal = 1;
												$button.addClass('inactive');
												$('.pro-inc-wrap').hide();
												$('.addtocart').show();
												deleteCartProduct(product_code,Request_url3,Request_url4,Request_url2);
											}
										}
										
										
										if(oldValue=="1") 
										{
											 oldValue = parseFloat(oldValue);
											var newVal	= oldValue;
										}
									
										//$button.parent().find('.quantity').val(newVal);
										product_quantity  = newVal;
										
										if(product_quantity==1)
										{
											if(typeof(localStorage.products)=="undefined")
											{
												var string =  '[{"entity_id":'+entity_id+',"product_code":"'+product_code+'","title":"'+title+'","thumb":"'+thumb+'","item_type":"'+item_type+'","price":"'+price+'","product_quantity":'+parseInt(product_quantity)+'}]';
												localStorage["products"] =string;
											}
					
											if(typeof(localStorage.products)!=="undefined")
											{
												var products = JSON.parse(localStorage.products);
												var products1 = [];
												n = 0 ; 
												for (var i = 0; i <products.length; i++) 
												{
													if(product_code === products[i].product_code)
													{  
													   //products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity); 
													   products[i].product_quantity  =  parseInt(product_quantity); 
													   n=0;
													   break;  
													}
													else 
													{
														n=1;
													}  
												}
												if ( n==1 )
												{
													var len = products1.length;
													var string = {
																	"entity_id":entity_id,
																	"product_code":product_code ,
																	"title":title,
																	"thumb":thumb,
																	"price":price,
																	"item_type":item_type,
																	/*"weight":weight,
																	"unit_option":unit_option,
																	"unit_value":unit_value,*/
																	"product_quantity":parseInt(product_quantity)
																 };
													products.push(string);
												}
												localStorage.setItem("products", JSON.stringify(products));
												total(Request_url2);				
											}	
										}											
										load_cart(Request_url3,Request_url2);
										e.preventDefault();
									});

							}	
						});
	}
	
	function load_cart(Request_url1,Request_url2)
	{
			if(typeof(localStorage.products)!=="undefined")
			{
				var products = JSON.parse(localStorage.products);
					
				if(products.length>=1)
				{
						
						$.ajax ({
									
									url: Request_url1,
									type: 'get',
									data:   {
												data		: 	JSON.parse(localStorage.products) 
											},
									dataType: 'text',
									success: function(data)
									{
                                        //localStorage.removeItem('products');
                                        //localStorage.setItem('products',  JSON.stringify(data['products']));

											$("#cart").empty().append(data);
											
											
											$(".incr-btn1").on("click", function (e)
											{
												var $button = $(this);
												var id  = $button.parent().find('.price_id').val(); 
												id1 = '.quantity'+id; 
												id2 = '.price'+id;
												var oldValue = $(id1).val();

                                                if((oldValue <= 4 && $button.data('action') == "increase") || $button.data('action') == "decrease") {
                                                    $button.parent().find('.incr-btn1[data-action="decrease"]').removeClass('inactive');
                                                    price = parseFloat($(id2).html());

                                                    if ($button.data('action') == "increase") {
                                                        var newVal = parseFloat(oldValue) + 1;
                                                    }
                                                    if ($button.data('action') == "decrease") {
                                                        if (oldValue > 1) {
                                                            var newVal = parseFloat(oldValue) - 1;
                                                        }
                                                        else {
                                                            newVal = 1;
                                                            $button.addClass('inactive');
                                                        }
                                                    }
                                                    $(id1).val(newVal);
                                                    price = (price / oldValue) * newVal;
                                                    price = Math.round(price * 100) / 100;
                                                    $(id2).empty().append(price);
                                                    e.preventDefault();
                                                    var Product_code = $button.parent().find('.product_code').val();
                                                    var item_type = $button.parent().find('.item_type').val();
                                                    var Product_quantity = newVal;
                                                    save(Product_code, Product_quantity, item_type, Request_url1);
                                                    total(Request_url2);
                                                }
												
											});
											total(Request_url2);
											$(".check_out").css({ 'background-color': "#139CB4" });
											$(".check_out").css({ 'display': "block" });


											
									}
										
								});
					
				}
			}
			else 
			{

                var a = "<div class='cart_empty nav nav-tabs' style='padding-top: 50%;'><div class='nav-link' style='padding-left: 30%;font-size: 18px; font-weight: 300; color: #48494d;'  >Cart is empty!</div><div style='padding-left: 15%;font-size: 15px; font-weight: 300; color: #c2c5d1;'> You don't have any Cart items</div></div>";
                $("#cart").empty().append(a);

                if(user_loggedin){
                    $.ajax ({

                        url: site_url+'/updateCart',
                        type: 'post',
                        data: {
                            products : '',
                            _token : crsf_token
                        },
                        dataType: 'json',
                        success: function (data) {

                        }
                    });
                }
			}

	}
	
	function load_wishlist(Request_url1)
	{
						$.ajax ({
									
									url: Request_url1,
									type: 'get',
									dataType: 'text',
									success: function(data)
									{		
										$("#wishlist").empty().append(data);
									}
								});

	}
	
	function show_cart(Request_url1,Request_url2)
	{
			if(typeof(localStorage.products)!=="undefined")
			{
				var products = JSON.parse(localStorage.products);
					
				if(products.length>=1)
				{
						$("#LoadingImageCart").show();	
						$.ajax ({
									
									url: Request_url1,
									type: 'get',
									data:   {
												data		: 	JSON.parse(localStorage.products) 
											},
									dataType: 'json',
									success: function(data)
									{
                                        $("#LoadingImageCart").hide();
											$("#show_list").empty().append(data.view);

											if(data.total_count > 0){
                                                localStorage.setItem('products',  JSON.stringify(data.products));
											}else{
                                                localStorage.removeItem('products');
											}

												if($('#show_list').find('ul').length == 0)
												{
													$('button.checkout').attr('disabled','disabled');
												}
												else{
                                                    $('button.checkout').removeAttr('disabled');
												}

											$(".incr-btn2").on("click", function (e) {
                                                var $button = $(this);
                                                var id = $button.parent().find('.price_id').val();
                                                id1 = '.quantity' + id;
                                                id2 = '.price' + id;
                                                var oldValue = $(id1).val();

                                                if((oldValue <= 4 && $button.data('action') == "increase") || $button.data('action') == "decrease") {

                                                $button.parent().find('.incr-btn2[data-action="decrease"]').removeClass('inactive');
                                                //.closest( '#parentselector' )
                                                price = parseFloat($(id2).html());

                                                if ($button.data('action') == "increase") {
                                                    var newVal = parseFloat(oldValue) + 1;
                                                }
                                                if ($button.data('action') == "decrease") {
                                                    if (oldValue > 1) {
                                                        var newVal = parseFloat(oldValue) - 1;
                                                    }
                                                    else {
                                                        newVal = 1;
                                                        $button.addClass('inactive');
                                                    }
                                                }
                                                $(id1).val(newVal);
                                                price = (price / oldValue) * newVal;
                                                price = Math.round(price * 100) / 100;

                                                $(id2).empty().append(price);
                                                e.preventDefault();
                                                var Product_code = $button.parent().find('.product_code').val();
                                                var item_type = $button.parent().find('.item_type').val();
                                                var Product_quantity = newVal;

                                                save(Product_code, Product_quantity, item_type, Request_url1);
                                                total(Request_url2);
                                            }
												
											});
											
				
									}
										
								});

				}
			}
			else{
                $("#show_list").empty().append('<div class="alert alert-warning">There is no items in cart to process checkout</div>');
                $('button.checkout').attr('disabled','disabled');
			}

	}
	
	function save(Product_code,Product_quantity,item_type,Request_url)
	{
		
		product_code = Product_code; 
		product_quantity = parseInt(Product_quantity);
									
		if(typeof(localStorage.products)=="undefined")
		{
				
			var string =  '[{"entity_id":'+entity_id+',"product_code":"'+product_code+'","title":"'+title+'","thumb":"'+thumb+'","price":"'+price+'","item_type":"'+item_type+'","product_quantity":'+parseInt(product_quantity)+'}]';
			localStorage["products"] =string;
		}
												
		if(typeof(localStorage.products)!=="undefined")
		{
			var products = JSON.parse(localStorage.products);
			var products1 = [];
			n = 0 ; 
			for (var i = 0; i <products.length; i++) 
			{
														 
				if(product_code === products[i].product_code)
				{  
					products[i].product_quantity  = parseInt(product_quantity); 
					n=0;
					break;  
				}
				else 
				{
					n=1;
				}
														  
			}
			if ( n==1 )
			{
				/*
				var string = 	{
									"product_code":product_code				,
									"product_quantity":product_quantity
								};
								
				var string = {
										"product_code":product_code ,
										"title":title,
										"thumb":thumb,
										"price":price,
										"weight":weight,
										"unit_option":unit_option,
										"unit_value":unit_value,
										"product_quantity":parseInt(product_quantity)
									 };
						*/
				//products.push(string);
			}
														   
			localStorage.setItem("products", JSON.stringify(products));
		}								
	}
	
	function total(Request_url)
	{
			if(typeof(localStorage.products)!=="undefined")
			{
			
						$.ajax ({
									
									url: Request_url,
									type: 'get',
									data:   {
												data		: 	JSON.parse(localStorage.products) 
											},
									dataType: 'json',
									success: function(data)
									{
									
										$(".orderNotification").css('display','block'); 	
										$(".orderNotification").empty().append(data['total_cart_products']); 	
										
										$(".subtotal").empty().append(data['currency']+' '+data['subtotal']);
										//$(".discount_amount").empty().append("$ "+data['discount_amount']);
										$(".delivery_charge").empty().append(data['currency']+' '+data['delivery_charge']);
										$(".customer_wallet").empty().append(data['currency']+' '+data['customer_wallet']); 	
										$(".calculated_loyalty_points").empty().append(data['calculated_loyalty_points']+" Points"); 		
										$(".paid_amount").empty().append(data['currency']+' '+data['paid_amount']);

                                        $("#paid_amount").val(data['paid_amount']);
										
										if(data['paid_amount']==0)
										{
											$(".cash").css({ 'display': "none" });
											//$(".webpay").css({ 'display': "none" });
										}
									
									}
								});
				
				
			}
	}
		
	function add_to_Cart(Request_url1,Request_url2)
	{
			$( ".add" ).click(function() 
			{
				
				var entity_id    		= $("input[name=entity_id]").val(); 
				var product_quantity    = $("input[name=product_quantity]").val(); 
				$("input[name=product_quantity]").val("1");
				var product_code 		= $("input[name=product_code]").val();   
				var title 		 		= $("input[name=title]").val(); 
				var thumb 		 		= $("input[name=thumb]").val(); 
				var price 	 			= $("input[name=price]").val();
                var item_type 	 			= $("input[name=item_type]").val();
                /*var weight 		 		= $("input[name=weight]").val();
                var unit_option  		= $("input[name=unit_option]").val();
                var unit_value 	 		= $("input[name=unit_value]").val(); */
						
				
				
				if(typeof(localStorage.products)=="undefined")
				{
					var string =  '[{"entity_id":'+entity_id+',"product_code":"'+product_code+'","item_type":"'+item_type+'","title":"'+title+'","thumb":"'+thumb+'","price":"'+price+'","product_quantity":'+parseInt(product_quantity)+'}]';
					localStorage["products"] =string;
				
				}
				
				if(typeof(localStorage.products)!=="undefined")
				{
					var products = JSON.parse(localStorage.products);
					var products1 = [];
					n = 0 ; 
					for (var i = 0; i <products.length; i++) 
					{
						if(product_code === products[i].product_code)
						{  
								if(products.length==1)
									products[i].product_quantity  =  parseInt(product_quantity); 
								else 
									products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity); 
								
							n=0;
						   break;  
						}
						else 
						{
							n=1;
						}  
					}
					
					console.log(products); 
					if ( n==1 )
					{
						var len = products1.length;
						/*var string = 	{
											"product_code":product_code				,
											"product_quantity":parseInt(product_quantity)
											
											
										};*/
						var string = {
										"entity_id":entity_id,
										"product_code":product_code ,
										"title":title,
										"thumb":thumb,
										"price":price,
                            			"item_type":item_type,
									/*	"weight":weight,
										"unit_option":unit_option,
										"unit_value":unit_value,*/
										"product_quantity":parseInt(product_quantity)
									 };
						

						products.push(string);
					}
					localStorage.setItem("products", JSON.stringify(products));
					total(Request_url1);	
					var products = JSON.parse(localStorage.products);
					if(products.length>=1)
					{
						$(".check_out").css({ 'background-color': "#139CB4" });
						$(".check_out").css({ 'display': "block" });
						$.ajax ({
									url: Request_url2,
									type: 'get',
									data:   {
												data		: 	JSON.parse(localStorage.products) 
											},
									dataType: 'text',
									success: function(data)
									{		
										$("#cart").empty().append(data);
										$(".incr-btn1").on("click", function (e)
											{
												var $button = $(this);
												var id  = $button.parent().find('.price_id').val(); 
												id1 = '.quantity'+id; 
												id2 = '.price'+id;
												
												var oldValue = $(id1).val();

												if((oldValue <= 4 && $button.data('action') == "increase") || $button.data('action') == "decrease") {

                                                    $button.parent().find('.incr-btn1[data-action="decrease"]').removeClass('inactive');
                                                    price = parseFloat($(id2).html());
                                                    if ($button.data('action') == "increase") {

                                                        var newVal = parseFloat(oldValue) + 1;
                                                    }
                                                    if ($button.data('action') == "decrease") {
                                                        if (oldValue > 1) {
                                                            var newVal = parseFloat(oldValue) - 1;
                                                        }
                                                        else {
                                                            newVal = 1;
                                                            $button.addClass('inactive');
                                                        }
                                                    }
                                                    $(id1).val(newVal);

                                                    price = (price / oldValue) * newVal;
                                                    price = Math.round(price * 100) / 100;
                                                    $(id2).empty().append(price);
                                                    e.preventDefault();
                                                    var Product_code = $button.parent().find('.product_code').val();
                                                    var item_type = $button.parent().find('.item_type').val();
                                                    var Product_quantity = newVal;

                                                    save(Product_code, Product_quantity, item_type, Request_url1);
                                                    total(Request_url1);
                                                }
												
											});
											
											
											
									}					
								});
					}
				}
				
				
				
				
			});
				

	}
	
	function checkout(Request_url1,Request_url2)
	{

			$(".checkout").on("click", function (e)
			{
				if(typeof(localStorage.products)!=="undefined")
				{
					//console.log($(".day").val()); console.log($(".time").val()); return false;
                   /* if($.trim($(".day").val()) == '' || $.trim($(".time").val()) == ''){
                        $("#show_list").prepend('<div class="alert alert-danger">Please select time slots to process checkout</div>');
                        return false;
					}
					else{
                        $("#show_list .alert-danger").remove();
					}*/

					/*localStorage["day"] = $(".day").val();
					localStorage.setItem("day", $(".day").val());
					localStorage["time"] = $(".time").val();
					localStorage.setItem("time", $(".time").val());*/
					
					$.ajax ({

						url: Request_url1,
						type: 'get',
						data:   
						{
							data			: 	JSON.parse(localStorage.products) ,
							coupon_code		: 	localStorage.coupon_code 		  
						},
						dataType: 'text',
						success: function(data)
						{

							if(data.error == 1){
                                $("#show_list").prepend('<div class="alert alert-danger">'+data.message+'</div>');
                                return false;
							}else{
                                localStorage.removeItem('is_gift_card');
								var products = JSON.parse(localStorage.products);
                                localStorage.setItem('is_gift_card',0);

                                $.each(products,function(k,v){
                                    console.log(v.item_type);
                                	if($.trim(v.item_type) == 'gift_card'){
                                        //console.log(v);
                                        localStorage.setItem('is_gift_card',1);
									}

                                });

                                window.location = Request_url2 ;
							}

						}
					});


				}
			});
	}

	function process_order(Request_url1)
	{
			$(".shipping_verification").on("click", function (e)
			{
				
			if($('#street').val()=='' ||  $('#checkout_phone').val()=='' ||  $('#checkout_email').val()==''  || $('#checkout_last_name').val()=='' || $('#checkout_first_name').val()=='' )
			{
				
				if($('#street').val()=='')
				{
					$("#error_shipping_verification").css("display", "block");
					/*$("#error_shipping_verification").addClass('alert alert-danger');
					$("#error_shipping_verification").css("color", "red");
					$("#error_shipping_verification").css("background-color",'#f8d7da');
					$("#error_shipping_verification").css("border-color",'#f5c6cb');*/
					$("#error_shipping_verification").empty().append('Street is required!');
				}
				if( $('#checkout_phone').val()=='')
				{
					$("#error_shipping_verification").css("display", "block");
				/*	$("#error_shipping_verification").addClass('alert alert-danger');
					$("#error_shipping_verification").css("color", "red");
					$("#error_shipping_verification").css("background-color",'#f8d7da');
					$("#error_shipping_verification").css("border-color",'#f5c6cb');*/
					$("#error_shipping_verification").empty().append('Phone number is required!');
				}
				if( $('#checkout_email').val()=='' )
				{
					/*$("#error_shipping_verification").css("display", "block");
					$("#error_shipping_verification").addClass('alert alert-danger');
					$("#error_shipping_verification").css("color", "red");
					$("#error_shipping_verification").css("background-color",'#f8d7da');
					$("#error_shipping_verification").css("border-color",'#f5c6cb');*/
					$("#error_shipping_verification").empty().append('Email is required!');
				}
				if( $('#checkout_last_name').val()=='' )
				{
					$("#error_shipping_verification").css("display", "block");
			/*		$("#error_shipping_verification").addClass('alert alert-danger');
					$("#error_shipping_verification").css("color", "red");
					$("#error_shipping_verification").css("background-color",'#f8d7da');
					$("#error_shipping_verification").css("border-color",'#f5c6cb');*/
					$("#error_shipping_verification").empty().append('Last name is required!');
				}
				if($('#checkout_first_name').val()=='' )
				{
					/*$("#error_shipping_verification").css("display", "block");
					$("#error_shipping_verification").addClass('alert alert-danger');
					$("#error_shipping_verification").css("color", "red");
					$("#error_shipping_verification").css("background-color",'#f8d7da');
					$("#error_shipping_verification").css("border-color",'#f5c6cb');*/
					$("#error_shipping_verification").empty().append('First name is required!');
				}
			}
			else
			{
				$("#error_shipping_verification").css("display", "none");
				
			}
				
					
			});
			
			$(".process_order").on("click", function (e)
			{
				if(typeof(localStorage.products)!=="undefined")
				{
					if(typeof(localStorage.day)!="undefined")
						var Day = localStorage["day"];
					else
						var Day = "";
					
					if(typeof(localStorage.day)!="undefined")
						var Time = localStorage["time"];
					else
						var Time = "";
					
					$.ajax ({

						url: Request_url1,
						type: 'get',
						data:   {
							data						: 	JSON.parse(localStorage.products) ,
							coupon_code					: 	localStorage.coupon_code 	,
							checkout_first_name			: 	$("#checkout_first_name").val(),
							checkout_last_name			: 	$("#checkout_last_name").val(),
							checkout_email				: 	$("#checkout_email").val(),
							checkout_phone				: 	$("#checkout_phone").val(),
							street						: 	$("#street").val(),
							latitude					: 	$("#latitude").val(),
							longitude					: 	$("#longitude").val(),
							same						: 	$("#same").val(),
							order_notes					:	$("#order_notes").val(),
							day							:	Day,
							time						:   Time,
							shipping_address			: 	$("input[name='shipping_address']:checked").val(),
                            recipient_name				:    $('#recipient_name').val(),
                            recipient_email				:    $('#recipient_email').val(),
                            recipient_message				:    $('#recipient_message').val(),
							is_gift_card				:	localStorage.is_gift_card,
						},
						dataType: 'json',
						success: function(data)
						{
							if(data.error == 0){

								var lead_order = data.data;
                                $("#txn_ref").val(lead_order['txn_ref']);
                                $("#entity_id").val(lead_order['entity_id']);
                                $("#product_id").val(lead_order['product_id']);
                                $("#pay_item_id").val(lead_order['pay_item_id']);
                                $("#amount").val(lead_order['amount']);
                                $("#currency").val(lead_order['currency']);
                                $("#site_redirect_url").val(lead_order['site_redirect_url']);
                                $("#cust_id").val(lead_order['cust_id']);
                                $("#site_name").val(lead_order['site_name']);
                                $("#cust_name").val(lead_order['cust_name']);
                                $("#mackey").val(lead_order['mackey']);
                                $("#hash").val(lead_order['hash']);

                                $("button[type=submit]").removeAttr("disabled");
                                $("button[type=submit]").css("background-color","#139CB4");

                            }
                            else{
                                $('.add-to-cart').attr('disabled','disabled');
                                $('.error-message').html('');
                                $('.error-message').append('<div class="alert alert-danger">'+data.message+'</div>');
							}

							//localStorage.removeItem('products');
							//window.location = Request_url2 ;
						}
					});


				}
			});
	}

	function menus(Request_url,Category_id)
	{
				$("#LoadingImageMenu").show();
				$.ajax ({
									
							url: Request_url,
							type: 'get',
							data:   {
										category_id			: 	Category_id 
									},
							dataType: 'text',
							success: function(data)
							{		
								$(".menus").empty().append(data);	
								$("#LoadingImageMenu").hide();
											
											
											// Nav Greedy First
											var $nav = $('.greedy-nav');
											var $btn = $('.greedy-nav button');
											var $vlinks = $('.greedy-nav .visible-links');
											var $hlinks = $('.greedy-nav .hidden-links');
											var breaks = [];
											function updateNav() {			  
											  var availableSpace = $btn.hasClass('hidden') ? $nav.width() : $nav.width() - $btn.width() - 30;
											  // The visible list is overflowing the nav
											  if($vlinks.width() > availableSpace) {
												// Record the width of the list
												breaks.push($vlinks.width());
												// Move item to the hidden list
												$vlinks.children().last().prependTo($hlinks);
												// Show the dropdown btn
												if($btn.hasClass('hidden')) {
												  $btn.removeClass('hidden');
												}
											  // The visible list is not overflowing
											  } else {
												// There is space for another item in the nav
												if(availableSpace > breaks[breaks.length-1]) {
												  // Move the item to the visible list
												  $hlinks.children().first().appendTo($vlinks);
												  breaks.pop();
												}
												// Hide the dropdown btn if hidden list is empty
												if(breaks.length < 1) {
												  $btn.addClass('hidden');
												  $hlinks.addClass('hidden');
												}
											  }
											  // Keep counter updated
											  $btn.attr("count", breaks.length);
											  // Recur if the visible list is still overflowing the nav
											  if($vlinks.width() > availableSpace) {
												updateNav();
											  }
											}

											// Window listeners
											$(window).resize(function() {
												updateNav();
											});
											$btn.on('click', function() {
											  $hlinks.toggleClass('hidden');
											});
											updateNav();
											
											
											// Nav Greedy Close When Other is Open
											$( "body" ).click(function(e) {
												if(!$(e.target).parent().hasClass("greedy-nav")){
													$(".greedy-nav .hidden-links").addClass("hidden");
												}
												if(!$(e.target).parent().hasClass("greedy-nav-second")){
													$(".greedy-nav-second .hidden-links").addClass("hidden");
												}
											});







											// Responsive Menu
											jQuery(document).on('click', '.mega-dropdown-menu', function(e) {
											  e.stopPropagation()
											});

											$(document).click(function(){
												if($(document).find('.flyout-wrap').length > 0){
													var section = $('.dropdown-toggle').parent().parent().parent();
													$(section).removeClass('flyout-wrap');
												}
											});

											$('.dropdown-toggle').on('click', function () {
												if($(document).find('.flyout-wrap').length > 0){
													var section = $(this).parent().parent().parent();
													$(section).removeClass('flyout-wrap');
												}else{
													var section = $(this).parent().parent().parent();
													$(section).addClass('flyout-wrap');
												}
											});

											$('.li-active').on('click', function () {
												$('.dropdown-toggle').html($(this).html() + '<span class="glyphicon glyphicon-chevron-down pull-right"></span>');
												$('section').removeClass('flyout-wrap');
												$("#productCateSideWrap").removeClass('show')
												$("#productCateSideWrap").parent().removeClass('show')
												$(".product-Section").removeClass('flyout-wrap')
											});
	
			




									
											// Nav Scroll -------------------------------------------
													
											var $nav2 = $('.greedy-nav-second');
											var $btn2 = $('.greedy-nav-second button');
											var $vlinks2 = $('.greedy-nav-second .visible-links');
											var $hlinks2 = $('.greedy-nav-second .hidden-links');

											var breaks2 = [];

											function updateNav2() {
												  
											  var availableSpace = $btn2.hasClass('hidden') ? $nav2.width() : $nav2.width() - $btn2.width() - 30;

											  // The visible list is overflowing the nav
											  if($vlinks2.width() > availableSpace) {

												// Record the width of the list
												breaks2.push($vlinks2.width());

												// Move item to the hidden list
												$vlinks2.children().last().prependTo($hlinks2);

												// Show the dropdown btn
												if($btn2.hasClass('hidden')) {
												  $btn2.removeClass('hidden');
												}

											  // The visible list is not overflowing
											  } else {

												// There is space for another item in the nav
												if(availableSpace > breaks2[breaks2.length-1]) {

												  // Move the item to the visible list
												  $hlinks2.children().first().appendTo($vlinks2);
												  breaks2.pop();
												}

												// Hide the dropdown btn if hidden list is empty
												if(breaks2.length < 1) {
												  $btn2.addClass('hidden');
												  $hlinks2.addClass('hidden');
												}
											  }

											  // Keep counter updated
											  $btn2.attr("count", breaks2.length);

											  // Recur if the visible list is still overflowing the nav
											  if($vlinks2.width() > availableSpace) {
												setTimeout(updateNav2,1); //updateNav2();
											  }

											}

											// Window listeners

											$(window).resize(function() {
												setTimeout(updateNav2,1); //updateNav2();
											});

											$btn2.on('click', function() {
											  $hlinks2.toggleClass('hidden');
											});

											setTimeout(updateNav2,1); //updateNav2();
											
													
															}
						});

	}
								
	function deleteCartProduct(Product_code,Request_url1,Request_url2,Request_url3)
	{
			//$(document).ready(function()
			//{
              /*  bootbox.confirm({
                    message: "Are you sure you want to Delete selected items?",
                buttons: {
                    confirm: {
                        label: 'OK',
                        className: 'confirmBtn'
                    },
                },
                callback: function (result) {

                    if (result === true) {*/

                        Product_code = Product_code;
                        n = 0;
                        len = 0;
                        if (typeof(localStorage.products) !== "undefined") {
                            var products = JSON.parse(localStorage.products);
                            var products1 = [];
                            var len = products.length;
                            for (var i = 0; i < products.length; i++) {
                                if (Product_code == products[i].product_code) {
                                    n = i;
                                }
                            }

                            if (products.length == 1) {
                                localStorage.removeItem("products");
                                $(".subtotal").empty().append("$ 0.00");
                                $(".calculated_loyalty_points").empty().append("0 Points");

                            }
                            else {
                                delete products[n];
                                for (var i = n; i < products.length; i++) {
                                    products[i] = products[(i + 1)];
                                }
                                for (var i = 0; i < products.length; i++) {

                                    if (products[i] != null) {
                                        products1[i] = products[i];
                                    }
                                }
                            }
                            products = products1;
                            localStorage.setItem("products", JSON.stringify(products));
                            if (products.length == 0) {
                                localStorage.removeItem("products");
                                $(".subtotal").empty().append("$ 0.00");
                                $(".calculated_loyalty_points").empty().append("0 Points");

                            }
                        }

                        //$("#show_list").empty();
                        //$("#cart").empty();

                        load_cart(Request_url1, Request_url3);
                        show_cart(Request_url2, Request_url3);

                        len = len - 1;
                        $(".orderNotification").empty().append(len);

                        if (len == 0) {
                            $(".orderNotification").css({'display': "none"});
                            $(".check_out").css({'background-color': "#8080808f"});
                            $(".check_out").css({'display': "none"});

                        }
                    /*}
                  }
                });*/
		//	});

	}	
							
	function deleteWishlistProduct(Entity_id,Request_url1,Request_url2,Request_url3,Request_url4,Request_url5)
	{
			
				Entity_id = parseInt(Entity_id);
				
					
				$.ajax ({
							url: Request_url5,
							type: 'get',
							data:   {
										entity_id			: 	Entity_id 
									},
							dataType: 'text',
							success: function(data)
							{
									
										
										$("#show_list").empty();
										$("#wishlist").empty().append(data);	
															
										$("#cart").empty();				
										load_cart(Request_url1,Request_url3);
										show_cart(Request_url2,Request_url3);
										load_wishlist(Request_url4)
										
							}
						});
							

	}	
	
	function saveReview(saveReviewUrl)
	{

			$( "#recipe_save_review" ).click(function()
			{
				var Rating 		= $('#rating').val(); 
				var Review 		= $('#review').val(); 
				var Product_id	= $('#product_id').val(); 
				var recipe_url  = $('#recipe_url').val(); 
				console.log(typeof(Review)); 
				if(Rating == '' || Review=="")
				{
					if(Rating == '')
					{
							
						$("#error_msg_review_verification").css('display','block');
						$("#error_msg_review_verification").addClass('alert alert-danger');
						//$("#error_msg_review_verification").css("color", "red");
						//$("#error_msg_review_verification").css("background-color",'#f8d7da');
						//$("#error_msg_review_verification").css("border-color",'#f5c6cb');
						$("#error_msg_review_verification").empty().append('Please give rating before submission!');
					}
					else
					if( Review== "")
					{
						
						$("#error_msg_review_verification").css('display','block');
						$("#error_msg_review_verification").addClass('alert alert-danger');
						//$("#error_msg_review_verification").css("color", "red");
						//$("#error_msg_review_verification").css("background-color",'#f8d7da');
						//$("#error_msg_review_verification").css("border-color",'#f5c6cb');
						$("#error_msg_review_verification").empty().append('Please give Review before submission!');
					}
				}
				else 
				{
					$.ajax ({
								url: saveReviewUrl,
								type: 'get',
								data:   {
											rating			: 	Rating		,
											review			:	Review		,
											product_id		:	Product_id
										},
								dataType: 'json',
								success: function(data)
								{
									
									if(data['response']=='error')
									{
										
										$("#error_msg_review_verification").addClass('alert alert-danger');
										$("#error_msg_review_verification").css("color", "red");
										$("#error_msg_review_verification").css("background-color",'#f8d7da');
										$("#error_msg_review_verification").css("border-color",'#f5c6cb');
										$("#error_msg_review_verification").empty().append(data['message']);
									}
									else
									{
									
										window.location = recipe_url; 
									}	
								}
							});
				}
			});

	}
	
	function getOrderDetail(getOrderDetailUrl)
	{
		$( ".reorder" ).click(function()
			{
				var $button = $(this);
				var order_id  = $button.parent().find('.order_id').val();
                $(".orderPopupBody").empty().before('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loading...');
                $(".orderPopupBody").hide();
						
				$.ajax ({
							url: getOrderDetailUrl,
							type: 'get',
							data:   {
										entity_id			: 	order_id		,
										
									},
							dataType: 'text',
							success: function(data)
							{
                                $(".orderPopupBody").show();
								
									$(".orderPopup").empty().append(data);
									//window.location = recipe_url; 
									$('.orderPopupBody').enscroll({
										showOnHover: true,
										verticalTrackClass: 'track3',
										verticalHandleClass: 'handle3'
									});
				
										
							}
						});
						
						
			});
	}
	
	function getOrderReview(getOrderReviewUrl)
	{
		
			$( ".review" ).click(function() 
			{
					var $button = $(this);
				var order_id  = $button.parent().find('.order_id').val();
                $('.orderReviewmodel').modal('show');
                $(".orderReviewPopupBody").empty().append('Loading...');
						
				$.ajax ({
							url: getOrderReviewUrl,
							type: 'get',
							data:   {
										entity_id			: 	order_id		,
										
									},
							dataType: 'text',
							success: function(data)
							{

									$(".orderReviewPopupBody").empty().append(data);
									//window.location = recipe_url; 
									// Star Rating
									var $star_rating = $('.star-rating .tt');
									var SetRatingStar = function()  {
																	  return $star_rating.each(function() {
																		if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
																		  return $(this).removeClass('icon-tt-star-icon').addClass('icon-tt-star-fill-icon');
																		} else {
																		  return $(this).removeClass('icon-tt-star-fill-icon').addClass('icon-tt-star-icon');
																		}
																	  });
																	};

									$star_rating.on('click', function() {
												
																			$('#rating').val($(this).data('rating'));
																			$star_rating.siblings('input.rating-value').val($(this).data('rating'));
																			return SetRatingStar();
																		});



                                SetRatingStar();

                                $('.orderReviewPopupBody .button.close').on('click',function(){
                                    $('.orderReviewmodel').modal('hide');
                                });

							}
						
						
						});
			
			});
			
		
	}


	function testimonial(testimonialUrl)
	{
			$.ajax ({
						url: testimonialUrl,
						type: 'get',
						dataType: 'text',
						success: function(data)
						{
								$("#testimonial").empty().append(data);
						}
					});

	}

	function mainCategory(route){

        $.ajax ({
            url: route,
            type: 'get',
            dataType: 'text',
            success: function(data)
            {
                $("#mainCategory").empty().append(data);
            }
        });
	}
	
	function aboutBusiness(aboutBusinessUrl)
	{
			$.ajax ({
						url: aboutBusinessUrl,
						type: 'get',
						dataType: 'text',
						success: function(data)
						{
							$("#aboutBusiness").empty().append(data);		
						}
					});

	}
	
	function promotionAndDiscount(promotionAndDiscountUrl)
	{
			$.ajax ({
						url: promotionAndDiscountUrl,
						type: 'get',
						dataType: 'text',
						success: function(data)
						{
							$("#promotionAndDiscountUrl").empty().append(data);		
						}
					});

	}
	
	function guestChefDeal(Request_url1)
	{
				$("#LoadingGuestChefDealImage").show();
				$.ajax ({
							
							url: Request_url1,
							type: 'get',
							data:   {
										product_detail_url	:	"khjkhjk",
							},
							dataType: 'text',
							success: function(data)
							{		
								
									$("#guestChefDeal").empty().append(data);
									$("#LoadingGuestChefDealImage").hide();
									
									
							}
								
						});
					
							

	}
	
	function topChefDeal(Request_url1)
	{
				$("#LoadingTopChefDealImage").hide();
				$.ajax ({
							
							url: Request_url1,
							type: 'get',
							dataType: 'text',
							success: function(data)
							{		
								
									$("#TopChefDeal").empty().append(data);
									$("#LoadingTopChefDealImage").hide();
									
									
							}
								
						});
					
							

	}
	
	function changeYourAccountDetail(changeYourAccountDetailUrl)
	{

			$( "#save_your_account" ).click(function() 
			{
			//	if($("#term_and_condition").prop('checked') == true)
			//	{
				
					$.ajax ({		
							url: changeYourAccountDetailUrl,
							data:{
										first_name					: $("#account_first_name").val()		,
										last_name  					: $("#account_last_name").val()			,
								 },
							type: 'get',
							dataType: 'json',
							success: function(data)
							{		
								if(	data['message'] == "Success" ) 
								{
                                    if($("#account_response").hasClass('alert')){
                                        $("#account_response").removeClass('alert-danger');
                                    }

                                    $("#account_response").addClass('alert alert-success');
                                   // showSuccessAlert('Your profile updated successfully');
                                    timerA = setInterval(function(){
                                        $('.editYourDetailmodal').modal('hide');
                                        clearInterval(timerA);
                                    },2000);


									/*$("#account_response").css("color", "white");
									$("#account_response").css("background-color",'#d4edda');
									$("#account_response").css("border-color",'#d4edda');*/
									//$("#account_response").empty().append("Data Has been changed successfully!");
								}	
								else
								{
                                   // showAlert(data['message']);
									$("#account_response").addClass('alert alert-danger');
								/*	$("#account_response").css("color", "red");
									$("#account_response").css("background-color",'#f8d7da');
									$("#account_response").css("border-color",'#f5c6cb');*/
								  $("#account_response").empty().append(data['message']);
								}								
							}
						});
						
				//}
				//else
				//{
                   // showAlert('Please agree with terms and conditions!');
					//$("#account_response").addClass('alert alert-danger');
			/*		$("#account_response").css("color", "red");
					$("#account_response").css("background-color",'#f8d7da');
					$("#account_response").css("border-color",'#f5c6cb');*/
					//$("#account_response").empty().append('Please agree with terms and conditions!');
				//}
				
			});
	}

	function changeAccountPassword(changeAccountPasswordUrl)
	{
			$( "#change_your_account_password" ).click(function() 
			{
				
				$.ajax ({		
							url: changeAccountPasswordUrl,
							data:{
										current_password		: $("#current_password").val()		,
										new_password  			: $("#new_password").val()			,
										confirm_password		: $('#confirm_password').val()
										//mobile_no  		: $("#account_mobile_no").val()
								 },
							type: 'get',
							dataType: 'json',
							success: function(data)
							{		
								if(	data['error'] == 1 ) 
								{
									$("#account_change_response").addClass('alert alert-danger');
									$("#account_change_response").empty().append(data['message']); 	
								
								}									
								if(	data['error'] == 0 ) 
								{
									if($("#account_change_response").hasClass('alert')){
                                        $("#account_change_response").removeClass('alert-danger');
									}

									$("#account_change_response").addClass('alert alert-success');
									$("#account_change_response").empty().append("Password has changed successfully");

                                    timePass = setInterval(function(){
                                    	$('.chgPassmodal').modal('hide');
                                        clearInterval(timePass);
                                    },2000);
								}
							
							}
						});
				
			}); 

	}
	
	function forgetAccountPassword(forgetAccountPasswordUrl)
	{

			$( "#forget_your_account_password" ).click(function() 
			{
				
				$.ajax ({		
							url: forgetAccountPasswordUrl,
							data:{
										current_password		: $("#current_password").val()		,
										new_password  			: $("#new_password").val()			,
										confirm_password		: $('#confirm_password').val()
										//mobile_no  		: $("#account_mobile_no").val()
								 },
							type: 'get',
							dataType: 'json',
							success: function(data)
							{		
								if(	data['error'] == 1 ) 
								{
									$("#account_forget_response").addClass('alert alert-danger');
									$("#account_forget_response").empty().append(data['message']); 	
								
								}									
								if(	data['error'] == 0 ) 
								{
									$("#account_forget_response").addClass('alert alert-success');
									$("#account_forget_response").empty().append("Data has been successfully updated!");
								}
							
							}
						});
				
			});
	}
	
	
	
	function savePaymentMehtodType(savePaymentMehtodTypeUrl,Payment_method_type)
	{
				$.ajax ({		
							url: savePaymentMehtodTypeUrl,
							data:
							{
								payment_method_type	: Payment_method_type			
							},
							type: 'get',
							dataType: 'json',
							success: function(data)
							{		
								if(	data['error'] == 1 ) 
								{
									$("#error_msg_change_payment_method").addClass('alert alert-danger');
									$("#error_msg_change_payment_method").empty().append(data['message']); 	
								
								}									
								if(	data['error'] == 0 ) 
								{
									
									$("#error_msg_change_payment_method").addClass('alert alert-success');
									/*$("#error_msg_change_payment_method").css("color", "white");
									$("#error_msg_change_payment_method").css("background-color",'#d4edda');
									$("#error_msg_change_payment_method").css("border-color",'#d4edda');*/
									$("#error_msg_change_payment_method").empty().append('Payment method has been updated successfully!');

							
								}
							}
						});
	}
	
	function referAFriend(referAFriendUrl)
	{
			$( ".referBtn" ).click(function() 
			{
				$.ajax ({		
								url: referAFriendUrl,
								data:
								{
									entity_id	: $("#refer_entity_id").val() ,
									email	: $("#refer_email").val() ,
								},
								type: 'get',
								dataType: 'json',
								success: function(data)
								{		
								  	if(	data['error'] == 1 ) 
									{
										$(".signinError").addClass('alert alert-danger');
										//$(".signinError").css("color", "red");
										//$(".signinError").css("background-color",'#f8d7da');
									//	$(".signinError").css("border-color",'#f5c6cb');
										$(".signinError").empty().append(data['message']);											
									
									}									
									if(	data['error'] == 0 ) 
									{
										if($(".signinError").hasClass('alert-danger')){
                                            $(".signinError").removeClass('alert-danger')
										}

										$(".signinError").addClass('alert alert-success');
										//$(".signinError").css("color", "white");
										//$(".signinError").css("background-color",'#d4edda');
									//	$(".signinError").css("border-color",'#d4edda');
										$(".signinError").empty().append('Notification has been successfully send to your friend!');
                                        //$(".signinError").empty();
                                       // $(".signinError").removeClassesExceptThese(["signinError"]);
                                        $('#refer_email').val('');
                                        timeRefer = setInterval(function(){
                                            $('.referfriendmodal').modal('hide');
                                            clearInterval(timeRefer);
                                        },2000);
								
									}
								}
						});
			});

	}

	function sendCode(sendCodeUrl,socialPhoneVerficationUrl)
	{
		
		$(".sendcode").on("click", function (e) 
		{
					
			
			if($('#phone').val()=='' )
			{
				$("#error_msg_social_phone_verification").addClass('alert alert-danger');
				$("#error_msg_social_phone_verification").css("color", "red");
				$("#error_msg_social_phone_verification").css("background-color",'#f8d7da');
				$("#error_msg_social_phone_verification").css("border-color",'#f5c6cb');
				$("#error_msg_social_phone_verification").empty().append('Invalid phone number!');
				
					
			}
			else 
			{
				$.ajax 
				({
						url: sendCodeUrl,
						type: 'get',
						data:   {
									new_login_id		:	$('#phone').val()	
								},
						dataType: 'json',
						success: function(data)
						{		
							
							if( data['error'] == 1 ) 
							{
								$("#error_msg_social_phone_verification").addClass('alert alert-danger');
								$("#error_msg_social_phone_verification").css("color", "red");
								$("#error_msg_social_phone_verification").css("background-color",'#f8d7da');
								$("#error_msg_social_phone_verification").css("border-color",'#f5c6cb');
								$("#error_msg_social_phone_verification").empty().append(data['message']);
								
								
								
							
							}
							else
							{
								
								$("#error_msg_social_phone_verification").addClass('alert alert-success');
								$("#error_msg_social_phone_verification").css("color", "white");
								$("#error_msg_social_phone_verification").css("background-color",'#d4edda');
								$("#error_msg_social_phone_verification").css("border-color",'#c3e6cb');
								$("#error_msg_social_phone_verification").empty().append(data['message']);
									
								$("#social_entity_id").val(data['data']['customer']['entity_id']);
								
								$("#social_verification_token").val(data['data']['customer']['auth']['verification_token']);
								$("#social_phone_number_verification").val(data['data']['customer']['auth']['mobile_no']);
								
								
								$(".social_phone_verfication").on("click", function (e) 
								{
									var code = $('#social_tel1').val()+$('#social_tel2').val()+$('#social_tel3').val()+$('#social_tel4').val();
									if($('#social_tel1').val()=='' || $('#social_tel2').val()=='' || $('#social_tel3').val()=='' || $('#social_tel4').val()=='')
									{
										$("#error_msg_phone_verification").addClass('alert alert-danger');
										$("#error_msg_phone_verification").css("color", "red");
										$("#error_msg_phone_verification").css("background-color",'#f8d7da');
										$("#error_msg_phone_verification").css("border-color",'#f5c6cb');
										$("#error_msg_phone_verification").empty().append('Code is invalid!');
										
														
									}
									else 
									{
									
										var code = $('#social_tel1').val()+$('#social_tel2').val()+$('#social_tel3').val()+$('#social_tel4').val();
										var entity_id = $('#social_entity_id').val();
										var social_verification_token = $('#social_verification_token').val(); 
										var social_phone_number_verification = $('#social_phone_number_verification').val();
										
										$.ajax 
										({
												url: socialPhoneVerficationUrl,
												type: 'get',
												data:   {
													
															mobile_no			:	$('#phone').val()	,
															verification_token	:	social_verification_token	,
															verification_mode	:	'change_mobile_no',
															entity_type_id		:	11,
															authy_code			:	code		
														},
												dataType: 'json',
												success: function(data)
												{		
													if( data['error'] == 1 ) 
													{
														$("#error_msg_social_phone_verification").addClass('alert alert-danger');
														$("#error_msg_social_phone_verification").css("color", "red");
														$("#error_msg_social_phone_verification").css("background-color",'#f8d7da');
														$("#error_msg_social_phone_verification").css("border-color",'#f5c6cb');
														$("#error_msg_social_phone_verification").empty().append(data['message']);
													}
													else
													{
														
														$("#error_msg_social_phone_verification").addClass('alert alert-success');
														$("#error_msg_social_phone_verification").css("color", "white");
														$("#error_msg_social_phone_verification").css("background-color",'#d4edda');
														$("#error_msg_social_phone_verification").css("border-color",'#c3e6cb');
														$("#error_msg_social_phone_verification").empty().append(data['message']);
														setTimeout(function() {/*do something special*/}, 2000);
														//alert( $('#url').val()); 
														window.location = $('#social_url').val(); 
													
													}		
												}
										});
									}
								});
								
							}			
						}
				});	

			}				
		});
		$(".social_phone_verfication").on("click", function (e) 
		{
			
			if($('#social_tel1').val()=='' || $('#social_tel2').val()=='' || $('#social_tel3').val()=='' || $('#social_tel4').val()=='')
			{
										
				$("#error_msg_social_phone_verification").addClass('alert alert-danger');
				$("#error_msg_social_phone_verification").css("color", "red");
				$("#error_msg_social_phone_verification").css("background-color",'#f8d7da');
				$("#error_msg_social_phone_verification").css("border-color",'#f5c6cb');
				$("#error_msg_social_phone_verification").empty().append('Code is invalid!');
				
														
			}
		});
		
	}

function addCartProcess(Request_url2,Request_url3,Request_url4,Request_url5)
{
    add_to_wishlist(Request_url5);

    // Add Cart Btn Animation
    $('.addtocart').click(function(){

        $(this).hide();
        var abc = $(this).parent().find('.pro-inc-wrap').toggle("slide");

    });


    //Inc Dec Button----------------
    $(".incr-btn3").on("click", function (e)
    {

        var $button = $(this);
        var oldValue = $button.parent().find('.quantity').val();

        if((oldValue <= 4 && $button.data('action') == "increase") || $button.data('action') == "decrease") {

            var entity_id = $button.parent().find('.entity_id').val();
            var product_code = $button.parent().find('.product_code').val();
            var title = $button.parent().find('.title').val();
            var thumb = $button.parent().find('.thumb').val();
            var price = $button.parent().find('.price').val();
            var item_type = $button.parent().find('.item_type').val();
            /*var	weight 		 		= $button.parent().find('.weight').val();
            var	unit_option  		= $button.parent().find('.unit_option').val();
            var	unit_value 	 		= $button.parent().find('.unit_value').val();*/
            console.log(item_type);
            $button.parent().find('.incr-btn3[data-action="decrease"]').removeClass('inactive');

            if (oldValue == "0") {
                //	var oldValue = parseFloat(oldValue) + 1;
                //var newVal	= oldValue;
            }
            if ($button.data('action') == "increase") {
                var newVal = parseFloat(oldValue) + 1;
            }
            if ($button.data('action') == "decrease") {
                // Don't allow decrementing below 1
                if (oldValue > 1) {
                    var newVal = parseFloat(oldValue) - 1;
                } else {
                    newVal = 1;
                    $button.addClass('inactive');
                    //$('.pro-inc-wrap').hide();
                    //$('.addtocart').show();
                    $button.parent().parent().hide();
                    $button.parent().parent().parent().find('.addtocart').show();
                    deleteCartProduct(product_code, Request_url3, Request_url4, Request_url2);
                }
            }


            $button.parent().find('.quantity').val(newVal);
            product_quantity = newVal;

            if (product_quantity > 1) {
                if (typeof(localStorage.products) == "undefined") {
                    var string = '[{"entity_id":' + entity_id + ',"product_code":"' + product_code + '","title":"' + title + '","thumb":"' + thumb + '","price":"' + price + '","item_type":"' + item_type + '","product_quantity":' + parseInt(product_quantity) + '}]';
                    localStorage["products"] = string;
                }

                if (typeof(localStorage.products) !== "undefined") {
                    var products = JSON.parse(localStorage.products);
                    var products1 = [];
                    n = 0;
                    for (var i = 0; i < products.length; i++) {
                        if (product_code === products[i].product_code) {
                            //products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity);
                            products[i].product_quantity = parseInt(product_quantity);
                            n = 0;
                            break;
                        }
                        else {
                            n = 1;
                        }
                    }
                    if (n == 1) {
                        var len = products1.length;
                        var string = {
                            "entity_id": entity_id,
                            "product_code": product_code,
                            "title": title,
                            "thumb": thumb,
                            "price": price,
                            "item_type": item_type,
                            /*"weight":weight,
                            "unit_option":unit_option,
                            "unit_value":unit_value,*/
                            "product_quantity": parseInt(product_quantity)
                        };
                        products.push(string);
                    }
                    localStorage.setItem("products", JSON.stringify(products));
                    total(Request_url2);
                }
            }

            load_cart(Request_url3, Request_url2);
        }

    });


    //Inc Dec Button----------------
    $(".addtocart").on("click", function (e)
    {
        var $button = $(this);
        var oldValue = $button.parent().find('.quantity').val();


        var entity_id 			= $button.parent().find('.entity_id').val();
        var product_code 		= $button.parent().find('.product_code').val();
        var	title 		 		= $button.parent().find('.title').val();
        var	thumb 		 		= $button.parent().find('.thumb').val();
        var	price   			= $button.parent().find('.price').val();
        var	item_type   		= $button.parent().find('.item_type').val();
        //var	weight 		 		= $button.parent().find('.weight').val();
        //	var	unit_option  		= $button.parent().find('.unit_option').val();
        //var	unit_value 	 		= $button.parent().find('.unit_value').val();

        $button.parent().find('.incr-btn3[data-action="decrease"]').removeClass('inactive');

        if(oldValue=="0")
        {
            //var oldValue = parseFloat(oldValue) + 1;
            //	var newVal	= oldValue;
        }
        if ($button.data('action') == "increase") {
            var newVal = parseFloat(oldValue) + 1;
        }
        if ($button.data('action') == "decrease")
        {
            // Don't allow decrementing below 1
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
                $button.addClass('inactive');
                //$('.pro-inc-wrap').hide();
                $('.addtocart').show();
                //   $(this).hide();
                var abc = $(this).parent().find('.pro-inc-wrap').toggle( "slide");
                deleteCartProduct(product_code,Request_url3,Request_url4,Request_url2);
            }
        }


        if(oldValue=="1")
        {
            oldValue = parseFloat(oldValue);
            var newVal	= oldValue;
        }

        //$button.parent().find('.quantity').val(newVal);
        product_quantity  = newVal;

        if(product_quantity==1)
        {
            if(typeof(localStorage.products)=="undefined")
            {
                var string =  '[{"entity_id":'+entity_id+',"product_code":"'+product_code+'","title":"'+title+'","thumb":"'+thumb+'","price":"'+price+'","item_type":"'+item_type+'","product_quantity":'+parseInt(product_quantity)+'}]';
                localStorage.products =string;
                console.log(localStorage.products);
            }

            if(typeof(localStorage.products)!=="undefined")
            {
                var products = JSON.parse(localStorage.products);
                var products1 = [];
                n = 0 ;
                for (var i = 0; i <products.length; i++)
                {
                    if(product_code === products[i].product_code)
                    {
                        //products[i].product_quantity  = parseInt(products[i].product_quantity) + parseInt(product_quantity);
                        products[i].product_quantity  =  parseInt(product_quantity);
                        n=0;
                        break;
                    }
                    else
                    {
                        n=1;
                    }
                }
                if ( n==1 )
                {
                    var len = products1.length;
                    var string = {
                        "entity_id":entity_id,
                        "product_code":product_code ,
                        "title":title,
                        "thumb":thumb,
                        "price":price,
                        "item_type" : item_type,
                        /*	"weight":weight,
                            "unit_option":unit_option,
                            "unit_value":unit_value,*/
                        "product_quantity":parseInt(product_quantity)
                    };
                    products.push(string);
                }
                localStorage.setItem("products", JSON.stringify(products));
                total(Request_url2);
            }
        }

        load_cart(Request_url3,Request_url2);
        e.preventDefault();
    });
}

function showAlert(msg)
{
    hideAlert();
    addErrorMsg(msg);

}

function hideAlert(){

    if($(".alert-success").length > 0){
        $("form .alert-success").remove();
    }
    if($(".alert-danger").length > 0){
        $(".alert-danger").remove();
    }
}

function showSuccessAlert(msg){
    hideAlert();
    addSuccessMsg(msg);
}


function clearAlert(){
    setTimeout(function() {

        hideAlert();
    }, 50000);
}

function addErrorMsg(message)
{
    $('.alert-message').append('<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a>'+message+'</div>');
    $(".alert-danger").focus();
}

function addSuccessMsg(message)
{
    $('.alert-message').append('<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a>'+message+'</div>');
    $(".alert-success").focus();
}

	
$('.custom-close').on('click',function(){
	$('.orderReviewmodel').modal('hide');
});
