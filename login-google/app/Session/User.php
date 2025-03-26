<?php

namespace App\Session;

class User{

    /**
     * Metodo responsavel por iniciar a sessão dentro da aplicação
     * @return boolean
     */
    private static function init(){
return session_status() !== PHP_SESSION_ACTIVE ? session_start() : true;
    }
    
    /**
     * Metodo responsavel por definir a sessão de login
     * @param string $name
     * @param string $email
     */
    public static function login($name,$email){
        //Inicia a sessão da aplicação
        self::init();
        
        //Define a sessão do usuario
      $_SESSION['user'] = [
        'name' => $name,
        'email' => $email,
        'descricao' => d
      ];
    }
    
    /**
     * Metodo responsavel por verificar se o usuario está logado
     * @return boolean
     */
    public static function isLogged(){
      //Inicia a sessão da aplicação
      self::init();

      //Retorna a existencia do indice user na sessão
      return isset($_SESSION['user']);
    }
   
    /**
     * Metodo responsavel por retornar as informações guardadas na sessão do usuario
     * @return array
     */
    public static function getInfo(){
      //Inicia a sessão da aplicação
      self::init();

      //Retorna os dados da sessão
      return $_SESSION['user'] ?? [];
    }

    /**
     * Metodo responsavel por deslogar o usuario
     */
    public static function logout(){
      //inicia a sessão da aplicação
      self::init();

      //remove a sessão do usuario
      unset($_SESSION['user']);
    }
    public static function getdescription(){
      self::init();

      unset($_SESSION['descricao'])
    }
}