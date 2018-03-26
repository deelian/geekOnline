$(function(){
  // header高度
  var head_H = $('header').outerHeight();
  // 咨询导航条高度
  var news_H = $('#news .nav').outerHeight();
  // 问答导航高度
  var ans_H = $('#answer .nav').outerHeight();

  $('#news .show').css('height', $('#news .content').height());
  $('#answer .show').css('height', $('#answer .content').height());

  $('#course').css('width', $(document.body).width());
  $('#course').css('left', $(document.body).width());

  $('#news').css('width', $(document.body).width());
  $('#news').css('left', '0px');
  $('#news .content').css('width', $(document.body).width());
  $('#news .content1').css('left', $(document.body).width());
  $('#news .content2').css('left', $(document.body).width() * 2);
  $('#news .content3').css('left', $(document.body).width() * 3);
  $('#news .content4').css('left', $(document.body).width() * 4);
  $('#news .content5').css('left', $(document.body).width() * 5);


  $('#answer').css('width', $(document.body).width());
  $('#answer').css('left', $(document.body).width() * 2);
  $('#answer .content').css('width', $(document.body).width());
  $('#answer .content2').css('width', $(document.body).width());
  $('#answer .content2').css('left', $(document.body).width());

  $('#teach').css('width', $(document.body).width());
  $('#teach').css('left', $(document.body).width() * 3);

  $('#frame0').css({
      'width': $(document.body).width(),
      'height': $('#news').outerHeight() + head_H
  });

  // 跳转
  $('.tab span').each(function(i) {
      $(this).on('click', function() {
          var j = 'a' + i;
          $('#frame0').css('height', $('.' + j).outerHeight() + head_H);
          $('#big').animate({
              left: -$(document.body).width() * i
          });
      })
  });
  $('#news .nav li').each(function(i) {
      $(this).on('click', function() {
          var j = 'content' + i;
          $('#frame0').css('height', $('.' + j).outerHeight() + head_H + news_H);
          $('#news .show').css('height', $('.' + j).outerHeight());
          $('#news .move').animate({
              left: -$(document.body).width() * i
          });
      })
  });
  $('#answer .box span').each(function(i) {
      $(this).on('click', function() {
          var j = 'c' + i;
          $('#frame0').css('height', $('.' + j).outerHeight() + head_H + ans_H);
          $('#answer .show').css('height', $('.' + j).outerHeight());
          $('#answer .move').animate({
              left: -$(document.body).width() * i
          });
      })
  });

  // 选项卡动画
  $("header .tab span").click(function() {
      $("header span").eq($(this).index()).addClass("active").siblings().removeClass("active");
  });
  $("#news .nav li").click(function() {
      $("#news .nav li").eq($(this).index()).addClass("cur").siblings().removeClass("cur");
  });
  $("#answer .box span").click(function() {
      $("#answer .box span").eq($(this).index()).addClass("active2").siblings().removeClass("active2");
  });
})
