<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta property="og:updated_time" content="<?php echo time()?>" />
<?php $url=  $this->uri->segment(4);
if($url){
$content = getstory( $this->uri->segment( 4 ) );
if($content['spideyImage']){?>
<meta property="og:image" content="<?php echo base_url();?>uploads/spidey/<?php echo $content['spideyImage'];?>" />
<?php }else{?>
<meta property="og:image" content="<?php echo base_url().'uploads/noimage/no-image-614x373.png'; ?>" 
<?php }?>
<meta property="og:title" content="<?php echo $content['spidyName'];?>" />
<meta property="og:url" content="<?php echo current_url();?>" />
<?php $page=$url;
}else{ $page = $this->uri->segment(1);
} $seo = get_seo($page);if($seo){?>
<title><?php echo($seo[0]['title']);?></title>
<meta name="description" content="<?php echo($seo[0]['description']);?>" />
<meta name="keywords" content="<?php echo($seo[0]['keywords']);?>" />
<?php }elseif($this->uri->segment(2)=='share'){
$inbrief= get_share($this->uri->segment(3));
?>
<title><?php echo $inbrief['title'];?></title>
<meta property="og:description" content="<?php echo $inbrief['summary'];?>" />
<?php if($inbrief['images']){?>
<meta property="og:image" content="<?php echo base_url().'uploads/spidey/'.$inbrief['images'];?>" />
<?php }else{?>
<meta property="og:image" content="<?php echo base_url().'uploads/noimage/no-image-614x373.png'; ?>" 
<?php }?>
<meta property="og:title" content="<?php echo $inbrief['title'];?>" />
<meta property="og:url" content="<?php echo base_url();?>inbrief/share/<?php echo $inbrief['id'];?>" />
<?php }else{ ?>
<title>Spideybuzz</title>
<?php }?>
   
	
	<link rel="icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon" />
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH; ?>sb-css/animate.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>sb-css/swiper.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>sb-css/jquery.mCustomScrollbar.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>sb-css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>sb-css/slick.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH; ?>sb-css/home.slider.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH;?>sb-css/responsive.css" />

    <script src="<?php echo base_url().'assets/js/';?>jquery-2.1.4.min.js" ></script>
    <script src="<?php echo base_url().'assets/sb-js/';?>jquery.ticker.min.js"></script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_API_KEY; ?>"></script>
	<script type="text/javascript">
		//Resize handler to reset the menu visibility 
		var resizeTimer;
		$(window).on({
		    resize: function(e) {
		        clearTimeout(resizeTimer);
			    resizeTimer = setTimeout(function () {
			        if ($(window).width() > 800) {
			            $("#pmenu").show();
						$("#mobile_menu").hide();
			        } else {
			            $("#mobile_menu").show();
						$("#pmenu").hide();
			        }
			    }, 100);
		    },
		    load: function(f) {
		        clearTimeout(resizeTimer);
			    resizeTimer = setTimeout(function () {
			        if ($(window).width() > 800) {
			            $("#pmenu").show();
						$("#mobile_menu").hide();
			        } else {
			            $("#mobile_menu").show();
						$("#pmenu").hide();
			        }
			    }, 100);
		    }
		});

	    function areaMap(latitude, longitude) {
	        var myCenter = new google.maps.LatLng(latitude, longitude);

	        var map = new google.maps.Map(document.getElementById('areamap'), {
	          zoom: 14,
	          center: myCenter,
	          mapTypeId:google.maps.MapTypeId.ROADMAP
	        });

	        var marker = new google.maps.Marker({
	            position:myCenter,
	        });

	        marker.setMap(map);
	    }

	    $(document).ready( function() {
		    $('#story-tab-box').css("display", "none");

		    $(".newstab").click(function() {
		        $("#news-tab-box").slideToggle('200','linear');
		    });

		    $(".storytab").click(function() {
		        $("#story-tab-box").slideToggle('200','linear');
		    });

		    $('.newstab').on('click', function() {
			   $('#story-tab-box').css("display", "none");
			});

		    $('.opinion').on('click', function() {
		       $('#news-tab-box').css("display", "none");
		    });

		    $('li.features').on('click', function() {
		       $('div#news-tab-box').css("display", "none");
		    });

		    $('.storytab').on('click', function() {
			  $('#news-tab-box').css("display", "none");
			});
		});
	</script>
	
 </head>
 