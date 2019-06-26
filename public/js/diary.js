$(document).on('click', '.js-like', function() {
    let diaryId = $(this).siblings('.diary-id').val();

    let $clickedBtn = $(this);

    like(diaryId, $clickedBtn);
})

function like(diaryId, $clickedBtn) {
    $.ajax({
        url: 'diary/' + diaryId +'/like', 
        type: 'POST', 
        dataTyupe: 'json',
        // LaravelではCSRF対策として、tokenを送信しないとエラーが発生します。
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .then(
        function (data) {
            changeLikeBtn($clickedBtn);
            
            // いいね数を1増やす
            let num = Number($clickedBtn.siblings('.js-like-num').text());
            $clickedBtn.siblings('.js-like-num').text(num + 1);
        },
        function () {
            console.log(error);
        }
    )
}

// いいね, いいね解除でボタンの色を変更、
// js-like, js-dislikeでいいね, いいね解除の切り替えをしてるためクラスの付け替え
function changeLikeBtn(btn) {
    btn.toggleClass('far').toggleClass('fas');
    btn.toggleClass('js-like').toggleClass('js-dislike');
}

$(document).on('click', '.js-dislike', function() {
  let diaryId = $(this).siblings('.diary-id').val();

  let $clickedBtn = $(this);

  dislike(diaryId, $clickedBtn);
})


// いいね解除処理
function dislike(diaryId, $clickedBtn) {
  $.ajax({
      url: 'diary/' + diaryId +'/dislike',
      type: 'POST',
      dataTyupe: 'json',
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  })
  .then(
      function (data) {
          changeLikeBtn($clickedBtn);

          // いいね数を1減らす
          let num = Number($clickedBtn.siblings('.js-like-num').text());
          $clickedBtn.siblings('.js-like-num').text(num - 1);
      },
      function () {
          console.log(error);
      }
  )
}

window.onload = function() {
  (function() {
    var print_img_id = 'print_img';
    if (checkFileApi()) {
      var file_image = document.getElementById('image');
      file_image.addEventListener('change', selectReadfile, false);
    }
    function checkFileApi() {
      if (window.File && window.FileReader && window.FileList && window.Blob) {
        return true;
      }
      alert('このブラウザはFile APIに対応していないため利用できません');
      return false;
    }
    function selectReadfile(e) {
      var file = e.target.files;
      var reader = new FileReader();
      reader.readAsDataURL(file[0]);
      reader.onload = function() {
        readImage(reader, print_img_id);
      }
    }
    function readImage(reader, print_image_id) {
      var result_DataURL = reader.result;
      var img = document.getElementById(print_image_id);
      var src = document.createAttribute('src');
      src.value = result_DataURL;
      img.setAttributeNode(src);
    }
  })();
}
