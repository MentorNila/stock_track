<?php namespace App\Modules\Filing\Logic;

use App\Modules\Client\Models\Client;
use Illuminate\Support\Facades\File;

class StorageHelper
{
    protected static $mode = 0777;

    protected static function getBasePath()
    {
        return storage_path('app') . '/';
    }

    protected static function getLogsPath()
    {
        return storage_path('logs') . '/';
    }

    protected static function getClientPath()
    {
        return static::getBasePath() . 'clients/' . Client::getCurrentClientId() . '/';
    }


    public static function getCompaniesPath($companyId)
    {
        $path = static::getClientPath() . 'companies/' . $companyId;
        return static::makeDirectory($path);
    }

    public static function getCompanyDraftPath($companyId)
    {
        $companyPath = static::getCompaniesPath($companyId);
        return static::makeDirectory($companyPath . '/drafts');
    }

    public static function getFilingDraftPath($companyId, $filingId)
    {
        $draftPath = static::getCompanyDraftPath($companyId);
        return static::makeDirectory($draftPath . '/' . $filingId);
    }

    public static function getExhibitDraftPath($companyId, $filingId)
    {
        $filingPath = static::getFilingDraftPath($companyId, $filingId);

        return static::makeDirectory($filingPath . '/exhibits');
    }

    public static function getFilingDraftFilePath($companyId, $filingId)
    {
        $draftPath = static::getFilingDraftPath($companyId, $filingId);
        return $draftPath . '/' . 'draft.html';
    }

    public static function getExhibitDraftFilePath($companyId, $filingId, $fileName)
    {
        $exhibitsPath = static::getExhibitDraftPath($companyId, $filingId);
        $path = $exhibitsPath . '/' . $fileName . '.html';
        if (!file_exists($path)) {
            return false;
        }
        return $path;
    }

    public static function getFilingSheetPath($companyId, $filingId)
    {
        $companyPath = static::getCompaniesPath($companyId);
        static::makeDirectory($companyPath . '/sheets/' . $filingId);

        return 'clients/' . Client::getCurrentClientId() . '/companies/' . $companyId . '/sheets/' . $filingId;
    }

    public static function getFilingExhibitsPath($companyId, $filingId)
    {
        $companyPath = static::getCompaniesPath($companyId);
        return static::makeDirectory($companyPath . '/exhibits/' . $filingId);
    }

    public static function getWordDocumentPathPath($companyId, $filingId)
    {
        $companyPath = static::getCompaniesPath($companyId);
        $wordPath = $companyPath . '/word/' . $filingId;
        static::makeDirectory($wordPath);

        return 'clients/' . Client::getCurrentClientId() . '/companies/' . $companyId . '/word/' . $filingId;
    }

    public static function getHtmlDocumentPath($companyId, $filingId)
    {
        $companyPath = static::getCompaniesPath($companyId);
        $htmlPath = $companyPath . '/html/' . $filingId;
        $htmlPath = static::makeDirectory($htmlPath);

        return $htmlPath;
    }

    public static function getFinancialStatementsPath($companyId, $filingId)
    {
        $companyPath = static::getCompaniesPath($companyId);
        return static::makeDirectory($companyPath . '/fs/' . $filingId);
    }

    protected static function makeDirectory($path)
    {
        if (!file_exists($path)) {
            try {
                mkdir($path, static::$mode, true);
            } catch (\Exception $e) {
                if (file_exists($path)) {
                    // Do not create folder if already exists, do nothing
                } else {
                    info('Could not create directory: ' . $path);
                }
            }
        }

        return $path;
    }
}
