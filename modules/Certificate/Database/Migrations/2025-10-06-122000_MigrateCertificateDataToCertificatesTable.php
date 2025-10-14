<?php

namespace Certificate\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrateCertificateDataToCertificatesTable extends Migration
{
    public function up()
    {
        // Migrate existing certificate data from course_students to certificates table
        $builder        = $this->db->table('course_students');
        $courseStudents = $builder->select('
                course_students.*,
                users.name as participant_name,
                courses.course_title as title
            ')
            ->join('users', 'users.id = course_students.user_id')
            ->join('courses', 'courses.id = course_students.course_id')
            ->where('course_students.cert_code IS NOT NULL')
            ->where('course_students.cert_code !=', '')
            ->get()
            ->getResultArray();

        if (! empty($courseStudents)) {
            $certificatesData = [];

            foreach ($courseStudents as $student) {
                $certNumber = $this->formatCertificateNumber($student);
                $certificatesData[] = [
                    'cert_code'        => $student['cert_code'],
                    'cert_increment'   => $student['cert_number'] ?? 1,
                    'cert_number'      => $certNumber,
                    'cert_claim_date'  => $student['cert_claim_date'] ?? $student['created_at'],
                    'user_id'          => $student['user_id'],
                    'entity_type'      => 'course',
                    'entity_id'        => $student['course_id'],
                    'participant_name' => $student['participant_name'],
                    'title'            => $student['title'],
                    'template_name'    => 'default',
                    'additional_data'  => json_encode([
                        'live_batch_id' => $student['live_batch_id'] ?? null,
                        'migrated_from' => 'course_students',
                    ]),
                    'is_active'  => 1,
                    'created_at' => $student['created_at'],
                    'updated_at' => $student['updated_at'] ?? $student['created_at'],
                ];
            }

            // Insert certificates data
            $certificatesBuilder = $this->db->table('certificates');
            $certificatesBuilder->insertBatch($certificatesData);

            // Update course_students with certificate_id
            foreach ($courseStudents as $student) {
                $certificate = $this->db->table('certificates')
                    ->where('cert_code', $student['cert_code'])
                    ->get()
                    ->getRowArray();

                if ($certificate) {
                    $this->db->table('course_students')
                        ->where('id', $student['id'])
                        ->update(['certificate_id' => $certificate['id']]);
                }
            }
        }
    }

    public function down()
    {
        // Remove migrated certificates (ones with additional_data containing 'migrated_from')
        $this->db->query("
            DELETE FROM certificates
            WHERE JSON_EXTRACT(additional_data, '$.migrated_from') = 'course_students'
        ");

        // Reset certificate_id in course_students
        $this->db->table('course_students')
            ->set('certificate_id', null)
            ->update();
    }

    private function formatCertificateNumber(array $certificate): string
    {
        $year  = date('Y', strtotime($certificate['cert_claim_date']));
        $month = date('m', strtotime($certificate['cert_claim_date']));

        // Roman month conversion
        $romanMonths = [
            '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV', '05' => 'V', '06' => 'VI',
            '07' => 'VII', '08' => 'VIII', '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII',
        ];
        $romanMonth = $romanMonths[$month] ?? '';

        // Get certificate prefix from config
        $config     = new \Certificate\Config\Certificate();
        $certPrefix = $config->certPrefix ?? 'CPJS';

        // Get certificate type prefix
        $CertTemplate = \Certificate\Libraries\CertificateTemplateFactory::getTemplate($certificate['entity_type'] ?? 'default');
        $typePrefix   = $CertTemplate->getPrefix();

        $prefix = $certPrefix . '-' . strtoupper($typePrefix);
        $number = str_pad($certificate['cert_number'], 4, '0', STR_PAD_LEFT);

        return "{$prefix}/{$year}/{$romanMonth}/{$number}";
    }

}
