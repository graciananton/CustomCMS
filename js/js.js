
document.write("js");
function updateContent(){
    console.log("Udating Content field");
        const title = document.getElementById('title').value;
        const content = document.getElementById('contentFinal');
        if(title =="header" || title =="footer" || title == "navBar"){
            console.log("Title is header, footer, or navBAr")
            content.value = "<nav class='navbar navbar-expand-lg navbar-dark bg-primary'><div class='container-fluid'><a class='navbar-brand' href='#'>Brand</a><button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#main_nav' aria-expanded='false' aria-label='Toggle navigation'><span class='navbar-toggler-icon'></span></button><div class='collapse navbar-collapse' id='main_nav'><ul class='navbar-nav'><li class='nav-item active'><a class='nav-link' href='#'>Home </a></li><li class='nav-item'><a class='nav-link' href='#'>About </a></li><li class='nav-item'><a class='nav-link' href='#'>Services </a></li><li class='nav-item dropdown'><a class='nav-link  dropdown-toggle' href='#' data-bs-toggle='dropdown'>Hover me </a><ul class='dropdown-menu'><li><a class='dropdown-item' href='#'>Submenu item 1</a></li><li><a class='dropdown-item' href='#'>Submenu item 2 </a></li><li><a class='dropdown-item' href='#'>Submenu item 3 </a></li></ul></li></ul><ul class='navbar-nav ms-auto'><li class='nav-item'><a class='nav-link' href='#'>Menu item </a></li><li class='nav-item'><a class='nav-link' href='#'>Menu item </a></li><li class='nav-item dropdown'><a class='nav-link  dropdown-toggle' href='#' data-bs-toggle='dropdown'>Dropdown right </a><ul class='dropdown-menu dropdown-menu-end'><li><a class='dropdown-item' href='#'>Submenu item 1</a></li><li><a class='dropdown-item' href='#'>Submenu item 2 </a></li></ul></li></ul></div></div></nav>";
        }
                                                    
    }
