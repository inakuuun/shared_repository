$(function(){
  /*
  
    //ドロワーメニュー
    $(".js-drawerIcon").on("click",function(e){
      e.preventDefault();
      $(".p-drawerIcon").toggleClass("is-active");
      $(".p-drawerBack").toggleClass("is-active");
      $(".p-drawer__menu").toggleClass("is-active");
        return false;
    });
    
      //ヘッダーナビゲーション
      $('.js-nav').click(function() {
        $(this).removeClass('is-action');
        $(this).addClass('is-action');
        return false;
      });

      */
     /*//ログイン画面：モーダル
      $('.js-open').click(function(e){
        e.preventDefault();
        $('.js-login').addClass('is-open');
        $('body').css('overflow-y', 'hidden');  // 本文の縦スクロールを無効
        return false;
      });

      $('.js-close').click(function(e){
        e.preventDefault();
        $('.js-login').removeClass('is-open');
        $('body').css('overflow-y','auto');
        return false;
      });*/

      //必須項目入力しないと押せないボタン
      let $submit = $('#js-submit');
      $('#js-form input').on('change', function(){
        if(
          $('#js-form input[name="name"]').val() !== "" &&
          $('#js-form input[name="email"]').val() !== "" &&
          $('#js-form input[name="password"]').val() !== "" &&
          $('#js-form input[name="password2"]').val() !== "" 
        ){
          $submit.prop('disabled', false)
        } else {
          $submit.prop('disabled', true)
        }
      });


      // パスワードの表示・非表示切替
    /*
      $('#js-password').click(function(){
        let input = $(this).parent().prev("input");

        if ($(this).hasClass('fa-eye-slash') == true) {
          $(this).removeClass('fa-eye-slash');
          $(this).addClass('fa-eye');
          input.attr('type', 'text');
        } else {
          $(this).removeClass('fa-eye');
          $(this).addClass('fa-eye-slash');
          input.attr('type', 'password');
        }
      });
      */
  });
