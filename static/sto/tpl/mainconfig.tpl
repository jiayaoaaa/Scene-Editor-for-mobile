<div class="panel setting-box" ms-controller="mainConfig" ms-visible="isActive" >
    <h1>基本设置</h1>

    <div class="group">

    <h4>滑屏方向</h4>
    <div class="padding5">
        <label>
            <input  ms-duplex-string="scrollDirection" type="radio" name="pagescroll" value="vertical" checked/>上下滑屏</label>
        <label>
            <input ms-duplex-string="scrollDirection" type="radio" name="pagescroll" value="horizontal"/>左右滑屏 </label>
    </div>
    <hr>
    <h4>滑屏特效</h4>
    <ul class="padding5">
           <li> 
            <label><input ms-duplex-string="scrollEffect" type="radio"  value="slide" checked>滑入</label>
        </li>

        <li>
            <label><input  ms-duplex-string="scrollEffect" type="radio"  value="fade" >淡入 </label>
       
        </li>

     

             <li> 
            <label><input ms-duplex-string="scrollEffect" type="radio"  value="cube">立方体</label>
        </li>
    </ul>
    <hr>
    <h4>箭头样式</h4>

    <ul class="padding5">
        <li>
          <label>
            <input  ms-duplex-string="arrowStyle" type="radio" name="arrowStyle" value=""  checked />无</label>
        <label>
            <input  ms-duplex-string="arrowStyle" type="radio" name="arrowStyle" value="01"  />样式一 
                   <img src="../img/arrow01.png" alt="" height="20" style="background:#ccc">

        </label>
        <label>
            <input ms-duplex-string="arrowStyle" type="radio" name="arrowStyle" value="02" />样式二 
                   <img src="../img/arrow02.png" alt="" height="20" style="background:#ccc"></label>

        </li>


    </ul>
    <hr>
    <h4>循环显示</h4>
    <div class="padding5">
        <label>
            <input checked class="form-control" type="radio" name="loop" ms-duplex-checked="isLoop">是</label>
        <label>
            <input class="form-control" type="radio" name="loop" ms-duplex-checked="!isLoop">否 </label>
    </div>
    <hr>
    <div class="padding5"><input type="checkbox" name="musicCtrl" ms-duplex-checked="hasMusic">开启背景音乐</div>
    
<div ms-visible="hasMusic">
    <div class="col-lg-12">  （请上传5M以内 mp3、wav格式文件）
        <input type="text" class="input-line"  name="musicUrl" ms-duplex-string="musicUrl" placeholder="请上传音乐或输入音乐地址"> 
    </div>
     <br>
    <div class="col-lg-12">
         <form action="/lettermaterial/upload.json?type=music" id="musicUploader">
             <div class="dz-message btn-blue01" href="#">上传音乐</div>
       </form>
    </div>

</div>
  
</div>
  
</div>
