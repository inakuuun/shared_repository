$(function(){
  /*
  
     //ログイン画面：モーダル
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

      //必須項目入力しないと押せないボタン(新規登録)
      let $submit = $('#js-signupBtn');
      $('#js-signup input').on('change', function(){
        if(
          $('#js-signup input[name="name"]').val() !== "" &&
          $('#js-signup input[name="email"]').val() !== "" &&
          $('#js-signup input[name="password"]').val() !== "" &&
          $('#js-signup input[name="password2"]').val() !== "" 
        ){
          $submit.prop('disabled', false);
        } else {
          $submit.prop('disabled', true);
        }
      });

      //変更しないと押せないボタン(マイページ編集)
      let $edit = $('#js-editBtn');
      $('#js-edit input').on('change', function(){
        if( $('#js-edit input[name="name"]').val() !== "") {
          $edit.prop('disabled', false);
        } else {
          $edit.prop('disabled', true);
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
