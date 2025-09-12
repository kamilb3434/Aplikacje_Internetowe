<?php
// public_html/install/steps/step5.php
?>
<div class="card">
  <div class="card-body">
    <h2 class="h4 mb-3">Krok 5 — dane aplikacji i konto administratora</h2>

    <form action="install-handler.php?step=6" method="post" autocomplete="off">
      <div class="row">
        <div class="col-md-6">
          <h5 class="mb-3">Aplikacja</h5>
          <div class="mb-3">
            <label class="form-label">Adres bazowy (base_url)</label>
            <input name="base_url" type="text" class="form-control" placeholder="http://localhost/">
          </div>
          <div class="mb-3">
            <label class="form-label">Nazwa aplikacji</label>
            <input name="nazwa_aplikacji" type="text" class="form-control" value="Serwis Konferencyjny">
          </div>
          <div class="mb-3">
            <label class="form-label">Wersja</label>
            <input name="wersja" type="text" class="form-control" value="beta">
          </div>
          <div class="mb-3">
            <label class="form-label">Brand</label>
            <input name="brand" type="text" class="form-control" value="SerwisKonferencyjnyIT">
          </div>
          <div class="mb-3">
            <label class="form-label">Telefon</label>
            <input name="phone" type="text" class="form-control" value="(+48) 000 000 000">
          </div>
        </div>

        <div class="col-md-6">
          <h5 class="mb-3">Konto administratora</h5>
          <div class="mb-3">
            <label class="form-label">Login (e-mail)</label>
            <input name="admin_login" type="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Hasło</label>
            <input name="passwd" type="password" class="form-control" required minlength="8">
          </div>
          <div class="mb-3">
            <label class="form-label">Powtórz hasło</label>
            <input name="passwd2" type="password" class="form-control" required minlength="8">
          </div>
        </div>
      </div>

      <button class="btn btn-primary" type="submit">Zakończ instalację</button>
    </form>
  </div>
</div>
