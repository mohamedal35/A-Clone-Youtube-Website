function postComment(btn, postedBy, videoId, replyTo, containerClass) {
    var textarea    = $(btn).siblings("textarea");
    var commentText = $(textarea).val();
    $(textarea).val("");
    if (commentText) {
        var xhr         = new XMLHttpRequest();
        var params      = "postedBy="+postedBy+"&videoId="+videoId+"&replyTo="+replyTo+"&commentText="+commentText;
        xhr.open("POST", "ajax/postComment.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            var comment = this.responseText;
            if (!replyTo) {
                $("."+containerClass).prepend(comment);
            } else {
                $(btn).parent().siblings("."+containerClass).append(comment);
            }
        }
        xhr.send(params);

    }else {
        alert("Can't Post Empty Comment");
    }
}
function toggleReply(element) {
    $(element).parent().next().toggleClass("hide")
}
function toggleReplyForm(btn) {
    $(btn).parent().toggleClass("hide");
}
function likeComment(commentId, button, videoId) {
    let xhr     = new XMLHttpRequest();
    let id      = videoId;
    let params  = "commentId="+commentId+"&videoId="+id;

    xhr.open('POST', 'ajax/likeComment.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function() {

        var likeBtn     = button;
        var dislikeBtn  = $(likeBtn).siblings(".dislikeCommentBtn");



        let data        = JSON.parse(this.responseText);

        updateCountVal(likeBtn, data.likes, data.likeImg, "like");
        updateCountVal(dislikeBtn, 0, data.dislikeImg);
    };

    xhr.send(params);

}
function dislikeComment(commentId, button, videoId) {
    let xhr     = new XMLHttpRequest();
    let id      = videoId;
    let params  = "commentId="+commentId+"&videoId="+id;

    xhr.open('POST', 'ajax/dislikeComment.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function() {

        var dislikeBtn     = button;
        var likeBtn        = $(dislikeBtn).siblings(".likeCommentBtn");



        let data        = JSON.parse(this.responseText);

        updateCountVal(likeBtn, data.likes, data.likeImg, "like");
        updateCountVal(dislikeBtn, 0, data.dislikeImg);

    };

    xhr.send(params);

}
function updateCountVal(element, num, img, type="dislike") {
    if ($(element).prev(".likesCount").text() == "") {
        var likesCountVal   = 0;
    } else {
        var likesCountVal   = parseInt($(element).prev(".likesCount").text());
    }
    var x  = likesCountVal + (num);
    if (type === "like") {
        $(element).prevAll(".likesCount").first().html((x == 0) ? "" : x);
    }
    $(element).children("img").first().attr("src", img);
}
function getReplies(commentId, btn, videoId) {
    var xhr         = new XMLHttpRequest();
    var params      = "commentId="+commentId+"&videoId="+videoId;
    xhr.open("POST", "ajax/getReplies.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        var replySec    = $("<div></div>").addClass("repliesSection");
        replySec.append(this.responseText);
        $(btn).replaceWith(replySec);
    }

    xhr.send(params);
}
