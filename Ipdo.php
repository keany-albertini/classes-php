<?php
  class lpdo
  {
    private $bdd;

    function constructeur($host, $username, $password, $db)
    {
      $bdd = mysqli_connect("$host", "$username", "", "$db");
      $this->bdd = $bdd;
    }

    function connect($host, $username, $password, $db)
    {
      $bdd = $this->bdd;
      if ($bdd) 
      {
        mysqli_close($bdd);
        $bdd = mysqli_connect("$host", "$username", "", "$db");
        $this->bdd = $bdd;
      }
    }

    function destructeur()
    {
      mysqli_close($this->bdd);
    }

    function close()
    {
      mysqli_close($this->bdd);
    }

    function execute($query)
    {
      $bdd = $this->bdd;
      $select = mysqli_query($bdd,"$query");
      while ($result = mysqli_fetch_assoc($select)) 
      {
        return var_dump($result);
      }
    }

    function getLastQuery()
    {

    }

    function getLastResult()
    {

    }

    function getTables()
    {

    }

    function getFields($table)
    {
      
    }


  }

 ?>