<?php


class ModelClient 
{

  private $idevent;
  private $titre;
  private $date;



  protected static $table = 'evenment'; 


  public function __construct($idClient = NULL, $titre = NULL, $date = NULL)
  {

    if (!is_null($titre) && !is_null($date)) {

      $this->titre = $titre;
      $this->date = $date;
    }
  }
  public function getIdevent()
  {
    return $this->idclient;
  }
  public function gettitre()
  {
    return $this->titre;
  }
  public function getdate()
  {
    return $this->date;
  }

} 