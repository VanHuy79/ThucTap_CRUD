<?php

namespace App\Service;
// Triển khai các phương thức bên Service

class BaseService implements ServiceInterface
{
   // Tạo ra đối tượng repo
   public $repository;

   public function all()
   {
      // gọi đến các phương thức tương ứng
      return $this->repository->all();
   }

   public function find($id)
   {
      return $this->repository->find($id);
   }

   public function create(array $data)
   {
      return $this->repository->create($data);
   }

   public function update(array $data, $id)
   {
      return $this->repository->update($data, $id);
   }

   public function delete($id)
   {
      return $this->repository->delete($id);
   }
}
