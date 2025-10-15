<?php

namespace Certificate\Libraries;

abstract class CertificateTemplate
{
    protected $studentData;

    public function __construct($studentData = [])
    {
        $this->studentData = $studentData;
    }

    /**
     * Get the certificate configuration
     * Must be implemented by child classes
     */
    abstract public function getConfig(): array;

    /**
     * Get page dimensions (default A4 landscape)
     */
    protected function getPageDimensions(): array
    {
        return [
            'w' => 297,
            'h' => 210,
        ];
    }

    /**
     * Get QR code configuration (default)
     */
    protected function getQrConfig(): array
    {
        return [
            'xPct'   => 89,
            'yPct'   => 74,
            'sizeMm' => 36,
            'ecl'    => 'M',
            'dark'   => '#000000',
            'light'  => '#ffffff',
        ];
    }

    /**
     * Helper method to create position configuration
     */
    protected function createPosition(
        float $xPct,
        float $yPct,
        float $maxWidthPct,
        float $fontMm,
        ?float $minFontMm = null,
        string $weight = 'normal',
        string $align = 'left',
        string $color = '#000000',
        bool $autoshrink = false
    ): array {
        return [
            'xPct'        => $xPct,
            'yPct'        => $yPct,
            'maxWidthPct' => $maxWidthPct,
            'fontMm'      => $fontMm,
            'minFontMm'   => $minFontMm ?? $fontMm,
            'weight'      => $weight,
            'align'       => $align,
            'color'       => $color,
            'autoshrink'  => $autoshrink,
        ];
    }

    /**
     * Helper method to create page configuration
     */
    protected function createPage(string $backgroundUrl, array $positions): array
    {
        return [
            'bg'        => $backgroundUrl,
            'positions' => $positions,
        ];
    }

    /**
     * Get template name for identification
     */
    abstract public function getName(): string;

    /**
     * Get template prefix code
     */
    abstract public function getPrefix(): string;

    /**
     * Get template description
     */
    abstract public function getDescription(): string;
}
