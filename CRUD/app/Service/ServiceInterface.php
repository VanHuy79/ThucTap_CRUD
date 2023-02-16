<?php

namespace App\Service;
// Khai báo 1 interface định nghĩa các phương thức
interface ServiceInterface
{
   public function all();
   public function find($id);
   public function create(array $data);
   public function update(array $data, $id);
   public function delete($id);
}
