// JavaScript Document

$(window).load(function(e) {
	$("#bn7").breakingNews({
		effect		:"slide-h",
		autoplay	:true,
		timer		:5000,
		color		:'darkred'
	});
});


$(window).on('scroll', function () {
   var scrollTrigger = 118; // px 
	var scrollTop = $(window).scrollTop();
	if (scrollTop > scrollTrigger) { //alert("hi");
	
		$('.pmenu').addClass('fixed');	
		$('.fixed-logo').css("display","block");
		//$('.scroll-section').css("margin-top","75px");		                
		
		
		 $('#searchbar').addClass('fixedse');	
		
	} else {
		$('.pmenu').removeClass('fixed');
		$('.fixed-logo').css("display","none");
		//$('.scroll-section').css("margin-top","0px");	
		$('#searchbar').removeClass('fixedse');

	}
	
   var scrollTrigger = 118; // px 
	var scrollTop = $(window).scrollTop();
	if (scrollTop > scrollTrigger) { //alert("hi");
	
		$('.mobile_menu').addClass('mobilefixed');	
		//$('.fixed-logo').css("display","block");
		//$('.scroll-section').css("margin-top","75px");		                
		
		
		 $('#mobile-searchbar').addClass('mobilefixedse');	
		
	} else {
		$('.mobile_menu').removeClass('mobilefixed');
		//$('.fixed-logo').css("display","none");
		//$('.scroll-section').css("margin-top","0px");	
		$('#mobile-searchbar').removeClass('mobilefixedse');
	}
});




var swiper1 = new Swiper('.swiper1', {
        pagination: '.swiper-pagination',
        paginationClickable: false,
        slidesPerView: 10,
        spaceBetween: 50,
        breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 40
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });
	
	
	var swiper2 = new Swiper('.swiper2', {
        pagination: '.swiper-pagination',
        slidesPerView:4,
        paginationClickable: true,
        spaceBetween: 30,
		        breakpoints: {
            1030: {
                slidesPerView: 4,
                spaceBetween: 40
            },
			1024: {
                slidesPerView: 4,
                spaceBetween: 30
            },
			800: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 20
            },
			360: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }

    });
	
	
	var swiper3 = new Swiper('.swiper3', {
        pagination: '.swiper-pagination3',
        slidesPerView: 3,
        paginationClickable: true,
        spaceBetween: 5,
		nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        freeMode: true,
		//centeredSlides: true,
		//loop: true,
		//autoplay: 2500,
		breakpoints: {
            1024: {
                slidesPerView: 1,
                spaceBetween: 5
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 5
            },
            640: {
                slidesPerView: 1,
                spaceBetween: 5
            },
            480: {
                slidesPerView: 1,
                spaceBetween: 5
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 5
            }
        }
		        

    });
	
	
	var swiper4 = new Swiper('.swiper4', {
        pagination: '.swiper-pagination4',
        paginationClickable: true,
        slidesPerView: 5,
        spaceBetween:20,
		nextButton: '.pn4',
        prevButton: '.pp4',
        breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 20
            },
            768: {
                slidesPerView: 3,
                spaceBetween:40
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 40
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });
	
	var swiper5 = new Swiper('.swiper5', {
        pagination: '.swiper-pagination5',
        paginationClickable: true,
        slidesPerView: 5,
        spaceBetween:20,
		nextButton: '.pn5',
        prevButton: '.pp5',
        breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 20
            },
            768: {
                slidesPerView: 3,
                spaceBetween:40
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 40
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });
	
		var swiper6 = new Swiper('.swiper6', {
        pagination: '.swiper-pagination6',
        paginationClickable: true,
        slidesPerView: 5,
        spaceBetween:20,
		nextButton: '.pn6',
        prevButton: '.pp6',
        breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 20
            },
            768: {
                slidesPerView: 3,
                spaceBetween:40
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 40
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });

		var swiper7 = new Swiper('.swiper7', {
        pagination: '.swiper-pagination7',
        paginationClickable: true,
        slidesPerView: 5,
        spaceBetween:20,
		nextButton: '.pn7',
        prevButton: '.pp7',
        breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 20
            },
            768: {
                slidesPerView: 3,
                spaceBetween:40
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 40
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });
	
		var swiper8 = new Swiper('.swiper8', {
        pagination: '.swiper-pagination8',
        paginationClickable: true,
        slidesPerView: 8,
        spaceBetween:10,
		nextButton: '.pn7',
        prevButton: '.pp7',
        breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 20
            },
            768: {
                slidesPerView: 3,
                spaceBetween:40
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 40
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });
	
	
	// $(document).ready(function(){
    (function($){
        $('.menu-smooth-scroll').scrollingTo({
		easing : 'easeOutQuart',
		animationTime : 1800,
        topSpace: 40, 
		});

    });
	
	
	
	// $(document).ready(function(){
    (function($){
            var submitIcon = $('.searchbox-icon');
            var inputBox = $('.searchbox-input');
            var searchBox = $('.searchbox');
            var isOpen = false;
            submitIcon.click(function(){
                if(isOpen == false){
					//$(".ulclose").hide();
                    searchBox.addClass('searchbox-open');
                    inputBox.focus();
                    isOpen = true;
                } else {
					//$(".ulclose").show('slow');
                    searchBox.removeClass('searchbox-open');
                    inputBox.focusout();
                    isOpen = false;
                }
            });  
             submitIcon.mouseup(function(){
                    return false;
                });
            searchBox.mouseup(function(){
                    return false;
                });
            $(document).mouseup(function(){
                    if(isOpen == true){
                        $('.searchbox-icon').css('display','block');
                        submitIcon.click();
                    }
                });
        	});
            function buttonUp(){
                var inputVal = $('.searchbox-input').val();
                inputVal = $.trim(inputVal).length;
                if( inputVal !== 0){
                    $('.searchbox-icon').css('display','none');
                } else {
                    $('.searchbox-input').val('');
                    $('.searchbox-icon').css('display','block');
                }
            }
			
		$(document).ready(function(e) {
		$('#seemore-navigation').click(function() {
			$('#show-navigation').slideToggle('1000');
					$("i", this).toggleClass("icon-circle-arrow-up icon-circle-arrow-down");
				});
				$('#myCarousel, #myCarousel-two').carousel({
					interval: 11000
				});
				$('#filtered-by').click(function() {
				$('#show-filter').slideToggle('1000');
					$("i", this).toggleClass("white-up-arrow white-down-arrow");
				});
		
			//Home page main slider		
			$('.variable-width').slick({
			  //dots: true,
			   autoplay: true,
			  autoplaySpeed: 7000,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 1,
			  centerMode: true,
			  useTransform: true,
			  variableWidth: true,
			});	
	
			
		});


		(function($){
			$(window).on("load",function(){
                $('#story-tab-box').css("display", "none");
				
				$("#content-1").mCustomScrollbar({
					autoHideScrollbar:false,
					theme:"rounded"
				});
				
				$("#content-2").mCustomScrollbar({
					autoHideScrollbar:false,
					theme:"minimal-dark"
				});
				
				$(".scroll-text").mCustomScrollbar({
					autoHideScrollbar:false,
					theme:"minimal-dark"
				});
				
				$("#content-6").mCustomScrollbar({
					axis:"x",
					theme:"minimal-dark",
					autoHideScrollbar:true,
					scrollbarPosition:"outside",
					contentTouchScroll: true,
					autoExpandScrollbar:true,
					moveDragger:true,
					advanced:{autoExpandHorizontalScroll:true}
				});
			});
		})(jQuery);




		function mylikeFunction(like) {
			like.classList.toggle("fa-thumbs-down");
		}
		
		function myFunction() {
			var replycomment = document.getElementById('reply-comment-list');
			if (replycomment.style.display === 'none') {
				replycomment.style.display = 'block';
			} else {
				replycomment.style.display = 'none';
			}
		}


$(function() {
   $(window).scroll(function() { 
		if($(this).scrollTop() > 500) { 
			$('.goToTop').addClass("showGototop");    
		}else{
			$('.goToTop').removeClass("showGototop");
		}
	});
});
 $(".goToTop").click(function () {
       $("body,html").animate({scrollTop: 0}, 800)
 });


$(function(){
  var $searchlink = $('#searchtoggl i');
  var $searchbar  = $('#searchbar');
  
  $('#ulclose a').on('click', function(e){
    e.preventDefault();
	    
    if($(this).attr('id') == 'searchtoggl') {
      if(!$searchbar.is(":visible")) { 
        // if invisible we switch the icon to appear collapsable
        $searchlink.removeClass('fa-search').addClass('fa-times');
      } else {
        // if visible we switch the icon to appear as a toggle
        $searchlink.removeClass('fa-times').addClass('fa-search');
      }
      
      $searchbar.slideToggle(300, function(){
        // callback after search bar animation
      });
    }
  });
  
  $('#searchform').submit(function(e){
    e.preventDefault(); // stop form submission
  });
});

$(function(){
  var $searchlinkmobile = $('#searchtogglmobile i');
  var $searchbarmobile  = $('#mobile-searchbar');
  
  $('#ulmobileclose a').on('click', function(e){
    e.preventDefault();
	    
    if($(this).attr('id') == 'searchtogglmobile') {
      if(!$searchbarmobile.is(":visible")) { 
        // if invisible we switch the icon to appear collapsable
        $searchlinkmobile.removeClass('fa-search').addClass('fa-times');
      } else {
        // if visible we switch the icon to appear as a toggle
        $searchlinkmobile.removeClass('fa-times').addClass('fa-search');
      }
      
      $searchbarmobile.slideToggle(300, function(){
        // callback after search bar animation
      });
    }
  });
  
  $('#searchform').submit(function(e){
    e.preventDefault(); // stop form submission
  });
});






//news alerts script
var modal = document.getElementById('id01');
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}


/*Mobile Menu Js*/
function openNav() {
    document.getElementById("mySidenav").style.width = "290px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}


function myFunctionone() {
    var x = document.getElementById('myNews');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
		alert(hello)
    }
}
function myFunctiontwo() {
    var x = document.getElementById('filterBy');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}
function myFunctionthree() {
    var x = document.getElementById('submitBy');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}





