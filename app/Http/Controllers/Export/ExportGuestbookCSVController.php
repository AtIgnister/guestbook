<?php

namespace App\Http\Controllers\Export;

use App\Helpers\GuestbookExportHelper;
use App\Models\Guestbook;
use Illuminate\Http\Request;
use ZipArchive;


class ExportGuestbookCSVController extends \App\Http\Controllers\Controller {
    private function sanitize($value) {
        return is_null($value) ? '' : preg_replace("/[\r\n]+/", ' ', $value);
    }

    public function export(Request $request, Guestbook $guestbook)
    {
        $data = GuestbookExportHelper::getData($guestbook, true, true);

        // Create temp file for ZIP
        $zipFileName = tempnam(sys_get_temp_dir(), 'guestbook.zip');
        $zip = new ZipArchive();
        if ($zip->open($zipFileName, ZipArchive::CREATE) !== true) {
            throw new \RuntimeException('Failed to create ZIP file.');
        }

        $this->writeGuestbook($zip, $data);
        $this->writeEntries($zip, $data);
        $zip->close();

        return response()->download($zipFileName, 'guestbook.zip')->deleteFileAfterSend(true);
    }

    private function writeGuestbook($zip, $data) {
        $headerRowsForGuestbook = ["GuestbookID", "GuestbookName", "AuthorName", "GuestbookStyle", "GuestbookDescription"];

        // Write guestbook header
        $guestbookCsv = fopen('php://temp', 'r+');
        fwrite($guestbookCsv, "\xEF\xBB\xBF");  
        fputcsv($guestbookCsv, $headerRowsForGuestbook, ",", '"');

        // Write guestbook rows
        foreach ($data['guestbooks'] as $guestbookData) {
            fputcsv($guestbookCsv, [
                $this->sanitize($guestbookData['id']),
                $this->sanitize($guestbookData['name']),
                $this->sanitize($guestbookData['author_name']),
                $this->sanitize($guestbookData['style']),
                $this->sanitize($guestbookData['description'])
            ]);
        }
        rewind($guestbookCsv);
        $zip->addFromString('guestbook.csv', stream_get_contents($guestbookCsv));
        fclose($guestbookCsv);

        return $zip;
    }

    private function writeEntries($zip, $data) {
        $headerRowsForEntry = ["EntryID", "AuthorName", "Comment", "Website", "GuestbookID", "CreatedAt", "UpdatedAt", "Approved", "ParentID"];

        $entriesCsv = fopen('php://temp', 'r+');
        fwrite($entriesCsv, "\xEF\xBB\xBF");  
        // Write entries header
        fputcsv($entriesCsv, $headerRowsForEntry, ",", '"');

        // Write entries
        foreach ($data['guestbooks'] as $guestbookData) {
            foreach ($guestbookData['entries'] as $entry) {
                fputcsv($entriesCsv, [
                    $this->sanitize($entry['id']),
                    $this->sanitize($entry['name']),
                    $this->sanitize($entry['comment']),
                    $this->sanitize($entry['website']),
                    $this->sanitize($guestbookData['id']),
                    $this->sanitize($entry['created_at']),
                    $this->sanitize($entry['updated_at']),
                    $this->sanitize($entry['approved']),
                    $this->sanitize($entry['parent_entry_id'] ?? 'null')
                ]);
            }
        }
        rewind($entriesCsv);
        $zip->addFromString('entries.csv', stream_get_contents($entriesCsv));
        fclose($entriesCsv);

        return $zip;
    }
}