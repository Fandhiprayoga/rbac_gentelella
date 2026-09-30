<?php
$siteName = setting('App.siteName') ?? 'Gentelella';
$logo = setting('App.siteLogo');
$logoUrl = ! empty($logo) ? base_url($logo) : base_url('gentelella/images/logo-icon.svg');
$themePrimary = setting('App.themePrimary') ?? '#1ABB9C';
$themePrimary = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $themePrimary) ? $themePrimary : '#1ABB9C';
$themeRadius = max(0, min(16, (int) (setting('App.themeRadius') ?? 6)));
$themeFontSize = max(13, min(16, (float) (setting('App.themeFontSize') ?? 14)));
$themeMode = setting('App.themeMode') ?? 'system';
$themeMode = in_array($themeMode, ['system', 'light', 'dark'], true) ? $themeMode : 'system';
$authAsideStart = setting('App.authAsideStart') ?? '#2f3f63';
$authAsideStart = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $authAsideStart) ? $authAsideStart : '#2f3f63';
$authAsideEnd = setting('App.authAsideEnd') ?? '#1b2338';
$authAsideEnd = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $authAsideEnd) ? $authAsideEnd : '#1b2338';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'Autentikasi') ?> | <?= esc($siteName) ?></title>
  <link rel="icon" href="<?= base_url('gentelella/images/favicon.svg') ?>" type="image/svg+xml">
  <script>
    (function () {
      try {
        var theme = localStorage.getItem('theme');
        var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        var defaultMode = <?= json_encode($themeMode) ?>;
        document.documentElement.setAttribute('data-theme', theme || (defaultMode === 'system' ? (prefersDark ? 'dark' : 'light') : defaultMode));
      } catch (error) {}
    })();
  </script>
  <script type="module" src="<?= base_url('gentelella/js/rolldown-runtime-_5RX-BWT.js') ?>"></script>
  <script type="module" src="<?= base_url('gentelella/js/toast-CBtjS_PZ.js') ?>"></script>
  <script type="module" src="<?= base_url('gentelella/js/main-v4-CmWkxJuV.js') ?>"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('gentelella/assets/main-v4-DB_ReeJG.css') ?>">
  <link rel="stylesheet" href="<?= base_url('gentelella/assets/dashboard-app.css') ?>">
  <style>
    :root {
      --primary: <?= esc($themePrimary) ?>;
      --primary-dk: color-mix(in srgb, var(--primary) 80%, black);
      --primary-lt: color-mix(in srgb, var(--primary) 10%, transparent);
      --radius: <?= $themeRadius ?>px;
      --radius-sm: <?= max(0, $themeRadius - 2) ?>px;
      --radius-lg: <?= $themeRadius + 2 ?>px;
      --font-size: <?= $themeFontSize / 16 ?>rem;
    }
    :root[data-theme="dark"] { --primary-lt: color-mix(in srgb, var(--primary) 14%, transparent); }
    .auth-page { background: linear-gradient(160deg, <?= esc($authAsideStart) ?>, <?= esc($authAsideEnd) ?>); }
  </style>
</head>
<body data-shell="auth" data-page="auth">
  <main class="auth-page">
    <section class="auth-card">
      <a class="auth-brand" href="<?= base_url() ?>">
        <img src="<?= esc($logoUrl, 'attr') ?>" alt="" width="30" height="30">
        <span class="brand-name"><?= esc($siteName) ?></span>
      </a>
      <?= $this->renderSection('content') ?>
    </section>
  </main>

  <script>
    document.addEventListener('click', function (event) {
      var toggle = event.target.closest('[data-password-toggle]');
      if (!toggle) return;
      var input = document.getElementById(toggle.getAttribute('aria-controls'));
      if (!input) return;
      var reveal = input.type === 'password';
      input.type = reveal ? 'text' : 'password';
      toggle.setAttribute('aria-pressed', String(reveal));
    });
  </script>
  <?= $this->renderSection('js') ?>
</body>
</html>