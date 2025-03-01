<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<div class="page-heading">


    <section class="section">
        <div class="mb-3">
            <div class="row">
                <div class="col">
                    <h2>
                        Materi untuk: Ngonten Sakti dengan AI <a class="ms-2 btn btn-sm btn-white text-dark" title="Edit course settings" href="/ruangpanel/course/edit/1"><span class="bi bi-pencil"></span> Edit</a>
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
                        <a href="/ruangpanel/course/lessons/topic" class="btn btn-sm btn-secondary"><span class="bi bi-tag"></span> Add Topic</a>
                    </div>

                    <div class="sidebar-lesson" style="margin: 0 -15px; padding: 15px;">
                        <ul class="lesson-list list-unstyled">
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/ruangpanel/course/manage_lessons/1/edit_topic/1">Pengenalan</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/theory/1" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/quiz/1" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/ruangpanel/course/moveup_topic/1/1/1" style="visibility:hidden" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/ruangpanel/course/movedown_topic/1/1/1" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-1" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/1/1" data-title="Selamat Datang">
                                                    <span class="bi bi-unlock text-warning"></span>
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Selamat Datang </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/1/1/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/1/1/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-2" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/1/2" data-title="Kontrak Belajar">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Kontrak Belajar </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/1/2/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/1/2/2" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/ruangpanel/course/manage_lessons/1/edit_topic/2">02 - AI dan Perkembangannya</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/theory/2" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/quiz/2" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/ruangpanel/course/moveup_topic/1/2/2" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/ruangpanel/course/movedown_topic/1/2/2" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-3" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/2/3" data-title="Mengenal Artificial Intelligence">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Mengenal Artificial Intelligence </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/2/3/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/2/3/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-4" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/2/4" data-title="Sejarah Artificial Intelligence">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Sejarah Artificial Intelligence </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/2/4/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/2/4/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-5" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/2/5" data-title="AI dalam Teknologi Saat Ini">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    AI dalam Teknologi Saat Ini </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/2/5/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/2/5/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-6" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/2/6" data-title="Potensi dan Tantangan AI">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Potensi dan Tantangan AI </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/2/6/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/2/6/4"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-7" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/2/7" data-title="Prinsip Kreasi Konten dengan AI">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Prinsip Kreasi Konten dengan AI </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/2/7/5"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/2/7/5"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-8" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/2/8" data-title="ChatGPT dan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT dan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/2/8/6"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/2/8/6" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/ruangpanel/course/manage_lessons/1/edit_topic/3">Mengenal ChatGPT</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/theory/3" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/quiz/3" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/ruangpanel/course/moveup_topic/1/3/3" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/ruangpanel/course/movedown_topic/1/3/3" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-9" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/3/9" data-title="Berkenalan dengan ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Berkenalan dengan ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/3/9/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/3/9/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-10" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/3/10" data-title="Cara Kerja ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Cara Kerja ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/3/10/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/3/10/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-11" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/3/11" data-title="Kemampuan ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Kemampuan ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/3/11/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/3/11/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-12" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/3/12" data-title="Keterbatasan ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Keterbatasan ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/3/12/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/3/12/4"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-13" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/3/13" data-title="Membuat Akun ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Akun ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/3/13/5"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/3/13/5"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-14" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/3/14" data-title="Prompt ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Prompt ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/3/14/6"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/3/14/6"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-15" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/3/15" data-title="ChatGPT Plus">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Plus </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/3/15/7"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/3/15/7" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/ruangpanel/course/manage_lessons/1/edit_topic/4">Praktik Menggunakan ChatGPT</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/theory/4" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/quiz/4" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/ruangpanel/course/moveup_topic/1/4/4" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/ruangpanel/course/movedown_topic/1/4/4" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-16" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/4/16" data-title="ChatGPT Sebagai Teman Virtual">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Teman Virtual </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/4/16/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/4/16/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-17" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/4/17" data-title="ChatGPT Sebagai Teman Brainstorming">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Teman Brainstorming </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/4/17/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/4/17/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-18" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/4/18" data-title="ChatGPT Sebagai Alat Menulis">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Alat Menulis </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/4/18/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/4/18/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-19" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/4/19" data-title="ChatGPT Sebagai Bantuan Belajar">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Bantuan Belajar </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/4/19/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/4/19/4"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-20" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/4/20" data-title="ChatGPT Sebagai Penerjemah Bahasa">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Penerjemah Bahasa </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/4/20/5"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/4/20/5"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-21" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/4/21" data-title="ChatGPT Sebagai Pembuat Kode Program">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Pembuat Kode Program </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/4/21/6"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/4/21/6"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-22" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/4/22" data-title="ChatGPT Sebagai Penyedia Informasi">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Penyedia Informasi </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/4/22/7"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/4/22/7"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-23" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/4/23" data-title="ChatGPT Sebagai Pembuat Rangkuman">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    ChatGPT Sebagai Pembuat Rangkuman </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/4/23/8"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/4/23/8" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/ruangpanel/course/manage_lessons/1/edit_topic/5">Mengenal Midjourney</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/theory/5" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/quiz/5" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/ruangpanel/course/moveup_topic/1/5/5" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/ruangpanel/course/movedown_topic/1/5/5" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-24" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/5/24" data-title="Berkenalan dengan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Berkenalan dengan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/5/24/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/5/24/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-25" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/5/25" data-title="Cara Kerja Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Cara Kerja Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/5/25/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/5/25/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-26" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/5/26" data-title="Keuntungan Menggunakan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Keuntungan Menggunakan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/5/26/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/5/26/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-27" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/5/27" data-title="Kemampuan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Kemampuan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/5/27/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/5/27/4"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-28" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/5/28" data-title="Keterbatasan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Keterbatasan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/5/28/5"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/5/28/5"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-29" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/5/29" data-title="Membuat Akun Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Akun Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/5/29/6"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/5/29/6"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-30" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/5/30" data-title="Berlangganan Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Berlangganan Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/5/30/7"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/5/30/7"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-31" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/5/31" data-title="Prompt Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Prompt Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/5/31/8"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/5/31/8"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-32" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/5/32" data-title="Menjelajah Website Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Menjelajah Website Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/5/32/9"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/5/32/9"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-33" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/5/33" data-title="Server Discord Midjourney">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Server Discord Midjourney </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/5/33/10"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/5/33/10" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/ruangpanel/course/manage_lessons/1/edit_topic/6">Praktik Menggunakan Midjourney</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/theory/6" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/quiz/6" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/ruangpanel/course/moveup_topic/1/6/6" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/ruangpanel/course/movedown_topic/1/6/6" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-34" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/6/34" data-title="Demo Membuat Ilustrasi Buku Cerita Anak">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Demo Membuat Ilustrasi Buku Cerita Anak </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/6/34/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/6/34/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-35" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/6/35" data-title="Demo Membuat Gambar Imajinasi">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Demo Membuat Gambar Imajinasi </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/6/35/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/6/35/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-36" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/6/36" data-title="Demo Membuat Avatar 3D">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Demo Membuat Avatar 3D </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/6/36/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/6/36/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-37" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/6/37" data-title="Membuat Formula Midjourney Prompt dengan ChatGPT">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Formula Midjourney Prompt dengan ChatGPT </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/6/37/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/6/37/4" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/ruangpanel/course/manage_lessons/1/edit_topic/7">Studi Kasus Kreasi Konten dengan AI</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/theory/7" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/quiz/7" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/ruangpanel/course/moveup_topic/1/7/7" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/ruangpanel/course/movedown_topic/1/7/7" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-38" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/7/38" data-title="Studi Kasus Ngonten dengan AI">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Studi Kasus Ngonten dengan AI </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/7/38/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/7/38/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-39" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/7/39" data-title="Merancang Strategi Konten">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Merancang Strategi Konten </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/7/39/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/7/39/2"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-40" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/7/40" data-title="Menentukan Branding">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Menentukan Branding </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/7/40/3"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/7/40/3"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-41" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/7/41" data-title="Membuat Logo">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Logo </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/7/41/4"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/7/41/4"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-42" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/7/42" data-title="Membuat Daftar Ide Konten">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Daftar Ide Konten </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/7/42/5"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/7/42/5"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-43" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/7/43" data-title="Membuat Postingan Instagram">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Postingan Instagram </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/7/43/6"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/7/43/6"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-44" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/7/44" data-title="Membuat Naskah Konten Video">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Naskah Konten Video </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/7/44/7"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/7/44/7"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-45" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/7/45" data-title="Mengubah Naskah ke Bahasa Lain">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Mengubah Naskah ke Bahasa Lain </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/7/45/8"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/7/45/8"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-46" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/7/46" data-title="Membuat Cover Gambar untuk Youtube">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Cover Gambar untuk Youtube </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/7/46/9"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/7/46/9"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-47" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/7/47" data-title="Membuat Konten dari Artikel Bahasa Asing">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Membuat Konten dari Artikel Bahasa Asing </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/7/47/10"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/7/47/10" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/ruangpanel/course/manage_lessons/1/edit_topic/8">Penutup</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/theory/8" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/quiz/8" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/ruangpanel/course/moveup_topic/1/8/8" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/ruangpanel/course/movedown_topic/1/8/8" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-48" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/8/48" data-title="Langkah Selanjutnya">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Langkah Selanjutnya </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/8/48/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/8/48/1" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="p-2 mb-3 border shadow-sm">
                                <h6 class="topic-title publish">
                                    <span class="bi bi-lock text-success"></span> <a href="/ruangpanel/course/manage_lessons/1/edit_topic/9">Rekaman Sesi Live Zoom</a>
                                </h6>

                                <div class="mb-2">
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/theory/9" title="Buat materi baru"><span class="bi bi-plus-circle"></span> Add Lesson</a>
                                    <a class="btn btn-sm btn-link badge bg-info" href="/ruangpanel/course/lessons/quiz/9" title="Buat quiz baru"><span class="bi bi-plus-circle"></span> Add Quiz</a>
                                </div>

                                <div class="text-end pl-0 movable-topic">
                                    <div class="align-middle">
                                        <a href="/ruangpanel/course/moveup_topic/1/9/9" title="Move topic up"><span class="bi bi-arrow-up"></span></a>
                                        <a href="/ruangpanel/course/movedown_topic/1/9/9" style="visibility:hidden" title="Move topic down"><span class="bi bi-arrow-down"></span></a>
                                    </div>
                                </div>

                                <ul class="submenu-lesson-list list-unstyled">
                                    <li id="lesson-49" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/9/49" data-title="Rekaman Sesi Live Zoom Hari Pertama Batch 1">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Rekaman Sesi Live Zoom Hari Pertama Batch 1 </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/9/49/1" style="visibility:hidden"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/9/49/1"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                    <li id="lesson-50" class="border publish ">
                                        <label class="d-flex justify-content-between my-1">
                                            <span>
                                                <a href="/ruangpanel/course/manage_lessons/1/edit_theory/9/50" data-title="Rekaman Sesi Live Zoom Hari Kedua Batch 1">
                                                    <span class="bi bi-book"></span>&nbsp;
                                                    Rekaman Sesi Live Zoom Hari Kedua Batch 1 </a>
                                            </span>
                                            <span class="text-end small movable-lesson" style="min-width:25px">
                                                <a title="Move lesson up" href="/ruangpanel/course/moveup_lesson/9/50/2"><span class="bi bi-arrow-up"></span></a>
                                                <a title="Move lesson down" href="/ruangpanel/course/movedown_lesson/9/50/2" style="visibility:hidden"><span class="bi bi-arrow-down"></span></a>
                                            </span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-9">
                    <h3 class="mt-2 mb-4">Add Quiz</h3>

                    <style>
                        .tab-content {
                            border-bottom: 3px solid #ccc !important;
                        }

                        #accordionQuestion .card {
                            margin-bottom: 5px;
                            border-radius: 5px;
                            border-bottom: 1px solid #ccc;
                        }

                        #accordionQuestion .card .card-header {
                            background-color: #eee;
                        }

                        #accordionQuestion .card .card-header .btn-link {
                            color: #444;
                            font-weight: 600;
                        }

                        .btn.text-muted {
                            color: #aaa !important;
                        }

                        .ck-editor__editable_inline {
                            min-height: 100px !important;
                        }
                    </style>

                    <!-- FORM QUIZ GROUP -->
                    <form action="/ruangpanel/course/save_quiz/1/1/" method="post">
                        <div class="tab-content pb-5" id="myTabContent">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label" for="topic_id">Topic</label>
                                    <input disabled="" type="text" id="topic_id" name="topic_id" class="form-control" placeholder="Lesson Title" value="Pengenalan">
                                    <input type="hidden" name="topic_id" value="1">
                                    <input type="hidden" name="quiz_id" value="">
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success shadow"><span class="fa fa-save"></span> Save Lesson</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Order -->
                                <input type="hidden" name="lesson_order" value="3">

                                <div class="col-6 slugify">
                                    <label class="form-label" for="lesson_title">Quiz Title</label>
                                    <input type="text" name="lesson_title" value="" id="lesson_title" class="form-control title" placeholder="Quiz Title" style="font-weight:bold">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="lesson_slug">Quiz Slug</label>
                                    <input type="text" name="lesson_slug" value="" id="lesson_slug" class="form-control slug" placeholder="Quiz Slug">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="video">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="video">Thumbnail Image</label>
                                        <div class="input-group">
                                            <div class="mb-3 mb-0">
                                                <div class="input-group mb-0">
                                                    <input type="text" id="thumbnail" name="thumbnail" class="form-control" placeholder="Choose file .." value="" data-caption="Thumbnail image">
                                                    <div class="input-group-append">
                                                        <a data-fancybox="" data-type="iframe" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="/filemanager/dialog.php?type=1&amp;field_id=thumbnail&amp;akey=4ab1a1be4ee36986a10ba25d532d67d2" class="input-group-text btn-file-manager">Choose</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="video">Minimum Score</label>
                                        <input type="number" name="kkm" id="kkm" class="form-control" value="100">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="video">Duration</label>
                                        <small>(HH:MM:SS)</small>
                                        <input type="text" name="duration" id="duration" class="form-control" value="00:00:00">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6 d-flex justify-content-start">
                                    <div class="pe-5">
                                        <label class="form-label" for="lesson_slug">Is Quiz Free?</label><br>
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
                                    <div class="pe-0">
                                        <label class="form-label" for="lesson_slug">Publish Quiz?</label><br>
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
                            </div>
                        </div>
                    </form>
                    <!-- END FORM QUIZ GROUP -->

                    <!-- QUESTION MANAGEMENT -->
                    <!-- END QUESTION MANAGEMENT -->

                    <script>
                        $(function() {
                            if (location.hash != null && location.hash != "") {
                                $('.collapse').removeClass('in');
                                $(location.hash + '.collapse').collapse('show');
                                $('.main-wrapper').scrollTop(0);
                                setTimeout(() => {
                                    $('.main-wrapper').animate({
                                        'scrollTop': $(location.hash).offset().top - 60
                                    }, 400);
                                }, 400);
                            }

                            $(document).on('click', '.remove_option', function() {
                                var questionID = $(this).data('question');
                                var optionID = $(this).data('option');
                                if (confirm('Hapus opsi ini?')) {
                                    $('#option_group_' + optionID).remove();
                                }
                            })

                            $('.btn-add-option').on('click', function() {
                                var randID = Math.random().toString(36).substr(2, 9);
                                var questionID = $(this).data('question');
                                optionTemplate = `
        <div class="mb-3" id="option_group_${randID}">
          <div class="d-flex justify-content-start">
            <div>
              <button type="button" class="remove_option btn btn-secondary btn-sm" data-question="" data-option="${randID}"><span class="fa fa-times text-danger"></span></button>
            </div>
            <div class="col-6">
              <input type="text" name="question_options[${randID}]" class="form-control" value="" required focus>
            </div>
            <div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="is_right" value="${randID}" id="check_right_${randID}">
                <label class="form-label" class=" custom-control-label" for="check_right_${randID}">
                  This is right option
                </label>
              </div>
            </div>
          </div>
        </div>`;
                                $('#qs_' + questionID).find('.question_options').append(optionTemplate);
                            })
                        })
                    </script>
                </div>
            </div>
        </div>
    </section>

</div>

<?php $this->endSection() ?>
<!-- END Content Section -->