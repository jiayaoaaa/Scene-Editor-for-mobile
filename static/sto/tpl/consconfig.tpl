<div class="panel text-box" ms-controller="ccConfig" ms-visible="isActive">
      <h1>文字设置</h1>

  <div class="group" ms-visible="componentProps.type=='text'">
    <div >
      <textarea  class="text-area" type="text" placeholder="亲，在这里输入文本哦" ms-duplex-string="componentProps.textcontent" ></textarea>

    </div>
    <div class="font-area" role="group" aria-label="...">
      <select name="" id="" ms-duplex="componentProps.fontSize" >
        <option value="">字号</option>
        <option value="18">18</option>
        <option value="20">20</option>
        <option value="22">22</option>
        <option value="26">26</option>
        <option value="28">28</option>
        <option value="30">30</option>
        <option value="32">32</option>
        <option value="34">34</option>
        <option value="36">36</option>
        <option value="38">38</option>
        <option value="40">40</option>
        <option value="42">42</option>
        <option value="44">44</option>
        <option value="46">46</option>
        <option value="48">48</option>
        <option value="50">50</option>
        <option value="52">52</option>
        <option value="54">54</option>
        <option value="56">56</option>
        <option value="58">58</option>
        <option value="60">60</option>
        <option value="72">72</option>
        <option value="96">96</option>
        <option value="100">100</option>
        <option value="200">200</option>
        <option value="300">300</option>
        <option value="400">400</option>
        <option value="500">500</option>
      </select>
      <select name="" id="" ms-duplex="componentProps.lineHeight" 
>
        <option value="">间距</option>
        <option value="1">1.0</option>
        <option value="1.15">1.15</option>
        <option  value="1.5">1.5</option>
        <option  value="1.8">1.8</option>
        <option value="2">2.0</option>
        <option value="2.5">2.5</option>
        <option value="3">3.0</option>
        <option value="3.5">3.5</option>
        <option value="4">4.0</option>
        <option value="4.5">4.5</option>
        <option value="5">5.0</option>
      </select>
      <select name="" id="" ms-duplex="componentProps.textAlign" 
>
        <option value="">对齐</option>
        <option value="left">左对齐</option>
        <option value="right">右对齐</option>
        <option value="center">居中对齐</option>
      </select>
    </div>
    <hr>
    <h4> 文字颜色</h4>
    <div class="input-style">
      <input type="text" ms-duplex="componentProps.fontColor" ms-widget="colorpicker" >
    </div>
  </div>


   <!--如果是图片-->
  <div class="group" ms-visible="componentProps.type=='image'"> 
        <h1>图片设置</h1>

    <img ms-attr-src="componentProps.imageUrl"  alt="" width="99%">
    <br><br>
    <form   id="insertImageUploader" >
      <span class="btn-blue01" id="insertImage-btn"> 上传 </span>
    </form>
  </div>
  <!--如果是图片END--> 
  
  <!--如果是表单-->
  
  <div class="group" ms-visible="componentProps.type=='form'"> 
  <h1>表单设置</h1>
    <ul class="form-list">
      <li ms-repeat-f="componentProps.formElment">
        <input type="checkbox" ms-duplex-checked="f.ischecked" name="formcheck" ms-attr-disabled="f.disabled"   ms-attr-value="{{$index}}" >
        <input disabled="disabled" type="text" ms-attr-placeholder="{{f.label}}">
        必填 </li>
    </ul>
  </div>
  <hr>
  <!--../如果是表单-->




  <ul class="panel-tab">
    <li ms-click="tab(0)" ms-class-on="toggle==0">
       样式 

  </li><li ms-click="tab(1)" ms-class-on="toggle==1">动画</li></ul>




  <div class="text-set" ms-visible="toggle==0">

  
  <div class="group">
    <h4>大小</h4>
    <div class="input-style">
      宽 <input type="text" placeholder="宽度" ms-duplex="componentProps.width" >  
      高 <input type="text" placeholder="自动高度" ms-duplex="componentProps.height" >
    </div>
  </div>
  <hr>
  <div class="group">
    <h4>位置</h4>
    <div class="input-style">
      X轴 <input type="text" placeholder="X坐标" ms-duplex="componentProps.left" >  
      Y轴 <input type="text" placeholder="Y坐标" ms-duplex="componentProps.top" >
    </div>
  </div>
  <hr>
  <div class="group">
    <h4>背景</h4>
    <div class="input-style">
      <input type="text" placeholder="背景颜色" ms-widget="colorpicker" ms-duplex="componentProps.backgroundColor">
    </div>
  </div>
  <!--                     <div class="group">
                        <h4>边框</h4>
                        <div class="width-50">
                            <input type="text" placeholder="边框大小" ms-duplex="componentProps.borderSize">
                        </div>
                        <div class="width-50">
                            <input type="text" placeholder="边框颜色" ms-duplex="componentProps.borderColor"  ms-widget="colorpicker">
                        </div>
                    </div>
                     -->
  <div class="group">
    <h4>透明度</h4>
    <div class="input-style">
      <div class="w-70">
              <div ms-widget="slider, sliderOpacity,$opt" data-slider-range="min" data-slider-value="100"></div>

      </div>
   <div class="w-5">&nbsp; </div>
      <div class="w-25" style="margin-top:-5px">

           <div ms-controller="sliderOpacity">
        <input ms-duplex="componentProps.opacity" type="text" ms-attr-value="{{value}}"> %
      </div>
        
      </div>
   
    </div>
  </div>







  </div>
  <div class="anim-set" ms-visible="toggle==1">
    

 <!--动画-->
  <div class="group">
    <h4>动画</h4>
    <div class="input-style">
      <ul class="effect-list fix">
        <li ms-repeat="animLib" ms-class="on:el.animationName==componentProps.animationName" ms-click="setAnimate(el.animationName,$index)">
          <i></i>
          <div  ms-attr-value="{{el.animationName}}">{{el.name}} </div>
        </li>
      </ul>
    </div>
  </div>
  <!--动画-->
  <hr>
  <div class="group">
    <h4>开始时间</h4>
    <div class="input-style">
            <div class="w-70">

      <input ms-widget="slider,sss" data-slider-min="0" data-slider-max="10" data-slider-value="0" data-slider-step="0.1" >
    </div>
    <div class="w-5">&nbsp;</div>
          <div class="w-25" style="margin-top:-5px">

      <p ms-controller="sss">
        <input ms-duplex="componentProps.animationDelay"  type="text" ms-attr-value="{{value}}"> 秒</p>
      </div>
    </div>
  </div>
  <hr>
  <div class="group">
    <h4>持续时间</h4>
    <div class="input-style">
            <div class="w-70">

      <input ms-widget="slider,ddd"   data-slider-min="0.1" data-slider-max="10" data-slider-value="0" data-slider-step="0.1">
    </div>
    <div class="w-5">&nbsp;</div>

              <div class="w-25" style="margin-top:-5px">

      <p ms-controller="ddd">
        <input ms-duplex="componentProps.animationDuration"  type="text" ms-attr-value="{{value}}"> 秒 </p>
    </div>    </div>

  </div>
  <hr>
  <div class="group">
    <h4>执行次数</h4>
    <div class="input-style">
      <select name="" id="" ms-duplex="componentProps.animationIterationCount">
        <option value="1">一次</option>
        <option value="2">二次</option>
        <option value="3">三次</option>
        <option value="infinite">无限循环</option>
      </select>
    </div>
  </div>



  </div>





 

</div>
