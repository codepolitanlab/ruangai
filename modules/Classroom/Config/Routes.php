<?php

helper('heroicsetting');

$routes->group(
    setting_item('Heroicadmin.urlScope') . '/classroom',
    ['namespace' => 'Classroom\Controllers'],
    static function ($routes) {
        // ============ SYLLABUS ============
        $routes->get('syllabuses', 'Syllabus::index'); // List silabus
        $routes->get('syllabuses/data', 'Syllabus::data'); // Datatable
        $routes->post('syllabuses/store', 'Syllabus::store'); // Create
        $routes->post('syllabuses/(:num)/update', 'Syllabus::update/$1'); // Update
        $routes->post('syllabuses/(:num)/duplicate', 'Syllabus::duplicate/$1'); // Duplicate
        $routes->post('syllabuses/(:num)/delete', 'Syllabus::delete/$1'); // Delete

        // ============ MATERIAL & RESOURCE ============
        $routes->get('syllabuses/(:num)/materials', 'Material::index/$1'); // Halaman materi
        $routes->get('syllabuses/(:num)/materials/data', 'Material::data/$1'); // List materi + resource
        $routes->post('syllabuses/(:num)/materials/store', 'Material::store/$1'); // Create materi
        $routes->post('syllabuses/(:num)/materials/reorder', 'Material::reorder/$1'); // Reorder materi
        $routes->post('syllabuses/(:num)/materials/(:num)/update', 'Material::update/$1/$2'); // Update materi
        $routes->post('syllabuses/(:num)/materials/(:num)/delete', 'Material::delete/$1/$2'); // Delete materi
        // Resource
        $routes->post('syllabuses/(:num)/materials/(:num)/resources/store', 'Material::storeResource/$1/$2'); // Tambah resource
        $routes->post('syllabuses/(:num)/materials/(:num)/resources/reorder', 'Material::reorderResource/$1/$2'); // Reorder resource
        $routes->post('syllabuses/(:num)/materials/(:num)/resources/(:num)/update', 'Material::updateResource/$1/$2/$3'); // Update resource
        $routes->post('syllabuses/(:num)/materials/(:num)/resources/(:num)/delete', 'Material::deleteResource/$1/$2/$3'); // Hapus resource

        // ============ CLASS ROOM ============
        $routes->get('classes', 'ClassRoom::index'); // List kelas
        $routes->get('classes/data', 'ClassRoom::data'); // Datatable
        $routes->get('classes/form', 'ClassRoom::form'); // Form create
        $routes->get('classes/(:num)/edit', 'ClassRoom::form/$1'); // Form edit
        $routes->get('classes/syllabuses', 'ClassRoom::syllabuses'); // Dropdown silabus published
        $routes->get('classes/resources', 'ClassRoom::resources'); // Checklist resource submission
        $routes->post('classes/store', 'ClassRoom::store'); // Create kelas
        $routes->post('classes/(:num)/update', 'ClassRoom::update/$1'); // Update kelas
        $routes->post('classes/(:num)/delete', 'ClassRoom::delete/$1'); // Delete kelas

        // ============ SCHEDULE ============
        $routes->get('classes/(:num)/schedule', 'Schedule::index/$1'); // Halaman jadwal
        $routes->get('classes/(:num)/schedule/data', 'Schedule::data/$1'); // Data jadwal
        $routes->post('classes/(:num)/schedule/sync', 'Schedule::sync/$1'); // Sinkronisasi materi
        $routes->post('classes/(:num)/schedule/(:num)/update', 'Schedule::update/$1/$2'); // Set jadwal + notes
        $routes->post('classes/(:num)/schedule/(:num)/toggle-open', 'Schedule::toggleOpen/$1/$2'); // Buka/tutup materi
        $routes->get('classes/(:num)/schedule/(:num)', 'Schedule::detail/$1/$2'); // Detail materi
        $routes->get('classes/(:num)/schedule/(:num)/data', 'Schedule::detailData/$1/$2'); // Data detail materi
        $routes->get('classes/(:num)/schedule/(:num)/progress', 'Schedule::progress/$1/$2'); // Progres peserta
        $routes->get('classes/(:num)/schedule/(:num)/quiz-results', 'Schedule::quizResults/$1/$2'); // Hasil kuis
        $routes->get('classes/(:num)/schedule/(:num)/submissions', 'Schedule::submissions/$1/$2'); // List submission
        $routes->post('classes/(:num)/schedule/(:num)/meeting-info', 'Schedule::meetingInfo/$1/$2'); // Simpan info meeting
        $routes->post('classes/(:num)/schedule/(:num)/submissions/(:num)/review', 'Schedule::reviewSubmission/$1/$2/$3'); // Review submission
        $routes->get('classes/(:num)/schedule/submissions/(:num)/download', 'Schedule::downloadSubmission/$1/$2'); // Download file tugas
        $routes->get('classes/(:num)/schedule/(:num)/resource/(:num)', 'Schedule::resourceMatrix/$1/$2/$3'); // Matriks status resource
        $routes->post('classes/(:num)/schedule/(:num)/resource/(:num)/meeting-detail', 'Schedule::meetingDetail/$1/$2/$3'); // Detail tatap muka
        $routes->post('classes/(:num)/schedule/(:num)/resource/(:num)/attendance', 'Schedule::setAttendance/$1/$2/$3'); // Set absensi

        // ============ MEMBER ============
        $routes->get('classes/(:num)/members', 'Member::index/$1'); // Halaman peserta
        $routes->get('classes/(:num)/members/data', 'Member::data/$1'); // Datatable peserta
        $routes->get('classes/(:num)/members/search', 'Member::search/$1'); // Cari user
        $routes->post('classes/(:num)/members/add', 'Member::add/$1'); // Tambah 1 member
        $routes->post('classes/(:num)/members/bulk', 'Member::bulk/$1'); // Tambah massal CSV
        $routes->post('classes/(:num)/members/(:num)/drop', 'Member::drop/$1/$2'); // Drop member
        $routes->post('classes/(:num)/members/(:num)/restore', 'Member::restore/$1/$2'); // Aktifkan kembali

        // ============ FEED ============
        $routes->get('classes/(:num)/feeds', 'Feed::index/$1'); // Halaman feed
        $routes->get('classes/(:num)/feeds/data', 'Feed::data/$1'); // Datatable feed
        $routes->post('classes/(:num)/feeds/store', 'Feed::store/$1'); // Buat feed
        $routes->post('classes/(:num)/feeds/(:num)/update', 'Feed::update/$1/$2'); // Update feed
        $routes->post('classes/(:num)/feeds/(:num)/delete', 'Feed::delete/$1/$2'); // Hapus feed
        $routes->post('classes/(:num)/feeds/(:num)/toggle-pin', 'Feed::togglePin/$1/$2'); // Pin/unpin

        // ============ FEEDBACK ============
        $routes->get('classes/(:num)/feedbacks', 'Feedback::index/$1'); // Halaman feedback
        $routes->get('classes/(:num)/feedbacks/data', 'Feedback::data/$1'); // Datatable feedback

        // ============ MEMBER WORK ============
        $routes->get('memberworks', 'MemberWork::index'); // List karya
        $routes->get('memberworks/data', 'MemberWork::data'); // Datatable
        $routes->get('memberworks/create', 'MemberWork::create'); // Form buat karya
        $routes->get('memberworks/(:num)', 'MemberWork::show/$1'); // Detail karya
        $routes->get('memberworks/(:num)/edit', 'MemberWork::edit/$1'); // Form edit
        $routes->post('memberworks/store', 'MemberWork::store'); // Buat karya (admin)
        $routes->post('memberworks/(:num)/update', 'MemberWork::update/$1'); // Update karya
        $routes->post('memberworks/(:num)/moderate', 'MemberWork::moderate/$1'); // Publish/reject
        $routes->post('memberworks/(:num)/delete', 'MemberWork::delete/$1'); // Hapus karya
    }
);
