<form action="/register.php" method="POST" autocomplete="off">
  <h1 class="h3 mb-3 fw-normal">Please register</h1>

  <div class="form-floating">
    <input type="text" name="login" class="form-control" id="floatingLogin" placeholder="name@example.com" />
    <label for="floatingLogin">Login</label>
  </div>

  <div class="form-floating">
    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" />
    <label for="floatingPassword">Password</label>
  </div>

  <div class="form-floating">
    <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Email" />
    <label for="floatingEmail">Email</label>
  </div>

  <div class="form-floating">
    <input type="text" name="name" class="form-control" id="floatingName" placeholder="Name" />
    <label for="floatingName">Name</label>
  </div>

  <button class="w-100 btn btn-lg btn-primary" type="submit">
    Register
  </button>
</form>