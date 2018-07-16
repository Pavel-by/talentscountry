//var leftMenu;
var windowSizeToCloseMenu = 1000;
var menuOpened = false;
var smallMenu;

function openMenu () {
    $(smallMenu).addClass('opened');
    $(smallMenu).removeClass("closed");
    document.body.style.overflow = "hidden";
    return false;
}

function closeMenu () {
    $(smallMenu).addClass('closed');
    $(smallMenu).removeClass("opened");
    document.body.style.overflow = "auto";
    return false;
}

function changeMenu () {
    if (menuOpened) {
        closeMenu();
        menuOpened = false;
    }
    else {
        openMenu();
        menuOpened = true;
    }
    return false;
}

$(window).resize(function(){    
    if (document.body.clientWidth <= windowSizeToCloseMenu) {
        closeMenu();
        menuOpened = false;
    }
});
document.addEventListener("DOMContentLoaded", function(){
    var footer = document.getElementById("footer");
    //leftMenu = document.getElementById("left-menu");
    smallMenu = document.getElementById("left-menu-small");
    var topMenu = document.getElementById("root-top-block");
    var lastScroll = window.pageYOffset || document.documentElement.scrollTop;

    updateLeftMenuPosition();

    window.addEventListener('scroll', function(){
        //updateLeftMenuPosition();
    });

    function updateLeftMenuPosition(){
        /*var topMenuHeight = topMenu.offsetHeight;
        var topMenuBottom = topMenu.getBoundingClientRect().bottom;
        var leftMenuHeight = leftMenu.offsetHeight;
        var leftMenuTop = leftMenu.getBoundingClientRect().top;
        var height = window.innerHeight;
        var footerTop = footer.getBoundingClientRect().top;
        var scroll = window.pageYOffset || document.documentElement.scrollTop;

        var top = topMenuBottom;
        /*if (footerTop < leftMenuHeight + topMenuBottom) {
            top = footerTop - leftMenuHeight;
        }*/
        //leftMenu.style.top = top + "px";
    }

    if (document.body.clientWidth <= windowSizeToCloseMenu) {
        closeMenu();
        menuOpened = false;
    } 

    //document.getElementsByClassName('content')[0].style.marginLeft = (leftMenu.offsetWidth) + "px";
});