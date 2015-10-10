define(function() {

	var ua = navigator.userAgent.toLowerCase(); //获取用户端信息

    var info = {

     ie: /msie/.test(ua) && !/opera/.test(ua),  //匹配IE浏览器
     ie10:/msie/.test(ua) && /10/.test(ua),
     op: /opera/.test(ua),  //匹配Opera浏览器

     sa: /version.*safari/.test(ua),  //匹配Safari浏览器

     ch: /chrome/.test(ua),  //匹配Chrome浏览器

     ff: /gecko/.test(ua) && !/webkit/.test(ua)  //匹配Firefox浏览器

    }

    return info

})