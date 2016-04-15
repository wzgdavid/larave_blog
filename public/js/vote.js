$(function(){
              $('.btn_vote').click(function(){
                   
                  //var $origin_votes = $(this).parent().next();
                  //var num = parseInt($origin_votes.html());
                  //$origin_votes.html(num+1);
                  var url = "/vote_img";
                  var img_id = $(this).parent().siblings('img').attr('id');
                  $the_btn = $(this);
                  $.get( url, { imgid:img_id } )
                      .done(function( data ) {

                          var $origin_votes = $the_btn.parent().next();
                          var num = parseInt(data.votes) + 1;
                          //alert(data.imgid);
                          $origin_votes.html(num);
                  });


              });

          });