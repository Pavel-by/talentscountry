<?php
if (session_status() == PHP_SESSION_DISABLED or session_status() == PHP_SESSION_NONE) {
    @session_start();
}
?>
<script type="text/javascript" src="scripts/js/left-menu.js"></script>
<div id="left-menu">
    <div class="information-menu">
        <ul>
            <li><a href="logout.php" class="input input-submit center full-width">Выход</a></li>
            <li><a href="user-info.php" class="information-menu-item">Информация</a></li>
            <li><a href="user-payment.php" class="information-menu-item">Оплата</a></li>
            <li><a href="user-download.php" class="information-menu-item">Скачать задания</a></li>
            <li><a href="user-answer.php" class="information-menu-item">Отправить решения</a></li>
            <li><a href="user-results.php" class="information-menu-item">Результаты</a></li>
            <?php
            if (isset($_SESSION['usertype']) and $_SESSION['usertype'] == 1) {
                echo "<li><a href=\"comments.php\" class=\"information-menu-item\">Оставить отзыв</a></li>";
            }
            ?>
        </ul>
    </div>
</div>
<div id="left-menu-small">
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
            <li><a href="user-info.php" class="information-menu-item">Информация</a></li>
            <li><a href="user-payment.php" class="information-menu-item">Оплата</a></li>
            <li><a href="user-download.php" class="information-menu-item">Скачать задания</a></li>
            <li><a href="user-answer.php" class="information-menu-item">Отправить решения</a></li>
            <li><a href="user-results.php" class="information-menu-item">Результаты</a></li>
            <?php
            if (isset($_SESSION['usertype']) and $_SESSION['usertype'] == 1) {
                echo "<li><a href=\"comments.php\" class=\"information-menu-item\">Оставить отзыв</a></li>";
            }
            ?>
            <li><a href="logout.php" class="information-menu-item">Выход</a></li>
        </ul>
    </div>
</div>