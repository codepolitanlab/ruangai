<?php
$phone = substr($result[$config['name']] ?? '', 0, 1)=='0' 
        ? substr_replace($result[$config['name']], '62', 0, 1) 
        : $result[$config['name']];
?>
<a href="https://wa.me/<?= $phone; ?>" target="_blank"><?= $phone; ?></a>