<form action="/index.php" method="POST" autocomplete="off">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <div class="form-floating">
        <input type="text" name="login" class="form-control <?= $class['login'] ?? '' ?>" id="floatingLogin"
            placeholder="name@example.com" value="<?= $post['login'] ?? null ?>" />
        <label for="floatingLogin">Login</label>
        <p class="form__message"><?= $errors['login'] ?? '' ?></p>
    </div>

    <div class="form-floating">
        <input type="password" name="password" class="form-control <?= $class['password'] ?? '' ?>" id="floatingPassword"
            placeholder="Password" value="<?= $post['password'] ?? null ?>" />
        <label for="floatingPassword">Password</label>
        <p class="form__message"><?= $errors['password'] ?? '' ?></p>
    </div>

    <button class="w-100 btn btn-lg btn-primary" type="submit">
        Sign in
    </button>
</form>

<div class="reg-form">
    <a href="register.php">Don't have an account? Register here!</a>
</div>