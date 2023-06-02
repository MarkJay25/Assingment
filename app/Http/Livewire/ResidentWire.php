<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Resident;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ResidentWire extends Component
{
    use LivewireAlert;
    use WithPagination; // Import the WithPagination trait
    use WithFileUploads;
    
    public $CivilStatus, $FirstName, $MiddleName, $LastName, $Suffix, $DateofBirth, $PlaceofBirth, $forUpdate, $sessionID;
    public $searchTerm; // Corrected property name
    public $list;
    public $file; 
    public $files; 

    protected $paginationTheme = 'bootstrap'; // Optional: Set the pagination theme

    public function render()
{
    
    $residents = $this->getResidentList(); // Call the getResidentList() method
    $residents = $this->getResidentList()->paginate(3); // Set the number of items per page

    return view('livewire.resident-wire', compact('residents'));
}

    public function delete($id)
    {
        $delete = Resident::where('id', $id)->delete();
        if($delete)
            $this->alert('success','Successfully deleted!');

        {
            $files = Storage::disk('public')->files('uploads');
            return view('livewire.resident-wire', [
                'files' => $files,
            ]);
        }
    }

    public function update($id)
    {
        $info = Resident::where('id', $id)->first();
        
        if(isset($info)){
            $this->sessionID = $id;
            $this->forUpdate = true;
            $this->FirstName = $info->FirstName;
            $this->MiddleName = $info->MiddleName;
            $this->LastName = $info->LastName;
            $this->Suffix = $info->Suffix;
            $this->DateofBirth = $info->DateofBirth;
            $this->CivilStatus = $info->CivilStatus;
            $this->PlaceofBirth = $info->PlaceofBirth;
        }
    }

    public function saveResident()
    {
        $validate = $this->validate([
            'FirstName' => 'required',
            'LastName' => 'required',
            'DateofBirth' => 'required',
            'PlaceofBirth' => 'required',
            'CivilStatus' => 'required',
        ]);

        if($validate){
            if($this->forUpdate){
                $data = [
                    'FirstName' => $this->FirstName,
                    'MiddleName' => $this->MiddleName,
                    'LastName' => $this->LastName,
                    'Suffix' => $this->Suffix,
                    'DateofBirth' => $this->DateofBirth,
                    'PlaceofBirth' => $this->PlaceofBirth,
                    'CivilStatus' => $this->CivilStatus,
                ];

                $update = Resident::where('id', $this->sessionID)
                    ->update($data);
                if($update){
                    $this->alert('success', $this->FirstName . ' ' . $this->LastName . ' has been updated', ['toast' => false, 'position' => 'center']);
                }

            }else{
                $c = new Resident();
                $c->ResidentNo = strtoupper(uniqid());
                $c->FirstName = $this->FirstName;
                $c->MiddleName = $this->MiddleName;
                $c->LastName = $this->LastName;
                $c->Suffix = $this->Suffix;
                $c->DateofBirth = $this->DateofBirth;
                $c->PlaceofBirth = $this->PlaceofBirth;
                $c->CivilStatus = $this->CivilStatus;
                $c->save();

                $this->alert('success', $this->FirstName . ' ' . $this->LastName . ' has been saved', ['toast' => false, 'position' => 'center']);
            }

            $this->resetFields();
        }
    }

    public function resetFields()
    {
        $this->forUpdate = false;
        $this->sessionID = null;
        $this->FirstName = null;
        $this->MiddleName = null;
        $this->LastName = null;
        $this->Suffix = null;
        $this->DateofBirth = null;
        $this->PlaceofBirth = null;
        $this->CivilStatus = null;
    }

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|file',
        ]);
    
        $uploadedFile = $this->file->store('public/uploads');
        $this->alert('success', 'File Successfully Uploaded!');
        $this->reset('file');
        $this->emit('fileUploaded', $uploadedFile);
        $this->files = Storage::disk('public')->files('uploads'); 
    }
    
    public function updatedFile()
    {
        $this->validateOnly('file', [
            'file' => 'required|file|max:2048',
        ]);
    }

    public function removeFile($filePath)
    {
        Storage::delete($filePath);
        $this->files = array_diff($this->files, [$filePath]);
        $this->alert('success', 'File removed successfully.');
    }

    public function getResidentList()
    {
        $query = Resident::query();

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('FirstName', 'LIKE', '%' . $this->searchTerm . '%')
                    ->orWhere('LastName', 'LIKE', '%' . $this->searchTerm . '%');
            });
        }

        return $query->orderBy('id', 'DESC');
    }
}



