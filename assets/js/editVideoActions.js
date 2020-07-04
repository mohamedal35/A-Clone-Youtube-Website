function setThumbnail(thumbnailId, videoId, clickedTumbnail) {
    let xhr     = new XMLHttpRequest();
    let params  = "thumbnailId="+thumbnailId+"&videoId="+videoId;

    xhr.open("POST", "ajax/setThumbnail.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload  = () => {
        $(clickedTumbnail).siblings().removeClass("selected");
        $(clickedTumbnail).addClass("selected");
        alert("Thumbnail Updated");
    }
    xhr.send(params);
}