<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">


    <section class="section">
        <div class="mb-3">
            <div class="row">
                <div class="col">
                    <h2>
                        Materi untuk: Ngonten Sakti dengan AI <a class="ms-2 btn btn-sm btn-white text-dark" title="Edit course settings" href="/zpanel/course/edit/1"><span class="bi bi-pencil"></span> Edit</a>
                        <a class="btn btn-sm btn-white text-dark" target="_blank" title="Preview course" href="/courses/learn/ngonten-sakti-dengan-ai?preview=true"><span class="bi bi-external-link"></span> Preview</a>
                    </h2>
                </div>
            </div>
        </div>
        <div class="card card-block block-editor p-3">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="toolbar-lesson d-flex justify-content-between mb-2">
                        <h4 class="mb-0">Topic list</h4>
                        <a href="/zpanel/course/manage_lessons/1/add_topic" class="btn btn-sm btn-secondary"><span class="bi bi-tag"></span> Add Topic</a>
                    </div>

                    <div class="sidebar-lesson" style="margin: 0 -15px; padding: 15px;">
                        <ul class="lesson-list list-unstyled">
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/zpanel/course/manage_lessons/1/edit_topic/1">Pengenalan</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/theory" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/quiz" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/zpanel/course/moveup_topic/1/1/1" style="visibility:hidden" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/zpanel/course/movedown_topic/1/1/1" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-1" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/1/1" data-title="Selamat Datang">
                                                    <span class="bi bi-unlock text-warning"></span>
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Selamat Datang </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/1/1/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/1/1/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-2" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/1/2" data-title="Kontrak Belajar">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Kontrak Belajar </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/1/2/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/1/2/2" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/zpanel/course/manage_lessons/1/edit_topic/2">02 - AI dan Perkembangannya</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/theory/2" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/quiz/2" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/zpanel/course/moveup_topic/1/2/2" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/zpanel/course/movedown_topic/1/2/2" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-3" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/2/3" data-title="Mengenal Artificial Intelligence">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Mengenal Artificial Intelligence </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/2/3/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/2/3/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-4" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/2/4" data-title="Sejarah Artificial Intelligence">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Sejarah Artificial Intelligence </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/2/4/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/2/4/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-5" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/2/5" data-title="AI dalam Teknologi Saat Ini">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    AI dalam Teknologi Saat Ini </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/2/5/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/2/5/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-6" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/2/6" data-title="Potensi dan Tantangan AI">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Potensi dan Tantangan AI </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/2/6/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/2/6/4"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-7" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/2/7" data-title="Prinsip Kreasi Konten dengan AI">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Prinsip Kreasi Konten dengan AI </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/2/7/5"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/2/7/5"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-8" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/2/8" data-title="ChatGPT dan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT dan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/2/8/6"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/2/8/6" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/zpanel/course/manage_lessons/1/edit_topic/3">Mengenal ChatGPT</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/theory/3" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/quiz/3" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/zpanel/course/moveup_topic/1/3/3" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/zpanel/course/movedown_topic/1/3/3" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-9" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/3/9" data-title="Berkenalan dengan ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Berkenalan dengan ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/3/9/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/3/9/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-10" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/3/10" data-title="Cara Kerja ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Cara Kerja ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/3/10/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/3/10/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-11" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/3/11" data-title="Kemampuan ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Kemampuan ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/3/11/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/3/11/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-12" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/3/12" data-title="Keterbatasan ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Keterbatasan ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/3/12/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/3/12/4"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-13" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/3/13" data-title="Membuat Akun ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Akun ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/3/13/5"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/3/13/5"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-14" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/3/14" data-title="Prompt ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Prompt ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/3/14/6"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/3/14/6"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-15" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/3/15" data-title="ChatGPT Plus">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Plus </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/3/15/7"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/3/15/7" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/zpanel/course/manage_lessons/1/edit_topic/4">Praktik Menggunakan ChatGPT</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/theory/4" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/quiz/4" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/zpanel/course/moveup_topic/1/4/4" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/zpanel/course/movedown_topic/1/4/4" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-16" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/4/16" data-title="ChatGPT Sebagai Teman Virtual">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Teman Virtual </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/4/16/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/4/16/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-17" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/4/17" data-title="ChatGPT Sebagai Teman Brainstorming">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Teman Brainstorming </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/4/17/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/4/17/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-18" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/4/18" data-title="ChatGPT Sebagai Alat Menulis">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Alat Menulis </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/4/18/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/4/18/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-19" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/4/19" data-title="ChatGPT Sebagai Bantuan Belajar">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Bantuan Belajar </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/4/19/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/4/19/4"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-20" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/4/20" data-title="ChatGPT Sebagai Penerjemah Bahasa">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Penerjemah Bahasa </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/4/20/5"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/4/20/5"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-21" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/4/21" data-title="ChatGPT Sebagai Pembuat Kode Program">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Pembuat Kode Program </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/4/21/6"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/4/21/6"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-22" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/4/22" data-title="ChatGPT Sebagai Penyedia Informasi">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Penyedia Informasi </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/4/22/7"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/4/22/7"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-23" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/4/23" data-title="ChatGPT Sebagai Pembuat Rangkuman">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Pembuat Rangkuman </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/4/23/8"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/4/23/8" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/zpanel/course/manage_lessons/1/edit_topic/5">Mengenal Midjourney</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/theory/5" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/quiz/5" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/zpanel/course/moveup_topic/1/5/5" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/zpanel/course/movedown_topic/1/5/5" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-24" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/5/24" data-title="Berkenalan dengan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Berkenalan dengan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/5/24/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/5/24/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-25" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/5/25" data-title="Cara Kerja Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Cara Kerja Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/5/25/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/5/25/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-26" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/5/26" data-title="Keuntungan Menggunakan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Keuntungan Menggunakan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/5/26/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/5/26/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-27" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/5/27" data-title="Kemampuan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Kemampuan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/5/27/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/5/27/4"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-28" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/5/28" data-title="Keterbatasan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Keterbatasan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/5/28/5"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/5/28/5"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-29" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/5/29" data-title="Membuat Akun Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Akun Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/5/29/6"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/5/29/6"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-30" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/5/30" data-title="Berlangganan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Berlangganan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/5/30/7"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/5/30/7"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-31" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/5/31" data-title="Prompt Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Prompt Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/5/31/8"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/5/31/8"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-32" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/5/32" data-title="Menjelajah Website Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Menjelajah Website Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/5/32/9"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/5/32/9"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-33" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/5/33" data-title="Server Discord Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Server Discord Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/5/33/10"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/5/33/10" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/zpanel/course/manage_lessons/1/edit_topic/6">Praktik Menggunakan Midjourney</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/theory/6" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/quiz/6" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/zpanel/course/moveup_topic/1/6/6" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/zpanel/course/movedown_topic/1/6/6" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-34" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/6/34" data-title="Demo Membuat Ilustrasi Buku Cerita Anak">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Demo Membuat Ilustrasi Buku Cerita Anak </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/6/34/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/6/34/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-35" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/6/35" data-title="Demo Membuat Gambar Imajinasi">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Demo Membuat Gambar Imajinasi </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/6/35/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/6/35/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-36" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/6/36" data-title="Demo Membuat Avatar 3D">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Demo Membuat Avatar 3D </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/6/36/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/6/36/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-37" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/6/37" data-title="Membuat Formula Midjourney Prompt dengan ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Formula Midjourney Prompt dengan ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/6/37/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/6/37/4" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/zpanel/course/manage_lessons/1/edit_topic/7">Studi Kasus Kreasi Konten dengan AI</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/theory/7" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/quiz/7" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/zpanel/course/moveup_topic/1/7/7" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/zpanel/course/movedown_topic/1/7/7" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-38" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/7/38" data-title="Studi Kasus Ngonten dengan AI">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Studi Kasus Ngonten dengan AI </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/7/38/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/7/38/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-39" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/7/39" data-title="Merancang Strategi Konten">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Merancang Strategi Konten </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/7/39/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/7/39/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-40" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/7/40" data-title="Menentukan Branding">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Menentukan Branding </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/7/40/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/7/40/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-41" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/7/41" data-title="Membuat Logo">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Logo </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/7/41/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/7/41/4"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-42" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/7/42" data-title="Membuat Daftar Ide Konten">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Daftar Ide Konten </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/7/42/5"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/7/42/5"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-43" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/7/43" data-title="Membuat Postingan Instagram">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Postingan Instagram </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/7/43/6"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/7/43/6"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-44" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/7/44" data-title="Membuat Naskah Konten Video">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Naskah Konten Video </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/7/44/7"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/7/44/7"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-45" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/7/45" data-title="Mengubah Naskah ke Bahasa Lain">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Mengubah Naskah ke Bahasa Lain </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/7/45/8"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/7/45/8"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-46" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/7/46" data-title="Membuat Cover Gambar untuk Youtube">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Cover Gambar untuk Youtube </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/7/46/9"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/7/46/9"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-47" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/7/47" data-title="Membuat Konten dari Artikel Bahasa Asing">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Konten dari Artikel Bahasa Asing </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/7/47/10"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/7/47/10" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/zpanel/course/manage_lessons/1/edit_topic/8">Penutup</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/theory/8" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/quiz/8" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/zpanel/course/moveup_topic/1/8/8" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/zpanel/course/movedown_topic/1/8/8" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-48" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/8/48" data-title="Langkah Selanjutnya">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Langkah Selanjutnya </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/8/48/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/8/48/1" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/zpanel/course/manage_lessons/1/edit_topic/9">Rekaman Sesi Live Zoom</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/theory/9" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/zpanel/course/lessons/quiz/9" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/zpanel/course/moveup_topic/1/9/9" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/zpanel/course/movedown_topic/1/9/9" style="visibility:hidden" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-49" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/9/49" data-title="Rekaman Sesi Live Zoom Hari Pertama Batch 1">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Rekaman Sesi Live Zoom Hari Pertama Batch 1 </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/9/49/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/9/49/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-50" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/zpanel/course/manage_lessons/1/edit_theory/9/50" data-title="Rekaman Sesi Live Zoom Hari Kedua Batch 1">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Rekaman Sesi Live Zoom Hari Kedua Batch 1 </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/zpanel/course/moveup_lesson/9/50/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/zpanel/course/movedown_lesson/9/50/2" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-9">
                    <h3 class="mt-2 mb-4">Add Topic</h3>

                    <form action="/zpanel/course/save_topic/1/" method="POST" class="p-2">
                        <div class="row mb-3">
                            <input type="hidden" name="topic_order" value="10">
                            <div class="col-7">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" id="topic_title" name="topic_title" placeholder="Nama Topik" value="">
                            </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <div class="pe-5">
                                <label class="form-label">Is Topic Free?</label><br>
                                <label class="align-middle pe-2">No</label>
                                <label class="align-middle switch" id="free">
                                    <input type="checkbox">
                                    <span class="slider round d-inline-block"></span>
                                    <input type="hidden" name="free" value="0" data-caption="Free">
                                </label>
                                <label class="align-middle ps-2">Yes</label>

                                <script>
                                    $(function() {
                                        let swParent = $('#free');
                                        swParent.children('input[type=checkbox]').on('change', function() {
                                            let checked = $(this).prop('checked');
                                            swParent.children('input[type=hidden]').val(Number(checked));
                                        })
                                    })
                                </script>
                            </div>
                            <div class="pe-5">
                                <label for="lesson_slug">Publish Topic?</label><br>
                                <label class="align-middle pe-2">No</label>
                                <label class="align-middle switch" id="status">
                                    <input type="checkbox" checked="">
                                    <span class="slider round d-inline-block"></span>
                                    <input type="hidden" name="status" value="1" data-caption="Status">
                                </label>
                                <label class="align-middle ps-2">Yes</label>

                                <script>
                                    $(function() {
                                        let swParent = $('#status');
                                        swParent.children('input[type=checkbox]').on('change', function() {
                                            let checked = $(this).prop('checked');
                                            swParent.children('input[type=hidden]').val(Number(checked));
                                        })
                                    })
                                </script>
                            </div>
                        </div>

                        <div class="row mt-3 pt-3 border-top">
                            <div class="col-6">
                            </div>
                            <div class="col-6 text-end">
                                <a class="btn btn-secondary" href="/zpanel/course/manage_lessons/1"><span class="fa fa-arrow-left"></span> Cancel</a>
                                <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save Topic</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->