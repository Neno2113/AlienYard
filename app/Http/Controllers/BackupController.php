<?php

namespace App\Http\Controllers;

use Artisan;
use Exception;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\Controller;
use League\Flysystem\Adapter\Local;
use Log;
use Request;
use Response;
use Storage;

class BackupController extends Controller
{
    public function index()
    {
        if (!count(config('backup.backup.destination.disks'))) {
            dd(trans('backpack::backup.no_disks_configured'));
        }

        $this->data['backups'] = [];

        foreach (config('backup.backup.destination.disks') as $disk_name) {
            $disk = Storage::disk($disk_name);
            $adapter = $disk->getDriver()->getAdapter();
            $files = $disk->allFiles();

            // make an array of backup files, with their filesize and creation date
            foreach ($files as $k => $f) {
                // only take the zip files into account
                if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                    $this->data['backups'][] = [
                        'file_path'     => $f,
                        'file_name'     => str_replace('backups/', '', $f),
                        'file_size'     => $disk->size($f),
                        'last_modified' => $disk->lastModified($f),
                        'disk'          => $disk_name,
                        'download'      => ($adapter instanceof Local) ? true : false,
                    ];
                }
            }
        }

        // reverse the backups, so the newest one would be on top
        $this->data['backups'] = array_reverse($this->data['backups']);
        $this->data['title'] = 'Backups';
        // for ($i=0; $i <count($this->data['backups']) ; $i++) { 
        //     $this->data['backups'][$i]['last_modified'] = date('d/m/20y', strtotime($this->data['backups'][$i]['last_modified']));
        // }
       

        return $this->data;
    }

    public function create()
    {
        $message = 'success';

        try {
            ini_set('max_execution_time', 600);

            Log::info('Backpack\BackupManager -- Called backup:run from admin interface');

            Artisan::call('backup:run');

            $output = Artisan::output();
            if (strpos($output, 'Backup failed because')) {
                preg_match('/Backup failed because(.*?)$/ms', $output, $match);
                $message = "Backpack\BackupManager -- backup process failed because ";
                $message .= isset($match[1]) ? $match[1] : '';
                Log::error($message.PHP_EOL.$output);
            } else {
                Log::info("Backpack\BackupManager -- backup process has started");
            }
        } catch (Exception $e) {
            Log::error($e);

            return Response::make($e->getMessage(), 500);
        }

        return $message;
    }

    /**
     * Downloads a backup zip file.
     */
    public function download($file_name, $disco)
    {
        
        $disk = Storage::disk($disco);
        // $file_name = Request::input('file_name');
        $adapter = $disk->getDriver()->getAdapter();
        // var_dump($disk);
        // var_dump($file_name);
        // print_r($adapter);
        // die();

        if ($adapter instanceof Local) {
            $storage_path = $disk->getDriver()->getAdapter()->getPathPrefix();

            if ($disk->exists($file_name)) {
                return response()->download($storage_path.$file_name);
            } else {
                abort(404, trans('backpack::backup.backup_doesnt_exist'));
            }
        } else {
            abort(404, trans('backpack::backup.only_local_downloads_supported'));
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete(HttpRequest $request)
    {
      
        $file_name = $request->input('file_name');
        $disco = $request->input('disco');

        // var_dump($disco);
        // var_dump($file_name);
        // die();

        $disk = Storage::disk($disco);

        if ($disk->exists($file_name)) {
            $disk->delete($file_name);

            return 'success';
        } else {
            abort(404, trans('backpack::backup.backup_doesnt_exist'));
        }
    }
}