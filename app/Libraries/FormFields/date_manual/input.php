<?php
$id = str_replace(['[', ']'], ['__', ''], $config['name']);
$selectedYear = $value['year'] ?? date("Y");
$selectedMonth = $value['month'] ?? date("m");
$selectedDay = $value['day'] ?? date("d");
?>

<div class="d-flex">
    <!-- Select Tahun -->
    <select id="year_<?= $id; ?>" class="form-select me-2">
        <?php for ($y = date("Y") - 50; $y <= date("Y") + 10; $y++): ?>
            <option value="<?= $y; ?>" <?= $y == $selectedYear ? 'selected' : ''; ?>><?= $y; ?></option>
        <?php endfor; ?>
    </select>

    <!-- Select Bulan -->
    <select id="month_<?= $id; ?>" class="form-select me-2">
        <?php
        $months = [
            "01" => "Januari", "02" => "Februari", "03" => "Maret",
            "04" => "April", "05" => "Mei", "06" => "Juni",
            "07" => "Juli", "08" => "Agustus", "09" => "September",
            "10" => "Oktober", "11" => "November", "12" => "Desember"
        ];
        foreach ($months as $key => $name): ?>
            <option value="<?= $key; ?>" <?= $key == $selectedMonth ? 'selected' : ''; ?>><?= $name; ?></option>
        <?php endforeach; ?>
    </select>

    <!-- Select Tanggal -->
    <select id="day_<?= $id; ?>" class="form-select">
        <!-- Opsi tanggal akan diisi oleh JavaScript -->
    </select>
</div>

<p class="small invalid-date text-danger d-none" id="invalid_<?= $id; ?>">Tanggal tidak valid</p>

<!-- Input Hidden -->
<input type="hidden" id="real_<?= $id; ?>" name="<?= $config['name']; ?>" value="<?= $selectedYear . '-' . $selectedMonth . '-' . $selectedDay; ?>">

<script>
document.addEventListener("DOMContentLoaded", function() {
    const yearSelect = document.getElementById("year_<?= $id; ?>");
    const monthSelect = document.getElementById("month_<?= $id; ?>");
    const daySelect = document.getElementById("day_<?= $id; ?>");
    const hiddenInput = document.getElementById("real_<?= $id; ?>");

    function updateDays() {
        let year = parseInt(yearSelect.value);
        let month = parseInt(monthSelect.value);
        let daysInMonth = new Date(year, month, 0).getDate();

        // Simpan nilai sebelumnya
        let selectedDay = parseInt(daySelect.value) || <?= (int) $selectedDay; ?>;

        // Reset isi dropdown tanggal
        daySelect.innerHTML = "";
        for (let d = 1; d <= daysInMonth; d++) {
            let option = document.createElement("option");
            option.value = d.toString().padStart(2, "0");
            option.textContent = d;
            if (d === selectedDay) option.selected = true;
            daySelect.appendChild(option);
        }

        // Jika tanggal sebelumnya lebih besar dari jumlah hari di bulan yang dipilih
        if (selectedDay > daysInMonth) {
            daySelect.value = daysInMonth.toString().padStart(2, "0");
        }
    }

    function updateHiddenInput() {
        let selectedYear = yearSelect.value;
        let selectedMonth = monthSelect.value;
        let selectedDay = daySelect.value.padStart(2, "0");
        let fullDate = `${selectedYear}-${selectedMonth}-${selectedDay}`;
        hiddenInput.value = fullDate;
    }

    // Event Listeners
    yearSelect.addEventListener("change", function() {
        updateDays();
        updateHiddenInput();
    });

    monthSelect.addEventListener("change", function() {
        updateDays();
        updateHiddenInput();
    });

    daySelect.addEventListener("change", updateHiddenInput);

    // Initial Setup
    updateDays();
    updateHiddenInput();
});
</script>
