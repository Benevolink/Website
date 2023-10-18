<?php

try {
  $db = new PDO('sqlite:database.sqlite');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $res = $db->exec(
    "CREATE TABLE IF NOT EXISTS messages (
      id INTEGER PRIMARY KEY AUTOINCREMENT, 
      title TEXT, 
      message TEXT, 
      time INTEGER
    )"
  );
  
  $stmt = $db->prepare(
    "INSERT INTO messages (title, message, time) 
      VALUES (:title, :message, :time)"
  );
  
  // Bind values directly to statement variables
  $stmt->bindValue(':title', 'message title', SQLITE3_TEXT);
  $stmt->bindValue(':message', 'message body', SQLITE3_TEXT);
  
  // Format unix time to timestamp
  $formatted_time = date('Y-m-d H:i:s');
  $stmt->bindValue(':time', $formatted_time, SQLITE3_TEXT);
   
  // Execute statement
  $stmt->execute();
  
  $messages = $db->query("SELECT * FROM messages");
    
  // Garbage collect db
  $db = null;
} catch (PDOException $ex) {
  echo $ex->getMessage();
}

?>