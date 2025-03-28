<?= $this->extend('template/mobile') ?>

<!-- START Content Section -->
<?php $this->section('content') ?>

    <!-- Alpinejs Routers -->
    <div id="app" x-data></div>

    <?= $this->include('router') ?>

<?php $this->endSection() ?>
<!-- END Content Section -->


<?php $this->section('script') ?>
<script>
document.addEventListener('alpine:init', () => {
    
    // Setup Pinecone Router
    window.PineconeRouter.settings.basePath = '/';
    window.PineconeRouter.settings.templateTargetId = 'app';
    window.PineconeRouter.settings.includeQuery = false;
    
    NProgress.configure({ showSpinner: false });
    document.addEventListener('pinecone-start', () => {
        NProgress.start();
    });
    document.addEventListener('pinecone-end', () => {
        NProgress.done();
    });
    document.addEventListener('fetch-error', (err) => console.error(err));

    // Global store
    Alpine.store('core', {
        currentPage: 'home',
        showBottomMenu: true,
        sessionToken: null,
        settings: {},
        user: {},
        async getSiteSettings() {
            if(Object.keys(Alpine.store('core').settings).length < 1){
                try{
                    await axios.get('/_components/common/settings', {
                        headers: {
                            'Authorization': `Bearer ` + localStorage.getItem('heroic_token'),
                        }
                    })
                    .then(response => {
                        Alpine.store('core').settings = response.data.settings
                        Alpine.store('core').user = response.data.user
                    })
                    .catch(error => {
                        console.log(error);
                    });
                } catch (error) {
                    // Tangani error jika terjadi masalah pada saat fetching data
                    console.error('Error fetching site settings:', error);
                }
            }
        }
    })

})
</script>
<?php $this->endSection() ?>
