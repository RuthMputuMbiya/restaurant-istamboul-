<?php

// app/Http/Controllers/Admin/LogController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LogController extends Controller
{
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];
        
        if (File::exists($logFile)) {
            $content = File::get($logFile);
            $lines = explode("\n", $content);
            $logs = array_reverse($lines);
            $logs = array_slice($logs, 0, 200);
            
            // Transformer chaque ligne en tableau associatif
            $formattedLogs = [];
            foreach ($logs as $line) {
                if (!empty(trim($line))) {
                    $formattedLogs[] = [
                        'content' => $line,
                        'level' => $this->getLogLevel($line),
                        'icon' => $this->getLogIcon($line),
                        'created_at' => now()
                    ];
                }
            }
            $logs = $formattedLogs;
        }
        
        return view('admin.logs.index', compact('logs'));
    }
    
    private function getLogLevel($line)
    {
        if (str_contains($line, 'ERROR')) return 'error';
        if (str_contains($line, 'WARNING')) return 'warning';
        if (str_contains($line, 'INFO')) return 'info';
        return 'debug';
    }
    
    private function getLogIcon($line)
    {
        if (str_contains($line, 'ERROR')) return 'fa-exclamation-circle';
        if (str_contains($line, 'WARNING')) return 'fa-exclamation-triangle';
        if (str_contains($line, 'INFO')) return 'fa-info-circle';
        return 'fa-bug';
    }
    
    public function download()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!File::exists($logFile)) {
            return redirect()->back()->with('error', 'Aucun fichier log trouvé.');
        }
        
        return response()->download($logFile, 'laravel-log-' . date('Y-m-d') . '.log');
    }
    
    public function clear()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (File::exists($logFile)) {
            File::put($logFile, '');
        }
        
        return redirect()->back()->with('success', 'Logs vidés avec succès.');
    }
}