<?php
// Include config file
$titolo = 'Bookique - Upload';
require_once UTILS_DIR . 'config.php';
include ASSETS_DIR . 'asset.php';

//Elaborazione dell'anteprima del xml
if (isset($_POST['submitxml'])){
?>
    <section class="banner" role="banner">
        <h1>Upload</h1>
        <div class="container login-container login-form-1">
            <div class="row">
                <div class="col-md-6">
                    <h3>Anteprima dell'XML</h3>
                </div>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Titolo</th>
                            <th scope="col">Autore</th>
                            <th scope="col">Casa Editrice</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Tipologia</th>
                            <th scope="col">Prezzo</th>
                            <th scope="col">Descrizione</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">N. Pagine</th>
                            <th scope="col">Quantità</th>
                        </tr>
                        </thead>
                    <?php

                    //Serializzo l'xml e preparo l'array per il caricamento su db
                    $xmlPath = $_FILES['xmlfile']['tmp_name'];
                    $xml= simplexml_load_file($xmlPath) or die("Errore nella lettura del file");
                    $i = 1;
                    $archivio = [];

                    //Mi salvo le informazioni per ogni libro
                    foreach ($xml->children() as $row){
                        $titolo = (string)$row->Title;
                        $autore = (string)$row->Author;
                        $categoria = (string)$row->Genre;
                        $tipologia = (string)$row->Type;
                        $prezzo = (string)$row->Price;
                        $descrizione = (string)$row->Description;
                        $copertina = (string)$row->Description;
                        $isbn = (string)$row->ISBN;
                        $npagine = (string)$row->NumeroPagine;
                        $ce = (string)$row->CasaEditrice;
                        $quantita = (string)$row->Quantita;
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i?></th>
                            <td><?php echo $titolo?></td>
                            <td><?php echo $autore?></td>
                            <td><?php echo $ce?></td>
                            <td><?php echo $categoria?></td>
                            <td><?php echo $tipologia?></td>
                            <td><?php echo $prezzo?></td>
                            <td><?php echo $descrizione?></td>
                            <td><?php echo $isbn?></td>
                            <td><?php echo $npagine?></td>
                            <td><?php echo $quantita?></td>
                        </tr>
                        <?php
                        $libro = [$titolo, $autore, $ce, $categoria, $tipologia, $prezzo, $descrizione, $isbn, $npagine, $quantita];
                        array_push($archivio, $libro);

                        $i+=1;
                    }
                    ?>
                    </table>
                    <form action="upload" method="post" enctype="multipart/form-data">
                        <input type="submit" value="Salva i nuovi libri" name="saveDataToDatabase" class="btnSubmit" style="width: 270px; margin-top: 30px; left: 0;background-color: #28a745">
                        <input type="submit" value="Carica un altro file" name="nuovoUpload" class="btnSubmit" style="width: 270px; margin-top: 30px; left: 0;">
                    </form>
            </div>
        </div>
    </section>
<?php
//Mi salvo i dati per caricarli su databse
$_SESSION['archivio'] = $archivio;

//Se è sttato premuto il pulsate 'Salva i nuovi libri' richiamo la funzione che li caricherà sul database
}elseif(isset($_POST['saveDataToDatabase'])){
    uploadToDatabase( $_SESSION['archivio']);

//Visualizzo il form per caricare il file se non è stato premuto il pulsante di submit
}else{
    ?>
    <section class="banner" role="banner">
        <h1>Upload</h1>
        <div class="container login-container login-form-1">
            <div class="row">
                <div class="col-md-6">
                    <h3>Seleziona l'XML da caricare</h3>
                    <form action="upload" method="post" enctype="multipart/form-data">
                        <input type="file" name="xmlfile" id="xmlCatalogo" class="btn-block btn" required>
                        <input type="submit" value="Anteprima del caricamento" name="submitxml" class="btnSubmit" style="width: 270px; margin-top: 30px; left: 0;">
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
}

//Una volta visualizzata l'anteprima dell'xml si passa al caricamento su database
function uploadToDatabase($result){
    require ("utils/config.php");
    ?>
    <section class="banner" role="banner">
        <h1>Upload</h1>
        <div class="container login-container login-form-1">
            <div class="row">
                <div class="col-md-6">
                    <h3>Caricamento dati xml su databse</h3>
                    <?php
                        //Controllo che sia stato passato l'archivio, quindi lo carico sul database
                        if(isset($result)){

                            //Scorro tutti i libri presenti nel xml
                            for($i = 0; $i < count($result); $i++ ){
                                $sql = "INSERT INTO libro INNER JOIN casa_editrice ON libro.ce_id = casa_editrice.ce_id (titolo, autore, categoria, tipologia, n_pagine, quantity, isbn, ce_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmt = $link2->prepare($sql);
                                $stmt->bind_param("ssssiisi", $result[$i][] );

                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}