<?php

namespace App\Http\Livewire\Imports;

use App\Imports\TerminationsImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;


class TerminationImport extends Component
{
    use WithFileUploads;

    public $terminationFiles = [];
    public $uploadTerminations;

    //public string $file;
    //public string $uploadedFilename;


    public function updatedTerminationFiles()
    {
        $this->validate([
            'terminationFiles.*' => 'mimes:csv,xlsx|max:5120' //5MB
        ]);


    }
    public function import()
    {
        foreach($this->terminationFiles as $terminationFile){
            Excel::import(new TerminationsImport,$terminationFile);
        }

        return redirect()->route('import.termination');
    }

    public function render()
    {
        return view('livewire.imports.termination-import');
    }
}
