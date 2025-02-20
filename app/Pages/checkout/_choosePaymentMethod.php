<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Pilih Metode Pembayaran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <!-- E-Wallet -->
            <template x-for="(pMethods,categoryName) in paymentMethodCategories">
            <div class="border-bottom mb-2">
                <div class="section-title mb-2" x-text="categoryName"></div>
                <div class="row">
                    <template x-for="methodName in pMethods">
                        <div class="col-6 mb-1">
                            <button 
                                type="button" class="btn-method btn-block btn btn-outline-secondary btn-lg" 
                                x-on:click="setPaymentMethod(methodName)" 
                                :title="paymentMethods[methodName].label">
                                <img :src="paymentMethods[methodName]?.thumbnail" class="img-payment-method">
                            </button>
                        </div>
                    </template>
                </div>
            </div>
            </template>

        </div>
    </div>
</div>