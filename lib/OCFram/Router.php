<?php
namespace OCFram;

class Router
{
  /** @var Route[] $routes */
  protected $routes = [];
 
  const NO_ROUTE = 1;
 
  public function addRoute(Route $route)
  {
    if (!in_array($route, $this->routes))
    {
      $module=$route->module();
      $action=$route->action();
      $key=$module.','.$action;
      $this->routes[$key] = $route;
      //[$route->module(),$route->action()] =>
      //array_push($this->routes[],[$route->module(),$route->action()=>$route]);
    }
  }
 
  public function getRoute($url)
  {
    foreach ($this->routes as $route)
    {
      // Si la route correspond à l'URL
      if (($varsValues = $route->match($url)) !== false)
      {
        // Si elle a des variables
        if ($route->hasVars())
        {
          $varsNames = $route->varsNames();
          $listVars = [];
 
          // On crée un nouveau tableau clé/valeur
          // (clé = nom de la variable, valeur = sa valeur)
          foreach ($varsValues as $key => $match)
          {
            // La première valeur contient entièrement la chaine capturée (voir la doc sur preg_match)
            if ($key !== 0)
            {
              $listVars[$varsNames[$key - 1]] = $match;
            }
          }
 
          // On assigne ce tableau de variables � la route
          $route->setVars($listVars);
        }
        return $route;
      }
    }
 
    throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
  }

  /**
   * @param $module
   * @param $action
   * @param array $vars
   * @return string url de destination correspondant à $action du $mordule avec les $vars.
   */
  public function getBuiltRoute($module, $action, array $vars){

    $route = $this->routes[$module.','.$action];

    if($route->hasVars()){
    //ajouter les variables
      $routebuilt=$route->url(); //initialisation


      $varsName = $route->varsNames();
       // Pour chaque Nom d'attribut, on recherche par la clé associé la bonne variable.
       foreach($varsName as $Name){
         if(isset($vars[$Name])){
           $routebuilt = preg_replace('/\(.*\)/', $vars[$Name], $routebuilt,1);
         }
         else{
           throw new \RuntimeException('Il n\'y a pas de correspondance de clé');
         }
      }

      /*
       *foreach($vars as $var){//key de route
        $routebuilt = preg_replace('/\(.*\)/', $var, $routebuilt,1);
      }//pour chaque parenthèse, on insère la variable associé (l'ordre est donc important)
      */

      return $routebuilt;


    }else{
      return $route->url();
    }

    throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
  }

  // on appelle cette fonction ici parce qu'on a eu la flemme de réecrire getbuiltRoute alors que l'on sait que la nomenclature est pourri
  public function BuildRoute($module, $action, array $vars){
  return self::getBuiltRoute($module, $action,$vars);
  }

}