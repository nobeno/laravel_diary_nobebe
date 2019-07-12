$(document).on('click', '.js-follow', function() {
    let userId = $(this).siblings('.user-id').val();

    let $clickedBtn = $(this);

    follow(userId, $clickedBtn);
})

function follow(userId, $clickedBtn) {
    $.ajax({
        url: 'profile/' + userId +'/follow', 
        type: 'POST', 
        dataTyupe: 'json',
        // LaravelではCSRF対策として、tokenを送信しないとエラーが発生します。
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .then(
        function (data) {
            changeFollowBtn($clickedBtn);
            $('.textChange-' + userId ).text("フォロー中");
        },
        function () {
            console.log(error);
        }
    )
}

// いいね, いいね解除でボタンの色を変更、
// js-like, js-dislikeでいいね, いいね解除の切り替えをしてるためクラスの付け替え
function changeFollowBtn(btn) {
    btn.toggleClass('js-follow').toggleClass('js-unfollow');
    btn.toggleClass('btn-primary').toggleClass('btn-outline-primary');
}

$(document).on('click', '.js-unfollow', function() {
  let userId = $(this).siblings('.user-id').val();

  let $clickedBtn = $(this);

  unfollow(userId, $clickedBtn);
})


// いいね解除処理
function unfollow(userId, $clickedBtn) {
  $.ajax({
      url: 'profile/' + userId +'/unfollow',
      type: 'POST',
      dataTyupe: 'json',
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  })
  .then(
      function (data) {
          changeFollowBtn($clickedBtn);
          $('.textChange-' + userId ).text("フォロー");
      },
      function () {
          console.log(error);
      }
  )
}
