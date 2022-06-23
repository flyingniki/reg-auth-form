<div class="user-info">
    <div class="user-info">
        <p>ДОБРО ПОЖАЛОВАТЬ, <?= $userName ?></p>
        <p>Здесь можно поменять твое ФИО и пароль</p>

        <form action="/admin.php" method="POST" autocomplete="off">
            <div class="form-floating">
                <input class="form-control" type="text" name="new-name" id="new-name">
                <label for="new-name">Новые ФИО</label>
            </div>
            <div class="form-floating">
                <input class="form-control" type="password" name="new-password">
                <label for="new-password">Новый пароль</label>
            </div>
            <div class="form-floating">
                <input class="form-control" type="password" name="old-password">
                <label for="old-password">Старый пароль</label>
                <p><?= $error ?></p>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">
                Изменить
            </button>
        </form>

        <a href="/logout.php">Выйти</a>
    </div>
</div>