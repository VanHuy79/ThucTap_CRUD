<?php

namespace App\Repositories;
// Phần này khai báo các hàm chung
interface RepositoriesInterface
{
   public function all();
   public function find($id);
   public function create(array $data);
   public function update($data = [], $id);
   public function delete($id);
}
