<?php

class Config{

    private $host="localhost";
    private $database="books";
    private $username='root';
    private $password='';
    private $connection;

    public function Dbconncet()
    {
        $this->connection=mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if(isset($this->connection))
        {
            $result=array('status'=>"Database Connected Successfully !");
            // echo json_encode($result);
            
        }
        else{
            $result=array('status'=>"Database Connection Failed !");
            echo json_encode($result);
        }
    }
    public function __construct() {
        $this->Dbconncet();
    }

    public function fetchData()
    {
        $query= "SELECT * FROM `bookcenter`";
        $result=mysqli_query($this->connection,$query);
        
        if($result)
        {
            $listrespose=[];
            while( $data = mysqli_fetch_assoc($result))
            {
               
                array_push($listrespose, $data);
            }
        }else{
            $listrespose["error"] = "Data Not Found";
        }
        
        return $listrespose;
    
    }

public function insertBook($title, $author, $publishyear, $price, $quantity, $general)
{
    $query = "INSERT INTO `bookcenter`(`title`, `author`, `publishyear`, `price`, `quantity`, `general`) 
              VALUES ('$title', '$author', '$publishyear', '$price', '$quantity', '$general')";
    $result = mysqli_query($this->connection, $query);
    return $result;
}

public function deleteBook($id)
{
    $query = "DELETE FROM `bookcenter` WHERE id='$id'";
    $result = mysqli_query($this->connection, $query);
    return $result;
}

public function updateBook($id, $title, $author, $publishyear, $price, $quantity, $general)
{
    $query = "UPDATE `bookcenter` 
              SET title='$title', author='$author', publishyear='$publishyear', 
                  price='$price', quantity='$quantity', general='$general' 
              WHERE id='$id'";
    $result = mysqli_query($this->connection, $query);
    return $result;
}

}
?>
