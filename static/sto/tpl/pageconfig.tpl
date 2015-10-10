<div class="panel setting-box" ms-controller="pageConfig" ms-visible="isActive">
     <h1>页面设置</h1>

  <div class="group" class="toScrollbar">
    <h4>背景图片</h4>
<img ms-src="pagebgImage" alt="" width="95%" ms-visible="pagebgImage!==''">


<form action="/lettermaterial/upload.json?type=music"  id="bgImageUploader" style="padding:15px 0;" >
            <span class="btn-blue01 fileclickable" id="Jadd-bj-btn">
          上传
        </span>
          <span class="btn-blue01" id="del" ms-visible="pagebgImage!==''" >
          删除
        </span>
 </form>

<hr>
    <h4>背景颜色</h4>
     <div class="input-style">
      <input type="text" ms-duplex="pagebgColor" class="colorpicker" ms-widget="colorpicker">
    </div>
     
  

  </div>

</div>
