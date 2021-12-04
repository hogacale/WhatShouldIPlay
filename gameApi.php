<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, , Authorization, X-Requested-With");
include('pdo_connect.php');


/* Define variables and assign default values */
$parameterValues = null; // Set the $parameterValues to null
$type = null;
$error = "Invalid request";
class TableRows extends RecursiveIteratorIterator {
   function __construct($it) {
       parent::__construct($it, self::LEAVES_ONLY);
   }

   function current() {
       return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
   }

   function beginChildren() {
       echo "<tr>";
   }

   function endChildren() {
       echo "</tr>" . "\n";
   }
}

if (isset($_GET['type'])){
   $type = $_GET['type'];
}

// Define response based on the user request (input)
switch ($type) {
  case 'browse':
   //debug_to_console("browse case");
       // Read the request type: game genre
       $genre = (isset($_GET['genre'])) ? $_GET['genre'] : '-1';
       $pageNumber = (isset($_GET['page'])) ? $_GET['page'] : '-1';
       $pageNumber = $pageNumber*25;
       //$rating = (isset($_GET['rating'])) ? $_GET['rating'] : '-1';
       if ($genre === '-1') {
          $response = $error;
       } else {
          if ($genre === 'All'){
              // Display a list of all the movies
              $sql = "SELECT g.name, g.publisherName, r.averageRatings, g.price, g.genreName FROM Game g, Rating r where g.gameId=r.gameId order by name LIMIT 25 OFFSET $pageNumber;";
          }
          else {
              // Display a list of movies based on the user selection
              $sql = "SELECT /*g.gameId,*/ g.name, g.publisherName, r.averageRatings, g.price, g.genreName FROM Game g, Rating r where g.gameId=r.gameId AND genreName like '%$genre%' order by name LIMIT 25 OFFSET $pageNumber;";

             // Define value(s) for 'named' parameters
             $parameterValues = array(':genre' => $genre);

             
         }

         // Execute SQL statement and obtain data
         //$response = getAllRecords($sql, $db, $parameterValues);
         $response = getAllRecords($sql, $db);
        
      }
      //echo json_encode($response);
      break;
   case 'search':
         // Read the request type: game genre

      $search = (isset($_GET['search'])) ? $_GET['search'] : '-1';
      $pageNumber = (isset($_GET['page'])) ? $_GET['page'] : '-1';
      $pageNumber = (int)$pageNumber*25;
      $genre = (isset($_GET['genre'])) ? $_GET['genre'] : '-1';
      $publisher = (isset($_GET['publisher'])) ? $_GET['publisher'] : '-1';
      $rating = (isset($_GET['rating'])) ? $_GET['rating'] : '-1';
      
      if($search === 'null'){
         $search = '';
      }
         
      if($genre === 'null' || $genre === 'All'){
         $genre = '';
      }
         
      if($publisher === 'null' || $publisher === 'All'){
         $publisher = '';
      }
         
      if($rating === 'null' || $rating === 'All'){
         $rating = '0';
      }   
      
         if ($search === '-1' || $pageNumber === '-1' || $genre === '-1' || $publisher === '-1' || $rating === '-1') {
            $response = $error;
         } else {
           //All values
               $sql = "SELECT g.name, g.publisherName, r.averageRatings, g.price, g.genreName, g.gameId FROM Game g, Rating r where g.publisherName like '$publisher%' AND g.gameId=r.gameId AND g.name LIKE '%$search%' AND genreName like '%$genre%' AND r.averageRatings >= $rating order by name LIMIT 25 OFFSET $pageNumber;";
               //echo $sql;
           }
           // Execute SQL statement and obtain data
           $response = getAllRecords($sql, $db);
          //echo implode(" ", $response);
         
        
        break;
        
   case 'gameView':
      $gameId = (isset($_GET['gameId'])) ? $_GET['gameId'] : '-1';
      if ($gameId === '-1') {
            $response = $error;
         } else {
           //All values
               $sql = "SELECT g.name, g.publisherName, r.averageRatings, g.price, g.genreName, g.releaseDate, g.platformName, g.categoryName, g.description, r.totalNegative, r.totalPositive FROM Game g, Rating r where g.gameId=r.gameId and g.gameId=$gameId;";
               //echo $sql;
           }
      $response = getAllRecords($sql, $db);
      
      break;

   default :
      $response = array();
      break;
} // end switch


echo json_encode($response);

function getAllRecords($sql, $db){
   // prepare SQL statement
   $stm = $db->prepare($sql);
   // execute SQL statement
   $stm->execute();
   // fetch all records
   $response = $stm->fetchAll(PDO::FETCH_ASSOC);
return $response;
}



/*
function getAllRecords($sql, $db, $values = null){
   // prepare SQL statement
   $stm = $db->prepare($sql);
   // execute SQL statement
   $stm->execute($values);
   // fetch all records
   $results = $stm->fetchAll(PDO::FETCH_ASSOC);
   // return the result set
   $tmpArr = array();
   foreach ($results as $sub) {
     $tmpArr[] = implode(',', $sub);
   }
   $result = implode('|', $tmpArr);
   echo $result;   
   return $results;
   }
*/
/*
function debug_to_console($data) {
   $output = $data;
   
   echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
*/
?>