<?php

namespace App\Http\Livewire;

use App\Imports\TerminationsImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Excel;

class FileUpload extends Component
{
    use WithFileUploads;

    public $files = [];
    public $uploadTerminations;

    //public string $file;
    //public string $uploadedFilename;


    public function updatedFiles()
    {
        $this->validate([
            'files.*' => 'max:5120' //5MB
        ]);
    }
    public function import()
    {
        foreach($this->files as $file){
            Excel::import(new TerminationsImport,$file);
        }
        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.file-upload');
    }
}
