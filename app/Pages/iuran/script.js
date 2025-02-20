// Page iuran
document.addEventListener('alpine:init', () => {
  Alpine.data('iuran', () => ({
    title: "Iuran",
    data: {
      bills: [],
      unpaid_amount: 0,
    },
    selectedBill: [],
    loading: false,
    process: false,
    totalBill: 0,

    init() {      
      if(localStorage.getItem('intro') != 1){
        window.PineconeRouter.context.redirect('/intro');
      }
      
      document.title = this.title;
      Alpine.store('masagi').currentPage = 'iuran'
      
      this.loading = true;
      
      if(cachePageData['iuran']){
        this.data.bills = cachePageData['iuran']['bills'];
        this.data.unpaid_amount = cachePageData['iuran']['unpaid_amount'];
        this.loading = false;
      } else {   
        fetchPageData('iuran/listTagihan', {
          headers: {
            'Authorization': `Bearer ` + localStorage.getItem('heroic_token'),
          }
        })
        .then(response => {
          if (response.found == 1) {
            this.data.bills = response.data.bills;
            this.data.unpaid_amount = response.data.unpaid_amount;
            cachePageData['iuran'] = response.data;
          }
        })
        .catch(err => {
          console.error(err)
        })
        .finally(() => (this.loading = false));
      }
    },

    convertRupiah(amount) {
      return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    selectBill(bill, checked) {
      if (checked) {
        this.selectedBill.push(bill);
        this.totalBill += parseInt(bill.amount);
      } else {
        this.selectedBill.map((selected, index) => {
          if (selected.id == bill.id) {
            this.selectedBill.splice(index, 1);
            this.totalBill -= parseInt(bill.amount);
          }
        });
      }
    },

    setDetail(id) {
      const detail = this.data.bills.find((bill) => bill.id === id);
      document.getElementById("bill_type").innerHTML = detail.title;
      document.getElementById("name").innerHTML = detail.name;
      document.getElementById("created_at").innerHTML = detail.start_date;
      document.getElementById("due_date").innerHTML = detail.due_date;
      document.getElementById("nis").innerHTML = detail.nis;
      let status = document.getElementById("status");

      if (detail.status == "pending") {
        status.innerHTML = `<span class="badge bg-orange ms-auto">Belum Lunas</span>`;
      } else {
        status.innerHTML = `<span class="badge bg-success-4 ms-auto">Lunas</span>`;
      }
    },
    
    checkout() {
      this.process = true;

      // Check login using axios post
      const formData = new FormData();
      formData.append("cart", JSON.stringify(this.selectedBill));
      axios
        .post("/iuran", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(response => {
          if(response.data.found == 1) {
            const token = btoa(response.data.token)
            window.PineconeRouter.context.navigate('/checkout/' + token)
          }
        })
        .catch((error) => console.log(error))
    },

  }))
})