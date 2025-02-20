<div id="checkout" x-data="checkout($router.params.token)">
  <style>
    .item-shrink {
      max-height: 300px;
      overflow: hidden;
      padding-bottom: 20px !important;
    }

    .item-more {
      position: absolute;
      bottom: 0;
      left: 0;
      background: #fff;
      text-align: center;
      width: 100%;
      box-shadow: 0 -20px 10px #fff;
    }

    .btn-method btn-block {
      padding: 10px;
      border: 1px solid #ddd;
    }

    .img-payment-method {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
    }
  </style>

  <div id="app-header" class="appHeader bg-brand" style="max-width:768px">
    <div class="left"></div>
    <div class="pageTitle text-white"><span>Checkout</span></div>
    <div class="right"></div>
  </div>

  <div
    id="appCapsule"
    class="shadow"
    style="max-width:768px; background: url(<?= base_url('mobilekit/assets/img/bg-header-min.png'); ?>) no-repeat top left; background-size: contain">
    <div class="appContent" style="min-height:90vh">
      <div class="container mt-3">
        <div class="row">
          <div class="col-md-6">
            <div class="card mb-2">
              <div class="card-body position-relative" :class="showMoreItems ? `` : `item-shrink`" style="transition: .4s ease; padding-bottom: 60px;">
                <h5 class="me-auto text-secondary">Item</h5>
                <ul class="listview image-listview">
                  <template x-for="(item,index) in cart" :key="index">
                    <li>
                      <div class="item px-0">
                        <div class="icon-box bg-info" title="iuran">
                          <i class="bi bi-receipt text-white"></i>
                        </div>
                        <div class="w-100">
                          <div>
                            <h5 class="fs-6 mb-0 text-secondary" x-text="item.title">title</h5>
                            <h5 class="mb-1 text-muted" x-text="item.subtitle">subtitle</h5>
                            <div class="d-flex justify-content-between">
                              <div class="text-muted" x-text="`Rp ` + convertRupiah(item.price) + ` x ` + item.qty"></div>
                              <div class="fs-6 text-primary" x-text="`Rp ` + convertRupiah(item.total)">Rp0</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </template>
                </ul>
                <div class="item-more" x-show="cart.length > 2">
                  <button
                    class="btn btn-link text-secondary"
                    x-on:click="showMoreItems = !showMoreItems"
                    x-html="showMoreItems ? `Lipat kembali <i class='bi bi-arrow-bar-up ms-1'></i>` : `Tampilkan ${cart.length-2} lainnya..`">
                    Tampilkan lainnya..
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card mb-2">
              <div class="card-body pb-0">
                <h5 class="me-auto text-secondary">Detail Pembayaran</h5>
              </div>
              <ul class="listview flush transparent simple-listview">
                <li>
                  <div class="fs-6 text-dark-emphasis">Items <span class="text-muted" x-text="`(` + cart.length + `)`"></span></div>
                  <div class="fs-6 text-primary" x-text="`Rp ` + convertRupiah(subtotal)">Rp 0</div>
                </li>
                <li>
                  <div class="fs-6 text-dark-emphasis">Biaya Admin</div>
                  <div class="fs-6 text-primary" x-text="`Rp ` + convertRupiah(adminFee)">Rp 0</span>
                </li>
                <li>
                  <div class="fs-6 text-dark-emphasis">Total</div>
                  <span class="text-primary fw-bold" x-text="`Rp ` + convertRupiah(total)">Rp 0</span>
                </li>
              </ul>

              <div class="card-body">
                <div class="card border shadow-sm" :class="methodChosen ? 'border-success' : 'border-primary'">
                  <ul class="listview flush transparent image-listview">
                    <li class="m-0">

                      <!-- Button Choose Payment Method first time -->
                      <a x-show="!methodChosen" native href="javascript:void()" class="item" data-bs-toggle="modal" data-bs-target="#choosePaymentMethodModal">
                        <div class="icon-box bg-success">
                          <i class="bi bi-coin text-white"></i>
                        </div>
                        <div class="in">
                          <div class="text-secondary">Pilih Metode Pembayaran</div>
                        </div>
                      </a>
                      <!-- Button Chosen Payment Method  -->
                      <a x-show="methodChosen" native href="javascript:void()" class="item gap-1 text-center" data-bs-toggle="modal" data-bs-target="#choosePaymentMethodModal">
                        <img :src="paymentMethods[methodChosen]?.thumbnail" alt="paymentMethods[methodChosen].name + ' thumbnail'" style="max-width:64px">
                        <div class="justify-content-center in">
                          <div class="text-secondary" x-text="paymentMethods[methodChosen]?.label"></div>
                        </div>
                      </a>


                      <div class="bg-primary bg-opacity-10">
                        <ul class="listview image-listview media bg-primary bg-opacity-10">
                          <li>
                            <div class="item px-4">
                              <div class="imageWrapper me-1">
                                <img src="/mobilekit/assets/img/icon-secure-min.png" class="imaged w64" alt="secure">
                              </div>
                              <div class="in">
                                <div>
                                  <small class=" text-secondary fw-bold mb-1">Secure Payment</small>
                                  <h6 class="text-secondary mb-1">All of your payments are RSA security encryption</h6>
                                </div>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>

                <div class="mt-5">
                  <button :class="submitCheckout ? 'btn-progress' : ''" class="btn btn-lg btn-block btn-commit" :disabled="adminFee < 1" x-on:click="doCheckout">
                    BAYAR &middot;&nbsp; <span x-text="`Rp ` + convertRupiah(total)">Rp 0</span>
                  </button>
                </div>

                <!-- Modal payment methods -->
                <div class="modal fade" tabindex="-1" id="choosePaymentMethodModal">
                  <?= $this->include('checkout/_choosePaymentMethod') ?>
                </div>
                <!-- END Modal payment methods -->

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>