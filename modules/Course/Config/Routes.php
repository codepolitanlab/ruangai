<?php

helper('heroicsetting');

$routes->group(
    setting_item('Heroicadmin.urlScope') . '/course',
    ['namespace' => 'Course\Controllers'],
    static function ($routes) {
        // Course
        $routes->get('/', 'Course::index'); // List course
        $routes->get('form', 'Course::form'); // Form
        $routes->post('form', 'Course::save'); // Create/Update
        $routes->post('delete', 'Course::delete'); // Delete
        
        $routes->get('(:num)', 'Lesson::index/$1'); // Lesson list landing
        $routes->get('(:num)/student', 'Student::index/$1'); // Lesson list student

        // Course Topic
        $routes->get('(:num)/topic', 'Topic::index/$1'); // Add
        $routes->post('(:num)/topic', 'Topic::save/$1'); // Create
        $routes->get('(:num)/topic/(:num)', 'Topic::index/$1/$2'); // Edit
        $routes->post('(:num)/topic/(:num)', 'Topic::save/$1/$2'); // Update
        $routes->get('(:num)/topic/(:num)/delete', 'Topic::delete/$1/$2'); // Delete

        // Course Lesson Theory
        $routes->get('(:num)/topic/(:num)/theory', 'Theory::index/$1/$2'); // Add
        $routes->get('(:num)/topic/(:num)/theory/(:num)', 'Theory::index/$1/$2/$3'); // Edit
        $routes->post('(:num)/topic/(:num)/theory', 'Theory::save/$1/$2'); // Insert/Update

        // Course Lesson Quiz
        $routes->get('(:num)/topic/(:num)/quiz', 'Quiz::index/$1/$2'); // Add
        $routes->get('(:num)/topic/(:num)/quiz/(:num)', 'Quiz::index/$1/$2/$3'); // Edit
        $routes->post('(:num)/topic/(:num)/quiz', 'Quiz::save/$1/$2'); // Insert/Update

        // Delete lesson theory or quiz
        $routes->get('(:num)/lesson/(:num)/delete', 'Lesson::delete/$1/$2');

        // Live batch
        $routes->get('(:num)/live', 'LiveBatch::index/$1'); // List
        $routes->get('(:num)/live/create', 'LiveBatch::create/$1'); // Create
        $routes->post('(:num)/live/create', 'LiveBatch::insert/$1'); // Insert
        $routes->get('(:num)/live/(:num)/edit', 'LiveBatch::edit/$1/$2'); // Edit
        $routes->post('(:num)/live/(:num)/edit', 'LiveBatch::update/$1/$2'); // Update
        $routes->get('(:num)/live/(:num)/delete', 'LiveBatch::delete/$1/$2'); // Delete

        // Live meeting
        $routes->get('live/(:num)/meeting', 'LiveMeeting::index/$1'); // List
        $routes->get('live/(:num)/meeting/create', 'LiveMeeting::create/$1'); // Add
        $routes->post('live/(:num)/meeting/create', 'LiveMeeting::insert/$1'); // Insert
        $routes->get('live/(:num)/meeting/(:num)/edit', 'LiveMeeting::edit/$1/$2'); // Edit
        $routes->post('live/(:num)/meeting/(:num)/edit', 'LiveMeeting::update/$1/$2'); // Update
        $routes->get('live/(:num)/meeting/(:num)/delete', 'LiveMeeting::delete/$1/$2'); // Delete

        // Live attendance
        $routes->get('live/meeting/(:num)/attendant', 'MeetingAttendance::index/$1'); // List
        $routes->get('live/meeting/(:num)/attendant/add', 'MeetingAttendance::form/$1'); // Add
        $routes->post('live/meeting/(:num)/attendant/add', 'MeetingAttendance::save/$1'); // Insert
        $routes->get('live/meeting/(:num)/attendant/(:num)/edit', 'MeetingAttendance::form/$1/$2'); // Edit
        $routes->post('live/meeting/(:num)/attendant/(:num)/edit', 'MeetingAttendance::save/$1/$2'); // Update
        $routes->post('live/meeting/(:num)/attendant/(:num)/delete', 'MeetingAttendance::delete/$1/$2'); // Delete
        $routes->get('live/meeting/(:num)/attendant/sync', 'MeetingAttendance::sync/$1'); // Add
        $routes->get('live/meeting/(:num)/attendant/startSync', 'MeetingAttendance::startSync/$1'); // Add

        // Live attendance
        $routes->get('product', 'Product::index'); // List
        $routes->get('product/add', 'Product::form'); // Add
        $routes->post('product/add', 'Product::save'); // Insert
        $routes->get('product/(:num)/edit', 'Product::form/$1'); // Edit
        $routes->post('product/(:num)/edit', 'Product::save/$1'); // Update
        $routes->post('product/delete', 'Product::delete'); // Delete
        $routes->get('product/checkout/(:num)', 'Product::checkout/$1'); // Generate checkout link
    }
);

// Zoom meeting link processor
$routes->get('zoom/(:any)', '\Course\Controllers\Zoom::index/$1');
