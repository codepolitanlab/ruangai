<style>
    th.sortable {
        cursor: pointer;
    }
    th.sortable:hover {
        background-color: #e8eaffa4;
    }

    th.sortable.asc:before {
        content: "▲ ";
        color: #ccc;
    }

    th.sortable.desc:before {
        content: "▼ ";
        color: #ccc;
    }
</style>

<script src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js" defer></script>

</script>


<section class="section">
    <div class="card rounded-4 shadow-0">
        <div class="card-body table-responsive">

            <div x-data="<?= $schema['name'] ?>_entry_table()" x-init="loadTable()">

                <div class="d-flex justify-content-end align-items-center gap-2 mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span>perbaris: </span>
                        <select id="perpage" x-model="perpage" class="form-select form-select-sm" @change="page=1; loadTable()">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="150">150</option>
                            <option value="200">200</option>
                        </select>
                    </div>

                    <div class="dropdown">
                        <button
                            class="btn btn-sm btn-outline-secondary dropdown-toggle"
                            type="button"
                            data-bs-auto-close="outside"
                            data-bs-toggle="dropdown">
                            Pilih Kolom
                        </button>
                        <ul class="dropdown-menu" style="min-width: 130px;">
                            <li class="text-end">
                                <button class="btn btn-sm btn-link" @click="resetVisible()">Pilih Semua</button>
                            </li>
                            <template x-for="(visible, key) in visibleColumns" :key="key">
                                <li>
                                    <label class="dropdown-item d-flex align-items-center gap-2 px-2">
                                        <input type="checkbox"
                                            class="form-check-input"
                                            @change="loadTable()"
                                            x-model="visibleColumns[key]">
                                        <span x-text="labelMap[key] || key"></span>
                                    </label>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th
                                class="sortable"
                                :class="orderBy==`<?= $schema['primary_key'] ?? 'id' ?>` ? sort : ``"
                                    @click="setSort('<?= $schema['primary_key'] ?? 'id' ?>'); loadTable()">
                                    ID
                            </th>
                            <?php foreach ($schema['show_on_table'] as $column): ?>
                                <th
                                    class="<?= in_array($column, $schema['sortable'] ?? [], true) ? 'sortable' : '' ?>"
                                    :class="orderBy==`<?= $column ?>` ? sort : ``"
                                    @click="setSort('<?= $column ?>'); loadTable()"
                                    x-show="visibleColumns.<?= $column ?>"
                                    x-transition>
                                    <?= $schema['fields'][$column]['label'] ?? ucfirst(str_replace('_', ' ', $column)) ?>
                                </th>
                            <?php endforeach; ?>

                            <th class="text-end">Aksi</th>
                        </tr>

                        <tr class="filters">
                            <th></th>
                            <?php foreach ($schema['searchable'] as $column): ?>
                            <th x-show="visibleColumns.<?= $column ?>">
                                <input type="text" class="form-control" placeholder="Cari <?= $schema['fields'][$column]['label'] ?>" x-model="filters.<?= $column ?>" @keydown.enter="page=1; loadTable()" />
                            </th>
                            <?php endforeach; ?>
                            <th>
                                <div class="d-flex justify-content-end gap-1">
                                    <button class="btn btn-sm btn-outline-primary text-nowrap" @click="page=1; loadTable()"><i class="bi bi-search"></i> Filter</button>
                                    <button class="btn btn-sm btn-outline-secondary text-nowrap" @click="resetFilter()"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody x-ref="tableBody" x-show="!loading" x-transition.opacity>
                        <!-- akan diisi via ajax -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</section>

<?= $this->include('Heroicadmin\Modules\Entry\Views\script'); ?>