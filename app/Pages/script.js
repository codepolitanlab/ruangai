// Script untuk halaman utama member

// Alpine data function
document.addEventListener('alpine:init', () => {

    NProgress.configure({ showSpinner: false });

    Alpine.data("router", () => ({
        async init(){
            document.title = this.title;
            Alpine.store('masagi').sessionToken = localStorage.getItem('heroic_token')
            await Alpine.store('masagi').getSiteSettings()
        },

        // Check login session, dipanggil oleh x-handler template yang meemerlukan session
        isLoggedIn(context){
            if(localStorage.getItem('intro') != 1) return context.redirect('/intro')
            if(Alpine.store('masagi').sessionToken == null) return context.redirect('/masuk')
        },

        notfound(context) {
            document.querySelector('#app').innerHTML = `<h1>Not Found</h1>`
        },
    }))

    // Setup Pinecone Router
    window.PineconeRouter.settings.basePath = '/';
    window.PineconeRouter.settings.includeQuery = false;
    
    document.addEventListener('pinecone-start', () => {
        NProgress.start();
        Alpine.store('masagi').pageLoaded = false
    });
    document.addEventListener('pinecone-end', () => {
        NProgress.done();
        Alpine.store('masagi').pageLoaded = true;
    });
    document.addEventListener('fetch-error', (err) => console.error(err));

    // Global store
    Alpine.store('masagi', {
        currentPage: 'home',
        pageLoaded: false,
        showBottomMenu: true,
        sessionToken: null,
        settings: {},
        user: {},
        async getSiteSettings() {
            if(Object.keys(Alpine.store('masagi').settings).length < 1){
                try{
                    await axios.get('/_components/common/settings', {
                        headers: {
                            'Authorization': `Bearer ` + localStorage.getItem('heroic_token'),
                        }
                    })
                    .then(response => {
                        Alpine.store('masagi').settings = response.data.settings
                        Alpine.store('masagi').user = response.data.user
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

//****************************************************************** */
// Animated header style on scroll
//****************************************************************** */
window.animatedScroll = function() {
    var appHeader = document.querySelector(".appHeader.scrolled");
    var scrolled = window.scrollY;
    if (scrolled > 20) {
        appHeader.classList.add("is-active")
    }
    else {
        appHeader.classList.remove("is-active")
    }
}

// Variabel untuk melacak offcanvas yang sedang terbuka
window.openOffcanvas = null;
window.openModal = null;
window.historyStateAdded = false;

document.addEventListener('pinecone-end', () => {
    var appHeader = document.querySelector(".appHeader.scrolled");
    if (document.body.contains(appHeader)) {
        animatedScroll();
        document.addEventListener("scroll", function () {
            animatedScroll()
        })
    }
});