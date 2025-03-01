<?php 
$fieldId = str_replace(['[', ']'], ['__', ''], $config['name']); 
$day = $value['day'] ?? ''; 
$month = $value['month'] ?? ''; 
$year = $value['year'] ?? ''; 
?>

<div class="d-flex">
    <input 
        type="text" 
        class="form-control" 
        id="date_<?= $fieldId; ?>" 
        style="min-width:50px" 
        value="<?= $day; ?>">

    <span class="date-separator px-2">/</span>

    <select id="month_<?= $fieldId; ?>" class="form-select">
        <?php 
        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', 
            '04' => 'April', '05' => 'Mei', '06' => 'Juni', 
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September', 
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        foreach ($months as $key => $name) {
            $selected = ($month === $key) ? 'selected' : '';
            echo "<option value='$key' $selected>$name</option>";
        }
        ?>
    </select>

    <span class="date-separator px-2">/</span>

    <input 
        type="text" 
        class="form-control" 
        id="year_<?= $fieldId; ?>" 
        style="min-width:70px" 
        value="<?= $year; ?>">
</div>

<p class="small invalid-date text-danger d-none" id="invalid_<?= $fieldId; ?>">Tanggal tidak valid</p>

<input type="hidden" id="real_<?= $fieldId; ?>" name="<?= $config['name']; ?>" value="">

<script>
    $(function() {
        $('#date_<?= $fieldId; ?>, #month_<?= $fieldId; ?>, #year_<?= $fieldId; ?>')
        .on('change', function() {
            let date = $('#date_<?= $fieldId; ?>').val();
            let month = $('#month_<?= $fieldId; ?>').val();
            let year = $('#year_<?= $fieldId; ?>').val();
            let mydate = moment(date + '-' + month + '-' + year, "DD-MM-YYYY").format("YYYY-MM-DD");
            
            if(mydate === 'Invalid date' || year.length !== 4 || date.length > 2) {
                $('#invalid_<?= $fieldId; ?>').removeClass('d-none');
            } else {
                $('#invalid_<?= $fieldId; ?>').addClass('d-none');
            }
            
            $('#real_<?= $fieldId; ?>').val(mydate);
        });
    });
</script>
