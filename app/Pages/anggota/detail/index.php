<div id="anggota_detail" x-data="anggota_detail($router.params.id)">
  <style>
    .avatar-detail{ width: 180px; height: 180px; border-radius: 50%; background-size: cover; margin: 0 auto 20px;}
  </style>

  <div class="appHeader bg-brand">
    <div class="left">
      <a href="javascript:void()" onclick="history.back()" class="headerButton text-white">
        <ion-icon name="chevron-back-outline"></ion-icon>
      </a>
    </div>
    <div class="pageTitle"></div>
    <div class="right">
    </div>
  </div>

  <section class="section-top full pb-1 mb-3 text-muted">
    <div class="bg-brand" style="height:160px;"></div>
    <div class="pt-5 pb-4 text-center" style="margin-top:-115px;">

      <div class="d-flex-column placeholder-wave" x-show="data.loading">
        <div class="placeholder rounded-circle mb-4" style="width: 148px; height: 148px;"></div><br>
        <div class="placeholder placeholder-lg px-4 w-50 mb-2"></div>
        <div class="placeholder placeholder-lg px-4 w-75"></div>
      </div>

      <div x-show="data.loading === false" style="display: none;">
        <a :href="data.member.avatar" data-fancybox="gallery">
          <div class="avatar-detail" :style="`background-image: url('${ data.member.avatar ? data.member.avatar : 'https://image.web.id/images/avatar-male.png' }')`"></div>
        </a>
        <h5 class="px-4 text-uppercase" x-text="data.member.name"></h5>
        <h6 class="text-muted px-4 fst-italic" x-text="data.member.short_description"></h6>
        <div class="mb-4 px-4">
          <div>NPA: <span x-text="data.member.username"></span></div>
          <div>PC: <span x-text="data.member.nama_pc"></span></div>
          <div>Profesi: <span x-text="data.member.jobs"></span></div>
        </div>

       
        <!-- <div class="listview-title mt-2">Tagihan Iuran Anggota</div>
        <ul class="listview image-listview">
          <template x-for="(tagihan,tagihanIndex) in data.tagihan.unpaid">
            <li>
              <div class="item">
                <div class="icon-box">
                  <input type="checkbox"
                    style="width:1.4rem;height:1.4rem"
                    :id="tagihanIndex"
                    x-on:click="selectBill(tagihanIndex)"
                    :checked="Alpine.store('cart').cart[tagihanCategoryID].includes(tagihanIndex)">
                </div>
                <div class="in">
                  <div x-text="tagihan.title"></div>
                  <small x-text="`Rp ` + convertRupiah(tagihan.amount)"></small>
                </div>
              </div>
            </li>
          </template>
        </ul>

        <div class="listview-title mt-2">Iuran Anggota Lunas</div>
        <ul class="listview image-listview">
          <template x-for="tagihan in data.tagihan.paid">
            <li>
              <div class="item bg-success bg-opacity-25">
                <div class="icon-box bg-success text-white">
                  <i class="bi bi-check fs-1"></i>
                </div>
                <div class="in">
                  <div x-text="tagihan.title"></div>
                  <small x-text="`Rp ` + convertRupiah(tagihan.amount)"></small>
                </div>
              </div>
            </li>
          </template>
        </ul> -->

      </div>

    </div>