<?php 
$idname = str_replace(['[', ']'], ['__', ''], $config['name']);
?>

<select id="<?= $idname; ?>" name="<?= $config['name']; ?>[]" class="form-control" multiple data-caption="<?= $config['label']; ?>"></select>

<script>
  $(function(){
    $('#<?= $idname; ?>').select2({
      placeholder: '<?= $config['placeholder'] ?? ''; ?>',
      ajax: {
        url: '<?= site_url('admin/entry/config/getSelect2Dropdown'); ?>',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            table: '<?= $config['relation']['table']; ?>',
            caption_field: <?= json_encode($config['relation']['caption']); ?>,
            search_field: <?= json_encode($config['relation']['searchby']); ?>,
            keyword: params.term
          };
        },
        cache: true
      }
    });
  });
</script>
