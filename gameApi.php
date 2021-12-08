<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, , Authorization, X-Requested-With");
include('pdo_connect.php');


/* Define variables and assign default values */
$parameterValues = null; // Set the $parameterValues to null
$type = null;
$error = "Invalid request";


if (isset($_GET['type'])){
   $type = $_GET['type'];
}

// Define response based on the user request (input)
switch ($type) {
  case 'browse':
   $random = (isset($_GET['random'])) ? $_GET['random'] : '-1';
   $userId = (isset($_GET['userId'])) ? $_GET['userId'] : '-1';
   //debug_to_console("browse case");
   
       // Read the request type: game genre
       $sql = "SELECT g.name, g.publisherName, r.averageRatings, g.price, g.genreName, g.gameId FROM Game g, Rating r, User u where g.gameId=r.gameId and g.requiredAge <= $userId and g.requiredAge <= u.age and u.userId=$userId order by Rand($random) LIMIT 25;";

         // Execute SQL statement and obtain data
         //$response = getAllRecords($sql, $db, $parameterValues);
         $response = getAllRecords($sql, $db);
        
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
      $userId = (isset($_GET['userId'])) ? $_GET['userId'] : '-1';
      
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
               $sql = "SELECT g.name, g.publisherName, r.averageRatings, g.price, g.genreName, g.gameId FROM Game g, Rating r, User u where g.publisherName like '$publisher%' AND g.gameId=r.gameId AND g.name LIKE '%$search%' AND genreName like '%$genre%' AND r.averageRatings >= $rating and g.requiredAge <= u.age and u.userId=$userId order by name LIMIT 25 OFFSET $pageNumber;";
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
      
   case 'AddtoCart':
      $gameId = $gameId = (isset($_GET['gameId'])) ? $_GET['gameId'] : '-1';
      $userId = $userId = (isset($_GET['userId'])) ? $_GET['userId'] : '-1';
      
      $scId = getCountRecords("select scId from ShoppingCart order by scId DESC limit 1;", $db);
      $scId = $scId[0][0] + 1;
      if ($gameId === '-1') {
            $response = $error;
         } else {
           //All values
               $sql = "INSERT INTO ShoppingCart VALUES ($userId, null ,$gameId,$scId);";
               //echo $sql;
           }
      echo "success!";
      $response = getAllRecords($sql, $db);
   break;
   
   case 'viewCart':
         $userId = (isset($_GET['userId'])) ? $_GET['userId'] : '-1';
         if ($userId === '-1') {
               $response = $error;
            } else {
            
               $sql = "SELECT g.gameId, g.name, g.publisherName, r.averageRatings, g.price, c.scId FROM Game g, Rating r, User u, ShoppingCart c WHERE u.userId=c.userId and g.gameId=c.gameId and c.userId=$userId and r.gameId=g.gameId ORDER BY g.name LIMIT 25;";
               //echo $sql;


              }
         $response = getAllRecords($sql, $db);
      break;
      
   case 'removeFromCart':
      $scId = (isset($_GET['scId'])) ? $_GET['scId'] : '-1';
      if ($userId === '-1') {
               $response = $error;
            } else {
            
               $sql = "Delete from ShoppingCart where scId=$scId;";
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

function getCountRecords($sql, $db){
   // prepare SQL statement
   $stm = $db->prepare($sql);
   // execute SQL statement
   $stm->execute();
   // fetch all records
   $response = $stm->fetchAll(PDO::FETCH_BOTH);
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