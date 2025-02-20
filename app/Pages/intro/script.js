// Page intro
window.intro = function() {
    return {
        title: "Intro",
        swiper: null,
        init(){
            document.title = this.title
            Alpine.store('masagi').currentPage = 'intro'
            
            this.swiper = new Swiper(".swiper-intro", {
                slidesPerView: 1,
                spaceBetween: 20,
                autoplay: {
                    delay: 5000,
                    pauseOnMouseEnter: true
                },
                pagination: {
                    el: ".swiper-pagination"
                }
            });
        },
        gotoLogin(){
            localStorage.setItem('intro', 1)
            return window.PineconeRouter.context.navigate("/login");
        }
    }
}