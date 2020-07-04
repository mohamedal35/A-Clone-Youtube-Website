function likeVideo(button, videoId) {
        let xhr     = new XMLHttpRequest();
        let id      = videoId;
        let params  = "videoId=" + id;

        xhr.open('POST', 'ajax/likeVideo.php', true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function() {

            var likeBtn     = button;
            var dislikeBtn  = document.querySelector(".dislikeBtn");


            let data        = JSON.parse(this.responseText);

            updateLikesValue(likeBtn.getElementsByClassName('text')[0], data.likes, data.likeImg);
            updateLikesValue(dislikeBtn.getElementsByClassName('text')[0], data.dislikes, data.dislikeImg);
        };

        xhr.send(params);

}

function dislikeVideo(button, videoId) {
    let xhr     = new XMLHttpRequest();
    let id      = videoId;
    let params  = "videoId=" + id;

    xhr.open('POST', 'ajax/dislikeVideo.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function() {

        var dislikeBtn              = button;
        var likeBtn                 = document.querySelector(".likeBtn");


        let data        = JSON.parse(this.responseText);

        updateLikesValue(likeBtn.getElementsByClassName('text')[0], data.likes, data.likeImg);
        updateLikesValue(dislikeBtn.getElementsByClassName('text')[0], data.dislikes, data.dislikeImg);
    };

    xhr.send(params);

}

function updateLikesValue(button, num, img) {
    // var likesCountVal   = button.textContent || 0;
    var x  = parseInt(button.innerText) + (num);
    button.innerText    = x;
    $(button).siblings("img").attr("src", "assets/images/icons/" + img);
}