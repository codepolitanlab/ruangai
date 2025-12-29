<?php

namespace App\Pages\certificate\detail;

use App\Pages\BaseController;
use Certificate\Libraries\CertificateTemplateFactory;

class PageController extends BaseController
{
    private $certPrefix = 'CPRAI'; // Certificate prefix, e.g., CPJS for "Certificate"
    public $data = [
        'page_title' => "Sertifikat RuangAI"
    ];

    public function getData($code = null)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);

        $vars = $this->certVariables($code);
        $this->data = array_merge($this->data, $vars);

        return $this->respond($this->data);
    }

    public function getShow($certificate_id = null)
    {
        // Get certificate by ID
        $certificate = model('CertificateModel')->find($certificate_id);

        if (!$certificate) {
            return $this->respond([
                'status' => 'failed',
                'message' => 'Sertifikat tidak ditemukan'
            ]);
        }

        // Redirect to certificate page using cert_code
        return redirect()->to(site_url() . "c/" . $certificate['cert_code']);
    }

    private function certVariables($code = null)
    {
        // Get certificate data from new certificates table
        $certificate = model('CertificateModel')->getCertificateByCode($code);

        if (!$certificate) {
            return [
                'status' => 'failed',
                'message' => 'Sertifikat tidak ditemukan'
            ];
        }

        // Roman month from cert_claim_date
        $monthNum = date('m', strtotime($certificate['cert_claim_date']));
        $romanMonths = [
            '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV', '05' => 'V', '06' => 'VI',
            '07' => 'VII', '08' => 'VIII', '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII'
        ];
        $bulan = $romanMonths[$monthNum] ?? '';

        // Prepare certificate data from certificate
        $certificateData = [
            'url'         => site_url() . "c/" . $certificate['cert_code'],
            'code'        => $certificate['cert_code'],
            'number'      => $certificate['cert_number'],
            'name'        => $certificate['participant_name'],
            'code'        => $certificate['cert_code'],
            'course'      => $certificate['title'], // Generic title for any type
            'publishDate' => date('d F Y', strtotime($certificate['cert_claim_date'])),
            'expiredDate' => date('d F Y', strtotime($certificate['cert_claim_date'] . ' + 5 year')),
            'entity_type' => $certificate['entity_type'],
            'entity_id'   => $certificate['entity_id'],
        ];

        // Add additional data if exists
        if (!empty($certificate['additional_data'])) {
            $additionalData = json_decode($certificate['additional_data'], true);
            $certificateData = array_merge($certificateData, $additionalData);
        }

        // Use template from certificate or determine based on type
        $templateName = $certificate['template_name'];
        
        // Get certificate template using factory
        $template = CertificateTemplateFactory::getTemplate($templateName, $certificateData);
        $certificateConfig = $template->getConfig();

        return [
            'status' => 'success',
            'claimer' => $certificateData,
            'certificate' => $certificateConfig,
            'template_info' => [
                'name' => $template->getName(),
                'description' => $template->getDescription()
            ]
        ];
    }

}
