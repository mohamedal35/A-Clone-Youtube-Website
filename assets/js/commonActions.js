document.addEventListener("DOMContentLoaded", ()=> {
    var showHideButton = document.querySelector(".navShowHide");

        showHideButton.onclick = () => {
            var mainSectionContainer = document.getElementById("mainSectionContainer"),
                sideNavContainer     = document.getElementById("sideNavContainer");
            if (mainSectionContainer.classList.contains("paddingLeft")) {
                sideNavContainer.style.display = "none";
            } else {
                sideNavContainer.style.display = "block";
            }
            mainSectionContainer.classList.toggle("paddingLeft");
        }
});
