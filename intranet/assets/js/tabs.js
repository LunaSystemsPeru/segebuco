//Activacion del tabs
let listButtonNavs = document.querySelectorAll("button.nav-link");
let listPanes = document.querySelectorAll(".tab-pane.fade");

listButtonNavs.forEach((listButtonNav) => {
    listButtonNav.addEventListener("click", () => {
        listButtonNavs.forEach((listButtonNavs) => listButtonNavs.classList.remove("active"));
        listButtonNav.classList.add("active");

        listPanes.forEach((listPane) => listPane.classList = ("#" + listPane.id != listButtonNav.dataset.bsTarget) ? "tab-pane fade" : "tab-pane fade show active");
    });
});