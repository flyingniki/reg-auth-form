<div class="user-info">
    <div class="user-info">
        <p>ДОБРО ПОЖАЛОВАТЬ, <?= $userName ?></p>
        <p>Здесь можно поменять твое ФИО и пароль</p>

        <form action="/admin.php" method="POST" autocomplete="off">
            <div class="form-floating">
                <input class="form-control <?= $class['newName'] ?? '' ?>" type="text" name="new-name" id="new-name"
                    value="<?= $post['newName'] ?? null ?>">
                <label for="new-name">Новые ФИО</label>
                <p class="form__message"><?= $errors['newName'] ?? '' ?></p>
            </div>
            <div class="form-floating">
                <input class="form-control <?= $class['newPassword'] ?? '' ?>" type="password" name="new-password"
                    id="new-password" value="<?= $post['newPassword'] ?? null ?>">
                <label for="new-password">Новый пароль</label>
                <p class="form__message"><?= $errors['newPassword'] ?? '' ?></p>
            </div>
            <div class="form-floating">
                <input class="form-control <?= $class['oldPassword'] ?? '' ?>" type="password" name="old-password"
                    id="old-password" value="<?= $post['oldPassword'] ?? null ?>">
                <label for="old-password">Старый пароль</label>
                <p class="form__message"><?= $errors['oldPassword'] ?? '' ?></p>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">
                Изменить
            </button>
        </form>

        <a href="/logout.php">Выйти</a>
    </div>
</div>