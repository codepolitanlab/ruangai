<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('<?= $schema['name'] ?>_entry_table', function() {
        return {
            filters: {
                <?php foreach ($schema['searchable'] as $column) { ?>
                <?= $column ?>: '',
                <?php } ?>
            },

            visibleColumns: this.$persist({
                <?php foreach ($schema['hideable'] as $column) { ?>
                <?= $column ?>: true,
                <?php } ?>
            }).as(`<?= $schema['name'] ?>VisibleColumns`),

            labelMap: {
                <?php foreach ($schema['fields'] as $key => $field) { ?>
                <?= $key ?>: '<?= $field['label'] ?? ucfirst(str_replace('_', ' ', $key)) ?>',
                <?php } ?>
            },

            loading: false,
            page: 1,
            perpage: <?= $schema['rowsPerPage'] ?? 5 ?>,
            timeout: null,
            orderBy: `<?= $schema['default_sorting'][0] ?? 'id' ?>`,
            sort: `<?= $schema['default_sorting'][1] ?? 'asc' ?>`,

            resetFilter() {
                this.filters = {
                    <?php foreach ($schema['searchable'] as $column): ?>
                    <?= $column ?>: '',
                    <?php endforeach; ?>
                };
                this.page = 1;
                this.loadTable();
            },

            resetVisible()
            {
                this.visibleColumns = {
                    <?php foreach ($schema['hideable'] as $column) { ?>
                    <?= $column ?>: true,
                    <?php } ?>
                };
                this.loadTable();
            },

            setSort(field) {
                if (this.orderBy == field) {
                    if (this.sort == 'asc')
                        this.sort = 'desc'
                    else
                        this.sort = 'asc'
                }
                this.orderBy = field
            },

            async loadTable() {
                this.loading = true;
                const params = new URLSearchParams();
                params.append(`tableBody`, 1);

                // Encode filter as filter[nama]=... etc
                for (const key in this.filters) {
                    params.append(`filter[${key}]`, this.filters[key]);
                }

                for (const key in this.visibleColumns) {
                    if (this.visibleColumns[key]) {
                        params.append(`visible[${key}]`, '1');
                    }
                }

                params.append('page', this.page);
                params.append('perpage', this.perpage);
                params.append('orderby', this.orderBy);
                params.append('sort', this.sort);

                const response = await fetch(`<?= site_url(urlScope() . $schema['base_url']) ?>` + `?${params}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = await response.text();
                this.$refs.tableBody.innerHTML = html;
                this.loading = false;
            }
        }
    });
});
</script>