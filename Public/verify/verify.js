/*
* @Author: Administrator
* @Date:   2017-12-23 10:16:19
* @Last Modified by:   Administrator
* @Last Modified time: 2017-12-23 10:28:38
*/
$(function () {
    var verify = $('.verify').attr('src')
    $('.refresh').click(function () {
        $('.verify').attr('src', verify+'/'+Math.random());
    });
});