<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeService
{
    public function generate(string $text): string
    {
        $builder = new Builder();

        $result = $builder->build(
            writer: new PngWriter(),
            data: $text,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 700,
            margin: 20,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            logoPath: public_path('images/logo-utp.png'),
            logoResizeToWidth: 110,
            logoResizeToHeight: 110,
            logoPunchoutBackground: true,
        );

        return $result->getString();
    }
}