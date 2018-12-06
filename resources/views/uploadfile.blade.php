<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }


            #dropHere{
            border: 3px dashed #BBBBBB;
            line-height:50px;
            text-align: center;
            }
        </style>

        <script lang="javascript" src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
        <script lang="javascript" src="{{asset('js/xlsx.full.min.js')}}"></script>
        <script lang="javascript" src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    </head>
    <body>
        <div class="container-fluid">
            <h1 class="display-4">OCHA Rowca Database</h1>
            <blockquote class="blockquote">
                <p class="mb-0">Upolad Excel sheets and select which data to import.</p>
            </blockquote>
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-upload-tab" data-toggle="pill" href="#pills-upload" role="tab" aria-controls="pills-upload" aria-selected="true">Upload</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="pills-select-tab" data-toggle="pill" href="#pills-select" role="tab" aria-controls="pills-select" aria-selected="false">Select data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="pills-import-tab" data-toggle="pill" href="#pills-import" role="tab" aria-controls="pills-import" aria-selected="false">Import</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-upload" role="tabpanel" aria-labelledby="pills-upload-tab">
                    <div class="flex-center position-ref full-height" id='dropHere'>
                    Drop here
                    </div>
                    <div id='filesInfo'>
                        <p class="font-weight-normal">Informations sur le fichier</p>
                        <p><em>Dernier modification : test le 1245/45/45</em></p>
                        <p><em>Feuilles : test</em></p>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-select" role="tabpanel" aria-labelledby="pills-select-tab">
                    <div class="row">
                    <div class="col-2">
                        <div class="nav flex-column nav-pills" id="sheet-pills-tab" role="tablist" aria-orientation="vertical">
                            feuilles
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="tab-content" id="sheet-pills-tabContent">
                        </div>
                    </div>
                    </div>
                
                </div>
                <div class="tab-pane fade" id="pills-import" role="tabpanel" aria-labelledby="pills-import-tab"><button type="button" onclick='launchImport()' class="btn btn-primary">Primary</button></div>
            </div>
        </div>


        <script>

            //RECUPERATION DES DONNEES DE LA BASE
            var indicators = null;
            var db_typeHeaders = null;
            var db_headears = null;
            var workbook = null;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            
            jQuery.ajax({ url: "{{ url('/listIndcators') }}",async : false, method: 'post',data: {},success: function(result){indicators = JSON.parse(result);}});
            jQuery.ajax({ url: "{{ url('/getTypeHeaders') }}",async : false, method: 'post',data: {},success: function(result){db_typeHeaders = JSON.parse(result);}});
            jQuery.ajax({ url: "{{ url('/getHeaders') }}",async : false, method: 'post',data: {},success: function(result){db_headears = JSON.parse(result);}});
            //FIN


            //ACTIVATION DU DROP
            var drop_dom_element = document.getElementById("dropHere");
            var rABS = true; // true: readAsBinaryString ; false: readAsArrayBuffer
            function handleDrop(e) {
                e.stopPropagation(); e.preventDefault();
                var files = e.dataTransfer.files, f = files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    var data = e.target.result;
                    if(!rABS) data = new Uint8Array(data);
                    var workbook = XLSX.read(data, {type: rABS ? 'binary' : 'array'});
                    
                    //console.log(workbook);
                    /* DO SOMETHING WITH workbook HERE */
                };
                if(rABS) reader.readAsBinaryString(f); else reader.readAsArrayBuffer(f);
            }

            //EVENEMENTS DU DROP
            $(document).on('dragenter', '#dropHere', function() {
                        $(this).css('border', '3px dashed red');
                        return false;
            });
            $(document).on('dragover', '#dropHere', function(e){
                e.preventDefault();
                e.stopPropagation();
                $(this).css('border', '3px dashed red');
                return false;
            });
            $(document).on('dragleave', '#dropHere', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        $(this).css('border', '3px dashed #BBBBBB');
                        return false;
            });
            $(document).on('drop', '#dropHere', function(e) {
                if(e.originalEvent.dataTransfer){
                    if(e.originalEvent.dataTransfer.files.length) {
                        // Stop the propagation of the event
                        e.preventDefault();
                        e.stopPropagation();

                        $(this).css('border', '3px dashed green');
                        // Main function to upload
                        //upload(e.originalEvent.dataTransfer.files);

                        var files = e.originalEvent.dataTransfer.files;
                        var f = files[0];
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var data = e.target.result;
                            if(!rABS) data = new Uint8Array(data);
                            workbook = XLSX.read(data, {type: rABS ? 'binary' : 'array'});
                            
                            $( "#pills-select-tab" ).removeClass("disabled");
                            $( "#pills-import-tab" ).removeClass("disabled");
                            
                            
                            
                            //INFORMATIONS DU FICHIER
                            $( "#dropHere" ).hide();
                            $( "#filesInfo" ).show();
                            var user = workbook.Props.LastAuthor;
                            var date = workbook.Props.ModifiedDate;
                            $( "#filesInfo" ).html("<p class='font-weight-normal'>Informations sur le fichier</p><p><em>Dernier modification : "+user+" le "+date+"</em></br><em>Feuilles : test</em></p>");
                        
                        
                            var idSheet = 0;
                            var sheetActive = "show active";
                            var buttonSheetActive = "active";
                            var ariaSelected = true;
                            $.each(workbook.SheetNames, function(i, sheetname){
                                if(idSheet!=0){
                                    sheetActive ="";  
                                    buttonSheetActive = "";
                                    ariaSelected = false;                                          
                                }
                                
                                $("#sheet-pills-tab").append("<a class='nav-link "+buttonSheetActive+"' id='v-pills-sheet"+idSheet+"-tab' data-toggle='pill' href='#v-pills-sheet"+idSheet+"' role='tab' aria-controls='v-pills-sheet"+idSheet+"' aria-selected='"+ariaSelected+"'>"+sheetname+"</a>");
                                $("#sheet-pills-tab").append("<input type='text' id='sheet"+idSheet+"' value='"+sheetname+"'/>");
                                $("#sheet-pills-tabContent").append("<div class='tab-pane fade "+sheetActive+"' id='v-pills-sheet"+idSheet+"' role='tabpanel' aria-labelledby='v-pills-sheet"+idSheet+"-tab'><form><div class='form-check'><input type='checkbox' class='form-check-input checkImportSheet' id='checkImportSheet"+idSheet+"'><label class='form-check-label' for='exampleCheck1'>Importer cette feuille</label></div></form><table class='table' ><thead class='sthead-dark'><tr><th scope='col'>?</th><th scope='col'>Entete</th><th scope='col'>Type</th><th scope='col'>KeyFigure / CaseLoad</th></tr></thead><tbody></tbody></table></div>");
                                
                                ws = workbook.Sheets[sheetname];
                                headers = XLSX.utils.sheet_to_json(ws, {header:1})[0];
            
                                var j;
                                for (j = 0; j < headers.length; j++) {
                                    $("#v-pills-sheet"+idSheet+" table tbody").append("<tr><td><div class='form-check'><input type='checkbox' class='form-check-input checkImportColomn"+idSheet+"' id='checkImportColomn"+idSheet+j+"'></div></form></td><td>"+headers[j]+"<input type='text' id='HeaderName"+idSheet+j+"' value='"+headers[j]+"'/></td><td><select class='form-control' id='headerType"+idSheet+j+"'><option value=''>Select one</option><option value='location'>Localisation</option><option value='date'>Date</option><option value='keyFigure'>Key figure / Caseload</option></select></td><td><select class='form-control' id='HeaderIndicator"+idSheet+j+"'></select></td></tr>");
                                    var k;

                                    for (k = 0; k < indicators.length; k++) {
                                        $("#HeaderIndicator"+idSheet+j).append(new Option(indicators[k].kfindic_caption_fr, indicators[k].kfind_id));
                                    }
                                }

                                idSheet++;
                            });
/*
                            //RECHERCHE DES HEADERS DANS LES INDICATEURS
                            var jqxhr = $.post( "example.php", function() {
                            alert( "success" );
                            })
                            .done(function() {
                                alert( "second success" );
                            })
                            .fail(function() {
                                alert( "error" );
                            })
                            .always(function() {
                                alert( "finished" );
                            });
*/
                            /* DO SOMETHING WITH workbook HERE */
                        };
                        if(rABS) reader.readAsBinaryString(f); else reader.readAsArrayBuffer(f);
                    }  
                }
                else {
                        $(this).css('border', '3px dashed #BBBBBB');
                }
                return false;
            });

            

            function upload(files) {
                        var f = files[0] ;
                        console.log(f);
                        // Only process image files.
                        /*
                        if (!f.type.match('image/jpeg')) {
                                alert('The file must be a jpeg image') ;
                                return false ;
                        }*/
                        var reader = new FileReader();
            
                        // When the image is loaded,
                        // run handleReaderLoad function
                        //reader.onload = handleReaderLoad;
            
                        // Read in the image file as a data URL.
                        reader.readAsDataURL(f);            
            }

            function launchImport(){
                idSheet = 0;
                ImportSheets = [];
                $( ".checkImportSheet" ).each(function(l, sheet) {
                    if($(sheet).is(':checked')){
                        feuille = $("#sheet"+idSheet+"").val();
                        sheetData = null;
                        importInfo = [];
                        sheetInfo = [];

                        ws = workbook.Sheets[feuille];
                        sheetData = XLSX.utils.sheet_to_json(ws, {header:1});

                        idColumn = 0;
                        $( ".checkImportColomn"+ idSheet+"" ).each(function(m, column) {
                            if($(column).is(':checked')){
                                headerName = $("#HeaderName"+idSheet+idColumn+"").val();
                                headerIndex = idColumn;
                                headerType = $("#headerType"+idSheet+idColumn+"").val();
                                HeaderIndicator = $("#HeaderIndicator"+idSheet+idColumn+"").val();

                                headerInfo = [];
                                headerInfo.push({headerName,headerName});
                                headerInfo.push({headerIndex,headerIndex});
                                headerInfo.push({headerType, headerType});
                                headerInfo.push({HeaderIndicator,HeaderIndicator});
                                importInfo.push({headerInfo,headerInfo});
                            }
                            idColumn++;
                        });

                        sheetInfo.push({feuille, feuille});
                        sheetInfo.push({importInfo,importInfo});
                        sheetInfo.push({sheetData,sheetData});
                        ImportSheets.push({sheetInfo,sheetInfo});
                    }
                    //console.log(ImportSheets);
                    idSheet++;
                });

                console.log("prepartation import");
                jQuery.ajax({ url: "{{ url('/importData') }}",async : false, method: 'post',data: {import:ImportSheets },success: function(result){
                    console.log(result);
                }});
            
            }

            function handleReaderLoad(evt) {
                var pic = {};
                pic.file = evt.target.result.split(',')[1];

                var str = jQuery.param(pic);

                $.ajax({
                        type: 'POST',
                        url: 'url_to_php_script.php',
                        data: str,
                        success: function(data) {
                                    do_something(data) ;
                        }
                });
            }
            //drop_dom_element.addEventListener('drop', handleDrop, false);
        </script>
    </body>
</html>
