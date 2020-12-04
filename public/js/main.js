(function($) {
  "use strict"

  // Mobile Nav button toggle
  $('.navbar-toggle-btn').on('click', function() {
    $('.navbar-menu').toggleClass('navbar-menu-active');
  });

  // Mobile Search button toggle
  $('.search-toggle-btn').on('click', function() {
    $('.navbar-search').toggleClass('navbar-search-active');
  });

  // Mobile dropdown
  $('.navbar-menu .has-dropdown > a').on('click', function(e) {
    e.preventDefault();
    $(this).parent().toggleClass('dropdown-active');
  });

  // Home Owl
  $('#home-owl').owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    margin: 0,
    nav: true,
    dots: false,
    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
  });

  // Testimonial Owl
  $('#testimonial-owl').owlCarousel({
    loop: true,
    margin: 15,
    dots: true,
    nav: false,
    autoplay: true,
    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
    responsive: {
      0: {
        items: 1
      },
      992: {
        items: 1
      }
    }
  });

	// Parallax Background
	$.stellar({
		responsive: true
	});

  $('.show-icon').click(function() {
    if($('#div-icon').css('height') != '370px'){
      $('#div-icon').stop().animate({height: '370px'}, 200);
      $(this).text('Lihat Semua');
    }else{
      $('#div-icon').css({height:'100%'});
      var xx = $('#div-icon').height();
      $('#div-icon').css({height:'370px'});
      $('#div-icon').stop().animate({height: xx}, 400);
      // ^^ The above is beacuse you can't animate css to 100% (or any percentage).  So I change it to 100%, get the value, change it back, then animate it to the value. If you don't want animation, you can ditch all of it and just leave: $('.icon-div').css({height:'100%'});^^ //
      $(this).text('Sembunyikan');
    }
  });

  $('#admodal').modal({
    backdrop: 'static',
    keyboard: false,
  });

  $('img').on('click', function() {
  $('#overlay')
    .css({backgroundImage: `url(${this.src})`})
    .addClass('open')
    .one('click', function() { $(this).removeClass('open'); });
  });

  $(document).ready(function(){
    $('#ex1').zoom({
      magnify: 0.5,
    });
    $('#ex2').zoom({
      magnify: 0.5,
    });
    // $('#ex2').zoom({ on:'grab' });
    // $('#ex3').zoom({ on:'click' });      
    // $('#ex4').zoom({ on:'toggle' });
  });

})(jQuery);
