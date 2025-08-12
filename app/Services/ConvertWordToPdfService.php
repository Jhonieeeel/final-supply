<?php

namespace App\Services;

class ConvertWordToPdfService
{
    public function convert($filepath)
    {
        $outputPath = storage_path('app/public/requisition_slip/');
        $docx = pathinfo($filepath, PATHINFO_FILENAME);
        $pdfPath = "{$outputPath}/{$docx}.pdf";

        if (!getenv('HOME')) {
            putenv('HOME=' . storage_path());
        }

        $libreOfficePath = '"C:\\Program Files\\LibreOffice\\program\\soffice.exe"';
        $command = "{$libreOfficePath} --headless --convert-to pdf --outdir \"{$outputPath}\" \"{$filepath}\"";

        exec($command . ' 2>&1', $output, $returnCode);

        if ($returnCode !== 0) {
            logger()->error('LibreOffice PDF conversion failed', [
                'command' => $command,
                'output' => $output,
                'code' => $returnCode,
            ]);
            return false;
        }

        if (file_exists($filepath)) {
            unlink($filepath);
        }



        return [
            'pdf_path' => $pdfPath,
            'file_name' => $docx . '.pdf',
        ];
    }
}
