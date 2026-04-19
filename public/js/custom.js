document.addEventListener("click", function(e){

    const toggleBtn = e.target.closest(".toggle-menu");
    const allMenus = document.querySelectorAll(".glass-menu");

    /* If clicking the toggle button */
    if(toggleBtn){

    e.stopPropagation();

    const container = toggleBtn.closest(".action-container");
    const menu = container.querySelector(".glass-menu");

    const isOpen = menu.classList.contains("show");

    /* close all menus first */
    allMenus.forEach(m => m.classList.remove("show"));

    /* toggle */
    if(!isOpen){
    menu.classList.add("show");
    }

    return;
    }

    /* if clicking outside close all */
    allMenus.forEach(menu=>{
    menu.classList.remove("show");
    });

});
