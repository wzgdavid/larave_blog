$(function(){
    $('.btn_delete_img').click(function(){
               
        var url = "/delete_img";
        var img_id = $(this).attr('alt');
                  
        $the_btn = $(this);
        $.get( url, { imgid:img_id } )
        .done(function( data ) {
                     
            $tr = $the_btn.parent().parent().remove();

        });


    });
    
    /*
    $('#temp').click(function(){
        alert($('#img-input').val());
    });*/
    $('#btn-upload').click(function(){
                
                var filename = $('#img-input').val();
                

                if($('#img-input').val() == "" ){
                    $('#red-sign').remove();
                    $required = "<strong id='red-sign' style='color:red'> need to choose a picture</strong>"
                    $('#img-input').parent().append($required);
                    return false;
                }else {
                    ext = filename.split('.')[1].toUpperCase();
                    /*if(ext=='GIF' || ext=='JPG' || ext== 'JPEG' || ext=='PNG'){

                    }else{
                      $('#red-sign').remove();
                      $required = "<strong id='red-sign' style='color:red'> need to choose a gif,jpg,jpeg or png</strong>"
                      $('#img-input').parent().append($required);
                      return false;
                    }*/
                    if(ext!='GIF' && ext!='JPG' && ext!= 'JPEG' && ext!='PNG'){
                      $('#red-sign').remove();
                      $required = "<strong id='red-sign' style='color:red'> need to choose a gif,jpg,jpeg or png</strong>"
                      $('#img-input').parent().append($required);
                      return false;
                    
                    }

                }
                
    });
});