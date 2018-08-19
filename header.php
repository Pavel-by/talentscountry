<?php
    @session_start();
?>
<div class="menu-container" id="root-top-block">
    <!--div class="main-background">
        <div id="top-block" class="limit-block flex-block flex-between flex-row flex-middle" style="border-bottom: 1px solid rgba(128, 128, 128, 0.432);">
            <p style="text-align: left; color: black; font-size: 18px; padding-left: 60px; padding-right: 60px; padding-top: 30px; padding-bottom: 30px;">
                help@stranatalantow.ru<br>+7 (903) 949 55 41<br>+7 (923) 00 483 02
            </p>
            <p style="color: black; font-size: 18px; padding-left: 60px; padding-right: 60px; padding-top: 30px; padding-bottom: 30px;">
                <a href="registration.php" class="bright-button">Принять участие!</a>
            </p>
        </div>
    </div-->
    <div class="limit-block flex-block flex-row flex-middle flex-between">
        <a href="index.php" class="logo-link" style="display: inline-block;">
            <div class="logo flex-block flex-row flex-middle flex-nowrap">
                <img src="images/logo.jpg">
                <h2>Страна талантов</h2>
            </div>
        </a>
        <ul class="flex-block flex-middle flex-row flex-nowrap flex-right">
            <li><a href="#" onclick="return openMenu();" class="open-menu-button menu-item" style="padding-right: 100px;">Меню</a></li>
            <li><a href="about.php" class="menu-item big-screen">О проекте</a></li>
            <li><a href="contacts.php" class="menu-item big-screen">Контакты</a></li>
            <?php
                echo (
                    isset($_SESSION['name']) 
                    ?   "<li><a href=\"user-info.php\" class=\"menu-item big-screen\">" . $_SESSION['name'] . "</a></li>"
                    :   "<li><a href=\"login.php\" class=\"menu-item big-screen\">Вход</a></li>"
                        . "<li><a href=\"registration.php\" class=\"menu-item big-screen\">Регистрация</a></li>"
                );
            ?>
        </ul>
        
    </div>
    <script type="text/javascript">
        var topBlock;
        var root;

        function updateTopBlock() {
            var scroll = window.pageYOffset || document.documentElement.scrollTop;
            if (scroll == 0) {
                root.style.boxShadow = "none";
            }
            else {
                root.style.boxShadow = "0 0 8px rgba(0,0,0,0.1)";
            }
        }
        
        document.addEventListener("DOMContentLoaded", function(){
            topBlock = document.getElementById("top-block");
            root = document.getElementById("root-top-block");
            window.addEventListener('scroll', function() {
                updateTopBlock();
            });

            updateTopBlock();

            //Меню
            var menu = document.getElementById("slide-down-menu");
            var opened = false;
            function OpenMenu(elem){
                opened = true;
                $(elem).next().show(0);
                $(elem).addClass("opened");
            }

            function CloseMenu(elem){
                opened = false;
                $(elem).next().hide(0);
                $(elem).removeClass("opened");
            }

            $('.menu-item.slide-down').click(function(e){
                e.preventDefault();
                if (opened){
                    CloseMenu(this);
                }
                else {
                    OpenMenu(this);
                }
            });

            $(menu).parent().click(false, function(e){
                event.stopPropagation ? event.stopPropagation() : (event.cancelBubble=true);
            });

            $("body").click(false, function(){
                CloseMenu($(menu).parent().find(".slide-down"));
            });
        });
    </script>
</div>