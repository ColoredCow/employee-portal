<?php

namespace App\Helpers;

use App\Models\HR\Applicant;
use App\Models\HR\Application;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use niklasravnsborg\LaravelPdf\Pdf as PdfFile;

class FileHelper
{
    /**
     * Retrieve file path based upon year and month
     *
     * @param  string $year  year directory of the file
     * @param  string $month month directory of the file
     * @param  string $file  invoice file name
     * @return string
     */
    public static function getFilePath($year, $month, $file)
    {
        $filePath = $year . '/' . $month . '/' . $file;

        if (!Storage::exists($filePath)) {
            return false;
        }

        return $filePath;
    }

    /**
     * Retrieve storage directory based upon current year and month
     *
     * @return string
     */
    public static function getCurrentStorageDirectory()
    {
        $now = Carbon::now();
        return $now->format('Y') . '/' . $now->format('m');
    }

    public static function getOfferLetterFileName(PdfFile $file, Applicant $applicant)
    {
        $dashedApplicantName = str_replace(' ', '-', $applicant->name);
        $timestamp = Carbon::now()->format('Ymd');
        return "$dashedApplicantName-$timestamp.pdf";
    }

    public static function generateOfferLetter(Application $application, $offer_letter_body, $offerLetterPreview = false)
    {
        $job = $application->job;
        $applicant = $application->applicant;
        $pdf = Pdf::loadView('hr.application.offer-letter', compact('applicant', 'job', 'offer_letter_body'));
        $fileName = self::getOfferLetterFileName($pdf, $applicant);
        if ($offerLetterPreview) {
            return $pdf->stream('offer-letter.pdf');
        }
        $fullPath = storage_path('app/' . config('constants.hr.offer-letters-dir') . '/' . $fileName);
        $pdf->save($fullPath);
        $application->saveOfferLetter(config('constants.hr.offer-letters-dir') . '/' . $fileName);
        return $application->offer_letter;
    }
}
