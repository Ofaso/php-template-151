<?php

namespace ihrname\Controller;

use Ofaso\SimpleTemplateEngine;
use Ofaso\Service\Homepage\HomepagePdoService;

class IndexController 
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  
  private $homepagePdoService;
  
  private $pdo;
  
  public function __construct(SimpleTemplateEngine $template, HomepagePdoService $homepagePdoService, \PDO $pdo)
  {
     $this->template = $template;
     $this->homepagePdoService = $homepagePdoService;
     $this->pdo = $pdo;
  }

  public function homepage() {
    echo $this->template->render("hello.html.php");
    
    while ($row = $this->pdo->mysqli_fetch_array($this->homepagePdoService->getAllPosts()))
    {
    	echo "<tr>";
    	echo "<td>" . $row["Title"] . "</td>";
    	echo "<td>" . $row["Content"] . "</td>";
    	echo "</tr>";
    }
  }

  public function greet($name) {
  	echo $this->template->render("hello.html.php", ["name" => $name]);
  }
}
