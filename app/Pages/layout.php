<?= $this->extend('layouts/mobile') ?>

<!------------------------------------------------>

<?php $this->section('content') ?>

<!-- Alpinejs app container -->
<div id="app" x-data></div>

<!-- Pinecone Routers -->
<div id="router" x-data="router()">
    <?= ltrim(renderRouter(App\Pages\Router::$router)) ?>
</div>

<?php $this->endSection() ?>

<!------------------------------------------------>

<?php $this->section('script') ?>
<script>
    let base_url = `<?= base_url() ?>`

    document.addEventListener('alpine:init', () => {
        
        // Setup Pinecone Router
        window.PineconeRouter.settings({
			basePath: '/',
			targetID: 'app',
		})
        
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
        });
        
        Alpine.data('router', () => ({
            isLoggedIn(context){
                if(! localStorage.getItem('heroic_token')){
                    context.redirect('/masuk')
                }
            }
        }))
    })
    

    Fancybox.bind('[data-fancybox="gallery"]', {});
    // Check that service workers are supported
    if ('serviceWorker' in navigator) {
        // Use the window load event to keep the page load performant
        window.addEventListener('load', () => {
            navigator.serviceWorker.register(`/sw_masagi.js`);
            window.console.log('Service-worker registered');
        });
    } else {
        window.console.debug('Service-worker not supported');
    }
</script>
<?php $this->endSection() ?>
