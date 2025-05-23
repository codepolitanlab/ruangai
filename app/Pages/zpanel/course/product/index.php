<?= $this->extend('layouts/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $page_title ?></h3>
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/zpanel/course">Course</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="/zpanel/course/lesson/1" class="btn btn-primary"><i class="bi bi-save"></i> Manage Lessons</a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-save"></i> Save Courses</button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="list-group list-group-horizontal-sm text-center w-25" role="tablist">
            <a href="/zpanel/course/form" class="list-group-item list-group-item-action border-0 rounded-0">Course</a>
            <a href="/zpanel/course/product" class="list-group-item list-group-item-action border-0 rounded-0 active">Product</a>
        </div>
        <div class="tab-content mb-5" id="myTabContent">
            <div class="tab-pane card fade show active" id="product" role="tabpanel" aria-labelledby="product-tab" style="border-top:0; border-radius: 0 10px">
                <div class="card-body">

                    <style>
                        th {
                            color: #666 !important;
                            font-weight: 600;
                            font-size: 14px;
                            padding: 10px 10px !important;
                        }

                        th.sorted {
                            color: #fe974b !important;
                            font-weight: 700;
                        }

                        .no-border-top td {
                            border-top: 0;
                            padding-top: 0;
                        }

                        .select2-container .select2-selection--single {
                            height: 31px !important;
                        }
                    </style>

                    <div class="card rounded shadow">
                        <div class="card-body">

                            <form>
                                <section class="mb-2">
                                    <div class="mb-4">
                                        <a href="/zpanel/course/product/form" class="btn btn-success rounded shadow-sm">
                                            <span class="bi bi-plus"></span>
                                            <span class="d-none d-sm-inline">Tambah Course Product</span>
                                        </a>


                                    </div>

                                    <div class="row gx-3 align-items-center">
                                        <div class="col-auto">
                                            <div class="mb-2 px-1 pe-3 border-end py-2"><strong>Total baris: 1</strong></div>
                                        </div>


                                    </div>
                                </section>

                                <div class="table-responsive">
                                    <table class="table table-hover  table-sm">
                                        <thead>
                                            <tr style="background-color: #eee;">
                                                <th width="60px">No.</th>

                                                <th class="">
                                                    Nama Produk </th>
                                                <th class="">
                                                    Harga </th>
                                                <th class="">
                                                    Harga Coret </th>
                                                <th class="">
                                                    Durasi </th>
                                                <th class="">
                                                    Harga Default? </th>


                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr>
                                                <td>1</td>


                                                <td>
                                                    <span class="">Lifetime</span>
                                                </td>
                                                <td>
                                                    <div class="text-end text-nowrap">
                                                        <span class="">Rp 225.000,-</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-end text-nowrap">
                                                        <span class="">Rp 500.000,-</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    Selamanya </td>
                                                <td>
                                                    <span class="text-nowrap">
                                                        <span title="Yes" class="bi bi-check-circle text-success"></span> Yes </span>
                                                </td>


                                                <td class="text-end">
                                                    <div class="btn-group mb-1">


                                                        <a target="_self" href="/zpanel/entry/course_product/action/row/set_default/1" class="btn btn-sm btn-outline-secondary text-info set_default" title="Set Default">
                                                            <span class="bi bi-check text-success"></span> Set Default </a>
                                                    </div>

                                                    <div class="btn-group mb-1">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary text-secondary " data-url="zpanel/entry/course_product/detail/1" data-bs-caption="Detail data" data-bs-toggle="modal" data-bs-target="#detailModal" title="Detail"><span class="bi bi-search"></span> Detail</button>

                                                        <a class="btn btn-sm btn-outline-secondary text-success " href="/zpanel/entry/course_product/edit/1?filter[course_id]=1" title="Edit"><span class="bi bi-pencil"></span> Edit</a>

                                                        <a data-no-swup="" class="btn btn-sm btn-outline-secondary text-danger " onclick="return confirm('Yakin akan menghapus?')" href="/zpanel/entry/course_product/delete/1?filter[course_id]=1" title="Delete"><span class="bi bi-remove"></span> Hapus</a>
                                                    </div>
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>

                            </form>

                            <div class="pagination">
                            </div>

                        </div>
                    </div>

                    <!-- Detail Modal -->
                    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-white text-dark">
                                    <h5 class="modal-title" id="detailModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="ratio ratio-16x9">
                                    <iframe id="detailIframe" src="#" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        $('#detailModal').on('show.bs.modal', function(event) {
                            var modalButton = $(event.relatedTarget);
                            var caption = $(event.relatedTarget).data('caption');
                            var url = `/` + $(event.relatedTarget).data('url');
                            $('#detailModalLabel').html(caption);
                            $('#detailIframe').attr('src', url);
                        })
                        window.closeModal = function() {
                            $('#detailModal').modal('hide');
                            window.location.reload();
                        };
                    </script>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->