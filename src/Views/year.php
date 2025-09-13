<?php /** @var int $year */ /** @var bool $isLeap */ ?>
<h1 class="card">Год: <?= (int)$year ?></h1>
<div class="card">
  <p>Високосный: <strong><?= $isLeap ? 'да' : 'нет' ?></strong></p>
  <p class="muted">Логика в контроллере считает високосность через <code>DateTimeImmutable</code>.</p>
</div>
