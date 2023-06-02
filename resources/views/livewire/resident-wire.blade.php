<div>
    <div class="card-body">
        <h5>Add New Residents</h5>
        <form wire:submit.prevent="saveResident">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="form-label">First Name</div>
                        <input type="" wire:model="FirstName" class="form-control">
                        @error('FirstName')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="form-label">Middle Name</div>
                        <input type="" wire:model="MiddleName" class="form-control">
                        @error('MiddleName')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="form-label">Last Name</div>
                        <input type="" wire:model="LastName" class="form-control">
                        @error('LastName')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="form-label">Suffix</div>
                        <input type="" wire:model="Suffix" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="form-label">Date of Birth</div>
                        <input type="date" wire:model="DateofBirth" class="form-control">
                        @error('DateofBirth')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="form-label">Civil Status</div>
                        <select wire:model="CivilStatus" class="form-control">
                            <option value="">--Select Status--</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Separated">Separated</option>
                            <option value="Widow">Widow</option>
                        </select>
                        @error('CivilStatus')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="form-label">Place of Birth</div>
                        <input type="" wire:model="PlaceofBirth" class="form-control">
                        @error('PlaceofBirth')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    @if($forUpdate)
                    <button class="btn btn-primary form-group mt-2">Update</button>
                    @else
                    <button class="btn btn-primary form-group mt-2">Save</button>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <hr>

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-table me-1"></i>
                    Residents List
                </div>
                <div>
                    <input type="text" wire:model="searchTerm" placeholder="Search..." class="form-control">
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <th>QRcode</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Suffix</th>
                <th>Date of Birth</th>
                <th>Place of Birth</th>
                <th>Civil Status</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($residents as $resident)
                <tr>
                    <td>{!! QrCode::size(40)->generate($resident->FirstName . ' ' . $resident->MiddleName . ' ' . $resident->LastName) !!}</td>
                    <td>{{ $resident->FirstName }}</td>
                    <td>{{ $resident->MiddleName }}</td>
                    <td>{{ $resident->LastName }}</td>
                    <td>{{ $resident->Suffix }}</td>
                    <td>{{ $resident->DateofBirth }}</td>
                    <td>{{ $resident->PlaceofBirth }}</td>
                    <td>{{ $resident->CivilStatus }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" wire:click="update('{{ $resident->id }}')">Edit</button>
                        <button class="btn btn-danger btn-sm" wire:click="delete('{{ $resident->id }}')">Remove</button>
                    </td>
                </tr>
                @endforeach
            </tbody>          
        </table>
        {{ $residents->links() }}
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-upload me-1"></i>
            File Upload
        </div>
        <div class="card-body">
            <form wire:submit.prevent="uploadFile" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file">Choose File</label>
                    <input type="file" class="form-control" wire:model="file">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-alt me-1"></i>
            Uploaded Files
        </div>
        <div class="card-body">
            @if (empty($files))
            <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                <p class="text-center">No Files Uploaded</p>
            </div>
            @else
            <ul>
                @foreach ($files as $file)
                <li>
                    <a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a>
                    <button class="btn btn-danger btn-sm" wire:click="removeFile('{{ $file }}')">Remove</button>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>   
</div>
