<div class="row justify-content-center">
    <div class="col-md-4 mb-4">
        {{-- <input type="text" class="form-control" name="nom_partenaire" required> 
        <div class="input-group">
            <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="nom_partenaire" required>
                @if(isset($nom_partenaire))
                    <option value="" disabled>Nom partenaire</option>
                    @forelse ($partenaires as $value)
                        @if ($value->id== $nom_partenaire)
                            <option value="{{$value->id}}" selected>{{$value->nom_partenaire}}</option>
                        @else
                            <option value="{{$value->id}}">{{$value->nom_partenaire}}</option>
                        @endif
                        @empty
                        <option value="">Aucun partenaire disponible</option>
                    @endforelse
                @else
                    <option value="" disabled selected>Nom partenaire</option>
                        @forelse ($partenaires as $value)
                            <option value="{{$value->id}}">{{$value->nom_partenaire}}</option>
                            @empty
                            <option value="">Aucun partenaire disponible</option>
                        @endforelse
                @endif
            </select>
        </div>--}}
    </div>
    <div class="col-md-4 mb-4">
        {{-- <input type="text" class="form-control" name="nom_partenaire" required> --}}
        <div class="input-group">
            <input type="text" id="daterange" class="form-control" name="dates" value="{{$dates ?? date('d/m/Y',strtotime( '-1 days' )).' - '.date('d/m/Y',strtotime( '-1 days' )) }}">
            <div class="input-group-append">
                <span class="input-group-text"><i class="dripicons-calendar"></i></span>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-6">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
        </button> &nbsp;
        @if (Route::is('facturation_valide.search') || Route::is('facturation_valide.index'))
            <a href="{{ route('facturation_valide.index') }}" class="btn btn-dark">
                <span style="color:white">Tous</span>
            </a>
        @elseif (Route::is('facturation_envalidation.search') || Route::is('facturation_envalidation.index'))
            <a href="{{ route('facturation_envalidation.index') }}" class="btn btn-dark">
                <span style="color:white">Tous</span>
            </a>
        @elseif (Route::is('recyclage_uv.search') || Route::is('recyclage_uv.index'))
            <a href="{{ route('recyclage_uv.index') }}" class="btn btn-dark">
                <span style="color:white">Tous</span>
            </a>    
        @endif
    </div>
</div>
