<div class="input-group">
    <input type="password" id="<?= str_replace(['[',']'], ['__',''], $config['name']); ?>" 
           name="<?= $config['name']; ?>"
           placeholder="<?= $config['placeholder'] ?? ''; ?>" 
           class="form-control" 
           data-caption="<?= $config['label']; ?>" />

    <div class="input-group-append">
       <button class="btn mb-0 btn-secondary" id="show_password_<?= str_replace(['[',']'], ['__',''], $config['name']); ?>" data-toggle="hide" type="button">
           <span class="fa fa-eye-slash"></span>
       </button>
    </div>
</div>

<script>
    $(function(){
        $('#show_password_<?= str_replace(['[',']'], ['__',''], $config['name']); ?>').on('click', function(){
            let inputField = $('#<?= str_replace(['[',']'], ['__',''], $config['name']); ?>');
            if($(this).data('toggle') === 'hide'){
                $(this).data('toggle', 'show').html('<span class="fa fa-eye"></span>');
                inputField.attr('type', 'text');
            } else {
                $(this).data('toggle', 'hide').html('<span class="fa fa-eye-slash"></span>');
                inputField.attr('type', 'password');
            }
        });
    });
</script>
