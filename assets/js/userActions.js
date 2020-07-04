function subscribe(userTo, userFrom, btn) {
        if (userTo === userFrom) {      
                alert("You can't subscribe to yourself");
                return;      
        }       
        fetch("ajax/subscribe.php", {
                method: "POST",
                headers: {
                        "Content-type": "application/x-www-form-urlencoded"
                },
                body:"userTo="+userTo+"&userFrom="+userFrom
        }).then(res => {
                return res.text();
        }).then(dataCount => {
                if(dataCount != null) {
                        btn.classList.toggle("subscribe");
                        btn.classList.toggle("unsubscribe");
                        var buttonText  = btn.classList.contains("subscribe") ? "SUBSCRIBE" : "SUBSCRIBED";
                        $(btn).text(buttonText + " " + dataCount);
                } else {
                        alert("Some Thing Went Wrong");
                }
        });
}