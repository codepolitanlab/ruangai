<div
    id="workshop"
    x-data="$heroic({
        title: `<?= $page_title ?>`,
        url: `workshop/data`
        })">

    <div class="text-center py-3">
        <h1>Welcome <span x-text="data.name"></span>!</h1>
    </div>

    <?= $this->include('_bottommenu'); ?>
</div>
