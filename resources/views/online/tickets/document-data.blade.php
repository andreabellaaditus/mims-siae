<div class="modal-header" style='background: #8B7E70; color:#fff'>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title" style='color:#fff !important;'><span
                style="text-transform: uppercase; font-weight:400; font-style: normal !important;">Procedura Acquisto Biglietti Ridotti/Gratuiti</span>
    </h4>
</div>
<div class="modal-body">
    <div class="row m-t-10">
        <div class="col-md-12 col-sm-12 col-xs-12 text-justify">
            <strong>Per poter acquistare i biglietti <strong>Ridotti/Gratuiti</strong> è necessario indicare i requisiti
                e i dati relativi al documento che ne attesti il diritto</strong>
        </div>
    </div>
    <hr>
    <form name="frmDocumentForReduction" method="post" action="#">
        <div class="form-group text-left">
            <label for="product_id">Biglietto {{ $infos['productName'] }} - {{ $infos['siteName'] }}</label>
        </div>
        <div class="form-group text-left">
            <label for="reduction_type_id">Tipologia Riduzione/Gratuità</label>
            <select name="reduction_type_id" id="reduction_type_id" class="form-control" required>
                <option value="">Selezionare Tipologia Riduzione/Gratuità</option>
                @foreach($infos['reductions'] as $key => $reduction)
                    <option value="{{ $key }}">{{ $reduction }}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group text-left">
                    <label for="first_name">Nome</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Nome"
                           required/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group text-left">
                    <label for="last_name">Cognome</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Cognome"
                           required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group text-left">
                    <label for="document_type_id">Tipo di documento</label>
                    <select name="document_type_id" class="form-control" required>
                        <option value="">Seleziona un tipo di documento dalla lista</option>
                        @foreach($infos['documentTypes'] as $documentType)
                            <option value="{{$documentType['id']}}" data-slug="{{$documentType['slug']}}">{{$documentType['label']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group text-left document_type_detail_other hide">
                    <label for="document_type_other">Specificare il tipo di documento</label>
                    <input type="text" name="document_type_other" id="document_type_other" class="form-control"
                           placeholder="Tipo documento"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group text-left">
                    <label for="document_id">N. Documento</label>
                    <input type="text" name="document_id" id="document_id" class="form-control"
                           placeholder="N. Documento" required/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group text-left">
                    <label for="document_issued_by">Emesso da</label>
                    <input type="text" name="document_issued_by" id="document_issued_by" class="form-control"
                           placeholder="Tipo documento" required/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group text-left">
                    <label for="document_expire_at">Scadenza</label>
                    <input type="text" name="document_expire_at" id="document_expire_at" class="form-control"
                           placeholder="Scadenza documento" required autocomplete="false"/>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>


        <div class="form-group text-left">
            <label for="warning"><i class="fa fa-exclamation-triangle text-danger"></i></label>
            <strong>Per i biglietti Ridotti/Gratuti, al controllo accessi, verrà richiesta la documentazione che attesti
                il diritto all'utilizzo di tale biglietto. Se non verrà dimostrata la titolarità alla
                riduzione/gratuità, per accedere al {{ $infos['siteName'] }} sarà necessario acquistare un biglietto
                INTERO.</strong>
        </div>
        <hr>
        <div class="row m-t-10">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <button type="button" class="cd-hero__btn cd-hero__btn--blue pull-left" data-dismiss="modal"><i
                            class="fas fa-times"></i> Annulla
                </button>
                <button type="submit" class="cd-hero__btn pull-right"><i class="fa fa-plus"></i> Conferma
                </button>
            </div>
        </div>
    </form>
</div>
