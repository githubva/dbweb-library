<?php require 'templates/base.php' ?>
<link href="static/css/base.css" rel="stylesheet" type="text/css">
<?php startblock('header');
        echo "<a href='index.php'>Home</a> &raquo; <a href='personal.php'>Personal Page</a> &raquo; Personal Library";
endblock() ?>
<?php startblock('content');
  echo "<div class='main'>";
        echo "<div class='blockHeader'> <h2>Personal Library</h2></div>";
        echo "<div class='blockContent'>";

            echo "<form method='get' action='newDocument.php'>";
                echo "<input type='submit' value='Upload new Document'/>";
            echo "</form><hr/>";

            $query = $con->prepare("select Document.* from Document
                join PaperDoc on (Document.docID=PaperDoc.docID) where PaperDoc.email='{$_SESSION['email']}' union
                select Document.* from Document
                join ElectronicDocCopies on (Document.docID=ElectronicDocCopies.docID) where ElectronicDocCopies.email='{$_SESSION['email']}'");
            $query->execute();
            if($query->rowCount()>0) {
                echo "<table>";
                    echo "<th> Name</th>";
                    echo "<th> Author</th>";
                    echo "<th> Description </th>";
                    echo "<th> ISBN(optional)</th>";
                    $i=0;
                    foreach($query as $document) {
                        $i = $i+1;
                        $i=$i%2;
                        $idvar = 'even';
                        if ($i==0) {
                            $idvar='odd';
                        }
                        echo "<tr id='$idvar' ><td><a href='book.php?book={$document['docID']}'>{$document['document_name']}</a></td>";
                        echo "<td>{$document['author']}</td>";
                        $desc = "<td>".substr($document['description'],0,20);
                        if(strlen($document['description'])>20) {
                            $desc = $desc . "...";
                        }
                        echo $desc ."</td>";
                        echo "<td>{$document['isbn']}</td>";
                        echo "</tr>";
                    }
                echo "</table>";
            } else { //No documents
                echo "There are no documents currently.";
            }
        echo "</div>";
    echo "</div>";

endblock() ?>
