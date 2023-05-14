<?php
require_once 'functions/index.php';

// Проверка что пользователь авторизирован
if (!isAuthenticated()) {
    header("Location: login.php");
    exit();
}

// Получение массива объявлений
$ads = getAds();

require_once 'layouts/header.php';
?>

    <main>
        <section class="container">
            <h2>Объявления</h2>
            <div class="list">
                <?php foreach ($ads as $ad): ?>
                    <div class="item">
                        <h3><?php echo htmlspecialchars($ad['title']); ?></h3>
                        <p><?php echo htmlspecialchars($ad['description']); ?></p>
                        <span>@<?php echo htmlspecialchars($ad['username']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="form-container">
                <form id="ad-form">
                    <label for="title">Название:</label>
                    <input type="text" id="title" name="title" required>
                    <label for="description">Описание:</label>
                    <textarea id="description" name="description" required></textarea>
                    <button type="submit">Отправить</button>
                </form>
            </div>
        </section>
    </main>

    <script>
        const form = document.getElementById("ad-form");
        // Добавляем event на событие submit, которое будет отправлять запрос на создание объявления
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);

            fetch("createAd.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    // При успехе создаём новый элемент в списке
                    if (data.success) {
                        const adRow = `
                            <div class="item">
                                <h3>${data.ad.title}</h3>
                                <p>${data.ad.description}</p>
                                <span>@${data.ad.username}</span>
                            </div>
                        `;
                        // Очищаем форму
                        form.reset();
                        document.querySelector(".list").insertAdjacentHTML("afterbegin", adRow);
                    } else {
                        alert(data.error);
                    }
                });
        });
    </script>

<?php require_once 'layouts/footer.php'; ?>