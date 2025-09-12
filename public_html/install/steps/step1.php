<?php
// public_html/install/steps/step1.php
?>
<div class="card">
  <div class="card-body">
    <h2 class="h4 mb-3">Krok 1 — połączenie z bazą</h2>

    <?php if (!empty($err)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form action="install-handler.php?step=2" method="post" autocomplete="off">
      <div class="mb-3">
        <label class="form-label">Host bazy</label>
        <input name="db_host" type="text" class="form-control" required
               value="<?= htmlspecialchars($old['db_host']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Nazwa bazy</label>
        <input name="db_name" type="text" class="form-control" required
               value="<?= htmlspecialchars($old['db_name']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Użytkownik bazy</label>
        <input name="db_user" type="text" class="form-control" required
               value="<?= htmlspecialchars($old['db_user']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Hasło bazy</label>
        <input name="db_pass" type="password" class="form-control" >
      </div>
      <div class="mb-3">
        <label class="form-label">Prefix tabel</label>
        <input name="prefix" type="text" class="form-control" required
               value="<?= htmlspecialchars($old['prefix']) ?>">
        <div class="form-text">np. <code>serwiskonf_</code></div>
      </div>

      <button class="btn btn-primary" type="submit">Dalej →</button>
    </form>
  </div>
</div>
