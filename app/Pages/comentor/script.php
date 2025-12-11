<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<script>
  Alpine.data("comentor", function() {
    return {
      title: "Co-Mentor",
      errorMessage: null,
      search: "", // keyword pencarian
      filteredMembers: [], // hasil filter
      sortOrder: "asc",

      init() {
        if(this.ui.empty === false) {
          this.filteredMembers = [...this.data.members].sort((a, b) => new Date(a.joined_at) - new Date(b.joined_at));
        }

        // auto filter saat ketik
        this.$watch("search", (val) => {
          this.filterMembers(val);
        });
        console.log(this.filteredMembers)
      },

      filterMembers(keyword) {
        if (!keyword) {
          this.filteredMembers = this.data?.members ?? [];
        } else {
          let lower = keyword.toLowerCase();
          this.filteredMembers = this.data?.members?.filter(m =>
            m.fullname.toLowerCase().includes(lower) ||
            m.email.toLowerCase().includes(lower) ||
            (m.whatsapp || "").toLowerCase().includes(lower)
          ) ?? [];
        }

        this.filteredMembers = members.sort((a, b) => {
          if (this.sortOrder === "asc") {
            return new Date(a.joined_at) - new Date(b.joined_at);
          } else {
            return new Date(b.joined_at) - new Date(a.joined_at);
          }
        });
      },

      sortMembers() {
        this.filteredMembers.sort((a, b) => {
          if (this.sortOrder === "asc") {
            return new Date(a.joined_at) - new Date(b.joined_at);
          } else {
            return new Date(b.joined_at) - new Date(a.joined_at);
          }
        });
      },

      copyToClipboard(text) {
        navigator.clipboard.writeText(`https://ruangai.id/cmref/${text}`);
        $heroicHelper.toastr("Link referral berhasil disalin ke clipboard", "success");
      },

      downloadCSV() {
        if (!confirm("Apakah Anda yakin ingin mengunduh data peserta?")) return;

        if (!this.filteredMembers.length) {
          $heroicHelper.toastr("Tidak ada data untuk diunduh", "warning");
          return;
        }

        try {
          // Buat header CSV
          const headers = ["Nama", "Email", "Whatsapp", "Status", "Progres", "Live Session"];

          // Mapping data ke baris CSV
          const rows = this.filteredMembers.map(member => {
            let status = "Masih Belajar";

            if (member.graduate == 1) status = "Tuntas";
            else if (member.progress == 100 && member.total_live_session >= 1) status = "Belum Klaim Sertifikat";
            else if (member.progress == 100 && member.total_live_session == 0) status = "Belum Live";
            else if (member.progress != 100 && member.total_live_session >= 1) status = "Belum Course";

            return [
              member.fullname,
              member.email,
              member.whatsapp || '',
              status,
              member.progress + '%',
              member.total_live_session + 'x'
            ];
          });

          // Generate filename
          const filename = `daftar_peserta_comentor_${this.data?.leader?.fullname}_${new Date().toISOString().split("T")[0]}.csv`;

          // === APPROACH 1: Direct Data URI (Paling reliable) ===
          const csvContent = headers.join(",") + "\n" +
            rows.map(row => row.map(cell => `"${cell}"`).join(",")).join("\n");

          // Tambahkan BOM untuk Excel
          const BOM = "\uFEFF";

          // Encode ke base64 untuk data URI
          const dataUri = 'data:text/csv;charset=utf-8,' + encodeURIComponent(BOM + csvContent);

          // Buat temporary link dan trigger download
          const downloadLink = document.createElement('a');
          downloadLink.href = dataUri;
          downloadLink.download = filename;

          // Prevent event propagation yang bisa ditangkap router
          downloadLink.addEventListener('click', (e) => {
            e.stopPropagation();
            e.stopImmediatePropagation();
          }, true);

          // Trigger click secara programmatic
          document.body.appendChild(downloadLink);
          downloadLink.click();
          document.body.removeChild(downloadLink);

          $heroicHelper.toastr("Data peserta berhasil diunduh", "success");

        } catch (error) {
          console.error('Download error:', error);
          $heroicHelper.toastr("Gagal mengunduh data. Silakan coba lagi.", "error");
        }
      }

    };
  });
</script>