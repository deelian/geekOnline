// header高度
var head_H = $('header').outerHeight();
// 咨询导航条高度
var news_H = $('#news .nav').outerHeight();
// 问答导航高度
var ans_H = $('#answer .nav').outerHeight();
//获取滚动条当前的位置
function getScrollTop() {
    var scrollTop = 0;
    if (document.documentElement && document.documentElement.scrollTop) {
        scrollTop = document.documentElement.scrollTop;
    } else if (document.body) {
        scrollTop = document.body.scrollTop;
    }
    return scrollTop;
}

//获取当前可视范围的高度
function getClientHeight() {
    var clientHeight = 0;
    if (document.body.clientHeight && document.documentElement.clientHeight) {
        clientHeight = Math.min(document.body.clientHeight, document.documentElement.clientHeight);
    } else {
        clientHeight = Math.max(document.body.clientHeight, document.documentElement.clientHeight);
    }
    return clientHeight;
}

//获取文档完整的高度
function getScrollHeight() {
    return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
}
window.onscroll = function() {
    // 全部
    if (getScrollTop() + getClientHeight() == getScrollHeight()&&$('.tab span:eq(0)').hasClass('active')&&$('#news .nav li:eq(0)').hasClass('cur')) {
        // $.ajax({
        //     type: 'GET',
        //     url: '../html/update.json',
        //     dataType: 'json',
        //     success: function(data) {
        //         var result = '';
        //         for (var i = 0; i < data.lists.length; i++) {
        //             result += '<a class="item opacity" href="' + data.lists[i].link + '">' +
        //                 '<img src="' + data.lists[i].pic + '" alt="">' +
        //                 '<h3>' + data.lists[i].title + '</h3>' +
        //                 '<span class="date">' + data.lists[i].date + '</span>' +
        //                 '</a>';
        //         }
        //       $('#news .toMore').show();
        //         // 为了测试，延迟1秒加载
        //         setTimeout(function() {
        //           $('#news .toMore').hide();
        //             $('#news .content0 ul').append(result);
        //             $('#news .show').css('height', $('#news .content0').outerHeight());
        //             $('#frame0').css('height', $('#news .content0').outerHeight() + head_H + news_H);
        //         }, 1000);
        //     }
        // });
        var result = '<li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/news.jpg" alt=""></div></li>';
                $('#news .toMore').show();
                // 为了测试，延迟1秒加载
                setTimeout(function() {
                  $('#news .toMore').hide();
                    $('#news .content0 ul').append(result);
                    $('#news .show').css('height', $('#news .content0').outerHeight());
                    $('#frame0').css('height', $('#news .content0').outerHeight() + head_H + news_H);
                }, 1000);
    }



    // // 本地
     if (getScrollTop() + getClientHeight() == getScrollHeight()&&$('.tab span:eq(0)').hasClass('active')&&$('#news .nav li:eq(1)').hasClass('cur')) {
    //     $.ajax({
    //         type: 'GET',
    //         url: '../html/update.json',
    //         dataType: 'json',
    //         success: function(data) {
    //             var result = '';
    //             for (var i = 0; i < data.lists.length; i++) {
    //                 result += '<a class="item opacity" href="' + data.lists[i].link + '">' +
    //                     '<img src="' + data.lists[i].pic + '" alt="">' +
    //                     '<h3>' + data.lists[i].title + '</h3>' +
    //                     '<span class="date">' + data.lists[i].date + '</span>' +
    //                     '</a>';
    //             }
    //           $('#news .toMore').show();
    //             // 为了测试，延迟1秒加载
    //             setTimeout(function() {
    //               $('#news .toMore').hide();
    //                 $('#news .content1 ul').append(result);
    //                 $('#news .show').css('height', $('#news .content1').outerHeight());
    //                 $('#frame0').css('height', $('#news .content1').outerHeight() + head_H + news_H);
    //             }, 1000);
    //         }
    //     });
    var result = '<li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/news.jpg" alt=""></div></li>';
                $('#news .toMore').show();
                // 为了测试，延迟1秒加载
                setTimeout(function() {
                  $('#news .toMore').hide();
                    $('#news .content1 ul').append(result);
                    $('#news .show').css('height', $('#news .content1').outerHeight());
                    $('#frame0').css('height', $('#news .content1').outerHeight() + head_H + news_H);
                }, 1000);

     }


    // // 政策
     if (getScrollTop() + getClientHeight() == getScrollHeight()&&$('.tab span:eq(0)').hasClass('active')&&$('#news .nav li:eq(2)').hasClass('cur')) {
    //     $.ajax({
    //         type: 'GET',
    //         url: '../html/update.json',
    //         dataType: 'json',
    //         success: function(data) {
    //             var result = '';
    //             for (var i = 0; i < data.lists.length; i++) {
    //                 result += '<a class="item opacity" href="' + data.lists[i].link + '">' +
    //                     '<img src="' + data.lists[i].pic + '" alt="">' +
    //                     '<h3>' + data.lists[i].title + '</h3>' +
    //                     '<span class="date">' + data.lists[i].date + '</span>' +
    //                     '</a>';
    //             }
    //           $('#news .toMore').show();
    //             // 为了测试，延迟1秒加载
    //             setTimeout(function() {
    //               $('#news .toMore').hide();
    //                 $('#news .content2 ul').append(result);
    //                 $('#news .show').css('height', $('#news .content2').outerHeight());
    //                 $('#frame0').css('height', $('#news .content2').outerHeight() + head_H + news_H);
    //             }, 1000);
    //         }
    //     });
    var result = '<li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/news.jpg" alt=""></div></li>';
                $('#news .toMore').show();
                // 为了测试，延迟1秒加载
                setTimeout(function() {
                  $('#news .toMore').hide();
                    $('#news .content2 ul').append(result);
                    $('#news .show').css('height', $('#news .content2').outerHeight());
                    $('#frame0').css('height', $('#news .content2').outerHeight() + head_H + news_H);
                }, 1000);
     }

    // // 优惠
     if (getScrollTop() + getClientHeight() == getScrollHeight()&&$('.tab span:eq(0)').hasClass('active')&&$('#news .nav li:eq(3)').hasClass('cur')) {
    //     $.ajax({
    //         type: 'GET',
    //         url: '../html/update.json',
    //         dataType: 'json',
    //         success: function(data) {
    //             var result = '';
    //             for (var i = 0; i < data.lists.length; i++) {
    //                 result += '<a class="item opacity" href="' + data.lists[i].link + '">' +
    //                     '<img src="' + data.lists[i].pic + '" alt="">' +
    //                     '<h3>' + data.lists[i].title + '</h3>' +
    //                     '<span class="date">' + data.lists[i].date + '</span>' +
    //                     '</a>';
    //             }
    //           $('#news .toMore').show();
    //             // 为了测试，延迟1秒加载
    //             setTimeout(function() {
    //               $('#news .toMore').hide();
    //                 $('#news .content3 ul').append(result);
    //                 $('#news .show').css('height', $('#news .content3').outerHeight());
    //                 $('#frame0').css('height', $('#news .content3').outerHeight() + head_H + news_H);
    //             }, 1000);
    //         }
    //     });
    var result = '<li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/news.jpg" alt=""></div></li>';
                $('#news .toMore').show();
                // 为了测试，延迟1秒加载
                setTimeout(function() {
                  $('#news .toMore').hide();
                    $('#news .content3 ul').append(result);
                    $('#news .show').css('height', $('#news .content3').outerHeight());
                    $('#frame0').css('height', $('#news .content3').outerHeight() + head_H + news_H);
                }, 1000);
     }

    // // 专题
     if (getScrollTop() + getClientHeight() == getScrollHeight()&&$('.tab span:eq(0)').hasClass('active')&&$('#news .nav li:eq(4)').hasClass('cur')) {
    //     $.ajax({
    //         type: 'GET',
    //         url: '../html/update.json',
    //         dataType: 'json',
    //         success: function(data) {
    //             var result = '';
    //             for (var i = 0; i < data.lists.length; i++) {
    //                 result += '<a class="item opacity" href="' + data.lists[i].link + '">' +
    //                     '<img src="' + data.lists[i].pic + '" alt="">' +
    //                     '<h3>' + data.lists[i].title + '</h3>' +
    //                     '<span class="date">' + data.lists[i].date + '</span>' +
    //                     '</a>';
    //             }
    //           $('#news .toMore').show();
    //             // 为了测试，延迟1秒加载
    //             setTimeout(function() {
    //               $('#news .toMore').hide();
    //                 $('#news .content4 ul').append(result);
    //                 $('#news .show').css('height', $('#news .content4').outerHeight());
    //                 $('#frame0').css('height', $('#news .content4').outerHeight() + head_H + news_H);
    //             }, 1000);
    //         }
    //     });
    var result = '<li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/news.jpg" alt=""></div></li>';
                $('#news .toMore').show();
                // 为了测试，延迟1秒加载
                setTimeout(function() {
                  $('#news .toMore').hide();
                    $('#news .content4 ul').append(result);
                    $('#news .show').css('height', $('#news .content4').outerHeight());
                    $('#frame0').css('height', $('#news .content4').outerHeight() + head_H + news_H);
                }, 1000);
     }

    // // 活动
     if (getScrollTop() + getClientHeight() == getScrollHeight()&&$('.tab span:eq(0)').hasClass('active')&&$('#news .nav li:eq(5)').hasClass('cur')) {
    //     $.ajax({
    //         type: 'GET',
    //         url: '../html/update.json',
    //         dataType: 'json',
    //         success: function(data) {
    //             var result = '';
    //             for (var i = 0; i < data.lists.length; i++) {
    //                 result += '<a class="item opacity" href="' + data.lists[i].link + '">' +
    //                     '<img src="' + data.lists[i].pic + '" alt="">' +
    //                     '<h3>' + data.lists[i].title + '</h3>' +
    //                     '<span class="date">' + data.lists[i].date + '</span>' +
    //                     '</a>';
    //             }
    //           $('#news .toMore').show();
    //             // 为了测试，延迟1秒加载
    //             setTimeout(function() {
    //               $('#news .toMore').hide();
    //                 $('#news .content5 ul').append(result);
    //                 $('#news .show').css('height', $('#news .content5').outerHeight());
    //                 $('#frame0').css('height', $('#news .content5').outerHeight() + head_H + news_H);
    //             }, 1000);
    //         }
    //     });
    var result = '<li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/wangke1.jpg" alt=""></div></li><li><div class="left fl"><div class="title">上拉加载测试</div><div class="desc clear"><span class="fl fs12">中小企业财税</span><span class="fr fs12"><i class="good"></i>0</span><span class="fr fs12"><i class="look"></i>3k</span></div></div><div class="right fr"><img src="image/news.jpg" alt=""></div></li>';
                $('#news .toMore').show();
                // 为了测试，延迟1秒加载
                setTimeout(function() {
                  $('#news .toMore').hide();
                    $('#news .content5 ul').append(result);
                    $('#news .show').css('height', $('#news .content5').outerHeight());
                    $('#frame0').css('height', $('#news .content5').outerHeight() + head_H + news_H);
                }, 1000);
     }
}
