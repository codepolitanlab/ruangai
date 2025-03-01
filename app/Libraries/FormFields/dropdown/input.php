<?php 
$fieldId = str_replace(['[', ']'], ['__', ''], $config['name']); 
$options = $config['options'] ?? [];
$value = $value ?? '';
$attributes = $attributes ?? '';
?>

<?php if($config['load_after'] ?? ''): ?>
    <?php if(!$value): ?>
        <p id="loading_<?= $fieldId; ?>" class="text-muted"><em>Pilih dulu <?= $config['load_after']; ?></em></p>
    <?php endif; ?>

    <div id="dropdown_<?= $fieldId; ?>" class="<?= $value ? '' : 'sr-only'; ?>">
        <?= form_dropdown($config['name'], $options, $value, $attributes); ?>
    </div>

    <script>
        $(function(){
            $('#<?= $config['load_after']; ?>').on('change', function(){
                $('#loading_<?= $fieldId; ?>').addClass('sr-only');
                $('#dropdown_<?= $fieldId; ?>').removeClass('sr-only');

                let caption = '<?= is_array($config['relation']['caption'] ?? null) ? implode(',', $config['relation']['caption']) : ($config['relation']['caption'] ?? '') ?>';
                let filterField = '<?= $config['load_after']; ?>';
                let filterVal = $(this).val();
                
                $.getJSON(`<?= site_url('api/entry/'.$config['relation']['entry'].'/dropdown');?>?caption=${caption}&filter[${filterField}]=${filterVal}`, function(data){
                    $('#<?= $fieldId; ?>').empty();
                    $('#<?= $fieldId; ?>').append(`<option value="">-pilih opsi-</option>`);
                    if (typeof data !== 'undefined' && data.length > 0 && data[0] != false) {
                        data.forEach(function(item, idx){
                            $('#<?= $fieldId; ?>').append(`<option value="${item.id}">${item[caption]}</option>`);
                        });
                    }
                });

                $('.form-select').select2();
            });
        });
    </script>
<?php else: ?>
    <?= form_dropdown($config['name'], $options, $value, $attributes); ?>

    <?php if(($config['fixed_value'] ?? false) && (isset($_GET['filter'][$config['name']]) || isset($_GET[$config['name']]))) : ?>
        <input type="hidden" name="<?= $fieldId; ?>" value="<?= $value ?? $_GET[$config['name']] ?? $_GET['filter'][$config['name']] ?? ''; ?>">
    <?php endif; ?>

    <script>
        $(function(){
            $('.form-select').select2();

            <?php if($config['update_on_change'] ?? false): ?>
                $('#<?= $config['name']; ?>').on('change', function(){
                    const urlSearchParams = new URLSearchParams(window.location.search);
                    const params = Object.fromEntries(urlSearchParams.entries());
                    params['<?= $config['name']; ?>'] = $(this).val();
                    location.href = `<?= current_url(); ?>?` + new URLSearchParams(params).toString();
                });
            <?php endif; ?>
        });
    </script>
<?php endif; ?>
