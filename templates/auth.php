<form action="auth.php" method="POST" autocomplete="off">
  <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

  <div class="form-floating">
    <input type="text" name="login" class="form-control" id="floatingLogin" placeholder="name@example.com" />
    <label for="floatingLogin">Login</label>
  </div>

  <div class="form-floating">
    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" />
    <label for="floatingPassword">Password</label>
  </div>

  <button class="w-100 btn btn-lg btn-primary" type="submit">
    Sign in
  </button>
</form>

<div class="reg-form">
  <a href="register.php">Don't have an account? Register here!</a>
</div>