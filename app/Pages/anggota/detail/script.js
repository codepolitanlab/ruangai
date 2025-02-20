// Page anggota/detail
document.addEventListener('alpine:init', () => {
  Alpine.data('anggota_detail', (id) => ({
    title: 'Detail Anggota',
    data: {
      member: {},
      tagihan: [],
      loading: false
    },
    tagihanCategoryID: 1, // cart Anggota
    tagihanChecked: [],
    totalAmount: 0,
    idleSelecting: null,

    init() {
      document.title = this.title;
      this.data.loading = true;

      if (cachePageData[`anggota_detail_`+id]) {
        this.data.member = cachePageData[`anggota_detail_`+id].member;
        this.data.tagihan = cachePageData[`anggota_detail_`+id].tagihan;
        this.data.loading = false;
      } else {
        fetchPageData(`/anggota/detail/supply/` + id)
        .then((response) => {
          window.console.log(response);
          if (response.response_code == 404) {
            // Do nothing
          } else {
            this.data.member = response.member;
            this.data.tagihan = response.tagihan;
            cachePageData[`anggota_detail_`+id] = this.data;
            document.title = this.data.member.name;
          }

          this.data.loading = false;
        })
        .catch((error) => console.log(error))
        .finally(() => (this.data.loading = false));
      }
    },

    convertRupiah(amount) {
      return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    selectBill(index) {
      if (Alpine.store('cart').cart[this.tagihanCategoryID].includes(index)) {
        Alpine.store('cart').cart[this.tagihanCategoryID] = Alpine.store('cart').cart[this.tagihanCategoryID].filter(i => i !== index);
      } else {
          Alpine.store('cart').cart[this.tagihanCategoryID].push(index);
      }

      Alpine.store('cart').totalCart = Object.values(Alpine.store('cart').cart).reduce((total, arr) => total + arr.length, 0);

      clearTimeout(this.idleSelecting); // Hapus timer yang sedang berjalan
      this.idleSelecting = setTimeout(this.addToCart, 1000);
    },

    // Cart disimpan di localStorage
    addToCart(){
      localStorage.setItem('cart', JSON.stringify(Alpine.store('cart').cart));
      toastr.success('Tagihan berhasil ditambahkan ke keranjang', null, { preventDuplicates: true, positionClass: "toast-bottom-full-width" });
    },
  }));
});
