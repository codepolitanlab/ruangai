<?php
$idname = str_replace(['[', ']'], ['__', ''], $config['name']);
?>

<div>
  <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addMultipleItemModal-<?= $idname; ?>">+ Add Item</button>
  <input type="hidden" name="<?= $config['name']; ?>[mode]" value="multiple_advanced">
  
  <table class="table table-striped table-sm" id="table-<?= $idname; ?>">
    <tr>
      <th>Item</th>
      <th>Quantity</th>
      <th></th>
    </tr>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="addMultipleItemModal-<?= $idname; ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add <?= $config['label']; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Item</label>
          <input type="text" class="form-control" id="item-<?= $idname; ?>">
        </div>
        <div class="mb-3">
          <label>Quantity</label>
          <input type="number" class="form-control" id="qty-<?= $idname; ?>">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSave-<?= $idname; ?>">Save</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function(){
    $('#btnSave-<?= $idname; ?>').on('click', function(){
      let item = $('#item-<?= $idname; ?>').val();
      let qty = $('#qty-<?= $idname; ?>').val();
      let row = `<tr>
                    <td>${item}</td>
                    <td>${qty}</td>
                    <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
                 </tr>`;
      $('#table-<?= $idname; ?>').append(row);
      $('#addMultipleItemModal-<?= $idname; ?>').modal('hide');
    });

    $(document).on('click', '.remove-row', function(){
      $(this).closest('tr').remove();
    });
  });
</script>
