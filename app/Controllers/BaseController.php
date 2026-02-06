<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
  /**
   * Instance of the main Request object.
   *
   * @var CLIRequest|IncomingRequest
   */
  protected $request;

  /**
   * An array of helpers to be loaded automatically upon
   * class instantiation. These helpers will be available
   * to all other controllers that extend BaseController.
   *
   * @var array
   */
  protected $helpers = [];

  /**
   * Be sure to declare properties for any property fetch you initialized.
   * The creation of dynamic property is deprecated in PHP 8.2.
   */
  /**
   * Instance of the session service.
   *
   * @var \CodeIgniter\Session\Session
   */
  protected $session;


  /**
   * @return void
   */
  public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
  {
    // Do Not Edit This Line
    parent::initController($request, $response, $logger);

    // Preload any models, libraries, etc, here.

    $this->session = \Config\Services::session();
    $tempSecret = $_ENV['JWT_SECRET_TEMP'] ?? 'default_secret';
    if (!session()->get('user_id')) {
      $Key = $this->tempKey(32) . date("ymdhis");
      $token = $this->generateJWT($tempSecret);
      $this->session->set('jwt', $token);
      $this->session->set('user_id', $Key);
      $this->session->set('loginStatus', "NO");
      $this->session->set('otp_verify', "NO");
    }

  }

  private function generateJWT($secret)
  {

    $issuedAt = time();
    $expirationTime = $issuedAt + 3600; // Token valid for 1 hour

    $payload = [
      'iat' => $issuedAt,
      'exp' => $expirationTime,
      'data' => [
        'user_id' => $this->tempKey(32)
      ]
    ];
    return JWT::encode($payload, $secret, 'HS256');
  }

  private function tempKey($value)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $value; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

}
