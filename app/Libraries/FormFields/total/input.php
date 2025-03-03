<?php
$attrs = '';
if (isset($config['attr'])) {
    foreach ($config['attr'] as $key => $val) {
        $attrs .= $key . '="' . $val . '" ';
    }
}
?>
<div class="form-inline">
    <button id="sum<?= $config['name'];?>" type="button" class="btn btn-info py-2 mt-1 me-2">&sum;</button>
    <input id="<?= str_replace(['[',']'], ['__',''], $config['name']);?>" 
           type="number" 
           name="<?= $config['name'];?>" 
           value="<?= $value; ?>" 
           class="form-control" 
           <?= $attrs; ?> 
           data-caption="<?= $config['label'];?>" />
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("sum<?= $config['name'];?>").addEventListener("click", function() {
        let total = 0;
        <?php foreach($config['sum'] as $sumField): ?>
        let field = document.getElementById("<?= $sumField; ?>");
        if (field && field.value) {
            total += parseInt(field.value) || 0;
        }
        <?php endforeach; ?>
        document.getElementById("<?= str_replace(['[',']'], ['__',''], $config['name']);?>").value = total;
    });
});
</script>
