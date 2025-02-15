<?php
class Content {
   function Content() {
   }
   function PrintContent($content) {
       $baseurl =BASEURL;
       $r='<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12" style="padding: 0;">
            <div style="width: 100%, height:5px; background-color: #2780CD;position: relative;overflow: hidden;font-size: 2px;">&nbsp;</div>
        </div>
        <div class="col-6 col-md-2"></div>
     
        <div class="col-12">'.Header::menu().'</div>
            <div class="col-12" style="background-color: #f7f7f7;border: 1px solid #eeeeee;"><h3 style="padding:0;color:#082F60;margin:5px 0;"><i class="fas fa-angle-double-right"></i>&nbsp;'.$content["title"].'</h3></div>
               <div class="col-12 ">
            <hr>
        </div>
        <div class="col-12" style="background-color: #fff;border-top: 0px solid #dee2e6; */"> '.$content["content"].' </div>
                   <div class="col-12 ">
            <hr>
        </div>
    </div>
</div>';


    $r = '<div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                    '.$content["content"].'
                    </div>
                </div>
            </div>
        </div>
    </div>';
      echo $r;
   }
}
?>