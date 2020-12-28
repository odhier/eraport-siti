
<div class="row mr-0">
    @push('pagetitle', 'Admin Teacher')
    <div class="col-2 sub-menu">
        <livewire:partials.menu :post="$menu">
    </div>
    <div class="col-10 main-content position-relative">
        <div class="container">
            <h2>{{$subMenu}}</h2>

            <hr/>
            @if (session()->has('errorMessage'))
            <div class="alert alert-danger">
                {{ session('errorMessage') }}
            </div>
            @endif
            @if (session()->has('successMessage'))
            <div class="alert alert-success">
                {{ session('successMessage') }}
            </div>
            @endif
            <div class="form-group row">
                <label for="tahun" class="col-sm-2 col-form-label">Tahun Ajaran saat ini</label>
                <div class="col-sm-10">
                    <select id="inputState" class="form-control" wire:model="general.tahun_ajaran_aktif" style="max-width:200px">
                        <option value="" selected>Pilih Tahun Ajaran</option>
                        @foreach ($allTahun as $tahun)
                        <option value="{{$tahun['id']}}" wire:key="{{$tahun['id']}}">{{$tahun['tahun_ajaran']}}</option>
                        @endforeach
                    </select>
                    @if(isset($validation_errors["tahun_ajaran_aktif"]))
                    @foreach($validation_errors["tahun_ajaran_aktif"] as $k => $v)
                    <label for="" class="text-danger">{{ $v }}</label>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="tahun" class="col-sm-2 col-form-label">Semester saat ini</label>
                <div class="col-sm-10">
                    <select wire:model="general.semester_aktif" class="form-control " style="max-width:200px">
                        <optgroup label="Semester">
                          <option value="1" wire:key="1">Ganjil</option>
                          <option value="2" wire:key="2">Genap</option>
                        </optgroup>
                      </select>
                    @if(isset($validation_errors["semester_aktif"]))
                    @foreach($validation_errors["semester_aktif"] as $k => $v)
                    <label for="" class="text-danger">{{ $v }}</label>
                    @endforeach
                    @endif
                </div>
            </div>
            <hr>
            <div class="col-12 text-right ">
                <button type="button" wire:click="save" class="btn s-btn-primary my-3 btn-modal-save">Save</button>
            </div>

        </div>
        <footer class="w-100">
            <livewire:partials.footer>
        </footer>
    </div>
</div>

