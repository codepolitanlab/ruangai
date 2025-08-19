<?= $this->extend('layouts/mobile') ?>

<!------------------------------------------------>

<?php $this->section('content') ?>

<!-- Alpinejs app container -->
<div id="app" x-data></div>

<!-- Pinecone Routers -->
<div id="router" x-data="router()" x-handler.global="[globalHandler]">
    <?= ltrim(renderRouter(App\Pages\Router::$router)) ?>
</div>

<?= $this->include('partials/reload_alert') ?>

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
            showReloadAlert: false,
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
            pageWithReloadAlert: [
                "/",
                "/courses/intro/1/dasar-dan-penggunaan-generative-ai",
                "/courses/intro/1/dasar-dan-penggunaan-generative-ai/live_session"
            ],

            isLoggedIn(context, controller){
                if(! localStorage.getItem('heroic_token')){
                    // this.$router.navigate('/masuk')
                    window.location.replace('https://ruangai.id/signin')
                }
            },
            globalHandler(ctx) {
                // Show reload alert if the page is in the list
                if(this.pageWithReloadAlert.includes(ctx.path)){
                    Alpine.store('core').showReloadAlert = true;
                } else {
                    Alpine.store('core').showReloadAlert = false;
                }
            }
        }))
    })


    Fancybox.bind('[data-fancybox="gallery"]', {});

    // Register Service Worker
    // and Web Push Notification
    const publicKey = 'BDSkwRKMHK7WT6hTXe7oj0OJ6q9pqIX61tjZc4jR9b7ldszNsmRb1AbAVVFPxUerbhsOaV9Xa-99IEgUHzr2IcM';
    let swRegistration = null;

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
        const rawData = atob(base64);
        return Uint8Array.from([...rawData].map(char => char.charCodeAt(0)));
    }

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register(`/sw.js`).then(registration => {
                console.log('Service worker registered.');
                swRegistration = registration;
            }).catch(err => {
                console.error('Service worker registration failed:', err);
            });
        });
    } else {
        console.debug('Service-worker not supported');
    }

    async function subscribeToPush() {
        if (!swRegistration) {
            console.error('Service worker not yet registered');
            return;
        }

        try {
            const subscription = await swRegistration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(publicKey)
            });

            const formData = new FormData();
            formData.append('subscription', JSON.stringify(subscription));

            // Kirim menggunakan Axios
            const response = await axios.post('/api/push/register', formData);
            alert(response.data.status);
        } catch (err) {
            console.error('Push subscription error:', err);
        }
    }

</script>
<?php $this->endSection() ?>
