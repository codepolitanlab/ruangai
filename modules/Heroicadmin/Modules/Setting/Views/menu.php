<?php foreach ($schemas as $slug => $schema) : ?>
<li><a class="dropdown-item active" href="/<?= urlScope() ?>/setting/<?= $slug ?>"><?= $schema->title ?></a></li>
<?php endforeach; ?>