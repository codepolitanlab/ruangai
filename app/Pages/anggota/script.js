// Page intro
document.addEventListener('alpine:init', () => {
  Alpine.data('anggota', () => ({
    title: 'Daftar Anggota',
    data: {
      members: [],
      loading: false,
      searchValue: "",
      active: {
        business: "",
        location: "",
      },
    },
    init() {
        document.title = this.title;
        Alpine.store('masagi').currentPage = 'anggota';
        this._fetchUsers();
    },
    filteredMember() {
      return this.data.members.filter((member) => {
        const searchLower = this.data.searchValue.toLowerCase();
        return (
          member.name.toLowerCase().includes(searchLower) ||
          member.nama_pc.toLowerCase().includes(searchLower)
        );
      });
    },
    _fetchUsers() {
      this.data.loading = true;

      let page = "anggota";
      if (cachePageData[`anggota`]?.length > 0) {
        this.data.members = cachePageData[`anggota`];
      } else {
        fetchPageData('anggota/supply')
        .then((response) => {
            if(response.found == 1) {
                cachePageData[`anggota`] = response.members;
                this.data.members = response.members;
                this.data.loading = false;
            }
        });
      }
    },
    
  }));
});
