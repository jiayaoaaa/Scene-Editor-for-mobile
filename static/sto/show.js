//2015.09.15 15:05
require.config({ //配置
    baseUrl: SP_URL_STO,
    paths: {
        avalon: "vendor/avalon/avalon", //必须修改源码，禁用自带加载器，或直接删提AMD加载器模块
        swiper: 'vendor/swiper/js/swiper.min',
        mmPromise: 'vendor/avalon/mmPromise',
        mmRequest: 'vendor/avalon/mmRequest.modern',
        wx:'http://res.wx.qq.com/open/js/jweixin-1.0.0'

    },
    shim: {
        jquery: {
            exports: "jquery"
        },
        avalon: {
            exports: "avalon"
        }
    }
})

require(['avalon', 'swiper', 'mmRequest','wx'], function(avalon, Swiper) {

    var $ = function(s) {
        if (s.indexOf('#') > -1 || s.indexOf('=') > -1) {
            return document.querySelector('body').querySelector(s)

        } else {
            return document.querySelector('body').querySelectorAll(s)

        }
    }

    var manifest = []
    window.manifest=manifest

    var config = {
        width: 384,
        height: 624,
        bgSound: ''
    }

    function getLoadMainfileformJson(data) {

        console.log('从json数据中筛选出图片..........')

        avalon.each(data.pageItem, function(k, v) {
            if (v.pagebgImage) {
                manifest.push({
                    src: v.pagebgImage
                })
            }


        return manifest

    }

    var loaded = 0

    function preloader(manifest, callback) {

        if (manifest.length > 0) {


            for (var i = manifest.length - 1; i >= 0; i--) {
                var img = new Image()
                console.log(manifest[i].src)
                img.onload = function() {
                    loaded++
                    if (loaded == manifest.length) {
                        console.log('图片资源加载完毕！')
                        callback()
                    }
                }

                img.src = manifest[i].src


            };
        } else {
            console.log('无图片资源！')

            callback()

        }


    }

    function playMusic() {
        console.log('playMusic')
        var isplay;
        var audio = document.getElementsByTagName("audio")[0];

        audio.src = config.bgSound;
                                console.log(audio)

        audio.autobuffer = true;


            audio.play();
            isplay = true;
            var musicEl = document.getElementById('music')
            musicEl.style.display = 'block'
            musicEl.classList.add('on')
            musicEl.addEventListener('touchstart', function() {
                if (isplay) {
                    //audio.currentTime = 0;
                    this.classList.remove('on')
                    this.classList.add('off')
                    isplay = false;
                    audio.pause();
                } else {
                    this.classList.remove('off')
                    this.classList.add('on');
                    audio.play();
                    isplay = true
                }

            });

        audio.addEventListener('ended', function() {
            setTimeout(function() {
                audio.play();
            }, 500);
        }, false);
    }






    var winW = document.documentElement.clientWidth
    var winH = document.documentElement.clientHeight

    var scale = {
        x: winW / config.width,
        y: winH / config.height
    }

//开始读取数据

   avalon.getJSON('/letter/show.json', {
        id: SP_LETTER_ID
    }, function(json) {


    var swiperConfig=avalon.mix(true,{},json.data.pageConfig)
    // document.title = json.data.title
    var loadfies = getLoadMainfileformJson(json.data)

        preloader(loadfies, function() {

          if(!!swiperConfig.arrowStyle){
            $('#arrow').classList.add('arrow-'+swiperConfig.scrollDirection)
            $('#arrow').classList.add('arrow'+swiperConfig.arrowStyle)

          }else{
             $('#arrow').style.display='none'
          }


        })

        var pageConfig = json.data.pageConfig
        var pageItem = json.data.pageItem
        //如果有音乐播放
        if (json.data.pageConfig.musicUrl !== '' && json.data.pageConfig.hasMusic == true) {
            config.bgSound = SP_URL_FILE + json.data.pageConfig.musicUrl
            playMusic()

        }

        //创建VM 、初始化swiper
        var MainVM = avalon.define({
        $id: 'main',
        pageItemArr: json.data.pageItem,
        mainConfig: json.data.pageConfig,
        formSubmit: function(el) {
            var _this = this
            _this.innerHTML="提交中..."
            //提交表单
            avalon.post('/letter/apply.json', {
                letterId: SP_LETTER_ID,
                data: {
                    name: _this.parentNode.querySelector('#name').value,
                    phone: _this.parentNode.querySelector('#phone').value,
                    email: _this.parentNode.querySelector('#email').value,
                    sex: (function() {

                        var sexarr = _this.parentNode.querySelectorAll('input[name="sex"]')
                        for (var i = 0; i < sexarr.length; i++) {
                            if (sexarr[i].checked == true) {
                                return (sexarr[i].value);
                            }
                        }
                    })(),
                    company: _this.parentNode.querySelector('#company').value,
                    position: _this.parentNode.querySelector('#position').value,
                    address: _this.parentNode.querySelector('#address').value,

                }
            }, function(data) {
                            _this.innerHTML="提交"

                if (data.status == 0) {
                    alert('报名成功！')
                } else {
                    console.log(data)
                    alert(data.msg)
                }
            })


        },
        rendered: function() {
          console.info('执行rendered')
          console.log(swiperConfig.scrollDirection)

            var mySwiper = new Swiper('.swiper-container', {
                // Optional parameters
                direction: swiperConfig.scrollDirection,
                effect : swiperConfig.scrollEffect || "slide" ,
                loop:swiperConfig.isLoop,
                mousewheelControl: true,
                onInit: function(swiper) {
                    console.log('Swiper初始化了')
                    //alert(swiper.activeIndex);提示Swiper的当前索引
                    $('#loading').style.display = 'none'

                },
                onSlideChangeStart: function(swiper) {

                    var curDom = document.querySelector('.swiper-slide-active').querySelectorAll('.elements')

                        avalon.each(curDom, function(k, v) {

                            // setStyle(v)
                           setStyle(v)

                        })

                        function setStyle(el){


                               var anStyle = el.getAttribute('animation')
                            var delay = el.getAttribute('delay')
                            console.log('延迟时间:'+delay)
                             el.style.animation = ''
                            el.style.webkitAnimation = ''
                            el.offsetWidth = el.offsetWidth //触发reflow

                                                        console.log(delay>0)

                          if (delay > 0) {
                               el.style.display = 'none'

                                window.setTimeout(function() {
                                    el.style.display = 'block'
                                    el.style.webkitAnimation = anStyle
                                    el.style.animation = anStyle

                                }, delay * 1000)

                            } else {
                                el.style.webkitAnimation = anStyle
                                el.style.animation = anStyle
                            }


                        }

                        // function setStyle(el) {
                        //     var anStyle = el.getAttribute('animation')
                        //     var delay = parseInt(el.getAttribute('delay'))
                        //     el.style.animation = ''
                        //     el.style.webkitAnimation = ''
                        //     el.offsetWidth = el.offsetWidth //触发reflow

                        //     if (delay > 0) {
                        //         v.style.display = 'none'
                        //         window.setTimeout(function() {
                        //             v.style.display = 'block'
                        //             el.style.webkitAnimation = anStyle
                        //             el.style.animation = anStyle
                        //         }, delay * 1000)

                        //     } else {
                        //         el.style.webkitAnimation = anStyle
                        //         el.style.animation = anStyle
                        //     }
                        // }

                                      

          



                }

            })

        }
    })

    avalon.scan()


    //wx

     wx.config(wxconfig);
      wx.ready(function () {

        console.log('wxready')
        // 在这里调用 API
        
        //分享到朋友圈
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: location.href, // 分享链接
            imgUrl: manifest[0].src || SP_URL_STO+'/img/logo.png', // 分享图标
            success: function () { 
                // 用户确认分享后执行的回调函数
            },
            cancel: function () { 
                // 用户取消分享后执行的回调函数
            }
        });
        
        //分享给朋友
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: letter.discrib, // 分享描述
            link: location.href, // 分享链接
            imgUrl: manifest[0].src || SP_URL_STO+'/img/logo.png', // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () { 
                // 用户确认分享后执行的回调函数
            },
            cancel: function () { 
                // 用户取消分享后执行的回调函数
            }
        });
        
        //分享到QQ
        wx.onMenuShareQQ({
        title: '{%$letter.title%}', // 分享标题
        desc: '{%$letter.discrib%}', // 分享描述
        link: 'location.href', // 分享链接
        imgUrl: manifest[0].src || SP_URL_STO+'/img/logo.png', // 分享图标
        success: function () { 
           // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
           // 用户取消分享后执行的回调函数
        }
    });

      });


    })
})
