<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DatabaseBackup;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupController extends Controller
{
    public function download(string $name): BinaryFileResponse
    {
        $backup = new DatabaseBackup;

        abort_unless($backup->exists($name), 404);

        return response()->download($backup->pathFor($name));
    }
}
