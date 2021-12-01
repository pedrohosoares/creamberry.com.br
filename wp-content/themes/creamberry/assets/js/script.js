let theme = {
    openCloseMenuMobile(){
        let button_menu = document.querySelector('.mobile-nav-toggler');
        let menu = document.querySelector('.main-menu.navbar-expand-md.navbar-light');
        button_menu.onclick = ()=>{
            console.log(menu.style.display);
            if(menu.style.display == '' || menu.style.display == "none"){
                document.querySelector('.main-menu').style.display = "block";
            }else if(menu.style.display == "block"){
            
                document.querySelector('.main-menu').style.display = "none";
            }
        }
    },
    openSearchBox(){
        let button_search = document.querySelector('.search-box-btn');
        let search_menu = document.querySelector('.dropdown-menu.search-panel');

        button_search.onclick = ()=>{
            if(search_menu.style.display == '' || search_menu.style.display == "none"){
                search_menu.style.display = "block";
                search_menu.style.visibility = "visible";
            }else if(search_menu.style.display == "block"){
            
                search_menu.style.display = "none";
                search_menu.style.visibility = "hidden";
            }
        };
    },
    init(){
        this.openCloseMenuMobile();
        this.openSearchBox();
    }

};

theme.init();