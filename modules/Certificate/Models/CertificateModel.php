<?php

namespace Certificate\Models;

use CodeIgniter\Model;

class CertificateModel extends Model
{
    protected $table            = 'certificates';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'cert_code',
        'cert_increment',
        'cert_number',
        'cert_claim_date',
        'user_id',
        'entity_type',
        'entity_id',
        'participant_name',
        'title',
        'additional_data',
        'template_name',
        'is_active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'cert_code'        => 'required|is_unique[certificates.cert_code]|max_length[20]',
        'cert_increment'   => 'required|integer',
        'user_id'          => 'required|integer',
        'entity_type'      => 'required|max_length[50]',
        'entity_id'        => 'required|integer',
        'participant_name' => 'required|max_length[255]',
        'title'            => 'required|max_length[500]',
        'template_name'    => 'max_length[50]',
    ];
    protected $validationMessages = [
        'cert_code' => [
            'is_unique' => 'Certificate code already exists',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateCertCode'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get certificate by cert_code with user data
     */
    public function getCertificateByCode(string $certCode): ?array
    {
        return $this->select('certificates.*, users.name as user_name, users.email')
            ->join('users', 'users.id = certificates.user_id')
            ->where('certificates.cert_code', $certCode)
            ->where('certificates.is_active', 1)
            ->first();
    }

    /**
     * Get certificates by user
     *
     * @param mixed|null $type
     */
    public function getCertificatesByUser(int $userId, $type = null): array
    {
        $builder = $this->where('user_id', $userId)
            ->where('is_active', 1);

        if ($type) {
            $builder->where('entity_type', $type);
        }

        return $builder->orderBy('cert_claim_date', 'DESC')->findAll();
    }

    /**
     * Get certificates by entity
     */
    public function getCertificatesByEntity(string $entityType, int $entityId): array
    {
        return $this->select('certificates.*, users.name as user_name, users.email')
            ->join('users', 'users.id = certificates.user_id')
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('is_active', 1)
            ->orderBy('cert_claim_date', 'DESC')
            ->findAll();
    }

    /**
     * Generate next certificate increment for given type and year
     *
     * @param mixed|null $year
     */
    public function getNextCertIncrement(string $type, $year = null): int
    {
        if (! $year) {
            $year = date('Y');
        }

        $lastCert = $this->select('cert_increment')
            ->where('entity_type', $type)
            ->where('YEAR(cert_claim_date)', $year)
            ->orderBy('cert_increment', 'DESC')
            ->first();

        return $lastCert ? $lastCert['cert_increment'] + 1 : 1;
    }

    /**
     * Generate certificate code
     */
    protected function generateCertCode(array $data): array
    {
        if (empty($data['data']['cert_code'])) {
            $data['data']['cert_code'] = $this->generateUniqueCertCode();
        }

        return $data;
    }

    /**
     * Generate unique certificate code
     */
    private function generateUniqueCertCode(): string
    {
        do {
            $code = strtoupper(bin2hex(random_bytes(5))); // 10 character code
        } while ($this->where('cert_code', $code)->first());

        return $code;
    }

    /**
     * Format certificate number based on type and data
     */
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
        $number = str_pad($certificate['cert_increment'], 4, '0', STR_PAD_LEFT);

        return "{$prefix}/{$year}/{$romanMonth}/{$number}";
    }

    /**
     * Create certificate for course completion
     */
    public function createCourseCertificate(array $data): int
    {
        $certClaimDate     = $data['cert_claim_date'] ?? date('Y-m-d H:i:s');
        $year              = date('Y', strtotime($certClaimDate));
        $nextCertIncrement = $this->getNextCertIncrement('course', $year);

        $certificateData = [
            'cert_code'   => $this->generateUniqueCertCode(),
            'cert_number' => $this->formatCertificateNumber([
                'cert_claim_date' => $certClaimDate,
                'entity_type'     => 'course',
                'cert_increment'  => $nextCertIncrement,
            ]),
            'cert_increment'   => $nextCertIncrement,
            'cert_claim_date'  => $certClaimDate,
            'user_id'          => $data['user_id'],
            'entity_type'      => 'course',
            'entity_id'        => $data['course_id'],
            'participant_name' => $data['participant_name'],
            'title'            => $data['course_title'],
            'template_name'    => $data['template_name'] ?? 'default',
            'additional_data'  => json_encode($data['additional_data'] ?? []),
        ];

        return $this->insert($certificateData);
    }

    /**
     * Create certificate for training completion
     */
    public function createTrainingCertificate(array $data): int
    {
        $certClaimDate     = $data['cert_claim_date'] ?? date('Y-m-d H:i:s');
        $year              = date('Y', strtotime($certClaimDate));
        $nextCertIncrement = $this->getNextCertIncrement('course', $year);

        $certificateData = [
            'cert_code'   => $this->generateUniqueCertCode(),
            'cert_number' => $this->formatCertificateNumber([
                'cert_claim_date' => $certClaimDate,
                'entity_type'     => 'training',
                'cert_increment'  => $nextCertIncrement,
            ]),
            'cert_increment'   => $this->getNextCertIncrement('training', $year),
            'cert_claim_date'  => $certClaimDate,
            'user_id'          => $data['user_id'],
            'entity_type'      => 'training',
            'entity_id'        => $data['training_id'],
            'participant_name' => $data['participant_name'],
            'title'            => $data['training_title'],
            'template_name'    => $data['template_name'] ?? 'training',
            'additional_data'  => json_encode($data['additional_data'] ?? []),
        ];

        return $this->insert($certificateData);
    }

    /**
     * Create certificate for event participation
     */
    public function createEventCertificate(array $data): int
    {
        $certClaimDate     = $data['cert_claim_date'] ?? date('Y-m-d H:i:s');
        $year              = date('Y', strtotime($certClaimDate));
        $nextCertIncrement = $this->getNextCertIncrement('event', $year);

        $certificateData = [
            'cert_code'   => $this->generateUniqueCertCode(),
            'cert_number' => $this->formatCertificateNumber([
                'cert_claim_date' => $certClaimDate,
                'entity_type'     => 'event',
                'cert_increment'  => $nextCertIncrement,
            ]),
            'cert_increment'   => $nextCertIncrement,
            'cert_claim_date'  => $certClaimDate,
            'user_id'          => $data['user_id'],
            'entity_type'      => 'event',
            'entity_id'        => $data['event_id'],
            'participant_name' => $data['participant_name'],
            'title'            => $data['event_title'],
            'template_name'    => $data['template_name'] ?? 'event',
            'additional_data'  => json_encode($data['additional_data'] ?? []),
        ];

        return $this->insert($certificateData);
    }
}
