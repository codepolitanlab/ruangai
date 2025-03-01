<label class="switch">
    <input type="checkbox" <?= $value == '1' ? 'checked':''; ?>>
    <span class="slider round"></span>
    <input type="hidden" name="<?= $config['name'];?>" value="<?= $value; ?>">
</label>

<script>
    $(function(){
        $('input[type=checkbox]').on('change', function(){
            $(this).siblings('input[type=hidden]').val(Number($(this).prop('checked')));
        });
    });
</script>
