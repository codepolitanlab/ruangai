<div id="anggota" x-data="anggota()">
  <style>
    .item .avatar {
      min-width: 48px !important;
      max-width: 48px !important;
      width: 48px !important;
      height: 48px !important;
      object-fit: cover;
      object-position: top;
    }
  </style>

  <div id="app-header" class="appHeader main bg-brand">
    <div class="left"></div>
    <div class="pageTitle text-white"><span>Direktori Anggota</span></div>
    <div class="right"></div>
  </div>

  <div id="appCapsule" class="shadow">
    <div class="appContent" style="min-height:90vh">

      <section class="section-top full pb-1 mb-3 text-muted">
        <div class="bg-brand" style="height:20px"></div>
        <div class="py-4 rounded-top-4 bg-white" style="margin-top:-10px;">
          <div class="d-flex gap-2 mb-2 px-3">
            <div class="input-group">
              <span class="input-group-text text-secondary border rounded-start ps-1">
                <i class="bi bi-search"></i>
              </span>
              <input x-model="data.searchValue" type="text" class="form-control border-start-0 px-0" placeholder="Cari Anggota/Nama PC">
            </div>
          </div>

          <div x-show="data.members.length == 0 &amp;&amp; !data.searchValue" class="text-center mt-4" style="display: none;">Belum ada data anggota</div>
          <div x-show="filteredMember().length == 0 &amp;&amp; data.searchValue" class="text-center mt-4" style="display: none;">Pencarian tidak ditemukan</div>
          <div x-show="filteredMember().length > 0" class="text-end mx-3 my-2" x-text="`Total: ` + filteredMember().length"></div>

          <ul class="listview image-listview">

            <template x-for="member in filteredMember()">
              <li>
                <a :href="`/anggota/` + member.id" class="item">
                  <img x-bind:src="member.avatar ? member.avatar : 'https://image.web.id/images/avatar-male.png'" class="image avatar" alt="Avatar">
                  <div class="in">
                    <div>
                      <span class="text-uppercase fs-6" x-text="member.name">[name]</span>
                      <footer class="text-secondary mt-0" x-text="member.nama_pc">[pc]</footer>
                    </div>
                  </div>
                </a>
              </li>
            </template>

          </ul>
        </div>

        <div class="offcanvas offcanvas-bottom h-75 rounded-top-4" tabindex="-1" id="offcanvasFilter" aria-labelledby="offcanvasFilterLabel">
          <div class="offcanvas-header shadow-none d-flex justify-content-center">
            <div class="w-25 bg-primary rounded-pill" style="padding:1.5px;"></div>
          </div>
          <div class="offcanvas-body p-4 d-flex flex-column justify-content-between">
            <div>
              <h5>Lokasi</h5>
              <div class="d-flex flex-wrap gap-2">
                <div @click="setFilter('location', 'Bandung')" class="rounded-3 px-3 py-1 border border-secondary-subtle" x-bind:class="data.active.location == 'Bandung' &amp;&amp; 'active'" role="button">Bandung</div>
                <div @click="setFilter('location', 'Jakarta')" class="rounded-3 px-3 py-1 border border-secondary-subtle" x-bind:class="data.active.location == 'Jakarta' &amp;&amp; 'active'" role="button">Jakarta</div>
                <div @click="setFilter('location', 'Bekasi')" class="rounded-3 px-3 py-1 border border-secondary-subtle" x-bind:class="data.active.location == 'Bekasi' &amp;&amp; 'active'" role="button">Bekasi</div>
                <div @click="setFilter('location', 'Garut')" class="rounded-3 px-3 py-1 border border-secondary-subtle" x-bind:class="data.active.location == 'Garut' &amp;&amp; 'active'" role="button">Garut</div>
                <div @click="setFilter('location', 'Cianjur')" class="rounded-3 px-3 py-1 border border-secondary-subtle" x-bind:class="data.active.location == 'Cianjur' &amp;&amp; 'active'" role="button">Cianjur</div>
                <div @click="setFilter('location', 'Sukabumi')" class="rounded-3 px-3 py-1 border border-secondary-subtle" x-bind:class="data.active.location == 'Sukabumi' &amp;&amp; 'active'" role="button">Sukabumi</div>
                <div @click="setFilter('location', 'Bandung Barat')" class="rounded-3 px-3 py-1 border border-secondary-subtle" x-bind:class="data.active.location == 'Bandung Barat' &amp;&amp; 'active'" role="button">Bandung Barat</div>
              </div>
            </div><button class="btn btn-lg btn-primary w-100">TAMPILKAN USAHA</button>
          </div>
        </div>
      </section>
    </div>
  </div>

</div>