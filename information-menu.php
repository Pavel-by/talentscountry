<?php
@session_start();
?>
<script type="text/javascript" src="scripts/js/left-menu.js"></script>
<div id="left-menu">
    <div class="information-menu">
        <ul>
            <?php
            if (isset($_SESSION['userkey'])) {
                echo "<li><a href=\"/user-info.php\" class=\"input full-width input-submit big-screen center\">Аккаунт</a></li>";
            } else {
                echo "<li class='flex-block flex-left flex-middle flex-nowrap flex-row'>"
                    . "<a href=\"/login.php\" class=\"input full-width input-submit big-screen center\">Вход</a>"
                    . "<a href=\"/registration.php\" class=\"input full-width input-submit big-screen center\">Регистрация</a>"
                    . "</li>";
            }
            ?>

            <li><a href="/" class="information-menu-item small-screen">Главная</a></li>
            <li><a href="about.php" class="information-menu-item small-screen">О проекте</a></li>
            <li><a href="contacts.php" class="information-menu-item small-screen">Контакты</a></li>
            <?php
            echo(
            isset($_SESSION['name'])
                ? "<li><a href=\"user-info.php\" class=\"information-menu-item small-screen\">" . $_SESSION['name'] . "</a></li>"
                : "<li><a href=\"login.php\" class=\"information-menu-item small-screen\">Вход</a></li>"
                . "<li><a href=\"registration.php\" class=\"information-menu-item small-screen\">Регистрация</a></li>"
            );
            ?>
            <li><a href="about.php" class="information-menu-item">О проекте</a></li>
            <li><a href="statements.php" class="information-menu-item">Общие положения</a></li>
            <li><a href="howstart.php" class="information-menu-item">Как принять участие</a></li>
            <li><a href="archive.php" class="information-menu-item">Архив</a></li>
            <li><a href="criteria.php" class="information-menu-item">Критерии</a></li>
            <li><a href="news.php" class="information-menu-item">Новости</a></li>
            <li><a href="jury.php" class="information-menu-item">Наши учителя</a></li>
            <li><a href="subscribe.php" class="information-menu-item">Подписка</a></li>
            <li><a href="rules.php" class="information-menu-item">Правила участия</a></li>
            <li><a href="prizes.php" class="information-menu-item">Призы и подарки</a></li>
            <li><a href="premiummaterials.php" class="information-menu-item">Наградные материалы</a></li>
            <li><a href="trial.php" class="information-menu-item">Пробные задания</a></li>
            <li><a href="faq.php" class="information-menu-item">Частые вопросы</a></li>
            <li><a href="law-acts.php" class="information-menu-item">Помощь педагогам</a></li>
            <li><a href="details.php" class="information-menu-item">Реквизиты</a></li>
            <li><a href="contacts.php" class="information-menu-item">Контакты</a></li>
            <li><a href="paymentreceipt.php" class="information-menu-item">Оплата</a></li>
            <li><a href="job.php" class="information-menu-item">Вакансии</a></li>
            <li><a href="comments.php" class="information-menu-item">Отзывы</a></li>
        </ul>
    </div>
    <!--div class="social-block">
        <a class="share" href="https://www.facebook.com/Страна талантов-601908700163839" target="_blank" title="Facebook">
            <img src="http://olympforum.ru/images/facebook-icon.png" alt="facebook">
        </a>
        <a class="share" href="https://vk.com/olympforum" target="_blank" title="ВКонтакте">
            <img src="http://olympforum.ru/images/vk-icon.png" alt="VK">
        </a>
        <a class="share" href="https://www.ok.ru/group/53730148352145" target="_blank" title="Одноклассники">
            <img src="http://olympforum.ru/images/odnoklassniki-icon.png" alt="Odnoklassniki">
        </a>
    </div-->
</div>

<div id="left-menu-small">
    <?php
    include('small-menu-top-block.html');
    ?>
    <div class="information-menu">
        <ul>
            <li><a href="/" class="information-menu-item">Главная</a></li>
            <li><a href="about.php" class="information-menu-item">О проекте</a></li>
            <li><a href="contacts.php" class="information-menu-item">Контакты</a></li>
            <?php
            echo(
            isset($_SESSION['name'])
                ? "<li><a href=\"user-info.php\" class=\"information-menu-item\">" . $_SESSION['name'] . "</a></li>"
                : "<li><a href=\"login.php\" class=\"information-menu-item\">Вход</a></li>"
                . "<li><a href=\"registration.php\" class=\"information-menu-item\">Регистрация</a></li>"
            );
            ?>
            <hr>
            <li><a href="statements.php" class="information-menu-item">Общие положения</a></li>
            <li><a href="archive.php" class="information-menu-item">Архив</a></li>
            <li><a href="criteria.php" class="information-menu-item">Критерии</a></li>
            <li><a href="news.php" class="information-menu-item">Новости</a></li>
            <li><a href="jury.php" class="information-menu-item">Наши учителя</a></li>
            <li><a href="subscribe.php" class="information-menu-item">Подписка</a></li>
            <li><a href="rules.php" class="information-menu-item">Правила участия</a></li>
            <li><a href="prizes.php" class="information-menu-item">Призы и подарки</a></li>
            <li><a href="premiummaterials.php" class="information-menu-item">Наградные материалы</a></li>
            <li><a href="trial.php" class="information-menu-item">Пробные задания</a></li>
            <li><a href="faq.php" class="information-menu-item">Частые вопросы</a></li>
            <li><a href="law-acts.php" class="information-menu-item">Помощь педагогам</a></li>
            <li><a href="howstart.php" class="information-menu-item">Как принять участие</a></li>
            <li><a href="details.php" class="information-menu-item">Реквизиты</a></li>
            <li><a href="contacts.php" class="information-menu-item">Контакты</a></li>
            <li><a href="paymentreceipt.php" class="information-menu-item">Оплата</a></li>
            <li><a href="job.php" class="information-menu-item">Вакансии</a></li>
            <li><a href="comments.php" class="information-menu-item">Отзывы</a></li>
        </ul>
    </div>
    <!--div class="social-block">
        <a class="share" href="https://www.facebook.com/Страна талантов-601908700163839" target="_blank" title="Facebook">
            <img src="http://olympforum.ru/images/facebook-icon.png" alt="facebook">
        </a>
        <a class="share" href="https://vk.com/olympforum" target="_blank" title="ВКонтакте">
            <img src="http://olympforum.ru/images/vk-icon.png" alt="VK">
        </a>
        <a class="share" href="https://www.ok.ru/group/53730148352145" target="_blank" title="Одноклассники">
            <img src="http://olympforum.ru/images/odnoklassniki-icon.png" alt="Odnoklassniki">
        </a>
    </div-->
</div>