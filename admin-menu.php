<script type="text/javascript" src="scripts/js/left-menu.js"></script>
<div id="left-menu">
    <div class="information-menu">
        <ul>
            <li><a href="logout.php" class="input-submit input full-width center">Выход</a></li>
            <li><a href="admin-add-permit.php" class="information-menu-item">Изменить допуск</a></li>
            <li><a href="admin-tables.php" class="information-menu-item">Скачать таблицы</a></li>
            <li><a href="admin-update-results.php" class="information-menu-item">Обновить результаты</a></li>
            <li><a href="admin-add-administrator.php" class="information-menu-item">Добавить администратора</a></li>
        </ul>
    </div>
</div>
<div id="left-menu-small">
    <?php
    include("small-menu-top-block.html");
    ?>
    <div class="information-menu">
        <ul>
            <li><a href="/" class="information-menu-item">Главная</a></li>
            <li><a href="about.php" class="information-menu-item">О проекте</a></li>
            <li><a href="contacts.php" class="information-menu-item">Контакты</a></li>
            <?php
                echo (
                    isset($_SESSION['name']) 
                    ?   "<li><a href=\"user-info.php\" class=\"information-menu-item\">" . $_SESSION['name'] . "</a></li>" 
                    :   "<li><a href=\"login.php\" class=\"information-menu-item\">Вход</a></li>"
                        . "<li><a href=\"registration.php\" class=\"information-menu-item\">Регистрация</a></li>"
                );
            ?>
            <hr>
            <li><a href="admin-add-permit.php" class="information-menu-item">Изменить допуск</a></li>
            <li><a href="admin-tables.php" class="information-menu-item">Скачать таблицы</a></li>
            <li><a href="admin-update-results.php" class="information-menu-item">Обновить результаты</a></li>
            <li><a href="admin-add-administrator.php" class="information-menu-item">Добавить администратора</a></li>
            <li><a href="logout.php" class="information-menu-item">Выйти</a></li>
        </ul>
    </div>
</div>