/*
全局配置文件
*/

define(function() {


    var CONFIG = CONFIG || {};
    CONFIG.pageEffects = [{
        name: "无效果",
        animationName: "noeffect"
    }, {
        name: "淡入",
        animationName: "fadeInNormal"
    }, {
        name: "弹性放大",
        animationName: "fadeIn"
    }, {
        name: "弹性缩小",
        animationName: "expandOpen"
    }, {
        name: "放大",
        animationName: "zoomIn"
    }, {
        name: "下落放大",
        animationName: "zoomInDown"
    }, {
        name: "从左滚入",
        animationName: "rotateInDownLeft"
    }, {
        name: "从右滚入",
        animationName: "rotateInDownRight"
    }, {
        name: "向右飞入",
        animationName: "moveRight"
    }, {
        name: "向左飞入",
        animationName: "moveLeft"
    }, {
        name: "向上飞入",
        animationName: "moveUp"
    }, {
        name: "向下飞入",
        animationName: "moveDown"
    }, {
        name: "向右滑入",
        animationName: "slideRight"
    }, {
        name: "向左滑入",
        animationName: "slideLeft"
    }, {
        name: "向上滑入",
        animationName: "slideUp"
    }, {
        name: "向下滑入",
        animationName: "slideDown"
    }, {
        name: "刹车",
        animationName: "lightSpeedIn"
    }, {
        name: "左右翻转",
        animationName: "flipInY"
    }, {
        name: "上下翻转",
        animationName: "flipInX"
    }, {
        name: "旋转出现",
        animationName: "rotateIn"
    }, {
        name: "向右展开",
        animationName: "stretchRight"
    }, {
        name: "向左展开",
        animationName: "stretchLeft"
    }, {
        name: "向上展开",
        animationName: "pullUp"
    }, {
        name: "向下展开",
        animationName: "pullDown"
    }]

    CONFIG.effectArr = [{
        name: "无效果",
        "animationName": "noeffect"
    }, {
        name: "淡入",
        "animationName": "fadeInNormal"
    }, {
        name: "弹性放大",
        "animationName": "fadeIn"
    }, {
        name: "弹性缩小",
        "animationName": "expandOpen"
    }, {
        name: "放大",
        "animationName": "zoomIn"
    }, {
        name: "下落放大",
        "animationName": "zoomInDown"
    }, {
        name: "从左滚入",
        "animationName": "rotateInDownLeft"
    }, {
        name: "从右滚入",
        "animationName": "rotateInDownRight"
    }, {
        name: "向右飞入",
        "animationName": "moveRight"
    }, {
        name: "向左飞入",
        "animationName": "moveLeft"
    }, {
        name: "向上飞入",
        "animationName": "moveUp"
    }, {
        name: "向下飞入",
        "animationName": "moveDown"
    }, {
        name: "向右滑入",
        "animationName": "slideRight"
    }, {
        name: "向左滑入",
        "animationName": "slideLeft"
    }, {
        name: "向上滑入",
        "animationName": "slideUp"
    }, {
        name: "向下滑入",
        "animationName": "slideDown"
    }, {
        name: "刹车",
        "animationName": "lightSpeedIn"
    }, {
        name: "左右翻转",
        "animationName": "flipInY"
    }, {
        name: "上下翻转",
        "animationName": "flipInX"
    }, {
        name: "旋转出现",
        "animationName": "rotateIn"
    }, {
        name: "向右展开",
        "animationName": "stretchRight"
    }, {
        name: "向左展开",
        "animationName": "stretchLeft"
    }, {
        name: "向上展开",
        "animationName": "pullUp"
    }, {
        name: "向下展开",
        "animationName": "pullDown"
    }]

    CONFIG.pageData = {
        title: '名称',
        discrib: '描述',
        globleConfig: {
            scrollDirection: 'vertical', //滑屏方向 vertical  hor
            scrollEffect: '', //滑屏特效
            arrowStyle: '', //箭头样式
            isLoop: 'true',
            bgSound: 'url',
            backgrundImage: ''
        },

        pageItem: [ ]

    }

    CONFIG.formdDataTemplate={
                    type: 'form',
                    width: '300',
                    height: '',
                    left: '80',
                    top: '20',
                    textAlign: 'center',
                    backgroundColor: '',
                    lineHeight:'1.5',
                    fontColor:'#333333',
                    opacity: 100,
                    fontSize:'28',
                    borderStyle: 'none',
                    borderColor: 'none',
                    borderWidth: '0',
                    borderRadius: '0',
                    animationName: 'zoomIn',
                    animationDuration: '1',
                    animationDelay: '0',
                    animationIterationCount: 1,
                    formElment: [{
                        name:'name',
                        label: '姓名',
                        type: "text",
                        disabled:'disabled',
                        display:'block',
                        ischecked:true
                    },
                           {
                        name:'phone',
                        label: '手机',
                        type: "text",
                        disabled:'disabled',
                        ischecked:true

                    },
                      
                     {  name:'email',
                        label: '邮箱',
                        type: "text",
                        ischecked:true
                    },
                    {   name:'sex',
                        label: '性别',
                        type:"radio",
                        radioname:'sex',
                        text1:'男',
                        text2:'女',
                        ischecked:true
                    },
                       
                    {   name:'company',
                        label: '公司',
                        type: "text",
                        ischecked:true
                    },
                    {   name:'position',
                        label: '职位',
                        type: "text",
                        ischecked:true
                    } ,
                    {   name:'address',
                        label: '地址',
                        type: "text",
                        ischecked:true
                    } 
                    

                ]

            }


    return config = CONFIG
})






// function pageTree(){

// }

// pageTree.prototype={

//  init:function(){},
//  add:function(){

//  },
//  getTreeData:function(){

//  }
//  // body...
// };
