<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		{%HEADER%}		
		<link href="theme/frontend/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
		<link href="theme/frontend/css/font-awesome.css" type="text/css" rel="stylesheet" />
		<link href="theme/frontend/css/animate.css" type="text/css" rel="stylesheet" />
		<link href="theme/frontend/css/camera.css" type="text/css" rel="stylesheet" />
		<link href="theme/frontend/zoom/cloudzoom.css" type="text/css" rel="stylesheet" />
		<link href="theme/frontend/css/owl.carousel.css" type="text/css" rel="stylesheet" />

		<link rel="stylesheet" type="text/css" href="theme/frontend/modules/menu/css/menu.css">
		<link rel="stylesheet" type="text/css" href="theme/frontend/modules/menumobile/css/headroom.css">
		<link rel="stylesheet" type="text/css" href="theme/frontend/modules/menumobile/css/meanmenu.css">

		<link href="theme/frontend/css/style1.css" type="text/css" rel="stylesheet" />

		<link href="theme/frontend/css/style.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
	 <div id="bg-load" style="display:none;"> 
        <div class="loader"> 
            <div class="miniloader"></div> 
        </div>
    </div> 

	@include('header')

	@yield('content')

	@include('footer')

	<script src="theme/frontend/js/jquery-2.2.1.min.js"></script>
	<script src="theme/frontend/js/bootstrap.min.js" defer></script>
	<script src="theme/frontend/js/wow.js" defer></script>
	<script src="theme/frontend/js/jquery.easing.1.3.js" defer></script>
	<script src="theme/frontend/js/camera.min.js" defer></script>
	<script src="theme/frontend/zoom/cloudzoom.js" defer></script>
	<script src="theme/frontend/js/owl.carousel.min.js" defer></script>

	<script type="text/javascript" src="theme/frontend/modules/menumobile/js/headroom.min.js" defer></script>
	<script type="text/javascript" src="theme/frontend/modules/menumobile/js/jQuery.headroom.min.js" defer></script>
	<script type="text/javascript" src="theme/frontend/modules/menumobile/js/jquery.meanmenu.js" defer></script>
	<script type="text/javascript" src="theme/frontend/modules/menumobile/js/menu.js" defer></script>
	<script src="theme/frontend/js/script.js" defer></script>
	<script src="theme/frontend/js/script1.js" defer></script>
	

	




	</body>
</html>