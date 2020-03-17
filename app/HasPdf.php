<?php

namespace App;

use Illuminate\Http\UploadedFile;
use PDF;
use Illuminate\Support\Facades\Storage;

trait HasPdf
{
    /**
     *  Create and PDF with the Given Content  
     * 
     * @param String $layout
     * @param Array $content 
     * @return  
     */
    public function createPdf($layout, $content, $attributes = NULL)
    {            
        if(env('APP_ENV') != 'testing'){
            $pdf = PDF::loadView($layout, $content); 
            
            $dom_pdf = $pdf->getDomPDF();        
    
            $canvas = $dom_pdf ->get_canvas(); 
            // Create Page Number in PDF Footer
            $canvas->page_text(500, 805, __("{PAGE_NUM} of {PAGE_COUNT}"), null, 10, array(0, 0, 0));
        }else{
            $pdf = UploadedFile::fake()->create('test.pdf'); 
        }     
        
        $path = $this->makePath($attributes);         
        
        $this->storePdf($path, $pdf);
        
        return $path;
    }

    /**
     *  Make Proper Path to Store the File
     * 
     * @return String
     */
    protected function makePath($attributes)
    {        
        $folder = strtolower(class_basename($this)).'s';  
        $attributes = isset($attributes) ? "_{$attributes}" : '';
        
        return "pdf/{$folder}/{$this->custom_id}{$attributes}.pdf";
    }

    /**
     *   Store PDF in the Storage
     * 
     * @param Stirng $path
     * @param File $pdf   
     */
    protected function storePdf($path, $pdf)
    {        
        if(env('APP_ENV') != 'testing'){
             Storage::disk('public')->put($path, $pdf->output()); 
        }else{
            // If Testing Mode use Fake Storage
            Storage::fake('public');
            Storage::disk('public')->put($path, $pdf); 
        }        
    }
}