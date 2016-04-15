$(function(){
    //上传图片相关

    $('.upload-mask').on('click',function(){
        $(this).hide();
        $('.upload-file').hide();
    })

    $('.upload-file .close').on('click',function(){
        $('.upload-mask').hide();
        $('.upload-file').hide();
    })

    var imgSrc = $('.pic-upload').next().attr('src');
    console.log(imgSrc);
    if(imgSrc == ''){
        $('.pic-upload').next().css('display','none');
    }
    $('.pic-upload').on('click',function(){
        $('.upload-mask').show();
        $('.upload-file').show();
        console.log($(this).next().attr('id'));
        var imgID = $(this).next().attr('id');
        $('#imgID').attr('value',imgID);
    })

    //ajax 上传
    $(document).ready(function() {
        var options = {
            beforeSubmit:  showRequest,
            success:       showResponse,
            dataType: 'json'
        };
        $('#imgForm input[name=file]').on('change', function(){
            //$('#upload-avatar').html('正在上传...');
            $('#imgForm').ajaxForm(options).submit();
        });
    });

    function showRequest() {
        $("#validation-errors").hide().empty();
        $("#output").css('display','none');
        return true;
    }

    function showResponse(response)  {
        if(response.success == false)
        {
            var responseErrors = response.errors;
            $.each(responseErrors, function(index, value)
            {
                if (value.length != 0)
                {
                    $("#validation-errors").append('<div class="alert alert-error"><strong>'+ value +'</strong><div>');
                }
            });
            $("#validation-errors").show();
        } else {

            $('.upload-mask').hide();
            $('.upload-file').hide();
            $('.pic-upload').next().css('display','block');

            console.log(response.pic);

            $("#"+response.id).attr('src',response.pic);
            $("#"+response.id).next().attr('value',response.pic);
        }
    }

})