<?php

// Подключаем файл конфигурации
require '../config/config.inc.php';

// Устанавливаем идентификатор пользователя в сессию

// Подключаем файл с настройками для работы с MySQL
require MYSQL;

// Включаем файл заголовка
include 'header.html';

?>

<section class="main-content">

    <div class="banner chapter">
        <div class="banner__content">
            <h1>МОЙ НЕ САМ И САМ НЕ МОЙ</h1>
        </div>
    </div>

    <div class="feedbacks">
        <h2>ОТЗЫВЫ</h2>
        <div class="feedbacks__content">
            <div class="feedback">
                <div class="feedback__logo">
                    <h4>Иванова Мария Петровна</h4>
                    <div class="rating">
                        <p>5/5</p>
                    </div>
                </div>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Non rerum impedit porro ipsa debitis exercitationem iste corporis amet nam, cupiditate provident sunt sed totam doloremque dolore quisquam ea in, similique quas placeat ex voluptatibus cumque. Maiores deserunt cupiditate ullam omnis!</p>
            </div>
            <div class="feedback">
                <div class="feedback__logo">
                    <h4>Иванова Мария Петровна</h4>
                    <div class="rating">
                        <p>5/5</p>
                    </div>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex adipisci, repellat atque deleniti quia est? Facere magni, modi non dolor consectetur excepturi libero soluta necessitatibus. Nobis in sunt, totam fugiat ratione quas, provident, corporis hic sint libero eius possimus minus.</p>
            </div>
            <div class="feedback">
                <div class="feedback__logo">
                    <h4>Иванова Мария Петровна</h4>
                    <div class="rating">
                        <p>5/5</p>
                    </div>
                </div>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perferendis tempora maxime quaerat porro, excepturi aperiam quisquam consequatur doloremque illo cum distinctio quam officiis totam fuga inventore aliquid expedita et. Voluptates iste tenetur optio earum reiciendis enim ipsa quas qui quibusdam!</p>
            </div>
            <div class="feedback">
                <div class="feedback__logo">
                    <h4>Иванова Мария Петровна</h4>
                    <div class="rating">
                        <p>5/5</p>
                    </div>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis unde ratione soluta laudantium dolor eveniet labore architecto quas debitis harum dolorum, temporibus commodi non aspernatur excepturi doloribus ea doloremque voluptatum quasi cumque maxime ipsa. Quia error quam voluptate магнам dicta.</p>
            </div>
        </div>

    </div>
</section>

<?php

// Включаем файл подвала
include 'footer.html'

?>
