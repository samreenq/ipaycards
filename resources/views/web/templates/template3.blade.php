<!DOCTYPE html>
<html lang="en">
	
	<head>
		@yield("head")
	</head>
	<body>
	
		@yield("navbar")
		@yield("cartbar")
		@yield("header")
		@yield("dashboard")
		
		@yield("payment")
		@yield("order_history")
		@yield("address_book")
		@yield("wallet")
		@yield("logout")
		
		
		@yield("footer")

		@yield("signin")
		@yield("signup")
		@yield("phone_verification")
		@yield("change_password")
		@yield("forget_password")
		@yield("editYourDetailmodal")	
		@yield("orderReviewmodel")
		@yield("orderDetailmodal")
		@yield("basket_and_wish_list")	
		@yield("about_us")
		@yield("refer_friend")
		
		@yield("foot")
	</body>
</html>	
