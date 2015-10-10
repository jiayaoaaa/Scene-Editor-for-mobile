/*********************************************************************
 *                           配置                                *
 **********************************************************************/

require.config({ //配置
    baseUrl: SP_URL_STO,
    paths: {
        jquery: 'vendor/jquery/jquery.2.1.4.min',
        avalon: "vendor/avalon/avalon.1.46", //必须修改源码，禁用自带加载器，或直接删提AMD加载器模块
        validation: 'vendor/avalon/avalon.validation',
        text: 'vendor/require/text',
        domReady: 'vendor/require/domReady',
        css: 'vendor/require/css',
        mmPromise: 'vendor/avalon/mmPromise',
        config: 'modules/editor-config',
        draggable: 'vendor/avalon/avalon.draggable',
        resizeable: 'vendor/avalon/avalon.resizable',
        slider: 'vendor/avalon/slider/avalon.slider',
        colorpicker: 'vendor/avalon/colorpicker/avalon.colorpicker',
        dropzone: 'vendor/upload/dropzone-amd-module',
        pace: 'vendor/pace.min',
        broswer: 'modules/broswer',
        layer:'vendor/layer/layer',
        notify:'vendor/notify/notify_md',
        scrollbar:'vendor/scrollbar/jquery.mCustomScrollbar.concat.min',
        scrollbarCss:'vendor/scrollbar/jquery.mCustomScrollbar.min'


    },
    priority: ['text', 'css'],
    shim: {
        jquery: {
            exports: "jquery"
        },
        avalon: {
            exports: "avalon"
        },
        scrollbar:{
            deps:['jquery'],
            exports:'scrollbar'
        }
    }
})



/*********************************************************************
 *                           依赖                                    *
 **********************************************************************/
 


require(['domReady!','jquery', 'config',  'draggable', 'resizeable', 'slider', 'colorpicker','notify','css!scrollbarCss','scrollbar'], function() { //第二块，添加根VM（处理共用部分）

$('#pageTree').mCustomScrollbar({ theme:"minimal-dark"})
$('#sidebar').mCustomScrollbar({ theme:"minimal-dark"})



       require(['broswer','pace'], function(broswer,pace) {

  if( broswer.ch || broswer.ff || broswer.ie10 ||broswer.sa){
            pace.start()
            pace.on('done', function() {
                $('#loading').fadeOut()
            })
        }else{
          return
        }

    })



    $.getJSON('/letter/show.json', {
        id: SP_LETTER_ID
    }, function(json) {

        console.log(json)

        if (json.status != 0) {
            notify.log('数据加载失败，请刷新重试')
            return
        }

        // console.log(json.data.pageItem)

        var pageArr = json.data.pageItem
        var pageConfigData = json.data.pageConfig

        if (pageArr == null) {
            pageArr = [{
                pagebgColor: '',
                pagebgImage: '',
                comInsList: [{
                    type: 'text',
                    textcontent: '开始制作吧',
                    width: '260',
                    height: '43',
                    left: '60',
                    top: '210',
                    textAlign: 'center',
                    backgroundColor: '#c00',
                    lineHeight: '1.5',
                    fontColor: '#ffffff',
                    opacity: 100,
                    fontSize: '28',
                    zIndex: 1,
                    borderStyle: 'none',
                    borderColor: 'none',
                    borderWidth: '0',
                    borderRadius: '0',
                    animationName: 'zoomIn',
                    animationDuration: '1',
                    animationDelay: '0',
                    animationIterationCount: 1
                }]
            }]
        }






        var $editorFrame = $('#editorFrame')
        var i = 0

        function setEditorFrameCenter(){
            var topbarH=$('.top-box').height()
            var documentH=$(document).height()
            var contentH=documentH-topbarH
           $('#pageTree,#sidebar,#editor').height(contentH)

            var top=$(document).height()-$('.top-box').height()-$editorFrame.height()
            if(top<0){top=10}
            $editorFrame.css({
                marginTop:top/2
            })
        }

        $(window).on('resize',setEditorFrameCenter)

        setEditorFrameCenter()

            //全局控制器
        var rootModel = avalon.define({
            $id: 'root',
            mainconfigSrc: SP_URL_STO + 'tpl/mainconfig.tpl',
            consconfigSrc: SP_URL_STO + 'tpl/consconfig.tpl',
            pageconfigSrc: SP_URL_STO + 'tpl/pageconfig.tpl',
            // insertSingleImage: showUpload,
            addPage: function() {
                TreeModel.addPage()
            },
            baseSetting: function() {
                mainConfigVM.isActive = true
                pageConfigVM.isActive = false
                ccConfigVM.isActive = false
            },
            saveAll:function(){
                saveAllPageData()
                console.log('提交中.....')
                var pageconfig = JSON.stringify(mainConfigVM.$model)
                var pageItem = JSON.stringify(TreeModel.$model.pageArr)
                console.log(mainConfigVM.$model)
                console.log(TreeModel.$model.pageArr)

                $.post('/active/lettereditor.json', {
                    id: SP_LETTER_ID,
                    pageConfig: pageconfig,
                    pageItem: pageItem
                }, function(data) {
                    console.log(data)
                    if (0 == data.status) {
                            notify.log('已保存！')
                    }
                })
            },
            saveDone: function() {

                saveAllPageData()

                notify.log('提交中.....')

                var pageconfig = JSON.stringify(mainConfigVM.$model)
                var pageItem = JSON.stringify(TreeModel.$model.pageArr)
                console.log(mainConfigVM.$model)
                console.log(TreeModel.$model.pageArr)



                $.post('/active/lettereditor.json', {
                    id: SP_LETTER_ID,
                    pageConfig: pageconfig,
                    pageItem: pageItem
                }, function(data) {
                    console.log(data)
                    if (0 == data.status) {
                        window.location.href = '/letter/createsuccess.html?id=' + SP_LETTER_ID
                    }
                })



                //保存页面设置

            },
            insertSingleTxt: function() {
                editorVm.insertSingleTxt()
            },
            insertSingleImage: function() {
                editorVm.insertSingleImage()
            },
            insertForm: function() {
                editorVm.insertForm()
            }
        })


        //单页背景颜色控制器
        var pageConfigVM = avalon.define({
            $id: 'pageConfig',
            pagebgImage: '',
            pagebgColor: '',
            isActive: false
        })

        pageConfigVM.$watch('pagebgColor', function(data) {

            console.info('pagebgColor change！！！！！！！！！！！！' + data)

            editorVm.curPage.pagebgColor = data

            console.log(editorVm.curPage.pagebgColor)

            console.log(editorVm.curPage.$model)


            // //插入到全局数据中 
            editorVm.$fire('all!CurPageDataToGlobal', avalon.mix(true, {}, editorVm.curPage.$model))

        })
        pageConfigVM.$watch('pagebgImage', function(data) {

            console.info('pagebgImage change！！！！！！！！！！！！' + data)

            editorVm.curPage.pagebgImage = data
            $editorFrame.css({
                backgroundImage: 'url(' + data + ')'
            })

            // //插入到全局数据中 
            editorVm.$fire('all!CurPageDataToGlobal', avalon.mix(true, {}, editorVm.curPage.$model))

        })


        // pageConfigVM.$watch('pagebgColor',function(name,a,b){

        //     console.group('监控page设置页chang')

        //     console.info(name+ '改变'+a)

        //     console.groupEnd()

        //     editorVm.curPage[name]=a
        //     console.log( editorVm.curPage[name])

        //     console.log( editorVm.$model.curPage)

        //     $.extend(true,TreeModel.$model.ThePageItemData[TreeModel.curPageIndex],editorVm.$model.curPage)

        //             console.log(TreeModel.ThePageItemData[TreeModel.curPageIndex])

        // })



        //获取数据







        var glo_index = 0;


        //Pagetree 


        var TreeModel = avalon.define({
            $id: "pageTree",
            pageArr: pageArr,
            curPageIndex: 0,
            remove: function(index, event) {
                var e = event || window.event
                event.preventDefault()
                event.stopPropagation()
                if (TreeModel.pageArr.size() <= 1) {
                    notify.log('请至少保留一页')

                    return false


                } else {
                    TreeModel.pageArr.removeAt(index)

                   TreeModel.showpage(index-1)

                }

                notify.log('页面删除成功！')
            },

            addPage: function() {
                TreeModel.pageArr.push({
                    pagebgColor: '',
                    pagebgImage: '',
                    comInsList: [
                        // {
                        //     type: 'text',
                        //     textcontent: '新建页面',
                        //     width: '123',
                        //     height: '80',
                        //     left: '100',
                        //     top: '210',
                        //     textAlign: 'center',
                        //     backgroundColor: '#c00',
                        //     lineHeight:'1.5',
                        //     fontColor:'#333333',
                        //     opacity: 100,
                        //     fontSize:'28',
                        //     zIndex:1,
                        //     borderStyle: 'none',
                        //     borderColor: 'none',
                        //     borderWidth: '0',
                        //     borderRadius: '0',
                        //     animationName: 'rotateIn',
                        //     animationDuration: '1',
                        //     animationDelay: '0',
                        //     animationIterationCount: 1,
                        //     }
                    ]
                })

                //显示最后一页
                TreeModel.showpage(TreeModel.pageArr.size()-1)


            },
            showpage: function(index) {
                // saveAllPageData()

                TreeModel.curPageIndex = index
                pageConfigVM.isActive = true
                mainConfigVM.isActive = false
                ccConfigVM.isActive = false
                editorVm.selectedIndex = -1

                var oneItemData = TreeModel.pageArr
                console.log(oneItemData.length)
                console.log(oneItemData)
                console.log(oneItemData[index])

                if (oneItemData.length > 0) {

                    TreeModel.$fire('all!curPageUpdate', oneItemData[index])

                } else {
                    editorVm.curPage.comInsList = []
                }

            }




        })

        TreeModel.$watch('CurPageDataToGlobal', function(curPagedata) {

            console.log('CurPageDataToGlobal!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!')
            console.log(curPagedata)

            // pageTreeArr[index]=data;
            //得写两次才行，要不$model不自动更新
            var index = TreeModel.curPageIndex

            console.log("$watch(CurPageDataToGlobal---->in  " + index)

            TreeModel.pageArr[index] = avalon.mix(true, {}, curPagedata)
            TreeModel.pageArr.$model[index] = avalon.mix(true, {}, curPagedata)

            console.log(TreeModel.pageArr[index])



        })



        var Editor = function() {}


        //插入元素的时候 
        function insertElement(data) {
            console.log('插入在第几页？--> ' + TreeModel.curPageIndex)
            if (TreeModel.curPageIndex < 0) {
                notify.log('请先增加页面')
                return
            }
            editorVm.curPage.comInsList.push(data);

            var curEleIndex = editorVm.curPage.comInsList.size()
            editorVm.selectedIndex = curEleIndex - 1
            var curPageData = avalon.mix(true, {}, editorVm.$model.curPage);
            // //同时把文字数据插入到全局数据中  使用fire
            editorVm.$fire('all!CurPageDataToGlobal', curPageData)

            //触发点击事件
            editorVm.chooseElements(editorVm.selectedIndex)


                // //触发元素属性改变
                // editorVm.$fire('all!comPropsRefresh', data)



        }


        //save curPage

        // function saveCurPage() {
        //     var index = TreeModel.curPageIndex
        //     var curPagedata = editorVm.curPage.$model

        //     TreeModel.ThePageItemData[index] = avalon.mix(true, {}, curPagedata)
        //     TreeModel.ThePageItemData.$model[index] = avalon.mix(true, {}, curPagedata)
        // }


        function saveAllPageData() {



            var elindex = editorVm.selectedIndex
            console.log('elindex' + elindex)
            var pageIndex = TreeModel.curPageIndex
            console.log('pageIndex' + pageIndex)

            var curPagedata = editorVm.curPage.$model

            console.log('editorVm.curPage.$model:')

            console.log(editorVm.curPage.$model)


            // avalon.mix(true, TreeModel.pageArr[pageIndex], curPagedata)

            // avalon.mix(true, TreeModel.$model.pageArr[pageIndex], curPagedata)


            TreeModel.pageArr[pageIndex]=avalon.mix(true, {}, curPagedata) 
            TreeModel.$model.pageArr[pageIndex]=avalon.mix(true, {}, curPagedata) 



            // TreeModel.pageArr.$model[pageIndex] = avalon.mix(true, {}, curPagedata)

            console.info('保存后的data')
            console.log(TreeModel.pageArr)






        }

       //隐藏右键菜单
        Editor.hideContextMenu=function(){
              editorVm.ctrl.isShowLayerCtrl = false
                ccConfigVM.isActive = false
                pageConfigVM.isActive=true 
        }

        Editor.hasFired=false
        Editor.timer=null



        Editor.model = {
            $id: 'editor',
            $skipArray: ['resizeable'],

            // 背景属性
            globleConfig: {
                scrollDirection: 'vertical', //滑屏方向 vertical  hor
                scrollEffect: '', //滑屏特效
                arrowStyle: '', //箭头样式
                isLoop: true,
                bgSound: 'url',
                backgrundImage: ''
            },
            curPage: {
                pagebgColor: '',
                pagebgImage: '',
                comInsList: [{
                    type: 'text',
                    textcontent: '',
                    imageUrl: '',
                    width: '0',
                    height: '0',
                    left: '100',
                    top: '210',
                    textAlign: 'center',
                    backgroundColor: '#c00',
                    lineHeight: '1.5',
                    fontColor: '#333333',
                    opacity: 100,
                    fontSize: '28',
                    zIndex: 1,
                    borderStyle: 'none',
                    borderColor: 'none',
                    borderWidth: '0',
                    borderRadius: '0',
                    animationName: 'rotateIn',
                    animationDuration: '1',
                    animationDelay: '0',
                    animationIterationCount: 1,
                    formElment: []
                }]
            },
            selectedIndex: -1, //默认无选中
            // 编辑区组件列表

            deleteComponent: function() {

                console.log( editorVm.curPage.comInsList)


                editorVm.curPage.comInsList.removeAt(editorVm.selectedIndex);

                 console.log( editorVm.curPage.comInsList)

                editorVm.selectedIndex = -1
                saveAllPageData()
                Editor.hideContextMenu()




            },
            checkMenu: function() {
                var index = editorVm.curPage.comInsList[editorVm.selectedIndex].zIndex
                if (index <= 0) {
                    editorVm.ctrl.isBottomLayer = true
                    editorVm.ctrl.isTopLayer = false

                } else if (index >= editorVm.curPage.comInsList.size()) {

                    editorVm.ctrl.isTopLayer = true
                    editorVm.ctrl.isBottomLayer = false

                } else {
                    editorVm.ctrl.isBottomLayer = false
                    editorVm.ctrl.isTopLayer = false
                }


            },
            toUpLayer: function() {
                editorVm.curPage.comInsList[editorVm.selectedIndex].zIndex += 1
                saveAllPageData()
                Editor.hideContextMenu()


            },
            toDownLayer: function() {
                editorVm.curPage.comInsList[editorVm.selectedIndex].zIndex -= 1
                saveAllPageData()
                Editor.hideContextMenu()

            },
            toTopLayer: function() {

                editorVm.curPage.comInsList[editorVm.selectedIndex].zIndex = editorVm.curPage.comInsList.size()
                saveAllPageData()
                Editor.hideContextMenu()

            },
            toBottomLayer: function() {
                editorVm.curPage.comInsList[editorVm.selectedIndex].zIndex = 0
                saveAllPageData()
                Editor.hideContextMenu()
            },



            mouseenter: function(e) {
                $(this).addClass('selected')

            },
            mouseleave: function(e) {
                $(this).removeClass('selected')
            },
            insertForm: function() {

                console.log(TreeModel.pageArr)

                //历遍数据查找type==form
                var hasform = false

                function hasformFn() {

                    avalon.each(TreeModel.pageArr, function(k, v) {
                        avalon.each(v.comInsList, function(key, val) {
                            console.log(val.type == "form")
                            if (val.type == "form") {
                                hasform = true
                            }
                        })
                    })
                    return hasform

                }

                console.log(hasformFn());

                if (!hasform) {
                    var formdDataTemplate = config.formdDataTemplate
                    insertElement(formdDataTemplate)
                } else {
                    notify.log('一个邀请函只能插入一个表单')
                }

            },
            insertSingleImage: function() {

                var url = SP_URL_STO + 'img/img-placeholder.png'

                var singleImageDataTemplate = {
                    type: 'image',
                    imageUrl: url,
                    width: '123',
                    height: '100',
                    left: '100',
                    top: '200',
                    textAlign: 'center',
                    backgroundColor: '',
                    fontColor: '',
                    fontSize: '24',
                    zIndex: 0,
                    lineHeight: '1.5',
                    opacity: '100',
                    borderStyle: 'none',
                    borderColor: 'none',
                    borderWidth: '0',
                    borderRadius: '0',
                    animationName: 'zoomIn',
                    animationDuration: '1',
                    animationDelay: '0',
                    animationIterationCount: 1,
                }

                insertElement(singleImageDataTemplate)


            },
            insertSingleTxt: function() {

                var singleTxtDataTemplate = {
                    type: 'text',
                    textcontent: '请输入文字',
                    width: '195',
                    height: '48',
                    left: '96',
                    top: '210',
                    textAlign: 'center',
                    backgroundColor: '',
                    lineHeight: '1.5',
                    fontColor: '#333333',
                    opacity: 100,
                    fontSize: '28',
                    zIndex: 0,
                    borderStyle: 'none',
                    borderColor: 'none',
                    borderWidth: '0',
                    borderRadius: '0',
                    animationName: 'rotateIn',
                    animationDuration: '1',
                    animationDelay: '0',
                    animationIterationCount: 1,
                }

                insertElement(singleTxtDataTemplate)

            },
            chooseElements: function(index, e) {
                var e =e || window.event;



                 // e.preventDefault()
                // e.stopPropagation()
                editorVm.selectedIndex = index
                mainConfigVM.isActive = false
                pageConfigVM.isActive = false
                ccConfigVM.isActive = true

                if (e && e.button == 2) {
                    editorVm.ctrl.isShowLayerCtrl = true
                    editorVm.ctrl.layerTop = e.pageY - $('#editorFrame').offset().top
                    editorVm.ctrl.layerLeft = e.pageX - $('#editorFrame').offset().left
                    editorVm.checkMenu()
                }

                //设置选中当前组件的data
                // editorVm.curComponent = editorVm.curPage.comInsList[editorVm.selectedIndex]

                editorVm.$fire('all!comPropsToPanel', {});





     



            },
            ctrl: {
                isSelectPage: true,
                // 右键弹出层显示
                isShowLayerCtrl: false,
                // 右键弹出层显示位置
                layerTop: 0,
                layerLeft: 0,
                // 右键菜单控制
                isTopLayer: false,
                isBottomLayer: false,
            },


        }

        // var hoverTimer

        var editorVm = avalon.define(avalon.mix({}, Editor.model, {

            // 当前场景页


            resizable: {
                start: function() {
                    avalon.log("start resize")
                },
                drag: function(e, data) {
                    this.style.left = data.startLeft + e.pageX - data.startPageX + "px"
                    this.style.top = data.startTop + e.pageY - data.startPageY + "px"
                    console.log('draging')


                    //发送通知，当前组件left top 更改，需要优化先不做。
                    console.log(Editor.timer)

                    clearTimeout(Editor.timer)

                     Editor.timer= setTimeout(function() {

                        console.log('fire!!!!!!!!!!')
                            editorVm.$fire('all!comPropsToPanel', {
                                left: data.left,
                                top: data.top
                            })
                        }, 50)


                },
                //resize 停止
                stop: function(e, data) {
                    console.log('resize stoped!')
                    var pushData = {
                        width: data.resizeWidth,
                        height: data.resizeHeight,
                        left: data.resizeLeft,
                        top: data.resizeTop
                    }


                    //发送通知
                    editorVm.$fire('all!comPropsToPanel', pushData)





                }
            }

        }))



        //点击showpage后
        editorVm.$watch('curPageUpdate', function(data) {

            console.info('curPageUpdate!!!!!!!!!!!!!!!!!!')
            console.info(data);
            if (typeof data !== 'undefined') {

                // avalon.mix(true,editorVm.curPage,data)

                //先设置为空数组在赋值 触发dom2次渲染，否则动画样式不执行。
                editorVm.curPage.comInsList = []
                editorVm.curPage.comInsList = avalon.mix(true, [], data.comInsList)

                // avalon.vmodels.editor.curPage.pagebgImage = data.pagebgImage
                // avalon.vmodels.editor.curPage.pagebgColor = data.pagebgColor
                // avalon.vmodels.editor.curPage.comInsList = []
                // avalon.vmodels.editor.curPage.comInsList = data.comInsList


                pageConfigVM.pagebgImage = data.pagebgImage
                pageConfigVM.pagebgColor = data.pagebgColor

            }



        })





        $('#editorContent').on('click', function(e) {
            e.preventDefault()
            if (e.button !== 2 && $(e.target).attr('id') == 'editor') {
                editorVm.ctrl.isShowLayerCtrl = false
                mainConfigVM.isActive=false
                pageConfigVM.isActive = true
                ccConfigVM.isActive = false
                editorVm.selectedIndex = -1

            }
        })








        // var pageTree=function(){
        //     add:function(){
        //         var o={}
        //         pageTreeArr.push(o)

        //     },
        //     //交换数组
        //     function changeArr(arr,index1,index2){

        //     var o=arr[index1]
        //      arr.splice(index1,1,arr[index2])
        //      arr.splice(index2,1,o)

        //         document.write(arr)


        // }

        // changeArr(arr,-1,1)
        //     remove:function(index){

        //         pageTreeArr.del(index)

        //     },
        //     moveup:function(){
        //         //向上移动元素
        //     }
        //     ,
        //     moveDown:function(){
        //         //向上移动元素
        //     }
        // }

        // var editor=function(){}
        //     editor.prototype={
        //         addElements:'',
        //         removeElements:'',
        //         moveup:'',
        //         moveDown:'',
        //         // body...
        //     }
        // avalon.templateCache["mainconfig"] = require(['text!/tpl/mainconfig'])

        var mainConfigVM = avalon.define({
            $id: "mainConfig",
            isActive: true,
            hasMusic: false,
            musicUrl: '',
            scrollDirection: 'vertical', //滑屏方向 vertical  hor
            scrollEffect: 'slide', //滑屏特效
            arrowStyle: '01', //箭头样式
            isLoop: true,
        })



        /******ccconfig*****/
        /*******配置面板*****/
        var ccConfigVM = avalon.define({
            $id: "ccConfig",
            isActive: false,
            curIndex: 0,
            toggle:0,
            tab:function(index){
                ccConfigVM.toggle=index
            },
            animLib: config.effectArr,
            setAnimate: function(name, $index) {
                ccConfigVM.curIndex = $index
                console.log(ccConfigVM.curIndex)
                ccConfigVM.componentProps.animationName = ''
                ccConfigVM.componentProps.animationName = name
            },
            //需要初始化完成的对象结构，否则不能动态更改
            componentProps: {
                type: '',
                textcontent: '',
                imageUrl: '',
                width: '',
                height: '',
                left: '',
                top: '',
                textAlign: '',
                backgroundColor: '',
                lineHeight: '',
                fontColor: '',
                opacity: '',
                fontSize: '28',
                borderStyle: 'none',
                borderColor: 'none',
                borderWidth: '0',
                borderRadius: '0',
                animationName: 'zoomIn',
                animationDuration: '1',
                animationDelay: '0',
                animationIterationCount: 1,
                formElment: [{
                        name: 'name',
                        label: '姓名',
                        type: "text",
                        disabled: 'disabled',
                        display: 'block',
                        ischecked: true
                    }, {
                        name: 'phone',
                        label: '手机',
                        type: "text",
                        disabled: 'disabled',
                        ischecked: true

                    },

                    {
                        name: 'email',
                        label: '邮箱',
                        type: "text",
                        ischecked: true
                    }, {
                        name: 'sex',
                        label: '性别',
                        type: "radio",
                        radioname: 'sex',
                        text1: '男',
                        text2: '女',
                        ischecked: true
                    },

                    {
                        name: 'company',
                        label: '公司',
                        type: "text",
                        ischecked: true
                    }, {
                        name: 'position',
                        label: '职位',
                        type: "text",
                        ischecked: true
                    }, {
                        name: 'address',
                        label: '地址',
                        type: "text",
                        ischecked: true
                    }


                ]
            }

        })



        /*ccconfig绑定监听*/


        function bindWatchOnccConfig() {
            var componentPropsData = ccConfigVM.componentProps.$model
            console.info('binding.............' + componentPropsData)
            console.info(componentPropsData)

            for (var key in componentPropsData) {

                console.info('binding.............' + key)

                if (componentPropsData[key] instanceof Object) { //进入子循环

                    for (var sk in componentPropsData[key]) {



                        (function(key, sk) {

                            console.log(componentPropsData[key][sk].ischecked)

                            ccConfigVM.componentProps[key][sk].$watch('ischecked', function(val) {

                                editorVm.curPage.comInsList[editorVm.selectedIndex][key][sk].ischecked = val

                                console.log(editorVm.curPage.comInsList[editorVm.selectedIndex][key][sk].ischecked)
                                    // saveAllPageData()

                            })

                        })(key, sk)

                    }



                } else {

                    (function(key) {

                        ccConfigVM.componentProps.$watch(key, function(val, old) {


                            if(val ==old){
                                return
                            }else{
                             console.log('监听到值变化:' + key + ':' + val)
                            avalon.vmodels.editor.curPage.comInsList[editorVm.selectedIndex][key] = val
                            saveAllPageData()
                            }

                       
                        })

                    })(key)

                }

            }

        }






        //监听到拖拽和resize 、点击元素  。更新面板

        //效率太低 需要优化！！

        ccConfigVM.$watch("comPropsToPanel", function(data) {

            console.info('comPropsToPanel..........')
            var elindex = editorVm.selectedIndex
            curComponentData = avalon.mix({}, editorVm.curPage.$model.comInsList[elindex], data)

            for (var key in curComponentData) {

                if(ccConfigVM.componentProps[key]!==curComponentData[key]){
                  ccConfigVM.componentProps[key] = curComponentData[key]

                }
            }



        })

        //滑块位置通过监听数据更新 ,滑块初始化完成后才有VM，暂时延时2秒绑定.
        window.setTimeout(function() {
            avalon.vmodels.sliderOpacity.$watch("comPropsRefresh", function(data) {
                avalon.vmodels.sliderOpacity.percent = data.opacity
            })
        }, 2000)


        bindWatchOnccConfig()

        avalon.scan(document.body)

        //为基本设置 赋值 ，值为接口返回已保存的数据
        if (pageConfigData !== null) {
            mainConfigVM.isActive = pageConfigData.isActive,
                mainConfigVM.hasMusic = pageConfigData.hasMusic,
                mainConfigVM.musicUrl = pageConfigData.musicUrl,
                mainConfigVM.scrollDirection = pageConfigData.scrollDirection, //滑屏方向 vertical  hor
                mainConfigVM.scrollEffect = pageConfigData.scrollEffect, //滑屏特效
                mainConfigVM.arrowStyle = pageConfigData.arrowStyle, //箭头样式
                mainConfigVM.isLoop = pageConfigData.isLoop
        }

        $('#pageTree li').eq(0).trigger('click')



        require(['css!vendor/upload/dropzone.css', 'dropzone'], function(css, Dropzone) {



            /* <!--------上传音乐组件区------>*/
            var myDropzone = new Dropzone("#musicUploader", {
                url: "/lettermaterial/upload.json?type=music"
            });
            myDropzone.on("addedfile", function(file) {
                /* Maybe display some more file information on your page */
                console.log(file)
                if (file.type.indexOf('audio') < 0) {
                    notify.log('音乐格式不正确！')
                    myDropzone.removeFile(file)

                    return
                }
                if (file.size > 5242880) {
                    notify.log('音乐不能大于5M')
                    myDropzone.removeFile(file)
                    return

                }
            });

            myDropzone.on("complete", function(file) {
                myDropzone.removeFile(file)
            })


            myDropzone.on('success', function(a, res) {

                if (typeof res === 'string') {
                    res = $.parseJSON(res)
                }

                if (res.status == 0) {
                    mainConfigVM.musicUrl = res.data
                } else {
                    notify.log('上传失败！')
                }


            })

            /*  <!--------../上传音乐组件区------> */

            /*  <!--------上传背景图片------> */


            var bgImageUploader = new Dropzone("#bgImageUploader", {
                maxFiles: 1000,
                url: "/lettermaterial/upload.json?type=image",
                previewTemplate: $('#tplForUploadImage').html(),
                clickable: ".fileclickable",
                thumbnailWidth: 250,
                thumbnailHeight: 350,

            });
            bgImageUploader.on("addedfile", function(file) {


                /* Maybe display some more file information on your page */

            });

            bgImageUploader.on("maxfilesexceeded", function(file) {
                this.removeFile(file);
            });


            bgImageUploader.on("error", function(file) {
                notify.log('请先删除再上传')
            });



            bgImageUploader.on('success', function(file, res) {

                if (typeof res === 'string') {
                    res = $.parseJSON(res)
                }

                console.log('背景图片上传成功！')

                this.removeFile(file);

                var _this = this
             

              


                if (res.error == 0) {
                    console.log(" pageConfigVM.pagebgImage=" + pageConfigVM.pagebgImage)
                    pageConfigVM.pagebgImage = 'http://img.eventown.cn/' + res.data
                }

                console.log(pageConfigVM.pagebgImage)


                $('#Jadd-bj-btn').text('上传')


            })
             var rm = $('#del')
              rm.off().on("click", function(e) {
                    e.preventDefault()
                    bgImageUploader.removeAllFiles()
                    pageConfigVM.pagebgImage = ''

                });

            /*  <!--------../上传背景图片------> */


            /*   <!--------插入图片 上传组件------> */


            var insertImage = new Dropzone("#insertImageUploader", {
                url: "/lettermaterial/upload.json?type=image",
                clickable: "#insertImage-btn",
                previewTemplate: $('#tplForUploadImage').html(),

            });
            insertImage.on("addedfile", function(file) {
                console.log(file.type)
            });



            insertImage.on('success', function(file, res) {
                this.removeFile(file)

                if (res.error == 0) {
                    ccConfigVM.componentProps.imageUrl = 'http://img.eventown.cn/' + res.data
                        // editorVm.$fire('all!comPropsRefresh', avalon.mix(true, {}, editorVm.$model.curPage))
                }


                $('#insertImage-btn').text('上传')


            })



        })



    })

//工具函数
    function isHexColorValid(val){
        //正则匹配十六进制颜色表示
        var reg = /#[0-9,a-f]{6}$/i;
        return reg.test(val);
    }



})
