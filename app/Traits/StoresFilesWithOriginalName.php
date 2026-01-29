<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait StoresFilesWithOriginalName
{
    /**
     * Store a file with its original name, adding (1), (2), etc. if duplicate exists
     *
     * @param UploadedFile $file
     * @param string $directory Directory within storage/app/public (e.g., 'pet-photos')
     * @param string $disk Storage disk (default: 'public')
     * @return string The stored file path
     */
    protected function storeFileWithOriginalName(UploadedFile $file, string $directory, string $disk = 'public'): string
    {
        // Get original filename and extension
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
        
        // Clean the filename (remove special characters, keep spaces, hyphens, underscores)
        $nameWithoutExtension = preg_replace('/[^\w\s\-()]/', '', $nameWithoutExtension);
        
        // Start with original name
        $filename = $nameWithoutExtension . '.' . $extension;
        $filepath = $directory . '/' . $filename;
        
        // Check if file exists and add counter if needed
        $counter = 1;
        while (Storage::disk($disk)->exists($filepath)) {
            $filename = $nameWithoutExtension . ' (' . $counter . ').' . $extension;
            $filepath = $directory . '/' . $filename;
            $counter++;
        }
        
        // Store the file with the final filename
        Storage::disk($disk)->putFileAs($directory, $file, $filename);
        
        return $filepath;
    }
    
    /**
     * Store multiple files with original names
     *
     * @param array $files Array of UploadedFile objects
     * @param string $directory Directory within storage/app/public
     * @param string $disk Storage disk (default: 'public')
     * @return array Array of stored file paths
     */
    protected function storeFilesWithOriginalNames(array $files, string $directory, string $disk = 'public'): array
    {
        $paths = [];
        
        foreach ($files as $file) {
            $paths[] = $this->storeFileWithOriginalName($file, $directory, $disk);
        }
        
        return $paths;
    }
}